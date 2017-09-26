String.prototype.reverse = function() {
	splitext = this.split("");
	revertext = splitext.reverse();
	reversed = revertext.join("");

	return reversed;
}
$.fn.barcode = function(s) {
	var result = 0;
	var rs = s.reverse();
	for (counter = 0; counter < rs.length; counter++) {
		result = result + parseInt(rs.charAt(counter)) * Math.pow(3, ((counter+1) % 2));
	}
	var digit = (10 - (result % 10)) % 10;
	this.val(s+''+digit);

	return this;
}
$.fn.alpha_num = function (length) {
   var result = '';
   var chars = '01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    for (var i = length; i > 0; --i) {
   		result += chars[Math.floor(Math.random() * chars.length)];
    }
    this.val(result);

   return this;
}
if($.fn.datepicker){
	$('.date-picker').datepicker({
		format:'yyyy-mm-dd',
        orientation: "top auto",
        autoclose: true,
        todayHighlight:true
    });
}
if($.fn.select2) {
	$('.select2').select2({
        width: '100%'
    });
}
$('input[type=number]').on('focus', function(e) {
	  $(this).bind("wheel mousewheel", function(e) {
	      e.preventDefault();
	  });
});

$.fn.notify = function(message = 'The operation was successful', title = 'Success', type = 'success') {
  new PNotify({
        title: title,
        text: '<p>'+message+'</p>',
        type: type,
        styling: 'fontawesome'
     });
}
$.fn.getFormData = function(){
    var unindexed_array = this.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
$.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}
