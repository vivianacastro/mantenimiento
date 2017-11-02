<?php
/**
 * Clase controlador
 */
class Controlador_consultas
{

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por nombre o numero de orden
    **/
    public function listar() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por nombre o numero de orden
    **/
    public function buscarDinamico() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Buscar ordenes',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_BUSCAR, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por rangos de fechas
    **/
    public function listarf() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento por campus, sistema y fecha',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_F, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function listars() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento por campus, edificio, sistema y rango de fechas',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_MULTIPLE, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function listarNormal() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_NORMAL, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function listarNovedad() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_NOVEDAD, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistema por dia
    */
    public function listarDia() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar órdenes de mantenimiento.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_DIA, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function listarOrdenes() {

        $GLOBALS['mensaje'] = "";
        $user = $_SESSION['login'];

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($user == 'hidraulico'){
        	$user = "Hidráulico y Sanitario";
        }else if($user == 'planta'){
        	$user = "Planta Física";
        }else if($user == 'electrico'){
        	$user = "Eléctrico";
        }else if($user == 'mobiliario'){
        	$user = "Mobiliario y Planta Física";
        }else{
        	$user = "Todos";
        }

        $data = array(
            'mensaje' => 'Ordenes del sistema '.$user.'.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_ORDENES, $data);
    }

    /**
     * Función despliega el panel que permite crear ordenes en el sistema,
    **/
    public function listar_electrico()
    {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Órdenes del Sistema Eléctrico',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_ORDENES, $data);
    }

    /**
     * Función despliega el panel que permite crear ordenes en el sistema,
    **/
    public function listar_hidraulico()
    {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Órdenes del Sistema Hidráulico y Sanitario',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_ORDENES, $data);
    }

    /**
     * Función despliega el panel que permite crear ordenes en el sistema,
    **/
    public function listar_mobiliario()
    {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Órdenes del Sistema Aires Acondicionados',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_ORDENES, $data);
    }

    /**
     * Función despliega el panel que permite crear ordenes en el sistema,
    **/
    public function listar_planta()
    {

        $GLOBALS['mensaje'] = "";

        $data = array(
            'mensaje' => 'Órdenes del Sistema Planta Física',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_ORDENES, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function listarHistorial() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Consultar historial órdenes de mantenimiento.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_HISTORIAL, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function mostrarEstadisticasEdificios() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Estadísticas del sistema.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_ESTADISTICAS, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function mostrarEstadisticasEspacios() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Estadísticas del sistema.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_ESTADISTICAS, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function mostrarEstadisticasNovedades() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Estadísticas del sistema.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_ESTADISTICAS, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function mostrarEstadisticasSistema() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Estadísticas del sistema.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_ESTADISTICAS, $data);
    }

    /**
    * Función que despliega el panel que permite visualizar las ordenes que
    * hay en el sistemas por sistemas
    */
    public function mostrarEstadisticasOperador() {

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $data = array(
            'mensaje' => 'Estadísticas del sistema.',
        );

        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_ESTADISTICAS, $data);
    }

