<?php

class Modelo_usuario {
    protected $conexion;

    /**
     * Función contructura de la clase Modelo_usuario.
     * @param string $dbname nombre de la base de datos a la que se va a 
     * conectar el modelo.
     * @param string $dbuser usuario con el que se va a conectar a la 
     * base de datos.
     * @param string $dbpass contraseña para poder acceder a la base de datos.
     * @param string $dbhost Host en donde se encuentra la base de datos.
     */     
    public function __construct($dbname,$dbuser,$dbpass,$dbhost) {
        
        $conn_string = 'pgsql:host='.$dbhost.';port=5432;dbname='.$dbname;
        
        try { 
            $bd_conexion = new PDO($conn_string, $dbuser, $dbpass); 
            $this->conexion = $bd_conexion;
            
        } catch (PDOException $e) {
            var_dump( $e->getMessage());
        }       
    }
    
    /**
     * Función que permite comprobar la existencia de un usuario 
     * con acceso al sistema por medio de su login y password.
     * @param string $l, Cadena que hace referencia al login del usuario a 
     * comprobar.
     * @param string $c, Cadena que hace referencia al login del usuario a 
     * comprobar.
     * @return boolean
     */
    function comprobarExistenciaDeUsuario($l) {
        $l = htmlspecialchars($l);

        $sql = "SELECT * FROM usuarios_autorizados_sistema "
                . " WHERE login = '".$l."';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            return false;
        } else {
            if(!$l_stmt->execute()) { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                return false;
            }
            
            if($l_stmt->rowCount() > 0) {
                return true;
            }
            else {
                return false;
            }
        }      
    }  
    
	 /**
     * Función que permite comprobar la existencia de un usuario 
     * con acceso al sistema por medio de su email.
     * @param string $l, Cadena que hace referencia al email del usuario a 
     * comprobar.
     * @return boolean
     */
    function comprobarEmailUsuario($e) {
        $e = htmlspecialchars($e);

        $sql = "SELECT * FROM usuarios_autorizados_sistema "
                . " WHERE correo = '".$e."';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            return false;
        } else {
            if(!$l_stmt->execute()) { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                return false;
            }
            
            if($l_stmt->rowCount() > 0) {
            	 $GLOBALS['mensaje'] = "Correo ya asignado";
                return false;
            }
            else {
            	 return true;
            }
        }      
    }

         /**
     * Función que permite comprobar la existencia de un usuario 
     * con acceso al sistema por medio de su email.
     * @param string $l, Cadena que hace referencia al email del usuario a 
     * comprobar.
     * @return boolean
     */
    /*function buscarCorreoUsuario($e) {
        $e = htmlspecialchars($e);

        $sql = "SELECT login FROM usuarios_autorizados_sistema "
                . " WHERE correo = '".$e."';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            return false;
        } else {
            if(!$l_stmt->execute()) { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                return false;
            }
            
            if($l_stmt->rowCount() > 0) {
                return true;
            }
            else {
                $GLOBALS['mensaje'] = "Correo no encontrado";
                 return false;
            }
        }      
    }*/
    
    /**
     * Función que retorna la contraseña se un usuario por medio de su login.
     * @param string $l, Login del usuario a consultar.
     * @return boolean
     */
    function retornarContrasena($l) {
        $l = htmlspecialchars($l);

        $sql = "SELECT password FROM usuarios_autorizados_sistema "
                . " WHERE login = '".$l."';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            return false;
        }
        else {
            if(!$l_stmt->execute()) { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                return false;
            }
            
            if($l_stmt->rowCount() > 0)
            {
                $result = $l_stmt->fetch( PDO::FETCH_NUM );
            }
        }
        return $result[0];
    }    
    
    /**
     * funcion que encripta la constraseña del usuario usando el metodo md5
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function encriptarPassword($password) {       
        //return crypt($password, Config::$salt);
        return md5($password);
    }

    /**
     * Función que verifica si la contraseña digitada por el usuario es correcta
     * o no.
     * @param string $linput, login que digito el usuario.
     * @param string $cinput, password que digito el usuario.
     * @return boolean
     */
    public function verificarContrasena($linput, $cinput) {
        $passwdBd = $this->retornarContrasena($linput);
        
        if (md5($cinput) == $passwdBd) {
            return true;
        } 
        else {
            return false;
        }        
    }

    /**
     * Función que permite crear un usuario con acceso al sistema mediante la cuenta de un administrador de la aplicacion
     * @param string $n, Cadena que hace referencia al nombre del usuario. 
     * @param string $l, Cadena que hace referencia al login del usuario.
     * @param string $c, Cadena que hace referencia al password del usuario.
     * @param string $p, Cadena que hace referencia al perfil del usuario.
     * @param string $em, Cadena que hace referencia al email del usuario.
     * @param string $t, Cadena que hace referencia al telefono del usuario.
     * @param string $e, Cadena que hace referencia al extension del usuario.
     */
    public function insertarUsuarioAutorizado($n ,$l, $c, $p, $em, $t, $e) {
        $n = htmlspecialchars(strtolower(trim($n)));
        $n = ucwords($n);
        $n = mb_convert_case($n,MB_CASE_TITLE,"utf8");
        $l = htmlspecialchars(trim($l));
        $l = strtolower($l);
        $c = htmlspecialchars(trim($c));
        $p = htmlspecialchars(trim($p));
        $em = htmlspecialchars(trim($em));
        $em = strtolower($em);
        $t = htmlspecialchars(trim($t));
        $e = htmlspecialchars(trim($e));
        
        if($this->comprobarExistenciaDeUsuario($l)) {
            $GLOBALS['mensaje'] = MJ_ERROR_LOGIN_REGISTRADO_POR_OTRO_USUARIO;
            return false;
        }
        
        $c = $this->encriptarPassword($c);

        $sql = "INSERT INTO usuarios_autorizados_sistema (nombre_usuario, perfil, correo, telefono, extension, login, password) 
                VALUES ('".$n."','".$p."','".$em."','".$t."','".$e."','".$l."','".$c."');";
                
        $l_stmt = $this->conexion->prepare($sql);

        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA." "
                    .MJ_INSERT_USUARIO_FALLIDA;            
        } else {
            if(!$l_stmt->execute()) { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA." "
                    .MJ_INSERT_USUARIO_FALLIDA;
            }
        }
        
        $GLOBALS['mensaje'] = MJ_INSERT_USUARIO_EXITOSA;
    }

    /*
    public function CrearCuentaUsuario($n ,$l, $c, $p, $em, $t, $e) {
        $n = htmlspecialchars(trim($n));
        $l = htmlspecialchars(trim($l));
        $c = htmlspecialchars(trim($c));
        $p = htmlspecialchars(trim($p));
        $em = htmlspecialchars(trim($em));
        $t = htmlspecialchars(trim($t));
        $e = htmlspecialchars(trim($e));
        
        if($this->comprobarExistenciaDeUsuario($l)) {
            $GLOBALS['mensaje'] = MJ_ERROR_LOGIN_REGISTRADO_POR_OTRO_USUARIO;
            return;
        }
        
        $c = $this->encriptarPassword($c);

        $sql = "INSERT INTO usuarios_autorizados_sistema "
                . "(nombre_usuario, perfil, correo, telefono, extension, login, password) VALUES ('".
                $n."', '".$l. "','".$c. "','" . $p ."','".$em."','".$t."','".$e."');";
                
        $l_stmt = $this->conexion->prepare($sql);

        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA." "
                    .MJ_INSERT_USUARIO_FALLIDA;            
        }
        else
        {
            if(!$l_stmt->execute())
            { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA." "
                    .MJ_INSERT_USUARIO_FALLIDA;
            }
        }
        
        $GLOBALS['mensaje'] = MJ_INSERT_USUARIO_EXITOSA;
    }
    
    /**
     * Función que permite consultar un usuario con acceso al sistema por
     * medio de su id.
     * @param numerico $key, Entero que hace referencia la id del usuario
     * con acceso al sistema.
     */
    public function dameUsuarioAutorizado($key) {
        $key = htmlspecialchars($key);

        if($key == ""){
            $sql = "SELECT id,nombre_usuario,login,perfil,correo,telefono,extension
                FROM usuarios_autorizados_sistema
                WHERE estado = 'ACTIVO' AND CAST(id AS text) like '%".$key."%'
                ORDER BY id;";
        }else{
            $sql = "SELECT id,nombre_usuario,login,perfil,correo,telefono,extension
                FROM usuarios_autorizados_sistema
                WHERE estado = 'ACTIVO' AND login = '".$key."'
                ORDER BY id;";
        }        
        

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt) {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;            
        } else {
            if(!$l_stmt->execute())
            { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }
            
            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
            } 
        }  

        $GLOBALS['mensaje'] = MJ_CONSULTA_EXITOSA;
        return $result;
    }

    /**
     * Función que permite consultar un usuario con acceso al sistema por
     * medio de su nombre
     * @param numerico $key, Entero que hace referencia la id del usuario
     * con acceso al sistema.
     */
    public function dameUsuarioAutorizadoNombre($key) {
        $key = htmlspecialchars($key);
        $key = ucwords($key);
        
        $sql = "SELECT id,nombre_usuario,login,perfil,correo,telefono,extension
                FROM usuarios_autorizados_sistema
                WHERE estado = 'ACTIVO' AND nombre_usuario LIKE '%".$key."%';";

        $l_stmt = $this->conexion->prepare($sql);
        if(!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;            
        }
        else
        {
            if(!$l_stmt->execute())
            { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }
            
            if($l_stmt->rowCount() > 0)
            {
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = MJ_CONSULTA_EXITOSA;
            }
            else{
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            } 
        }  

        return $result;
    }
    
    /**
     * Función que permite modificar el perfil o privilegios de un usuario 
     * con acceso al sistema.
     * @param numerico $id, Entero que hace referencia al id del usuario 
     * con acceso al sistema.
     * @param string $p, Cadena que hace referencia al nuevo perfil o privilegio
     * del usuario con acceso al sistema.
     * @return boolean
     */
    public function modificarPerfilUsuarioAutorizado($login, $p) {
        $login = htmlspecialchars(trim($login));
        $p = htmlspecialchars(trim($p));
        
        if($p == '') {
            $GLOBALS['mensaje'] = 'Error debe de haber un perfil';
            return false;            
        }

        $sql = "UPDATE usuarios_autorizados_sistema SET "
                . "perfil = '".$p."'"
                . " WHERE login = '".$login."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA." "
                        .MJ_ACTUALIZACION_USUARIO_FALLIDA;
            return false;
        }
        else
        {
            if(!$l_stmt->execute())
            {
                $GLOBALS['mensaje'] = MJ_ACTUALIZACION_FALLIDA." "
                        .MJ_ACTUALIZACION_USUARIO_FALLIDA;
                return false;
            }
        }

        $GLOBALS['mensaje'] = MJ_ACTUALIZACION_USUARIO_EXITOSA;
        return true;
    }   
    
    /**
     * Función que permite modificar los datos de un usuario con acceso 
     * al sistema.
     * @param string $l, Cadena que hace referencia al login del usuario.
     * @param string $c, Cadena que hace referencia al password actual del usuario.
     * @param type $cn, Cadena que hace referencia a la nueva password del usuario.
     * @param string $crn, Cadena que hace referencia al nuevo correo del usuario.
     * @param int $tln, Valor que hace referencia al nuevo telefono del usuario.
     * @param int $xtn, Valor que hace referencia a la nueva extension del usuario
     * @return boolean
     */
    public function modificarDatosUsuarioAutorizado($l, $c, $cn, $crn, $tln, $xtn) {
        $l = htmlspecialchars($l);
        $c = htmlspecialchars($c);
        $cn = htmlspecialchars($cn);
        $crn = htmlspecialchars($crn);
        $tln = htmlspecialchars($tln);
        $xtn = htmlspecialchars($xtn);
        
        if(!$this->comprobarExistenciaDeUsuario($l))
        {
            $GLOBALS['mensaje'] = MJ_ERROR_NO_EXISTE_USUARIO;
            return false;            
        }
        
        if($cn != ""){
            if(!$this->verificarContrasena($l, $c)){
                $GLOBALS['mensaje'] = MJ_ERROR_NO_EXISTE_USUARIO;
                return false;            
            }
        }

        $control = false;
        $pass = "";
        $correo = "";
        $tel = "";
        $ext = "";

        if($cn != ""){
            $cn = $this->encriptarPassword($cn);
            $pass = "password = '".$cn."'";
            $control = true;
        }

        if($crn != ""){
            if($control){
                $correo = ", correo = '".$crn."'";
            }else{
                $correo = " correo = '".$crn."'";
                $control = true;
            }
        }

        if($tln != ""){
            if($control){
                $tel = ", telefono = '".$tln."'";
            }else{
                $tel = " telefono = '".$tln."'";
                $control = true;
            }        
        }

        if($xtn != ""){
            if($control){
                $ext = ", extension = '".$xtn."'";
            }else{
                $ext = " extension = '".$xtn."'";
            }
        }

        $sql = "UPDATE usuarios_autorizados_sistema SET ".$pass.$correo.$tel.$ext. 
        //"password = '".$cn."',"." correo = '".$crn."',"." telefono = '".$tln."',"." extension = '".$xtn."'". 
        " WHERE login = '".$l."';";


        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA." ".MJ_ACTUALIZACION_DATA_USUARIO_FALLIDA;
            return false;
        }
        else{
            if(!$l_stmt->execute())
            {
                $GLOBALS['mensaje'] =MS_ACTUALIZACION_FALLIDA." ".MJ_ACTUALIZACION_DATA_USUARIO_FALLIDA;
                return false;
            }
        }

        $GLOBALS['mensaje'] = MJ_ACTUALIZACION_DATA_USUARIO_EXITOSA;

        return true;
    }    
    
    /**
     * Función que permite eliminar uno o varios usuarios con acceso 
     * al sistema.
     * @param array $id, Array que contiene los id's de los usuario con acceso 
     * al sistema de inventario que van a ser eliminados.
     * @return boolean
     */
    public function eliminarUsuarioAutorizado($login) {

        $sql = "UPDATE usuarios_autorizados_sistema "
                . "SET estado = 'ELIMINADO' "
                . "WHERE login = '".$login."';";
        
        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_ELMINACION_USUARIO_FALLIDA;
            return false;
        }else
        {
            if(!$l_stmt->execute())
            {
                $GLOBALS['mensaje'] = MJ_ELMINACION_USUARIO_FALLIDA;
                return false;
            }
        }

        $GLOBALS['mensaje'] = MJ_ELMINACION_USUARIO_EXITOSA;

        return true;
    } 
    
    /**
     * Función que permite validar los datos.
     * @param string $n, Cadena que hace referencia al nombre del usuario
     * @param string $l, Cadena que hace referencia al login del usuario.
     * @param string $c, Cadena que hace referencia al password actual del usuario.
     * @param string $p, Cadena que hace referencia al perfil del usuario.
     * @return boolean
     */
    public function validarDatos($n, $l, $c, $p) {
        $n = htmlspecialchars(trim($n));
        $l = htmlspecialchars(trim($l));
        $c = htmlspecialchars(trim($c));
        $p = htmlspecialchars(trim($p));
        
        if(is_string($n) & is_string($l) & is_string($p)  & $l != '' & $c != '' & $p != '' & $n != '')
        {
            return true;
        }
        else
        {
            $GLOBALS['mensaje'] = MJ_REVISE_FORMULARIO." ".MJ_NO_CAMPOS_VACIOS;

            return false;
        }
    }

  
    /*-------------------------------Comprobar Acceso-----------------------------------------*/
    
    /**
     * Función que permite comprobar si un determinado usuario tiene acceso o 
     * no al sistema.
     * @param string $login, Cadena que hace referencia al login del usuario.
     * @param string $password, Cadena que hace referencia al login del usuario.
     */
    public function comprobarAcceso($login, $password) {
        $login = htmlspecialchars($login);
        $login = strtolower($login);
        
        if(!$this->verificarContrasena($login, $password))
        {
            $GLOBALS['mensaje'] = MJ_ERROR_CONTRASENA_INCORRECTA;
            return;
        }
        
        $password = $this->retornarContrasena($login);
        
        $sql = "SELECT id,nombre_usuario,login,perfil,correo,telefono,extension FROM usuarios_autorizados_sistema WHERE login = '".$login."' AND 
                password = '".$password."' AND estado = 'ACTIVO';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;            
        }
        else
        {
            if(!$l_stmt->execute())
            { 
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }
            
            if($l_stmt->rowCount() > 0)
            { 
                $result = $l_stmt->fetchAll(); 
            }             
        } 

        $GLOBALS['mensaje'] = MJ_CONSULTA_EXITOSA;

        return $result[0];        
    }

    public function actualizarUltimoAcceso($login){

        $fecha = date("Y-m-d H:i:s");

        $sql = "UPDATE usuarios_autorizados_sistema SET "
                . "ultimo_acceso = '".$fecha."'"
                . " WHERE login = '".$login."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            /*$GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA." "
                        .MJ_ACTUALIZACION_USUARIO_FALLIDA;*/
            return false;
        }
        else
        {
            if(!$l_stmt->execute())
            {
                /*$GLOBALS['mensaje'] = MJ_ACTUALIZACION_FALLIDA." "
                        .MJ_ACTUALIZACION_USUARIO_FALLIDA;*/
                return false;
            }
        }

        //$GLOBALS['mensaje'] = MJ_ACTUALIZACION_USUARIO_EXITOSA;
        return true;
    }    
}

?>