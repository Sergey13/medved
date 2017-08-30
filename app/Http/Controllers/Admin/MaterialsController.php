<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Store;
use App\Material;
use App\Http\Controllers\Controller;

class MaterialsController extends Controller
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
        
        $material = Material::find($id);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.materialedit', [
                'material' => $material,
                'units' => Store::getUnits()
            ]);
        } 
        
        return view('adminpanel.materialedit', [
            'material' => $material,
            'units' => Store::getUnits()
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
        
        $data = $request->input('material');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $material = Material::find($id);
        
        $material->name = $data['name'];
        $material->count = $data['count'];
        $material->unit = $data['unit'];
        $material->balance_notification = $data['balance_notification'];
        
        $material->save();

        Store::where('material_id', $id)
            ->update(['unit' => $data['unit']]);
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/stock/materials', 
            'message' => 'Изменения успешно сохранены.'
            ]);
    }
    
    public function delete($id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $material = Material::find($id);
        
        $material->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/stock/materials', 
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
            'count' => 'required|numeric',
            'balance_notification' => 'required|numeric'
        ]);
    }
}
