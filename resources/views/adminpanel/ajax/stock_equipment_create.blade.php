<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Добавление записи в базу склада
    </h3>
        
    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/stock/save', 'method' => 'post', 'id' => 'form-stock-add', 'class' => 'form ajax-form'))!!}
        <div class='form-group'>
            <label class="control-label" for='stock-equipment_id'>Оборудование</label>
            @if(isset($request->equipment))
            {!! Form::select('stock[equipment_id]', $equipments, $request->equipment, array('class' => 'form-control chosen-select', 'id' => 'stock-equipment_id')) !!}
            @else
            {!! Form::select('stock[equipment_id]', $equipments, '', array('class' => 'form-control chosen-select', 'id' => 'stock-equipment_id')) !!}
            @endif
        </div>
        <div class="form-group">
            <label class="control-label" for='stock-type'>Приход/расход</label>
            <input type="radio" name="stock[type]" value="incoming" data-toggle='show' data-id='[data-id="hide_field"]' @if(isset($request->type) && $request->type == 'incoming') checked="checked" @endif> Приход 
            <input type="radio" name="stock[type]" value="expense" data-toggle='show' data-id='[data-id="hide_field"]' id="stock-type" @if(isset($request->type) && $request->type == 'expense') checked="checked" @endif> Расход
        </div>
        
        <div class='form-group <?php if(isset($request->type) && $request->type == "incoming"): echo "hide"; endif;?>' data-id="hide_field">
            <label class="control-label" for='stock-performer_id'>Кому выдано оборудование</label>
            {!! Form::select('stock[performer_id]', $performers, '', array('class' => 'form-control chosen-select', 'id' => 'stock-performer_id')) !!}
        </div>
        <div class='form-group <?php if(isset($request->type) && $request->type == "incoming"): echo "hide"; endif;?>' data-id="hide_field">
            <label class="control-label" for='stock-place'>Место установки</label>
            {!! Form::select('stock[place]', $places, '', array('class' => 'form-control chosen-select', 'id' => 'stock-place')) !!}
            <label class="control-label" for='stock-place_add'>Или добавьте новое место установки</label>
            {!! Form::text('stock[place_add]', '', array('class' => 'form-control', 'id' => 'stock-place_add'))!!}
        </div>

        <div class='form-group'>
            <label class="control-label" for='stock-date'>Дата</label>
            {!! Form::text('stock[date]', '', array('class' => 'form-control datepicker-field', 'id' => 'stock-date')) !!}
        </div>
        <div class='form-group'>
            <label class="control-label" for='stock-count'>Количество</label>
            {!! Form::text('stock[count]', '', array('class' => 'form-control', 'id' => 'stock-count', 'rows' => 3)) !!}
        </div>
        <div class='form-group <?php if(isset($request->type) && $request->type == "expense"): echo "hide"; endif;?>' data-id="hide_field">
            <label class="control-label" for="stock-balance_notification">Укажите остаток для напоминания</label>
            {!! Form::text('stock[balance_notification]', 0, array('class' => 'form-control', 'id' => 'stock-balance_notification')) !!}
        </div>
        <div class='form-group text-center'>
            @if(isset($request->equipment))
                @if(isset($request->type) && $request->type == 'incoming') 
                    <a class="btn btn-danger" data-href='/stock/equipment/{{$request->equipment}}?type=incoming' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @elseif(isset($request->type) && $request->type == 'expense') 
                    <a class="btn btn-danger" data-href='/stock/equipment/{{$request->equipment}}?type=expense' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @else 
                    <a class="btn btn-danger" data-href='/stock/equipment/{{$request->equipment}}' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @endif
                {!! Form::hidden('equipment', $request->equipment)!!}
            @else
                @if(isset($request->type) && $request->type == 'incoming') 
                    <a class="btn btn-danger" data-href='/stock/equipments?type=incoming' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @elseif(isset($request->type) && $request->type == 'expense') 
                    <a class="btn btn-danger" data-href='/stock/equipments?type=expense' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @else 
                    <a class="btn btn-danger" data-href='/stock/equipments' data-name='stock' data-way='back'><i class="fa fa-close"></i> Отмена</a>
                @endif
             @endif
            {!! Form::hidden('list', $request->list)!!}
            {!! Form::submit('Добавить запись', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close()!!}
    </div>
        
</div>

