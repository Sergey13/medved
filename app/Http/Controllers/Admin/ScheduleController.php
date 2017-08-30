<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DateTimeInterface;
use Auth;
use DB;
use App\Equipment;
use App\Schedule;
use App\TypeOfRepair;
use App\Helpers\DateFormat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    
    public function __construct() {
        
        $this->middleware('role:admin|director');
        
    }
    
    /**
     * Show current schedule
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function getIndex(Request $request) {
        
        $year = $request->input('year');
        
        $years = Schedule::getYears();
        
        $years_array = $years->toArray();
        
        if(!isset($year) || !in_array($year, $years_array)) {
            $year = date('Y');
        }
        
        
        
        $equipments = Equipment::with([
                    'Schedule' => function(\Illuminate\Database\Eloquent\Relations\HasMany $query) use ($year) {
                        $query->with('type_of_repair')->where('date', 'like', $year . '%');
                    }
                ])->get();

        foreach ($equipments as $key1 => $equipment) {
            if(isset($equipment->Schedule)) {
                foreach ($equipment->Schedule as $key2 => $schedule) {
                    $equipments[$key1]->Schedule[$key2]->month = substr($schedule->date, 5, 2);
                }
                $schedule = $equipment->Schedule->toArray();
                $monthes = array_column($schedule, 'type_of_repair', 'month');
                $performed = array_column($schedule, 'performed', 'month');
                foreach($monthes as $month => $value) {
                    $monthes[$month]['performed'] = $performed[$month]; 
                }
                $equipments[$key1]->schedule = $monthes;
            }
        }
        
        if ($request->ajax()) {
            
            return view('adminpanel.ajax.schedule', [
                'equipments' => $equipments,
                'years' => $years,
                'current_year' => $year
            ]);
            
        }

        return view('adminpanel.schedule', [
            'equipments' => $equipments,
            'years' => $years,
            'current_year' => $year
        ]);
    }
    
    /**
     * Show edit form for schedule
     * 
     * @param Request $request
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
              
            abort(403);
            
            return;
        }
        
        $year = $request->input('year');
        
        if(!isset($year)) {
            $year = date('Y');
        }
        
        $types_of_repair = TypeOfRepair::all()->toArray();
        
        $ids = array_column($types_of_repair, 'id');
        
        array_push($ids, null);
        
        $names = array_column($types_of_repair, 'type');
        
        array_push($names, '___');
        
        $types_of_repair = array_combine($ids, $names);
        
        $equipment = Equipment::with([
                    'Schedule' => function(\Illuminate\Database\Eloquent\Relations\HasMany $query) use ($year) {
                        $query->with('type_of_repair')->where('date', 'like', $year . '%');
                    }
                ])->where('id', '=', $id)->first();

        if (isset($equipment->Schedule)) {
            foreach ($equipment->Schedule as $key2 => $schedule) {
                $equipment->Schedule[$key2]->month = substr($schedule->date, 5, 2);
                $equipment->Schedule[$key2]->day = (int)substr($schedule->date, 8, 2);
            }
            $schedule = $equipment->Schedule->toArray();
            $monthes = array_column($schedule, 'type_of_repair', 'month');
            $days = array_column($schedule, 'day', 'month');
            
            for($i = 1; $i <= 12; $i++) {
                if($i < 10) {
                    $month = '0'.$i;
                } else {
                    $month = (string) $i;
                }
                if(!isset($days[$month])) {
                    $days[$month] = '';
                }
            }
            
            $equipment->schedule = $monthes;
            $equipment->days = $days;
        } else {
            $equipment->Schedule = [];
        }

        if ($request->ajax()) {
            
            return view('adminpanel.ajax.scheduleedit', [
                'equipment' => $equipment,
                'current_year' => $year,
                'types_of_repair' => $types_of_repair
            ]);
            
        }

        return view('adminpanel.scheduleedit', [
            'equipment' => $equipment,
            'current_year' => $year,
            'types_of_repair' => $types_of_repair
        ]);
    }
    
    
     /**
     * Save schedule
     * 
     * @param Request $request
       @param integer $id
     * @return Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
              
            abort(403);
            
            return;
        }
        
        $year = $request->input('year');
        
        if(!isset($year)) {
            
            $year = date('Y');
        }
        
        $schedule = $request->input('schedule');
        
        $v = $this->validator($schedule);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $dates = array_keys($schedule['date']);
        
        $isset_schedule = Schedule::where('equipment_id', '=', $id)
                        ->where('date', 'like', $schedule['year'].'%')->get();
        
        if(count($isset_schedule) != 0) {
            
            foreach ($schedule['date'] as $key => $type) {
                
                $model_key = $isset_schedule->search(function($item) use ($schedule, $key){
                    
                    $pos = strripos($item->date, $schedule['year'].'-'.$key);
                    
                    if($pos !== false) {
                        return $item;
                    }
                });
                
                if($model_key !== false) {
                    
                    if($type == '') {
                        
                        $type = NULL;
                        
                    }
                    
                    $model = $isset_schedule[$model_key];
                    
                    $model->type_of_repair_id = $type;
                    
                    if ($schedule['day'][$key] == '') {

                        $model->delete();
                        
                    } else {

                        $model->date = $schedule['year'] . '-' . $key . '-' . $schedule['day'][$key];

                        $model->save();
                    }

                    unset($schedule['date'][$key]);
                }
            }
        }
        
        if(count($schedule) != 0) {
            
            $new_results = array();
            
            foreach ($schedule['date'] as $key => $type) {
                
                if($type != '') {
                
                    $data = [
                        'date' => $schedule['year'].'-'.$key.'-'.$schedule['day'][$key],
                        'equipment_id' => $id,
                        'type_of_repair_id' => $type
                    ];

                    array_push($new_results, $data);
                
                }
            }
            
            $result = Schedule::saveModels($new_results);
        
        }

        return  response()->json([
            'status' => 'ok', 
            'url' => '/schedule/equipment/'.$id.'?year='.$year, 
            'message' => 'График успешно изменен.'
            ]);
    }
    
    
    public function getEquipment(Request $request, $id) {
        
        $equipment = Equipment::find($id);
        
        $schedule = Schedule::with('type_of_repair')
                ->where('equipment_id', '=', $id)
                ->orderBy('date')
                ->get();
        
        foreach ($schedule as $key => $model) {
            
            $schedule[$key]->year = substr($model->date, 0, 4);
            $schedule[$key]->month = substr($model->date, 5, 2);
            
        }
        
        $schedule = $schedule->groupBy('year');
        
        foreach($schedule as $year => $items) {
            
            $schedule[$year] = $items->keyBy('month');
            
        }
        
        if($request->ajax()) {
            return view('adminpanel.ajax.schedule_equipment', [
                'schedule' => $schedule,
                'equipment' => $equipment,
            ]);
        } 
        
        return view('adminpanel.schedule_equipment', [
                'schedule' => $schedule,
                'equipment' => $equipment,
            ]);
    }
    
    /**
     * Show create form for schedule
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function getCreate(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
              
            abort(403);
            
            return;
        }
        
        $equipment = Equipment::find($id);
        
        $types_of_repair = TypeOfRepair::all()->toArray();
        
        $ids = array_column($types_of_repair, 'id');
        
        array_push($ids, null);
        
        $names = array_column($types_of_repair, 'type');
        
        array_push($names, '___');
        
        $types_of_repair = array_combine($ids, $names);
        
        if ($request->ajax()) {
            
            return view('adminpanel.ajax.schedulecreate', [
                'equipment' => $equipment,
                'types_of_repair' => $types_of_repair
            ]);
            
        }

        return view('adminpanel.schedulecreate', [
            'equipment' => $equipment,
            'types_of_repair' => $types_of_repair
        ]);
    }
    
    public function postSave(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
              
            abort(403);
            
            return;
        }
        
        $data = $request->input('schedule');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $new_results = array();
        
        $year = $data['year'];
        
        $years = Schedule::getYears();
        
        $years = $years->toArray();
        
        if(in_array($year, $years)) {
            
            return response()->json([
                        'status' => 'ok',
                        'url' => '/schedule/equipment/' . $id . '/edit?year=' . $year,
                        'message' => 'Введенный год уже существует. Вы можете изменить имеющийся график.'
            ]);
        }

        foreach ($data['date'] as $key => $type) {

            if ($type != '') {
                
                if((int) $data['day'][$key] < 10) {
                    $day = '0'.$data['day'][$key];
                } else {
                    $day = $data['day'][$key];
                }
                
                $data_result = [
                    'date' => $year . '-' . $key . '-' . $day,
                    'equipment_id' => $id,
                    'type_of_repair_id' => $type
                ];

                array_push($new_results, $data_result);
            }
        }
        
        if(count($new_results) != 0) {
        
            $result = Schedule::saveModels($new_results);
            
            $message = 'График успешно добавлен.';
            
            $url = '/schedule?year='.$year;
        
        } else {
            
            $message = 'Должен быть заполнен хотя бы один месяц.';
             
            $url = '/schedule/equipment/'. $id . '/create';
        }

        return response()->json([
                    'status' => 'ok',
                    'url' => $url,
                    'message' => $message,
        ]);
    }
    
    public function deleteSchedule(Request $request, $id, $year) {
        
        if(!Auth::user()->can('edit')) {
              
            abort(403);
            
            return;
        }
        
        $deletedRows = Schedule::where('equipment_id', $id)
                ->where('date', 'like', $year.'%')
                ->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/schedule/equipment/'.$id, 
            'message' => 'Запись успешно удалена.'
        ]);
        
    }
    
    /**
     * Get all notifications for schedule
     * 
     * @param Request $request
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getNotifications(Request $request) {
        
        $end_date = date("Y-m-d", strtotime("+5 day", strtotime(date('Y-m-d'))));
        
        $schedule = Schedule::with('equipment', 'type_of_repair')
                ->where('read', '=', 0)
                ->where('performed', '=', 0)
                ->where('date', '<=', $end_date)
                ->get();
        
        foreach($schedule as $key => $item) {
            $schedule[$key]->date_format = DateFormat::formatDate($item->date);
        }
        
        if ($request->ajax()) {
            return view('adminpanel.ajax.notifications', [
                'notifications' => $schedule
            ]);
        } else {
            return redirect('/schedule');
        }
    }
    
    protected function putNotificationsUpdate(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
              
            abort(403);
            
            return;
        }
        
        $data = $request->input('notification');
        
        $v = Validator::make($data, [
            'read' => 'required',
        ]);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $schedule = Schedule::find($id);
        
        $schedule->read = $data['read'];
        
        $schedule->save();
        
        
        return response()->json([
            'status' => 'ok', 
            'url' => 'none',
            'message' => 'Напоминание закрыто.'
        ]);
    }


    /**
     * Validate fields of schedule
     * 
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data) {
        
        $min_year = (int) date('Y');
        
        $rules['year'] = 'required|date_format:Y';
        
        foreach($data['day'] as $key => $day) {
            $rules['day.'.$key] = 'required_with:date.'.$key.'|date_format:j';
        }
        
        return Validator::make($data, $rules);
    }
}
