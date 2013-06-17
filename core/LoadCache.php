<?php
include('config.php');
include('lib.php');

	$week = SevenDays(date('Y-m-d')); //Array que guarda las fechas de los 6 dias posteriores al dia de hoy

	
	$sql = "SELECT * FROM app_amaszonas_promocion"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida PROMOCION: '.mysql_error());
	$nro_stacks = mysql_num_rows($result);

	$sql = "SELECT * FROM app_amaszonas_hora"; 
	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida PROMOCION: '.mysql_error());
	$nro_horas = mysql_num_rows($result);


	$bundle = array( 'stacks' => $nro_stacks,
					 'horas' => $nro_horas,
					 'week' => array()
					);
	$day = array( 'day' => '1','date' => '1 de Enero del 2013' );

	foreach ($week as $i => $value) {
		$day['day'] = getDay($week[$i]);
		$day['date'] = datestrmin($week[$i]);

		$bundle['week'][] = $day;
	}

	echo json_encode($bundle);
?>
