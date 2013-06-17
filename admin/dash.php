<?php
	
	session_start ();

	if (!isset($_SESSION["name"]) || !isset($_SESSION["mail"])){ 
   		header("Location: index.php");	
	}else{ 
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Administrador de Ofertas- Amaszonas</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="stylesheet" href="../css/main.css">

        

        <link rel="stylesheet" href="../css/appa.css">    
        <link rel="stylesheet" href="../css/admin.css"> 
        <script src="../js/vendor/jquery-1.9.1.min.js"></script>
        <!--
        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
        -->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <header>
            <div id="logo">
                
            </div>
            
            <h2>
                <span class="sup">Stack Amaszonas</span>
                <span class="inf">Administración</span>
            </h2>

            <nav>
            	<ul>
            		<li class="bg-green" id="new-promo"><i class="icon-plus bg-green"></i>Crear Stack</li>
            		<li class="bg-orange" id="list-promo"><i class="icon-eye bg-orange"></i>Listar Stacks</li>
            	</ul>
            </nav>
            <a href="logout.php" class="logout">Cerrar Sesion</a>
        </header>
        <section>
            
        </section>
        <footer>
            <div id="anoun"></div>
            <div id="terms"></div>
        </footer>
		

		<aside>
			<div id="new">
				<form id="new-form">
					<h3>Nueva Oferta</h3>

					<div class="info all">
						<label for="ini">Desde : </label>
						<select name="ini" id="ini" required >
							{{#places}}
							<option value="{{id}}">{{lugar}}</option>
							{{/places}}
						</select>
					</div>
					<div class="info all">
						<label for="fin">Hasta :</label>
						<select name="fin" id="fin" required>
							<!-- Code Conditional Template -->
						</select>
					</div>

					<div class="info mid">
						<label for="fecha">Día</label>
						<input type="date" name="fecha" id="fecha" required /> 
					</div>

					<div class="info mid">
						<label for="hora">Horario</label>
						<select name="hora" id="hora">
							{{#hours}}
							<option value="{{id}}">{{hora}}</option>
							{{/hours}}
						</select>		
					</div>

					<div class="info all">
						<label for="description">Descripción</label>
						<input type="text" name="description" id="description" required />						
					</div>
					<div class="info mid">
						<label for="minus">Precio</label>
						<input type="number" name="minus" id="minus" required />						
					</div>
					<div class="info mid">
						<label for="plz">Plazas</label>
						<input type="number" name="plz" id="plz" required />						
					</div>

					<div class="info all bar">
						<button id="save" class="btn btn-success"><i class="icon-plus"></i>Crear</button>
						<button id="clean" class="btn btn-info"><i class="icon-minus"></i>Limpiar</button>
						<button id="back" class="btn btn-inverse"><i class="icon-cancel"></i>Volver</button>
						<span id="anoun"></span>
					</div>
				</form>
			</div>
<!-- ============================================================================================================ 
									LISTA DE PROMOCIONES 
	============================================================================================================
-->
			<div id="list">
				<div id="all-promo" class="list-items">
					<h3>Todas las promociones</h3>
					{{#all}}
					<div class="item promo">
						<img src="../img/promo.png" alt=""/>
						<div class="contex">
							<span class="id">{{id}}</span>
							<span class="ruta">{{route}}</span>
							<span class="date">{{datesp}}</span>
							<span class="description">{{hour}}</span>
							<span class="desc">{{places}}</span>
						</div>
					</div>
					{{/all}}
				</div>
				<div id="currents-promo" class="list-items">
					<h3>Promociones vigentes</h3>
					{{#current}}
					<div class="item promo">
						<img src="../img/promo.png" alt=""/>
						<div class="contex">
							<span class="id">{{id}}</span>
							<span class="ruta">{{route}}</span>
							<span class="date">{{datesp}}</span>
							<span class="description">{{hour}}</span>
							<span class="desc">{{places}}</span>
						</div>
					</div>
					{{/current}}
				</div>
			</div>
<!-- ============================================================================================================ 
											SEGUIDORES DE LAS PROMOCIONES
	============================================================================================================
-->
			<div id="followers">
				{{#trip}}
				<div id="promo" >
					<h3>Promoción</h3>
					<img src="../img/promo.png" alt=""/>
					<div class="contex">
						<span class="ruta">{{route}}</span>
						<span class="date">{{datesp}}</span>
						<span class="description">{{description}}</span>
						<span class="hour">{{hour}}</span>
						<span class="id">{{id}}</span>
						<span class="desc">{{places}}</span>
						<span class="price">{{price}}</span>
					</div>
				</div>
				{{/trip}}
				<div id="cola" class="list-items">
					<h3>Usuarios en Cola</h3>
					{{#cola}}
					<div class="fan item">
						<i class="icon-user-3 iconik"></i>
						<span class="id">{{id}}</span>
						<span class="name">{{nombre}}</span>
						<span class="ci"><i class="icon-newspaper"></i>{{ci}}</span>
						<span class="phone"><i class="icon-phone"></i>{{telefono}}</span>
						<span class="mail"><i class="icon-mail mailer"></i><i class="icon-checkbox-unchecked cheking"></i></span>					
					</div>
					{{/cola}}
				</div>
				<div id="beneficiados" class="list-items">
					<h3>Usuarios Beneficiados</h3>
					{{#beneficiados}}
					<div class="fan item">
						<i class="icon-user-3 iconik"></i>
						<span class="id">{{id}}</span>
						<span class="name">{{nombre}}</span>
						<span class="ci"><i class="icon-newspaper"></i>{{ci}}</span>
						<span class="phone"><i class="icon-phone"></i>{{telefono}}</span>
						<span class="mail"><i class="icon-mail mailer"></i><i class="icon-checkbox	 cheking"></i></span>					
					</div>
					{{/beneficiados}}
				</div>
				
			</div>
			<div id="option">
				{{#places}}
					<option value="{{id}}">{{lugar}}</option>
				{{/places}}
			</div>
		</aside>


        <!-- 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        -->
        
        <script src="../js/vendor/jquery.dropdown.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/mustache.js"></script>
        <script src="../js/clases.js"></script>
        <script src="../js/lib.js"></script>
        <script src="../js/admin.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>-->
    </body>
</html>
<?php 
	}	
?>