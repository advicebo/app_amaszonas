
<?php
/*--------------------------------------------------------
Codigo para llenar la tabla principal de stacks que el usuario puede elegir
--------------------------------------------------------*/
include('config.php');
include('lib.php');

	$ini = $_POST['ini']; //id del lugar de partida
	$fin = $_POST['fin']; //id del lugar de llegada
	

	$week = SevenDays(date('Y-m-d')); //Array que guarda las fechas de los 6 dias posteriores al dia de hoy

	$sql = "SELECT id,ini,fin,descripcion,precio,plazas,hora,ffin FROM app_amaszonas_promocion WHERE ini=".$ini;
	$sql .= " AND fin='".$fin."' AND ffin BETWEEN '".$week['one']."' AND '".$week['seven']."' ORDER BY hora ASC";


	// $sql .= " ; 
	/*$sql = "SELECT id,id_ruta,descripcion,precio,plazas,hora,ffin FROM app_amaszonas_promocion";
	$sql += "WHERE id=".$id." AND ffin BETWEEN ".firstDay()." AND ".lastDay()." ORDER BY hora ASC"; */

	$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida STACKS PARA EL PANEL: '.mysql_error());

	$stacks = array( 'one' => array(),
					 'two' => array(),
					 'three' => array(),
					 'four' => array(),
					 'five' => array(),
					 'six' => array(),
					 'seven' => array(),
					 'track' => array(),
					 );

	$day = array( 'day' => '1','date' => '1 de Enero del 2013' );

	$stack = array( 'id'=> '1',
					'ini'=> 'ini',
					'fin'=> 'fin',
					'descripcion'=> 'descripcion',
					'precio'=> 'precio',
					'plazas'=> 'plazas',
					'hora'=> 'hora',
					'ffin'=> 'ffin',
				  );

	while ( $res = mysql_fetch_array( $result ) ){
		
		$stack['id'] = $res['id'];
		$stack['ini'] = $res['ini'];
		$stack['fin'] = $res['fin'];
		$stack['descripcion'] = utf8_encode($res['descripcion']);
		$stack['precio'] = utf8_encode($res['precio']);
		$stack['plazas'] = $res['plazas'];
		$stack['hora'] = $res['hora'];
		$stack['ffin'] = $res['ffin'];

		switch ( $res['ffin'] ) {
			case $week['one']: $stacks['one'][] = $stack; break;
			case $week['two']: $stacks['two'][] = $stack; break;
			case $week['three']: $stacks['three'][] = $stack; break;
			case $week['four']: $stacks['four'][] = $stack; break;
			case $week['five']: $stacks['five'][] = $stack; break;
			case $week['six']: $stacks['six'][] = $stack; break;
			case $week['seven']: $stacks['seven'][] = $stack; break;
		}

	}

	foreach ($week as $i => $value) {
		$day['day'] = getDay($week[$i]);
		$day['date'] = datestr($week[$i]);
		$stacks['track'][] = $day;
	}

	echo json_encode($stacks);

?>