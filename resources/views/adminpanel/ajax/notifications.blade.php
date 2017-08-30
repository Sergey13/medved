<div class="col-md-10 col-md-offset-1">
    <h3 class="page-title">
        Напоминания
    </h3>
    <button class="btn btn-link" data-toggle="close-block" data-id="#block-notifications"><i class="fa fa-close"></i></button>
    <table class="table">
        @foreach($notifications as $item)
        <tr class='parent-row'>
            <td>
                <strong>{{$item->equipment->name}}:</strong> на {{$item->date_format}} заплонировано {{$item->type_of_repair->type}}

            </td>
            @if(Auth::user()->can('edit'))
            <td>
                {!! Form::open(array('url' => '/schedule/notifications/'.$item->id, 'method' => 'put', 'id' => 'form-notification-update', 'class' => 'ajax-form'))!!}
                {!! Form::hidden('notification[read]', 1)!!}
                <button type='submit' class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Закрыть напоминание навсегда">
                    <i class="fa fa-close"></i>
                </button>
                {!! Form::close()!!}
            </td>
            @endif
        </tr>
        @endforeach
    </table>
    @if(count($notifications) == 0)
    <div class="notifications-empty">
        <p>Список пуст</p>
    </div>
    @endif
</div>


