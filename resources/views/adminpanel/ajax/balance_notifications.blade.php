<div class="col-md-10 col-md-offset-1">
    <h3 class="page-title">
        Необходимо пополнить склад
    </h3>
    <button class="btn btn-link" data-toggle="close-block" data-id="#balance-notifications"><i class="fa fa-close"></i></button>
    <table class="table">
        @foreach($notifications as $key => $list)
        @foreach($list as $item)
        <tr class='parent-row'>
            <td>
                <strong>{{$key}}:</strong> {{$item->name}} - осталось {{$item->count}} шт.

            </td>
             <td class="close_not" onClick="var text=$(this).prev().text(); $(this).prev().hide(); $(this).hide(); closex(text);">
                 <i class="fa fa-close "  style="color:red"></i>

            </td>
           
        </tr>
        @endforeach
        @endforeach
    </table>
    @if(count($notifications) == 0)
    <div class="notifications-empty">
        
    </div>
    @endif
</div>


