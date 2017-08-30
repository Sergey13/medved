<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Tool;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
    
    /**
     * Show edit form for tool
     * 
     * @param Request $request
     */
    public function getEdit(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $tool = Tool::find($id);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.tooledit', [
                'tool' => $tool,
            ]);
        } 
        
        return view('adminpanel.tooledit', [
            'tool' => $tool,
        ]);
    }
    
    /**
     * Update tool
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('tool');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $tool = Tool::find($id);
        
        $tool->name = $data['name'];
        $tool->count = $data['count'];
        $tool->balance_notification = $data['balance_notification'];
        
        $tool->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/stock/tools', 
            'message' => 'Изменения успешно сохранены.'
            ]);
    }
    
    public function delete($id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $tool = Tool::find($id);
        
        $tool->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/stock/tools', 
            'message' => 'Запись успешно удалена.'
        ]);
    }
    
    /**
     * Validate fields of tool
     * 
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data) {
        
        return Validator::make($data, [
            'name' => 'required',
            'count' => 'required|numeric|integer',
            'balance_notification' => 'required|numeric'
        ]);
    }
}
