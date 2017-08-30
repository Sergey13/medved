<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DateTimeInterface;
use Auth;
use App\Equipment;
use App\Place;
use App\Component;
use App\Performer;
use App\Schedule;
use App\TypeOfRepair;
use App\AccountingRepair;
use App\Helpers\DateFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    
    public function __construct() {
        
        $this->middleware('role:admin|director');
        
    }
    
    public function getEquipment(Request $request, $id) {
        
        $equipment = Equipment::find($id);
        
        if(!isset($equipment)) {
            
            abort(404);
        }
        
        $record = AccountingRepair::with('performer', 'type_of_repair')
                ->where('equipment_id', '=', $id)
                ->get();
        
        foreach($record as $key => $item) {
            
            $record[$key]->date_format = DateFormat::formatDate($item->date);
        }
        
        if($request->input('ajax') == 'json') {
            
            $record->load('equipment');
            
            return response()->json($record->toArray());
        }
        
        if($request->ajax()) {
            
            return view('adminpanel.ajax.record_equipment', [
                'record' => $record,
                'equipment' => $equipment
            ]);
        } 
        
        return view('adminpanel.record_equipment', [
            'record' => $record,
            'equipment' => $equipment
        ]);
        
    }
    
    public function getComponent(Request $request, $id) {
        
        $component = Component::find($id);
        
        if(!isset($component)) {
            
            abort(404);
        }
        
        $record = AccountingRepair::with('performer', 'type_of_repair')
                ->where('component_id', '=', $id)
                ->orderBy('date')
                ->get();
        
        foreach($record as $key => $item) {
            
            $record[$key]->date_format = DateFormat::formatDate($item->date);
        }
        
        if($request->input('ajax') == 'json') {
            
            $record->load('component');
            
            return response()->json($record->toArray());
        }
        
        if($request->ajax()) {
            
            return view('adminpanel.ajax.record_component', [
                'record' => $record,
                'component' => $component
            ]);
            
        } 
        
        return view('adminpanel.record_component', [
            'record' => $record,
            'component' => $component
        ]);
        
    }
    
    /**
     * Show create form for record components
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function getCreateComponent(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $component = Component::find($id);
        
        $performers = Performer::all()->toArray();
        
        $ids = array_column($performers, 'id');
        
        $names = array_column($performers, 'fio');
        
        $performers = array_combine($ids, $names);
        
        $types_of_repair = TypeOfRepair::all()->toArray();
        
        $ids = array_column($types_of_repair, 'id');
        
        array_push($ids, null);
        
        $names = array_column($types_of_repair, 'type');
        
        array_push($names, 'Тип ремонта');
        
        $types_of_repair = array_combine($ids, $names);
        
        if(!isset($component)) {
            
            abort(404);
        }
        
        if($request->ajax()) {
            
            return view('adminpanel.ajax.record_component_create', [
                'component' => $component,
                'performers' => $performers,
                'types_of_repair' => $types_of_repair
            ]);
            
        } 
        
        return view('adminpanel.record_component_create', [
            'component' => $component,
            'performers' => $performers,
            'types_of_repair' => $types_of_repair
        ]);
        
    }
    
    
    
    /**
     * Save record components
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function postSaveComponent(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('record_component');
        
        $data['date'] = DateFormat::change_date_for_db($data['date']);
        
        $v = $this->validatorComponent($data);
        
        if($v->fails()) {
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $component = Component::find($id);
        
        if(!isset($component)) {
            
            abort(404);
        }
        
        foreach ($data['performer'] as $performer) {

            $record = new AccountingRepair;

            $record->date = $data['date'];
            $record->performer_id = $performer;
            $record->component_id = $id;
            $record->type_of_repair_id = $data['type_of_repair'];
            $record->comment = $data['comment'];

            $record->save();
        }
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/record/component/'.$id, 
            'message' => 'Запись успешно добавлено.'
            ]);
        
    }
    
    /**
     * Delete record component
     * 
     * @param type $id
     * @return \Illuminate\Http\Response
     */
    public function deleteComponent($comp_id, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $record = AccountingRepair::find($id);
        
        $record->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/record/component/'.$comp_id, 
            'message' => 'Запись успешно удалена.'
        ]);
        
    }
    
    
    /**
     * Show create form for record components
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function getCreateEquipment(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $equipment = Equipment::find($id);
        
        $performers = Performer::all()->toArray();
        
        $ids = array_column($performers, 'id');
        
        $names = array_column($performers, 'fio');
        
        $performers = array_combine($ids, $names);
        
        $types_of_repair = TypeOfRepair::all()->toArray();
        
        $ids = array_column($types_of_repair, 'id');
        
        array_push($ids, null);
        
        $names = array_column($types_of_repair, 'type');
        
        array_push($names, 'Тип ремонта');
        
        $types_of_repair = array_combine($ids, $names);
        
        if(!isset($equipment)) {
            
            abort(404);
        }
        
        $schedule = Schedule::where('equipment_id', '=', $id)
                ->where('performed', '=', 0)
                ->whereNotNull('type_of_repair_id')
                ->orderBy('date')
                ->get();
        
        foreach($schedule as $key => $item) {
            $schedule[$key]->date_format = DateFormat::formatDate($item->date, 'with_month');
        }
        
        if($request->ajax()) {
            
            return view('adminpanel.ajax.record_equipment_create', [
                'equipment' => $equipment,
                'performers' => $performers,
                'types_of_repair' => $types_of_repair,
                'schedule' => $schedule
            ]);
            
        } 
        
        return view('adminpanel.record_equipment_create', [
            'equipment' => $equipment,
            'performers' => $performers,
            'types_of_repair' => $types_of_repair,
            'schedule' => $schedule
        ]);
        
    }
    
    /**
     * Save record equipment
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function postSaveEquipment(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('record_equipment');
        
        $data['date'] = DateFormat::change_date_for_db($data['date']);
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $equipment = Equipment::find($id);
        
        if(!isset($equipment)) {
            
            abort(404);
        }
        foreach ($data['performer'] as $performer) {
            $record = new AccountingRepair;

            $record->date = $data['date'];
            $record->performer_id = $performer;
            $record->equipment_id = $id;
            $record->type_of_repair_id = $data['type_of_repair'];
            $record->comment = $data['comment'];

            if ($data['schedule_id'] != '') {
                $record->schedule_id = $data['schedule_id'];


                $schedule = Schedule::find($data['schedule_id']);

                $schedule->performed = 1;

                $schedule->read = 1;

                $schedule->save();
            }

            $record->save();
        }
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/record/equipment/'.$id, 
            'message' => 'Запись успешно добавлено.'
            ]);
        
    }
    
    /**
     * Delete record equipment
     * 
     * @param type $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEquipment($eq_id, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $record = AccountingRepair::find($id);
        
        $record->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/record/equipment/'.$eq_id, 
            'message' => 'Запись успешно удалена.'
        ]);
        
    }
    
    
    
    /**
     * Validate fields of record
     * 
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data) {
        
        return Validator::make($data, [
            'date' => 'required|date_format:Y-m-d',
            'type_of_repair' => 'required',
            'performer' => 'required',
            'schedule' => array('required', 'regex:[^(planned|unplanned)]'),
            'schedule_id' => 'required_if:schedule,planned'
        ]);
        
    }


    /**
     * Validate fields of record
     *
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validatorComponent(array $data) {

        return Validator::make($data, [
            'date' => 'required|date_format:Y-m-d',
            'type_of_repair' => 'required',
            'performer' => 'required',
        ]);

    }
}
