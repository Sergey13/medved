
<div class="row col-md-10 col-md-offset-1">

    <h3 class="page-title text-center">
        Документы по оборудованию "{{$equipment->name}}"
    </h3>

    <div class='row col-sm-12 documents'>
        @if(isset($equipment->documents) && count($equipment->documents) != 0)
        <?php $i = 0; ?>
        @foreach($equipment->documents as $document)
        <div class='document'>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <div class='document-name' data-toggle='tooltip' data-placement='right' title='{{$document->name}}.{{$document->type}}'>{{$document->name}}.{{$document->type}}</div>
                </div>
                <div class='panel-body text-center'>
                    @if($document->type == 'png' || $document->type == 'jpg' || $document->type == 'jpeg')
                    <a class='fancybox' role='group' href='{{$document->link}}'>
                        <img src="{{$document->link}}">
                    </a>
                    @else
                    <div class='doc-file text-success'>
                        <i class='{{$document->label}}'></i>
                    </div>
                    @endif
                </div>
                <div class='panel-footer'>
                    <a href='{{$document->link}}'><i class='fa fa-download'></i></a>
                    
                    <button type="button" class="btn btn-danger btn-sm" data-id="delete-file-fully" data-full_delete='true' data-href="/equipment/file/{{$document->id}}" data-toggle="tooltip" data-placement="bottom" title="Удалить файл">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
         @endforeach
        @else
        <p>
            Документы отсутствуют
        </p>
        @endif
    </div>

</div>


