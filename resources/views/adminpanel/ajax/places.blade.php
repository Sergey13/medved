<div class="col-md-10 col-md-offset-1">

    @include('responsemessage')

    <h3 class="page-title">
        Список мест для установки оборудования
    </h3>

    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Название</th>
            <th colspan="2">
                @if(Auth::user()->can('add'))
                    <a class="btn btn-primary btn-sm btn-block" data-href='/places/create'><i
                                class="fa fa-plus-circle"></i> Добавить</a>
                @endif
            </th>
        </tr>
        <tr>
            <th>
                <a class='btn btn-link reset-filtr hide' data-href='/places' title="Сбросить фильтр">
                    <i class='fa fa-close text-danger'></i>
                </a>
            </th>
            <th>
                <input type="text" name="name" class="form-control">
            </th>
            <th colspan="2">
                <button class="btn btn-primary btn-sm btn-block" id='search-place'>
                    <i class="fa fa-search"></i> Найти
                </button>
            </th>
        </tr>
        </thead>
        <tbody id='place-list'>
        @foreach($places as $key => $place)
            <tr>
                <td>{{($key+1)}}</td>
                <td>
                    {{$place->name}}
                </td>
                @if(Auth::user()->can('edit'))
                    <td class='text-center'>
                        <a data-href="/places/{{$place->id}}/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить данные">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class='text-center'>
                        <button class='btn btn-danger' data-id='delete-item' data-href='/places/{{$place->id}}' data-toggle='tooltip' data-placement='bottom' title='Удалить запись'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(count($places) == 0)
        <div class='alert alert-info'>
            Список пуст
        </div>
    @endif
</div>

<script type='text/html' id='place-item-template'>
    <td>
<%= model.key %>
</td>
<td>
   <%= model.name %>
</td>
@if(Auth::user()->can('edit'))
<td class='text-center'>
   <a data-href="/places/<%= model.id %>/edit" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить запись">
       <i class="fa fa-edit"></i>
   </a>
</td>
<td class='text-center'>
   <button class='btn btn-danger' data-id='delete-item' data-href='/places/<%= model.id %>' data-toggle='tooltip' data-placement='bottom' title='Удалить запись'>
                           <i class='fa fa-trash'></i>
   </button>
</td>
@endif
</script>