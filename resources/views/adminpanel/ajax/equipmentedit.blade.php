
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Изменить данные для "{{$equipment->name}}".
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/equipment/'.$equipment->id.'/update', 'method' => 'put', 'id' => 'form-equipment-update', 'files' => true, 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='equipment-place'>Место установки</label>
            {!! Form::select('equipment[place]', $places, $equipment->place_id, array('class' => 'form-control chosen-select', 'id' => 'equipment-place')) !!}
            <label class="control-label" for='equipment-place_add'>Или добавьте новое место установки</label>
            {!! Form::text('equipment[place_add]', '', array('class' => 'form-control', 'id' => 'equipment-place_add'))!!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='equipment-name'>Название оборудования</label>
            {!! Form::text('equipment[name]', $equipment->name, array('class' => 'form-control', 'id' => 'equipment-name')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='equipment-installation_date'>Дата установки</label>
            {!! Form::text('equipment[installation_date]', $equipment->installation_date, array('class' => 'form-control datepicker-field', 'id' => 'equipment-installation_date')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='equipment-pasport'>Паспорт изделия</label>
            {!! Form::textarea('equipment[pasport]', $equipment->pasport, array('class' => 'form-control', 'id' => 'equipment-pasport', 'rows' => 3)) !!}

        </div>
        <div class='form-group'>
            <label class="control-label" for='equipment-inventory_number'>Инвентаризационный номер</label>
            {!! Form::text('equipment[inventory_number]', $equipment->inventory_number, array('class' => 'form-control', 'id' => 'equipment-inventory_number')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for="equipment-balance_notification">Изменить остаток для напоминания</label>
            {!! Form::text('equipment[balance_notification]', $equipment->balance_notification, array('class' => 'form-control', 'id' => 'equipment-balance_notification')) !!}
        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/equipment' data-name='equipment' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Cохранить изменения', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


