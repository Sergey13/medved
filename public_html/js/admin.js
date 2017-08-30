
var app = {
    //переменная для хранения загружаемых файлов
    files: {}
}

$(function () {

    initMainMenu();

    init_library($('body'));
    
    app.loading_coffee = $('.load-page.coffee');
    app.loading_cube = $('.load-page.cube');
    app.loading_loader = $('.load-page.loader');
    app.loading = $('.load-page');

    var defaults = {'way': 'forward'}

    var options;
    
    $(window).on('beforeunload', function () {
        if ((window.location.pathname).indexOf('upload') + 1) {
            return "Данные не будут сохранены!";
        } 
    });
    
    $('#form-files-update').submit(function () {
        var data = $(this).serializeArray();
        if (data.length == 0) {
            return false;
        }
    });
    
    $.fn.pageChange = function (params) {

        options = $.extend({}, defaults, options, params);

        var main = function () {

            var that = this;

            $(this).stop();

            $('.no-active').stop();

            if (options.way === 'forward') {

                $(this).animate({'left': '-100%'}, 1000, function () {
                    $(that).css('left', '100%');
                });

                $('.no-active').css('display', 'inline-block');

                $('.no-active').animate({'left': '0'}, 1000, function () {
                    $('.no-active').addClass('active').removeClass('no-active');
                    $(that).addClass('no-active').removeClass('active');
                    $(that).css('display', 'none');
                    $(that).empty();
                });

            } else {

                $(this).animate({'left': '100%'}, 1000);

                $('.no-active').css({'display': 'inline-block', 'left': '-100%'});

                $('.no-active').animate({'left': '0'}, 1000, function () {
                    $('.no-active').addClass('active').removeClass('no-active');
                    $(that).addClass('no-active').removeClass('active');
                    $(that).css('display', 'none');
                    $(that).empty();
                });
            }
        }

        return this.each(main);
    };

    //переход по ссылке 
    $('body').on('click', 'a', function () {
        
        if ((window.location.pathname).indexOf('upload') + 1) {
            var resultConfirm = confirm('Данные не будут сохранены! Вы действительно хотите покинуть эту страницу?');
            if (resultConfirm) {
                cancel_files($(this).data('href'), $(this).data('way'));
            }

            return false;
        } 

        var url = $(this).data('href');

        if (url !== '' && url !== undefined) {

            var way = $(this).data('way');

            link_page(url, way);

            // Предотвращаем дефолтное поведение
            return false;
        }
    });

    
    $('body').on('change', '[type="file"]', function (event) {

        app.files = event.target.files;

    });

    $('body').on('submit', 'form.ajax-form', function (event) {

        if ($(this).find('[type="file"]').length) {

            submit_form_with_file(this, event);

        } else {

            submit_form(this);
        }

        return false;
    });
    
    
    $('body').on('click', '[data-id="delete-item"]', function() {
        
        var result = confirm('Все данные записи и все, что связано с ней, будут удалены без возможности востановления. Вы действительно хотите удалить запись?');
        
        if(result) {
            
            delete_item(this);
            
        }
    });
    
    
    $('body').on('click', '[data-id="delete-file"]', function() {
            
        delete_file(this);
    });
    
    $('body').on('click', '[data-id="delete-file-fully"]', function() {
        
        var result = confirm("Вы действительно хотите безвозвратно удалить файл?");
        
        if (result) {
            delete_file(this);
        }
    });
    
    $('body').on('change', '#record_equipment-schedule', function(){
       
        var type = $('#record_equipment-schedule option:selected').data('type');
        
        $("#record_equipment-type").val(type).change();
        
        $("#record_equipment-type").trigger("chosen:updated");
    });
    
    $('body').on('change', '[data-toggle="show"]', function(){
       
       var id = $(this).data('id');
       
       $(id).toggleClass('hide');
       
    });
    
    $('body').on('change', '#schedule-year-select', function(){
       
        var href = $(this).data('href');
        
        var year = $(this).val();
        
        link_page(href+'?year='+year);
    });
    
    $('body').on('change', '#select-equipment', function(){
       
        var value = $(this).val();
        
        if(value === '') {
            
            $('tbody>tr').removeClass('hide');
            
        } else {

            $('tbody>tr').addClass('hide');
            $('tbody>tr#equipment-'+value).removeClass('hide');
            
        }
        
    });
    
    $('.notifications').on('click', function(){
       $('.block-notifications').show(200); 
    });
    
     $('.empty-stock').on('click', function(){
       $('.balance-notifications').show(200); 
    });
    
    
    
    $('body').on('click', '[data-toggle="close-block"]', function(){
        
        var id = $(this).attr('data-id');
        
        var elem = $('body').find(id);
        
        $('body').find(id).hide(200);
        
        if(id === '#block-notifications') {
            
            var rows = $(id).find('.parent-row');
            
            if(rows.length === 0) {
                $('.notifications').removeClass('animate');
            }
        }
    });
    
    getNotifications();
    
    var checkNotifications = setInterval(getNotifications, 360000);
    
    check_store();
    
    window.onpopstate = function (event) {
        link_page(event.state.path);
    };

});


function check_store() {
    
    $.ajax({
       url: '/stock/notifications',
       method: 'get',
       beforeSend: function(xhr) {
           initToken(xhr);
       },
        success: function(data) {
            $('.balance-notifications').html(data); 
            var rows = $('.balance-notifications').find('.parent-row');
            if(rows.length !== 0) {
                $('.empty-stock').removeClass('hide');
            } else {
                $('.empty-stock').addClass('hide');
            }
        },
    });
    
}

function getNotifications() {
    
    $.ajax({
        url: '/schedule/notifications',
        method: 'get',
        beforeSend: function (xhr) {
            initToken(xhr);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data) {
            $('.block-notifications').html(data); 
            var rows = $('.block-notifications').find('.parent-row');
            if(rows.length !== 0) {
                $('.notifications').addClass('animate');
            } else {
                $('.notifications').removeClass('animate');
            }
        }
    });
}


function initToken(request) {
    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
}

function initMainMenu() {

    var pathname = window.location.pathname;

    var arr = pathname.split('/');

    $('.main-menu').find('a.active').removeClass('active');
    $('a[data-name="' + arr[1] + '"]').addClass('active');
}

function before_send(xhr) {
    
    initToken(xhr);
    
    $(app.loading_loader).show();
    
}

function ajax_error(jqXHR, textStatus, errorThrown)
{
    if (jqXHR.status === 401) {
        location.href = '/login';
    }

    if (jqXHR.status === 404) {
        location.href = '/error';
    }

    if (jqXHR.status === 500) {
        alert('Ошибка сервера!');
    }
}


function link_page(url, way, status, message) {

    $.ajax({
        url: url,
        method: 'get',
        beforeSend: function (xhr) {
            initToken(xhr);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data) {

            if (way === undefined)
                way = 'forward';

            if (url !== window.location.pathname) {
                $('.admin-page.no-active').html(data);
                $('.admin-page.active').pageChange({'way': way});
                window.history.pushState({path:url}, url, url);
                //window.location.href = window.location.origin + url;
            } else {
                $('.admin-page.active').html(data);
            }
            
            if(status !== undefined && message !== undefined) {
                var row = $('.row-'+status);
                $('.row-'+status).removeClass('hide');
                $('.row-'+status).find('.message').html(message);
            }

            initMainMenu();

            init_library($('.admin-page'));

        },
        complete: function() {
            $(app.loading).hide();
        }
    });
}

function submit_form_with_file(that, event) {

    var data = new FormData();
    
    var fieldsFileNames = $(that).find('[type="file"]');

    $.each(app.files, function (key, value)
    {
        data.append($(fieldsFileNames[key]).attr('name'), value);
    });

    var fields = $(that).serializeArray();

    $.each(fields, function (key, item)
    {
        data.append(item.name, item.value);
    });

    hide_errors();

    $.ajax({
        url: $(that).attr('action'),
        type: $(that).attr('method'),
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            before_send(xhr);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data, textStatus, jqXHR) {

            if (data.errors !== undefined) {

                show_errors(data.errors, that);

            } else {
                
                if($(that).attr('action').match(/stock\/create/)) {
                    check_store();
                }
                
                if(data.url !== 'none') {
                
                    link_page(data.url, 'back', 'success', data.message);
                
                } else {
                    
                    $(that).html(data.message);
                    
                    var elem = $(that).parents('.parent-row');
                    
                    setTimeout(function(){
                        $(elem).detach();
                    }, 1000);
                }
            }
        },
        complete: function() {
            $(app.loading).hide();
        }
    });
}


function submit_form(that) {

    var data = $(that).serializeArray();

    hide_errors();

    $.ajax({
        url: $(that).attr('action'),
        method: $(that).attr('method'),
        data: data,
        dataType: 'json',
        beforeSend: function (xhr) {
            before_send(xhr)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data, textStatus, jqXHR) {

            if (data.errors !== undefined) {

                show_errors(data.errors, that);

            } else {
                
                if($(that).attr('action').match(/stock\/save/)) {
                    check_store();
                }
                
                if(data.url !== 'none') {
                
                    link_page(data.url, 'back', 'success', data.message);
                
                } else {
                    
                    $(that).html(data.message);
                    
                    var elem = $(that).parents('.parent-row');
                    
                    setTimeout(function(){
                        $(elem).detach();
                    }, 1000);
                }
            }
        },
        complete: function() {
            $(app.loading).hide()
        }
    });

}

function delete_item(elem) {


    $.ajax({
        url: $(elem).data('href'),
        method: 'delete',
        dataType: 'json',
        beforeSend: function (xhr) {
            before_send(xhr)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data, textStatus, jqXHR) {
            
            if (data.errors !== undefined) {

                show_errors(data.errors, that);

            } else {
                
                link_page(data.url, 'forward', 'success', data.message);
            }
        }
    });
}

