<div class="col-md-10 col-md-offset-1">
    <div class="col-md-12 row">
        @include('responsemessage')
        <h3 class="page-title block-inline block-left">

            <a class="btn btn-primary" data-href='/components' data-name='equipment' data-way='back'><i
                        class="fa fa-arrow-left"></i> Назад</a>&nbsp;&nbsp;
            Вид и учет ремонта для комплектующего "{{$component->name}}"
        </h3>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Вид ремонта</th>
            <th>Дата</th>
            <th>Примечание</th>
            <th>Исполнитель</th>
            <th>
                @if(Auth::user()->can('add'))
                    <a data-href="/record/component/{{$component->id}}/create" class="btn btn-link"
                       data-toggle="tooltip" data-placement="bottom" title="Добавить новую запись в учет">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/record/component/{{$component->id}}'
                   title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="type" class="form-control">
            </th>
            <th>
                <input type="text" name="date" class="form-control datepicker-field">
            </th>
            <th></th>
            <th>
                <input type="text" name="performer" class="form-control">
            </th>
            <th colspan="3">
                <button class="btn btn-link" id='search-record'>
                    <i class="fa fa-search"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody id='record-list'>
        @foreach($record as $key => $item)
            <tr>
                <td>
                    {{($key + 1)}}
                </td>
                <td>
                    {{$item->type_of_repair->type}}
                </td>
                <td>
                    {{$item->date_format}}
                </td>
                <td>
                    @if(isset($item->comment))
                        {{$item->comment }}
                    @endif
                </td>
                <td>
                    {{$item->performer->fio}}
                </td>
                <td>
                    @if(Auth::user()->can('edit'))
                        <button class='btn btn-danger' data-id='delete-item'
                                data-href='/record/component/{{$component->id}}/{{$item->id}}/delete'
                                data-toggle='tooltip' data-placement='bottom' title='Удалить запись из учета'>
                            <i class='fa fa-trash'></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(count($record) == 0)
        <div class="alert alert-info">
            Записи отсутствуют!
        </div>
    @endif
</div>


<script type='text/html' id='record-item-template'>
    <td>
<%= model.key %>
</td>
<td>
<%= model.type_of_repair.type %>
</td>
<td>
<%= model.date_format %>
</td>
<td>
<% if(model.comment !== null) { %>
<%= model.comment %>
<% } %>
</td>
<td>
<%= model.performer.fio %>
</td>
<td>
@if(Auth::user()->can('edit'))
<button class='btn btn-danger' data-id='delete-item' data-href='/record/component/<%= model.component.id %>/<%= model.id %>/delete' data-toggle='tooltip' data-placement='bottom' title='Удалить запись из учета'>
    <i class='fa fa-trash'></i>
</button>
@endif
</td>
</script>