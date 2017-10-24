<?php

/**
 * Clase controladora de registro de ordenes de mantenimiento
 */
class Controlador_registros
{

    /**
     * Función despliega el panel que permite crear ordenes en el sistema,
    **/
    public function insertar()
    {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Registrar órdenes de mantenimiento',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],REGISTROS, OPERATION_SET, $data);
    }

    /**
     * Funcion que permite registrar las orden o solcitudes de mantenimiento y almacenarla en la base de datos
     * @return array $result. Un array con 2 key el mensaje que devuelve el metodo del modelo y el value que es un valor booleano
     */
    public function insertarOrden(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $info = json_decode($_POST['jObject'], true);
            $tmp_usuario = $_SESSION['login'];
            $tmp_sede = $info['sede'];
            $tmp_campus = $info['campus'];
            $tmp_edificio = $info['edificio'];
            $tmp_piso = $info['piso'];
            $tmp_espacio = $info['espacio'];
            $tmp_contacto = $info['contacto'];
            $tmp_cantidad = $info['cantidad'];
            $tmp_novedad = $info['descripcion'];
            $tmp_cantidad2 = $info['cantidad2'];
            $tmp_novedad2 = $info['descripcion2'];
			$tmp_cantidad3 = $info['cantidad3'];
            $tmp_novedad3 = $info['descripcion3'];
            $tmp_otraNovedad = $info['descripcion_novedad'];
            $tmp_otraNovedad2 = $info['descripcion_novedad2'];
            $tmp_otraNovedad3 = $info['descripcion_novedad3'];

            if($m->validarDatos($tmp_usuario, $tmp_edificio, $tmp_piso, $tmp_espacio, $tmp_contacto, $tmp_cantidad, $tmp_novedad))
            {

                if($m->insertarOrdenes($tmp_usuario, $tmp_sede, $tmp_campus, $tmp_edificio, $tmp_piso, $tmp_espacio, $tmp_contacto, $tmp_cantidad, $tmp_novedad, $tmp_cantidad2, $tmp_novedad2, $tmp_cantidad3, $tmp_novedad3, $tmp_otraNovedad, $tmp_otraNovedad2, $tmp_otraNovedad3))
                {
                    $result = array('value' => true,);
                    //$m->enviarMail();
                }
                else{
                    $result = array('value' => false,);
                }
            }
            else
            {
                $result = array('value' => false,);
            }
        }

        $result['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($result);
    }


    /**
     * funcion que permite consultar las novedad del sistema
     * @return [array] $dataNew contiene el nombre de la novedades registradas en la bd
     */
    public function buscarNovedad()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarDBNovedad();
            while (list($clave, $valor) = each($data)) {
                $arrayAux = array(
                    'id' => $valor['id'],
                    'novedad' => $valor['novedad'],
                    'cod_sistema' => $valor['cod_sistema'],
                    );
                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * funcion que permite consultar los edificios asociados al campus seleccionado por el usuario
     * @return [array] $dataNew contiene el codigo y nombre del edificio
     */
    public function buscarEdificio()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarDBEdificio($_POST['buscar']);

            while (list($clave, $valor) = each($data)) {
                $arrayAux = array(
                    'codigo' => $valor['codigo'],
                    'nombre' => $valor['nombre'],
                    'pisos' => $valor['pisos'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite buscar los campus registrados en el sistema
     * @return array $dataNew retorna un array con el nombre del campus registrado en formato json
     */
    public function buscarCampus()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarDBCampus();

            while (list($clave, $valor) = each($data)) {
                $arrayAux = array(
                    'nombre' => $valor['nombre'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * funcion que permite buscar los pisos de la base de datos
     * @return array $dataNew con el nombre del piso registrados en formato json
     */
    public function buscarPiso()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarDBPiso();

            while (list($clave, $valor) = each($data)) {
                $arrayAux = array(
                    'piso' => $valor['piso'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * funcion que permite obtener los datos del usuario y mostrarlos en los formularios de registro
     * @return array $dataNew con la informacion del usuario en formato json
     */
    public function buscarUsuario()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
            Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $user = $_SESSION['login'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();

            $data = $m->buscarDBUsuario($user);

            while(list($clave, $valor) = each($data)){
                $arrayAux = array(
                    'nombre_usuario' => $valor['nombre_usuario'],
                    'correo' => $valor['correo'],
                    'telefono' => $valor['telefono'],
                    'extension' => $valor['extension'],
                    );
                array_push($dataNew, $arrayAux);
            }

            $dataNew['mensaje'] = $GLOBALS['mensaje'];

            echo json_encode($dataNew);
        }

    }

    /**
     * funcion que permite buscar las ultimas ordenes que hay en el sistema de acuerdo al campus, edificio y piso ingresados por el usuario
     * @return [type] [description]
     */
    public function buscarOrdenes(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_registros(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
            Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $info = json_decode($_POST['jObject'], true);
            $dataNew = array();

            $data = $m->buscarUltimasOrdenes($info['campus'], $info['edificio'], $info['piso']);


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
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'descripcion1' => $novedad1,
                    'descripcion2' => $novedad2,
                    'descripcion3' => $novedad3,
                    'estado' => $valor['estado'],
                    'fecha' => $valor['fecha'],
                    'tipo_usuario' => $_SESSION["perfil"],
                    );
                array_push($dataNew, $arrayAux);

            }

            $dataNew['mensaje'] = $GLOBALS['mensaje'];
        }

        echo json_encode($dataNew);
    }
}
?>
