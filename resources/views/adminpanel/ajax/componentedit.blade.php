
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Изменение данных для составляющего "{{$component->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/components/'.$component->id.'/update', 'method' => 'put', 'id' => 'form-component-update', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='component-equipment'>Оборудование</label>
            {!! Form::select('component[equipment]', $equipments, $component->equipment_id, array('class' => 'form-control chosen-select', 'id' => 'component-equipment')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-parent_id'>Составляющее</label>
            {!! Form::select('component[parent_id]', $components, $component->parent_id, array('class' => 'form-control chosen-select', 'id' => 'component-parent_id')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-name'>Название cоставляющего</label>
            {!! Form::text('component[name]', $component->name, array('class' => 'form-control', 'id' => 'component-name')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-number'>Каталожный номер</label>
            {!! Form::text('component[number_edit]', $component->number, array('class' => 'form-control', 'id' => 'component-number')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='component-count_in'>Количество в оборудование</label>
            {!! Form::text('component[count_in]', $component->count_in, array('class' => 'form-control', 'id' => 'component-count_in')) !!}

        </div>
        <div class='form-group'>
            <label class="control-label" for="component-balance_notification">Изменить остаток для напоминания</label>
            {!! Form::text('component[balance_notification]', $component->balance_notification, array('class' => 'form-control', 'id' => 'component-balance_notification')) !!}
        </div>
        <div class='form-group text-center'>
             {!! Form::hidden('component[count]', $component->count) !!}
             @if(isset($component->parent_id))
             <a class="btn btn-danger" data-href='/components/{{$component->parent_id}}/inside' data-name='components' data-way='back'><i class="fa fa-close"></i> Отмена</a>
             @else
            <a class="btn btn-danger" data-href='/components' data-name='components' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            @endif
            {!! Form::submit('Сохранить изменения', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>

</div>


