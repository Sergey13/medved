<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Place;
use Illuminate\Http\Request;
use DateTimeInterface;
use Auth;
use App\Store;
use App\Component;
use App\Equipment;
use App\Tool;
use App\Material;
use App\Performer;
use App\Helpers\DateFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StockController extends Controller
{
    public function getComponents(Request $request)
    {

        $stock = Store::with('place')
            ->whereNotNull('component_id')
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $stock->load('component', 'performer');

        foreach ($stock as $key => $item) {
            $stock[$key]->date_full = DateFormat::formatDate($item->date);
            $stock[$key]->unit_name = $item->units[$item->unit];
        }

        if ($request->input('ajax') == 'json') {

            return response()->json($stock->toArray());
        }

        $data = $this->modify_store_data($stock);


        if ($request->ajax()) {

            return view('adminpanel.ajax.stock', [
                'stock_incoming' => $data['stock_incoming'],
                'stock_expense'  => $data['stock_expense'],
                'request'        => $request,
                'list'           => 'component'
            ]);

        }

        return view('adminpanel.stock', [
            'stock_incoming' => $data['stock_incoming'],
            'stock_expense'  => $data['stock_expense'],
            'request'        => $request,
            'list'           => 'component'
        ]);
    }

    public function getComponent(Request $request, $id)
    {

        $stock = Store::with('place')
            ->where('component_id', '=', $id)
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $stock->load('component', 'performer');

        foreach ($stock as $key => $item) {
            $stock[$key]->date_full = DateFormat::formatDate($item->date);
            $stock[$key]->unit_name = $item->units[$item->unit];
        }

        if ($request->input('ajax') == 'json') {

            return response()->json($stock->toArray());

        }

        $data = $this->modify_store_data($stock);

        if ($request->ajax()) {
            return view('adminpanel.ajax.stock', [
                'stock_incoming' => $data['stock_incoming'],
                'stock_expense'  => $data['stock_expense'],
                'request'        => $request,
                'component'      => $id,
                'list'           => 'component'
            ]);
        }

        return view('adminpanel.stock', [
            'stock_incoming' => $data['stock_incoming'],
            'stock_expense'  => $data['stock_expense'],
            'request'        => $request,
            'component'      => $id,
            'list'           => 'component'
        ]);
    }

    public function getEquipments(Request $request)
    {

        $stock = Store::with('place')
            ->whereNotNull('equipment_id')
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $stock->load('equipment', 'performer');

        foreach ($stock as $key => $item) {
            $stock[$key]->date_full = DateFormat::formatDate($item->date);
            $stock[$key]->unit_name = $item->units[$item->unit];
        }

        if ($request->input('ajax') == 'json') {

            return response()->json($stock->toArray());
        }

        $data = $this->modify_store_data($stock);


        if ($request->ajax()) {

            return view('adminpanel.ajax.stock', [
                'stock_incoming' => $data['stock_incoming'],
                'stock_expense'  => $data['stock_expense'],
                'request'        => $request,
                'list'           => 'equipment'
            ]);

        }

        return view('adminpanel.stock', [
            'stock_incoming' => $data['stock_incoming'],
            'stock_expense'  => $data['stock_expense'],
            'request'        => $request,
            'list'           => 'equipment'
        ]);
    }

    public function getTools(Request $request)
    {

        $stock = Store::with('place')
            ->whereNotNull('tool_id')
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $stock->load('tool', 'performer');

        foreach ($stock as $key => $item) {
            $stock[$key]->date_full = DateFormat::formatDate($item->date);
            $stock[$key]->unit_name = $item->units[$item->unit];
        }

        if ($request->input('ajax') == 'json') {

            return response()->json($stock->toArray());
        }

        $data = $this->modify_store_data($stock);


        if ($request->ajax()) {

            return view('adminpanel.ajax.stock', [
                'stock_incoming' => $data['stock_incoming'],
                'stock_expense'  => $data['stock_expense'],
                'request'        => $request,
                'list'           => 'tool'
            ]);

        }

        return view('adminpanel.stock', [
            'stock_incoming' => $data['stock_incoming'],
            'stock_expense'  => $data['stock_expense'],
            'request'        => $request,
            'list'           => 'tool'
        ]);
    }

    public function getMaterials(Request $request)
    {

        $stock = Store::with('place')
            ->whereNotNull('material_id')
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $stock->load('material', 'performer');

        foreach ($stock as $key => $item) {
            $stock[$key]->date_full = DateFormat::formatDate($item->date);
            $stock[$key]->unit_name = $item->units[$item->unit];
        }

        if ($request->input('ajax') == 'json') {

            return response()->json($stock->toArray());
        }

        $data = $this->modify_store_data($stock);

        if ($request->ajax()) {

            return view('adminpanel.ajax.stock', [
                'stock_incoming' => $data['stock_incoming'],
                'stock_expense'  => $data['stock_expense'],
                'request'        => $request,
                'list'           => 'material'
            ]);

        }

        return view('adminpanel.stock', [
            'stock_incoming' => $data['stock_incoming'],
            'stock_expense'  => $data['stock_expense'],
            'request'        => $request,
            'list'           => 'material'
        ]);
    }

    /**
     * Show create form for stock
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request)
    {

        if (!Auth::user()->can('edit-stock')) {

            abort(403);

            return;
        }

        $data = $request->input();

        if (isset($data['list']) && $data['list'] == 'component') {

            return $this->create_form_component($request);

        }

        if (isset($data['list']) && $data['list'] == 'equipment') {

            return $this->create_form_equipment($request);

        }

        if (isset($data['list']) && $data['list'] == 'tool') {

            return $this->create_form_tool($request);

        }

        if (isset($data['list']) && $data['list'] == 'material') {

            return $this->create_form_material($request);

        }

    }


    /**
     * Save record to stock
     *
     * @param Request $request
     */
    public function postSave(Request $request)
    {

        if (!Auth::user()->can('edit-stock')) {

            abort(403);

            return;
        }

        $data = $request->input('stock');

        $data['date'] = DateFormat::change_date_for_db($data['date']);

        $list = $request->input('list');

        $name_id = $list . '_id';

        if ($list == 'component' && $data[$name_id] !== '') {
            $object_list = Component::find($data[$name_id]);
        }

        if ($list == 'equipment' && $data[$name_id] !== '') {
            $object_list = Equipment::find($data[$name_id]);
        }

        if ($list == 'tool' && $data[$name_id] !== '') {
            $object_list = Tool::find($data[$name_id]);
        }

        if ($list == 'material' && $data[$name_id] !== '') {
            $object_list = Material::find($data[$name_id]);
        }

        if ($data['type'] == 'expense') {

            if (isset($object_list)) {
                $count = $object_list->count;
            } else {
                $count = 0;
            }

            $v = $this->validator($data, $count);

        } else {

            $v = $this->validator($data);

        }

        if ($v->fails()) {

            return response()->json(['errors' => $v->errors()]);
        }

        if (isset($data[$list . '_name']) && $data[$list . '_name'] !== '' && $data[$name_id] == '') {

            $object_list = $this->create_new_object($list, $data[$list . '_name'], $data['unit']);

            if (isset($object_list['error'])) {
                return response()->json(['errors' => $object_list['error']->errors()]);
            }

            $data[$name_id] = $object_list->id;

        }

        if (isset($data['place_add']) && $data['place_add'] != '' && $data['place'] == '') {

            $place = Place::whereName($data['place_add'])->first();

            if (!$place) {
                $place = Place::create([
                    'name' => $data['place_add']
                ]);
            }
            $data['place'] = $place->id;
        }

        $store = new Store;

        $store->$name_id = $data[$name_id];
        $store->type = $data['type'];
        $store->count = (float)$data['count'];
        $store->date = $data['date'];
        $store->unit = $object_list->unit;

        if ($data['type'] == 'expense') {

            $store->count = (float)$data['count'] * (-1);
            $store->performer_id = $data['performer_id'];
            $store->place_id = (isset($data['place'])) ? $data['place'] : null;

        }

        $store->save();

        if (isset($object_list)) {

            $object_list->count = (float)$object_list->count + (float)$store->count;

            if ($data['type'] == 'incoming') {

                $object_list->balance_notification = $data['balance_notification'];

            }

            $object_list->save();
        }

        $url = '/stock';

        $object = $request->input($list);

        if (isset($object)) {
            $url .= '/' . $list . '/' . $data[$object];
        } else {
            $url .= '/' . $list . 's';
        }

        if ($data['type'] == 'expense') {

            $url .= '?type=expense';

        } else if ($data['type'] == 'incoming') {

            $url .= '?type=incoming';

        }

        return response()->json([
            'status'  => 'ok',
            'url'     => $url,
            'message' => 'Запись успешно добавлена.'
        ]);

    }

    /**
     * Get all notifications for stock
     *
     * @param Request $request
     * @return View
     */
    protected function getNotifications(Request $request)
    {

        $equipments = Equipment::all();

        $components = Component::all();

        $material = Material::all();

        $equipments = $equipments->filter(function ($item) {
            return $item->count <= $item->balance_notification;
        });

        $components = $components->filter(function ($item) {
            return $item->count <= $item->balance_notification;
        });

        $material = $material->filter(function ($item) {
            return $item->count <= $item->balance_notification;
        });

        $notifications = [
            'Оборудование'  => $equipments,
            'Комплектующие' => $components,
            'Материалы'     => $material
        ];

        if ($request->ajax()) {
            return view('adminpanel.ajax.balance_notifications', [
                'notifications' => $notifications
            ]);
        } else {
            return redirect('/stock');
        }
    }


     /**
     * Get all notifications for stock
     *
     * @param Request $request
     * @return View
     */
    public function delNotifications(Request $request) //прием аякс запроса на удаление товара из списка пополнения склада
    {
       
    $data = $request->input('data');
    $vid = $request->input('vid');
    $data= trim($data);


     
    if ($vid=="k") {
        $components = Component::where('name', $data)->first();   
        $components->balance_notification = '-1';    
        $components->save();
    /*mail ("sv-garant@mail.ru",
      "медведь тест",
      "Данные: $data \n $vid \n",
      "Content-type:text/plain; charset=utf-8");*/

        }

        if ($vid=="m") {
        $material = Material::where('name', $data)->first();   
        $material->balance_notification = '-1';    
        $material->save();
    /*mail ("sv-garant@mail.ru",
      "медведь тест",
      "Данные: $data \n $vid \n",
      "Content-type:text/plain; charset=utf-8");*/
           

        }

        if ($vid=="o") {
        $equipments = Equipment::where('name', $data)->first();
        $equipments->balance_notification = '-1';    
        $equipments->save();
    /*mail ("sv-garant@mail.ru",
      "медведь тест",
      "Данные: $data \n $vid \n",
      "Content-type:text/plain; charset=utf-8");*/   

        }
   
    }

    /**
     * Generete data for create component form
     * @param Request $request
     * @return View
     */
    protected function create_form_component(Request $request)
    {

        $components = Component::all()->toArray();

        $ids = array_column($components, 'id');

        array_push($ids, '');

        $names = array_column($components, 'name');

        array_push($names, 'Выберите комплектующее');

        $result = array_combine($ids, $names);

        $performers = Performer::all()->toArray();

        $ids = array_column($performers, 'id');

        array_push($ids, '');

        $names = array_column($performers, 'fio');

        array_push($names, 'Выберите кому выдано комплектующее');

        $result_performers = array_combine($ids, $names);

        $places = Place::getPlacesForSelect();
        if ($request->ajax()) {
            return view('adminpanel.ajax.stock_component_create', [
                'request'    => $request,
                'components' => $result,
                'performers' => $result_performers,
                'units'      => Store::getUnits(),
                'places'     => $places
            ]);
        }

        return view('adminpanel.stock_component_create', [
            'request'    => $request,
            'components' => $result,
            'performers' => $result_performers,
            'units'      => Store::getUnits(),
            'places'     => $places
        ]);

    }

    /**
     * Generete data for create equipment form
     * @param Request $request
     * @return View
     */
    protected function create_form_equipment(Request $request)
    {

        $equipments = Equipment::all()->toArray();

        $ids = array_column($equipments, 'id');

        array_push($ids, '');

        $names = array_column($equipments, 'name');

        array_push($names, 'Выберите оборудование');

        $result = array_combine($ids, $names);

        $performers = Performer::all()->toArray();

        $ids = array_column($performers, 'id');

        array_push($ids, '');

        $names = array_column($performers, 'fio');

        array_push($names, 'Выберите кому выдано оборудование');

        $result_performers = array_combine($ids, $names);
        $places = Place::getPlacesForSelect();

        if ($request->ajax()) {
            return view('adminpanel.ajax.stock_equipment_create', [
                'request'    => $request,
                'equipments' => $result,
                'performers' => $result_performers,
                'units'      => Store::getUnits(),
                'places'     => $places
            ]);
        }

        return view('adminpanel.stock_equipment_create', [
            'request'    => $request,
            'equipments' => $result,
            'performers' => $result_performers,
            'units'      => Store::getUnits(),
            'places'     => $places
        ]);

    }

    /**
     * Generete data for create tool form
     * @param Request $request
     * @return View
     */
    protected function create_form_tool(Request $request)
    {

        $tools = Tool::all()->toArray();

        $ids = array_column($tools, 'id');

        array_push($ids, '');

        $names = array_column($tools, 'name');

        array_push($names, 'Выберите инструмент');

        $result = array_combine($ids, $names);

        $performers = Performer::all()->toArray();

        $ids = array_column($performers, 'id');

        array_push($ids, '');

        $names = array_column($performers, 'fio');

        array_push($names, 'Выберите кому выдан инструмент');

        $result_performers = array_combine($ids, $names);
        $places = Place::getPlacesForSelect();

        if ($request->ajax()) {

            return view('adminpanel.ajax.stock_tool_create', [
                'request'    => $request,
                'tools'      => $result,
                'performers' => $result_performers,
                'units'      => Store::getUnits(),
                'places'     => $places
            ]);

        }

        return view('adminpanel.stock_tool_create', [
            'request'    => $request,
            'tools'      => $result,
            'performers' => $result_performers,
            'units'      => Store::getUnits(),
            'places'     => $places
        ]);

    }

    /**
     * Generete data for create tool form
     *
     * @param Request $request
     *
     * @return View
     */
    protected function create_form_material(Request $request)
    {

        $materials = Material::all()->toArray();

        $ids = array_column($materials, 'id');

        array_push($ids, '');

        $names = array_column($materials, 'name');

        array_push($names, 'Выберите материал');

        $result = array_combine($ids, $names);

        $performers = Performer::all()->toArray();

        $ids = array_column($performers, 'id');

        array_push($ids, '');

        $names = array_column($performers, 'fio');

        array_push($names, 'Выберите кому выдан материал');

        $result_performers = array_combine($ids, $names);

        $places = Place::getPlacesForSelect();

        if ($request->ajax()) {

            return view('adminpanel.ajax.stock_material_create', [
                'request'    => $request,
                'materials'  => $result,
                'performers' => $result_performers,
                'units'      => Store::getUnits(),
                'places'     => $places
            ]);

        }

        return view('adminpanel.stock_material_create', [
            'request'    => $request,
            'materials'  => $result,
            'performers' => $result_performers,
            'units'      => Store::getUnits(),
            'places'     => $places
        ]);

    }

    protected function create_new_object($list, $name, $unit = 'peice')
    {

        $v = Validator::make([$list . '_name' => $name], [
            $list . '_name' => 'unique:' . $list . 's,name'
        ]);

        if ($v->fails()) {

            return array('error' => $v);
        }


        if ($list == 'tool') {

            $object = Tool::create([
                'name' => $name,
                'unit' => $unit
            ]);
        }

        if ($list == 'material') {

            $object = Material::create([
                'name' => $name,
                'unit' => $unit
            ]);
        }

        return $object;

    }

    /**
     * Modify data for store
     *
     * @param type $stock
     * @return array
     */
    protected function modify_store_data($stock)
    {

        $data = [];

        $data['stock_incoming'] = $stock->filter(function ($item) {
            return $item->type == 'incoming';
        });

        $data['stock_expense'] = $stock->filter(function ($item) {
            return $item->type == 'expense';
        });

        return $data;
    }

    /**
     * Validate fields of store
     *
     * @param array $data
     * @return Validator
     */
    protected function validator(array $data, $max = NULL)
    {

        if (isset($max)) {
            $count_rule = 'required|numeric|min:0|max:' . $max;
        } else {
            $count_rule = 'required|numeric|min:0.01';
        }

        return Validator::make($data, [
            'tool_name'            => 'sometimes|required_without:tool_id',
            'tool_id'              => 'sometimes|required_without:tool_name',
            'material_name'        => 'sometimes|required_without:material_id',
            'material_id'          => 'sometimes|required_without:material_name',
            'component_id'         => 'sometimes|required',
            'equipment_id'         => 'sometimes|required',
            'type'                 => array('required', 'regex:[^(incoming|expense)]'),
            'date'                 => 'required|date',
            'count'                => $count_rule,
            'performer_id'         => 'required_if:type,expense',
            'balance_notification' => 'required_if:type,incoming'
        ]);
    }
}
