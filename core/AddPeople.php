<?php


include('config.php');
	
	$id = $_POST['id'];

	if($id!=""){

		$stack = $_POST['stack'];

		$sql = "SELECT id_participante,id_promocion FROM app_amaszonas_participa WHERE id_promocion='".$stack."' AND id_participante='".$id."'"; 

		$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida PARTICIPANTE: '.mysql_error());
		$nf =mysql_num_rows($result);
		if($nf>0){
			echo "Ud. ya se h suscrito a alguna de las Rutas en oferta";
		}
		else{
			$sql = "INSERT INTO app_amaszonas_participa ( id_participante, id_promocion, atendido, fatencion ) ";
			$sql.= "VALUES ('".$id."', '".$stack."', '0', '".date("Y-m-d")."')";


			@mysql_query($sql,$con)
			or die('Error: Consulta  Fallida : ABM '.mysql_error());	
/*---------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
							PARA MANDAR CORREOS
---------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------*/
			$correo="";$nombre=""; $ci="";$telefono=""; 
			$fan_sql = "SELECT * FROM app_amaszonas_participante WHERE id=".$id;

			$resultf = mysql_query($fan_sql,$con) or die('Error: Conexion  Fallida MAIL DE PARTICIPANTE: '.mysql_error());
			while ( $resf = mysql_fetch_array( $resultf ) ){
				$correo = $resf['correo'];
				$nombre = $resf['nombre'];
				$ci = $resf['ci'];
				$telefono = $resf['telefono'];
			}
			
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

			header("Location: mailer/procesa.php?nombre=$nombre&correo=$correo&ci=$ci&telefono=$telefono&ruta=".$trip['route']."&hora=".$trip['hour']."&precio=".$trip['price']."");

		}

			
			/*---------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------
			---------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------*/


			
	}else{
		$ci = $_POST['ci'];
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$telefono = $_POST['telefono'];
		
		$sql=""; 

		$sql = "INSERT INTO app_amaszonas_participante ( ci, nombre, correo, telefono ) ";
		$sql.= "VALUES ('".$ci."', '".$nombre."', '".$correo."', '".$telefono."')";


		@mysql_query($sql,$con)
		or die('Error: Consulta  Fallida : ABM '.mysql_error());	
	}
	
?>