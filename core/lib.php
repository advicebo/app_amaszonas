<?php


function compareDates($p, $s){

  $fecha1 = explode ("-", $p);   
  $fecha2 = explode ("-", $s); 

  $yf1 = $fecha1[0]; $yf2   = $fecha2[0];
  $mf1 = $fecha1[1]; $mf2 = $fecha2[1];
  $df1 = $fecha1[2]; $df2  = $fecha2[2];

  $days1 = gregoriantojd($mf1, $df1, $yf1);  
  $days2 = gregoriantojd($mf2, $df2, $yf2);     

  if(!checkdate($mf1, $df1, $yf1)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mf2, $df2, $yf2)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{
    return  $days1 - $days2;
  } 

}
// Funcion para convertir una fecha en Literal
function datestr($datex){
	$fecha = explode( "-", $datex );

	$y = $fecha[0];
	$m = $fecha[1];
	$d = $fecha[2];

	$mes = "";
	switch ($m) {
		case '01':	$mes = "Enero";	break;
		case '02':	$mes = "Febreo"; break;
		case '03':	$mes = "Marzo";	break;
		case '04':	$mes = "Abril";	break;
		case '05':	$mes = "Mayo"; break;
		case '06':	$mes = "Junio"; break;
		case '07':	$mes = "Julio";	break;
		case '08':	$mes = "Agosto"; break;
		case '09':	$mes = "Septiembre"; break;
		case '10':	$mes = "Octubre"; break;
		case '11':	$mes = "Noviembre";	break;
		case '12':	$mes = "Diciembre";	break;
	}

	return $d." de ".$mes." del ".$y;
}

function datestrmin($datex){
	$fecha = explode( "-", $datex );

	$y = $fecha[0];
	$m = $fecha[1];
	$d = $fecha[2];

	$mes = "";
	switch ($m) {
		case '01':	$mes = "Enero";	break;
		case '02':	$mes = "Febreo"; break;
		case '03':	$mes = "Marzo";	break;
		case '04':	$mes = "Abril";	break;
		case '05':	$mes = "Mayo"; break;
		case '06':	$mes = "Junio"; break;
		case '07':	$mes = "Julio";	break;
		case '08':	$mes = "Agosto"; break;
		case '09':	$mes = "Septiembre"; break;
		case '10':	$mes = "Octubre"; break;
		case '11':	$mes = "Noviembre";	break;
		case '12':	$mes = "Diciembre";	break;
	}

	return $d." de ".$mes;
}

// Funciones para obtener el primer y ultimo dia de la semana actual
function firstDay(){
	$primer_dia = mktime();
	while(date("w",$primer_dia)!=1){
		$primer_dia -= 3600;
	}
	return date('Y-m-d', $primer_dia);
}

function lastDay(){
	$ultimo_dia = mktime();
	while(date("w",$ultimo_dia)!=0){
		$ultimo_dia += 3600;
	}	
	return date('Y-m-d', $ultimo_dia);
}
function week($day){
	$primer_dia = mktime();
	while(date("w",$primer_dia)!=1){
		$primer_dia -= 3600;
	}

	$dia_semana = $primer_dia;

	while(date("w",$dia_semana)!=$day){
		$dia_semana += 3600;
	}

	if ($day == 0 ) {
		return lastDay();
	}else{
		return date('Y-m-d', $dia_semana);		
	}
}

function SevenDays($day){
	$days = array(	'one' => '1',
					'two' => '2',
					'three' => '3',
					'four' => '4',
					'five' => '5',
					'six' => '6',
					'seven' => '7'
				);

	$days['one'] = $day;
	$days['two'] = date('Y-m-d', strtotime($day.' +1 day')) ;
	$days['three'] = date('Y-m-d', strtotime($day.' +2 day')) ;
	$days['four'] = date('Y-m-d', strtotime($day.' +3 day')) ;
	$days['five'] = date('Y-m-d', strtotime($day.' +4 day')) ;
	$days['six'] = date('Y-m-d', strtotime($day.' +5 day')) ;
	$days['seven'] = date('Y-m-d', strtotime($day.' +6 day')) ;

	return $days;
}

function getDay($day){
	$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
	return ( $dias[date('N', strtotime($day))-1] );
}

?>