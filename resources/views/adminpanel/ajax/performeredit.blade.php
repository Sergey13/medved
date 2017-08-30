
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Регистрация нового исполнителя
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/performers/'.$performer->id.'/update', 'method' => 'put', 'id' => 'form-performer-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='performer-fio'>ФИО</label>
            {!! Form::text('performer[fio]', $performer->fio, array('class' => 'form-control', 'id' => 'performer-phone')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='performer-phone'>Контактный телефон</label>
            {!! Form::text('performer[phone]', $performer->phone, array('class' => 'form-control phone-mask', 'id' => 'performer-phone')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='performer-date_of_employment'>Дата оформления</label>
            {!! Form::text('performer[date_of_employment]', $performer->date_of_employment, array('class' => 'form-control datepicker-field', 'id' => 'performer-date_of_employment')) !!}
        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/performers' data-name='performers' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Cохранить изменения', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>