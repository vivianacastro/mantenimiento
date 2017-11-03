$(document).ready(function() {
	$("#correo").blur(function() { // when focus out
		var form_data = {
			action: 'check_Email',
			correo: $(this).val()
		};
		$.ajax({
			type: "POST",
			url: "php/Functions.php",
			data: form_data,
			success: function(result) {
				$("#messageCorreo").html(result);
			}
		});
	});

	$("#enviarCorreo").click(function() {
		var form_data = {
			action: 'check_Correo',
			correo: $(this).val()
		};
		$.ajax({
			type: "POST",
			url: "php/Functions.php",
			data: form_data,
			success: function(result) {
				$("#messageCorreo").html(result);
			}
		});
	});

	$("#usuario").blur(function() { // when focus out
		var user = $(this).val();
		user = user.toLowerCase();
		var form_data = {
			action: 'check_Username',
			usuario: user
		};
		$.ajax({
			type: "POST",
			url: "php/Functions.php",
			data: form_data,
			success: function(result) {
				$("#messageUsr").html(result);
			}
		});
	});

	$("#recordarUsuario").click(function() {
		var verificar = true;
		var expRegEmail = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		if (!expRegEmail.exec(correo2.value)){
		   alert("El correo, no es válido");
		   correo2.focus();
		   verificar = false;
		   return false;
		}
		if(verificar){
		   var correo = correo2.value;
		   var info = {};
		   info["correo"] = correo;
		   var jObject = JSON.stringify(info);
		   $.ajax({
			   type: "POST",
			   url: "php/recordar_usuarios.php",
			   data: {jObject:jObject},
			   dataType: "json",
			   async: false,
			   error: function(xhr, status, error) {
				   var err = eval("(" + xhr.responseText + ")");
				   console.log(err.Message);
			   },
			   success: function(data) {
				   if (data.length < 1) {
					   alert("No hay usuarios registrados con el correo ingresado");
				   }else{
					   for (var i = 0; i < data.length; i++) {
						   $("#tabla_usuarios").append("<tr id='tr_tabla_usuarios'><td>"+data[i]["usuario"]+"</td><td>"+data[i]["nombre"]+"</td></tr>");
					   }
					   $("#divDialogUsuario").modal("show");
				   }
			   }
		   });
		}
	});
	$("#divDialogUsuario").on('hidden.bs.modal', function () {
		window.location = "http://192.168.46.53/mantenimiento/web/index.php";
    });
});

function checkData () {
	var verificar = true;
	var contrasena = document.getElementById("contrasena").value;
	var contrasena2 = document.getElementById("contrasena2").value;
	if (contrasena != contrasena2) {
		alert("Verifique: Diferentes Contraseñas");
		document.form1.contrasena.focus();
		return false;
	}
 }

function check() {
	var verificar = true;
	var expRegEmail = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	if (!expRegEmail.exec(form2.correo2.value)){
		alert("El correo, no es válido");
		document.form2.correo2.focus();
		verificar = false;
		return false;
	}
	if(verificar){
		document.form2.submit();
	}
 }
