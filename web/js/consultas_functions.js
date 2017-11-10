/**
**/
function ejecutarFuncion(e)
{
    var keynum;
    if(window.event) { // IE
      keynum = e.keyCode;
    } else if(e.which){ // Netscape/Firefox/Opera
      keynum = e.which;
    }
    if (keynum == 13) {
        $("#buscarOrdenes").click();
    }
}
$(document).ready(function() {
    var URLactual = window.location;
    if(URLactual['href'].indexOf('novedad_consultas') >= 0){
        actualizarSelectNovedad("novedadSearch");
    }

    var usuario = "";

    var arregloNumSolicitudes = [];

    var dataEdificios;

    var edificiosSotano = ['100','116','118','124','132','310','316','318'], edificiosTerraza = ['100','108','110','116','117','118','120','122','122A','124','126','127','130','132','132A','134','135','316'];

    var primeraVez = true, primeraVez2 = true, primeraVez3 = true, primeraVez4 = true;

/***********************************Funciones de los formularios de consulta consultas*********************************************/
    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarOrdenes(consulta) {
        var dataResult;

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_orden",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                beforeSend: function() {
                    $("#loader").dialog("open");
                    $('#loader').html('<img id="" src="../web/images/loading.gif"/>');
                // $("#loader").dialog("close");
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                    $("#loader").dialog("close");
                }
            });
            return dataResult;
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden  por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarSolicitud(consulta){
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_solicitudes_mantenimiento",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data) {
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarOrdenesParametros(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicio = $.trim(consulta[2]);
        var fechaFin = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicio + " 00:00:00";
        dataSave['fechaFin'] = fechaFin + " 23:59:59";


        var jObject = JSON.stringify(dataSave);

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_orden_parametros",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerEstadisticasEdificios(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicial = $.trim(consulta[2]);
        var fechaFinal = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_estadisticas_edificios",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerEstadisticasNovedades(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicial = $.trim(consulta[2]);
        var fechaFinal = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_estadisticas_novedades",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerEstadisticasEspacios(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicial = $.trim(consulta[2]);
        var fechaFinal = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_estadisticas_espacios",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerEstadisticasSistema(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicial = $.trim(consulta[2]);
        var fechaFinal = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_estadisticas_sistema",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerEstadisticasOperador(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var sistema = $.trim(consulta[1]);
        var fechaInicial = $.trim(consulta[2]);
        var fechaFinal = $.trim(consulta[3]);

        dataSave['campus']= campus;
        dataSave['sistema'] = sistema;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_estadisticas_operador",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarOrdenesParametrosAvanzados(consulta){
        var dataResult;
        var dataSave = {};

        var campus = $.trim(consulta[0]);
        var edificio = $.trim(consulta[1]);
        var sistema = $.trim(consulta[2]);
        var piso = $.trim(consulta[3]);
        var fechaInicial = $.trim(consulta[4]);
        var fechaFinal = $.trim(consulta[5]);

        dataSave['campus']= campus;
        dataSave['edificio'] = edificio;
        dataSave['sistema'] = sistema;
        dataSave['piso'] = piso;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_orden_parametros_avanzados",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
    * Función que realiza la consulta de una orden por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarOrdenesNovedad(consulta){
        var dataResult;
        var dataSave = {};

        var novedad = $.trim(consulta[0]);
        var campus = $.trim(consulta[1]);
        var edificio = $.trim(consulta[2]);
        var piso = $.trim(consulta[3]);
        var fechaInicial = $.trim(consulta[4]);
        var fechaFinal = $.trim(consulta[5]);

        dataSave['novedad']= novedad;
        dataSave['campus']= campus;
        dataSave['edificio']= edificio;
        dataSave['piso']= piso;
        dataSave['fechaInicio'] = fechaInicial + " 00:00:00";
        dataSave['fechaFin'] = fechaFinal + " 23:59:59";

        var jObject = JSON.stringify(dataSave);

        try
        {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_orden_novedad",
                data: {jObject:  jObject},
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                }
            });
            return dataResult;
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Función que realiza una consulta de los edificios
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarEdificio(consulta){
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_edificio",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
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
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Función que realiza una consulta de las ordenes dado
     un usuario
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarOrdenesSistema(consulta){
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_ordenes_sistema",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
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
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
     */
    function buscarDatosUsuario(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_datos_usuario",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
    */
    function buscarHistorialUsuario(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_historial",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Función que realiza una consulta de las novedades
     * con base en una palabra clave.
     * @param {type} consulta, palabra clave para realizar la consulta.
     * @returns {data} object json
    **/
    function buscarNovedad(consulta){
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
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
     */
    function buscarOrdenesElectrico(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_ordenes_electrico",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
     */
    function buscarOrdenesHidraulico(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_ordenes_hidraulico",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
     */
    function buscarOrdenesMobiliario(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_ordenes_mobiliario",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * funcion que permite recuperar los datos del usuario asociados a una orden/solicitud
     * @param  {string} consulta [nombre de login del usuario]
     * @return {object}          [Objeto json con los datos del usuario]
     */
    function buscarOrdenesPlanta(consulta){
        var dataResult;

        try{
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_ordenes_planta",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function (request, status, error) {
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    location.reload(true);
                },
                success: function (data){
                    dataResult = data;
                }
            });
            return dataResult;
        }
        catch(ex){
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaOrdenes(data){
        var tablaOrdenes = $('#tablaOrdenes').DataTable();
        var campus;

        if (primeraVez) {
            var tablaOrdenes = $('#tablaOrdenes').DataTable({
                "info":             false,
                "bFilter":          false,
                "bInfo":            false,
                "bLengthChange":    false,
                "bPaginate":        false,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                            },
                "order": [[ 0, "desc" ]]
            });
            $('#tablaOrdenes tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
        }

        $('#tablaOrdenes').dataTable().fnClearTable();
        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);
                tablaOrdenes.row.add([
                    record.numero_solicitud,
                    record.impreso,
                    record.fecha,
                    record.usuario,
                    campus,
                    record.codigo_edificio,
                    record.piso,
                    record.espacio,
                    record.descripcion1,
                    record.cantidad1,
                    record.descripcion2,
                    record.cantidad2,
                    record.descripcion3,
                    record.cantidad3,
                    record.contacto,
                    record.estado]).draw(false);
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaOrdenes2(data){
        var tablaSolicitado = $('#tablaSolicitado2').DataTable();
        var tablaRevisado = $('#tablaRevisado2').DataTable();
        var tablaRealizado = $('#tablaRealizado2').DataTable();
        var campus;

        if(primeraVez2){
            var tablaSolicitado = $('#tablaSolicitado2').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRevisado = $('#tablaRevisado2').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRevisado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRevisado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRealizado = $('#tablaRealizado2').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRealizado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRealizado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            $('#tablaSolicitado2 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRevisado2 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRealizado2 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
        }

        $('#tablaSolicitado2').dataTable().fnClearTable();
        $('#tablaRevisado2').dataTable().fnClearTable();
        $('#tablaRealizado2').dataTable().fnClearTable();

        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);
                if(record.estado == 'Pendiente'){
                    tablaSolicitado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }else if(record.estado == 'Revisado'){
                    tablaRevisado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Realizado' || record.estado == 'Duplicado' || record.estado == 'No Aplica'){
                    tablaRealizado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaOrdenes3(data){
        var tablaSolicitado = $('#tablaSolicitado3').DataTable();
        var tablaRevisado = $('#tablaRevisado3').DataTable();
        var tablaRealizado = $('#tablaRealizado3').DataTable();
        var campus;

        if(primeraVez3){
            var tablaSolicitado = $('#tablaSolicitado3').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRevisado = $('#tablaRevisado3').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRevisado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRevisado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRealizado = $('#tablaRealizado3').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRealizado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRealizado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            $('#tablaSolicitado3 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRevisado3 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRealizado3 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
        }

        $('#tablaSolicitado3').dataTable().fnClearTable();
        $('#tablaRevisado3').dataTable().fnClearTable();
        $('#tablaRealizado3').dataTable().fnClearTable();

        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);

                if(record.estado == 'Pendiente'){
                    tablaSolicitado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Revisado'){
                    tablaRevisado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Realizado' || record.estado == 'Duplicado' || record.estado == 'No Aplica'){
                    tablaRealizado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaOrdenes4(data){
        var tablaSolicitado = $('#tablaSolicitado4').DataTable();
        var tablaRevisado = $('#tablaRevisado4').DataTable();
        var tablaRealizado = $('#tablaRealizado4').DataTable();
        var campus;

        if (primeraVez4) {
            var tablaSolicitado = $('#tablaSolicitado4').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaSolicitado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRevisado = $('#tablaRevisado4').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRevisado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRevisado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            var tablaRealizado = $('#tablaRealizado4').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "responsive":       true,
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "dom":              'Bfrtip',
                "select":           true,
                "buttons": [
                    {
                        text: 'Seleccionar todo',
                        action: function () {
                            tablaRealizado.rows().select();
                        }
                    },
                    {
                        text: 'Deseleccionar todo',
                        action: function () {
                            tablaRealizado.rows().deselect();
                        }
                    },
                    'excel'
                ],
                "order": [[ 0, "desc" ]]
            });
            $('#tablaSolicitado4 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRevisado4 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#tablaRealizado4 tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
        }

        $('#tablaSolicitado4').dataTable().fnClearTable();
        $('#tablaRevisado4').dataTable().fnClearTable();
        $('#tablaRealizado4').dataTable().fnClearTable();

        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);
                if(record.estado == 'Pendiente'){
                    tablaSolicitado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Revisado'){
                    tablaRevisado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Realizado' || record.estado == 'Duplicado' || record.estado == 'No Aplica'){
                    tablaRealizado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaHistorial(){
        var URLactual = window.location;
        var campus;

        if(URLactual['href'].indexOf('listar_historial') >= 0){


            data = buscarHistorialUsuario();
            var tabla = $('#tablaHistorial').DataTable({
                "paging":           true,
                "info":             true,
                "bFilter":          true,
                "bInfo":            true,
                "bDestroy":         true,
                "select":           true,
                "responsive":       true,
                "columnDefs":       [{className: "dt-body-center"},
                                    {className: "dt-head-center"}],
                "language": {
                    "url":          "js/plugins/Espanol.json",
                },
                "order": [[ 0, "desc" ]]
            });
            $('#tablaHistorial').dataTable().fnClearTable();
            $('#tablaHistorial').show();
            mostrarMensaje(data.mensaje);
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    campus = getNombreCampus(record.codigo_campus);
                    tabla.row.add([
                        record.numero_solicitud,
                        record.fecha,
                        //record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.estado]).draw(false);
                        usuario = record.usuario;
                }
            });
            $("#divTablas").show();
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaElectrico(){
        var URLactual = window.location;

        if(URLactual['href'].indexOf('listar_electrico_consultas') >= 0){

            $("#tablaOrdenes3").clearGridData();
            numColumnas = $('#tablaOrdenes3').find('tr')[0].cells.length;
            data = buscarOrdenesElectrico('consulta');
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    $("#tablaOrdenes3").jqGrid('addRowData',index,record);
                }
            });
            var numeroFilas = $("#tablaOrdenes3").getGridParam("reccount");
            $("#divConteo2").html("Número de registros: "+numeroFilas);
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaHidraulico(){
        var URLactual = window.location;

        if(URLactual['href'].indexOf('listar_hidraulico_consultas') >= 0){

            $("#tablaOrdenes3").clearGridData();
            numColumnas = $('#tablaOrdenes3').find('tr')[0].cells.length;
            data = buscarOrdenesHidraulico('consulta');
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    $("#tablaOrdenes3").jqGrid('addRowData',index,record);
                }
            });
            var numeroFilas = $("#tablaOrdenes3").getGridParam("reccount");
            $("#divConteo2").html("Número de registros: "+numeroFilas);
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaMobiliario(){
        var URLactual = window.location;

        if(URLactual['href'].indexOf('listar_mobiliario_consultas') >= 0){

            $("#tablaOrdenes3").clearGridData();
            numColumnas = $('#tablaOrdenes3').find('tr')[0].cells.length;
            data = buscarOrdenesMobiliario('consulta');
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    $("#tablaOrdenes3").jqGrid('addRowData',index,record);
                }
            });
            var numeroFilas = $("#tablaOrdenes3").getGridParam("reccount");
            $("#divConteo2").html("Número de registros: "+numeroFilas);
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes
     * en el sistema.
     */
    function actualizarTablaPlanta(){
        var URLactual = window.location;

        if(URLactual['href'].indexOf('listar_planta_consultas') >= 0){

            $("#tablaOrdenes3").clearGridData();
            numColumnas = $('#tablaOrdenes3').find('tr')[0].cells.length;
            data = buscarOrdenesPlanta('consulta');
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    $("#tablaOrdenes3").jqGrid('addRowData',index,record);
                }
            });
            var numeroFilas = $("#tablaOrdenes3").getGridParam("reccount");
            $("#divConteo2").html("Número de registros: "+numeroFilas);
        }
    }

    /**
    *funcion axuliar que actualiza el campo impreso de una solicitud
    */
    function actualizarImpreso(numeroSolicitud){

        var dataResult;

        $.ajax({
            type: "POST",
            url: 'index.php?action=actualizar_impreso',
            data: "buscar=" + numeroSolicitud,
            dataType: "json",
            async: false,
            error: function(error){
                alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                location.reload(true);
            },
            success: function(data){
                dataResult = data;
            }
        });
        return dataResult;
    }

    /**
     * Función que llena y actualiza el selector de Edificio.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectEdificio(idSelect){
        dataEdificios = buscarEdificio(idSelect);
        $("#edificioSearch").empty();
        $.each(dataEdificios, function(index, record) {
            if($.isNumeric(index)) {
                 if(index == 1){
                    var todos = "TODOS";
                    var row2 = $("<option value='" + todos + "'/>");
                    row2.text(todos);
                    row2.appendTo("#edificioSearch");
                }
                var row = $("<option value='" + record.codigo + "'/>");
                row.text(record.codigo + " - " + record.nombre);
                row.appendTo("#edificioSearch");
            }
        });
    }

    /**
     * Función que llena y actualiza el selector de Piso.
     * @param {array} data, datos que se van a actualizar en el selector.
     * @returns {undefined}
    **/
    function actualizarSelectPiso(edificio){
        var numeroPisos;
        var mensaje = "Seleccionar Piso", sotano = "Sótano", terraza = "Terraza";

        var row = $("<option value='" + mensaje + "'/>");
        row.text(mensaje);
        row.appendTo("#pisoSearch");

        $.each(dataEdificios, function(index, record) {
            if(dataEdificios[index].codigo == edificio) {
                numeroPisos = record.pisos;
            }
            if (index == 1) {
                var todos = "TODOS";
                var row2 = $("<option value='" + todos + "'/>");
                row2.text(todos);
                row2.appendTo("#pisoSearch");
            }
        });

        if(edificiosSotano.indexOf(edificio) != -1){
            var row3 = $("<option value='" + sotano + "'/>");
            row3.text(sotano);
            row3.appendTo("#pisoSearch");
        }
        for(i=1;i<=numeroPisos;i++){
            var row4 = $("<option value='" + i + "'/>");
            row4.text(i);
            row4.appendTo("#pisoSearch");
        }
        if(edificiosTerraza.indexOf(edificio) != -1){
            var row5 = $("<option value='" + terraza + "'/>");
            row5.text(terraza);
            row5.appendTo("#pisoSearch");
        }
    }

    /** funcion auxiliar que permite devolver el nombre del campus
    */
    function getNombreCampus(data){
        if(data == 1){
            return "Meléndez";
        }
        else if(data == 2){
            return "San Fernando";
        }
        else if(data == 3){
            return "Otro";
        }
        else{
            return "";
        }
    }

    /** funcion auxiliar que permite devolver el código de un campus
    */
    function getCodCampus(data){
        if(data == "Meléndez"){
            return 1;
        }
        else if(data == "San Fernando"){
            return 2;
        }
        else if(data == "Otro"){
            return 3;
        }
        else{
            return "";
        }
    }

    /** funcion auxiliar que pinta un grafico dado los datos de entrada
    */
    function generarGrafico(titulo,subtitulo,xCategorias,xTitulo,yTitulo,info){
        $('#divGraficos').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: titulo,
                style: {
                     fontweight: 'bolder'
                }
            },
            subtitle: {
                text: subtitulo
            },
            xAxis: {
                categories: xCategorias,
                title: {
                    text: xTitulo,
                    style: {
                         color: 'black',
                         fontweight: 'bolder'
                    }
                },
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: yTitulo,
                    style: {
                         color: 'black',
                         fontweight: 'bolder'
                    },
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Solicitudes: <b>{point.y:.0f}</b>'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: '',
                data: info,
                color: '#E60013'
            }]
        });
    }

    /** funcion auxiliar que pinta un grafico dado los datos de entrada
    */
    function generarGraficoSistemas(titulo,subtitulo,xCategorias,xTitulo,yTitulo,sistema,info){
        $('#divGraficos').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: titulo,
                style: {
                     fontweight: 'bolder'
                }
            },
            subtitle: {
                text: subtitulo
            },
            xAxis: {
                categories: xCategorias,
                title: {
                    text: xTitulo,
                    style: {
                         color: 'black',
                         fontweight: 'bolder'
                    }
                },
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: yTitulo,
                    style: {
                         color: 'black',
                         fontweight: 'bolder'
                    },
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: sistema[2],
                data: info[2],
                color: '#E60013'
            },{
                name: sistema[0],
                data: info[0],
                color: 'yellow'
            },{
                name: sistema[1],
                data: info[1],
                color: 'green'
            },{
                name: sistema[3],
                data: info[3],
                color: 'purple'
            },{
                name: sistema[4],
                data: info[4],
                color: 'orange'
            }]
        });
    }

    /**
    *funcion auxiliar que devuelve el nombre del sistema
    */
    function getNombreSistema(data){
        if(data == 1){
            return "Sistema Hidráulico y Sanitario";
        }
        else if(data == 2){
            return "Sistema Eléctrico";
        }
        else if(data == 3){
            return "Sistema Planta Física ";
        }
        else if(data == 4){
            return "Sistema Aires Acondicionados";
        }
        else if(data == 5){
            return "Sistema Cubiertas";
        }
        else{
            return "";
        }
    }

    /**
    *funcion axuliar que permite recuperar el nombre de un edificio
    */
    function getNombreEdficio(campus, edificio){

        var dataResult;
        var dataSave = {};
        dataSave['campus'] = getCodCampus(campus);

        dataSave['edificio']= edificio;

        var jObject = JSON.stringify(dataSave);

        $.ajax({
            type: "POST",
            url: 'index.php?action=obtener_nombre_edificio',
            dataType: "json",
            data: {jObject:  jObject},
            async: false,
            error: function(error){
                alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                location.reload(true);
            },
            success: function(data){
                dataResult = data;
            }
        });
        return dataResult;
    }

    /**
     * Se captura el evento cuando de da click en el boton guardar modificación
     * y se realiza la operacion correspondiente.
     */
    function guardarModOrdenes(idTabla,id){
        try {
            if(id == ""){
                aux = 2;
            }else{
                aux = id;
            }

            if($.trim($("#selectEstado").val()) == "Seleccionar"){
                alert("Error, seleccione un estado");
            }else if($.trim($("#descripcion"+aux).val()) == ""){
                alert("Error, la descripción no puede estar vacía");
            }else{

                var tablaOrdenes = $('#'+idTabla).DataTable();

                var elementoSeleccionado = tablaOrdenes.rows('.selected').data();

                var data = [];
                var saveData = {}, solicitud = {}, usuario = {};
                var conteo = 0;

                $.each(elementoSeleccionado, function(index, record){
                    solicitud[conteo] = record[0]; //record[0] = Número Solicitud
                    usuario[conteo] = record[3]; //record[3] = Usuario
                    conteo++;
                });

                saveData["solicitud"] = solicitud;
                saveData["usuario"] = usuario;

                if($.trim($("#selectEstado").find(':selected').val()) == 'Cerrado'){
                    saveData["estado"] = $.trim($("#selectTipoCerrado").find(':selected').val());
                }else{
                    saveData["estado"] = $.trim($("#selectEstado").find(':selected').val());
                }
                saveData["descripcion"] = $.trim($("#descripcion"+aux).val());

                if ($.trim($("#selectEstado").find(':selected').val()) == 'Cerrado' && $.trim($("#selectTipoCerrado").find(':selected').val()) == 'Realizado') {
                    saveData["operario"] = $.trim($("#selectOperario").find(':selected').val());
                }else{
                    saveData["operario"] = null;
                }

                var jObject = JSON.stringify(saveData);

                $.ajax({
                    type: "POST",
                    url: "index.php?action=actualizar_orden_varios",
                    data: {jObject:  jObject},
                    dataType: "json",
                    error: function(error){
                        alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                        location.reload(true);
                    },
                    success: function(result){
                        if(result.value == true) {
                            alert(result.mensaje);
                            $('#divDialogModificacion'+id).modal('toggle');

                            $.each(elementoSeleccionado, function(index, record){
                                var data = buscarSolicitud(record[0]); //record[0] = Número Solicitud
                                actualizarTablaOrdenesVarios(data,idTabla);
                            });

                            var rows = tablaOrdenes
                                .rows('.selected')
                                .remove()
                                .draw();
                        }
                        else {
                            alert("Error");
                            //console.log(result.mensaje);
                        }
                    }
                });
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Se captura el evento cuando de da click en el boton guardar modificación
     * y se realiza la operacion correspondiente.
     */
    function guardarModOrdenes2(id){
        try {

            if(id == ""){
                aux = 2;
            }else{
                aux = id;
            }

            if($.trim($("#selectEstado").val()) == "Seleccionar"){
                alert("Error, seleccione un estado");
            }else if($.trim($("#descripcion"+aux).val()) == ""){
                alert("Error, la descripción no puede estar vacía");
            }else{

                var tablaSolicitado = $('#tablaSolicitado'+aux).DataTable();
                var tablaRevisado = $('#tablaRevisado'+aux).DataTable();
                var tablaRealizado = $('#tablaRealizado'+aux).DataTable();

                var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
                var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
                var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

                var data = [];
                var saveData = {}, solicitud = {}, usuario = {};
                var conteo = 0;

                $.each(elementosSeleccionadosSolicitado, function(index, record){
                    solicitud[conteo] = record[0]; //record[0] = Número Solicitud
                    usuario[conteo] = record[3]; //record[3] = Usuario
                    conteo++;
                });

                $.each(elementosSeleccionadosRevisado, function(index, record){
                    solicitud[conteo] = record[0]; //record[0] = Número Solicitud
                    usuario[conteo] = record[3]; //record[3] = Usuario
                    conteo++;
                });

                $.each(elementosSeleccionadosRealizado, function(index, record){
                    solicitud[conteo] = record[0]; //record[0] = Número Solicitud
                    usuario[conteo] = record[3]; //record[3] = Usuario
                    conteo++;
                });

                saveData["solicitud"] = solicitud;
                saveData["usuario"] = usuario;

                if($.trim($("#selectEstado").find(':selected').val()) == 'Cerrado'){
                    saveData["estado"] = $.trim($("#selectTipoCerrado").find(':selected').val());
                }else{
                    saveData["estado"] = $.trim($("#selectEstado").find(':selected').val());
                }
                saveData["descripcion"] = $.trim($("#descripcion"+aux).val());

                if ($.trim($("#selectEstado").find(':selected').val()) == 'Cerrado' && $.trim($("#selectTipoCerrado").find(':selected').val()) == 'Realizado') {
                    saveData["operario"] = $.trim($("#selectOperario").find(':selected').val());
                }else{
                    saveData["operario"] = null;
                }

                var jObject = JSON.stringify(saveData);

                $.ajax({
                    type: "POST",
                    url: "index.php?action=actualizar_orden_varios",
                    data: {jObject:  jObject},
                    dataType: "json",
                    error: function(error){
                        alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                        location.reload(true);
                    },
                    success: function(result){
                        if(result.value == true) {
                            alert(result.mensaje);
                            $('#divDialogModificacion'+aux).modal('toggle');

                            $.each(elementosSeleccionadosSolicitado, function(index, record){
                                var data = buscarSolicitud(record[0]); //record[0] = Número Solicitud
                                actualizarTablaOrdenesVarios2(data,id);
                            });

                            $.each(elementosSeleccionadosRevisado, function(index, record){
                                var data = buscarSolicitud(record[0]); //record[0] = Número Solicitud
                                actualizarTablaOrdenesVarios2(data,id);
                            });

                            $.each(elementosSeleccionadosRealizado, function(index, record){
                                var data = buscarSolicitud(record[0]); //record[0] = Número Solicitud
                                actualizarTablaOrdenesVarios2(data,id);
                            });

                            var rows = tablaSolicitado
                                .rows('.selected')
                                .remove()
                                .draw();

                            var rows = tablaRevisado
                                .rows('.selected')
                                .remove()
                                .draw();

                            var rows = tablaRealizado
                                .rows('.selected')
                                .remove()
                                .draw();

                        }
                        else {
                            alert("Error");
                            //console.log(result.mensaje);
                        }
                    }
                });
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    }

/*********************************Funciones de Impresion**************************************/
    /**
     * funcion que genera el archivo pdf usando la libreria BytescoutPDF.js
     *se utiliza la libreria bytescoutpdf para la generacion del pdf documentacion ->https://bytescout.com/products/developer/pdfgeneratorsdkjs/index.html
    */
    function generarPDF(data, numeroSolicitudes){
        var arregloSolicitudes = data[0];
        var arregloUsers = data[1];
        var arregloCampus = data[2];
        var arregloEdificios = data[3];

        var pdf = new BytescoutPDF();

        //Definir el tipo de documento
        pdf.pageSetSize(BytescoutPDF.A4);

        //Definir la orientacion del pdf
        pdf.pageSetOrientation(false);

        //Titulo PDF
        pdf.propertiesSet("Órdenes Mantenimiento", "Órdenes Mantenimiento", "Órdenes, Mantenimiento", "Mantenimiento Univalle", "Mantenimiento Univalle");

        for(i=0;i<numeroSolicitudes;i++){
            var dataOrder = buscarOrdenes(arregloSolicitudes[i]);
            var dataUser = buscarDatosUsuario(arregloUsers[i]);
            var dataEdificio = getNombreEdficio(arregloCampus[i], arregloEdificios[i]);
            //var dataCampus = getNombreCampus(arregloCampus[i]);
            var dataCampus = arregloCampus[i];

            // Agregar la nueva pagina
            pdf.pageAdd();

            // configurar fuente
            pdf.fontSetName('Helvetica');

            // Agregar configuraciones
            pdf.fontSetStyle(true, false, false);
            //header
            pdf.imageLoadFromUrl('images/logouv.png');
            pdf.imagePlace(50, 10);
            pdf.fontSetSize(15);
            pdf.textAdd(50, 50, 'ORDEN DE MANTENIMIENTO', 0);
            pdf.graphicsSetLineWidth(0.5);
            //cuerpo del archivo pdf
            //pdf.graphicsDrawLine(49, 75, 570, 75);
            pdf.fontSetSize(10);
            pdf.fontSetStyle(false, false, false);
            pdf.graphicsDrawRectangle(50, 60, 175, 20);

            //informacion del usuario
            $.each(dataOrder, function(index, record)
            {
             if($.isNumeric(index))
             {
                 pdf.textAdd(52, 76, 'Número Solicitud:   '+record.numero_solicitud);
                 arregloNumSolicitudes.push(record.numero_solicitud);
                 pdf.graphicsDrawRectangle(225, 60, 175, 20);
                 pdf.textAdd(227, 76, 'Fecha:  '+record.fecha);
                 pdf.graphicsDrawRectangle(400, 60, 145, 20);
                 pdf.textAdd(402, 76, 'Estado:  '+record.estado);
                 pdf.graphicsDrawRectangle(50, 80, 235, 20);
             }
            });

            //campus
            pdf.graphicsDrawRectangle(50, 100, 115, 20);
            pdf.textAdd(51, 116, "Campus: "+dataCampus);

            //datos del usuario
            $.each(dataUser, function(index, record){
                if($.isNumeric(index)){
                    pdf.textAdd(51, 96, 'Solicitante: '+record.nombre_usuario);
                    pdf.graphicsDrawRectangle(285, 80, 115, 20);
                    pdf.textAdd(287, 96, 'Teléfono: '+record.telefono);
                    pdf.graphicsDrawRectangle(400, 80, 145, 20);
                    pdf.textAdd(402, 96, 'Extensión:  '+record.extension);
                }
            });

            //datos del espacio de la orden
            $.each(dataOrder, function(index, record)
            {
             if($.isNumeric(index))
             {
                 pdf.graphicsDrawRectangle(470, 100, 75, 20);
                 pdf.textAdd(472, 116, 'Piso: '+record.piso);

                 //validar si hay datos null en la consulta
                 if(record.espacio == "" || record.espacio == null){
                     pdf.graphicsDrawRectangle(50, 105, 495, 20);
                     pdf.textAdd(51, 136,"Espacio: " + "No se registró espacio en la orden");
                 }
                 else{
                    pdf.graphicsDrawRectangle(50, 120, 495, 20);
                    pdf.textAdd(51, 136,"Espacio: " + record.espacio);
                 }


                 if(record.contacto == "" || record.contacto == null){
                     pdf.graphicsDrawRectangle(50, 120, 495, 20);
                     pdf.textAdd(51, 136, "Contacto: " + "No se registró contacto en la orden");
                 }
                 else{
                     pdf.graphicsDrawRectangle(50, 140, 495, 20);
                     pdf.textAdd(51, 156, "Contacto: "+record.contacto);
                 }


             }
            });
            $.each(dataEdificio, function(index, record){
             if($.isNumeric(index)){
                 pdf.graphicsDrawRectangle(165, 100, 305, 20);
                 var nombre = record.nombre;
                 if(nombre.length > 40){
                    nombre = nombre.substr(0,40);
                 }
                 pdf.textAdd(167,116, 'Edificio: '+record.codigo+" / "+nombre);
             }
            });

            //datos de la novedad
            $.each(dataOrder, function(index, record){
             if($.isNumeric(index)){
                 pdf.graphicsDrawRectangle(50,160,415,20);
                 pdf.graphicsDrawRectangle(50,180,495,20);
                 pdf.textAdd(51, 176, "Tarea 1: "+record.descripcion1);
                 pdf.textAdd(51, 196, "Descripción Tarea 1: "+record.descripcion_novedad);
             }
            });

            $.each(dataOrder, function(index, record){
             if($.isNumeric(index)){
                 pdf.graphicsDrawRectangle(465,160,80,20);
                 pdf.textAdd(467, 175, "Cantidad: "+record.cantidad1);
             }
            });

            $.each(dataOrder, function(index,record){
             if($.isNumeric(index)){
                 if(record.descripcion2 == '' || record.descripcion2 == null){
                     pdf.graphicsDrawRectangle(50,200,415,20);
                     pdf.graphicsDrawRectangle(50,220,495,20);
                     pdf.textAdd(51, 216, "Tarea 2: "+"----------");
                     pdf.textAdd(51, 236, "Descripción Tarea 2: "+"----------");
                 }
                 else{
                     pdf.graphicsDrawRectangle(50,200,415,20);
                     pdf.graphicsDrawRectangle(50,220,495,20);
                     pdf.textAdd(51, 216, "Tarea 2: "+record.descripcion2);
                     pdf.textAdd(51, 236, "Descripción Tarea 2: "+record.descripcion_novedad2);
                 }
             }
            });

            $.each(dataOrder, function(index,record){
             if($.isNumeric(index)){
                 if(record.descripcion3 == '' || record.descripcion3 == null)
                 {
                     pdf.graphicsDrawRectangle(465,200,80,20);
                     pdf.textAdd(467, 216,  "Cantidad: "+"-----");
                 }
                 else{
                     pdf.graphicsDrawRectangle(465,200,80,20);
                     pdf.textAdd(467, 216,  "Cantidad: "+record.cantidad2);
                 }
             }
            });

            $.each(dataOrder, function(index,record){
             if($.isNumeric(index)){
                 if(record.descripcion3 == '' || record.descripcion3 == null){
                     pdf.graphicsDrawRectangle(50,240,415,20);
                     pdf.graphicsDrawRectangle(50,260,495,20);
                     pdf.textAdd(51, 256, "Tarea 3: "+"----------");
                     pdf.textAdd(51, 276, "Descripción Tarea 3: "+"----------");
                 }
                 else{
                     pdf.graphicsDrawRectangle(50,240,415,20);
                     pdf.graphicsDrawRectangle(50,260,495,20);
                     pdf.textAdd(51, 256, "Tarea 3: "+record.descripcion3);
                     pdf.textAdd(51, 276, "Descripción Tarea 3: "+record.descripcion_novedad3);
                 }
             }
            });

            $.each(dataOrder, function(index,record){
             if($.isNumeric(index)){
                 if(record.descripcion3 == '' || record.descripcion3 == null)
                 {
                     pdf.graphicsDrawRectangle(465,240,80,20);
                     pdf.textAdd(467, 256,  "Cantidad: "+"-----");
                 }
                 else{
                     pdf.graphicsDrawRectangle(465,240,80,20);
                     pdf.textAdd(467, 256,  "Cantidad: "+record.cantidad3);
                 }
                 descripcion = record.descripcion;
                }
            });

            //informacion adicional
            pdf.graphicsDrawRectangle(50, 280, 495, 38);
            pdf.textAdd(52, 296, 'Trabajo Realizado:');
            if (descripcion != null) {
                pdf.textAdd(52, 309, descripcion);
            }
            pdf.graphicsDrawRectangle(50, 318, 247, 55);
            pdf.textAdd(52, 334, 'Materiales utilizados:');
            pdf.graphicsDrawRectangle(297, 318, 248, 55);
            pdf.textAdd(299, 334, 'Fecha de ejecución (D-M-A):');

            /*pdf.graphicsDrawRectangle(50, 404, 175, 35);
            pdf.textAdd(52, 420, 'Solicitante:');*/
            pdf.graphicsDrawRectangle(50, 373, 247, 35);
            pdf.textAdd(52, 389, 'Realizado por:');
            pdf.graphicsDrawRectangle(297, 373, 248, 35);
            pdf.textAdd(299, 389, 'Revisado por:');
            pdf.textSetAlign(BytescoutPDF.LEFT);
        }

     return pdf;

    }

    /**
     * funcion que permite generar el link de descargar de la orden en formato pdf en del div de mensajes de la aplicacion
     * @param {[type]} PDFContentBase64 [description]
    */
    function generarLinkDescarga(PDFContentBase64){
        var pdfdiv = document.getElementById("divMensaje");
        for(i=0;i<arregloNumSolicitudes.length;i++){
            actualizarImpreso(arregloNumSolicitudes[i]);
        }
        //pdfdiv.innerHTML ='<h4><a title=\"Archivo PDF \" target=\"_blank \" style="color:black" href=\"data:application/pdf;base64,' + PDFContentBase64 + '\">Se generó de forma correcta el pdf. Haga click para visualizarlo.<\/a></h4>';
        //window.open("data:application/pdf;base64, " + PDFContentBase64);
        newWindow.location = "data:application/pdf;base64, " + PDFContentBase64;
    }


/********************************Eventos de los componentes del frm de consultas***********************************************/
    $(function () {
        $('#divSelectRangoFechas .input-daterange').datepicker({
            endDate: "today",
            todayBtn: "linked",
            language: "es",
            autoclose: true,
            orientation: "auto"
        });

        $('#divSelectFecha input').datepicker({
            endDate: "today",
            todayBtn: "linked",
            language: "es",
            autoclose: true,
            orientation: "auto"
        });

        actualizarTablaHistorial();
        /*actualizarTablaElectrico();
        actualizarTablaHidraulico();
        actualizarTablaMobiliario();
        actualizarTablaPlanta();*/

    });

    /**
     * Se captura el evento cuando se da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#visualizarEstadisticas").click(function () {

        var URLactual = window.location;
        var totalSolicitudes = 0;
        var campus = $("#campusSearch").find(':selected').val();
        var sistema = $("#sistemaSearch").find(':selected').val();
        var fechaInicial = $("#searchFechaInicial").val();
        var fechaFinal = $("#searchFechaFinal").val();
        var nombreSistema = "";

        if(campus != 0 & sistema != 0 & fechaInicial != "" & fechaFinal != ""){
            saveData = [campus,sistema,fechaInicial,fechaFinal];

            if(URLactual['href'].indexOf('estadisticas_edificios') >= 0){
                estadisticas = obtenerEstadisticasEdificios(saveData);
                var label = [], informacion = [];
                tipo = "Edificios";

                $.each(estadisticas, function(posicion, info){
                    if(!isNaN(info.codigo_edificio)){
                        label.push(info.codigo_edificio);
                        informacion.push(info.conteosolicitudes);
                    }
                });
                if(estadisticas != null){
                    var aux;
                    var categorias = [], info = [];

                    if (!isNaN(informacion[0])) {
                        aux = parseInt(informacion[0]);
                        totalSolicitudes = aux;
                        categorias.push(label[0]);
                        info.push(parseInt(informacion[0]));
                    }if (!isNaN(informacion[1])) {
                        aux = parseInt(informacion[1]);
                        totalSolicitudes += aux;
                        categorias.push(label[1]);
                        info.push(parseInt(informacion[1]));
                    }if (!isNaN(informacion[2])) {
                        aux = parseInt(informacion[2]);
                        totalSolicitudes += aux;
                        categorias.push(label[2]);
                        info.push(parseInt(informacion[2]));
                    }if (!isNaN(informacion[3])) {
                        aux = parseInt(informacion[3]);
                        totalSolicitudes += aux;
                        categorias.push(label[3]);
                        info.push(parseInt(informacion[3]));
                    }if (!isNaN(informacion[4])) {
                        aux = parseInt(informacion[4]);
                        totalSolicitudes += aux;
                        categorias.push(label[4]);
                        info.push(parseInt(informacion[4]));
                    }if (!isNaN(informacion[5])) {
                        aux = parseInt(informacion[5]);
                        totalSolicitudes += aux;
                        categorias.push(label[5]);
                        info.push(parseInt(informacion[5]));
                    }if (!isNaN(informacion[6])) {
                        aux = parseInt(informacion[6]);
                        totalSolicitudes += aux;
                        categorias.push(label[6]);
                        info.push(parseInt(informacion[6]));
                    }if (!isNaN(informacion[7])) {
                        aux = parseInt(informacion[7]);
                        totalSolicitudes += aux;
                        categorias.push(label[7]);
                        info.push(parseInt(informacion[7]));
                    }if (!isNaN(informacion[8])) {
                        aux = parseInt(informacion[8]);
                        totalSolicitudes += aux;
                        categorias.push(label[8]);
                        info.push(parseInt(informacion[8]));
                    }if (!isNaN(informacion[9])) {
                        aux = parseInt(informacion[9]);
                        totalSolicitudes += aux;
                        categorias.push(label[9]);
                        info.push(parseInt(informacion[9]));
                    }

                    var titulo = tipo+" con más solicitudes";
                    var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                    var xTitulo = tipo;
                    var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';

                    generarGrafico(titulo,subtitulo,categorias,xTitulo,yTitulo,info);
                }
            }else if(URLactual['href'].indexOf('estadisticas_espacios') >= 0){
                estadisticas = obtenerEstadisticasEspacios(saveData);
                var label = [], informacion = [];
                tipo = "Espacios";

                $.each(estadisticas, function(posicion, info){
                    if(!isNaN(info.codigo_edificio)){
                        label.push(info.codigo_edificio + ":" + info.espacio);
                        informacion.push(info.conteosolicitudes);
                    }
                });

                if(estadisticas != null){
                    var aux;
                    var categorias = [], info = [];

                    if (!isNaN(informacion[0])) {
                        aux = parseInt(informacion[0]);
                        totalSolicitudes = aux;
                        categorias.push(label[0]);
                        info.push(parseInt(informacion[0]));
                    }if (!isNaN(informacion[1])) {
                        aux = parseInt(informacion[1]);
                        totalSolicitudes += aux;
                        categorias.push(label[1]);
                        info.push(parseInt(informacion[1]));
                    }if (!isNaN(informacion[2])) {
                        aux = parseInt(informacion[2]);
                        totalSolicitudes += aux;
                        categorias.push(label[2]);
                        info.push(parseInt(informacion[2]));
                    }if (!isNaN(informacion[3])) {
                        aux = parseInt(informacion[3]);
                        totalSolicitudes += aux;
                        categorias.push(label[3]);
                        info.push(parseInt(informacion[3]));
                    }if (!isNaN(informacion[4])) {
                        aux = parseInt(informacion[4]);
                        totalSolicitudes += aux;
                        categorias.push(label[4]);
                        info.push(parseInt(informacion[4]));
                    }if (!isNaN(informacion[5])) {
                        aux = parseInt(informacion[5]);
                        totalSolicitudes += aux;
                        categorias.push(label[5]);
                        info.push(parseInt(informacion[5]));
                    }if (!isNaN(informacion[6])) {
                        aux = parseInt(informacion[6]);
                        totalSolicitudes += aux;
                        categorias.push(label[6]);
                        info.push(parseInt(informacion[6]));
                    }if (!isNaN(informacion[7])) {
                        aux = parseInt(informacion[7]);
                        totalSolicitudes += aux;
                        categorias.push(label[7]);
                        info.push(parseInt(informacion[7]));
                    }if (!isNaN(informacion[8])) {
                        aux = parseInt(informacion[8]);
                        totalSolicitudes += aux;
                        categorias.push(label[8]);
                        info.push(parseInt(informacion[8]));
                    }if (!isNaN(informacion[9])) {
                        aux = parseInt(informacion[9]);
                        totalSolicitudes += aux;
                        categorias.push(label[9]);
                        info.push(parseInt(informacion[9]));
                    }

                    var titulo = tipo+" con más solicitudes";
                    var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                    var xTitulo = tipo;
                    var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';

                    generarGrafico(titulo,subtitulo,categorias,xTitulo,yTitulo,info);
                }
            }else if(URLactual['href'].indexOf('estadisticas_sistema') >= 0){

                var data =  obtenerEstadisticasSistema(saveData);

                if (sistema == -1) {
                    var label = [], sistemas = [], informacion = [];
                    var estadosArray = ['Revisado','Realizado','Pendiente','No Aplica','Duplicado'];
                    var sistemasArray = ['Sistema Cubiertas','Sistema Eléctrico','Sistema Equipos','Sistema Hidráulico y Sanitario','Sistema Planta Física'];
                    var informacionArray = [[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]];

                    $.each(data, function(posicion, info){
                        if($.isNumeric(posicion)){
                            label.push(info.estado);
                            sistemas.push(info.sistema);
                            informacion.push(info.conteosolicitudes);
                        }
                    });

                    for (var i = 0; i < sistemasArray.length; i++) {
                        var arrayAux = [];
                        for (var j = 0; j < sistemas.length; j++) {
                            if (sistemasArray[i] == sistemas[j]) {
                                for (var k = 0; k < estadosArray.length; k++) {
                                    if (estadosArray[k] == label[j]) {
                                        informacionArray[k][i] = informacion[j];
                                    }
                                }
                            }
                        }
                    }

                    var titulo = 'Estadísticas '+nombreSistema;
                    var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                    var categorias = sistemasArray;
                    var xTitulo = "Estado solicitud";
                    var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';

                    generarGraficoSistemas(titulo,subtitulo,categorias,xTitulo,yTitulo,estadosArray,informacionArray);
                }else{
                    var label = [], informacion = [];

                    $.each(data, function(posicion, info){
                        if($.isNumeric(posicion)){
                            label.push(info.estado);
                            informacion.push(info.conteosolicitudes);
                        }
                    });

                    var aux;
                    if (!isNaN(informacion[0])) {
                        aux = parseInt(informacion[0]);
                        totalSolicitudes = aux;
                    };
                    if (!isNaN(informacion[1])) {
                        aux = parseInt(informacion[1]);
                        totalSolicitudes += aux;
                    };
                    if (!isNaN(informacion[2])) {
                        aux = parseInt(informacion[2]);
                        totalSolicitudes += aux;
                    };
                    if (!isNaN(informacion[3])) {
                        aux = parseInt(informacion[3]);
                        totalSolicitudes += aux;
                    };
                    if (!isNaN(informacion[4])) {
                        aux = parseInt(informacion[4]);
                        totalSolicitudes += aux;
                    };

                    var infoSolicitud = [0,0,0,0,0];

                    if(label[0] == 'Revisado'){
                        infoSolicitud[1] = parseInt(informacion[0]);
                    }else if(label[0] == 'Realizado'){
                        infoSolicitud[2] = parseInt(informacion[0]);
                    }else if(label[0] == 'Pendiente'){
                        infoSolicitud[0] = parseInt(informacion[0]);
                    }else if(label[0] == 'No Aplica'){
                        infoSolicitud[3] = parseInt(informacion[0]);
                    }else if(label[0] == 'Duplicado'){
                        infoSolicitud[4] = parseInt(informacion[0]);
                    }

                    if(label[1] == 'Realizado'){
                        infoSolicitud[2] = parseInt(informacion[1]);
                    }else if(label[1] == 'Pendiente'){
                        infoSolicitud[0] = parseInt(informacion[1]);
                    }else if(label[1] == 'No Aplica'){
                        infoSolicitud[3] = parseInt(informacion[1]);
                    }else if(label[1] == 'Duplicado'){
                        infoSolicitud[4] = parseInt(informacion[1]);
                    }

                    if(label[2] == 'Pendiente'){
                        infoSolicitud[0] = parseInt(informacion[2]);
                    }else if(label[2] == 'No Aplica'){
                        infoSolicitud[3] = parseInt(informacion[2]);
                    }else if(label[2] == 'Duplicado'){
                        infoSolicitud[4] = parseInt(informacion[2]);
                    }

                    if(label[3] == 'No Aplica'){
                        infoSolicitud[3] = parseInt(informacion[3]);
                    }else if(label[3] == 'Duplicado'){
                        infoSolicitud[4] = parseInt(informacion[3]);
                    }

                    if(label[4] == 'Duplicado'){
                        infoSolicitud[4] = parseInt(informacion[4]);
                    }

                    if (sistema == 1) {
                        nombreSistema = "Sistema Hidráulico y Sanitario";
                    }if (sistema == 2) {
                        nombreSistema = "Sistema Eléctrico";
                    }if (sistema == 3) {
                        nombreSistema = "Sistema Planta Física";
                    }if (sistema == 4) {
                        nombreSistema = "Sistema Aires Acondicionados";
                    }if (sistema == 5) {
                        nombreSistema = "Sistema Cubiertas";
                    }if (sistema == -1) {
                        nombreSistema = "Todos los Sistemas";
                    }

                    var titulo = 'Estadísticas '+nombreSistema;
                    var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                    var categorias = ['Pendiente','Revisado','Realizado','No Aplica','Duplicado'];
                    var xTitulo = "Estado solicitud";
                    var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';
                    var info = [infoSolicitud[0],infoSolicitud[1],infoSolicitud[2],infoSolicitud[3],infoSolicitud[4]];

                    generarGrafico(titulo,subtitulo,categorias,xTitulo,yTitulo,info);
                }
            }else if(URLactual['href'].indexOf('estadisticas_operador') >= 0){

                var data =  obtenerEstadisticasOperador(saveData);

                var label = [], informacion = [];

                $.each(data, function(posicion, info){
                    if(posicion < 2){
                        label.push(info.operario);
                        informacion.push(info.conteosolicitudes);
                    }
                });

                var aux;

                if (!isNaN(informacion[0])) {
                    aux = parseInt(informacion[0]);
                    totalSolicitudes = aux;
                };
                if (!isNaN(informacion[1])) {
                    aux = parseInt(informacion[1]);
                    totalSolicitudes += aux;
                };

                var infoSolicitud = [];

                if (label[0] == 'Contratista') {
                    infoSolicitud[0] = parseInt(informacion[0]);
                    if(label[1] == 'Propio'){
                        infoSolicitud[1] = parseInt(informacion[1]);
                    }else{
                        infoSolicitud[1] = 0;
                    }
                }else{
                    infoSolicitud[0] = parseInt(informacion[1]);
                    if(label[1] == 'Contratista'){
                        infoSolicitud[1] = parseInt(informacion[0]);
                    }else{
                        infoSolicitud[1] = 0;
                    }
                }

                if (sistema == 1) {
                    nombreSistema = "Sistema Hidráulico y Sanitario";
                }if (sistema == 2) {
                    nombreSistema = "Sistema Eléctrico";
                }if (sistema == 3) {
                    nombreSistema = "Sistema Planta Física";
                }if (sistema == 4) {
                    nombreSistema = "Sistema Aires Acondicionados";
                }if (sistema == 5) {
                    nombreSistema = "Sistema Cubiertas";
                }if (sistema == -1) {
                    nombreSistema = "Todos los Sistemas";
                }

                var titulo = 'Estadísticas '+nombreSistema;
                var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                var categorias = ['Contratista','Propio'];
                var xTitulo = "Operario";
                var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';
                var info = [infoSolicitud[0],infoSolicitud[1]];

                generarGrafico(titulo,subtitulo,categorias,xTitulo,yTitulo,info);
            }else if(URLactual['href'].indexOf('estadisticas_novedades') >= 0){
                estadisticas = obtenerEstadisticasNovedades(saveData);
                var label = [], informacion = [];
                tipo = "Novedad";

                $.each(estadisticas, function(posicion, info){
                    if(info.novedad != undefined){
                        if (label.indexOf(info.novedad) == -1) {
                            label.push(info.novedad);
                            informacion.push(info.conteosolicitudes);
                        }else{
                            var index = label.indexOf(info.novedad);
                            var aux = parseInt(informacion[index]);
                            var aux2 = parseInt(info.conteosolicitudes);
                            var suma = aux + aux2;
                            informacion[index] = suma.toString();
                        }
                    }
                });
                if(estadisticas != null){
                    var aux;
                    var categorias = [], info = [];

                    if (!isNaN(informacion[0])) {
                        aux = parseInt(informacion[0]);
                        totalSolicitudes = aux;
                        categorias.push(label[0]);
                        info.push(parseInt(informacion[0]));
                    }if (!isNaN(informacion[1])) {
                        aux = parseInt(informacion[1]);
                        totalSolicitudes += aux;
                        categorias.push(label[1]);
                        info.push(parseInt(informacion[1]));
                    }if (!isNaN(informacion[2])) {
                        aux = parseInt(informacion[2]);
                        totalSolicitudes += aux;
                        categorias.push(label[2]);
                        info.push(parseInt(informacion[2]));
                    }if (!isNaN(informacion[3])) {
                        aux = parseInt(informacion[3]);
                        totalSolicitudes += aux;
                        categorias.push(label[3]);
                        info.push(parseInt(informacion[3]));
                    }if (!isNaN(informacion[4])) {
                        aux = parseInt(informacion[4]);
                        totalSolicitudes += aux;
                        categorias.push(label[4]);
                        info.push(parseInt(informacion[4]));
                    }if (!isNaN(informacion[5])) {
                        aux = parseInt(informacion[5]);
                        totalSolicitudes += aux;
                        categorias.push(label[5]);
                        info.push(parseInt(informacion[5]));
                    }if (!isNaN(informacion[6])) {
                        aux = parseInt(informacion[6]);
                        totalSolicitudes += aux;
                        categorias.push(label[6]);
                        info.push(parseInt(informacion[6]));
                    }if (!isNaN(informacion[7])) {
                        aux = parseInt(informacion[7]);
                        totalSolicitudes += aux;
                        categorias.push(label[7]);
                        info.push(parseInt(informacion[7]));
                    }if (!isNaN(informacion[8])) {
                        aux = parseInt(informacion[8]);
                        totalSolicitudes += aux;
                        categorias.push(label[8]);
                        info.push(parseInt(informacion[8]));
                    }if (!isNaN(informacion[9])) {
                        aux = parseInt(informacion[9]);
                        totalSolicitudes += aux;
                        categorias.push(label[9]);
                        info.push(parseInt(informacion[9]));
                    }

                    var titulo = tipo+" con más solicitudes";
                    var subtitulo = 'Desde: '+fechaInicial+" hasta: "+fechaFinal;
                    var xTitulo = tipo;
                    var yTitulo = 'Número de Solicitudes (Total: '+totalSolicitudes+')';

                    generarGrafico(titulo,subtitulo,categorias,xTitulo,yTitulo,info);
                }
            }
        }else{
            alert("Error. Por favor rellene todos los campos")
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes").click(function () {
        var vlrinput = $("#search").val();
        if(vlrinput != ""){
            var data =  buscarOrdenes(vlrinput);
            actualizarTablaOrdenes(data);
            $("#divTablas").show();
            $("#btImprimir").removeAttr('Disabled');
            $("#visualizarOrdenes").removeAttr('Disabled');
            $("#modificarOrdenes").removeAttr('Disabled');
            primeraVez = false;
        }
        else{
            alert("Ingrese un valor en el campo de búsqueda");
            $("#search").focus();
            $("#btImprimir").prop('disabled', true);
            $("#visualizarOrdenes").prop('disabled', true);
            $("#modificarOrdenes").prop('disabled', true);
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes2").click(function () {
        var campus = $("#campusSearch").find(':selected').val();
        var sistema = $("#sistemaSearch").find(':selected').val();
        var fechaInicio = $("#searchFechaInicial").val();
        var fechaFin = $("#searchFechaFinal").val();

        if(campus != 0 & sistema != 0 & fechaInicio != "" & fechaFin != "")
        {
            saveData = [campus,sistema,fechaInicio,fechaFin];
            var data =  buscarOrdenesParametros(saveData);
            actualizarTablaOrdenes2(data);
            $("#divTablas").show();
            $("#btImprimir2").removeAttr('Disabled');
            $("#visualizarOrdenes2").removeAttr('Disabled');
            $("#modificarOrdenes2").removeAttr('Disabled');
            primeraVez2 = false;
        }
        else{
            if(campus == 0){
                alert("Error. Seleccione un campus.");
                $("#campusSearch").focus();
            }else if(sistema == 0){
                alert("Error. Seleccione un sistema.");
                $("#sistemaSearch").focus();
            }else if(fechaInicio == ''){
                alert("Error. Ingrese una fecha de inicio.");
                $("#searchFechaInicial").focus();
            }else{
                alert("Error. Ingrese una fecha final.");
                $("#searchFechaFinal").focus();
            }
            $("#btImprimir2").prop('disabled', true);
            $("#visualizarOrdenes2").prop('disabled', true);
            $("#modificarOrdenes2").prop('disabled', true);
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes3").click(function () {
        var campus = $("#campusSearch").find(':selected').val();
        var edificio = $("#edificioSearch").find(':selected').val();
        var sistema = $("#sistemaSearch").find(':selected').val();
        var piso = $("#pisoSearch").find(':selected').val();
        var fechaInicial = $("#searchFechaInicial").val();
        var fechaFinal = $("#searchFechaFinal").val();

        /*if (campus == 0) {
            campus = "-1";
        }*/

        if (edificio == undefined) {
            edificio = 'TODOS';
        }

        /*if (sistema == -1) {
            sistema = '6';
        }*/

        if (piso == undefined || piso == 'TODOS') {
            piso = '-1';
        }

        if(campus != 0 & sistema != 0 & edificio != "--" & fechaInicial != "" & fechaFinal != "")
        {
            saveData = [campus,edificio,sistema,piso,fechaInicial,fechaFinal];
            var data =  buscarOrdenesParametrosAvanzados(saveData);
            actualizarTablaOrdenes2(data);
            $("#divTablas").show();
            $("#btImprimir3").removeAttr('Disabled');
            $("#visualizarOrdenes3").removeAttr('Disabled');
            $("#modificarOrdenes2").removeAttr('Disabled');
       }
       else{
            if(campus == 0){
                alert("Error. Seleccione un campus.");
                $("#campusSearch").focus();
            }else if(edificio == '--'){
                alert("Error. Seleccione un edificio.");
                $("#edificioSearch").focus();
            }else if(sistema == 0){
                alert("Error. Seleccione un sistema.");
                $("#sistemaSearch").focus();
            }else if(piso == 0){
                alert("Error. Seleccione un sistema.");
                $("#sistemaSearch").focus();
            }else if(fechaInicial == ''){
                alert("Error. Ingrese una fecha de inicio.");
                $("#searchFechaInicial").focus();
            }else{
                alert("Error. Ingrese una fecha final.");
                $("#searchFechaFinal").focus();
            }
            $("#btImprimir3").prop('disabled', true);
            $("#visualizarOrdenes3").prop('disabled', true);
            $("#modificarOrdenes2").prop('disabled', true);
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes4").click(function () {
        var URLactual = window.location;
        var campus = '1';
        var edificio = 'TODOS';
        var sistema = '10';         //Significa que va a tomar todos los sistemas
        var piso = '-1';
        var fechaInicial = $("#searchFechaInicial").val();
        var fechaFinal = $("#searchFechaFinal").val();

        if(URLactual['href'].indexOf('listar_electrico_consultas') >= 0){
            sistema = '2';
        }else if(URLactual['href'].indexOf('listar_hidraulico_consultas') >= 0){
            sistema = '1';
        }else if(URLactual['href'].indexOf('listar_mobiliario_consultas') >= 0){
            sistema = '4';
        }else if(URLactual['href'].indexOf('listar_planta_consultas') >= 0){
            sistema = '3';
        }

        if(campus != 0 & sistema != 0 & edificio != "--" & fechaInicial != "" & fechaFinal != "")
        {
            saveData = [campus,edificio,sistema,piso,fechaInicial,fechaFinal];
            var data =  buscarOrdenesParametrosAvanzados(saveData);
            actualizarTablaOrdenes3(data);
            $("#divTablas").show();
            $("#btImprimir5").removeAttr('Disabled');
            $("#visualizarOrdenes4").removeAttr('Disabled');
            $("#modificarOrdenes3").removeAttr('Disabled');
            primeraVez3 = false;
       }
       else{
            if(fechaInicial == ''){
                alert("Error. Ingrese una fecha de inicio.");
                $("#searchFechaInicial").focus();
            }else{
                alert("Error. Ingrese una fecha final.");
                $("#searchFechaFinal").focus();
            }
            $("#btImprimir5").prop('disabled', true);
            $("#visualizarOrdenes4").prop('disabled', true);
            $("#modificarOrdenes3").prop('disabled', true);
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes5").click(function () {

        var campus = '-1';         //Significa que va a tomar todos los campus
        var edificio = 'TODOS';
        var sistema = '10';         //Significa que va a tomar todos los sistemas
        var piso = '-1';
        var fechaInicial = $("#searchFecha").val();
        var fechaFinal = $("#searchFecha").val();

        if(campus != 0 & sistema != 0 & edificio != "--" & fechaInicial != "")
        {
            saveData = [campus,edificio,sistema,piso,fechaInicial,fechaFinal];
            var data =  buscarOrdenesParametrosAvanzados(saveData);
            actualizarTablaOrdenes4(data);
            $("#divTablas").show();
            $("#btImprimir6").removeAttr('Disabled');
            $("#visualizarOrdenes5").removeAttr('Disabled');
            $("#modificarOrdenes5").removeAttr('Disabled');
            primeraVez4 = false;
       }
       else{
            alert("Error. Seleccione una fecha.");
            $("#searchFecha").focus();
            $("#btImprimir6").prop('disabled', true);
            $("#visualizarOrdenes5").prop('disabled', true);
            $("#modificarOrdenes5").prop('disabled', true);
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton buscar y se
     * realiza la operacion correspondiente.
     */
    $("#buscarOrdenes6").click(function () {
        var URLactual = window.location;
        var campus = $("#campusSearch").find(':selected').val();
        var edificio = $("#edificioSearch").find(':selected').val();
        var sistema = $("#sistemaSearch").find(':selected').val();
        var piso = $("#pisoSearch").find(':selected').val();
        var novedad = $("#novedadSearch").val();
        var fechaInicial = $("#searchFechaInicial").val();
        var fechaFinal = $("#searchFechaFinal").val();

        if (campus == 0) {
            campus = "-1";
        }

        if (edificio == undefined) {
            edificio = 'TODOS';
        }

        if (piso == undefined || piso == 'TODOS') {
            piso = '-1';
        }

        if(campus != 0 & sistema != 0 & edificio != "--" & fechaInicial != "" & fechaFinal != "")
        {
            saveData = [novedad,campus,edificio,piso,fechaInicial,fechaFinal];
            var data =  buscarOrdenesNovedad(saveData);
            actualizarTablaOrdenes2(data);
            $("#divTablas").show();
            $("#btImprimir3").removeAttr('Disabled');
            $("#visualizarOrdenes3").removeAttr('Disabled');
            $("#modificarOrdenes2").removeAttr('Disabled');
            primeraVez3 = false;
       }
       else{
            if (novedad == 'Seleccionar') {
                alert("Error. Seleccione una novedad.");
                $("#novedadSearch").focus();
            }else if(campus == 0){
                alert("Error. Seleccione un campus.");
                $("#campusSearch").focus();
            }else if(edificio == '--'){
                alert("Error. Seleccione un edificio.");
                $("#edificioSearch").focus();
            }else if(sistema == 0){
                alert("Error. Seleccione un sistema.");
                $("#sistemaSearch").focus();
            }else if(piso == 0){
                alert("Error. Seleccione un sistema.");
                $("#sistemaSearch").focus();
            }else if(fechaInicial == ''){
                alert("Error. Ingrese una fecha de inicio.");
                $("#searchFechaInicial").focus();
            }else{
                alert("Error. Ingrese una fecha final.");
                $("#searchFechaFinal").focus();
            }
            $("#btImprimir3").prop('disabled', true);
            $("#visualizarOrdenes3").prop('disabled', true);
            $("#modificarOrdenes2").prop('disabled', true);
        }
    });

    /**
     * Evento que permite imprimir una o más ordenes o solicitudes de mantenimiento
     */
    $("#btImprimir").click(function (e) {
        if(confirm("¿Está seguro que desea generar PDF con la(s) orden(es) de mantenimiento?")){

            var tablaOrdenes = $('#tablaOrdenes').DataTable();

            var elementoSeleccionado = tablaOrdenes.rows('.selected').data();

            if(elementoSeleccionado.length > 0){
                var elementSelect = [];
                var solicitud = [];
                var usuario = [];
                var campus = [];
                var edificio = [];

                $.each(elementoSeleccionado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                var data = [solicitud,usuario,campus,edificio];

                var pdf = generarPDF(data, elementoSeleccionado.length);

                pdf.onload(function() {
                    var PDFContentBase64 = pdf.getBase64Text();
                    for(i=0;i<arregloNumSolicitudes.length;i++){
                        actualizarImpreso(arregloNumSolicitudes[i]);
                    }
                    window.open('data:application/pdf;base64,' + PDFContentBase64,"frame");
                    $("#divDialogVisualizacionPDF").modal("show");
                    //generarLinkDescarga(PDFContentBase64);
                });
            }else{
                alert("Error. Seleccione por lo menos una orden.");
            }
        }
    });

    /**
     * Evento que permite imprimir una o varias ordenes o solicitudes de mantenimiento
     */
    $("#btImprimir2").click(function () {
        if(confirm("¿Está seguro que desea generar PDF con la(s) orden(es) de mantenimiento?")){
            var tablaSolicitado = $('#tablaSolicitado2').DataTable();
            var tablaRevisado = $('#tablaRevisado2').DataTable();
            var tablaRealizado = $('#tablaRealizado2').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(elementosSeleccionados > 0){

                var elementSelect = [];
                var solicitud = [];
                var usuario = [];
                var campus = [];
                var edificio = [];

                $.each(elementosSeleccionadosSolicitado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRevisado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRealizado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                var data = [solicitud,usuario,campus,edificio];

                var pdf = generarPDF(data, elementosSeleccionados);

                pdf.onload(function() {
                    var PDFContentBase64 = pdf.getBase64Text();
                    for(i=0;i<arregloNumSolicitudes.length;i++){
                        actualizarImpreso(arregloNumSolicitudes[i]);
                    }
                    window.open('data:application/pdf;base64,' + PDFContentBase64,"frame");
                    $("#divDialogVisualizacionPDF").modal("show");
                    //generarLinkDescarga(PDFContentBase64);
                });
            }else{
                alert("Error. Seleccione por lo menos una orden.");
            }
        }
    });

    /**
     * Evento que permite imprimir una o varias ordenes o solicitudes de mantenimiento
     */
    $("#btImprimir3").click(function () {
        if(confirm("¿Está seguro que desea generar PDF con la(s) orden(es) de mantenimiento?")){
            var tablaSolicitado = $('#tablaSolicitado2').DataTable();
            var tablaRevisado = $('#tablaRevisado2').DataTable();
            var tablaRealizado = $('#tablaRealizado2').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(elementosSeleccionados > 0){

                var elementSelect = [];
                var solicitud = [];
                var usuario = [];
                var campus = [];
                var edificio = [];

                $.each(elementosSeleccionadosSolicitado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRevisado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRealizado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                var data = [solicitud,usuario,campus,edificio];

                var pdf = generarPDF(data, elementosSeleccionados);

                pdf.onload(function() {
                    var PDFContentBase64 = pdf.getBase64Text();
                    for(i=0;i<arregloNumSolicitudes.length;i++){
                        actualizarImpreso(arregloNumSolicitudes[i]);
                    }
                    window.open('data:application/pdf;base64,' + PDFContentBase64,"frame");
                    $("#divDialogVisualizacionPDF").modal("show");
                    //generarLinkDescarga(PDFContentBase64);
                });
            }else{
                alert("Error. Seleccione por lo menos una orden.");
            }
        }
    });

    /**
     * Evento que permite imprimir una o varias ordenes o solicitudes de mantenimiento
     */
    $("#btImprimir5").click(function () {
        if(confirm("¿Está seguro que desea generar PDF con la(s) orden(es) de mantenimiento?")){
            var tablaSolicitado = $('#tablaSolicitado3').DataTable();
            var tablaRevisado = $('#tablaRevisado3').DataTable();
            var tablaRealizado = $('#tablaRealizado3').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(elementosSeleccionados > 0){

                var elementSelect = [];
                var solicitud = [];
                var usuario = [];
                var campus = [];
                var edificio = [];

                $.each(elementosSeleccionadosSolicitado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRevisado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRealizado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                var data = [solicitud,usuario,campus,edificio];

                var pdf = generarPDF(data, elementosSeleccionados);

                pdf.onload(function() {
                    var PDFContentBase64 = pdf.getBase64Text();
                    for(i=0;i<arregloNumSolicitudes.length;i++){
                        actualizarImpreso(arregloNumSolicitudes[i]);
                    }
                    window.open('data:application/pdf;base64,' + PDFContentBase64,"frame");
                    $("#divDialogVisualizacionPDF").modal("show");
                    //generarLinkDescarga(PDFContentBase64);
                });
            }else{
                alert("Error. Seleccione por lo menos una orden.");
            }
        }
    });

    /**
     * Evento que permite imprimir una o varias ordenes o solicitudes de mantenimiento
     */
    $("#btImprimir6").click(function () {
        if(confirm("¿Está seguro que desea generar PDF con la(s) orden(es) de mantenimiento?")){
            var tablaSolicitado = $('#tablaSolicitado4').DataTable();
            var tablaRevisado = $('#tablaRevisado4').DataTable();
            var tablaRealizado = $('#tablaRealizado4').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(elementosSeleccionados > 0){

                var elementSelect = [];
                var solicitud = [];
                var usuario = [];
                var campus = [];
                var edificio = [];

                $.each(elementosSeleccionadosSolicitado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRevisado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                $.each(elementosSeleccionadosRealizado, function(index, record){
                    solicitud.push(record[0]);
                    usuario.push(record[3]);
                    campus.push(record[4]);
                    edificio.push(record[5]);
                });

                var data = [solicitud,usuario,campus,edificio];

                var pdf = generarPDF(data, elementosSeleccionados);

                pdf.onload(function() {
                    var PDFContentBase64 = pdf.getBase64Text();
                    for(i=0;i<arregloNumSolicitudes.length;i++){
                        actualizarImpreso(arregloNumSolicitudes[i]);
                    }
                    window.open('data:application/pdf;base64,' + PDFContentBase64,"frame");
                    $("#divDialogVisualizacionPDF").modal("show");
                    //generarLinkDescarga(PDFContentBase64);
                });
            }else{
                alert("Error. Seleccione por lo menos una orden.");
            }
        }
    });

    /**
     * Se captura el evento cuando se da click en el boton visualizarHistorial y se
     * realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarHistorial").click(function (e) {
        try
        {
            var tabla = $('#tablaHistorial').DataTable();

            var elementosSeleccionados = tabla.rows('.selected').data();

            if (elementosSeleccionados.length == 1) {

                var dataElemento;

                $.each(elementosSeleccionados, function(index, record){
                    dataElemento = record;
                });

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[2];

                var piso = dataElemento[4];

                var dataUsuario = buscarDatosUsuario(usuario);

                var dataEdificio = getNombreEdficio(dataElemento[2], dataElemento[3]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus").val(campus);
                        $("#piso").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });

            }else{
                alert("Error. Seleccione una solicitud.")
            }
        }
        catch(ex)
        {
            alert("Error: Ocurrio un error"+ex);
        }
    });

    /**
     * Se captura el evento cuando se da click en el boton visualizarOrdenes y se
     * realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarOrdenes").click(function (e) {
        try
        {
            var tablaOrdenes = $('#tablaOrdenes').DataTable();

            var elementoSeleccionado = tablaOrdenes.rows('.selected').data();

            if (elementoSeleccionado.length == 1) {
                var dataElemento;

                $.each(elementoSeleccionado, function(index, record){
                    dataElemento = record;
                });

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[4];

                var piso = dataElemento[6];

                var dataUsuario = buscarDatosUsuario(dataElemento[3]);

                var dataEdificio = getNombreEdficio(dataElemento[4], dataElemento[5]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus").val(campus);
                        $("#piso").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                        $("#fecha_modificado").val(record.fecha_modificado);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });
            }else if(elementoSeleccionado > 1){
                alert("Error. Sólo puede ser visualizar un elemento a la vez.");
            }else{
                alert("Error. Seleccione un elemento.");
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton visualizarOrdenes y se
     *  realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarOrdenes2").click(function (e) {
        try
        {
            var tablaSolicitado = $('#tablaSolicitado2').DataTable();
            var tablaRevisado = $('#tablaRevisado2').DataTable();
            var tablaRealizado = $('#tablaRealizado2').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if (elementosSeleccionados == 1) {
                var dataElemento;

                if(elementosSeleccionadosSolicitado.length == 1){
                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        dataElemento = record;
                    });
                }else if(elementosSeleccionadosRevisado.length == 1){
                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        dataElemento = record;
                    });
                }else{
                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        dataElemento = record;
                    });
                }

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[4];

                var piso = dataElemento[6];

                var dataUsuario = buscarDatosUsuario(dataElemento[3]);

                var dataEdificio = getNombreEdficio(dataElemento[4], dataElemento[5]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion2").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus").val(campus);
                        $("#piso").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                        $("#fecha_modificado").val(record.fecha_modificado);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });
            }else if(elementosSeleccionados > 1){
                alert("Error. Sólo puede ser visualizar un elemento a la vez.");
            }else{
                alert("Error. Seleccione un elemento.");
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton visualizarOrdenes y se
     *  realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarOrdenes3").click(function() {
        try
        {
            var tablaSolicitado = $('#tablaSolicitado2').DataTable();
            var tablaRevisado = $('#tablaRevisado2').DataTable();
            var tablaRealizado = $('#tablaRealizado2').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if (elementosSeleccionados == 1) {
                var dataElemento;

                if(elementosSeleccionadosSolicitado.length == 1){
                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        dataElemento = record;
                    });
                }else if(elementosSeleccionadosRevisado.length == 1){
                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        dataElemento = record;
                    });
                }else{
                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        dataElemento = record;
                    });
                }

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[4];

                var piso = dataElemento[6];

                var dataUsuario = buscarDatosUsuario(dataElemento[3]);

                var dataEdificio = getNombreEdficio(dataElemento[4], dataElemento[5]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion2").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus2").val(campus);
                        $("#piso2").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                        $("#fecha_modificado").val(record.fecha_modificado);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio2").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });
            }else if(elementosSeleccionados > 1){
                alert("Error. Sólo puede ser visualizar un elemento a la vez.");
            }else{
                alert("Error. Seleccione un elemento.");
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton visualizarOrdenes y se
     *  realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarOrdenes4").click(function() {
        try
        {
            var tablaSolicitado = $('#tablaSolicitado3').DataTable();
            var tablaRevisado = $('#tablaRevisado3').DataTable();
            var tablaRealizado = $('#tablaRealizado3').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if (elementosSeleccionados == 1) {
                var dataElemento;

                if(elementosSeleccionadosSolicitado.length == 1){
                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        dataElemento = record;
                    });
                }else if(elementosSeleccionadosRevisado.length == 1){
                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        dataElemento = record;
                    });
                }else{
                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        dataElemento = record;
                    });
                }

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[4];

                var piso = dataElemento[6];

                var dataUsuario = buscarDatosUsuario(dataElemento[3]);

                var dataEdificio = getNombreEdficio(dataElemento[4], dataElemento[5]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion2").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus").val(campus);
                        $("#piso").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                        $("#fecha_modificado").val(record.fecha_modificado);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });
            }else if(elementosSeleccionados > 1){
                alert("Error. Sólo puede ser visualizar un elemento a la vez.");
            }else{
                alert("Error. Seleccione un elemento.");
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton visualizarOrdenes y se
     *  realiza la operacion correspondiente desplegar una ventana con los datos especificos de la orden .
     */
    $("#visualizarOrdenes5").click(function() {
        try
        {
            var tablaSolicitado = $('#tablaSolicitado4').DataTable();
            var tablaRevisado = $('#tablaRevisado4').DataTable();
            var tablaRealizado = $('#tablaRealizado4').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var elementosSeleccionados = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if (elementosSeleccionados == 1) {
                var dataElemento;

                if(elementosSeleccionadosSolicitado.length == 1){
                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        dataElemento = record;
                    });
                }else if(elementosSeleccionadosRevisado.length == 1){
                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        dataElemento = record;
                    });
                }else{
                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        dataElemento = record;
                    });
                }

                var data = buscarOrdenes(dataElemento[0]);

                //var campus = getNombreCampus(dataElemento[4]);

                var campus = dataElemento[4];

                var piso = dataElemento[6];

                var dataUsuario = buscarDatosUsuario(dataElemento[3]);

                var dataEdificio = getNombreEdficio(dataElemento[4], dataElemento[5]);

                $.each(data, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#divDialogVisualizacion").modal('show');
                        $("#campNumeroSolicitud").val(dataElemento[0]);
                        $("#sede").val("Cali");
                        $("#campus").val(campus);
                        $("#piso").val(piso);
                        $("#espacio").val(record.espacio);
                        $("#cantidad1").val(record.cantidad1);
                        $("#novedad1").val(record.descripcion1);
                        $("#descripcion_novedad").val(record.descripcion_novedad);
                        $("#cantidadN2").val(record.cantidad2);
                        $("#novedad2").val(record.descripcion2);
                        $("#descripcion_novedad2").val(record.descripcion_novedad2);
                        $("#cantidadN3").val(record.cantidad3);
                        $("#novedad3").val(record.descripcion3);
                        $("#descripcion_novedad3").val(record.descripcion_novedad3);
                        $("#contacto").val(record.contacto);
                        $("#estado").val(record.estado);
                        $("#descripcion").val(record.descripcion);
                        $("#fecha").val(record.fecha);
                        $("#fecha_modificado").val(record.fecha_modificado);
                    }
                });

                $.each(dataEdificio, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#edificio").val(record.codigo+" - "+record.nombre);
                    }
                });

                $.each(dataUsuario, function(index, record)
                {
                    if($.isNumeric(index))
                    {
                        $("#usuario").val(record.nombre_usuario);
                        $("#telefono").val(record.telefono);
                        $("#extension").val(record.extension);
                        $("#correo").val(record.correo);
                    }
                });
            }else if(elementosSeleccionados > 1){
                alert("Error. Sólo puede ser visualizar un elemento a la vez.");
            }else{
                alert("Error. Seleccione un elemento.");
            }
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Validad que el usuario seleccione una opcion valida del selector
     */
    $("#sistemaSearch").change(function (e) {
        var vlr = $("#sistemaSearch").find(':selected').val();
        var URLactual = window.location;

        if(vlr == 0){
            alert("Seleccione una opcion validad en el selector sistema");
            $('#divEdificio').css('display','none');
            $('#divPiso').css('display','none');
        }else{
            if (URLactual['href'].indexOf('listar_multiple_consultas') >= 0) {
                //$("#sistemaSearch option[value='TODOS']").remove();
                $('#divCampus').css('display','block');
                if (vlr != -1) {
                    $('#campusSearch').val("0");
                }else{
                    $('#divEdificio').css('display','none');
                    $('#divPiso').css('display','none');
                }
            }
        }
    });

    /**
     * captura el elemento seleccionado del select campus y de acuerdo a la seleccion actualiza el select de edificios
    */
    $("#campusSearch").change(function (e) {
        var vlr = $("#campusSearch").find(':selected').val();
        var URLactual = window.location;
        var correcto = true;

        if(vlr == 0){
            $("#edificioSearch").empty();
        }
        if(vlr == 1){
            var id = 01;
            $("#edificioSearch").empty();
            actualizarSelectEdificio(id);

        }
        else if(vlr == 2){
            var id = 02;
            $("#edificioSearch").empty();
            actualizarSelectEdificio(id);

        }
        else if(vlr == 3){
            var id = 03;
            $("#edificioSearch").empty();
            actualizarSelectEdificio(id);
        }
        else if(vlr == 4){
            $("#edificioSearch").empty();
        }
        else if(vlr == -1){
            $("#edificioSearch").empty();
        }
        else{
            correcto = false;

        }
        if (correcto) {
            if (URLactual['href'].indexOf('listar_multiple_consultas') >= 0 || URLactual['href'].indexOf('novedad_consultas') >= 0) {
                //$("#edificioSearch option[value='TODOS']").remove();
                if (vlr != -1) {
                    $('#divEdificio').css('display','block');
                    $('#buscarOrdenes3').attr("disabled", true);
                    $('#buscarOrdenes6').attr("disabled", true);
                }else{
                    $('#divEdificio').css('display','none');
                    $('#divPiso').css('display','none');
                    $("#buscarOrdenes3").removeAttr('Disabled');
                    $("#buscarOrdenes6").removeAttr('Disabled');
                }
            }
        }else{
            $('#divEdificio').css('display','none');
            $('#divPiso').css('display','none');
            $("#buscarOrdenes3").removeAttr('Disabled');
            $("#buscarOrdenes6").removeAttr('Disabled');
        }


    });

    /**
     * Valida que se seleccione una opcion valida del selector edificio
     */
    $("#edificioSearch").change(function (e) {
        var edificio = $("#edificioSearch").find(':selected').val();
        var URLactual = window.location;

        if(edificio == "--"){
            alert("Error. Seleccione una opción valida");
            $('#divPiso').css('display','none');
            $("#buscarOrdenes3").removeAttr('Disabled');
            $("#buscarOrdenes6").removeAttr('Disabled');
        }else{
            if (URLactual['href'].indexOf('listar_multiple_consultas') >= 0 || URLactual['href'].indexOf('novedad_consultas') >= 0) {
                if (edificio != 'TODOS') {
                    $("#pisoSearch").empty();
                    var edificio = $("#edificioSearch").find(':selected').val();
                    actualizarSelectPiso(edificio);
                    $('#divPiso').css('display','block');
                    $('#buscarOrdenes3').attr("disabled", true);
                    $('#buscarOrdenes6').attr("disabled", true);
                }else{
                    $('#divPiso').css('display','none');
                    $("#buscarOrdenes3").removeAttr('Disabled');
                    $("#buscarOrdenes6").removeAttr('Disabled');
                }
            }
        }
    });

    /**
     * Valida que se seleccione una opcion valida del selector edificio
     */
    $("#pisoSearch").change(function (e) {
        var piso = $("#pisoSearch").find(':selected').val();
        var URLactual = window.location;

        if(piso == "Seleccionar Piso"){
            $('#buscarOrdenes3').attr("disabled", true);
            $('#buscarOrdenes6').attr("disabled", true);
        }else{
            $("#buscarOrdenes3").removeAttr('Disabled');
            $('#buscarOrdenes6').removeAttr('Disabled');
        }
    });

    /**
    * captura el elemento seleccionado del select campus y de acuerdo a la seleccion actualiza el select de edificios
    */
   $("#novedadSearch").change(function (e) {
       var vlr = $("#novedadSearch").find(':selected').val();
       var fechaInicio = $("#searchFechaInicial").val();
       var fechaFin = $("#searchFechaFinal").val();

       if(vlr == 'Seleccionar'){
           $('#buscarOrdenes6').attr("disabled", true);
       }
   });

    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */
    $("#modificarOrdenes").click(function (e) {
        try {
            var tablaOrdenes = $('#tablaOrdenes').DataTable();

            var elementoSeleccionado = tablaOrdenes.rows('.selected').data();

            if(elementoSeleccionado.length <= 0) {
                alert("Error. Seleccione por lo menos un elemento");
            }
            else {
                actualizarSelectorEstado();
                $("#divOperario").css('display','none');
                $('#divSelectOperario').css('display','none');

                var data = [];

                $.each(elementoSeleccionado, function(index, record){
                    data = buscarSolicitud(record[0]);
                });

                $.each(data, function(index, record) {
                    if($.isNumeric(index)) {
                        $("#divDialogModificacion").modal("show");
                        $("#descripcion2").val(record.descripcion);
                        $("#usuario").val(record.usuario);
                        if(record.estado == 'Duplicado' || record.estado == 'No Aplica' || record.estado == 'Realizado'){
                            $('#selectEstado').val('Cerrado');
                            $("#selectTipoCerrado").val(record.estado);
                            if(record.estado == 'Realizado'){
                                $('#divOperario').css('display','block');
                                $('#divSelectOperario').css('display','block');
                                $("#selectOperario").val(record.operario);
                            }
                            $('#divTipoCerrado').css('display','block');
                        }else{
                            $('#selectEstado').val(record.estado);
                        }
                    }
                });
            }
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */
    $("#modificarOrdenes2").click(function (e) {
        try {
            var tablaSolicitado = $('#tablaSolicitado2').DataTable();
            var tablaRevisado = $('#tablaRevisado2').DataTable();
            var tablaRealizado = $('#tablaRealizado2').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var totalElementos = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(totalElementos <= 0) {
                alert("Error. Seleccione por lo menos un elemento");
            }
            else {
                actualizarSelectorEstado();
                $("#divOperario").css('display','none');
                $('#divSelectOperario').css('display','none');

                if(totalElementos == 1){
                     var data = [];

                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(data, function(index, record) {
                        if($.isNumeric(index)) {
                            $("#divDialogModificacion2").modal("show");
                            $("#descripcion2").val(record.descripcion);
                            $("#usuario").val(record.usuario);
                            if(record.estado == 'Duplicado' || record.estado == 'No Aplica' || record.estado == 'Realizado'){
                                $('#selectEstado').val('Cerrado');
                                $("#selectTipoCerrado").val(record.estado);
                                if(record.estado == 'Realizado'){
                                    $('#divOperario').css('display','block');
                                    $('#divSelectOperario').css('display','block');
                                    $("#selectOperario").val(record.operario);
                                }
                                $('#divTipoCerrado').css('display','block');
                            }else{
                                $('#selectEstado').val(record.estado);
                            }
                        }
                    });
                }else{
                    $("#divDialogModificacion2").modal("show");
                    $('#selectEstado').val('Seleccionar');
                    $("#descripcion2").val("");
                }
            }
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */
    $("#modificarOrdenes3").click(function (e) {
        try {
            var tablaSolicitado = $('#tablaSolicitado3').DataTable();
            var tablaRevisado = $('#tablaRevisado3').DataTable();
            var tablaRealizado = $('#tablaRealizado3').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var totalElementos = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(totalElementos <= 0) {
                alert("Error. Seleccione por lo menos un elemento");
            }
            else {
                actualizarSelectorEstado();
                $("#divOperario").css('display','none');
                $('#divSelectOperario').css('display','none');

                if(totalElementos == 1){
                     var data = [];

                    $.each(elementosSeleccionadosSolicitado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(elementosSeleccionadosRevisado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(elementosSeleccionadosRealizado, function(index, record){
                        data = buscarSolicitud(record[0]);
                    });

                    $.each(data, function(index, record) {
                        if($.isNumeric(index)) {
                            $("#divDialogModificacion3").modal("show");
                            $("#descripcion3").val(record.descripcion);
                            $("#usuario").val(record.usuario);
                            if(record.estado == 'Duplicado' || record.estado == 'No Aplica' || record.estado == 'Realizado'){
                                $('#selectEstado').val('Cerrado');
                                $("#selectTipoCerrado").val(record.estado);
                                if(record.estado == 'Realizado'){
                                    $('#divOperario').css('display','block');
                                    $('#divSelectOperario').css('display','block');
                                    $("#selectOperario").val(record.operario);
                                }
                                $('#divTipoCerrado').css('display','block');
                            }else{
                                $('#selectEstado').val(record.estado);
                            }
                        }
                    });
                }else{
                    $("#divDialogModificacion3").modal("show");
                    $('#selectEstado').val('Seleccionar');
                    $("#descripcion3").val("");
                }
            }
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */
    $("#modificarOrdenes5").click(function (e) {
        try {
            var tablaSolicitado = $('#tablaSolicitado4').DataTable();
            var tablaRevisado = $('#tablaRevisado4').DataTable();
            var tablaRealizado = $('#tablaRealizado4').DataTable();

            var elementosSeleccionadosSolicitado = tablaSolicitado.rows('.selected').data();
            var elementosSeleccionadosRevisado = tablaRevisado.rows('.selected').data();
            var elementosSeleccionadosRealizado = tablaRealizado.rows('.selected').data();

            var totalElementos = elementosSeleccionadosSolicitado.length + elementosSeleccionadosRevisado.length + elementosSeleccionadosRealizado.length;

            if(totalElementos <= 0) {
                alert("Error. Seleccione por lo menos un elemento");
            }
            else {
                actualizarSelectorEstado();
                $("#divOperario").css('display','none');
                $('#divSelectOperario').css('display','none');

                if(totalElementos == 1){
                     var data = [];

                     $.each(elementosSeleccionadosSolicitado, function(index, record){
                         data = buscarSolicitud(record[0]);
                     });

                     $.each(elementosSeleccionadosRevisado, function(index, record){
                         data = buscarSolicitud(record[0]);
                     });

                     $.each(elementosSeleccionadosRealizado, function(index, record){
                         data = buscarSolicitud(record[0]);
                     });

                    $.each(data, function(index, record) {
                        if($.isNumeric(index)) {
                            $("#divDialogModificacion4").modal("show");
                            $("#descripcion4").val(record.descripcion);
                            $("#usuario").val(record.usuario);
                            if(record.estado == 'Duplicado' || record.estado == 'No Aplica' || record.estado == 'Realizado'){
                                $('#selectEstado').val('Cerrado');
                                $("#selectTipoCerrado").val(record.estado);
                                if(record.estado == 'Realizado'){
                                    $('#divOperario').css('display','block');
                                    $('#divSelectOperario').css('display','block');
                                    $("#selectOperario").val(record.operario);
                                }
                                $('#divTipoCerrado').css('display','block');
                            }else{
                                $('#selectEstado').val(record.estado);
                            }
                        }
                    });
                }else{
                    $("#divDialogModificacion4").modal("show");
                    $('#selectEstado').val('Seleccionar');
                    $("#descripcion4").val("");
                }
            }
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    });

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes que hay
     * registrados en el sistema.
     */
    function actualizarTablaOrdenesVarios(data,idTabla) {

        var tablaOrdenes = $('#'+idTabla).DataTable();
        var campus;

        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);
                tablaOrdenes.row.add([
                    record.numero_solicitud,
                    record.impreso,
                    record.fecha,
                    record.usuario,
                    campus,
                    record.codigo_edificio,
                    record.piso,
                    record.espacio,
                    record.descripcion1,
                    record.cantidad1,
                    record.descripcion2,
                    record.cantidad2,
                    record.descripcion3,
                    record.cantidad3,
                    record.contacto,
                    record.estado]).draw(false);
            }
        });
    }

    /**
     * Función que actualiza la tabla en donde se muestran las ordenes que hay
     * registrados en el sistema.
     */
    function actualizarTablaOrdenesVarios2(data,id) {

        var tablaSolicitado = $('#tablaSolicitado'+id).DataTable();
        var tablaRevisado = $('#tablaRevisado'+id).DataTable();
        var tablaRealizado = $('#tablaRealizado'+id).DataTable();
        var campus;

        $.each(data, function(index, record) {
            if($.isNumeric(index)) {
                campus = getNombreCampus(record.codigo_campus);
                if(record.estado == 'Solicitado'){
                    tablaSolicitado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Revisado'){
                    tablaRevisado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
                else if(record.estado == 'Realizado' || record.estado == 'Duplicado' || record.estado == 'No Aplica'){
                    tablaRealizado.row.add([
                        record.numero_solicitud,
                        record.impreso,
                        record.fecha,
                        record.usuario,
                        campus,
                        record.codigo_edificio,
                        record.piso,
                        record.espacio,
                        record.descripcion1,
                        record.cantidad1,
                        record.descripcion2,
                        record.cantidad2,
                        record.descripcion3,
                        record.cantidad3,
                        record.contacto,
                        record.telefono,
                        record.extension,
                        record.estado]).draw(false);
                }
            }
        });
    }

    /**
     * Función que actualiza el selector dado
     */
    function actualizarSelectorEstado() {
        $('#selectEstado').empty();
        $('#selectEstado').append('<option value="Seleccionar">----Seleccionar----</option>');
        $('#selectEstado').append('<option value="Pendiente">Pendiente</option>');
        $('#selectEstado').append('<option value="Revisado">Revisado</option>');
        $('#selectEstado').append('<option value="Cerrado">Cerrado</option>');
        $('#selectTipoCerrado').empty();
        $('#selectTipoCerrado').append('<option value="Duplicado" selected="selected">Duplicado</option>');
        $('#selectTipoCerrado').append('<option value="No Aplica">No Aplica</option>');
        $('#selectTipoCerrado').append('<option value="Realizado">Realizado</option>');
        $('#divTipoCerrado').css('display','none');
    }

    /**
     * evento que permite guardar las modificaciones de las ordenes en la ventana modal
     */
    $("#btGuardarModOrdenes").click(function() {
        if(confirm("Esta seguro(a) que desea guardar" + " los cambios realizados a la orden","Confirmación"))
        {
            guardarModOrdenes('tablaOrdenes','');
            //enviarCorreo();
        }
    });

    /**
     * evento que permite guardar las modificaciones de las ordenes en la ventana modal
     */
    $("#btGuardarModOrdenes2").click(function() {
        if(confirm("Esta seguro(a) que desea guardar" + " los cambios realizados a la orden","Confirmación"))
        {
            guardarModOrdenes2('2');
            //enviarCorreo();
        }
    });

    /**
     * evento que permite guardar las modificaciones de las ordenes en la ventana modal
     */
    $("#btGuardarModOrdenes3").click(function() {
        if(confirm("Esta seguro(a) que desea guardar" + " los cambios realizados a la orden","Confirmación"))
        {
            guardarModOrdenes2('3');
            //enviarCorreo();
        }
    });

    /**
     * evento que permite guardar las modificaciones de las ordenes en la ventana modal
     */
    $("#btGuardarModOrdenes4").click(function() {
        if(confirm("Esta seguro(a) que desea guardar" + " los cambios realizados a la orden","Confirmación"))
        {
            guardarModOrdenes2('4');
            //enviarCorreo();
        }
    });

    $("#selectEstado").change(function(){
        if ($.trim($("#selectEstado").find(':selected').val()) == 'Cerrado') {
            $('#divTipoCerrado').css('display','block');
        }else{
            $('#divTipoCerrado').css('display','none');
            $('#divOperario').css('display','none');
            $('#divSelectOperario').css('display','none');
        }
    });

    $("#selectTipoCerrado").change(function(){
        if ($.trim($("#selectTipoCerrado").find(':selected').val()) == 'Realizado') {
            $('#divOperario').css('display','block');
            $('#divSelectOperario').css('display','block');
        }else{
            $('#divOperario').css('display','none');
            $('#divSelectOperario').css('display','none');
        }
    });

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
                    row3 = $("<option value='" + record.id + "'>"+record.novedad+"</option>");
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
                    row3 = $("<option value='" + record.id + "'>"+record.novedad+"</option>");
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
                    row3 = $("<option value='" + record.id + "'>"+record.novedad+"</option>");

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
});
