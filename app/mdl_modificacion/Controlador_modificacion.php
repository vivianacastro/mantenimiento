<?php
//Librerías para el envío de mail
include_once('class.phpmailer.php');
include_once('class.smtp.php');
/**
 * Descripcion del controlador del modulo
 *
 */

class Controlador_modificacion
{

    /**
     * Función que despliega el panel que permite visualizar las ordenes que
     * hay en el sistema.
     */
    public function listar() {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Actualizar/Eliminar Órdenes de Mantenimiento',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],MODIFICACION, OPERATION_LIST, $data);
    }

    /**
     * Función que despliega el panel que permite visualizar las ordenes que
     * hay en el sistema.
     */
    public function novedades() {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Crear/Modificar Novedades',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],MODIFICACION, OPERATION_LIST_NOVEDADES, $data);
    }

    /**
     * Función que despliega el panel que permite visualizar las ordenes que
     * hay en el sistema.
     */
    public function listarn() {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Eliminar Órdenes de Mantenimiento',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],MODIFICACION, OPERATION_LIST_N, $data);
    }

    /**
     * Función que permite buscar una orden de mantenimiento en el sistema por su id o nombre del solicitante.
     */
    public function buscarSolicitud() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        $control = false;
        $dataNew = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            if(is_numeric($_POST['buscar'])) {
                $data = $m->buscarOrdenesPorKey($_POST['buscar']);
                $control = true;
            }
            /*else if(is_string($_POST['buscar'])){
                $data = $m->buscarOrdenesPorNombre($_POST['buscar']);
                $control = true;
            }*/
            else{
                $data['mensaje'] = "Error el campo de busqueda no puede estar vacio";
            }if($control) {
            	foreach ($data as $clave => $valor) {
                $temp1 = $valor['descripcion1'];
                $temp2 = $valor['descripcion2'];
                $temp3 = $valor['descripcion3'];
                $novedad1 = $m->getNombreNovedad($temp1);
                $novedad2 = $m->getNombreNovedad($temp2);
                $novedad3 = $m->getNombreNovedad($temp3);
                foreach ($novedad1 as $a => $b) {
                	 $novedad1 = $b['novedad'];
                }foreach ($novedad2 as $c => $d) {
                	 $novedad2 = $d['novedad'];
                }foreach ($novedad3 as $e => $f) {
                	 $novedad3 = $f['novedad'];
                }
                 $arrayAux = array(
                    'numero_solicitud' => $valor['numero_solicitud'],
                    'usuario' => $valor['usuario'],
                    'telefono' => $valor['telefono'],
                    'extension' => $valor['extension'],
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'descripcion' => $valor['descripcion'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'contacto' => $valor['contacto'],
                    'estado' => $valor['estado'],
                    'descripcion' => $valor['descripcion'],
                    'fecha' => $valor['fecha'],
                    'impreso' => $valor['impreso'],
                    'operario' => $valor['operario'],
                 );
                array_push($dataNew, $arrayAux);

                }
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * Función que permite obtener una novedad en el sistema.
     */
    public function obtenerNovedades(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $info = json_decode($_POST['jObject'], true);

            $data = $m->buscarNovedades();

            foreach ($data as $clave => $valor) {
                $arrayAux = array(
                    '#' => $clave+1,
                    'descripcion_novedad' => $valor['novedad'],
                    'sistema' => $valor['sistema'],
                   );
                    array_push($dataNew, $arrayAux);
            }
        }
        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * Función que permite buscar una novedad en el sistema.
     */
    public function buscarNovedad(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $info = json_decode($_POST['jObject'], true);

            $data = $m->buscarNovedad($info);

            foreach ($data as $clave => $valor) {
                $arrayAux = array(
                    '#' => $clave+1,
                    'descripcion_novedad' => $valor['novedad'],
                    'sistema' => $valor['sistema'],
                );
                array_push($dataNew, $arrayAux);
            }
        }
        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * Función que permite eliminar una orden en el sistema.
     */
    public function eliminar() {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $data = array();
            $info = json_decode($_POST['jObject'], true);

            foreach ($info as $valor)
            {
                $data[] = $valor['numero_solicitud'];
            }

            if($m->eliminarOrdenes($data))
            {
                $result = array(
                    'value' => true,
                );
            }
            else
            {
                $result = array(
                    'value' => false,
                );
            }
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }

    /**
     * Función que permite modificar los datos de una orden en el sistema.
     */
    public function modificar() {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $info = json_decode($_POST['jObject'], true);

            /*if ($m->validarDatos($info['solicitud'] ,$info['usuario'], $info['estado'], $info['descripcion']))
            {*/
            for($i=0;$i<count($info['solicitud']);$i++){

            	$rslt = $m->modificarOrdenes($info['solicitud'][$i], $_SESSION["login"] ,$info['estado'], $info['descripcion']);
            	//}
            	if($rslt)
            	{
                	$result = array(
                    	'value' => true,
                	);
            	}
            	else
            	{
                	$result = array(
                    	'value' => false,
                	);
            }}
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }

    /**
     * Función que permite modificar los datos de una orden en el sistema.
     */
    public function modificarVarios() {
        $GLOBALS['mensaje'] = "";

        $user = $_SESSION['login'];

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $info = json_decode($_POST['jObject'], true);

            /*if ($m->validarDatos($info['solicitud'] ,$info['usuario'], $info['estado'], $info['descripcion']))
            {*/
            for($i=0;$i<count($info['solicitud']);$i++){

                $rslt = $m->modificarOrdenes($info['solicitud'][$i], $user ,$info['estado'], $info['descripcion'], $info['operario']);
                //}
                if($rslt)
                {
                    $result = array(
                        'value' => true,
                    );
                }
                else
                {
                    $result = array(
                        'value' => false,
                    );
            }}
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }

    /**
     * Función que permite modificar los datos de una novedad en el sistema.
     */
    public function actualizarNovedad() {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $info = json_decode($_POST['jObject'], true);

            $rslt = $m->modificarNovedad($info['novedad'], $info['novedadNueva'] ,$info['sistema']);

            if($rslt){
                $result = array(
                    'value' => true,
                );
            }
            else
            {
                $result = array(
                    'value' => false,
                );
            }
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }

    /**
     * Función que permite modificar los datos de una novedad en el sistema.
     */
    public function crearNovedad() {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $info = json_decode($_POST['jObject'], true);

            $rslt = $m->crearNovedad($info['novedad'] ,$info['sistema']);

            if($rslt){
                $result = array(
                    'value' => true,
                );
            }
            else
            {
                $result = array(
                    'value' => false,
                );
            }
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }

    /**
    *Función que permite enviar un correo
    */
    public function enviarCorreo() {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_modificacion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $info = json_decode($_POST['jObject'], true);

            if($correoUsr = $m->getCorreoUsuario($info['usuario'])){
            	foreach ($correoUsr as $a => $b) {
            		$correoUsr = $b['correo'];
	         }
	      	}else{
	      		$correoUsr = 'mantenimiento.univalle@correounivalle.edu.co';
	      	}

            $rslt = $m->enviarMail($info['estado'],$correoUsr,$info['solicitud'],$info['descripcion'],$info['cod_sistema']);

            if($rslt)
            {
                $result = array(
                    'value' => true,
                );
            }
            else
            {
                $result = array(
						  'value' => false,
                );
            }
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }
}

?>
