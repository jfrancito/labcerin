$(document).ready(function(){

    var carpeta = $("#carpeta").val();




    $(".datetimepicker").datetimepicker({
        autoclose: true,
        pickerPosition: "bottom-left",
        componentIcon: '.mdi.mdi-calendar',
        navIcons:{
            rightIcon: 'mdi mdi-chevron-right',
            leftIcon: 'mdi mdi-chevron-left'
        },
        onSelect: function date(date) {
        var fechanacimiento = convertDateFormat($('#fechanacimiento').val());
        $('#edad').val(calcularEdad(fechanacimiento));
        }
    });


    $(".table-condensed").on('click','td', function() {

        var fechanacimiento = convertDateFormat($('#fechanacimiento').val());
        $('#edad').val(calcularEdad(fechanacimiento));

    }); 


    $(".ajaxpersonal").on('click','#buscarpaciente', function() {

        var dni     = $("#dni").val();
        var _token  = $('#token').val();
        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-paciente-essalud",
            data    :   {
                            _token  : _token,
                            dni     : dni
                        },
            success: function (data) {

                if(data == 'error'){
                    alerterrorajax("No se encontro paciente");
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

	$(".ajaxpersonal").on('change','#departamentos_id', function() {
		var departamentos_id = $('#departamentos_id').val();
    	var _token 		= $('#token').val();

        $.ajax({
            
            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-provincia",
            data	: 	{
            				_token	: _token,
            				departamentos_id : departamentos_id
            	 		},
            success: function (data) {

            	$(".ajaxprovincia").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });



	$(".ajaxpersonal").on('change','#provincia_id', function() {

		var provincia_id = $('#provincia_id').val();
        var departamentos_id = $('#departamentos_id').val();
    	var _token 		= $('#token').val();

        $.ajax({

            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-distrito",
            data	: 	{
            				_token	: _token,
            				provincia_id : provincia_id,
                            departamentos_id : departamentos_id                            
            	 		},
            success: function (data) {

            	$(".ajaxdistrito").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });

    });





});
function convertDateFormat(string) {
  var info = string.split('-');
  return info[2] + '-' + info[1] + '-' + info[0];
}

function calcularEdad(fecha) {
        // Si la fecha es correcta, calculamos la edad

        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
            fecha = formatDate(fecha, "yyyy-MM-dd");
        }

        var values = fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }

        if(edad > 0){
            return edad + " años";
        }else{
            if(meses > 0){

                if(meses == 1){
                    return meses + " mes ";
                }else{
                    return meses + " meses";
                }

            }else{
                if(dias == 1){
                    return dias + " dia ";
                }else{
                    return dias + " días";
                }

            }
        }


}