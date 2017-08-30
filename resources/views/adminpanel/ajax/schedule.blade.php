<div class="col-md-10 col-md-offset-1">
    <div class="col-md-12 no-padd">
        @include('responsemessage')
        <h3 class="page-title block-inline block-left">
            График ППР
        </h3>

        <div class="form-inline page-sort block-left">
            <select class="form-control" data-href='/schedule' id='schedule-year-select'>
                @foreach($years as $year)
                    <option value='{{$year}}' @if($current_year == $year) selected='selected' @endif>
                        {{$year}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class='col-sm-4 noprint'>
            <div class='form-group page-sort'>
                <select class='chosen-select chosen-control' id='select-equipment'>
                    <option value="">Найти оборудование</option>
                    @foreach($equipments as $equipment)
                        <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-primary block-right print-btn noprint">
            <a href="javascript:(print());" class="text-white">
                <i class="fa fa-print"></i> Распечатать график
            </a>
        </button>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Оборудование</th>
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
            <th colspan="4" class="noprint">
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $numberRow = 0; ?>
        @foreach($equipments as $equipment)
            <tr id='equipment-{{$equipment->id}}'>
                <td>
                    <?php $numberRow++; ?>
                    {{$numberRow}}
                </td>
                <td>
                    <a data-href="/schedule/equipment/{{$equipment->id}}">
                        {{$equipment->name}}
                    </a>
                </td>
                @if(isset($equipment->schedule))
                    @for($i = 1 ; $i <= 12; $i++)
                        <td>
                            <?php if ($i < 10) : $month = '0' . $i;
                            else: $month = (string)$i; endif; ?>
                            @if(isset($equipment->schedule[$month]))
                                @if($equipment->schedule[$month]['performed'] == '1') <span class="td-success"
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="bottom"
                                                                                            title="Выполнен"> @endif
                                    @if(isset($equipment->schedule[$month]['type']))
                                        {{$equipment->schedule[$month]['type']}}
                                    @endif
                                    @if($equipment->schedule[$month]['performed'] == '1') </span> @endif
                            @endif
                        </td>
                    @endfor
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                <td class="noprint">
                    <a data-href="/record/equipment/{{$equipment->id}}" class="btn btn-link" data-toggle='tooltip'
                       data-placement='bottom' title="Учет ремонта">
                        <i class="fa fa-wrench"></i>
                    </a>
                </td>
                @if(Auth::user()->can('edit'))
                    <td class="noprint">
                        <a class='btn btn-link'
                           data-href='/schedule/equipment/{{$equipment->id}}/edit?year={{$current_year}}'
                           data-toggle='tooltip' data-placement='bottom'
                           title="Изменить график за {{$current_year}} год">
                            <i class='fa fa-edit'></i>
                        </a>
                    </td>
                    <td class="noprint">
                        <a data-href="/schedule/equipment/{{$equipment->id}}/create" class="btn btn-link"
                           data-toggle="tooltip" data-placement="bottom" title="Заполнить график на новый год">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    </td>
                    <td class="noprint">
                        <button class='btn btn-danger' data-id='delete-item'
                                data-href='/schedule/equipment/{{$equipment->id}}/{{$current_year}}/delete'
                                data-toggle='tooltip' data-placement='bottom'
                                title='Удалить график за {{$current_year}} год'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
