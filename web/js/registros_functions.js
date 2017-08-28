$(document).ready(function() {
    var campus, arregloEdificios, edificiosSotano = ['100','106','116','118','124','126','310','316','318'], edificiosTerraza = ['316'];


/************** Funciones de consultas *****************/
    /**
     * Función que realiza una consulta de los edificios
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarEdificio(consulta)
    {
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_edificio",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

    /**
     * Función que realiza una consulta de las novedades
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarNovedad(consulta)
    {
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_novedad",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

    /**
     * Función que realiza una consulta de los pisos
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarPiso(consulta)
    {
         var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_piso",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }

    }

    /**
     * Función que realiza una consulta de los campus
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarCampus(consulta)
    {
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_campus",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

    /**
     * funcion que permite buscar los datos de un usuario para cargar el frm de registro
     * @param  consulta hace referencia a un valor de busqueda
     * @return json dataResult objeto con la informacion de usuario.
     */
    function buscarUsuario(consulta)
    {
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_usuario",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

    /**
     * funcion que permite consultar las ultimas solicitudes del campus, edificio y piso seleccionados
     * @return {[type]} [description]
     */
    function buscarUltimasNovedades()
    {
        var dataResult;
        var campus = $.trim($("#campus").find(':selected').val());
        var edificio = $.trim($("#edificio").find(':selected').val());
        var piso = $.trim($("#piso").find(':selected').val());
        var saveData = {};

        saveData['campus'] = campus;
        saveData['edificio'] = edificio;
        saveData['piso'] = piso;

        var jObject = JSON.stringify(saveData);

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_ordenes_mantenimiento",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function (error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex.toString());
        }

    }


/********************* Funciones de actualizacion de select ************************/

    /**
     * Función que llena y actualiza el selector de novedad.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectNovedad(selector)
    {
        var tableName = "novedades";
        var data = buscarNovedad(tableName);
        var codSistemaActual = 0;
        var it = 0;
        var codSistema;
        var nombreSistema;
        var row, row2, row3;

        $("#"+selector+"").empty();
        $.each(data, function(index, record) {
            if($.isNumeric(index)) {

                codSistema = record.cod_sistema;

                if (record.cod_sistema == '1') {
                    nombreSistema = "Hidráulico y Sanitario";
                }else if (record.cod_sistema == '2') {
                    nombreSistema = "Eléctrico";
                }else if (record.cod_sistema == '3') {
                    nombreSistema = "Planta Física";
                }else if (record.cod_sistema == '4') {
                    nombreSistema = "Aires Acondicionados";
                }else if (record.cod_sistema == '5') {
                    nombreSistema = "Cubiertas de los Edificios";
                }

                if ((codSistemaActual == 0) & (codSistema == 5)){
                    row = $('<option value="Seleccionar">Seleccionar</option>');
                    row2 = $('<optgroup label="'+nombreSistema+'">');
                    row3 = $("<option value='" + record.novedad + "'>"+record.novedad+"</option>");
                    //$row.text("Seleccionar");
                    $("#"+selector+"").append(row);
                    $("#"+selector+"").append('<option disabled="disabled"></option>');
                    row2.append(row3);
                    //row2.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                    //$('#descripcion').append(row2);
                    //row3.text(record.novedad);
                    //row3.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                    codSistemaActual = record.cod_sistema;
                }else if ((codSistemaActual == codSistema) & ((record.cod_sistema != null) || (record.novedad != 'Seleccionar'))) {
                    row3 = $("<option value='" + record.novedad + "'>"+record.novedad+"</option>");
                    row2.append(row3);
                    //row.text(record.novedad);
                    //row.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                }else if((record.cod_sistema != null) || (record.novedad != 'Seleccionar')){
                    row3 = $('</optgroup>');
                    if(codSistemaActual != 3)
                        row2.append('<option disabled="disabled"></option>');
                    row2.append(row3);
                    $("#"+selector+"").append(row2);
                    //$('#descripcion2').append(row2);
                    //$('#descripcion3').append(row2);
                    //var row = $('</optiongroup>');
                    row2 = $('<optgroup label="'+nombreSistema+'">');
                    row3 = $("<option value='" + record.novedad + "'>"+record.novedad+"</option>");

                    row2.append(row3);
                    //row.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                    //row2.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                    //row3.text(record.novedad);
                    //row3.appendTo("#descripcion", "#descripcion2", "#descripcion3");
                    codSistemaActual = record.cod_sistema;
                }
            }
        });
    }

/**
     * Función que llena y actualiza el selector de novedad con el id asociado.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectorNovedad(id)
    {
        var tableName = "novedades"
        var data = buscarNovedad(tableName);

        $("#"+id).empty();
        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                var row = $("<option value='" + record.novedad + "'/>");
                row.text(record.novedad);
                row.appendTo("#"+id);
            }
        });
    }

    /**
     * Función que llena y actualiza el selector de Edificio.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectEdificio(idSelect)
    {
        var data = buscarEdificio(idSelect);
        arregloEdificios = data;

        $("#edificio").empty();
        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                var row = $("<option value='" + record.codigo + "'/>");
                row.text(record.codigo + " - " + record.nombre);
                row.appendTo("#edificio");
                /*var row2 = $("<option value='" + record.pisos + "'/>");
                row2.text(record.pisos);
                row2.appendTo("#piso");*/
            }
        });
    }

    /**
     * Función que llena y actualiza el selector de operarios.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectCampus()
    {
        var tableName = "campus";
        var data = buscarCampus(tableName);

        $("#campus").empty();
        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                var row = $("<option value='" + record.nombre + "'/>");
                row.text(record.nombre);
                row.appendTo("#campus");
            }
        });
    }

    /**
     * Función que llena y actualiza el selector de piso.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function limpiarSelectorPiso()
    {
       $("#piso").empty();
    }

    /**
     * Función que llena y actualiza el selector de piso de acuerdo al edificio seleccionado.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectPisoEdificio(edificio)
    {
         var codigo = edificio.split(" ")[0];
         var data = arregloEdificios;
         var numeroPisos;
         var mensaje = "Seleccionar Piso", sotano = "Sótano", terraza = "Terraza";
         $("#piso").empty();
        $.each(data, function(index, record) {
            if(data[index].codigo == codigo) {
                 numeroPisos = record.pisos;
            }
        });
        var row = $("<option value='" + mensaje + "'/>");
        row.text(mensaje);
        row.appendTo("#piso");
        if(edificiosSotano.indexOf(codigo) != -1){
            var row2 = $("<option value='" + sotano + "'/>");
         row2.text(sotano);
         row2.appendTo("#piso");
            }
        for(i=1;i<=numeroPisos;i++){
            var row3 = $("<option value='" + i + "'/>");
         row3.text(i);
         row3.appendTo("#piso");
        }
        if(edificiosTerraza.indexOf(codigo) != -1){
            var row4 = $("<option value='" + terraza + "'/>");
         row4.text(terraza);
         row4.appendTo("#piso");
            }
    }

    /**
     * funcion que permite mostrar la informacion del usuario en los input del frm de registro de ordenes
     * @return {[type]} [actualiza los elementos del select]
     */
    function actualizarInputUsuario()
    {
        var tableName = "usuarios";
        var data = buscarUsuario(tableName);

        $("#nombre").empty();
        $("#correo").empty();
        $("#telefono").empty();
        $("#extension").empty();

        $.each(data, function(index, record) {
            if($.isNumeric(index)){
                $('#nombre').val(record.nombre_usuario);
                $("#correo").val(record.correo);
                $("#telefono").val(record.telefono);
                $("#extension").val(record.extension);
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaOrdenes() {

        var data = buscarUltimasNovedades();
        var tabla = $('#tablaSolicitud').DataTable({
            "paging":           true,
            "info":             true,
            "bFilter":          true,
            "bInfo":            true,
            "bDestroy":         true,
            "responsive":       true,
            "order":            [[ 1, "desc" ]],
            "language": {
                "url":          "js/plugins/Espanol.json",
                        }
        });

        $('#tablaSolicitud').dataTable().fnClearTable();

        if(data.mensaje != ""){
            var tipoUsuario = "";
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    tabla.row.add([
                        record.numero_solicitud,
                        record.fecha,
                        //record.usuario,
                        //record.codigo_campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.descripcion2,
                        record.descripcion3,
                        record.estado]).draw(false);
                    tipoUsuario = record.tipo_usuario;
                }
            });
            if (tipoUsuario == 'normal') {
                alert("A continuación usted podrá ver las últimas 5 solicitudes asociadas al campus, edificio y piso seleccionadas."
                    + "\nRevise que su novedad no haya sido reportada aún.");
                $("#divDialogSolicitud").modal('show');
            }
        }
    }


/************************ funciones del fmr de registro ****************************/

    /**
     * funcion que permite registrar las ordenes de mantenimiento por medio de ajax,
     * captura los valores del formulario y los envia al controlador
     * @return {[type]} [Devuelve el mensaje del controlador modelo si la ejecucion fue correcta o si se presento un error]
     */
    function registrarOrden()
    {
        try
        {
            var usuario = $.trim($("#nombre").val());
            var sede = $.trim($("#sede").val());
            var campus = $.trim($("#campus").find(':selected').val());
            var edificio = $.trim($("#edificio").find(':selected').val());
            var piso = $.trim($("#piso").find(':selected').val());
            var espacio = $.trim($("#espacio").val());
            var contacto = $.trim($("#contacto").val());
            var cantidad = $.trim($("#cantidad").val());
            var descripcion = $.trim($("#descripcion").find(':selected').val());
            var descripcion_novedad = $.trim($("#descripcion_novedad").val());
            var cantidad2 = $.trim($("#cantidad2").val());
            var descripcion2 = $.trim($("#descripcion2").find(':selected').val());
            var descripcion_novedad2 = $.trim($("#descripcion_novedad2").val());
            var cantidad3 = $.trim($("#cantidad3").val());
            var descripcion3 = $.trim($("#descripcion3").find(':selected').val());
            var descripcion_novedad3 = $.trim($("#descripcion_novedad3").val());
            /*var otraNovedad = $.trim($("#Otros").val());
            var otraNovedad2 = $.trim($("#Otros2").val());
            var otraNovedad3 = $.trim($("#Otros3").val());*/

            // al usar un formato json en el metodo Post de ajax y no el tradicional dataString se necesita almacenar los datos del fmr en un objeto
            var saveData = {};

            saveData['nombre']= usuario;
            saveData['sede'] = sede;
            saveData['campus'] = campus;
            saveData['edificio'] = edificio;
            saveData['piso'] = piso;
            saveData['espacio'] = espacio;
            saveData['contacto'] = contacto;
            saveData['cantidad'] = cantidad;
            saveData['descripcion'] = descripcion;
            saveData['descripcion_novedad'] = descripcion_novedad;
            saveData['cantidad2'] = cantidad2;
            saveData['descripcion2'] = descripcion2;
            saveData['descripcion_novedad2'] = descripcion_novedad2;
            saveData['cantidad3'] = cantidad3;
            saveData['descripcion3'] = descripcion3;
            saveData['descripcion_novedad3'] = descripcion_novedad3;
            /*saveData['otranovedad'] = otraNovedad;
            saveData['otranovedad2'] = otraNovedad2;
            saveData['otranovedad3'] = otraNovedad3;*/

            var jObject = JSON.stringify(saveData);

            $.ajax({
                type: "POST",
                url: "index.php?action=insertar_orden",
                data: {jObject:  jObject},
                dataType: "json",
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (result){
                    if(result.value == true)
                    {
                        mostrarMensaje(result.mensaje);
                        alert(result.mensaje);
                        $("#espacio").val("");
                        $("#contacto").val("");
                        $("#cantidad").val("");
                        $("#cantidad2").val("");
                        $("#cantidad3").val("");
                        actualizarSelectNovedad("descripcion");
                        actualizarSelectNovedad("descripcion2");
                        actualizarSelectNovedad("descripcion3");
                        actualizarSelectCampus();
                        limpiarSelectorPiso();
                        $("#edificio").empty();
                        $("#cantidad").prop("disabled",true);
                        $("#cantidad2").prop("disabled",true);
                        $("#cantidad3").prop("disabled",true);
                        $("#descripcion").prop("disabled",true);
                        $("#descripcion2").prop("disabled", true);
                        $("#descripcion3").prop("disabled", true);
                        $("#descripcion_novedad").prop("disabled",true);
                        $("#descripcion_novedad").val("");
                        $("#descripcion_novedad2").prop("disabled",true);
                        $("#descripcion_novedad2").val("");
                        $("#descripcion_novedad3").prop("disabled",true);
                        $("#descripcion_novedad3").val("");
                        $("#agregar").prop("disabled",true);
                        $("#eliminar").prop("disabled",true);
                        $("#espacio").prop("disabled",true);
                        $("#contacto").prop("disabled",true);
                        $("#Otros").val("");
                        $("#labelOtros").hide();
                        $("#Otros").hide();
                        $("#Otros2").val("");
                        $("#Otros2").hide();
                        $("#labelOtros2").hide();
                        $("#Otros3").val("");
                        $("#Otros3").hide();
                        $("#labelOtros3").hide();
                        $("#agregar").show();
                        $("#eliminar").hide();
                        $("#enviar_orden").hide();
                        document.getElementById("tr1").style.display = "none";
                        //document.getElementById("tr2").style.display = "none";
                        document.getElementById("tr3").style.display = "none";
                        //document.getElementById("tr4").style.display = "none";
                    }
                    else
                    {
                        mostrarMensaje(result.mensaje);
                        $("#espacio").val("");
                        $("#contacto").val("");
                        $("#cantidad").val("");
                        $("#cantidad2").val("");
                        $("#cantidad3").val("");
                        $("#edificio").prop('selectedIndex',"--");
                        actualizarSelectNovedad("descripcion");
                        actualizarSelectNovedad("descripcion2");
                        actualizarSelectNovedad("descripcion3");
                        actualizarSelectCampus();
                        limpiarSelectorPiso();
                        $("#cantidad").prop("disabled",true);
                        $("#cantidad2").prop("disabled",true);
                        $("#cantidad3").prop("disabled",true);
                        $("#descripcion").prop("disabled",true);
                        $("#descripcion2").prop("disabled", true);
                        $("#descripcion3").prop("disabled", true);
                        $("#descripcion_novedad").prop("disabled",true);
                        $("#descripcion_novedad").val("");
                        $("#descripcion_novedad2").prop("disabled",true);
                        $("#descripcion_novedad2").val("");
                        $("#descripcion_novedad3").prop("disabled",true);
                        $("#descripcion_novedad3").val("");
                        $("#espacio").prop("disabled",true);
                        $("#contacto").prop("disabled",true);
                        $("#Otros").val("");
                        $("#Otros").hide();
                        $("#labelOtros").hide();
                        $("#Otros2").val("");
                        $("#Otros2").hide();
                        $("#labelOtros2").hide();
                        $("#Otros3").val("");
                        $("#Otros3").hide();
                        $("#labelOtros3").hide();
                        $("#agregar").prop("disabled",true);
                        $("#eliminar").prop("disabled",true);
                        $("#agregar").show();
                        $("#eliminar").hide();
                        $("#enviar_orden").hide();
                        document.getElementById("tr1").style.display = "none";
                        //document.getElementById("tr2").style.display = "none";
                        document.getElementById("tr3").style.display = "none";
                        //document.getElementById("tr4").style.display = "none";
                    }
                }
            });
        }
        catch(ex){
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

    /**
     * Función que se ejecuta al momento que se accede a la página que lo tiene
     * incluido.
     * @returns {undefined}
     */
    (function ()
    {
        actualizarSelectNovedad("descripcion");
        actualizarSelectNovedad("descripcion2");
        actualizarSelectNovedad("descripcion3");
        actualizarSelectCampus();
        limpiarSelectorPiso();
        actualizarInputUsuario();
    })();


/******************* Controlador de eventos de los elementos del frm **********/
    /**
     * captura el elemento seleccionado del select campus y de acuerdo a la seleccion actualiza el select de edificios
     */
    $("#campus").change(function (e) {

        var vlr = $("#campus").find(':selected').val();
        campus = vlr;
        $("#edificio").empty();
        $("#piso").empty();
        $("#edificio").removeAttr('disabled');

        if(vlr == "Meléndez"){
            var id = 01;
            $("#edificio").empty();
            actualizarSelectEdificio(id);

        }
        else if(vlr == 'San Fernando'){
            var id = 02;
            $("#edificio").empty();
            actualizarSelectEdificio(id);

        }
        else if(vlr == "Otro"){
            var id = 03;
            $("#edificio").empty();
            actualizarSelectEdificio(id);
        }
        else
        {
            mostrarMensaje("Error no selecciono un campus del selector");
            $("#edificio").prop('disabled', true);
            $("#piso").prop('disabled', true);
            $("#agregar").prop('disabled', true);
            $("#espacio").prop('disabled', true);
            $("#contacto").prop('disabled', true);
            $("#cantidad").prop('disabled', true);
            $("#descripcion").prop('disabled', true);
            $("#descripcion_novedad").prop('disabled', true);
            $("#enviar_orden").hide();
        }
    });

    /**
     * Se valida que el usuario seleccione un valor correcto
     */
    $("#edificio").change(function (e) {
        var vlr = $("#edificio").find(':selected').val();
          actualizarSelectPisoEdificio(vlr);
          $("#piso").removeAttr('disabled');

        if(vlr == '--'){
            mostrarMensaje("Seleccione una opción válida en el selector de edificios");
            $("#piso").prop('disabled', true);
            $("#agregar").prop('disabled', true);
            $("#espacio").prop('disabled', true);
            $("#contacto").prop('disabled', true);
            $("#cantidad").prop('disabled', true);
            $("#descripcion").prop('disabled', true);
            $("#descripcion_novedad").prop('disabled', true);
            $("#enviar_orden").hide();
        }
    });

    /**
     * Se asigna al input enviar_orden de type="submit" el evento de registrar la orden
     */
    $("#enviar_orden").click(function () {
        var control = true;
        if($("#campus").find(':selected').val() == "Seleccionar"){
            control = false;
            alert("Error. Seleccione un campus");
            $("#campus").focus();
        }else if($("#edificio").find(':selected').val() == "-- - Seleccionar"){
            control = false;
            alert("Error. Seleccione un edificio");
            $("#edificio").focus();
        }else if($("#piso").find(':selected').val() == "Seleccionar Piso"){
            control = false;
            alert("Error. Seleccione un piso");
            $("#piso").focus();
        }else if($.trim($("#espacio").val()) == ""){
            control = false;
            alert("Error. Escriba el espacio donde se reporta la novedad");
            $("#espacio").focus();
        }else if($.trim($("#contacto").val()) == ""){
            control = false;
            alert("Error. Escriba el nombre de contacto");
            $("#contacto").focus();
        }else if($.trim($("#cantidad").val()) < 1){
            control = false;
            alert("Error. Ingrese una cantidad válida para la novedad");
            $("#cantidad").focus();
        }else if($.trim($("#descripcion").val()) == "Seleccionar"){
            control = false;
            alert("Error. Seleccione una novedad");
            $("#descripcion").focus();
        }else if($.trim($("#descripcion_novedad").val()) == ""){
            control = false;
            alert("Error. Ingrese una descripción de la novedad");
            $("#descripcion_novedad").focus();
        }
        var isDisabled = $('#tr1').is(':visible');
        if(isDisabled){
            if($.trim($("#cantidad2").val()) < 1){
                control = false;
                alert("Error. Ingrese una cantidad válida para la novedad");
                $("#cantidad2").focus();
            }else if($.trim($("#descripcion2").val()) == "Seleccionar"){
                control = false;
                alert("Error. Seleccione una novedad");
                $("#descripcion2").focus();
            }else if($.trim($("#descripcion_novedad2").val()) == ""){
                control = false;
                alert("Error. Ingrese una descripción de la novedad");
                $("#descripcion_novedad2").focus();
            }
        }
        isDisabled = $('#tr3').is(':visible');
        if(isDisabled){
            if($.trim($("#cantidad3").val()) < 1){
                control = false;
                alert("Error. Ingrese una cantidad válida para la novedad");
                $("#cantidad3").focus();
            }else if($.trim($("#descripcion3").val()) == "Seleccionar"){
                control = false;
                alert("Error. Seleccione una novedad");
                $("#descripcion3").focus();
            }else if($.trim($("#descripcion_novedad3").val()) == ""){
                control = false;
                alert("Error. Ingrese una descripción de la novedad");
                $("#descripcion_novedad3").focus();
            }
        }if(control){
            registrarOrden();
        }
    });

    /**
     * ocultar componente del formulario de registro de ordenes
     */
    $("#labelOtros").hide();
    $("#Otros").hide();
    $("#labelOtros2").hide();
    $("#Otros2").hide();
    $("#labelOtros3").hide();
    $("#Otros3").hide();
    $("#enviar_orden").hide();
    $("#eliminar").hide();

    /**
     * activa en la venta modal con la ventana que muestra las ultimas solicitudes
     */
    $("#piso").change(function (e) {
        try
        {
            var vlrCampus = $.trim($("#campus").find(':selected').val());
            var vlrEdificio = $.trim($("#edificio").find(':selected').val());
            var vlrPiso = $.trim($("#piso").find(':selected').val());

            if(vlrCampus != 'Seleccionar' & vlrEdificio != '--' & vlrPiso != 'Seleccionar Piso')
            {
                actualizarTablaOrdenes();
                $("#agregar").removeAttr('disabled');
                $("#espacio").removeAttr("disabled");
                $("#contacto").removeAttr("disabled");
                $("#cantidad").removeAttr("disabled");
                $("#descripcion").removeAttr("disabled");
                $("#descripcion_novedad").removeAttr("disabled");
                $("#enviar_orden").show();
            }
            else{
                mostrarMensaje("Error: Selecciona opciones válidas en los selectores de campus, edificio y piso.");
                $("#agregar").prop('disabled', true);
                $("#espacio").prop('disabled', true);
                $("#contacto").prop('disabled', true);
                $("#cantidad").prop('disabled', true);
                $("#descripcion").prop('disabled', true);
                $("#descripcion_novedad").prop('disabled', true);
                $("#enviar_orden").hide();
            }
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error");
            console.log("ERROR: Ocurrio un error" + ex);
        }
    });


    /**
     * Evento que permite agregar una novedad en el frm de registro de ordenes (maximo 3)
     */
    $("#agregar").click(function (e) {
        try{
            if(document.getElementById("tr1").style.display == "none"){
                document.getElementById("tr1").style.display = "table-row";
                //document.getElementById("tr2").style.display = "table-row";
                $("#eliminar").removeAttr('disabled');
                $("#eliminar").show();
                $("#cantidad2").show();
                $("#descripcion2").show();
                $("descripcion_novedad2").show();
                $("#cantidad2").removeAttr('disabled');
                $("#descripcion2").removeAttr('disabled');
                $("#descripcion_novedad2").removeAttr("disabled");
         }
            else if(document.getElementById("tr3").style.display == "none"){
                document.getElementById("tr3").style.display = "table-row";
                //document.getElementById("tr4").style.display = "table-row";
                $("#eliminar").removeAttr('disabled');
                $("#cantidad3").show();
                $("#descripcion3").show();
                $("descripcion_novedad3").show();
                $("#cantidad3").removeAttr('disabled');
                $("#descripcion3").removeAttr('disabled');
                $("#descripcion_novedad3").removeAttr("disabled");
                $(this).hide();
            }
        }
        catch(ex)
        {
            alert("ERROR: Ocurrio un error" + ex);
        }

    });

    /**
     * Evento que permite agregar una novedad en el frm de registro de ordenes (maximo 3)
     */
    $("#eliminar").click(function (e) {
        try{
            if(document.getElementById("tr3").style.display != "none"){
                document.getElementById("tr3").style.display = "none";
                //document.getElementById("tr4").style.display = "none";
                $("#agregar").show();
                $("#cantidad3").hide();
                $("#descripcion3").hide();
                $("descripcion_novedad3").hide();
                $("#cantidad3").attr('disabled');
                $("#descripcion3").attr('disabled');
                $("#descripcion_novedad3").attr("disabled");
                $("#cantidad3").val('');
                $("#descripcion3").val('Seleccionar');
                $("#descripcion_novedad3").val('');
         }
            else if(document.getElementById("tr1").style.display != "none"){
                document.getElementById("tr1").style.display = "none";
                //document.getElementById("tr2").style.display = "none";
                $("#cantidad2").hide();
                $("#descripcion2").hide();
                $("descripcion_novedad2").hide();
                $("#cantidad2").attr('disabled');
                $("#descripcion2").attr('disabled');
                $("#descripcion_novedad2").attr("disabled");
                $("#cantidad2").val('');
                $("#descripcion2").val('Seleccionar');
                $("#descripcion_novedad2").val('');
                $(this).hide();
            }
        }
        catch(ex)
        {
            alert("ERROR: Ocurrio un error" + ex);
        }

    });
});
