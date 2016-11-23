<?php

$GLOBALS [$action] = $_POST['action'];

if($GLOBALS[$action] == 'check_Email')
{
	$correo = $_POST['correo'];
	check_Email($correo);
}

function check_Email($correo)
{
	$dbconn = pg_connect("host=localhost dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());
	$result2 = pg_query("SELECT * FROM usuarios_autorizados_sistema WHERE correo ='$correo'");
	if(pg_num_rows($result2) > 0) {
		echo "<div style='color: red'><strong>{$correo}... </strong>E-mail	 ya registrado. No disponible</div>";
		pg_close($dbconn);
		return 0;
	}
	pg_close($dbconn);
}

if($GLOBALS[$action] == 'check_Correo')
{
	$correo = $_POST['correo'];
	check_Email($correo);
}


function check_Correo($correo)
{
	$dbconn = pg_connect("host=localhost dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());
	$result3 = pg_query("SELECT * FROM usuarios_autorizados_sistema WHERE correo ='".$correo."'");
	if(pg_num_rows($result3) == 0) {
		echo "<div style='color: red'><strong>{$correo}... </strong>El correo no se encuentra asociado a una cuenta en el sistema</div>";
		pg_close($dbconn);
		return 0;
	}
	pg_close($dbconn);
}

if($GLOBALS[$action] == 'check_Username')
{
	$u = $_POST['usuario'];
	check_Username($u);
}

function check_Username($u)
{
	$dbconn = pg_connect("host=localhost dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());
	$result = pg_query("SELECT * FROM usuarios_autorizados_sistema WHERE login ='$u'");

	if(pg_num_rows($result) > 0) {
		echo "<div style='color: red'><strong>{$u}... </strong>Usuario ya registrado. No disponible.</div>";
		pg_close($dbconn);
		return 0;
	}
	/*else {
		echo "<span class='yes'><strong>{$u}... </strong>Usuario disponible.</span>";
		pg_close($dbconn);
		return 0;
	}*/
}
?>