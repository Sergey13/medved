
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Добавление новой записи в учет состовляющего "{{$component->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/record/component/'.$component->id.'/save', 'method' => 'post', 'id' => 'form-record_component-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='record_component-performer'>Исполнитель</label>
            {!! Form::select('record_component[performer][]', $performers, '', array('multiple'=>'multiple', 'class' => 'form-control chosen-select', 'id' => 'record_component-performer')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_component-type'>Тип ремонта</label>
            {!! Form::select('record_component[type_of_repair]', $types_of_repair, '', array('class' => 'form-control chosen-select', 'id' => 'record_component-type')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_component-date'>Дата ремонта</label>
            {!! Form::text('record_component[date]', '', array('class' => 'form-control datepicker-field', 'id' => 'record_component-date')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='record_component-comment'>Примечание</label>
            {!! Form::text('record_component[comment]', '', array('class' => 'form-control', 'id' => 'record_component-comment')) !!}
        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/record/component/{{$component->id}}' data-name='equipment' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Добавить новую запись', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


