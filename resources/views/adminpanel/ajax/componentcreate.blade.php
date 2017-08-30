
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Добавление нового комплектующего
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/components/save', 'method' => 'post', 'id' => 'form-component-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='component-equipment'>Оборудование</label>
            {!! Form::select('component[equipment]', $equipments, '', array('class' => 'form-control chosen-select', 'id' => 'component-equipment')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-name'>Название cоставляющего</label>
            {!! Form::text('component[name]', '', array('class' => 'form-control', 'id' => 'component-name')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-number'>Каталожный номер</label>
            {!! Form::text('component[number]', '', array('class' => 'form-control', 'id' => 'component-number')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-count'>Количество на складе</label>
            {!! Form::text('component[count]', 0, array('class' => 'form-control', 'id' => 'component-count')) !!}

        </div>
        
        <div class='form-group'>
            <label class="control-label" for='component-count_in'>Количество в оборудование</label>
            {!! Form::text('component[count_in]', 1, array('class' => 'form-control', 'id' => 'component-count_in')) !!}

        </div>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/components' data-name='components' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            {!! Form::submit('Добавить комплектующее', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


