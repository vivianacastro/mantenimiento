/**
*funciones globales de la aplicacion 
*/
$(document).ready(function () {
	setTimeout(function() {
        $("#divDialogTimeOut").modal('show');
    },1200000);
    $('#divDialogTimeOut').on('hidden.bs.modal', function () {
    	location.reload();
	})
});

/**
 * Función que muestra el texto como mensaje en el panel superior.
 * @param {string} texto, Cadena que representa el mensaje a mostrar.
 * @returns {undefined}
 */
function mostrarMensaje(texto) {
        $("#divMensaje").empty();
        $("#divMensaje").text(texto);
}