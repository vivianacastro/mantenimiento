<?
include_once('class.phpmailer.php');
include_once('class.smtp.php');
session_start();
$login = strtolower($_POST['login2']);
$correo = strtolower($_POST['correo2']);

$source = 'abcdefghijklmnopqrstuvwxyz';
$source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$source .= '1234567890';
$rstr = "";
$source = str_split($source,1);
for($i=1; $i<=10; $i++){
    mt_srand((double)microtime() * 1000000);
    $num = mt_rand(1,count($source));
    $rstr .= $source[$num-1];
}

$mail = new PHPMailer();
     
$mail->IsSMTP();
/*$mail->SMTPDebug  = 2;
$mail->Debugoutput = 'html';*/
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->CharSet = 'UTF-8';

$email = 'mantenimiento.univalle@gmail.com';
$pass = 'ManteUnivalle';

$mail->Username = $email;
$mail->Password = $pass; //Su password

$mail->From = $email;
$mail->Sender = $email;
$mail->FromName= 'Mantenimiento Universidad del Valle';

//Agregar destinatario
$mail->AddAddress($correo);

//$mail->AddAddress('juan.camilo.lopez@correounivalle.edu.co');
$mail->Subject = 'Reestablecer contraseña de acceso al sistema';
$mail->Body = 'Se ha solicitado reestablecer la contraseña de la cuenta con usuario: '.$login.' a este correo, para ingresar utilice esta
contraseña temporal: '.$rstr.' y a continuación proceda a cambiar la contraseña en la pestaña "Opciones de cuenta/Actualizar Datos"';

$c = md5($rstr);

// conexion a la base de datos
$dbconn = pg_connect("host=localhost port=5432 dbname=solicitudes_mantenimiento user=postgres password=12") or die('NO HAY CONEXION: ' . pg_last_error());

$result3 = pg_query("SELECT * FROM usuarios_autorizados_sistema WHERE correo = '".$correo."' AND login = '".$login."';");

if(pg_num_rows($result3) == 0) {
  echo '<script type="text/javascript">confirm("El correo y/o login no se encuentran asociados a una cuenta");</script>';
  echo '<script type="text/javascript">' ."\n";
  echo 'window.location="../olvido_contrasenia.html";'; 
  echo '</script>';
  pg_close($dbconn);
}else{
  $query = "UPDATE usuarios_autorizados_sistema SET password = '".$c."' WHERE correo = '".$correo."' AND login = '".$login."';";

  if( ! $result = pg_query($dbconn, $query) )
  {
    echo '<script type="text/javascript">confirm("El correo y/o login no se encuentran asociados a una cuenta");</script>';
  	echo '<script type="text/javascript">' ."\n";
    echo 'window.location="../olvido_contrasenia.html";'; 
    echo '</script>';
  	pg_close($dbconn);
  }
  else
  {
      pg_close($dbconn);
      //Enviar correo
      try {
        $mail->Send();
      } catch (phpmailerException $e) {
        //return $e->errorMessage();
      } catch (Exception $e) {
        //return $e->getMessage();
      }
      echo "<script type='text/javascript'>confirm('Se ha enviado un correo a ".$correo." con la informaci\u00F3n para reestablecer la contrase\u00F1a');</script>";
      echo '<script type="text/javascript">' . "\n";
      echo 'window.location="http://192.168.46.53/mantenimiento/web/index.php";'; 
      echo '</script>';
  }
}
session_destroy();
?>