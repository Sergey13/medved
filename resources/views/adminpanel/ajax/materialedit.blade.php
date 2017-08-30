
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Изменение данных для инструмента "{{$material->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/materials/'.$material->id.'/update', 'method' => 'put', 'id' => 'form-material-update', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='material-name'>Название инструмента</label>
            {!! Form::text('material[name]', $material->name, array('class' => 'form-control', 'id' => 'material-name')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='material-unit'>Единица измерения</label>
            {!! Form::select('material[unit]', $units, $material->unit, array('class' => 'form-control', 'id' => 'material-unit')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for="material-balance_notification">Изменить остаток для напоминания</label>
            {!! Form::text('material[balance_notification]', $material->balance_notification, array('class' => 'form-control', 'id' => 'material-balance_notification')) !!}
        </div>
        <div class='form-group text-center'>
             {!! Form::hidden('material[count]', $material->count) !!}
            <a class="btn btn-danger" data-href='/stock/materials' data-name='components' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Сохранить изменения', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