    /**
     * Función que permite buscar una orden  por su
     * serial o nombre de solicitante.
     */
    public function buscar() {
        $GLOBALS['mensaje'] = "";
        $control = false;

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(is_numeric($_POST['buscar'])) {
                $data = $m->buscarOrdenesPorKey($_POST['buscar']);
                $control = true;
            }
            else if(is_string($_POST['buscar'])){
                $data = $m->buscarOrdenesPorNombre($_POST['buscar']);
                $control = true;
            }
            else{
                $data['mensaje'] = 'Error ingrese un valor';
            }
            if($control){
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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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
     * Función que permite buscar una orden  por su fecha, sistema y campus.
     * fecha,sistema, campus.
     */
    public function buscarParametros()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            if(is_string($info['fechaInicio']) and is_string($info['fechaFin']) and is_numeric($info['campus']) and is_numeric($info['sistema']))
            {
                $data = $m->buscarOrdenesParametros($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin']);

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
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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
            else
            {
                $dataNew['mensaje'] = 'Error seleccione opciones válidas';
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);
    }

    /**
     * funcion que permite buscar una orden/solicitud de mantenimiento por campus, edificio, sistema, rango de fechas
     * @return [type] [description]
     */
    public function buscarParametrosAvanzados()
    {
        $GLOBALS['mensaje'] = "";

        $tipoUser = $_SESSION['perfil'];

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            if(is_string($info['fechaInicio']) and is_string($info['fechaFin']) and is_string($info['edificio']) and is_numeric($info['campus']) and is_numeric($info['piso']) and is_numeric($info['sistema']))
            {
                if($info['sistema'] == '10'){
                    if($tipoUser == 'hidraulico'){
                        $sistema = 1;
                        $info['campus'] = 1;
                    }else if($tipoUser == 'planta'){
                        $sistema = 3;
                        $info['campus'] = 1;
                    }else if($tipoUser == 'electrico'){
                        $sistema = 2;
                        $info['campus'] = 1;
                    }else if($tipoUser == 'mobiliario'){
                        $sistema = 4;
                        $info['campus'] = 1;
                    }else{
                        $sistema = -1;
                    }
                    $info['sistema'] = $sistema;
                }

                if($tipoUser == 'sanfernando'){
                    if ($sistema == -1) {
                        $info['campus'] = 2;
                    }
                }

                $data = $m->buscarOrdenesParametrosAvanzados($info['campus'], $info['edificio'], $info['sistema'], $info['piso'], $info['fechaInicio'], $info['fechaFin']);

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
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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
            else
            {
                $dataNew['mensaje'] = 'Error selecciones opciones válidas';
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite buscar una orden/solicitud de mantenimiento por campus, edificio, sistema, rango de fechas
     * @return [type] [description]
     */
    public function buscarOrdenesNovedad()
    {
        $GLOBALS['mensaje'] = "";

        $tipoUser = $_SESSION['perfil'];

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $data = $m->buscarOrdenNovedad($info['novedad'], $info['campus'], $info['edificio'], $info['piso'], $info['fechaInicio'], $info['fechaFin']);

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
                'cantidad1' => $valor['cantidad1'],
                'descripcion1' => $novedad1,
                'descripcion_novedad' => $valor['descripcion_novedad'],
                'cantidad2' => $valor['cantidad2'],
                'descripcion2' => $novedad2,
                'descripcion_novedad2' => $valor['descripcion_novedad2'],
                'cantidad3' => $valor['cantidad3'],
                'descripcion3' => $novedad3,
                'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite obtener los edificios con más ordenes asociadas
     * @return [type] [description]
     */
    public function buscarEdificiosMasOrdenes()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $dataNew = array();

            $data = $m->buscarEdificiosMasSolicitudes($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin']);

            while (list($clave, $valor) = each($data)) {

                $arrayAux = array(
                    'codigo_edificio' => $valor['codigo_edificio'],
					'conteosolicitudes' => $valor['conteosolicitudes'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite obtener los edificios con más ordenes asociadas
     * @return [type] [description]
     */
    public function buscarEstadisticasSistema()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $dataNew = array();

            $data = $m->buscarEstadisticasSistemas($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin']);

            while (list($clave, $valor) = each($data)) {

                $arrayAux = array(
                    'estado' => $valor['estado'],
                    'conteosolicitudes' => $valor['conteosolicitudes'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite obtener los edificios con más ordenes asociadas
     * @return [type] [description]
     */
    public function buscarEspaciosMasOrdenes()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $dataNew = array();

            $data = $m->buscarEspaciosMasSolicitudes($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin']);

            while (list($clave, $valor) = each($data)) {

                $arrayAux = array(
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'conteosolicitudes' => $valor['conteosolicitudes'],
                    'espacio' => $valor['espacio'],
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite obtener los edificios con más ordenes asociadas
     * @return [type] [description]
     */
    public function buscarEstadisticasOperador()
    {
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $dataNew = array();

            $data = $m->buscarEstadisticasOperador($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin']);

            while (list($clave, $valor) = each($data)) {

                $arrayAux = array(
                    'operario' => $valor['operario'],
                    'conteosolicitudes' => $valor['conteosolicitudes']
                    );

                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite obtener los edificios con más ordenes asociadas
     * @return [type] [description]
     */
    public function buscarEstadisticasNovedades(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        $dataNew = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $info = json_decode($_POST['jObject'], true);

            $dataNew = array();
            $dataAux = array();

            $data3 = $m->buscarEstadisticasNovedades($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin'],"descripcion3");
            $data2 = $m->buscarEstadisticasNovedades($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin'],"descripcion2");
            $data = $m->buscarEstadisticasNovedades($info['campus'], $info['sistema'], $info['fechaInicio'], $info['fechaFin'],"descripcion1");

            while (list($clave, $valor) = each($data)) {
                $arrayAux = array(
                    'novedad' => $valor['novedad'],
                    'conteosolicitudes' => $valor['conteosolicitudes'],
                    );
                array_push($dataNew, $arrayAux);
            }
            while (list($clave, $valor) = each($data2)) {
                $arrayAux = array(
                    'novedad' => $valor['novedad'],
                    'conteosolicitudes' => $valor['conteosolicitudes'],
                    );
                array_push($dataNew, $arrayAux);
            }
            while (list($clave, $valor) = each($data3)) {
                $arrayAux = array(
                    'novedad' => $valor['novedad'],
                    'conteosolicitudes' => $valor['conteosolicitudes'],
                    );
                array_push($dataNew, $arrayAux);
            }
        }

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function obtenerEdificio(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
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
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function obtenerOrdenesSistema(){

        $GLOBALS['mensaje'] = "";

        $tipoUser = $_SESSION['perfil'];

        if($tipoUser == 'hidraulico'){
        	$sistema = 1;
        }else if($tipoUser == 'planta'){
        	$sistema = 3;
        }else if($tipoUser == 'electrico'){
        	$sistema = 2;
        }else if($tipoUser == 'mobiliario'){
        	$sistema = 4;
        }else{
        	$sistema = 0;
        }

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarOrdenesSistema($sistema);

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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function ordenes_electrico(){

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarOrdenesSistemaCampus("2", "2");

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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function ordenes_hidraulico(){

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarOrdenesSistemaCampus("1", "2");

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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function ordenes_mobiliario(){

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarOrdenesSistemaCampus("4", "2");

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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function ordenes_planta(){

        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataNew = array();
            $data = $m->buscarOrdenesSistemaCampus("3", "2");

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
                    'cod_sede' => $valor['cod_sede'],
                    'codigo_campus' => $valor['codigo_campus'],
                    'codigo_edificio' => $valor['codigo_edificio'],
                    'piso' => $valor['piso'],
                    'espacio' => $valor['espacio'],
                    'cantidad1' => $valor['cantidad1'],
                    'descripcion1' => $novedad1,
                    'descripcion_novedad' => $valor['descripcion_novedad'],
                    'cantidad2' => $valor['cantidad2'],
                    'descripcion2' => $novedad2,
                    'descripcion_novedad2' => $valor['descripcion_novedad2'],
                    'cantidad3' => $valor['cantidad3'],
                    'descripcion3' => $novedad3,
                    'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion permite obtener los codigos y nombres de los edificos en base a la seleccion del campus
     * @return [type] [description]
     */
    public function obtenerHistorial(){
        $GLOBALS['mensaje'] = "";

        $tipoUser = $_SESSION['perfil'];

        $user = $_SESSION['login'];

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        //if($tipoUser != "admin"){


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $dataNew = array();
                $data = $m->buscarBDHistorial($user);

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
                        'usuario' => $user,
                        'cod_sede' => $valor['cod_sede'],
                        'codigo_campus' => $valor['codigo_campus'],
                        'codigo_edificio' => $valor['codigo_edificio'],
                        'piso' => $valor['piso'],
                        'espacio' => $valor['espacio'],
                        'cantidad1' => $valor['cantidad1'],
                        'descripcion1' => $novedad1,
                        'descripcion_novedad' => $valor['descripcion_novedad'],
                        'cantidad2' => $valor['cantidad2'],
                        'descripcion2' => $novedad2,
                        'descripcion_novedad2' => $valor['descripcion_novedad2'],
                        'cantidad3' => $valor['cantidad3'],
                        'descripcion3' => $novedad3,
                        'descripcion_novedad3' => $valor['descripcion_novedad3'],
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

        //}

        $dataNew['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($dataNew);

    }

    /**
     * funcion que permite recuperar la informacion de un usuario correspondiente a una orden/Solicitud de mantenimiento
     */
    public function buscarDatosUsuario(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(is_string($_POST['buscar'])){
                $data = $m->buscarUsuario($_POST['buscar']);
            }
            else{
                $data['mensaje'] = 'Error ingrese un valor';
            }
        }

        $data['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($data);
    }

    /**
     * funcion que permite obtener el nombre y codigo de un edificio del campus de la universidad
     * @return [type] [description]
     */
    public function obtenerDatosEdificio(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $info = json_decode($_POST['jObject'], true);

            /*if(is_numeric($info['edificio']) and is_numeric($info['campus']))
            {*/
                $data = $m->getNombreEdificio($info['campus'], $info['edificio']);
            //}
        }

        $data['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($data);
    }

    /**
     * funcion que permite actualizar el campo imprimir de una solicitud
     */
    public function actualizarImpreso(){
        $GLOBALS['mensaje'] = "";

        $m = new Modelo_consultas(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(is_numeric($_POST['buscar'])) {
                $data = $m->actualizarImpresoSi($_POST['buscar']);
            }
        }
        //$data['mensaje'] = $GLOBALS['mensaje'];

        echo json_encode($data);
    }

}
?>
