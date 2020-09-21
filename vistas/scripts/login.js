(function($) {  
    $.get = function(key)   {  
        key = key.replace(/[\[]/, '\\[');  
        key = key.replace(/[\]]/, '\\]');  
        var pattern = "[\\?&]" + key + "=([^&#]*)";  
        var regex = new RegExp(pattern);  
        var url = unescape(window.location.href);  
        var results = regex.exec(url);  
        if (results === null) {  
            return null;  
        } else {  
            return results[1];  
        }  
    }  
})(jQuery);  
var a = $.get("val");
console.log(a);
if(a == 1){
    bootbox.alert("Usuario y/o Password incorrectos");
}

$("#frmAcceso").on('submit', function(e)
{
	e.preventDefault();
	logina=$("#logina").val();
	clavea=$("#clavea").val();

	$.post("../ajax/usuario.php?op=verificar",
        {"logina":logina, "clavea":clavea},
        function(data)
        {
            console.log(data);
           if (data != null){
            
            	$(location).attr("href","escritorio.php");
            }
        });
})
$(document).ready(function () {
     //CheckBox mostrar contraseña
            $('#show').click(function () {
                $('#clavea').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });