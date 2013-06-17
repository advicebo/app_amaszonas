<?php


include('config.php');

	$ini = $_POST['ini'];
	$fin = $_POST['fin'];
	$description = $_POST['description'];
	$minus = $_POST['minus'];
	$plz = $_POST['plz'];
	$hora = $_POST['hora'];
	$fecha = $_POST['fecha'];

	$sql=""; 

	$sql = "INSERT INTO app_amaszonas_promocion (ini, fin, descripcion, precio, plazas, hora, ffin, disponibles ) ";
	$sql.= "VALUES ('".$ini."','".$fin."', '".$description."', '".$minus."', '".$plz."', '".$hora."', '".$fecha."', '".$plz."')";


	@mysql_query($sql,$con)
	or die('Error: Consulta  Fallida : ABM  OFERTA 	'.mysql_error());

	echo "Consulta Exitosa --> ".$sql ;


?>