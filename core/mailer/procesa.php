<?php
require_once("class.phpmailer.php");

$mail = new PHPMailer();

//$mail->Host("http://curso.cesarcancino.com");
	$nombre=$_GET['nombre'];
	$correo=$_GET['correo'];
	$ruta=$_GET['ruta'];
	$hora=$_GET['hora'];
	$precio=$_GET['precio'];
	$ci=$_GET['ci'];
	$telefono=$_GET['telefono'];


	$amaszonas='1234567';
	$admin='xiberty@gmail.com';



	/***************************************
			Mensaje para el Usuario
	****************************************/
	$mail->From = $admin;
    $mail->FromName = "AMASZONAS";
    $mail->Subject = "Reserva de boletos";
    $mail->AddAddress($correo,utf8_decode($nombre));
	//******************************+
	 
	 $body =" <h2>Confirmación de Boleto, Amaszonas</h2><br>";
	 $body .=" Saludos Sr(a). $nombre :<br><br>";
	 $body.= " Gracias por preferir amaszonas, Ud. ha reservado un boleto por internet, verifíque si los datos son correctos \n ";
	 $body.= " y porfavor confirme esta reserva en los próximos 20 minutos llamando al numero $amaszonas <br><br>";
	 $body.= " <b>Nombre:</b> $nombre<br> ";
	 $body.= " <b>E-Mail:</b> $correo<br> ";
	 $body.= " <b>C.I.:</b> $ci<br> ";
	 $body.= " <b>Telefono/Movil:</b> $telefono<br><br> ";
	 $body.= " <h3>Datos del vuelo</h3><hr>";
	 $body.= " <b>Ruta:</b> $ruta<br> ";
	 $body.= " <b>Hora de Salida:</b> $hora<br> ";
	 $body.= " <b>Precio:</b> $precio<br> ";
	 
	 $mail->Body = $body;
	 $mail->AltBody = "Esperamos su pronta respuesta, gracias..";
	 

	 // SEND AL USUARIO
	 $mail->Send();


$admail = new PHPMailer();
	/***************************************
			Mensaje para el Administrador
	****************************************/
	$admail->From = $correo;
    $admail->FromName = $nombre;
    $admail->Subject = "Reserva de boletos";
    $admail->AddAddress($admin,utf8_decode($nombre));
	//******************************+
	 
	 $body =" <h2>Reserva de Boleto, Amaszonas</h2><br>";
	 $body .=" Saludos:<br><br>";
	 $body.= " Se acaba de reservar un boleto de avión por medio de la página en internet \n ";
	 $body.= " estos son los detalles:<hr><br>";
	 $body.= " <b>Nombre:</b> $nombre<br> ";
	 $body.= " <b>E-Mail:</b> $correo<br> ";
	 $body.= " <b>C.I.:</b> $ci<br> ";
	 $body.= " <b>Telefono/Movil:</b> $telefono<br><br> ";
	 $body.= " <h3>Datos del vuelo</h3><hr>";
	 $body.= " <b>Ruta:</b> $ruta<br> ";
	 $body.= " <b>Hora de Salida:</b> $hora<br> ";
	 $body.= " <b>Precio:</b> $precio<br> ";
	 
	 $admail->Body = $body;
	 $admail->AltBody = "Reserva de boletos, es un servicio de Advice Ltda.";
	 

	 echo "Registro y envio de mail exitosos --> ".$sql ;
	 

	 // SEND AL USUARIO
	 $admail->Send();

	
?>