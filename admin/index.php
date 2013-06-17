<?php

	session_start ();
	
	$name="name";
	$mail="mail";

	if( isset($_POST["iniciar"]) ){
		
		$usuario = $_POST["usuario"];
		$password = $_POST["contrasenia"];
		
		if(validarUsuario( $usuario,$password ) == true){			
			// print_r("<span class='span-notification'>".$_SESSION ["name"]."</span>");
			// print_r("<span class='span-notification'>".$_SESSION ["mail"]."</span>");
			header("location: dash.php");
		}
		else{
			print_r("<span class='span-notification'>Verifica tu nombre de Usuario y Contraseña</span>");
		}
	}
	
	function validarUsuario($usuario, $password){

		include("../core/config.php");

		$sql= "SELECT nombre, correo FROM app_amaszonas_user WHERE nick='".$usuario."' AND pwd='".$password."'"; 
		$result = mysql_query($sql,$con) or die('Error: Conexion  Fallida: Validar Usuario XXX : '.mysql_error());

		while ($res=mysql_fetch_array($result)){
			$nombre= utf8_encode($res['nombre']);
			$mail= utf8_encode($res['correo']);
			$_SESSION ['name'] = $res['nombre'];
			$_SESSION ['mail'] = utf8_encode($res['correo']);
		}

		if( $nombre!="" && $mail!=""){return true;}
		else{return false;}
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
		<meta charset="UTF-8" />
        <title>Amaszonas - Admin</title>
        <meta name="description" content="Login CIDE Ecuador" />
        <meta name="author" content="jvacx" />
        <link rel="stylesheet" type="text/css" href="../css/login.css" />
        <script src="../js/modernizr.custom.63321.js"></script>
        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		
    </head>
    <body>
        <div class="container">
			<header>
				<div id="logo">
					<img src="../img/logo.png"/>
						
				</div>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>
			</header>
			<section class="main">
				<form class="form-2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h1><span class="log-in">ADMINISTRACIÓN</span>, <span class="sign-up">AMASZONAS</span></h1>
					<p class="float">
						<label for="login"><i class="icon-user"></i>Usuario</label>
						<input type="text" name="usuario" placeholder="Usuario">
					</p>
					<p class="float">
						<label for="password"><i class="icon-lock"></i>Contraseña</label>
						<input type="password" name="contrasenia" placeholder="Contraseña" class="showpassword">
					</p>
					<p class="clearfix"> 
						<a href="http://www.amaszonas.com" class="log-twitter">Ver Pagina</a>    
						<input type="submit" name="iniciar" value="Administrar">
					</p>
				</form>​​
			</section>
        </div>
		<!-- jQuery if needed -->
        <script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
			    $(".showpassword").each(function(index,input) {
			        var $input = $(input);
			        $("<p class='opt'/>").append(
			            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
			                var change = $(this).is(":checked") ? "text" : "password";
			                var rep = $("<input placeholder='Password' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
			             })
			        ).append($("<label for='showPassword'/>").text("ver password")).insertAfter($input.parent());
			    });
			    $('#showPassword').click(function(){
					if($("#showPassword").is(":checked")) {
						$('.icon-lock').addClass('icon-unlock');
						$('.icon-unlock').removeClass('icon-lock');    
					} else {
						$('.icon-unlock').addClass('icon-lock');
						$('.icon-lock').removeClass('icon-unlock');
					}
			    });
			});
		</script>
    </body>
</html>