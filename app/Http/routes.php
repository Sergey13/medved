<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::get('uploads/{file}', function($path) {

    if (file_exists('/uploads/' . $path)) {
        return Response::download('/uploads/' . $path);
    } else {
        return redirect('/error');
    }
});

Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::group(['middleware' => 'auth'], function() {
        
        Route::get('/', function() {
            return redirect('/adminpanel');
        });

        Route::controllers([
            '/adminpanel' => 'Admin\AdminPanelController'
        ]);

        Route::get('/equipment/{eq_id}/upload', 'Admin\EquipmentController@getDocumentUpload')
                ->where(['eq_id' => '[0-9]+']);

        Route::post('/equipment/file/upload', 'Admin\EquipmentController@postDocumentUpload');
        
        Route::delete('/equipment/files/cancel', 'Admin\EquipmentController@DocumentsCancel');
        
        Route::delete('/equipment/file/{file_id}', 'Admin\EquipmentController@deleteDocument')
                ->where(['eq_id' => '[0-9]+']);
        
        Route::post('/equipment/{eq_id}/upload', 'Admin\EquipmentController@postDocumentsSave')
                ->where(['eq_id' => '[0-9]+']);
        
        Route::get('/equipment/{comp_id}/components', 'Admin\EquipmentController@getEquipmentComponents')
                ->where(['com_id' => '[0-9]+']);
        
        Route::get('/equipment/{eq_id}/edit', 'Admin\EquipmentController@getEdit')
                ->where(['eq_id' => '[0-9]+']);
        
        Route::put('/equipment/{eq_id}/update', 'Admin\EquipmentController@putUpdate')
                ->where(['eq_id' => '[0-9]+']);
        
        Route::delete('/equipment/{eq_id}', 'Admin\EquipmentController@delete')
                ->where(['eq_id' => '[0-9]+']);

        Route::get('/components/{id}/stock', 'Admin\ComponentsController@getComponentStock')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/components/{id}/edit', 'Admin\ComponentsController@getEdit')
                ->where(['id' => '[0-9]+']);
        
        Route::put('/components/{id}/update', 'Admin\ComponentsController@putUpdate')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/components/{id}/inside', 'Admin\ComponentsController@getInside')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/components/{id}/create', 'Admin\ComponentsController@getInsideCreate')
                ->where(['id' => '[0-9]+']);
        
        Route::post('/components/{id}/save', 'Admin\ComponentsController@postInsideSave')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/components/{id}', 'Admin\ComponentsController@delete')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/performers/{id}/edit', 'Admin\PerformersController@getEdit')
                ->where(['id' => '[0-9]+']);
        
        Route::put('/performers/{id}/update', 'Admin\PerformersController@putUpdate')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/performers/{id}', 'Admin\PerformersController@delete')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/tools/{id}/edit', 'Admin\ToolsController@getEdit')
                ->where(['id' => '[0-9]+']);
        
        Route::put('/tools/{id}/update', 'Admin\ToolsController@putUpdate')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/tools/{id}', 'Admin\ToolsController@delete')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/materials/{id}/edit', 'Admin\MaterialsController@getEdit')
                ->where(['id' => '[0-9]+']);
        
        Route::put('/materials/{id}/update', 'Admin\MaterialsController@putUpdate')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/materials/{id}', 'Admin\MaterialsController@delete')
                ->where(['id' => '[0-9]+']);

        Route::controllers([
            '/components' => 'Admin\ComponentsController'
        ]);
        
        Route::get('/schedule/equipment/{id}/create', 'Admin\ScheduleController@getCreate')
                ->where(['id' => '[0-9]+']);
        
        Route::post('/schedule/equipment/{id}/save', 'Admin\ScheduleController@postSave')
                ->where(['id' => '[0-9]+']);
        
        Route::get('/schedule/equipment/{id}/edit', 'Admin\ScheduleController@getEdit')
                ->where(['id' => '[0-9]+']);
        
        Route::put('/schedule/equipment/{id}/update', 'Admin\ScheduleController@putUpdate')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/schedule/equipment/{id}/{year}/delete', 'Admin\ScheduleController@deleteSchedule')
                ->where(['id' => '[0-9]+', 'year' => '\d{4}']);
        
        Route::get('/record/component/{id}/create', 'Admin\RecordController@getCreateComponent')
                ->where(['id' => '[0-9]+']);
        
        Route::post('/record/component/{id}/save', 'Admin\RecordController@postSaveComponent')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/record/component/{comp_id}/{id}/delete', 'Admin\RecordController@deleteComponent')
                ->where(['id' => '[0-9]+', 'comp_id' => '[0-9]+']);
        
        Route::get('/record/equipment/{id}/create', 'Admin\RecordController@getCreateEquipment')
                ->where(['id' => '[0-9]+']);
        
        Route::post('/record/equipment/{id}/save', 'Admin\RecordController@postSaveEquipment')
                ->where(['id' => '[0-9]+']);
        
        Route::delete('/record/equipment/{eq_id}/{id}/delete', 'Admin\RecordController@deleteEquipment')
                ->where(['id' => '[0-9]+', 'eq_id' => '[0-9]+']);
        
        Route::get('/schedule/notifications', 'Admin\ScheduleController@getNotifications');
        
        Route::get('/stock/notifications', 'Admin\StockController@getNotifications');

        Route::post('/stock/notifications','Admin\StockController@delNotifications'); /// удаление записи в таблице необходимо пополнить склад
        
        Route::put('/schedule/notifications/{id}', 'Admin\ScheduleController@putNotificationsUpdate')
                ->where(['id' => '[0-9]+']);

        Route::get('/places/{place_id}/edit', 'Admin\PlacesController@getEdit')
            ->where(['place_id' => '[0-9]+']);

        Route::put('/places/{place_id}/update', 'Admin\PlacesController@putUpdate')
            ->where(['place_id' => '[0-9]+']);

        Route::delete('/places/{place_id}', 'Admin\PlacesController@delete')
            ->where(['place_id' => '[0-9]+']);
        
        Route::controllers([
            '/schedule' => 'Admin\ScheduleController'
        ]);

        Route::controllers([
            '/stock' => 'Admin\StockController'
        ]);

        Route::controllers([
            '/record' => 'Admin\RecordController'
        ]);

        Route::controllers([
            '/equipment' => 'Admin\EquipmentController'
        ]);

        Route::controllers([
            '/performers' => 'Admin\PerformersController'
        ]);
        
//        Route::controllers([
//            '/places' => 'Admin\PlacesController'
//        ]);
    });
});

Route::get('/error', function() {
    return view('error');
});

Route::get('/error/server', function() {
    return view('errorserver');
});

Route::get('/error/access', function() {
    return view('erroraccess');
});