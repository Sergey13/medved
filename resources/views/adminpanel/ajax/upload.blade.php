
<div class="col-md-6 col-md-offset-3">

    <h3 class="page-title text-center">
        Загрузка документов для оборудования "{{$equipment->name}}"
    </h3>

    <div class='row col-sm-12'>
        {!! Form::open(array('url' => '/equipment/'.$equipment->id.'/upload', 'method' => 'post', 'id' => 'form-files-update', 'files' => true, 'class' => 'form ajax-form'))!!}
        <ul class="list-documents">
            
        </ul>
        <input id="fileupload" type="file" name="files[]" data-url="/equipment/file/upload" multiple>
        <div class='form-group text-center'>
            <a class="btn btn-danger" data-href='/equipment' data-name='equipment' data-way='back'><i class="fa fa-close"></i> Отмена</a>
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </div>
        {!! Form::close()!!}
    </div>

</div>


