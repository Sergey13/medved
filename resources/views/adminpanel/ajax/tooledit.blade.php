
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Изменение данных для инструмента "{{$tool->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/tools/'.$tool->id.'/update', 'method' => 'put', 'id' => 'form-tool-update', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='tool-name'>Название инструмента</label>
            {!! Form::text('tool[name]', $tool->name, array('class' => 'form-control', 'id' => 'tool-name')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for="tool-balance_notification">Изменить остаток для напоминания</label>
            {!! Form::text('tool[balance_notification]', $tool->balance_notification, array('class' => 'form-control', 'id' => 'tool-balance_notification')) !!}
        </div>
        <div class='form-group text-center'>
             {!! Form::hidden('tool[count]', $tool->count) !!}
            <a class="btn btn-danger" data-href='/stock/tools' data-name='components' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Сохранить изменения', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


