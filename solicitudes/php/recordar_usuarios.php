<?php
// conexion a la base de datos
$dbconn = pg_connect("host=localhost port=5432 dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());
$info = json_decode($_POST['jObject'], true);
$correo = htmlspecialchars($info["correo"]);
$result3 = pg_query("SELECT * FROM usuarios_autorizados_sistema WHERE correo = '".$correo."';");

$arreglo = pg_fetch_all($result3);
$data = array();
foreach ($arreglo as $clave => $valor) {
    $arrayAux = array(
        'nombre' => $valor['nombre_usuario'],
        'usuario' => $valor['login'],
    );
    array_push($data, $arrayAux);
}
echo json_encode($data);
session_destroy();
?>
