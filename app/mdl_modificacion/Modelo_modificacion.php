<?php
//Librerías para el envío de mail
include_once('class.phpmailer.php');
include_once('class.smtp.php');
/**
 * clase Modelo del modulo
 */
class Modelo_modificacion {
    protected $conexion;

    /**
     * Función contructur de la clase Modelo
     * @param string $dbname nombre de la base de datos a la que se va a
     * conectar el modelo.
     * @param string $dbuser usuario con el que se va a conectar a la
     * base de datos.
     * @param string $dbpass contraseña para poder acceder a la base de datos.
     * @param string $dbhost Host en donde se encuentra la base de datos.
     */
    public function __construct($dbname,$dbuser,$dbpass,$dbhost) {

        $conn_string = 'pgsql:host='.$dbhost.';port=5432;dbname='.$dbname;

        try
        {
            $bd_conexion = new PDO($conn_string, $dbuser, $dbpass);
            $this->conexion = $bd_conexion;

        }
        catch (PDOException $e)
        {
            var_dump( $e->getMessage());
        }
    }


    /**
     * Función que permite buscar ordenes en el sistema utilizando el nombre
     * de este.
     * @param strig $n, palabra clave.
     * @return array
     */
    public function buscarOrdenesPorNombre($n)
    {
        $n = htmlspecialchars(trim($n));

        $usuario = $this->getLoginUsuario($n);
        $dato = $usuario[0];

        $sql = "SELECT * FROM solicitudes_mantenimiento WHERE usuario = '".$dato."' AND estado <> 'Eliminado';";

        $l_stmt = $this->conexion->prepare($sql);

        if (!$l_stmt)
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
            else
            {
                $GLOBALS['mensaje'] = "No hay registro asociado a su consulta con el nombre de usuario que ingreso";
            }
        }

