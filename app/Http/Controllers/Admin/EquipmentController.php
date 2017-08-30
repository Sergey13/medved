<?php

namespace App\Http\Controllers\Admin;


use DB;
use Illuminate\Http\Request;
use DateTimeInterface;
use Auth;
use App\Equipment;
use App\Document;
use App\Place;
use App\Component;
use App\Helpers\DateFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{

    static $DOCUMENT_FORMAT_CLASS = array(
        'txt'   => 'fa fa-file-text-o',
        'png'   => 'fa fa-file-image-o',
        'zip'   => 'fa fa-file-archive-o',
        'rar'   => 'fa fa-file-archive-o',
        'jpg'   => 'fa fa-file-image-o',
        'jpeg'  => 'fa fa-file-image-o',
        'csv'   => 'fa fa-file-excel-o',
        'xls'   => 'fa fa-file-excel-o',
        'xlt'   => 'fa fa-file-excel-o',
        'xlw'   => 'fa fa-file-excel-o',
        'doc'   => 'fa fa-file-word-o',
        'docx'  => 'fa fa-file-word-o',
        'pdf'   => 'fa fa-file-pdf-o',
        'other' => 'fa fa-file-o'
    );

    public function __construct()
    {

        $this->middleware('role:admin|director');

    }

    /**
     * Show list of equipments
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {


        $equipments = Equipment::all();

        $equipments->load('place', 'documents');

        foreach ($equipments as $equipment) {
            $equipment->installation_date_format = DateFormat::formatDate($equipment->installation_date);
        }

        $equipments = $equipments->sortBy('place.name');

        if ($request->input('ajax') == 'json') {

            return response()->json($equipments->toArray());
        }

        if ($request->ajax()) {
            return view('adminpanel.ajax.index', [
                'equipments' => $equipments,
            ]);
        }

        return view('adminpanel.index', [
            'equipments' => $equipments,
        ]);
    }

    public function getDocuments(Request $request, $id)
    {

        $equipment = Equipment::find($id);
        $equipment->load('documents');

        if (!isset($equipment)) {
            abort(404);

            return;
        }

        if (isset($equipment->documents)) {
            foreach ($equipment->documents as $key => $document) {
                $equipment->documents[$key]->label = (array_key_exists($document->type, self::$DOCUMENT_FORMAT_CLASS)) ? self::$DOCUMENT_FORMAT_CLASS[$document->type] : self::$DOCUMENT_FORMAT_CLASS['other'];
            }
        }

        if ($request->ajax()) {
            return view('adminpanel.ajax.documents', [
                'equipment' => $equipment,
            ]);
        }

        return view('adminpanel.documents', [
            'equipment' => $equipment,
        ]);

    }

    /**
     * Show list components of equipment
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function getEquipmentComponents(Request $request, $id)
    {

        $equipment = Equipment::find($id);

        $components = Component::with('child')
            ->whereNull('parent_id')
            ->where('equipment_id', '=', $id)->get();

        if ($request->input('ajax') == 'json') {

            return response()->json($components->toArray());
        }

        if ($request->ajax()) {
            return view('adminpanel.ajax.components', [
                'equipment'  => $equipment,
                'components' => $components
            ]);
        }

        return view('adminpanel.components', [
            'equipment'  => $equipment,
            'components' => $components
        ]);
    }


    public function getDocumentUpload(Request $request, $id)
    {

        $equipment = Equipment::find($id);

        if ($request->ajax()) {
            return view('adminpanel.ajax.upload', [
                'equipment' => $equipment
            ]);
        }

        return view('adminpanel.upload', [
            'equipment' => $equipment
        ]);
    }

    public function postDocumentUpload(Request $request)
    {

        $files = $request->file('files');

        if (isset($files)) {

            $document = $files[0];
            $destinationPath = '/uploads';
            $extension = $document->getClientOriginalExtension();
            $type = $document->getClientMimeType();
            $originalName = $document->getClientOriginalName();
            $name = preg_replace('/\.\w+$/', '', $originalName);
            $fileName = rand(1111111, 9999999) . '.' . $extension;
            $result = $document->move(public_path() . $destinationPath, $fileName);
            $fileUrl = $destinationPath . '/' . $fileName;
            $extensionLabel = (array_key_exists($extension, self::$DOCUMENT_FORMAT_CLASS)) ? self::$DOCUMENT_FORMAT_CLASS[$extension] : self::$DOCUMENT_FORMAT_CLASS['other'];

            $doc = new Document;

            $id = DB::table($doc->table)->insertGetId([
                'link'         => $fileUrl,
                'equipment_id' => 0,
                'name'         => $name,
                'type'         => $extension
            ]);

            return response()->json([
                'files' =>
                    [[
                        'id'          => $id,
                        'url'         => $fileUrl,
                        'name'        => $originalName,
                        'label'       => $extensionLabel,
                        'type'        => $type,
                        'size'        => 46353,
                        'delete_url'  => "/equipment/file/" . $id,
                        'delete_type' => "DELETE"
                    ]]
            ]);
        }

    }

    public function postDocumentsSave(Request $request, $id)
    {

        $files = $request->input('files');

        $filesIDs = array_values($files);

        Document::whereIn('id', $filesIDs)->update(array('equipment_id' => $id));

        $this->clearDocuments();

        return response()->json([
            'status'  => 'ok',
            'url'     => '/equipment/documents/' . $id,
            'message' => 'Файлы успешно добавлены.'
        ]);

    }

    public function DocumentsCancel(Request $request)
    {

        $this->clearDocuments();

        return response()->json([
            'status'  => 'ok',
            'url'     => $request->input('url'),
            'message' => 'Запись успешно удалена.'
        ]);
    }

    public function deleteDocument(Request $request, $id)
    {

        $document = Document::find($id);

        $fullPath = public_path() . $document->link;

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $document->delete();

        return response()->json([
            'status'  => 'ok',
            'message' => 'Запись успешно удалена.'
        ]);
    }

    /**
     * Show create form for equipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request)
    {

        if (!Auth::user()->can('add')) {

            abort(404);

            return;
        }

        $places = Place::all()->toArray();

        $ids = array_column($places, 'id');

        array_push($ids, '');

        $names = array_column($places, 'name');

        array_push($names, 'Выберите место установки');

        $result = array_combine($ids, $names);

        if ($request->ajax()) {
            return view('adminpanel.ajax.equipmentcreate', [
                'places' => $result
            ]);
        }

        return view('adminpanel.equipmentcreate', [
            'places' => $result
        ]);

    }

    /**
     * Save new equipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {

        if (!Auth::user()->can('add')) {

            abort(404);

            return;
        }

        $data = $request->input('equipment');

        $data['installation_date'] = DateFormat::change_date_for_db($data['installation_date']);

        $files = $request->file('equipment');

        if (isset($files)) {

            $data = array_merge($data, $files);

        }

        $v = $this->validator($data);

        if ($v->fails()) {

            return response()->json(['errors' => $v->errors()]);
        }

        if ($data['place_add'] != '' && $data['place'] == '') {

            $place = Place::create([
                'name' => $data['place_add']
            ]);

            $data['place'] = $place->id;
        }

        $equipment = new Equipment;

        if (isset($files)) {

            $document = $files['document'];

            $destinationPath = '/uploads';

            $extension = $document->getClientOriginalExtension();

            $fileName = rand(11111, 99999) . '.' . $extension;

            $result = $document->move(public_path() . $destinationPath, $fileName);

            $equipment->document = $destinationPath . '/' . $fileName;
        }

        $equipment->place_id = $data['place'];
        $equipment->name = $data['name'];
        $equipment->installation_date = $data['installation_date'];
        $equipment->pasport = $data['pasport'];
        $equipment->inventory_number = $data['inventory_number'];

        $equipment->save();

        return response()->json([
            'status'  => 'ok',
            'url'     => '/equipment',
            'message' => 'Оборудование успешно добавлено.'
        ]);
    }

    /**
     * Show edit form for equipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {

        if (!Auth::user()->can('edit')) {

            abort(404);

            return;
        }

        $places = Place::all()->toArray();

        $ids = array_column($places, 'id');

        array_push($ids, '');

        $names = array_column($places, 'name');

        array_push($names, 'Выберите место установки');

        $result = array_combine($ids, $names);

        $equipment = Equipment::find($id);

        $equipment->installation_date = DateFormat::change_date_for_view($equipment->installation_date);

        if ($request->ajax()) {
            return view('adminpanel.ajax.equipmentedit', [
                'places'    => $result,
                'equipment' => $equipment
            ]);
        }

        return view('adminpanel.equipmentedit', [
            'places'    => $result,
            'equipment' => $equipment
        ]);

    }

    /**
     * Update equipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id)
    {

        if (!Auth::user()->can('edit')) {

            abort(404);

            return;
        }

        $data = $request->input('equipment');

        $data['installation_date'] = DateFormat::change_date_for_db($data['installation_date']);

        $files = $request->file('equipment');

        if (isset($files)) {

            $data = array_merge($data, $files);

        }

        $v = $this->validator($data);

        if ($v->fails()) {

            return response()->json(['errors' => $v->errors()]);
        }

        if ($data['place_add'] != '') {

            $place = Place::create([
                'name' => $data['place_add']
            ]);

            $data['place'] = $place->id;
        }


        $equipment = Equipment::find($id);

        if (isset($files) && count($files) !== 0) {

            $document = $files['document'];

            $destinationPath = '/uploads';

            $extension = $document->getClientOriginalExtension();

            $fileName = rand(11111, 99999) . '.' . $extension;

            $result = $document->move(public_path() . $destinationPath, $fileName);

            $equipment->document = $destinationPath . '/' . $fileName;


            if (isset($data['pasport_document']) && $data['pasport_document'] !== '') {

                if (file_exists(public_path() . $data['pasport_document'])) {
                    unlink(public_path() . $data['pasport_document']);
                }
            }
        }

        $equipment->place_id = $data['place'];
        $equipment->name = $data['name'];
        $equipment->installation_date = $data['installation_date'];
        $equipment->pasport = $data['pasport'];
        $equipment->inventory_number = $data['inventory_number'];
        $equipment->balance_notification = $data['balance_notification'];

        $equipment->save();

        return response()->json([
            'status'  => 'ok',
            'url'     => '/equipment',
            'message' => 'Изменения успешно сохранены.'
        ]);
    }

    /**
     * Delete equipment
     *
     * @param type $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (!Auth::user()->can('edit')) {

            abort(404);

            return;
        }

        $equipment = Equipment::find($id);

        if (isset($equipment->document) && $equipment->document != '') {

            if (file_exists(public_path() . $equipment->document)) {
                unlink(public_path() . $equipment->document);
            }
        }

        $equipment->delete();

        return response()->json([
            'status'  => 'ok',
            'url'     => '/equipment',
            'message' => 'Запись успешно удалена.'
        ]);

    }

    protected function clearDocuments()
    {

        $documents = Document::where('equipment_id', 0)->get();

        foreach ($documents as $document) {
            $fullPath = public_path() . $document->link;

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        Document::where('equipment_id', 0)->delete();

        return true;
    }


    /**
     * Validate fields of equipment
     *
     * @param array $data
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'place'             => 'required_without:place_add',
            'place_add'         => 'required_without:place|unique:places,name',
            'name'              => 'required',
            'installation_date' => 'required|date',
        ]);
    }

}
