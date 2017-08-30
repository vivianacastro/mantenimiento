<?php
//definicion de la ruta de la aplicacion
define('__ROOT__', dirname(dirname(__FILE__)));
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log',  __ROOT__.'/errores.log');
date_default_timezone_set('America/Bogota');

//dependencias de la aplicacion
require_once __ROOT__.'/app/Config.php';
require_once __ROOT__.'/app/Constantes.php';
require_once __ROOT__.'/app/Controlador_vista.php';
require_once __ROOT__.'/app/mdl_registros/Modelo_registros.php';
require_once __ROOT__.'/app/mdl_registros/Controlador_registros.php';
require_once __ROOT__.'/app/mdl_consultas/Modelo_consultas.php';
require_once __ROOT__.'/app/mdl_consultas/Controlador_consultas.php';
require_once __ROOT__.'/app/mdl_modificacion/Modelo_modificacion.php';
require_once __ROOT__.'/app/mdl_modificacion/Controlador_modificacion.php';
require_once __ROOT__.'/app/mdl_usuario/Controlador_usuario.php';
require_once __ROOT__.'/app/mdl_usuario/Modelo_usuario.php';

//variable global
global $mesaje;

//mapa de enrutamiento
$map = array(
    'insertar_registros' => array('controlador' =>'Controlador_registros', 'action' =>'insertar'),
    'buscar_dinamico' => array('controlador' => 'Controlador_consultas', 'action' => 'buscarDinamico'),
    'insertar_orden' => array('controlador' =>'Controlador_registros', 'action' =>'insertarOrden'),
    'buscar_campus' => array('controlador' =>'Controlador_registros', 'action' =>'buscarCampus'),
    'buscar_piso' => array('controlador' =>'Controlador_registros', 'action' =>'buscarPiso'),
    'buscar_edificio' => array('controlador' =>'Controlador_registros', 'action' =>'buscarEdificio'),
    'buscar_novedad' => array('controlador' =>'Controlador_registros', 'action' =>'buscarNovedad'),
    'buscar_usuario' => array('controlador' =>'Controlador_registros', 'action' =>'buscarUsuario'),
    'buscar_ordenes_mantenimiento' => array('controlador' =>'Controlador_registros', 'action' =>'buscarOrdenes'),
    'listar_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listar'),
    'listar_historial' => array('controlador' =>'Controlador_consultas', 'action' =>'listarHistorial'),
    'listarf_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listarf'),
    'listar_multiple_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listars'),
    'listar_normal_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listarNormal'),
    'listar_ordenes' => array('controlador' =>'Controlador_consultas', 'action' =>'listarOrdenes'),
    'obtener_edificio' => array('controlador' =>'Controlador_consultas', 'action' =>'obtenerEdificio'),
    'obtener_historial' => array('controlador' =>'Controlador_consultas', 'action' =>'obtenerHistorial'),
    'obtener_ordenes_sistema' => array('controlador' =>'Controlador_consultas', 'action' =>'obtenerOrdenesSistema'),
    'buscar_orden' => array('controlador' =>'Controlador_consultas', 'action' =>'buscar'),
    'buscar_orden_parametros' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarParametros'),
    'buscar_orden_parametros_avanzados' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarParametrosAvanzados'),
    'obtener_datos_usuario' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarDatosUsuario'),
    'obtener_nombre_edificio' => array('controlador' =>'Controlador_consultas', 'action' =>'obtenerDatosEdificio'),
    'actualizar_orden' => array('controlador' =>'Controlador_modificacion', 'action' =>'modificar'),
    'actualizar_orden_varios' => array('controlador' =>'Controlador_modificacion', 'action' =>'modificarVarios'),
    'eliminar_orden' => array('controlador' =>'Controlador_modificacion', 'action' =>'eliminar'),
    'listar_modificacion' => array('controlador' =>'Controlador_modificacion', 'action' =>'listar'),
    'listarn_modificacion' => array('controlador' =>'Controlador_modificacion', 'action' =>'listarn'),
    'buscar_solicitudes_mantenimiento' => array('controlador' =>'Controlador_modificacion', 'action' =>'buscarSolicitud'),
    'enviar_correo' => array('controlador' =>'Controlador_modificacion', 'action' =>'enviarCorreo'),
    'administrar_autorizado_usuario' => array('controlador' =>'Controlador_usuario', 'action' =>'administrar_usuario_autorizado'),
    'buscar_autorizados_manejar_sistema' => array('controlador' =>'Controlador_usuario', 'action' =>'buscar_autorizados_manejar_sistema'),
    'iniciar_sesion' => array('controlador' =>'Controlador_usuario', 'action' =>'iniciar_sesion'),
    'listar_electrico_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listar_electrico'),
    'listar_hidraulico_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listar_hidraulico'),
    'listar_mobiliario_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listar_mobiliario'),
    'listar_planta_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listar_planta'),
    'obtener_ordenes_electrico' => array('controlador' =>'Controlador_consultas', 'action' =>'ordenes_electrico'),
    'obtener_ordenes_hidraulico' => array('controlador' =>'Controlador_consultas', 'action' =>'ordenes_hidraulico'),
    'obtener_ordenes_mobiliario' => array('controlador' =>'Controlador_consultas', 'action' =>'ordenes_mobiliario'),
    'obtener_ordenes_planta' => array('controlador' =>'Controlador_consultas', 'action' =>'ordenes_planta'),
    'buscar_estadisticas_sistema' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarEstadisticasSistema'),
    'novedades' => array('controlador' =>'Controlador_modificacion', 'action' =>'novedades'),
    'obtener_novedades' => array('controlador' =>'Controlador_modificacion', 'action' =>'obtenerNovedades'),
    'actualizar_novedad' => array('controlador' =>'Controlador_modificacion', 'action' =>'actualizarNovedad'),
    'crear_novedad' => array('controlador' =>'Controlador_modificacion', 'action' =>'crearNovedad'),
    'buscar_novedades' => array('controlador' =>'Controlador_modificacion', 'action' =>'buscarNovedad'),
    'listardia_consultas' => array('controlador' =>'Controlador_consultas', 'action' =>'listarDia'),
    //'olvido_contrasenia' => array('controlador' =>'Controlador_usuario', 'action' =>'olvido_contrasenia'),
    //'reestablecer_contrasenia' => array('controlador' =>'Controlador_usuario', 'action' =>'reestablecer_contrasenia'),
    'salir_sesion' => array('controlador' =>'Controlador_usuario', 'action' =>'salir_sesion'),
    'actualizar_impreso' => array('controlador' =>'Controlador_consultas', 'action' =>'actualizarImpreso'),
    'estadisticas_edificios' => array('controlador' =>'Controlador_consultas', 'action' =>'mostrarEstadisticasEdificios'),
    'estadisticas_espacios' => array('controlador' =>'Controlador_consultas', 'action' =>'mostrarEstadisticasEspacios'),
    'estadisticas_sistema' => array('controlador' =>'Controlador_consultas', 'action' =>'mostrarEstadisticasSistema'),
    'estadisticas_operador' => array('controlador' =>'Controlador_consultas', 'action' =>'mostrarEstadisticasOperador'),
    'estadisticas_novedades' => array('controlador' =>'Controlador_consultas', 'action' =>'mostrarEstadisticasNovedades'),
    'crear_usuario_autorizado_para_adm_sistema' => array('controlador' =>'Controlador_usuario', 'action' =>'crear_usuario_autorizado_para_adm_sistema'),
    'eliminar_usuario_autorizado_adm_sistema' => array('controlador' =>'Controlador_usuario', 'action' =>'eliminar_usuario_autorizado_adm_sistema'),
    'modificar_perfil_usuario_autorizado_adm_sistema' => array('controlador' =>'Controlador_usuario', 'action' =>'modificar_perfil_usuario_autorizado_adm_sistema'),
    'buscar_usuario_sistema' => array('controlador' =>'Controlador_usuario', 'action' =>'buscarUsuario'),
    'cambiar_datos' => array('controlador' =>'Controlador_usuario', 'action' =>'cambiar_datos'),
	'obtener_estadisticas_edificios' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarEdificiosMasOrdenes'),
    'obtener_estadisticas_espacios' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarEspaciosMasOrdenes'),
    'obtener_estadisticas_operador' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarEstadisticasOperador'),
    'obtener_estadisticas_novedades' => array('controlador' =>'Controlador_consultas', 'action' =>'buscarEstadisticasNovedades'),
    //'crear_cuenta_usuario' => array('controlador' =>'Controlador_usuario', 'action' =>'crearCuentaUsuario'),
    //'crear_nuevo_usuario' => array('controlador' =>'Controlador_usuario', 'action' =>'crear_nuevo_usuario')
);

// Parseo de la ruta
if (isset($_GET['action']))
{
    if (isset($map[$_GET['action']]))
    {
        $ruta = $_GET['action'];
    }
    else
    {
        header('Status: 404 Not Found');
        echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                $_GET['action'] .
                '</p></body></html>';
        exit;
    }
}
else
{
    $ruta = 'iniciar_sesion';
}

// Checkear el acceso del usuario
if(!call_user_func(array(new Controlador_usuario, 'check')))
{
    $ruta = 'iniciar_sesion';
}

$controlador = $map[$ruta];

// Ejecución del controlador asociado a la ruta
if (method_exists($controlador['controlador'],$controlador['action']))
{
    call_user_func(array(new $controlador['controlador'], $controlador['action']));
}
else
{
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
            $controlador['controlador'] .
            '->' .
            $controlador['action'] .
            '</i> no existe</h1></body></html>';
}
?>
