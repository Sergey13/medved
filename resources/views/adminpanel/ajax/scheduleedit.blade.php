<div class="col-md-10 col-md-offset-1">
    
    <div class="col-md-12 row">
        <h3 class="page-title text-center">
            
            Изменения данных графика ППР для оборудования "{{$equipment->name}}" за {{$current_year}} год
        </h3>
    </div>
    {!! Form::open(array('url' => '/schedule/equipment/'.$equipment->id.'/update', 'method' => 'put', 'id' => 'form-schedule-update', 'class' => 'form ajax-form')) !!}
    {!! Form::hidden('year', $current_year)!!}
    <table class="table table-bordered table-hover table-striped schedule-change">
        <thead>
            <tr>
                <th>
                    {!! Form::text('schedule[day][01]', $equipment->days['01'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Января
                </th>
                <th>
                    {!! Form::text('schedule[day][02]', $equipment->days['02'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Февраля
                </th>
                <th>
                    {!! Form::text('schedule[day][03]', $equipment->days['03'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Марта
                </th>
                <th>
                    {!! Form::text('schedule[day][04]', $equipment->days['04'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Апреля
                </th>
                <th>
                    {!! Form::text('schedule[day][05]', $equipment->days['05'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Мая
                </th>
                <th>
                    {!! Form::text('schedule[day][06]', $equipment->days['06'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Июня
                </th>
                <th>
                    {!! Form::text('schedule[day][07]', $equipment->days['07'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Июля
                </th>
                <th>
                    {!! Form::text('schedule[day][08]', $equipment->days['08'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Августа
                </th>
                <th>
                    {!! Form::text('schedule[day][09]', $equipment->days['09'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Сентября
                </th>
                <th>
                    {!! Form::text('schedule[day][10]', $equipment->days['10'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Октября
                </th>
                <th>
                    {!! Form::text('schedule[day][11]', $equipment->days['11'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Ноября
                </th>
                <th>
                    {!! Form::text('schedule[day][12]', $equipment->days['12'], array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Декабря
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if(isset($equipment->schedule['01']))
                        {!! Form::select('schedule[date][01]', $types_of_repair, $equipment->schedule['01']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][01]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                   @if(isset($equipment->schedule['02']))
                        {!! Form::select('schedule[date][02]', $types_of_repair, $equipment->schedule['02']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][02]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                   @if(isset($equipment->schedule['03']))
                        {!! Form::select('schedule[date][03]', $types_of_repair, $equipment->schedule['03']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][03]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['04']))
                        {!! Form::select('schedule[date][04]', $types_of_repair, $equipment->schedule['04']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][04]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['05']))
                        {!! Form::select('schedule[date][05]', $types_of_repair, $equipment->schedule['05']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][05]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                   @if(isset($equipment->schedule['06']))
                        {!! Form::select('schedule[date][06]', $types_of_repair, $equipment->schedule['06']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][06]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['07']))
                        {!! Form::select('schedule[date][07]', $types_of_repair, $equipment->schedule['07']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][07]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['08']))
                        {!! Form::select('schedule[date][08]', $types_of_repair, $equipment->schedule['08']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][08]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['09']))
                        {!! Form::select('schedule[date][09]', $types_of_repair, $equipment->schedule['09']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][09]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['10']))
                        {!! Form::select('schedule[date][10]', $types_of_repair, $equipment->schedule['10']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][10]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['11']))
                        {!! Form::select('schedule[date][11]', $types_of_repair, $equipment->schedule['11']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][11]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
                <td>
                    @if(isset($equipment->schedule['12']))
                        {!! Form::select('schedule[date][12]', $types_of_repair, $equipment->schedule['12']['id'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('schedule[date][12]', $types_of_repair, '', array('class' => 'form-control')) !!}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group text-center">
        <a class='btn btn-danger' data-href='/schedule?year={{$current_year}}'>
                <i class='fa fa-arrow-left'></i> Отмена
            </a>
            <button type='submit' class='btn btn-primary'>
               Cохранить
            </button>
    </div>
    {!! Form::hidden('schedule[year]', $current_year) !!}
    {!! Form::close() !!}
</div>

