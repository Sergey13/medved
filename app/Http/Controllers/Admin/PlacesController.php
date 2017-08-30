<?php

namespace App\Http\Controllers\Admin;

use App\Equipment;
use Illuminate\Http\Request;
use Auth;
use App\Place;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
    
    public function __construct() {
        
        $this->middleware('role:admin|director');
        
    }
    

    public function getIndex(Request $request) {

        $places = Place::orderBy('name')->get();
        
        if($request->input('ajax') == 'json') {
            
            return response()->json($places->toArray());
        }
        
        if($request->ajax()) {
            return view('adminpanel.ajax.places', [
                'places' => $places
            ]);
        } 
        
        return view('adminpanel.places', [
            'places' => $places
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
        
        if($request->ajax()) {
            return view('adminpanel.ajax.placecreate');
        } 
        
        return view('adminpanel.placecreate');
        
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
        
        $data = $request->input('place');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $place = new Place;

        $place->name = $data['name'];

        $place->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/places',
            'message' => 'Место установки успешно добавлено.'
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

        
        $place = Place::find($id);
        
        if($request->ajax()) {
            return view('adminpanel.ajax.placeedit', [
                'place' => $place
            ]);
        } 
        
        return view('adminpanel.placeedit', [
            'place' => $place
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
        
        $data = $request->input('place');
        
        $v = $this->validator($data);
        
        if($v->fails()) {
            
            return  response()->json(['errors' => $v->errors()]);
        }
        
        
        $place = Place::find($id);

        $place->name = $data['name'];

        $place->save();
        
        return  response()->json([
            'status' => 'ok', 
            'url' => '/places',
            'message' => 'Изменения успешно сохранены.'
            ]);
    }
    
    public function delete($id) {
        
        if(!Auth::user()->can('edit')) {
            
            abort(403);
            
            return;
        }
        
        $place = Place::find($id);

        $place->delete();
        
        return response()->json([
            'status' => 'ok', 
            'url' => '/places',
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
            'name' => 'required'
        ]);
    }
}
