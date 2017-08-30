<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>№</th>
            <th>Дата</th>
            <th>Приход Наименование</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Текущее количество</th>
            <th colspan="2">
                @if(Auth::user()->can('edit-stock'))
                <a data-href='/stock/create?type=incoming&list=<?php echo $list; ?><?php if(isset($component)): echo '&component='.$component; endif;?>' class="btn btn-primary btn-sm btn-block">
                    <i class="fa fa-plus-circle"></i> Добавить
                </a>
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/stock<?php if(isset($component)): echo '/component/'.$component; else: echo '/'.$list.'s'; endif;?>?type=incoming' title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="date" class="form-control datepicker-field">
            </th>
            <th>
                <input type="text" name="{{$list}}" class="form-control">
            </th>
            <th colspan="3">

            </th>
            <th colspan="2">
                <input type='hidden' name='type' value="incoming">
                
                <button class="btn btn-primary btn-sm btn-block" id='search-stock_incoming' data-type="{{$list}}">
                    <i class="fa fa-search"></i> Найти
                </button>
                
            </th>
        </tr>
    </thead>
    <tbody id='stock_incoming-list'>
        <?php $i = 0; ?>
        @foreach($stock_incoming as $key => $item)
        <?php $i++; ?>
        <tr>
            <td>
                {{$i}}
            </td>
            <td>{{$item->date_full}}</td>
            <td>{{$item->$list->name}}</td>
            <td>
                {{$item->count}}
            </td>
            <td>{{$item->unit_name}}</td>
            <td>{{$item->$list->count}}</td>
            @if(Auth::user()->can('edit'))
            <td>
                <a data-href="/{{$list}}s/{{$item->$list->id}}/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить данные для инструмента">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
            <td>
                <button class='btn btn-danger' data-id='delete-item' data-href='/{{$list}}s/{{$item->$list->id}}' data-toggle='tooltip' data-placement='bottom' title='Удалить записи об инструменте'>
                    <i class='fa fa-trash'></i>
                </button>
            </td>
            @else
            <td colspan="2"></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@if(count($stock_incoming) == 0)
<div class="alert alert-info">
    Список пуст
</div>
@endif


<script type='text/html' id='stock_incoming-item-template'>
    <td>
        <%= model.key %>
    </td>
    <td>
        <%= model.date_full %>
    </td>
    <td>
        <%= model.<?php echo $list; ?>.name %>
    </td>
    <td>
        <%= model.count %>
    </td>
    <td>
        <%= model.unit_name %>
    </td>
    <td>
        <%= model.<?php echo $list; ?>.count %>
    </td>
    @if(Auth::user()->can('edit'))
    <td>
        <a data-href="/<?php echo $list . 's'; ?>/<%= model.<?php echo $list; ?>.id %>/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить данные для инструмента">
                    <i class="fa fa-edit"></i>
        </a>
    </td>
    <td>
        <button class='btn btn-danger' data-id='delete-item' data-href='/<?php echo $list . 's'; ?>/<%= model.<?php echo $list; ?>.id %>' data-toggle='tooltip' data-placement='bottom' title='Удалить записи об инструменте'>
                    <i class='fa fa-trash'></i>
        </button>
    </td>
    @else
    <td></td>
    @endif
</script>