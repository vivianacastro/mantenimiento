$(document).ready(function() {

    var tablaUsuarios = $('#tablaUsuarios').DataTable({
        "paging":           true,
        "info":             true,
        "bFilter":          true,
        "bInfo":            true,
        "bDestroy":         true,
        "responsive":       true,
        "language": {
            "url":          "js/plugins/Espanol.json",
        }
    });

    $('#tablaUsuarios tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );

    actualizarTablaUsuariosAutorizados();
    
    /**
     * Función que permite consultar uno o varios usuarios con acceso al sistema
     * @param {strign} consulta, palabra clave.
     * @returns {data}
     */
    function buscarUsuarioAutorizado(consulta)
    {
        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_autorizados_manejar_sistema",
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
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }
    }

      /**
     * Función que permite consultar uno o varios usuarios con acceso al sistema
     * @param {strign} consulta, palabra clave.
     * @returns {data}
     */
    function buscarUsuarioSistema(consulta) {

        var dataResult;

        try {
            $.ajax({
                type: "POST",
                url: "index.php?action=buscar_usuario_sistema",
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
                }
            });
            return dataResult;
        }
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }
    }
    
    /**
     * Función que actualiza la tabla en donde se muestran los usuarios con 
     * acceso al sistema registrados.
     */      
    function actualizarTablaUsuariosAutorizados(data) {
        var info;
        var URLactual = window.location;

        if(URLactual['href'].indexOf('administrar_autorizado_usuario') >= 0){
            if(data == null){
                $('#tablaUsuarios').dataTable().fnClearTable();
                info = buscarUsuarioAutorizado("");
            }else{
                //info = buscarUsuarioAutorizado(data);
                $.each(data, function(index, record) {
                    if($.isNumeric(index)) {
                        info = buscarUsuarioAutorizado(record[1]);
                    }
                });
                //console.log(info);
            }

            $.each(info, function(index, record) {
                if($.isNumeric(index)) {
                    tablaUsuarios.row.add([
                        record.nombre_usuario,
                        record.login,
                        record.perfil,
                        record.correo,
                        record.telefono,
                        record.extension]).draw(false);
                }
            });
            $("#divTablas").show();
        }
    }  
    
    /**
     * Se captura el evento cuando de dar click en el boton crear_usuario y se
     * realiza la operacion correspondiente.
     */     
    $("#crear_usuario").click(function () {
        try {           
            var nombre_usuario = $.trim($("#nombre_usuario").val());
            var login = $.trim($("#login").val());
            var password = $.trim($("#password").val());
            var r_password = $.trim($("#r_password").val());
            var perfil = $.trim($("#perfil").find(':selected').val());
            var correo = $.trim($("#correo").val());
            var telefono = $.trim($("#telefono").val());
            var extension = $.trim($("#extension").val());
                        
            if(nombre_usuario == '' || login == '' || password == '' || r_password == '' || perfil == '' || correo == '' || telefono == '' || extension == '') {
                alert("Por favor llene todos los campos.");
                return false;
            }
            
            var saveData = {};
            saveData["nombre_usuario"] = nombre_usuario;
            saveData["login"] = login;
            
            if(password == r_password) {
                saveData["password"] = password;
                //$("#div_r_password").html("<font color='red'>*</font>Repita la contraseña:");
            } else {
                alert("ERROR. Las contraseñas no coinciden");
                /*$("#div_r_password").html("<font color='red'>*</font>Repita la contraseña:");
                $("#div_r_password").append("<br /><font color='red'>\n\
                                No coincide con la contrase&ntilde;a</font>");*/
                return false;
            }
            saveData["perfil"] = perfil;
            saveData["correo"] = correo;
            saveData["telefono"] = telefono;
            saveData["extension"] = extension;

            console.log(saveData);
            
            var jObject = JSON.stringify(saveData);
            $.ajax({
                type: "POST",
                url: "index.php?action=crear_usuario_autorizado_para_adm_sistema",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    //console.log(error.toString());
                    location.reload(true);
                },
                success: function(result){
                    if(result.value == true) {
                        actualizarTablaUsuariosAutorizados();
                        alert(result.mensaje);
                        $("#nombre_usuario").val('');
                        $("#login").val('');
                        $("#password").val('');
                        $("#r_password").val('');
                        $("#correo").val('');
                        $("#telefono").val('');
                        $("#extension").val('');
                    }
                    else {
                        alert(result.mensaje);
                    }
                }
            });
        } catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }        
    });

    $("#cerrar").click(function () {
        $("#crearUsuarioAutorizado").show();
        $("#divBusqueda").show();
        $(".divBotonOpcionU").show(); 
        $("#divCrearNuevoUsuario").hide();
    });

    /**
     * Función que permite eliminar uno o varios usuarios con acceso al sistema
     a.
     * @param {array} data, datos de los usuarios a eliminar.
     */
    function eliminarUsuarioAutorizado(data) {
        try {
            var jObject = JSON.stringify($.extend({},data));
            console.log(jObject);
            
            $.ajax({
                type: "POST",
                url: "index.php?action=eliminar_usuario_autorizado_adm_sistema",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
                    location.reload(true);
                },
                success: function(result){  
                    if(result.value == true) {
                        var rows = tablaUsuarios
                                .rows('.selected')
                                .remove()
                                .draw();
                        alert(result.mensaje);
                    }
                    else {
                        alert(result.mensaje);
                    }
                }
            });
        } 
        catch(ex) {
            alert("ERROR: Ocurrio un error " + ex);
        }          
    }
    
    /**
     * Se captura el evento cuando de da click en el boton eliminar y se
     * realiza la operacion correspondiente.
     */      
    $("#eliminarUsuarioAutorizado").click(function() {
        var data = [];

        var tablaUsuarios = $('#tablaUsuarios').DataTable();

        var elementoSeleccionado = tablaUsuarios.rows('.selected').data();

        if (elementoSeleccionado.length > 0) { 
            if(confirm("¿Esta seguro(a) que desea eliminar" 
                    + " el/los usuario(s) seleccionado(s)?")) {
                $.each(elementoSeleccionado, function(index, record) {
                    data.push(record[1]);
                });
                eliminarUsuarioAutorizado(data);
            }
        } else { 
            alert("Error. Por favor seleccione por lo menos un usuario"); 
            return;
        }      
    });
    
    /**
     * Se captura el evento cuando de da click en el boton modificar y se
     * realiza la operacion correspondiente.
     */    
    $("#modificarUsuarioAutorizado").click(function() {
        try {
            var tablaUsuarios = $('#tablaUsuarios').DataTable();

            var elementoSeleccionado = tablaUsuarios.rows('.selected').data();
            
            if(elementoSeleccionado.length == 0) {
                alert("Error. Seleccione por lo menos un elemento");
            }else if(elementoSeleccionado.length == 1){
                var data;

                $.each(elementoSeleccionado, function(index, record){
                    data = buscarUsuarioAutorizado(record[1]);
                });

                $.each(data, function(index, record) {
                    if($.isNumeric(index)) {
                        $("#divDialogModificacion").modal("show");
                        $("#campUsuario").val(record.nombre_usuario);
                        $("#campLogin").val(record.login);
                        $("#campPerfil").val(record.perfil);
                    }
                });
            }
            else{
                alert("Error. Solamente se puede modificar un usuario a la vez");
            }
        } 
        catch(ex) {
            console.log(ex);
            alert("Error");
        }
    });
    
    /**
     * Función que permite modificar los datos de un usuario con acceso al
     * sistema.
     */     
    function guardarModUsuarioAutorizado() {
        try {

            var tablaUsuarios = $('#tablaUsuarios').DataTable();

            var elementoSeleccionado = tablaUsuarios.rows('.selected').data();          

            var saveData = {};

            $.each(elementoSeleccionado, function(index, record){
                saveData["login"] = record[1];
            });
            saveData["perfil"] = $("#campPerfil").find(':selected').val();

            var jObject = JSON.stringify(saveData);
            $.ajax({
                type: "POST",
                url: "index.php?action=modificar_perfil_usuario_autorizado_adm_sistema",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
                    location.reload(true);
                },
                success: function(result){
                    if(result.value == true) {
                        actualizarTablaUsuariosAutorizados(saveData["login"]);
                        var rows = tablaUsuarios
                                .rows('.selected')
                                .remove()
                                .draw();

                        $("#divDialogModificacion").modal('toggle');
                        alert(result.mensaje);                        
                    }
                    else {
                        alert(result.mensaje);
                    }
                }
            });
        } catch(ex) {
            alert(ex);
        }        
    }
    
    /**
     * Se captura el evento cuando de da click en el boton guardar modificación
     * y se realiza la operacion correspondiente.
     */      
    $("#btGuardarModUsuarioAutorizado").click(function() {    
        if(confirm("Esta seguro(a) que desea guardar" 
                + " los cambios realizados al usuario","Confirmación")) {
            guardarModUsuarioAutorizado();
        } 
    });    
    
    /*------------------------------------------------------------------------*/
    /*------------------------Actualizar Datos-------------------------------*/

    /**
     * Se captura el evento cuando de da click en el guardar cambio.
     * y se realiza la operacion correspondiente.
     */ 
    
    function cambiarDatos() {
        try {
            var act_password = $("#act_password").val();
            var password = $("#password").val();
            var r_password = $("#r_password").val();
            var correo = $("#correo").val();
            var telefono = $("#telefono").val();
            var extension = $("#extension").val();
            
            //validar campos null
            if(act_password == '' & password == '' & r_password == '' & 
                correo == '' & telefono == '' & extension == '') {
                alert("Por favor llene alguno los campos");
                return false;
            }

            var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!expr.test(correo) && correo != ""){
                alert("Error: La dirección de correo es inválida.");
                return false;
            }

            var expresionRegular1=/^\d*$/;//<--- con esto vamos a validar el numero
            var expresionRegular2=/\s/;//<--- con esto vamos a validar que no tenga espacios en blanco

            if(expresionRegular2.test(telefono) && telefono != ""){
                alert('Error, teléfono no válido.');
                return false;
            }
            else if(!expresionRegular1.test(telefono) && telefono != ""){
                alert('Error, teléfono no válido.');
                return false;
            }
            else if(expresionRegular2.test(extension) && extension != ""){
                alert('Error, extensión no válida.');
                return false;
            }
            else if(!expresionRegular1.test(extension) && extension != ""){
                alert('Error, extensión no válida.');
                return false;
            }
            else if(telefono != "" & extension == ""){
                alert("Por favor proporcione una extensión");
                return false;
            }

            var saveData = {};

            saveData["act_password"] = act_password;

            //validar contraseña
            if(password == r_password) {
                 saveData["password"] = password;
                 //$("#div_r_password").html("<font color='red'>*</font>Repita la contraseña:");
            } else {
                alert("ERROR. Las contraseñas no coinciden");
                $("#r_password").focus();
                /*$("#div_r_password").html("<font color='red'>*</font>Repita la contraseña:");
                $("#div_r_password").append("<br /><font color='red'>\n\
                                No coincide con la contrase&ntilde;a</font>");*/
                return false;
            }

            saveData["correo"] = correo;
            saveData["telefono"] = telefono;
            saveData["extension"] = extension;
            //console.log(saveData);
            var jObject = JSON.stringify(saveData);

            $.ajax({
                type: "POST",
                url: "index.php?action=cambiar_datos",
                data: {jObject:  jObject},
                dataType: "json",
                error: function(error){
                    alert("La sesión ha expirado, por favor ingrese nuevamente al sistema");
                    console.log(error.toString());
                    location.reload(true);
                },
                success: function(result){
                    if(result.value == true) {
                        alert(result.mensaje);     
                        $("#act_password").val('');
                        $("#password").val('');
                        $("#r_password").val('');
                        $("#correo").val('');
                        $("#telefono").val('');
                        $("#extension").val('');                        
                    }
                    else {
                        alert(result.mensaje);
                        $("#act_password").val('');
                        $("#password").val('');
                        $("#r_password").val('');
                        $("#correo").val('');
                        $("#telefono").val('');
                        $("#extension").val('');                          
                    }
                }
            });
        } catch(ex) {
            alert(ex);
        }        
    }
    
    /**
     * Se captura el evento cuando de da click en el boton cambiar datos
     * y se realiza la operacion correspondiente.
     */     
    $("#cambiar_datos").click(function () {
        if(confirm("Esta seguro(a) que desea realizar" 
                + " los cambios en su datos de usuario","Confirmación")) {
            cambiarDatos();
        }       
    });

    /**
     * se captura el evento cuando se da click en el boton buscar y se realiza la accion correspondiente
     */
    $("#buscarUsuarioAutorizado").click(function (e) {
        try{
            var vlr = $.trim($("#search").val());

            if(vlr == ""){
                alert("Ingrese un valor en el campo de busqueda no puede estar vacio.");
            }
            else{
                var data = buscarUsuarioSistema(vlr);
                actualizarTablaUsuariosAutorizados(data)
            }
        }
        catch(ex)
        {
            alert(ex.toString());
        }
    });

    /**
     * eventos para controlar lo que se muestra en la vista del modulo de usuario
     */
    $("#divCrearNuevoUsuario").hide();

    /**
     * eventos para controlar lo que se muestra en la vista del modulo de usuario 
     */
    $("#crearUsuarioAutorizado").click(function (e) {
        $("#divCrearNuevoUsuario").modal("show");
        /*$(this).hide();
        $("#divBusqueda").hide();
        $(".divBotonOpcionU").hide(); 
        $("#divCrearNuevoUsuario").show();*/
    });

    $("#limpiar").click(function(e){
        $("#search").val("");
        $("#tablaUsuarios").clearGridData();
        actualizarTablaUsuariosAutorizados();
    })
});