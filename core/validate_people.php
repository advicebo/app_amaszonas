<?php
include('config.php');
include('lib.php');

	$ci = $_POST['ci'];
	$correo = $_POST['correo'];


	$sql = "SELECT id,ci,nombre,correo,telefono FROM app_amaszonas_participante WHERE ci='".$ci."' AND correo='".$correo."'"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida PARTICIPANTE: '.mysql_error());

	$followers = array( 'followers' => array(), );

	$follower = array( 'id'=> '1',
					'ci'=> 'ci',
					'nombre'=> 'nombre',
					'correo'=> 'correo',
					'telefono'=> 'telefono'
				  );

	while ( $res = mysql_fetch_array( $result ) ){
		$follower['id'] = $res['id'];
		$follower['ci'] = $res['ci'];
		$follower['nombre'] = utf8_encode($res['nombre']);
		$follower['correo'] = utf8_encode($res['correo']);
		$follower['telefono'] = $res['telefono'];

		$followers['followers'][] = $follower;
	}

	echo json_encode($followers);	
?>
