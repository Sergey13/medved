<div class="col-md-10 col-md-offset-1">
    @include('responsemessage')
    <h3 class="page-title">
        <a class="btn btn-primary noprint" data-href='/equipment' data-name='equipment' data-way='back'><i class="flaticon-document259"></i> Список</a>&nbsp;&nbsp;
        
        <a class="btn btn-primary noprint" data-href='/schedule' data-name='equipment' data-way='back'><i class="flaticon-calendar68"></i> Календарь</a>&nbsp;&nbsp;
        
        График ППР для "{{$equipment->name}}"
        
        <button class="btn btn-primary block-right print-btn noprint">
            <a href="javascript:(print());" class="text-white">
                <i class="fa fa-print"></i> Распечатать график
            </a>
        </button>
    </h3>
    
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Год</th>
                <th>Январь</th>
                <th>Февраль</th>
                <th>Март</th>
                <th>Апрель</th>
                <th>Май</th>
                <th>Июнь</th>
                <th>Июль</th>
                <th>Август</th>
                <th>Сентябрь</th>
                <th>Октябрь</th>
                <th>Ноябрь</th>
                <th>Декабрь</th>
                <th colspan="3" class="noprint">
                    @if(Auth::user()->can('add'))
                    <a data-href="/schedule/equipment/{{$equipment->id}}/create" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Заполнить график на новый год">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule as $year => $model)
            <tr>
                <td><strong>{{$year}}</strong></td>
                @for($i = 1 ; $i <= 12; $i++)
                <td>
                    <?php if ($i < 10) : $month = '0' . $i; else: $month = (string) $i;
                    endif; ?>
                    @if(isset($model[$month]))
                        @if($model[$month]->performed == '1') <span class="td-success" data-toggle="tooltip" data-placement="bottom" title="Выполнен"> @endif
                            {{isset($model[$month]->type_of_repair) ? $model[$month]->type_of_repair->type : ''}}
                        @if($model[$month]->performed == '1') </span> @endif
                    @endif
                </td>
                @endfor
                <td class="noprint">
                    <a data-href="/record/equipment/{{$equipment->id}}" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Учет ремонта">
                        <i class="fa fa-wrench"></i>
                    </a>
                </td>
                @if(Auth::user()->can('edit'))
                <td class="noprint">
                    <a data-href="/schedule/equipment/{{$equipment->id}}/edit?year={{$year}}" class="btn btn-link" data-toggle='tooltip' data-placement='bottom' title="Изменить график за {{$year}} год">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
                <td class="noprint">
                    <button class='btn btn-danger' data-id='delete-item' data-href='/schedule/equipment/{{$equipment->id}}/{{$year}}/delete' data-toggle='tooltip' data-placement='bottom' title='Удалить график за {{$year}} год'>
                            <i class='fa fa-trash'></i>
                    </button>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if(count($schedule) == 0)
    <div class="alert alert-info">
        Для "{{$equipment->name}}" график не составлен
    </div>
    @endif
</div>
