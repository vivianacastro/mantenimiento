
$(document).ready(function() {

    var tablaNovedades = $('#tablaNovedades').DataTable({
        "paging":           true,
        "info":             true,
        "bFilter":          true,
        "bInfo":            true,
        "bDestroy":         true,
        "select":           true,
        "responsive":       true,
        "language": {
            "url":          "js/plugins/Espanol.json",
        }
    });

    actualizarTablaNovedades();

    /**
    * Función que realiza la consulta de las novedades por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function obtenerNovedades(consulta){
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=obtener_novedades",
                data: "buscar=" + consulta,
                dataType: "json",
                async: false,
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
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
    * Función que realiza la consulta de una novedad por medio de ajax.
    * @param {string} consulta, Cadena que representa la palabra clave.
    * @returns {data}
    **/
    function buscarNovedad(consulta){

        var saveData = [];
        saveData["novedad"] = consulta;
        var jObject = JSON.stringify(consulta);

        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_novedades",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
                    location.reload(true);
                },
                success: function(data){
                    dataResult = data;
                    mostrarMensaje(dataResult.mensaje);
                    actualizarTablaNovedades(dataResult);
                }
            });
        }
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    }

    /**
     * Función que actualiza la tabla en donde se muestran las novedades que hay
     * registrados en el sistema.
     */    
    function actualizarTablaNovedades(data) {
        var URLactual = window.location;

        if(URLactual['href'].indexOf('novedades') >= 0){            
            if(data == null){
                $('#tablaNovedades').dataTable().fnClearTable();
                data = obtenerNovedades();
            }
            $.each(data, function(index, record) {
                if($.isNumeric(index)) {
                    tablaNovedades.row.add([
                        record.descripcion_novedad,
                        record.sistema]).draw(false);
                }
            });
            $("#divTablas").show();
        }
    }

/*************************Funciones de Modificacion***********************************/
    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */    
    $("#modificarNovedad").click(function (e) {
        try {
            var tablaNovedades = $('#tablaNovedades').DataTable();

            var elementoSeleccionado = tablaNovedades.rows('.selected').data();

            $("#divDialogModificacion").modal("show");

            $.each(elementoSeleccionado, function(index, record) {
                $("#novedad").val(record[0]);
                $("#selectSistema").val(record[1]);
            });
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
    $("#crearNovedad").click(function (e) {
        try {
            $("#novedadNueva").val("");
            $("#selectSistemaNueva").val("Sistema Eléctrico");
            $("#divDialogCreacion").modal("show");
        } 
        catch(ex) {
            console.log(ex);
            alert("Error");
        }         
    });

    /**
     * Se captura el evento cuando de da click en el boton guardar modificación
     * y se realiza la operacion correspondiente.
     */     
    function guardarModNovedad(){
        try {

            var tablaNovedades = $('#tablaNovedades').DataTable();

            var elementoSeleccionado = tablaNovedades.rows('.selected').data();
            
            if($.trim($("#novedad").val()) == ""){
                alert("Error, la descripción de la novedad no puede estar vacía");
                $("#novedad").focus();
            }else{
                var saveData = {}, novedad;
                          
                $.each(elementoSeleccionado, function(index, record) {
                    novedad = record[0];
                });
                
                saveData["novedad"] = novedad;
                saveData["novedadNueva"] = $("#novedad").val();
                saveData["sistema"] = $.trim($("#selectSistema").find(':selected').val());

                var jObject = JSON.stringify(saveData);

                //console.log(saveData);

                $.ajax({
                    type: "POST",
                    url: "index.php?action=actualizar_novedad",
                    data: {jObject:  jObject},
                    dataType: "json",
                    error: function(error){
                        alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                        console.log(error.toString());
                        location.reload(true);
                    },
                    success: function(result){
                        if(result.value == true) {
                            $("#divDialogModificacion").modal('toggle');
                            alert(result.mensaje);

                            $.each(elementoSeleccionado, function(index, record){
                                var data = buscarNovedad(record[0]); //record[0] = Número Solicitud
                            });

                            var rows = tablaNovedades
                                .rows('.selected')
                                .remove()
                                .draw();
                        }
                        else {
                            alert(result.mensaje);
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
    function guardarNovedad(){
        try {           
            var saveData = {};
                          
            saveData["novedad"] = $("#novedadNueva").val();
            saveData["sistema"] = $.trim($("#selectSistemaNueva").find(':selected').val());

            var jObject = JSON.stringify(saveData);

            console.log(saveData);

            $.ajax({
                type: "POST",
                url: "index.php?action=crear_novedad",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
                    location.reload(true);
                },
                success: function(result){
                    if(result.value == true) {
                        $("#divDialogCreacion").modal("toggle");
                        alert(result.mensaje);
                        actualizarTablaNovedades();
                    }
                    else {
                        alert(result.mensaje);
                    }
                }
            });
        }
        catch(ex)
        {
            console.log(ex);
            alert("Error");
        }        
    }

    /**
     * evento que permite guardar las modificaciones de las novedades en la ventana modal
     */
    $("#btGuardarModNovedad").click(function() {  
        if(confirm("¿Esta seguro(a) que desea guardar" + " los cambios realizados a la novedad?","Confirmación"))
        {
            guardarModNovedad();
        }
    });

    /**
     * evento que permite guardar las modificaciones de las novedades en la ventana modal
     */
    $("#btGuardarNovedad").click(function() {  
        if(confirm("¿Esta seguro(a) que desea guardar" + " la novedad?","Confirmación"))
        {
            guardarNovedad();
        }
    });
});