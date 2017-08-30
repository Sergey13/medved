<div class="col-md-10 col-md-offset-1">
    @include('responsemessage')
    <h3 class="page-title">
        Список и место установки оборудования
    </h3>
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Место установки</th>
            <th>Оборудование</th>
            <th>Дата установки</th>
            <th @if(Auth::user()->can('edit')) colspan="2" @endif>Паспорт изделия</th>
            <th>Инв. №</th>
            <th colspan="4">
                @if(Auth::user()->can('add'))
                    <a class="btn btn-primary btn-sm btn-block" data-href='/equipment/create'><i
                                class="fa fa-plus-circle"></i> Добавить</a>
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/equipment' title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="place" class="form-control">
            </th>
            <th>
                <input type="text" name="name" class="form-control">
            </th>
            <th>
                <input type="text" name="installation_date" class="form-control datepicker-field">
            </th>
            <th @if(Auth::user()->can('edit')) colspan="2" @endif>
                <input type="text" name="pasport" class="form-control">
            </th>
            <th>
                <input type="text" name="inventory_number" class="form-control">
            </th>
            <th colspan="4">
                <button class="btn btn-primary btn-sm btn-block" id='search-equipment'>
                    <i class="fa fa-search"></i> Найти
                </button>
            </th>
        </tr>
        </thead>
        <tbody id='equipment-list'>
        <?php $index=1; ?>
        @foreach($equipments as $key => $equipment)
            <tr>
                <td>{{($index++)}}</td>
                <td>{{$equipment->place->name}}</td>
                <td>
                    <a data-href='/equipment/{{$equipment->id}}/components' title='Просмотреть составляющие'
                       data-toggle="tooltip" data-placement="left">
                        <i class='flaticon-marketing8'></i>
                        {{$equipment->name}}
                    </a>
                </td>
                <td>
                    {{$equipment->installation_date_format}}
                </td>

                <td>
                    @if(Auth::user()->can('edit'))
                        <a data-href="/equipment/{{$equipment->id}}/upload" class="btn btn-link" data-toggle='tooltip'
                           data-placement='bottom' title='Загрузить документы для оборудования'>
                            <i class="fa fa-upload"></i>
                        </a>
                    @endif
                    @if(isset($equipment->documents) && count($equipment->documents) != 0)
                        <a class="btn btn-link" data-href="/equipment/documents/{{$equipment->id}}"
                           data-toggle='tooltip' data-placement='left' title='Просмотреть все документы'>
                            <i class='fa fa-archive'></i>
                        </a>
                    @endif
                </td>

                <td>

                    @if(isset($equipment->pasport) && $equipment->pasport != '')
                        {{$equipment->pasport}}
                    @endif

                </td>
                <td>
                    {{$equipment->inventory_number}}
                </td>
                <td>
                    <a data-href="/record/equipment/{{$equipment->id}}" class="btn btn-link" data-toggle='tooltip'
                       data-placement='bottom' title="Учет ремонта">
                        <i class="fa fa-wrench"></i>
                    </a>
                </td>
                <td>
                    <a data-href="/schedule/equipment/{{$equipment->id}}" class="btn btn-link" data-toggle='tooltip'
                       data-placement='bottom' title='Календарь ППР'>
                        <i class="flaticon-calendar68"></i>
                    </a>
                </td>
                @if(Auth::user()->can('edit'))
                    <td>
                        <a data-href="/equipment/{{$equipment->id}}/edit" class="btn btn-link" data-toggle='tooltip'
                           data-placement='bottom' title='Изменть данные'>
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <button class='btn btn-danger' data-id='delete-item' data-href='/equipment/{{$equipment->id}}'
                                data-toggle='tooltip' data-placement='bottom' title='Удалить запись об оборудование'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @if(count($equipments) == 0)
        <div class='alert alert-info'>
            Комплектующие отсутствуют
        </div>
    @endif
</div>


<script type='text/html' id='equipment-item-template'>

    <td>
<%= model.key %>
</td>
<td>
<%= model.place.name %>
</td>
<td>
<a data-href='/equipment/<%= model.id %>/components' title='Cоставляющие' data-toggle="tooltip" data-placement="left" >
    <i class='flaticon-marketing8'></i>
    <%= model.name %>
</a>
</td>
<td>
<%= model.installation_date_format %>
</td>
<td>
<% if(model.documents !== null && model.documents !== 0) { %>
<a class="btn btn-link" data-href="/equipment/documents/<%= model.id %>" data-toggle='tooltip' data-placement='left' title='Просмотреть все документы'>
    <i class='fa fa-eye'></i>
</a>
<% } %>
<% if(model.pasport !== null && model.pasport !== '') { %>
   <%= model.pasport %>
<% } %>
</td>
<td>
<%= model.inventory_number %>
</td>
<td>
<a data-href="/schedule/equipment/<%= model.id %>/record" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Учет ремонта">
    <i class="fa fa-wrench"></i>
</a>
</td>
<td>
<a data-href="/schedule/equipment/<%= model.id %>" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Календарь ППР">
    <i class="flaticon-calendar68"></i>
</a>
</td>
@if(Auth::user()->can('edit'))
<td>
<a data-href="/equipment/<%= model.id %>/upload" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title='Загрузить документы для оборудования'>
    <i class="fa fa-upload"></i>
</a>
</td>
<td>
<a data-href="/equipment/<%= model.id %>/edit" class="btn btn-link" data-toggle='toltip' data-placement='bottom' title='Изменть данные'>
    <i class="fa fa-edit"></i>
</a>
</td>
<td>
<button class='btn btn-danger' data-id='delete-item' data-href='/equipment/<%= model.id %>' data-toggle='tooltip' data-placement='bottom' title='Удалить запись oб оборудование'>
    <i class='fa fa-trash'></i>
</button>
</td>
@endif
</script>