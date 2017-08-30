<div class="col-md-10 col-md-offset-1">
    @include('responsemessage')
    <h3 class="page-title">
        Исполнители
    </h3>
    <table class='table table-hover table-bordered table-striped'>
        <thead>
            <tr>
                <th>№</th>
                <th>
                    ФИО
                </th>
                <th>
                    Телефон
                </th>
                <th>
                    Оформлен
                </th>
                <th colspan="2">
                    @if(Auth::user()->can('add-performer'))
                    <a data-href='/performers/create' class="btn btn-primary btn-sm btn-block">
                        <i class="fa fa-plus-circle"></i> Добавить
                    </a>
                    @endif
                </th>
            </tr>
              <tr>
                    <th>
                        <a class='btn btn-link reset-filtr hide' data-href='/performers' title="Сбросить фильтр">
                            <i class='fa fa-close text-danger'></i>
                        </a>
                    </th>
                    <th>
                        <input type="text" name="fio" class="form-control">
                    </th>
                    <th></th>
                    <th></th>
                    <th colspan="2">
                        <button class="btn btn-primary btn-sm btn-block" id='search-performer'>
                            <i class="fa fa-search"></i> Найти
                        </button>
                    </th>
                </tr>
        </thead>
        <tbody id='performer-list'>
            @foreach($performers as $key => $performer)
            <tr>
                <td>
                    {{($key+1)}}
                </td>
                <td>
                    {{$performer->fio}}
                </td>
                <td>
                    {{$performer->phone}}
                </td>
                <td>
                    {{$performer->employment}}
                </td>
                @if(Auth::user()->can('edit-performer'))
                <td class='text-center' style="max-width: 80px;">
                    <a data-href='/performers/{{$performer->id}}/edit' class='btn btn-link'>
                        <i class='fa fa-edit'></i> Изменить
                    </a>
                </td>
                @endif
                @if(Auth::user()->can('delete-performer'))
                <td class='text-center' style="max-width: 80px;">
                    <button data-id='delete-item' data-href='/performers/{{$performer->id}}' class='btn btn-danger btn-block'>
                        <i class='fa fa-trash'></i> Удалить
                    </button>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(count($performers) == 0)
    <div class='alert alert-info'>
        В системе еще нет ни одного исполнителя
    </div>
    @endif
</div>




<script type='text/html' id='performer-item-template'>
    <td>
        <%= model.key %>
    </td>
    <td>
        <%= model.fio %>
    </td>
    <td>
        <%= model.phone %>
    </td>
    <td>
        <%= model.employment %>
    </td>
    @if(Auth::user()->can('edit-performer'))
    <td class='text-center' style="max-width: 80px;">
        <a data-href='/performers/<%= model.id %>/edit' class='btn btn-link'>
            <i class='fa fa-edit'></i> Изменить
        </a>
    </td>
    @endif
    @if(Auth::user()->can('delete-performer'))
    <td class='text-center' style="max-width: 80px;">
        <button data-id='delete-item' data-href='/performers/<%= model.id %>' class='btn btn-danger btn-block'>
            <i class='fa fa-trash'></i> Удалить
        </button>
    </td>
    @endif
</script>