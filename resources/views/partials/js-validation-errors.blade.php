if(error.response.status == 422) {
    $.each( error.response.data, function(key, value ) {
        let $input = $('input[name='+key+']');
        if(typeof $input != 'undefined'){
            $input.closest('.form-group').addClass('has-error');
            $input.closest('.form-group').find('.help-block').text(value[0]).show();
        }
    });
}