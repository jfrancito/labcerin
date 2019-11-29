$(document).ready(function(){

    var carpeta         =   $("#carpeta").val();



    $('#buscarconsulta').on('click', function(event){

        event.preventDefault();
        var ffin        = $('#ffin').val();
        var idopcion    = $('#idopcion').val();
        var _token      = $('#token').val();
        
        $(".listajax").html("");
        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-listado-diario",
            data    :   {
                            _token  : _token,
                            idopcion  : idopcion,
                            ffin    : ffin
                        },
            success: function (data) {
                cerrarcargando();
                $(".listajax").html(data);

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });



    $(".listadodiario").on('click','.btn-detalle-registro-consulta', function() {
        
        var data_cod_resultado  =   $(this).attr('data_cod_resultado');
        var data_examenres_id   =   $(this).attr('data_examenres_id');
        var _token              =   $('#token').val();
        var idopcion            =   $('#idopcion').val();

        $.ajax({
              type    :   "POST",
              url     :   carpeta+"/ajax-mantenimiento-registro-consulta",
              data    :   {
                            _token                : _token,
                            data_cod_resultado    : data_cod_resultado,
                            data_examenres_id     : data_examenres_id,
                            idopcion              : idopcion,
                          },
            beforeSend: function() {
                $('.ajax_resultado_examen_atender').html("<div class='row text-center'><div class='lds-roller'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>");
            },
            success: function (data) {
                $('.ajax_resultado_examen_atender').html(data);
            },
            error: function (data) {
                error500(data);
                setTimeout(function(){ $('.listaclientes').toggle("slow");  $('.resultado_examen_atender').toggle("slow");}, 2000);
            }
        });

        $('.listaconsulta').toggle("slow");
        $('.resultado_examen_atender').toggle("slow");
        
        
    });


    $(".listadodiario").on('click','.mdi-close-cliente', function(e) {

        $('.listaconsulta').toggle("slow");
        $('.resultado_examen_atender').toggle("slow");

    });



    //guardar pedido

    $(".listadodiario").on('click','.btn-guardar-re', function(e) {

        // validacion productos
        var obs         =   $('#obs').val();
        // validacion observacion
        //if(obs==''){ alertdangermobil("ingrese una observacion de un examen"); return false;}
        $('#observacion').val(obs);
        data = agregar_producto_hidden();
        if(data.length<=0){alertdangermobil("Tiene que ver por lo menos un examen"); return false;}
        var datastring = JSON.stringify(data);
        $('#xml_productos').val(datastring);

        abrircargando();
        return true;
    });


    $(".ajaxpersonal").on('click','#guardardconsulta', function() {

        var dni                 = $('#dniguardar').val().trim();
        var planatencion_id     = $('#planatencion_id').val();
        var centroconvenio_id   = $('#centroconvenio_id').val();
        var centroconvenio_id   = $('#centroconvenio_id').val();
        var fechaconsulta       = $('#fechaconsulta').val();        
        var hora                = $('#hora').val(); 
        var fechainforme        = $('#fechainforme').val(); 
        var informado_id        = $('#informado_id').val();
        var nombretratante      = $('#nombretratante').val();  
        var nombremedico        = $('#nombremedico').val();
        var xml                 = $('#xml').val();
        var tipodocumento_id    = $('#tipodocumento_id').val();
        var numerodocumentoguardar    = $('#numerodocumentoguardar').val();
        var comprobante_id      = $('#comprobante_id').val();
        var acuenta             = $('#acuenta').val();
        var tipopago            = $("input:radio[name=tipopago]:checked").val();


        if(dni == ''){alerterrorajax("El campo DNI es obligatorio");return false;}
        if(planatencion_id == '0'){alerterrorajax("El campo Plan de Atencion seleccionado es invalido");return false;}
        if(centroconvenio_id == '0'){alerterrorajax("El campo Centro seleccionado es invalido");return false;}
        if(fechaconsulta == ''){alerterrorajax("El campo Fecha Consulta es obligatorio");return false;}
        if(hora == ''){alerterrorajax("El campo Hora es obligatorio");return false;}
        if(fechainforme == ''){alerterrorajax("El campo Fecha Informe es obligatorio");return false;}
        if(informado_id == '0'){alerterrorajax("El campo Informado seleccionado es invalido");return false;}
        if(nombretratante == ''){alerterrorajax("El campo Nombre Tratante es obligatorio");return false;}
        if(nombremedico == ''){alerterrorajax("El campo Medico Solicitante es obligatorio");return false;}
        if(xml == ''){alerterrorajax("Por lo menos debe haber un producto seleccionado");return false;}
        if(tipodocumento_id == '0'){alerterrorajax("El campo Tipo Documento seleccionado es invalido");return false;}
        if(numerodocumentoguardar == ''){alerterrorajax("El campo Numero Documento es obligatorio");return false;}
        if(comprobante_id == '0'){alerterrorajax("El campo Comprobante seleccionado es invalido");return false;}
        if(acuenta == ''){alerterrorajax("El campo A Cuenta es obligatorio");return false;}
        if(tipopago == 'V'){if(comprobante_id != '1' && comprobante_id != '3'){alerterrorajax("El campo Visa seleccionado solo es para Factura y Boleta");return false;}}

        abrircargando();

        return true;

    });




    $(".ajaxpersonal").on('change','#tipodocumento_id', function() {
        $('#razonsocial').val('');
        $('#numerodocumentoguardar').val('');        
        $('#direccion').val(''); 
        $('#email').val('');
    });

    $(".ajaxpersonal").on('click','#btnbuscardocumento', function() {

        var _token          = $('#token').val();
        var numerodocumento = $('#numerodocumento').val();
        var tipodocumento   = $('#tipodocumento_id').val();


        if(numerodocumento.length<=0){
            alerterrorajax("El campo Numero Documento es obligatorio");
            return false;
        }

        if(tipodocumento == '0'){
            alerterrorajax("El campo Tipo Documento seleccionado es invalido");
            return false;
        }


        if(tipodocumento == '4' && tipodocumento == '7' && tipodocumento == '11'){
            alerterrorajax("Seleccione tipo documento Factura ó Boleta");
            return false;
        }


        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-documento",
            data    :   {
                            _token              : _token,
                            tipodocumento       : tipodocumento,
                            numerodocumento     : numerodocumento                            
                        },
            success: function (data) {
                $('.ajaxcomprobante').html(data);
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


    $(".ajaxpersonal" ).on('keyup','#acuenta', function(){

        var acuenta     = $('#acuenta').val();
        var total       = $('#montototal').val();
        if(acuenta == ''){
            acuenta='0';
        }
        tacuenta    = total - parseFloat(acuenta);
        $('#saldo').val(tacuenta.toFixed(1));

    });

    $( ".inputsaldo" ).on('keyup','#acuenta', function(){
        recalculartotal();
        recalcularsubtotal();
        reclacularigv();
        recalculardetraccion();
    });

    $(".ajaxpersonal").on('click','.eliminar', function() {
        $(this).closest('tr').remove();
        agregaritem();
        recalculartotal();
        recalcularsubtotal();
        crearxml();
    });


    $(".ajaxpersonal").on('click','#btnventastabla', function() {


        var planatencion    = $('#planatencion_id').val();
        var centroconvenio  = $('#centroconvenio_id').val();
        var examen          = $('#examen_id').val();
        var nombretratante  = $('#nombretratante').val();
        var nombreexamen    = $('#examen_id option:selected').text();
        var precio          = $('#precio').val();


        if(planatencion == '0'){
            alerterrorajax("El campo Plan Atencion seleccionado es invalido");
            return false;
        }

        if(centroconvenio == '0'){
            alerterrorajax("El campo Centro Convenio seleccionado es invalido");
            return false;
        }


        if(examen == '0'){
            alerterrorajax("El campo Examen seleccionado es invalido");
            return false;
        }
        
        var eliminar    = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>';               
        var fila        = '<tr class="filaventa" ><td style="display:none;" class="planatencion">'+planatencion+'</td><td style="display:none;" class="centroconvenio">'+centroconvenio+'</td><td style="display:none;" class="examen">'+examen+'</td><td class="item"></td><td class="nombre">'+nombreexamen+'</td><td class="precio">'+precio+'</td><td>'+eliminar+'</td></tr>'
        $('#listaventasdiarias tbody').append(fila);
        agregaritem();
        crearxml();
        recalculartotal();
        recalcularsubtotal();

    });



    $(".ajaxpersonal").on('change','#comprobante_id', function() {

        var _token          = $('#token').val();
        var comprobante = $('#comprobante_id option:selected').val();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-comprobanteserie",
            data    :   {
                            _token              : _token,
                            comprobante        : comprobante
                        },
            success: function (data) {
                $(".ajaxcomprobanteserie").html(data);
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

        if($(this).val() == '1' && $('#tipodocumento_id').val() != '1'){
            $('#tipodocumento_id').val('1').change();
        }

        if($(this).val() == '3' && $('#tipodocumento_id').val() != '6'){
            $('#tipodocumento_id').val('6').change();
        }

    });

    $(".ajaxpersonal").on('change','#examen_id', function() {

        var codexamen = $('#examen_id').val();
        var _token          = $('#token').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-examen",
            data    :   {
                            _token           : _token,
                            codexamen        : codexamen
                        },
            success: function (data) {
                var obj = JSON.parse(data);
                var count = Object.keys(obj).length;

                if(count>0){
                    $('#precio').val(reclacularprecio(obj.precio));   
                }else{
                    $('#precio').val("0.00");
                }
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


    $(".ajaxpersonal").on('change','#tipoexamen_id', function() {

        var _token          = $('#token').val();
        var codtipoexamen   = $('#tipoexamen_id').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-examen",
            data    :   {
                            _token           : _token,
                            codtipoexamen    : codtipoexamen
                        },
            success: function (data) {
                $(".ajaxexamen").html(data);
                $('#precio').val('');

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



    $(".ajaxpersonal").on('change','#planatencion_id', function() {

        var _token          = $('#token').val();
        var planatencion    = $('#planatencion_id option:selected').text();
        var examen_id       = $('#examen_id').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-select-centro-convenio",
            data    :   {
                            _token           : _token,
                            planatencion     : planatencion,
                            examen_id        : examen_id,                            
                        },
            success: function (data) {
                $(".ajaxcentro").html(data);
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

    $(".ajaxpersonal").on('click','.tratante', function() {

        var tratante           = $("input:radio[name=tratante]:checked").val();
        if(tratante == 'M'){
            $('#nombretratante').val('');
            $("#mod-medico").modal();
        }else{
            if(tratante == 'C'){
                $('#nombretratante').val('CERIN');
                $('#codmedico').val('2');
            }
        }
    });


    $(".ajaxpersonal").on('click','#buscarmedicopor', function() {

        var dniapellidomedico    = $('#dniapellidomedico').val();
        var tipobuscarmedico     = $("input:radio[name=tipobuscarmedico]:checked").val();
        var _token               = $('#token').val();
        if(dniapellido.length<=0){
            alerterrorajax("El campo DNI ó Apellido es obligatorio");
            return false;
        }


        $('.ajax-lista-medico').html('');
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-medico-modal",
            data    :   {
                            _token                : _token,
                            dniapellidomedico     : dniapellidomedico,
                            tipobuscarmedico      : tipobuscarmedico                          
                        },
            success: function (data) {

                $('.ajax-lista-medico').html(data);

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


    $(".ajaxpersonal").on('click','#btnbuscarpaciente', function() {

        var dni     = $("#dni").val();
        var _token  = $('#token').val();

        abrircargando();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-paciente",
            data    :   {
                            _token  : _token,
                            dni     : dni
                        },
            success: function (data) {

                var obj = JSON.parse(data);
                var count = Object.keys(obj).length;
                if(count>0){

                    var nombrecompleto   = obj.apPaterno +' '+obj.apMaterno +' '+obj.nombre ;
                    $('#codpaciente').val(obj.Cod_Paciente);
                    $('#nombrepaciente').val(nombrecompleto);
                    $('#edad').val(calcularEdad(obj.fechaNac));
                    $('#dniguardar').val(dni);

                    $('#tipodocumento_id').val('1').change();
                    $('#numerodocumento').val(dni); 
                    $('#numerodocumentoguardar').val(dni);                   
                    $('#razonsocial').val(nombrecompleto);
                    $('#direccion').val(obj.direccion); 
                    $('#email').val(obj.mail);


                }else{
                    $('#nombrepaciente').val("");
                    $('#edad').val("");
                    $('#dniguardar').val("");
                    $('#tipodocumento_id').val('0').change();
                    $('#numerodocumento').val('');
                    $('#numerodocumentoguardar').val('');                                        
                    $('#razonsocial').val('');
                    $('#direccion').val(''); 
                    $('#email').val('');
                    $("#mod-paciente").modal();
                }
                cerrarcargando();

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


    $(".ajaxpersonal").on('click','#buscarpacientepor', function() {

        var dniapellido          = $('#dniapellido').val();
        var tipobuscar           = $("input:radio[name=tipobuscar]:checked").val();
        var _token               = $('#token').val();
        if(dniapellido.length<=0){
            alerterrorajax("El campo DNI ó Apellido es obligatorio");
            return false;
        }


        $('.ajax-lista-paciente').html('');
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-paciente-modal",
            data    :   {
                            _token          : _token,
                            dniapellido     : dniapellido,
                            tipobuscar      : tipobuscar                          
                        },
            success: function (data) {

                $('.ajax-lista-paciente').html(data);

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


    $(".ajaxpersonal").on('dblclick','.ajax-lista-medico tbody tr', function() {

        var codigo =$(this).find('.bcodm').html();
        var dni =$(this).find('.bdnim').html();
        var nombre =$(this).find('.bnombrem').html();
        $('#nombretratante').val(nombre);
        $('#nombremedico').val('DR(A). '+nombre);
        $('#codmedico').val(codigo);
        $("#mod-medico").modal('hide');
            
    });


    $(".ajaxpersonal").on('dblclick','.ajax-lista-paciente tbody tr', function() {

        var codigo =$(this).find('.bcodpaciente').html();
        var dni =$(this).find('.bdni').html();
        var nombre =$(this).find('.bnombre').html();
        var fn =$(this).find('.bfn').html();
        var direccion =$(this).find('.direccion').html();
        var mail =$(this).find('.mail').html();

        $('#nombrepaciente').val(nombre);
        $('#edad').val(calcularEdad(fn));
        $('#dniguardar').val(dni);

        $('#dni').val(dni);
        $('#codpaciente').val(codigo);
        $("#mod-paciente").modal('hide');

        $('#tipodocumento_id').val('1').change();

        $('#numerodocumento').val(dni);                    
        $('#razonsocial').val(nombre);
        $('#direccion').val(direccion); 
        $('#email').val(mail);
        $('#numerodocumentoguardar').val(dni);

    });

    $('#planatencion_id').val('1').change();

});



function agregar_producto_hidden(){

    var data = [];
    $(".listadodiario .productoseleccion").each(function(){

        var data_id_coddetalleexamen                 = $(this).attr('data_id_coddetalleexamen');
        var data_valor                               = $(this).find('#valor').val();

        data.push({
            data_id_coddetalleexamen                : data_id_coddetalleexamen,
            data_valor                              : data_valor,
        });

    });

    return data;
}



function reclacularprecio(precio){


        var planatencion    = $('#planatencion_id').val();
        var examen          = $('#examen_id').val();
        var descuento       = 0.00;

        if(precio == ''){
            return '';
        }

        $(".listaplanes tr").each(function(){
            if(planatencion == $(this).find(".cod").html()){
                descuento       = parseInt($(this).find(".descuento").html());
            }
        });


        if(planatencion == 5){ //TF - TARIFA FAMILIAR
            if(examen != '0'){
                return parseInt('0.00').toFixed(2);
            }
        }

        if(planatencion == 1){ //TN - TARIFA NORMAL
            if(examen != '0'){
                return parseInt(precio).toFixed(2);
            }
        }

        if(planatencion == 2){ //TR - TARIFA REDUCIDA I
            if(examen != '0'){
                return (parseInt(precio) - descuento).toFixed(2) ;
            }
        }

        if(planatencion == 6){ //TR - TARIFA REDUCIDA II
            if(examen != '0'){
                return (parseInt(precio) - descuento).toFixed(2) ;
            }
        }

        if(planatencion == 3){ //TS - TARIFA SOCIAL
            if(examen != '0'){
                if(parseInt(precio) <= 100){
                    return parseInt('50.00').toFixed(2);
                }else{
                    if(parseInt(precio) > 100 &&  parseInt(precio) <= 200){
                        return parseInt('100.00').toFixed(2);
                    }else{
                        if(parseInt(precio) > 200 &&  parseInt(precio) <= 300){
                            return parseInt('200.00').toFixed(2);
                        }else{
                            if(parseInt(precio) > 300 &&  parseInt(precio) <= 400){
                                return parseInt('300.00').toFixed(2);
                            }                           
                        }                          
                    }                    
                }
            }
        }

        return parseInt(precio).toFixed(2);


}

function agregaritem(){
    var count = 1;
    $("#listaventasdiarias tbody tr").each(function(){
        $(this).find(".item").html(count);
        count = count + 1 ;

    });
}

function crearxml(){
    var xml             = '';
    $("#listaventasdiarias tbody tr").each(function(){
        tprecio             = $(this).find(".precio").html();
        tplanatencion       = $(this).find(".planatencion").html();
        tcentroconvenio     = $(this).find(".centroconvenio").html();
        texamen             = $(this).find(".examen").html();
        xml                 = xml + tprecio +'***'+ tplanatencion+'***'+ tcentroconvenio+'***'+ texamen + '&&&';
    });
    $("#xml").val(xml);
}

function recalculartotal(){
    var total           = 0.00;

    $("#listaventasdiarias tbody tr").each(function(){
        importe = $(this).find(".precio").html();
        total   = total + parseFloat(importe);
    });

    $('#montototal').val(total.toFixed(1));
    $('#saldo').val(total.toFixed(1));

}

function recalcularsubtotal(){
    var total           = 0.00;
    var subtotal        = 0.00;
    var igv             = 0.00;

    $("#listaventasdiarias tbody tr").each(function(){
        importe = $(this).find(".precio").html();
        total   = total + parseFloat(importe);
    });

    subtotal = total/1.18;
    igv = total - subtotal;

    $('#subtotal').val(subtotal.toFixed(1));
    $('#igv').val(igv.toFixed(1));


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