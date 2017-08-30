<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DateTimeInterface;
use Auth;
use App\Equipment;
use App\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ComponentsController extends Controller
{
    
    public function __construct() {
        
        $this->middleware('role:admin|director');
        
    }
    

    public function getIndex(Request $request) {
        
        $components = Component::with('child')
                ->whereNull('parent_id')
                ->orderBy('created_at', 'DESC')->get();
        
        if($request->input('ajax') == 'json') {
            
            return response()->json($components->toArray());
        }
        
        if($request->ajax()) {
            return view('adminpanel.ajax.allcomponents', [
                'components' => $components
            ]);
        } 
        
        return view('adminpanel.allcomponents', [
            'components' => $components
        ]);
    }
    
    public function getInside(Request $request, $id) {
        
        $components = Component::with('child')->where('parent_id', '=', $id)
                ->orderBy('created_at', 'DESC')->get();
        
        $parent_component = Component::find($id);
        
        if($request->input('ajax') == 'json') {
            
            return response()->json($components->toArray());
        }
        
        if($request->ajax()) {
            return view('adminpanel.ajax.allcomponents', [
                'components' => $components,
                'parent_component' => $parent_component
            ]);
        } 
        
        return view('adminpanel.allcomponents', [
            'components' => $components,
            'parent_component' => $parent_component
        ]);
    }
    
    /**
     * Show create form for component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $equipments = Equipment::all()->toArray();
        
        $ids = array_column($equipments, 'id');
        
        array_push($ids, '');
        
        $names = array_column($equipments, 'name');
        
        array_push($names, 'Выберите место установки');
        
        $result = array_combine($ids, $names);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.componentcreate', [
                'equipments' => $result
            ]);
        } 
        
        return view('adminpanel.componentcreate', [
            'equipments' => $result
        ]);
        
    }
    
    
    /**
     * Show create form for inside component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInsideCreate(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $component = Component::find($id);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.componentinsidecreate', [
                'component' => $component
            ]);
        } 
        
        return view('adminpanel.componentinsidecreate', [
            'component' => $component
        ]);
        
    }
    
    
    /**
     * Save new component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('component');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $component = new Component;
        
        $component->equipment_id = $data['equipment'];
        $component->name = $data['name'];
        $component->number = $data['number'];
        $component->count = $data['count'];
        $component->count_in = $data['count_in'];
        
        $component->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/components', 
            'message' => 'Комплектующее успешно добавлено.'
            ]);
    }
    
    /**
     * Save new inside component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postInsideSave(Request $request, $id) {
        
        if(!Auth::user()->can('add')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('component');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        $component = new Component;
        
        $component->equipment_id = $data['equipment'];
        $component->name = $data['name'];
        $component->number = $data['number'];
        $component->count = $data['count'];
        $component->parent_id = $data['parent_id'];
        $component->count_in = $data['count_in'];
        
        $component->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/components/'.$id.'/inside', 
            'message' => 'Комплектующее успешно добавлено.'
            ]);
    }
    
    /**
     * Show edit form for component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $equipments = Equipment::all()->toArray();
        
        $ids = array_column($equipments, 'id');
        
        array_push($ids, '');
        
        $names = array_column($equipments, 'name');
        
        array_push($names, 'Выберите место установки');
        
        $result = array_combine($ids, $names);
        
        $component = Component::find($id);
        
        $components = Component::all()->toArray();
        
        $ids = array_column($components, 'id');
        
        array_push($ids, null);
        
        $names = array_column($components, 'name');
        
        array_push($names, 'Выберите комплектующее, к которому относится данное');
        
        $result_components = array_combine($ids, $names);
        
        unset($result_components[$id]);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.componentedit', [
                'equipments' => $result,
                'component' => $component,
                'components' => $result_components
            ]);
        } 
        
        return view('adminpanel.componentedit', [
            'equipments' => $result,
            'component' => $component,
            'components' => $result_components
        ]);
        
    }
    
    /**
     * Update component
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $data = $request->input('component');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $component = Component::find($id);
        
        $component->equipment_id = $data['equipment'];
        $component->name = $data['name'];
        $component->number = $data['number_edit'];
        $component->parent_id = ($data['parent_id'] == '') ? null : $data['parent_id'];
        $component->count_in = $data['count_in'];
        $component->balance_notification = $data['balance_notification'];
        
        $component->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/components', 
            'message' => 'Изменения успешно сохранены.'
            ]);
    }
    
    public function getComponentStock(Request $request, $id) {
        
        $data = $request->input();
        
        if($request->ajax()) {
            return view('adminpanel.ajax.stock');
        } 
        
        return view('adminpanel.stock');
        
    }
    
    public function delete($id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $component = Component::find($id);
        
        
        $result = Component::where('parent_id', $component->id)
          ->update(['parent_id' => $component->parent_id]);
        
        $component->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/components', 
            'message' => 'Запись успешно удалена.'
        ]);
    }
    
    /**
     * Validate fields of component
     * 
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data) {
        
        return Validator::make($data, [
            'equipment' => 'required|numeric',
            'name' => 'required',
            'count' => 'required|numeric|integer',
            'count_in' => 'required|numeric|integer',
            'balance_notification' => 'numeric'
        ]);
    }
}
