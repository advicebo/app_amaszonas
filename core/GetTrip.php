<?php
include('config.php');
include('lib.php');

	$id = $_POST['id'];


	$sql = "SELECT id,ini,fin,descripcion,precio,plazas,hora,ffin FROM app_amaszonas_promocion WHERE id=".$id; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida GET TRIP: '.mysql_error());


	$trip = array(  'id'=> '1',
					'ini'=> 'ini',
					'fin'=> 'fin',
					'description' => 'route', 
					'price'=> 'descripcion',
					'places'=> 'precio',
					'hour'=> 'plazas',
					'route'=> 'hora',
					'date'=> 'ffin',
					'datesp'=> 'datesp',
					'datetime'=> 'datetime',
				  );

	while ( $res = mysql_fetch_array( $result ) ){
		$trip['id'] = $res['id'];
		$trip['ini'] = $res['ini'];
		$trip['fin'] = $res['fin'];
		$trip['description'] = utf8_encode($res['descripcion']);
		$trip['price'] = utf8_encode($res['precio']);
		$trip['places'] = $res['plazas'];

// ----------------------------------------------------------------------------------------
		$route = "";
		$lugar_sql= "SELECT lugar FROM app_amaszonas_lugar WHERE id=".$res['ini'];
		$resultr = mysql_query($lugar_sql,$con) or die('Error: Conexion  Fallida LUGAR INI: '.mysql_error());
		while ( $resr = mysql_fetch_array( $resultr ) ){
			$route .= utf8_encode($resr['lugar']);
		}
// -----------------------------------------------------------------------------------------
		$route .= " - ";
		$lugar_sql= "SELECT lugar FROM app_amaszonas_lugar WHERE id=".$res['fin'];
		$resultr = mysql_query($lugar_sql,$con) or die('Error: Conexion  Fallida LUGAR FIN: '.mysql_error());
		while ( $resr = mysql_fetch_array( $resultr ) ){
			$route .= utf8_encode($resr['lugar']);
		}
// -----------------------------------------------------------------------------------------
		$hora_sql= "SELECT hora FROM app_amaszonas_hora WHERE id=".$res['hora'];
		$resulth = mysql_query($hora_sql,$con) or die('Error: Conexion  Fallida RUTA: '.mysql_error());
		while ( $resh = mysql_fetch_array( $resulth ) ){
			$trip['hour'] = substr($resh['hora'],0,5);
		}
// -----------------------------------------------------------------------------------------
		$trip['route'] = $route;
		$trip['date'] = $res['ffin'];
		$trip['datesp'] = datestr($res['ffin']);
		$trip['datetime'] = $trip['date']." ".$trip['hour'];
	}

	echo json_encode($trip);	
?>
