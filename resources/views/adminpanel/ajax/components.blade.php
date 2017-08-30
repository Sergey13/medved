<div class="col-md-10 col-md-offset-1">
    
    @include('responsemessage')
    
    <h3 class="page-title">
        <a class="btn btn-primary" data-href='/equipment' data-name='equipment' data-way='back'><i class="fa fa-arrow-left"></i> Назад</a>&nbsp;&nbsp; Составляющие для оборудования "{{$equipment->name}}"
    </h3>
    @include('adminpanel.ajax.tablecomponents')
</div>
