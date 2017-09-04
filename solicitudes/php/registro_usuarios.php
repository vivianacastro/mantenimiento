<?php

session_start();
$nombre = strtolower(trim($_POST['nombre1']));
$nombre = ucwords($nombre);
$correo = trim($_POST['correo']);
$telefono = trim($_POST['telefono']);
$extension = trim($_POST['extension']);
$usuario = strtolower($_POST['usuario']);
$contrasena = $_POST['contrasena'];
$perfil = "normal";
$c = md5($contrasena);


// conexion a la base de datos
$dbconn = pg_connect("host=localhost port=5432 dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());

$query = "INSERT INTO usuarios_autorizados_sistema (nombre_usuario, perfil, correo, telefono, extension, login, password, fecha) VALUES ('$nombre', '$perfil', '$correo', '$telefono', '$extension', '$usuario', '$c', 'now()')";


if( ! $result = pg_query($dbconn, $query) ){
    echo '<script type="text/javascript">confirm("El usuario ya se encuentra registrado");</script>';
    echo '<script type="text/javascript">' ."\n";
    echo 'window.location="../crear_usuarios.html";';
    echo '</script>';
	pg_close($dbconn);
}else{
    pg_close($dbconn);
    echo "<script type='text/javascript'>confirm('El usuario fue registrado correctamente');</script>";
    echo '<script type="text/javascript">' . "\n";
    echo 'window.location="http://192.168.46.53/mantenimiento/web/index.php";';
    echo '</script>';
}
session_destroy();
?>
