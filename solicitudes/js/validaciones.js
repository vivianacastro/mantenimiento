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

});

$(document).ready(function() {

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

});


$(document).ready(function() {

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
		alert("El campo Email, no es válido");
		document.form2.correo2.focus();
		verificar = false;
		return false;
	}

	if(verificar){
		document.form2.submit();
	}
 }