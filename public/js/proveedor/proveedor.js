$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".ajaxpersonal").on('click','#buscarproveedor', function() {

        var ruc     = $("#ruc").val();
        var _token  = $('#token').val();
        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-proveedor",
            data    :   {
                            _token  : _token,
                            ruc     : ruc
                        },
            success: function (data) {

                if(data == 'error'){
                    alerterrorajax("No se encontro ruc");
                }
                cerrarcargando();
                $(".formpaciente").html(data);
            },
            error: function (data) {
                cerrarcargando();
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    }); 



});