function delete_file(elem) {


    $.ajax({
        url: $(elem).data('href'),
        method: 'delete',
        dataType: 'json',
        beforeSend: function (xhr) {
            before_send(xhr)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data, textStatus, jqXHR) {
            
            if(data.status == 'ok') {
                $(elem).parents('.document').detach();
            }
        },
        complete: function() {
            $(app.loading).hide();
        }
    });
}

function cancel_files(url) {
    
    $.ajax({
        url: '/equipment/files/cancel',
        data: {url : url},
        method: 'delete',
        dataType: 'json',
        beforeSend: function (xhr) {
            before_send(xhr)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajax_error(jqXHR, textStatus, errorThrown);
        },
        success: function (data, textStatus, jqXHR) {
            
            if (data.status == 'ok') {
                link_page(data.url, 'forward', 'success');
            }
        },
        complete: function() {
            $(app.loading).hide();
        }
    });
    
}

function show_errors(errors, form) {

    var id = $(form).attr('id');

    var prefix = id.replace('form-', '');
    prefix = prefix.replace('-add', '');
    prefix = prefix.replace('-update', '');
    
    $.each(errors, function (key, value) {
        
        var field;
        
        if(key.indexOf('.') + 1) {
            
            var arr = key.split('.');
            key = arr[0] + '[' + arr[1] + ']';
            
            field = $(form).find('[name="' + prefix + '[' + arr[0] + '][' + arr[1] +']"]');
            
            $(field).addClass('field-error');
            
        } else {
        
            field = $(form).find('[name="' + prefix + '[' + key + ']"]');
            
            $(field).before('<div class="error-field">' + value + '</div>');

            $(field).parents('.form-group').addClass('has-error');
        }

        

    });

    $('.error-field').show(200);

}

function hide_errors() {

    $('.error-field').detach();

    $('.form-group').removeClass('has-error');
    
    $('.form-control').removeClass('field-error');

}



function init_library(elem) {
    
    $(elem).find('.chosen-select').chosen({width: '100%'});

    $(elem).find('.datepicker-field').datepicker({
        dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        monthNamesShort: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        changeMonth: true,
        changeYear: true,
        yearRange: "2000:2030",
        dateFormat: "dd.mm.yy"
    });
    
    $(elem).find('.fancybox').fancybox();
    
    $(elem).find('[data-toggle="tooltip"]').tooltip();
    
    $(elem).find('.phone-mask').mask('+7 (999) 999 99 99');
    
    $(elem).find('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.type == 'image/jpeg' || file.type == 'image/png') {
                    data.context.html('<button type="button" class="btn btn-danger" data-id="delete-file" data-href="'+file.delete_url+'" data-toggle="tooltip" data-placement="bottom" title="Закрыть файл" data-original-title="Закрыть файл">' +
                            '<i class="fa fa-close"></i>' +
                        '</button><img src="'+ file.url +'"> <i class="'+file.label+'"></i> ' + file.name + '<input type="hidden" name="files['+e.timeStamp+']" value="'+file.id+'">');
                } else {
                    data.context.html('<button type="button" class="btn btn-danger" data-id="delete-file" data-href="'+file.delete_url+'" data-toggle="tooltip" data-placement="bottom" title="Закрыть файл" data-original-title="Закрыть файл">' +
                            '<i class="fa fa-close"></i>' +
                        '</button><i class="'+file.label+'"></i> ' + file.name + '<input type="hidden" name="files['+e.timeStamp+']" value="'+file.id+'">');
                }
                
            });
        },
        add: function (e, data) {
            data.context = $('<li/>').text('Загрузка...').addClass('document').appendTo('.list-documents');
            data.submit();
        },
    });
}

function closex(clik) {

	var data=clik;
     //alert(clik);
    regexp1 = "Комплектующие:";
    regexp2 = "- осталось ";
    regexp3 = /\d\sшт./;
    regexp4 = /\d.\d\d\sшт./;
    regexp5 = "Материалы:";
    regexp6 = "Оборудование:";
    if(data.match(regexp1)!=null){
      var vid="k";
    };
    if(data.match(regexp5)!=null){
        var vid="m";
    };
    if(data.match(regexp6)!=null){
        var vid="o";
    };
    
    //var naim=data.match(regexp1);
    var naim=data.replace(regexp1,'');
    var naim=naim.replace(regexp2,'');
    var naim=naim.replace(regexp4,'');
    var naim=naim.replace(regexp3,'');
    
    var naim=naim.replace(regexp5,'');
    //alert(naim);
     $.ajax({
       method: "POST",
       url: "/stock/notifications",
       data: {data:naim,vid:vid},
       beforeSend: function(xhr) {
           initToken(xhr);
       },
        error: function () {
            alert('ошибка');
        },
        success: function() {
           alert('ок');
            
        },
    });
	

}
