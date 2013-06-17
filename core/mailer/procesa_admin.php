<?php
require_once("class.phpmailer.php");

$mail = new PHPMailer();

//$mail->Host("http://curso.cesarcancino.com");
	$nombre=$_GET['nombre'];
	$correo=$_GET['correo'];
	$mensaje=$_GET['mensaje'];

/*	$nombre='Victor';
	$correo='jvacx.log@gmail.com';
	$mensaje='brooooooo';*/

	//***************************************
	//configuramos la información del correo o email
	$mail->From = "$correo";
    $mail->FromName = "$nombre";
    $mail->Subject = "Reserva de boletos(s)";
    $mail->AddAddress("xiberty@gmail.com",utf8_decode($nombre));
  //  $mail->AddAddress("destino2@correo.com","Nombre 02");
    //$mail->AddCC("usuariocopia@correo.com");
    //$mail->AddBCC("usuariocopiaoculta@correo.com");
	
	//******************************+
	//configuramos el cuerpo del mensaje
	 
	 $body  = "Hola Recibio una Consulta de:<br><br>";
	 $body.= " Nombre: $nombre<br><br> ";
	 $body.= " E-Mail: $correo<br><br><br><br> ";
	 $body.= " Mensaje: $mensaje<br><br>";
	 
	 $mail->Body = $body;
	 $mail->AltBody = "$mensaje";
	 
	 //hacemos el upload del archivo

	 echo "Registro y envio de mail exitosos --> ".$sql ;
	 
	 $mail->Send();
	 
	 
	 // header("Location: ../contacto.php?m=1");
	
?>