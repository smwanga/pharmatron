$(e.target).find('button[type=submit]').removeAttr('disabled');
if(error.response.status == 422) {
    $.each( error.response.data, function(key, value ) {
        let $input = $('[name='+key+']');
        if(typeof $input != 'undefined'){
            $input.closest('.form-group').addClass('has-error');
            $input.closest('.form-group').find('.help-block').text(value[0]).show();
        }
    });
}
