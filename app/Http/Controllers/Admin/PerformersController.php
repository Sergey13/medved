<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DateTimeInterface;
use Auth;
use App\Performer;
use App\Helpers\DateFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PerformersController extends Controller
{
    /**
     * Get list performers
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function getIndex(Request $request) {
         
        $performers = Performer::orderBy('fio')->get();
        
        foreach ($performers as $performer) {
            $performer->employment = DateFormat::formatDate($performer->date_of_employment);
        }
        
        if($request->input('ajax') == 'json') {
            
            return response()->json($performers->toArray());
        }

        
        if($request->ajax()) {
            return view('adminpanel.ajax.performers', [
                'performers' => $performers
            ]);
        } 
        
        return view('adminpanel.performers', [
                'performers' => $performers
            ]);
    }
    
    /**
     * Show create form for performer
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request) {
        
        if(!Auth::user()->can('add-performer')) {
            
            abort(403);
            return;
            
        }
        
        if($request->ajax()) {
            return view('adminpanel.ajax.performercreate');
        } 
        
        return view('adminpanel.performercreate');
        
    }
    
    /**
     * Save new performer
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request) {
        
        if(!Auth::user()->can('add-performer')) {
            
            abort(403);
            return;
            
        }
        
        $data = $request->input('performer');
        
        $data['date_of_employment'] = DateFormat::change_date_for_db($data['date_of_employment']);
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $performer = new Performer;
        
        $performer->fio = $data['fio'];
        $performer->phone = $data['phone'];
        $performer->date_of_employment = $data['date_of_employment'];
        
        $performer->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/performers', 
            'message' => 'Исполнитель успешно добавлен в систему.'
            ]);
    }
    
    
    /**
     * Show edit form for performer
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id) {
        
        if(!Auth::user()->can('edit-performer')) {
            
            abort(403);
            return;
            
        }
        
        $performer = Performer::find($id);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.performeredit', [
                'performer' => $performer
            ]);
        } 
        
        return view('adminpanel.performeredit', [
            'performer' => $performer
        ]);
        
    }
    
    /**
     * Update performer
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id) {
        
        if(!Auth::user()->can('edit-performer')) {
            
            abort(403);
            return;
            
        }
        
        $data = $request->input('performer');
        
        $data['date_of_employment'] = DateFormat::change_date_for_db($data['date_of_employment']);
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $performer = Performer::find($id);
        
        $performer->fio = $data['fio'];
        $performer->phone = $data['phone'];
        $performer->date_of_employment = $data['date_of_employment'];
        
        $performer->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/performers', 
            'message' => 'Изменения успешно сохранены.'
        ]);
    }
    
    /**
     * Delete performer
     * 
     * @param type $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        
        if(!Auth::user()->can('delete-performer')) {
            
            abort(403);
            return;
            
        }
        
        $performer = Performer::find($id);
        
        $performer->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/performers', 
            'message' => 'Исполнитель успешно удален.'
        ]);
        
    }
    
    /**
     * Validate fields of performer
     * 
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data) {
        
        return Validator::make($data, [
            'fio' => 'required',
            'phone' => 'required',
            'date_of_employment' => 'required|date',
        ]);
    }
}
