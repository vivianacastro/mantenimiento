<?php
/**
 *clase de modelo del modulo de registros
 */
class Modelo_registros
{
    protected $conexion;

    /**
     * Función contructor de la clase Modelo_registros.
     * @param string $dbname nombre de la base de datos a la que se va a 
     * conectar el modelo.
     * @param string $dbuser usuario con el que se va a conectar a la 
     * base de datos.
     * @param string $dbpass contraseña para poder acceder a la base de datos.
     * @param string $dbhost Host en donde se encuentra la base de datos.
     */
    public function __construct($dbname,$dbuser,$dbpass,$dbhost)
    {    
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
     * Funcion que permite guardar las ordenes de mantenimiento en la base de datos, ademas hace una verificacion,
     * en base al parametro novedad permitiendo hacer una unica solicitud o multiples si los codigos del sistema son diferentes
     * @param   string $nombre. Hace referencia al nombre del usuario que solicita la orden 
     * @param   string $sede. hace referencia a la sede Cali de Univalle.
     * @param   string $campus. Hace referencia al campus de la universidad donde se reporta la solicitud
     * @param   int $edificio. Hace referencia al edificio seleccionado por el usuario 
     * @param   int $piso. Hace referencia al piso seleccionado
     * @param   string $espacio. hace referencia al espacio ingresado
     * @param   string $contacto. Hace referencial contacto ingresado
     * @param   int $cantidad.  Hace referencia a la cantidad ingresado
     * @param   string $descripcion. Hace referencia a la novedad 1 seleccionada
     * @param   int $cantidad2. hace referencia a la cantidad 2 ingresada
     * @param   string $descripcion2 hace referencia a la novedad 2 seleccionada
     * @return Bool Devuelve un valor booleano true o false si al ejecucion del query sql fue correcto, además de instanciar el arreglo global mensaje
     * que se encarga de mostrar mensaje en div del fmr de la vista
     */
    /*public function insertarOrdenes($nombre, $sede, $campus, $edificio, $piso, $espacio, $contacto, $cantidad, $descripcion, $cantidad2, $descripcion2, $otranovedad, $otranovedad2)
    {
        /*Decodificar los valores recibidos por post del archivo json*/
        /*$n = htmlspecialchars(trim($nombre));
        $s = htmlspecialchars(trim($sede));
        $cp = htmlspecialchars(trim($campus));
        $e = htmlspecialchars(trim($edificio));
        $p = htmlspecialchars(trim($piso));
        $esp = htmlspecialchars(trim($espacio));
        $cont = htmlspecialchars(trim($contacto));
        $cant = htmlspecialchars(trim($cantidad));
        $des = htmlspecialchars(trim($descripcion));
        $cant2 = htmlspecialchars(trim($cantidad2));
        $des2 = htmlspecialchars(trim($descripcion2));
        $onov = htmlspecialchars(trim($otranovedad));
        $onov2 = htmlspecialchars(trim($otranovedad2));

        //Se obtienen los codigos de la sede, campus, novedad y sistema *importante usar $this->nombreMetododelaClase();
        $usuario = $this->getLoginUsuario($n);
        $login = $usuario[0];
        $Sede = $this->getCodigoSede($s);
        $codSede = $Sede[0];
        $Campus = $this->getCodigoCampus($cp);
        $codCampus = $Campus[0];
        $codNovedad = $this->getCodigoNovedad($des);
        $tmp_novedad = $codNovedad[0];
        $Sistema = $this->getCodigoSistema($tmp_novedad);
        $codSistema = $Sistema[0];
        $impreso = 0;

        if($des2 != 'Seleccionar')
        {
            $codNovedad2 = $this->getCodigoNovedad($des2);
            $tmp_novedad2 = $codNovedad2[0];
            $Sistema2 = $this->getCodigoSistema($tmp_novedad2);
            $codSistema2 = $Sistema2[0];

            if($codSistema == $codSistema2)
            {
                if($codSistema == 5 and $des == 'Otro' and $codSistema2 == 5 and $des2 == 'Otro'){

                    $sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,cod_sistema,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$codSistema."','".$cont."','Solicitado','".$onov."','".$onov2."','".$impreso."');";
                    
                    $l_stmt1 = $this->conexion->prepare($sql1);

                    if(!$l_stmt1)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt1->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud1 = $this->getNumeroSolicitud();
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud1[0];

                    return true;

                }
                else{
                    $sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,cod_sistema,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$codSistema."','".$cont."','Solicitado','".$onov."','".$onov2."','".$impreso."');";
                    
                    $l_stmt1 = $this->conexion->prepare($sql1);

                    if(!$l_stmt1)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt1->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud1 = $this->getNumeroSolicitud();
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud1[0];

                    return true;
                }
            }
            else
            {
                if($codSistema == 5 and $des == 'Otro' and $codSistema2 != 5 and $des2 != 'Otro')
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$codSistema."','".$cont."','Solicitado','".$onov."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$codSistema2."','".$cont."','Solicitado','".$des2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;

                }
                else if($codSistema2 == 5 and $des2 == 'Otro' and $codSistema != 5 and $des != 'Otro')
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$codSistema."','".$cont."','Solicitado','".$des."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$codSistema2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;
                }
                else
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$codSistema."','".$cont."','Solicitado','".$des."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$codSistema2."','".$cont."','Solicitado','".$des2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;

                }
                
            }
        }
        else
        {
            if($codSistema == 5 and $des == 'Otro'){
                $sql = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                    VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$codSistema."','".$cont."','Solicitado','".$onov."','".$impreso."');";

                $l_stmt = $this->conexion->prepare($sql);

                if(!$l_stmt)
                {
                    $GLOBALS['mensaje'] = "Error: SQL";
                   // $GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);;
                    return false;
                }
                else
                {
                    if(!$l_stmt->execute())
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);;
                        return false;
                    }
                }
            
                $numeroSolicitud = $this->getNumeroSolicitud();

                $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud[0];

                return true;
            }
            else{
                $sql = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cod_sistema,contacto,estado,descripcion_novedad,impreso) 
                    VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$codSistema."','".$cont."','Solicitado','".$des."','".$impreso."');";

                $l_stmt = $this->conexion->prepare($sql);

                if(!$l_stmt)
                {
                    $GLOBALS['mensaje'] = "Error: SQL";
                    //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);;
                    return false;
                }
                else
                {
                    if(!$l_stmt->execute())
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);;
                        return false;
                    }
                }
            
                $numeroSolicitud = $this->getNumeroSolicitud();

                $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud[0];

                return true;
            }
        }      
    }*/
    
    
    /**
     * Funcion que permite guardar las ordenes de mantenimiento en la base de datos, ademas hace una verificacion,
     * en base al parametro novedad permitiendo hacer una unica solicitud o multiples si los codigos del sistema son diferentes
     * @param   string $nombre. Hace referencia al nombre del usuario que solicita la orden 
     * @param   string $sede. hace referencia a la sede Cali de Univalle.
     * @param   string $campus. Hace referencia al campus de la universidad donde se reporta la solicitud
     * @param   int $edificio. Hace referencia al edificio seleccionado por el usuario 
     * @param   int $piso. Hace referencia al piso seleccionado
     * @param   string $espacio. hace referencia al espacio ingresado
     * @param   string $contacto. Hace referencial contacto ingresado
     * @param   int $cantidad.  Hace referencia a la cantidad ingresado
     * @param   string $descripcion. Hace referencia a la novedad 1 seleccionada
     * @param   int $cantidad2. hace referencia a la cantidad 2 ingresada
     * @param   string $descripcion2 hace referencia a la novedad 2 seleccionada
     * @return Bool Devuelve un valor booleano true o false si al ejecucion del query sql fue correcto, además de instanciar el arreglo global mensaje
     * que se encarga de mostrar mensaje en div del fmr de la vista
     */
   public function insertarOrdenes($nombre, $sede, $campus, $edificio, $piso, $espacio, $contacto, $cantidad, $descripcion, $cantidad2, $descripcion2, $cantidad3, $descripcion3, $otranovedad, $otranovedad2, $otranovedad3)
    {
        /**Decodificar los valores recibidos por post del archivo json*/
        $n = htmlspecialchars(trim($nombre));
        $s = htmlspecialchars(trim($sede));
        $cp = htmlspecialchars(trim($campus));
        $e = htmlspecialchars(trim($edificio));
        $p = htmlspecialchars(trim($piso));
        $esp = htmlspecialchars(trim($espacio));
        $cont = htmlspecialchars(trim($contacto));
        $cant = htmlspecialchars(trim($cantidad));
        $des = htmlspecialchars(trim($descripcion));
        $cant2 = htmlspecialchars(trim($cantidad2));
        $des2 = htmlspecialchars(trim($descripcion2));
        $cant3 = htmlspecialchars(trim($cantidad3));
        $des3 = htmlspecialchars(trim($descripcion3));
        $onov = htmlspecialchars(trim($otranovedad));
        $onov2 = htmlspecialchars(trim($otranovedad2));
        $onov3 = htmlspecialchars(trim($otranovedad3));

        //Se obtienen los codigos de la sede, campus, novedad y sistema *importante usar $this->nombreMetododelaClase();
        $login = $n;
        $Sede = $this->getCodigoSede($s);
        $codSede = $Sede[0];
        $Campus = $this->getCodigoCampus($cp);
        $codCampus = $Campus[0];
        $codNovedad = $this->getCodigoNovedad($des);
        $tmp_novedad = $codNovedad[0];
        $Sistema = $this->getCodigoSistema($tmp_novedad);
        $codSistema = $Sistema[0];
        $impreso = 0;

        if($des2 != 'Seleccionar' and $des3 == 'Seleccionar')
        {
            $codNovedad2 = $this->getCodigoNovedad($des2);
            $tmp_novedad2 = $codNovedad2[0];
            $Sistema2 = $this->getCodigoSistema($tmp_novedad2);
            $codSistema2 = $Sistema2[0];

            if($codSistema == $codSistema2)
            {
                if($codSistema == 5 and $des == 'Otro' and $codSistema2 == 5 and $des2 == 'Otro'){

                    $sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov."','".$onov2."','".$impreso."');";
                    
                    $l_stmt1 = $this->conexion->prepare($sql1);

                    if(!$l_stmt1)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt1->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud1 = $this->getNumeroSolicitud();
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud1[0];

                    return true;

                }
                else{
                    $sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov."','".$onov2."','".$impreso."');";
                    
                    $l_stmt1 = $this->conexion->prepare($sql1);

                    if(!$l_stmt1)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt1->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud1 = $this->getNumeroSolicitud();
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud1[0];

                    return true;
                }
            }
            else
            {
                if($codSistema == 5 and $des == 'Otro' and $codSistema2 != 5 and $des2 != 'Otro')
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;

                }
                else if($codSistema2 == 5 and $des2 == 'Otro' and $codSistema != 5 and $des != 'Otro')
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;
                }
                else
                {
                    $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                        VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";

                    $l_stmt2 = $this->conexion->prepare($sql2);

                    if(!$l_stmt2)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt2->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                            VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";

                
                    $l_stmt3 = $this->conexion->prepare($sql3);

                    if(!$l_stmt3)
                    {
                        $GLOBALS['mensaje'] = "Error: SQL";
                        //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                        return false;
                    }
                    else
                    {
                        if(!$l_stmt3->execute())
                        {
                            $GLOBALS['mensaje'] = "Error: SQL";
                            //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                            return false;
                        }
                    }

                    $numeroSolicitud2 = $this->getNumeroSolicitud();
                    $nSol2 = $numeroSolicitud2[0];
                    $nSol1 = $nSol2 - 1;
                    $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;

                    return true;

                }
                
            }
        }else if($des2 != 'Seleccionar' and $des3 != 'Seleccionar')
        {
            $codNovedad2 = $this->getCodigoNovedad($des2);
            $tmp_novedad2 = $codNovedad2[0];
            $Sistema2 = $this->getCodigoSistema($tmp_novedad2);
            $codSistema2 = $Sistema2[0];
            $codNovedad3 = $this->getCodigoNovedad($des3);
            $tmp_novedad3 = $codNovedad3[0];
            $Sistema3 = $this->getCodigoSistema($tmp_novedad3);
            $codSistema3 = $Sistema3[0];

            if($codSistema == $codSistema2 and $codSistema == $codSistema3)
            {
            	$sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,cantidad3,descripcion3,contacto,estado,descripcion_novedad,descripcion_novedad2,descripcion_novedad3,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$cant3."','".$tmp_novedad3."','".$cont."','Solicitado','".$onov."','".$onov2."','".$onov3."','".$impreso."');";
                    
               $l_stmt1 = $this->conexion->prepare($sql1);

               if(!$l_stmt1)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt1->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
                   }
                   $numeroSolicitud1 = $this->getNumeroSolicitud();
                   $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud1[0];
                   return true;
            }else if($codSistema == $codSistema2 and $codSistema != $codSistema3)
            {
            	$sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov."','".$onov2."','".$impreso."');";
                    
               $l_stmt1 = $this->conexion->prepare($sql1);

               if(!$l_stmt1)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt1->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant3."','".$tmp_novedad3."','".$cont."','Solicitado','".$onov3."','".$impreso."');";
                    
               $l_stmt2 = $this->conexion->prepare($sql2);

               if(!$l_stmt2)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt2->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $numeroSolicitud2 = $this->getNumeroSolicitud();
               $nSol2 = $numeroSolicitud2[0];
               $nSol1 = $nSol2 - 1;
               $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;
               return true;
               
            }else if($codSistema != $codSistema2 and $codSistema == $codSistema3)
            {
            	$sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cant3."','".$tmp_novedad3."','".$cont."','Solicitado','".$onov."','".$onov3."','".$impreso."');";
                    
               $l_stmt1 = $this->conexion->prepare($sql1);

               if(!$l_stmt1)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt1->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";
                    
               $l_stmt2 = $this->conexion->prepare($sql2);

               if(!$l_stmt2)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt2->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $numeroSolicitud2 = $this->getNumeroSolicitud();
               $nSol2 = $numeroSolicitud2[0];
               $nSol1 = $nSol2 - 1;
               $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;
               return true;
               
            }else if($codSistema != $codSistema2 and $codSistema2 == $codSistema3)
            {
            	$sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,cantidad2,descripcion2,contacto,estado,descripcion_novedad,descripcion_novedad2,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$cant3."','".$tmp_novedad3."','".$cont."','Solicitado','".$ono2."','".$onov3."','".$impreso."');";
                    
               $l_stmt1 = $this->conexion->prepare($sql1);

               if(!$l_stmt1)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt1->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";
                    
               $l_stmt2 = $this->conexion->prepare($sql2);

               if(!$l_stmt2)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt2->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                     }
               }
               
               $numeroSolicitud2 = $this->getNumeroSolicitud();
               $nSol2 = $numeroSolicitud2[0];
               $nSol1 = $nSol2 - 1;
               $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2;
               return true;
            }
            else
            {
            	
            	$sql1 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
            	VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";

               $l_stmt1 = $this->conexion->prepare($sql1);

               if(!$l_stmt1)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt1->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                  }
               }
            	
            	
            	$sql2 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
            	VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant2."','".$tmp_novedad2."','".$cont."','Solicitado','".$onov2."','".$impreso."');";

               $l_stmt2 = $this->conexion->prepare($sql2);

               if(!$l_stmt2)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt2->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                  }
               }
               $sql3 = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
               VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant3."','".$tmp_novedad3."','".$cont."','Solicitado','".$onov3."','".$impreso."');";

				   $l_stmt3 = $this->conexion->prepare($sql3);

               if(!$l_stmt3)
               {
               	$GLOBALS['mensaje'] = "Error: SQL";
                  //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                  return false;
               }
               else
               {
               	if(!$l_stmt3->execute())
                  {
                  	$GLOBALS['mensaje'] = "Error: SQL";
                     //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
                     return false;
                  }
               }
               $numeroSolicitud3 = $this->getNumeroSolicitud();
               $nSol3 = $numeroSolicitud3[0];
               $nSol2 = $nSol3 - 1;
					$nSol1 = $nSol2 - 1;
               $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Sus solicitudes son las número: ".$nSol1."-".$nSol2."-".$nSol3;
                  
               return true;
                
            }
        }
        else
        {
               $sql = "INSERT INTO solicitudes_mantenimiento (usuario,cod_sede,codigo_campus,codigo_edificio,piso,espacio,cantidad1,descripcion1,contacto,estado,descripcion_novedad,impreso) 
                   VALUES ('".$login."','".$codSede."','".$codCampus."','".$e."','".$p."','".$esp."','".$cant."','".$tmp_novedad."','".$cont."','Solicitado','".$onov."','".$impreso."');";

               $l_stmt = $this->conexion->prepare($sql);

               if(!$l_stmt)
               {
                   $GLOBALS['mensaje'] = "Error: SQL";
                   //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);
                  return false;
               }
               else
               {
                   if(!$l_stmt->execute())
                   {
                       $GLOBALS['mensaje'] = "Error: SQL";
                       //$GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(), true);
                       return false;
                   }
               }
           
               $numeroSolicitud = $this->getNumeroSolicitud();

               $GLOBALS['mensaje'] = MJ_INSERT_REGISTROS_EXITOSA." Su solicitud es la número: ".$numeroSolicitud[0];

               return true;
        }      
    }
 
    /**
     * Función que permite validar si los datos son vacion
     * @param string $c, Cadena que hace referencia al campus. 
     * @param string $e, Cadena que hace referencia al edificio 
     * @param string $p, Cadena que hace referencia al piso.
     * @param string $es, Cadena que hace referencia al espacio.
     * @param string $con, Cadena que hace referencia al contacto.
     * @param string $des1, Hace referencia al la descripcion 1.
     * @param string $cant1, Hace referencia al la cantidad 1.
     * @return boolean
     */
    public function validarDatos($c, $e, $p, $es, $con, $cant1, $des1)
    {
        $c = htmlspecialchars(trim($c));
        $e = htmlspecialchars(trim($e));
        $p = htmlspecialchars(trim($p));
        $es = htmlspecialchars(trim($es));
        $con = htmlspecialchars(trim($con));
        $des1 = htmlspecialchars(trim($des1));
        $cant1 = htmlspecialchars(trim($cant1));
        
        if(is_string($c) & is_string($e) & is_string($p) & is_string($es) & is_string($con) & is_string($des1) & is_string($cant1))
        {
            if(trim($c) != '' & trim($e) != '' & trim($p) != '' &  trim($es) != '' & trim($con) != '' & $des1 != ''  & $cant1 != '') 
            {
                if($cant1 <= 99)
                {
                    return true;
                }
                else{
                    $GLOBALS['mensaje'] = "Error en el campo de cantidad el valor máximo es 99";
                    return false;
                }
            }
            else 
            {
                $GLOBALS['mensaje'] = MJ_NO_CAMPOS_VACIOS;
                return false;
            }
        }
        else {
            $GLOBALS['mensaje'] = MJ_REVISE_FORMULARIO." ".MJ_NO_CAMPOS_VACIOS;
            return false;
        }
    }

    /**
     * funcion quer permite buscar los edificios de la sede melendes
     * @param  [int] $p hace referencia al codigo del campus 01==melendez,02==San fernando,03==Otros
     * @return [ResultSet] contiene la informacion de la busqueda.
     */
    public function buscarDBEdificio($p){

        $p = htmlspecialchars(trim($p));

        if($p == 01)
        {
            $sql = "SELECT codigo,nombre,pisos FROM edificiomelendez ORDER BY codigo;";
            $l_stmt = $this->conexion->prepare($sql);
            if (!$l_stmt){
                $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            }
            else{
                if(!$l_stmt->execute()){
                    $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                }

                if($l_stmt->rowCount() > 0)
                {
                    $result = $l_stmt->fetchAll();
                    $GLOBALS['mensaje'] = "Éxito";
                }
            }
           
        }
        if($p == 02){
            $sql = "SELECT codigo,nombre,pisos FROM edifsanfernando ORDER BY codigo;";
            $l_stmt = $this->conexion->prepare($sql);
            if (!$l_stmt){
                $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            }
            else{
                if(!$l_stmt->execute()){
                    $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                }

                if($l_stmt->rowCount() > 0)
                {
                    $result = $l_stmt->fetchAll();
                    $GLOBALS['mensaje'] = "Éxito";
                }
            }
           
        }
        if($p == 03){
            $sql = "SELECT codigo,nombre,pisos FROM otrosespacios ORDER BY codigo;";
            $l_stmt = $this->conexion->prepare($sql);
            if (!$l_stmt){
                $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;
            }
            else{
                if(!$l_stmt->execute()){
                    $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
                }

                if($l_stmt->rowCount() > 0)
                {
                    $result = $l_stmt->fetchAll();
                    $GLOBALS['mensaje'] = "Éxito";
                }
            }
            
        }

        return $result;    
    }

    /**
     * Funcion que permite buscar las novedad registradas en la base de datos
     * 
     * @return [ResultSet] $result contiene los datos obtenidos en la busqueda
     */
    public function buscarDBNovedad()
    {
        
        //$sql = "SELECT sistema.novedad, novedad_sistema.cod_sistema FROM novedad_sistema JOIN sistema ON sistema.cod_sistema = novedad_sistema.cod_sistema ORDER BY nombre_sistema, novedad;";
        $sql = "SELECT novedad_sistema.novedad, novedad_sistema.cod_sistema FROM novedad_sistema JOIN sistema ON novedad_sistema.cod_sistema = sistema.cod_sistema ORDER BY sistema.sistema, novedad_sistema.novedad;";

        $l_stmt = $this->conexion->prepare($sql);
        if (!$l_stmt)
        {
            $GLOBALS['mensaje'] = MJ_PREPARAR_CONSULTA_FALLIDA;            
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito";
            }             
        }
         
        return $result;
    }

    /**
     * funcion que permite buscar los datos de los campus de la universidad
     * @return metadata con elresultado de la busqueda
     */
    public function buscarDBCampus()
    {

        $sql = "SELECT nombre from campus ORDER BY codigo;";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = "Error en la consulta"; 
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = "Error en la consulta";
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito en mi consulta";
            }
        }

        return $result;
    }

    /**
     * funcion que permite retornar los datos de los pisos de la universidad
     * @return un metadata con el resultado de la busqueda
    */
    public function buscarDBPiso()
    {

        $sql = "SELECT piso FROM piso ORDER BY id;";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = "Error en la consulta";
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = "Error en la consulta";
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito en la consulta";
            }
        }

        return $result;
    }

    /**
     * funcion que permite retornar los datos del usuario registrado para mostrarlos en el home de la apliacion
     * @param  string $key [contiene el nombre del usuario registrado al cual deseamos buscar]
     * @return un metadata con el resultado de la busqueda
     */
    public function buscarDBUsuario($key)
    {

        $key = htmlspecialchars(trim($key));

        $sql = "SELECT nombre_usuario,correo,telefono,extension FROM usuarios_autorizados_sistema WHERE login = '".$key."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = "Error en la consulta";
        }
        else{

            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = "Error en la consulta"; 
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito";
            }
        }

        return $result;
    }

    /**
     * Funcion que permite obtener el codugo de la sede para la orden de mantenimiento ingresada por el usuario
     * @param  [string] $sede [description]
     * @return $sede. hace referencia al codigo de la sede 
     */
    public function getCodigoSede($dato)
    {
        $parametro = htmlspecialchars(trim($dato));

        $sql = "SELECT cod_sede from sede where sede = '".$parametro."';";

        $l_stmt = $this->conexion->prepare($sql);
        
        if(!$l_stmt){
            $GLOBALS['mensaje'] = "Error SQL";
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = "Error al hacer la consulta.";
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
            }
        }

        $sede = $result[0];

        return $sede;
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
            $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito";
            }
            else{
                $result['0'] = "--";
            }
        }

        return $result;
    }

    /**
     * Funcion que permite ontener el codigo del campus para una orden registrada por el usuario
     * @param  [string] $campus [hace referencia al campus seleccionado por el usuario]
     * @return $campus. hace referencia al codigo del campus seleccionado
     */
    public function getCodigoCampus($campus)
    {

        $parametro = htmlspecialchars(trim($campus));

        $sql = "SELECT codigo FROM campus where nombre = '".$parametro."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = "Error SQL";
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = "Error";
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
            }
        }

        $campus = $result[0];

        return $campus;
        
    }

    /**
     * Funcion que permite obtener el número de solicitud de la orden
     * @return $solicitud. devuelve el ultimo numero de orden registrado correspondiente a la orden del usuario
     */
    public function getNumeroSolicitud()
    {

        $sql = "SELECT numero_solicitud FROM solicitudes_mantenimiento ORDER BY numero_solicitud DESC LIMIT 1;"; 
        
        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt->execute()){
            $GLOBALS['mensaje'] = "Error SQL";
        }

        if($l_stmt->rowCount() > 0){
            $result = $l_stmt->fetchAll();
        }

        $solicitud = $result[0];

        return $solicitud;
    }

    /**
     * funcion que permite obtener el codigo de una novedad registrada por el usuario
     * @return $novedad. Hace referencia al codigo de la novedad 
     */
    public function getCodigoNovedad($dato)
    {
        $parametro = htmlspecialchars(trim($dato));

        $sql = "SELECT id from novedad_sistema WHERE novedad = '".$parametro."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt->execute()){
            $GLOBALS['mensaje'] = "Error SQL";
        }

        if($l_stmt->rowCount() > 0){
            $result = $l_stmt->fetchAll();
    
        }
        else
        {
            $result = array('400',);
        }

        $novedad = $result[0];

        return $novedad;
    }

    /**
     * funcion que permite obtener el codigo del sistema asociado a la novedad registrada del usuario
     * @return $sistema. Hace referencia a al codigo del sistema asociado a la novedad
     */
    public function getCodigoSistema($dato)
    {

        $parametro =htmlspecialchars(trim($dato));

        $sql = "SELECT cod_sistema FROM novedad_sistema WHERE id = '".$parametro."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt->execute()){
           $GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
        }
        
        if($l_stmt->rowCount() > 0){
            $result = $l_stmt->fetchAll();
        }
        else{
            $result = array('5',);
        }

        $sistema = $result[0];

        return $sistema;
    }

    /**
     * funcion que permite obtener el login del usuario 
     * @return $dato. Hace referencia a el nombre del usuario
     */
    public function getLoginUsuario($dato)
    {

        $parametro =htmlspecialchars(trim($dato));

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
     * [Funcion que obtiene el nombre de la novedad]
     * @param  [integer] $n [Hace referencia al identificador de la novedad]
     * @return [type]    [description]
     */
    public function getNovedad($n){
        $n = htmlspecialchars(trim($n));

        $sql = "SELECT * FROM novedad_sistema WHERE id = '".$n."';";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt){
            $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
        }
        else{
            if(!$l_stmt->execute()){
                $GLOBALS['mensaje'] = MJ_CONSULTA_FALLIDA;
            }

            if($l_stmt->rowCount() > 0){
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito";
            }
            else{
                $result['0'] = "";
            }
        }

        return $result;
    }

    /**
    *funcion que permite devolver las ultimas 5 ordenes del sistema 
    *@param campus hace referencia al campus elegido por el usuario en el frm
    *@param edificio hace referencia al edificio elegido por el usuario en el frm
    *@param piso hace referencia al piso elegido por el usuario en el frm
    */
    public function buscarUltimasOrdenes($campus, $edificio, $piso){
        $c = htmlspecialchars(trim($campus));
        $e = htmlspecialchars(trim($edificio));
        $p = htmlspecialchars(trim($piso));

        $Campus = $this->getCodigoCampus($c);
        $codCampus = $Campus[0];

        $sql = "SELECT * FROM solicitudes_mantenimiento WHERE codigo_campus = '".$codCampus."' AND codigo_edificio = '".$e."' AND piso = '".$p."' ORDER BY numero_solicitud DESC LIMIT 5;";

        $l_stmt = $this->conexion->prepare($sql);

        if(!$l_stmt)
        {
            $GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
        }
        else
        {
            if(!$l_stmt->execute())
            {
                $GLOBALS['mensaje'] = var_export($this->conexion->errorInfo(),true);;
            }

            if($l_stmt->rowCount() > 0)
            {
                $result = $l_stmt->fetchAll();
                $GLOBALS['mensaje'] = "Éxito";
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
            $email = 'mantenimiento.univalle@correounivalle.edu.co';
        }
        
        $mail->From = $email;
        $mail->FromName= 'Mantenimiento Universidad del Valle';
        
        //Agregar destinatario
        $mail->AddAddress($u);
        //$mail->AddAddress('juan.camilo.lopez@correounivalle.edu.co');
        $mail->Subject = 'Orden de Mantenimiento #'.$n;
        $mail->Body = "La solicitud número ".$n." fue creada en el sistema de Solicitudes de Mantenimiento, el estado de esta se puede
        consultar dentro del sistema.";

        //Enviar correo
        try {
            $mail->Send();
            //$GLOBALS['mensaje'] = "Exito";
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
