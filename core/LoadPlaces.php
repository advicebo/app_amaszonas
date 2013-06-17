<?php
include('config.php');

// --------------------------------------------------------------------------------------------------------
	$json = array( 'places' => array(), 'hours' => array(), 'traces' => array() );

	$place = array( 'id'=> '1', 'lugar'=> 'nombre' );
	$hora = array( 'id'=> '1', 'hora'=> 'hora' );
	$trazo = array( 'id'=> '1', 'trazo'=> 'hora' );
// --------------------------------------------------------------------------------------------------------
	$sql = "SELECT id,lugar FROM app_amaszonas_lugar"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida en LUGARES: '.mysql_error());

	while ( $res = mysql_fetch_array( $result ) ){
		$place['id'] = $res['id'];
		$place['lugar'] = utf8_encode($res['lugar']);

		$json['places'][] = $place;
	}

// --------------------------------------------------------------------------------------------------------
	$sql= "SELECT id,hora FROM app_amaszonas_hora"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida en HORA : '.mysql_error());

	while ( $res = mysql_fetch_array( $result ) ){
		$hora['id'] = $res['id'];
		$hora['hora'] = substr ( $res['hora'], 0, 5);

		$json['hours'][] = $hora;
	}
// --------------------------------------------------------------------------------------------------------
	$sql= "SELECT id,trazo FROM app_amaszonas_trazo"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida en TRAZO: '.mysql_error());

	while ( $res = mysql_fetch_array( $result ) ){
		$trazo['id'] = $res['id'];
		$trazo['trazo'] = $res['trazo'];
		
		$json['traces'][] = $trazo;
	}
// --------------------------------------------------------------------------------------------------------
	echo json_encode($json);	
?>
