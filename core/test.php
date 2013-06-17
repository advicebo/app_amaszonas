<?php
include('config.php');
include('lib.php');

$currentDay = date('Y-m-d');

echo $currentDay.'<br>' ;

$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

// echo date('N', strtotime($currentDay));
echo '<hr>' ;
$oneDay = $dias[date('N', strtotime($currentDay))-1];

echo $oneDay.'<br>' ;

?>