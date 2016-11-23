<?php

class Controlador_usuario {
    
    /**
     * Función despliega el panel que permite crear, visualizar y modificar los 
     * usuarios con acceso al sistema.
     */     
    public function administrar_usuario_autorizado() {
        $GLOBALS['mensaje'] = "";
        $data = array(
            'mensaje' => 'Administrar usuarios del sistema',
        );  
        
        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],USUARIO, OPERATION_ADM_SUPERV, $data);        
    }

        /**
     * Función que despliega la página de recuperación de la contraseña
     */     
    /*public function olvido_contrasenia() {
        $GLOBALS['mensaje'] = "";
        $data = array(
            'mensaje' => 'Recuperar contraseña',
        );  
        
        $v = new Controlador_vista();
        $v->retornar_vista("",USUARIO, OLVIDO_CONTRASENIA, $data);        
    }*/
    
    /**
     * Función que permite crear un usuario con acceso al sistema.
     */     
    public function crear_usuario_autorizado_para_adm_sistema() {
        $GLOBALS['mensaje'] = "";
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $info = json_decode($_POST['jObject'], true);
            
            if($m->validarDatos($info['nombre_usuario'], $info['login'], $info['password'], $info['perfil']) and $m->comprobarEmailUsuario($info["correo"]))
            {
                $m->insertarUsuarioAutorizado($info['nombre_usuario'], $info['login'], $info['password'], $info['perfil'], $info["correo"], $info["telefono"],$info["extension"]);
                
                $result = array(
                    'value' => true,
                );                
            } else {
                $result = array(
                    'value' => false,
                );                
            }
        }
        
        $result['mensaje'] = $GLOBALS['mensaje'];
        
        echo json_encode($result);   
    }
    
    /**
     * Función que permite cambiar los datos  de un 
     * usuario con acceso al sistema, ademas esta función es la 
     * encargada de desplegar el panel la realizar la operación de cambio de 
     * contraseña o password.
     */    
    public function cambiar_datos() {
        $GLOBALS['mensaje'] = "";
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        $v = new Controlador_vista();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_SESSION['login'])
                & $_SESSION["autorizado"]) {
            
            $info = json_decode($_POST['jObject'], true);
            $rslt = $m->modificarDatosUsuarioAutorizado($_SESSION["login"], $info['act_password'], $info['password'], $info['correo'], $info['telefono'], $info['extension']);
                    
            if($rslt) {
                $result = array(
                    'value' => true,
                );
            } else {
                $result = array(
                    'value' => false,
                );                
            }
            
            $result['mensaje'] = $GLOBALS['mensaje'];

            echo json_encode($result);  
        } else {
            $data = array(
                'mensaje' => 'Actualizar datos del usuario',
            );            
            $v->retornar_vista($_SESSION["perfil"],USUARIO, OPERATION_EDIT_DATA, $data);
        }       
    }
    
    /**
     * Función que permite buscar un usuario con acceso al sistema.
     */    
    public function buscar_autorizados_manejar_sistema() {
        $GLOBALS['mensaje'] = "";     

        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $m->dameUsuarioAutorizado($_POST['buscar']);
        }
        
        $data['mensaje'] = $GLOBALS['mensaje'];
        
        echo json_encode($data);
    }

    /**
     * Función que permite buscar un usuario con acceso al sistema.
     */    
    public function buscarUsuario() {
        $GLOBALS['mensaje'] = "";     

        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = $m->dameUsuarioAutorizadoNombre($_POST['buscar']);
        }
        
        $data['mensaje'] = $GLOBALS['mensaje'];
        
        echo json_encode($data);
    }     
    
    /**
     * Función que permite eliminar uno o varios usuario con acceso 
     * al sistema.
     */    
    public function eliminar_usuario_autorizado_adm_sistema() {
        $GLOBALS['mensaje'] = "";
        
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $data = array();
            $info = json_decode($_POST['jObject'], true);

            if($_SESSION['perfil'] == 'admin') {
                for ($i = 0; $i < sizeof($info); $i++) {
                    $respuesta = $m->eliminarUsuarioAutorizado($info[$i]);
                }
            }
            
            if($respuesta) {
                $result = array(
                    'value' => true,
                );
            } else {
                $result = array(
                    'value' => false,
                );                
            }
        }  
        
        $result['mensaje'] = $GLOBALS['mensaje'];
        
        echo json_encode($result);        
    }
    
    /**
     * Función que permite modificar el perfil o privilegio de un usuario 
     * con acceso al sistema de sistema.
     */    
    public function modificar_perfil_usuario_autorizado_adm_sistema() {
        $GLOBALS['mensaje'] = "";
        
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if($_SESSION['perfil'] == 'admin') {
                $info = json_decode($_POST['jObject'], true);
                $rslt = $m->modificarPerfilUsuarioAutorizado($info['login'], $info['perfil']);
            }
                    
            if($rslt) {
                $result = array(
                    'value' => true,
                );
            }else {
                $result = array(
                    'value' => false,
                );                
            }
        }  
        
        $result['mensaje'] = $GLOBALS['mensaje'];
        
        echo json_encode($result);
    }

    
    /*-------------------------------Operaciones del Index-----------------------------------------*/
    /**
     * Función que permite cerrar una sesion de un usuario.
    */
    public function salir_sesion() {
        session_start();
        
        //eliminar informacion almacenada de la sesion
        session_unset();
        //finalizar sesion
        session_destroy ();
        
        $data = array(
            'mensaje' => 'Bienvenido  '. date('d-m-y  h:i A'),
        );
        
        $v = new Controlador_vista();
        $v->retornar_vista($_SESSION["perfil"],USUARIO, INICIAR_SESION, $data);
    }    
    
    /**
     * Función que permite chekear si hay una sesion iniciada.
    */    
    public function check() {
        session_start();
        if(isset($_SESSION['userid']) & $_SESSION["autorizado"]) {
            
            $fechaGuardada = $_SESSION["ultimoAcceso"]; 
            $ahora = time(); 
            $tiempo_transcurrido = $ahora-$fechaGuardada;
 
            if($tiempo_transcurrido >= T_SEGUNDOS_INACTIVIDAD_PERMITIDO) { 
                session_unset();
                session_destroy();
                return false;
            }else { 
                $_SESSION["ultimoAcceso"] = $ahora;
                return true;
            }             
        }   
        return false;
    }

    /**
     * Función que permite iniciar una sesion por un usuario, ademas esta
     * función se encarga de desplegar el panel de logeo o el mostrar la pagina
     * de inicio de la aplicación web.
     */    
    public function iniciar_sesion() {
        session_start();
        
        //instaciar el objeto de la clase modelo
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);  
        
        $v = new Controlador_vista();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($infoResult = $m->comprobarAcceso($_POST['login'], $_POST['password']))
            {
                $_SESSION["autorizado"] = true;
                session_regenerate_id();
                $_SESSION["userid"] = session_id();
                $_SESSION["perfil"] = $infoResult["perfil"];
                $_SESSION["login"] = $infoResult["login"];
                $_SESSION["nombre_usuario"] = $infoResult["nombre_usuario"];
                $_SESSION["id_db_user"] = $infoResult["id"];
                $_SESSION["ultimoAcceso"] = time();
                
                $data = array(
                    'mensaje' => 'Bienvenido/a al sistema '. $_SESSION["nombre_usuario"],
                );

                $m->actualizarUltimoAcceso($_SESSION["login"]);

                if($_SESSION["perfil"] == 'admin'){
                    $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST, $data);
                }else if($_SESSION["perfil"] == 'hidraulico' || $_SESSION["perfil"] == 'electrico' || $_SESSION["perfil"] == 'planta' || $_SESSION["perfil"] == 'mobiliario'){
                    $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST_DIA, $data);
                }else if($_SESSION["perfil"] == 'sanfernando'){
                    $v->retornar_vista($_SESSION["perfil"],CONSULTAS, OPERATION_LIST, $data);
                }else{
                    $v->retornar_vista($_SESSION["perfil"],REGISTROS, OPERATION_SET, $data);
                }
            } else {
                $data = array(
                    'mensaje' => 'Intentelo de nuevo. Puede que haya '
                    . 'escrito mal su usuario o contraseña'
                );

                $v->retornar_vista($_SESSION["perfil"],USUARIO, INICIAR_SESION, $data);                 
            }
        } else {
            if($_SESSION["autorizado"] & isset($_SESSION['userid']) 
                    & isset($_SESSION['perfil'])) {
                $data = array('mensaje' => 'Bienvenido/a al sistema '.$_SESSION["nombre_usuario"],);

                $v->retornar_vista($_SESSION["perfil"],REGISTROS, OPERATION_SET, $data);                
            } else {
                $this->salir_sesion();
            }
        }
    }

    /**
     * Función que genera una contraseña aleatoria y la envía por mail
     *al usuario.
     */    
    /*public function reestablecer_contrasenia() {
        
        //instaciar el objeto de la clase modelo
        $m = new Modelo_usuario(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);  
        
        $v = new Controlador_vista();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($infoResult = $m->buscarCorreoUsuario($_POST['correo']))
            {
                $_SESSION["autorizado"] = true;
                session_regenerate_id();   
                $_SESSION["userid"] = session_id();
                $_SESSION["perfil"] = $infoResult["perfil"];
                $_SESSION["login"] = $infoResult["login"];
                $_SESSION["nombre_usuario"] = $infoResult["nombre_usuario"];
                $_SESSION["id_db_user"] = $infoResult["id"];
                $_SESSION["ultimoAcceso"] = time();
                
                $data = array(
                    'mensaje' => 'Se ha enviado un correo a '.$_POST['correo'].' con las instrucciones para reestablecer la contraseña.',
                );  

                $v->retornar_vista("",USUARIO, OLVIDO_CONTRASENIA, $data);
            } else {
                $data = array(
                    'mensaje' => 'El correo no se encuentra asociado a una cuenta en el sistema.'
                );

                $v->retornar_vista("",USUARIO, OLVIDO_CONTRASENIA, $data);                 
            }
        } else {
            if($_SESSION["autorizado"] & isset($_SESSION['userid']) 
                    & isset($_SESSION['perfil'])) {
                $data = array('mensaje' => 'Bienvenido/a al sistema '.$_SESSION["nombre_usuario"],);

                $v->retornar_vista($_SESSION["perfil"],REGISTROS, OPERATION_SET, $data);                
            } else {
                $this->salir_sesion();
            }
        }
    } */
}

?>