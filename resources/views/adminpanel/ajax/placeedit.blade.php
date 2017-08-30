
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Редактирование места установки оборудования
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/places/update/' . $place->id, 'method' => 'put', 'id' => 'form-place-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='place-name'>Название</label>
            {!! Form::text('place[name]', $place->name, array('class' => 'form-control', 'id' => 'place-name')) !!}
        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/places' data-name='places' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Изменить', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


