<div class="col-md-10 col-md-offset-1">
    
    <div class="col-md-12 row">
        @include('responsemessage')
        <h3 class="page-title text-center">
            Заполнение графика ППР для оборудования "{{$equipment->name}}" на новый год
        </h3>
    </div>
    {!! Form::open(array('url' => '/schedule/equipment/'.$equipment->id.'/save', 'method' => 'post', 'id' => 'form-schedule-add', 'class' => 'form ajax-form')) !!}
    <div class="col-md-12 row">
        <div class="form-group form-inline text-center">
            <label class="control-label" for='schedule-year'>Год</label>
            {!! Form::text('schedule[year]', '', array('class' => 'form-control', 'id' => 'schedule-year')) !!}
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped schedule-change" id='schedule-day'>
        <thead>
            <tr>
                <th>
                    {!! Form::text('schedule[day][01]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Января
                </th>
                <th>
                    {!! Form::text('schedule[day][02]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Февраля
                </th>
                <th>
                    {!! Form::text('schedule[day][03]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Марта
                </th>
                <th>
                    {!! Form::text('schedule[day][04]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Апреля
                </th>
                <th>
                    {!! Form::text('schedule[day][05]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Мая
                </th>
                <th>
                    {!! Form::text('schedule[day][06]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Июня
                </th>
                <th>
                    {!! Form::text('schedule[day][07]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Июля
                </th>
                <th>
                    {!! Form::text('schedule[day][08]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Августа
                </th>
                <th>
                    {!! Form::text('schedule[day][09]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Сентября
                </th>
                <th>
                    {!! Form::text('schedule[day][10]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Октября
                </th>
                <th>
                    {!! Form::text('schedule[day][11]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Ноября
                </th>
                <th>
                    {!! Form::text('schedule[day][12]', '', array('class' => 'form-control day-field', 'placeholder' => '__')) !!}
                    Декабря
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                   {!! Form::select('schedule[date][01]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][02]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                   {!! Form::select('schedule[date][03]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][04]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][05]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                   {!! Form::select('schedule[date][06]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][07]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][08]', $types_of_repair, '', array('class' => 'form-control')) !!}                </td>
                <td>
                    {!! Form::select('schedule[date][09]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][10]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][11]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
                <td>
                    {!! Form::select('schedule[date][12]', $types_of_repair, '', array('class' => 'form-control')) !!}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group text-center">
        <a class='btn btn-danger' data-href='/schedule'>
            <i class='fa fa-arrow-left'></i> Отмена
        </a>
        {!! Form::submit('Сохранить', array('class' => 'btn btn-primary'))!!}
    </div>
    {!! Form::close() !!}
</div>