        return $result;
    }

    /**
     * Función que permite consultar una orden en el sistema por medio de su
     * serial.
     * @param numerico $k, Entero que hace referencia al serial de la orden
     */
    public function buscarOrdenesPorKey($k)
    {
        $k = htmlspecialchars(trim($k));

        $sql = "SELECT numero_solicitud,usuario,telefono,extension,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,descripcion2,descripcion3,descripcion_novedad,cantidad2,descripcion_novedad2,cantidad3,descripcion_novedad3,contacto,descripcion,a.estado,a.fecha,impreso,operario, a.responsable_ejecucion, a.fecha_entrega_responsable
        FROM solicitudes_mantenimiento a JOIN usuarios_autorizados_sistema b ON a.usuario = b.login
        WHERE numero_solicitud = '".$k."' AND a.estado <> 'Eliminado';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt)
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
            else
            {
                $GLOBALS['mensaje'] = "No hay registro asociado a su consulta";
            }
        }

        return $result;
    }

    public function buscarNovedades(){

        $sql = "SELECT novedad_sistema.novedad, sistema.sistema FROM novedad_sistema JOIN sistema ON novedad_sistema.cod_sistema = sistema.cod_sistema WHERE novedad_sistema.novedad <> 'Seleccionar' ORDER BY sistema.sistema, novedad_sistema.novedad;";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt)
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
            else
            {
                $GLOBALS['mensaje'] = "No hay novedades registradas en el sistema";
            }
        }

        return $result;
    }

    public function buscarNovedad($n){

        $n = htmlspecialchars(trim($n));

        $sql = "SELECT novedad_sistema.novedad, sistema.sistema FROM novedad_sistema JOIN sistema ON novedad_sistema.cod_sistema = sistema.cod_sistema WHERE novedad_sistema.novedad ILIKE '%".$n."%' ORDER BY sistema.sistema, novedad_sistema.novedad;";

        $l_stmt = $this->conexion->prepare($sql);

        if (!$l_stmt)
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
            else
            {
                $GLOBALS['mensaje'] = "No hay novedades registradas en el sistema";
            }
        }

        return $result;
    }

    public function modificarNovedad($novedad,$novedadNueva,$sistema){

        $novedad = htmlspecialchars(trim($novedad));
        $novedadNueva = htmlspecialchars(trim($novedadNueva));
        $sistema = htmlspecialchars(trim($sistema));

        if($sistema == 'Sistema Hidráulico y Sanitario'){
            $cod_sistema = 1;
        }else if($sistema == 'Sistema Eléctrico'){
            $cod_sistema = 2;
        }else if($sistema == 'Sistema Planta Física'){
            $cod_sistema = 3;
        }else if($sistema == 'Sistema Aires Acondicionados'){
            $cod_sistema = 4;
        }else if($sistema == 'Sistema Cubiertas'){
            $cod_sistema = 5;
        }

        $sql = "UPDATE novedad_sistema SET "
                . "cod_sistema = '".$cod_sistema."', "
                . "novedad = '".$novedadNueva."'"
                . " WHERE novedad = '".$novedad."';";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt)
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
            else
            {
                $GLOBALS['mensaje'] = "No hay novedades registradas en el sistema";
            }
        }

        return $result;
    }

    public function crearNovedad($novedad,$sistema){

        $novedad = htmlspecialchars(trim($novedad));
        $sistema = htmlspecialchars(trim($sistema));

        if($sistema == 'Sistema Hidráulico y Sanitario'){
            $cod_sistema = 1;
        }else if($sistema == 'Sistema Eléctrico'){
            $cod_sistema = 2;
        }else if($sistema == 'Sistema Planta Física'){
            $cod_sistema = 3;
        }else if($sistema == 'Sistema Aires Acondicionados'){
            $cod_sistema = 4;
        }else if($sistema == 'Sistema Cubiertas'){
            $cod_sistema = 5;
        }

        $sql = "INSERT INTO novedad_sistema (novedad,cod_sistema) VALUES ('".$novedad."','".$cod_sistema."');";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            //$GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            $GLOBALS['mensaje'] = "Conexión erronea";
            return false;
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                return false;
            }else{
                $GLOBALS['mensaje'] = "Novedad creada correctamente";
                return true;
            }
        }

        return $result;
    }

    /**
     * Función que permite modificar los datos de una orden.
     * @param numerico $n, Entero que hace referencia al numero de la solicitud .
     * @param string $u, Cadena que hace referencia a el usuario que ordeno la solicitud.
     * @param string $e, cadea que hace referencia al estado de la solicitud.
     * @param string $d, Entero que hace referencia a la descripcion de la solicitud.
     * @param string $responsable_ejecucion Responsable de la ejecucion de la orden.
     * @param string $fecha_entrega_responsable Fecha de entrega de la orden.
     * @return boolean
     */
    public function modificarOrdenes($n, $u, $e, $d, $o, $responsable_ejecucion, $fecha_entrega_responsable) {
        $n = htmlspecialchars($n);
        //$u = htmlspecialchars($u);
        $e = htmlspecialchars($e);
        $d = htmlspecialchars($d);
        $o = htmlspecialchars($o);
        $responsable_ejecucion = htmlspecialchars($responsable_ejecucion);
        $fecha_entrega_responsable = htmlspecialchars($fecha_entrega_responsable);

        $sql = "UPDATE solicitudes_mantenimiento SET "
                . "estado = '".$e."', "
                . "descripcion = '".$d."', "
                . "operario = '".$o."', "
                . "responsable_ejecucion = '".$responsable_ejecucion."', "
                . "fecha_entrega_responsable = '".$fecha_entrega_responsable."' "
                . " WHERE numero_solicitud = '".$n."';";

        $l_stmt = $this->conexion->prepare($sql);

        if (!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_UPDATE_FALLIDA;
            return false;
        }
        else
        {
            if(!$l_stmt->execute())
            {
                $GLOBALS['mensaje'] = MJ_UPDATE_FALLIDA;
                return false;
            }
        }

        $sql2 = "INSERT INTO estado_orden VALUES ('".$u."','".$n."','".$e."','".$d."');";

        $l_stmt2 = $this->conexion->prepare($sql2);

        if(!$l_stmt2){
            $GLOBALS['mensaje'] = $sql2;
            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
            return false;
        }
        else
        {
            if(!$l_stmt2->execute())
            {
                $GLOBALS['mensaje'] = $sql2;
                //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                return false;
            }
        }

        $GLOBALS['mensaje'] = MJ_UPDATE_EXITOSA;

        return true;
    }


    /**
     * Función que permite eliminar una o mas ordenes del sistema.
     * @param array $id, Arreglo que contiene los ids de las ordenes
     * a eliminar.
     * @return boolean
     */
    public function eliminarOrdenes($id=array()) {

        for ($i = 0; $i < count($id); $i++)
        {
            $sql = "UPDATE solicitudes_mantenimiento SET estado = 'Eliminado' "
                    . "WHERE numero_solicitud = ".$id[$i];

            $l_stmt = $this->conexion->prepare($sql);
            if (!$l_stmt)
            {
                $GLOBALS['mensaje'] = MMJ_DELETE_FALLIDA;
                return false;
            }
            else
            {
                if(!$l_stmt->execute())
                {
                    $GLOBALS['mensaje'] = MJ_DELETE_FALLIDA;
                    return false;
                }
            }
        }

        $GLOBALS['mensaje'] = MJ_DELETE_EXITOSA;
        return true;
    }

    /**
     * Función que permite validar los datos.
     * @param numerico $n, Entero que hace referencia al numero de la solicitud .
     * @param string $u, Cadena que hace referencia a el usuario que ordeno la solicitud.
     * @param string $e, cadea que hace referencia al estado de la solicitud.
     * @param string $d, Entero que hace referencia a la descripcion de la solicitud .
     * @return boolean
     */
    public function validarDatos($n, $u, $e, $d)
    {
        $n = htmlspecialchars($n);
        $u = htmlspecialchars($u);
        $e = htmlspecialchars($e);
        $d = htmlspecialchars($d);

        if(is_string($u) & is_string($e) & is_string($d) & $n != 0 & $u != '' & $e !='Seleccionar' & $d != '')
        {
            return true;
        }
        else
        {
            $GLOBALS['mensaje'] = MJ_REVISE_FORMULARIO." ".MJ_NO_CAMPOS_VACIOS." ".", además selecciona una opción valida en el selector del estado.";
            return false;
        }
    }

    /**
     * [Funcion que obtiene el nombre de la novedad]
     * @param  [integer] $n [Hace referencia al identificador de la novedad]
     * @return [type]    [description]
     */
    public function getNombreNovedad($n){

        $n = htmlspecialchars(trim($n));

        $sql = "SELECT novedad FROM novedad_sistema WHERE id = '".$n."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            //$GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
        }
        else{
            if(!$l_stmt->execute()){
                //$GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA." Novedad2";
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                //$GLOBALS['mensaje'] = "Exito";
            }
            else{
                $result['0'] = "";
            }
        }

        return $result;
    }

    /**
     * funcion que permite obtener el login del usuario
     * @return $dato. Hace referencia a el nombre del usuario
     */
    public function getLoginUsuario($dato)
    {

        $parametro = htmlspecialchars(trim($dato));
        $parametro = mb_convert_case($parametro,MB_CASE_TITLE,"utf8");

        $sql = "SELECT login FROM usuarios_autorizados_sistema WHERE nombre_usuario = '".$parametro."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt->execute()){
           $GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
        }

        if($l_stmt->rowCount() > 0){
            $result = $l_stmt->fetchAll();
        }

        $data = $result[0];

        return $data;
    }

    /**
     * [Funcion que obtiene el correo de un usuario]
     * @param  [integer] $n [Hace referencia al login del usuario]
     * @return [type]    [description]
     */
    public function getCorreoUsuario($u){

        $u = htmlspecialchars(trim($u));

        $sql = "SELECT correo FROM usuarios_autorizados_sistema WHERE login = '".$u."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            return false;
        }
        else{
            if(!$l_stmt->execute()){
                return false;
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                return true;
            }
            else{
                 return false;
                $result['0'] = "Usuario no encontrado";
            }
        }

        return $result;
    }


    /**
     * Función que envía un correo
     */
    public function enviarMail($e,$u,$n,$d,$s){
        $n = htmlspecialchars($n);
        $e = htmlspecialchars($e);
        $d = htmlspecialchars($d);
        $s = htmlspecialchars($s);

        $mail = new PHPMailer();

        $mail->IsSMTP();
        //$mail->SMTPDebug  = 2;
        //$mail->Debugoutput = 'html';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        //Nuestra cuenta
        $mail->Username = EMAIL;
        $mail->Password = PASS; //Su password

        if($s == 1){
            $email = EMAILSISTHIDRAULICO;
        }else if($s == 2){
            $email = EMAILSISTELECTRICO;
        }else if($s == 3){
            $email = EMAILSISTPLANTAFISICA;
        }else if($s == 4){
            $email = EMAILSISTMOBILIARIO;
        }else{
            $email = 'soportesolicitudes.mantenimiento@correounivalle.edu.co';
        }

        $mail->From = $email;
        $mail->FromName= 'Solicitudes de Mantenimiento Universidad del Valle';

        //Agregar destinatario
        $mail->AddAddress($u);
        //$mail->AddAddress('juan.camilo.lopez@correounivalle.edu.co');
        $mail->Subject = 'Actualización Orden Mantenimiento #'.$n;
        $mail->Body = "La solicitud número ".$n." fue ".$e." con la descripción: ".$d." email: ".$u;

        //Enviar correo
        try {
            $mail->Send();
            $GLOBALS['mensaje'] = "Exito";
            return true;
        } catch (phpmailerException $e) {
            $GLOBALS['mensaje'] = "Error";
            return $e->errorMessage();
        } catch (Exception $e) {
            $GLOBALS['mensaje'] = "Error";
            return $e->getMessage();
        }
    }
}
?>