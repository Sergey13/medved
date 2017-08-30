<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>
                №
            </th>
            <th>Дата</th>
            <th>Расход Наименование</th>
            <th>Количество</th>
            <th>Единица измерения</th>
            <th>Текущее количество</th>
            <th>Место установки</th>
            <th>Кому выдано</th>
            <th>
                @if(Auth::user()->can('edit-stock'))
                <a data-href="/stock/create?type=expense&list=<?php echo $list; ?><?php if(isset($component)): echo '&component='.$component; endif;?>" class="btn btn-primary btn-sm btn-block">
                    <i class="fa fa-plus-circle"></i> Добавить
                </a>
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/stock<?php if(isset($component)): echo '/component/'.$component; else: echo '/'.$list.'s'; endif;?>?type=expense' title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="date" class="form-control datepicker-field">
            </th>
            <th>
                <input type="text" name="<?php echo $list; ?>" class="form-control">
            </th>
            <th></th>
            <th>

            </th>
            <th>

            </th>
            <th>
                
            </th>
            <th>
                <input type="text" name="performer" class="form-control">
            </th>
            <th>
                <input type='hidden' name='type' value="expense">
                
                <button class="btn btn-primary btn-sm btn-block" id='search-stock_expense' data-type="{{$list}}">
                    <i class="fa fa-search"></i> Найти
                </button>
                
            </th>
        </tr>
    </thead>
    <tbody id='stock_expense-list'>
        <?php $i = 0; ?>
        @foreach($stock_expense as $key => $item)
        <?php $i++; ?>
        <tr>
            <td>
                {{$i}}
            </td>
            <td>{{$item->date_full}}</td>
            <td>{{$item->$list->name}}</td>
            <td>{{$item->count}}</td>
            <td>{{$item->unit_name}}</td>
            <td>
                {{$item->$list->count}}
            </td>
            <td>@if(isset($item->place)) {{$item->place->name}} @endif</td>
            <td>
               @if(isset($item->performer))
               {{$item->performer->fio}}
               @else
               не указан
               @endif
            </td>
            <td class='center'></td>
        </tr>
        @endforeach
    </tbody>
</table>


@if(count($stock_expense) == 0)
<div class="alert alert-info">
    Список пуст
</div>
@endif


<script type='text/html' id='stock_expense-item-template'>
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
    <td>
        <% if(model.to_place != undefined) { %>
        <%= model.to_place %>
        <% } %>
    </td>
    <td>
        <%= model.performer.fio %>
    </td>
    <td></td>
</script>