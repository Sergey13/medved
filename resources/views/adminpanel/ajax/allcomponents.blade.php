<div class="col-md-10 col-md-offset-1">
    
    @include('responsemessage')
    @if(isset($parent_component))
    <h3 class="page-title">
        @if(is_null($parent_component->parent_id))
        <a class="btn btn-primary" data-href='/components' data-name='equipment' data-way='back'><i class="fa fa-arrow-left"></i> Назад</a> Весь список составляющих для "{{$parent_component->name}}"
        @else
        <a class="btn btn-primary" data-href='/components/{{$parent_component->parent_id}}/inside' data-name='equipment' data-way='back'><i class="fa fa-arrow-left"></i> Назад</a> Весь список комплектующих для "{{$parent_component->name}}"
        @endif
    </h3>
     @else
     <h3 class="page-title">
        Весь список составляющих
    </h3>
     @endif
    @include('adminpanel.ajax.tablecomponents')
</div>