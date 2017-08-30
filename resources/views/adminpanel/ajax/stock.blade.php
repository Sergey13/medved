
    <div class="col-md-10 col-md-offset-1">
        @include('responsemessage')
        <h3 class="page-title">
            Склад
        </h3>
        <div class="row">
            <div class="col-md-2">
                @include('adminpanel.ajax.stock_menu')
            </div>
            <div class="col-md-10">
                <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" <?php if((isset($request->type) && $request->type == 'incoming') || !isset($request->type)): echo "class='active'"; endif; ?>>
                <a href="#incoming" role="tab" data-toggle="tab" aria-controls="incoming">
                    Приход
                </a>
            </li>
            <li role="presentation" <?php if(isset($request->type) && $request->type == 'expense') : echo "class='active'";  endif; ?>>
                <a href="#expense" role="tab" data-toggle="tab" aria-controls="expense">
                    Расход
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane <?php if((isset($request->type) && $request->type == 'incoming') || !isset($request->type)): echo "active"; endif; ?>"  role="tabpanel" id="incoming" aria-labelledby="incoming-tab">
                @include('adminpanel.ajax.stockincoming')
            </div>
            <div class="tab-pane <?php if(isset($request->type) && $request->type == 'expense') : echo "active";  endif; ?>"  role="tabpanel" id="expense" aria-labelledby="expense-tab">
                @include('adminpanel.ajax.stockexpense')
            </div>
        </div>
            </div>
        </div>
        
        
        
    </div>

