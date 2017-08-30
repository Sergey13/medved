
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>№</th>
            <th>Комплектующие</th>
            <th>Каталожный №</th>
            <th>Количество</th>
            <th colspan="5">
                @if(Auth::user()->can('add'))
                @if(isset($parent_component)) 
                <a data-href="/components/{{$parent_component->id}}/create" class="btn btn-primary btn-block btn-sm">
                    <i class="fa fa-plus-circle"></i> Добавить
                </a>
                @else
                <a data-href="/components/create" class="btn btn-primary btn-block btn-sm">
                    <i class="fa fa-plus-circle"></i> Добавить
                </a>
                @endif
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/components' title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="name" class="form-control">
            </th>
            <th>
                <input type="text" name="number" class="form-control">
            </th>
            <th style='max-width: 150px;'>
            </th>
            <th colspan="5">
                <button class="btn btn-primary btn-sm btn-block" id='search-component'>
                    <i class="fa fa-search"></i> Найти
                </button>
            </th>
        </tr>
    </thead>
    <tbody id='component-list'>
        @foreach($components as $key => $component)
        <tr>
            <td>{{($key+1)}}</td>
            <td>
                @if(count($component->child) != 0)
                <a data-href='/components/{{$component->id}}/inside' title='Просмотреть состовляющие для комплектующего' data-toggle="tooltip" data-placement="left" >
                    <i class='flaticon-marketing8'></i>  
                    {{$component->name}}
                </a>
                @else
                {{$component->name}}
                @endif
            </td>
            <td>{{$component->number}}</td>
            <td>{{$component->count_in}}</td>
            <td class='text-center'>
                <a data-href="/record/component/{{$component->id}}" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Учет ремонта">
                    <i class="fa fa-wrench"></i>
                </a>
            </td>
            <td class='text-center'>
                <a data-href="/stock/component/{{$component->id}}" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="На складе">
                    <i class="flaticon-commercial15"></i>
                </a>
            </td>
            @if(Auth::user()->can('edit'))
            <td class='text-center'>
                <a data-href="/components/{{$component->id}}/create" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Добавить составляющий компонент">
                    <i class="fa fa-plus-circle"></i>
                </a>
            </td>
            <td class='text-center'>
                <a data-href="/components/{{$component->id}}/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить данные">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
            <td class='text-center'>
                <button class='btn btn-danger' data-id='delete-item' data-href='/components/{{$component->id}}' data-toggle='tooltip' data-placement='bottom' title='Удалить запись о комплектующем'>
                            <i class='fa fa-trash'></i>
                </button>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@if(count($components) == 0) 
<div class='alert alert-info'>
    Комплектующие отсутствуют
</div>
@endif


<script type='text/html' id='component-item-template'>
 <td>
 <%= model.key %>    
 </td>
 <td>
     <% if(model.child != undefined && model.child != null) { %>
     <a data-href='/components/<%= model.id %>/inside' title='Просмотреть составляющие для комплектующего' data-toggle="tooltip" data-placement="left" >
         <i class='flaticon-marketing8'></i>  
         <%= model.name %>
     </a>
     <% } else { %>
     <%= model.name %>
     <% } %>
 </td>
 <td>
     <%= model.number %>
 </td>
 <td>
     <%= model.count_in %>
 </td>
<td class='text-center'>
    <a data-href="/schedule/component/<%= model.id %>/record" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Учет ремонта">
        <i class="fa fa-wrench"></i>
    </a>
</td >
<td class='text-center'>
    <a data-href="/stock/component/<%= model.id %>" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="На складе">
        <i class="flaticon-commercial15"></i>
    </a>
</td>
@if(Auth::user()->can('edit'))
<td class='text-center'>
                <a data-href="/components/<%= model.id %>/create" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Добавить состовляющий компонент">
                    <i class="fa fa-plus-circle"></i>
                </a>
            </td>
<td class='text-center'>
    <a data-href="/components/<%= model.id %>/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить запись">
        <i class="fa fa-edit"></i>
    </a>
</td>
<td class='text-center'>
    <button class='btn btn-danger' data-id='delete-item' data-href='/components/<%= model.id %>' data-toggle='tooltip' data-placement='bottom' title='Удалить запись о комплектующем'>
                            <i class='fa fa-trash'></i>
    </button>
</td>
@endif
</script>