String.prototype.reverse =
		function()
		{
			splitext = this.split("");
			revertext = splitext.reverse();
			reversed = revertext.join("");
			return reversed;
		}
$.fn.barcode = function(s) {
		var result = 0;
		var rs = s.reverse();
		for (counter = 0; counter < rs.length; counter++)
		{
			result = result + parseInt(rs.charAt(counter)) * Math.pow(3, ((counter+1) % 2));
		}
		var digit = (10 - (result % 10)) % 10;
		this.val(s+''+digit);
		return this;
}
$.fn.alpha_num = function (length) {
   var result = '';
   var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    for (var i = length; i > 0; --i){
   		result += chars[Math.floor(Math.random() * chars.length)];
    }
    this.val(result);

   return this;
}
if($.fn.datepicker){
	$('.date-picker').datepicker({
        orientation: "top auto",
        autoclose: true,
        todayHighlight:true
    });
}
if($.fn.select2){
	$('.select2').select2({
        width: '100%'
    });
}