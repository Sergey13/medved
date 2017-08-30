
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Добавление новой записи в учет оборудования "{{$equipment->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/record/equipment/'.$equipment->id.'/save', 'method' => 'post', 'id' => 'form-record_equipment-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='record_equipment-performer'>Исполнитель</label>
            {!! Form::select('record_equipment[performer][]', $performers, '', array('multiple'=>'multiple', 'class' => 'form-control chosen-select', 'id' => 'record_equipment-performer')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_equipment-type'>Тип ремонта</label>
            {!! Form::select('record_equipment[type_of_repair]', $types_of_repair, '', array('class' => 'form-control chosen-select', 'id' => 'record_equipment-type')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_equipment-date'>Дата ремонта</label>
            {!! Form::text('record_equipment[date]', '', array('class' => 'form-control datepicker-field', 'id' => 'record_equipment-date')) !!}
        </div>
         <div class="form-group">
            <label class="control-label" for='record_equipment-schedule'>Плановый/Внеплановый</label>
            <input type="radio" name="record_equipment[schedule]" value="planned" data-toggle='show' data-id='#record-schedule_id' checked="checked"> Плановый 
            <input type="radio" name="record_equipment[schedule]" value="unplanned" data-toggle='show' data-id='#record-schedule_id'> Внеплановый
        </div>
        <div class='form-group' id="record-schedule_id">
            <label class="control-label" for='record_equipment-schedule'>Выберите дату планового ремонта из списка графика ППР</label>
            <select class='chosen-select' id='record_equipment-schedule' name='record_equipment[schedule_id]'>
                <option value='' selected="selected">____________________</option>
                @foreach($schedule as $item)
                <option value='{{$item->id}}' data-type='{{$item->type_of_repair_id}}'>{{$item->date_format}}</option>
                @endforeach
            </select>
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_equipment-comment'>Примечание</label>
            {!! Form::text('record_equipment[comment]', '', array('class' => 'form-control', 'id' => 'record_equipment-comment')) !!}
        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/record/equipment/{{$equipment->id}}' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Добавить новую запись', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


