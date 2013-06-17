var graph = new PlacesGraph()

$(document).on('ready',function(){

	

	$('#new-promo').click(function(){
		$('#new-promo').addClass('current');
		$('#list-promo').removeClass('current');
		Ajax('../core/LoadPlaces.php', {} , 'LoadPlaces').activate();
	});

	$('#list-promo').click(function(){

		$('#list-promo').addClass('current');
		$('#new-promo').removeClass('current');

		Ajax('../core/TripsList.php', {} , 'TripsList').activate();

	});



/*-----------------------------------------------------------------------------------------------
								EVENTOS CLICK EN LAS LISTAS GENERADAS
-----------------------------------------------------------------------------------------------*/ 
	$('body').on('click','.promo',function(e){
		
		var id = e.currentTarget.children[1].children[0].textContent;
		Ajax('../core/FansList.php', { id:id } , 'LoadFans').activate();
		
	});	
	

	// $('#new-promo').click();
	$('#list-promo').click();
	
/*-----------------------------------------------------------------------------------------------
								EVENTOS CLICK NUEVA PROMOCION
-----------------------------------------------------------------------------------------------*/
$('body').on('change','select#ini',function(e){
	var id =parseInt($('select#ini').val());
	ui('select#fin').load('aside #option', graph.getDESTINS(id) );
});


// Boton Crear Nueva Promocion
	$('body').on('click','#save',function(e){
		e.preventDefault();
		if( validate() ){
			Ajax('../core/OfferABM.php', Get_JSON()).sending();
			ui("new-form").clean();			
		}else{
			alert('Debes llenar todos los campos');
		}
		
	});

// Boton Limpiar
	$('body').on('click','#clean',function(e){
		e.preventDefault();
		ui("new-form").clean();
	});

// Boton Volver
	$('body').on('click','#back',function(e){
		$('#list-promo').click();
	});

/*-----------------------------------------------------------------------------------------------
										EVENTOS PERSONALIZADOS
-----------------------------------------------------------------------------------------------*/
	


/*-----------------------------------------------------------------------------------------------
										EVENTOS PERSONALIZADOS
-----------------------------------------------------------------------------------------------*/

// La variable DATA es un JSON en todos los eventos

// Codigo para cargar las rutas
$('body').on('LoadPlaces',function(e, data){
	graph.create(data.places,data.traces,data.hours);
	ui('section').load('aside #new', data);
	ui('select#fin').load('aside #option', graph.getDESTINS(0) );
});

// Codigo para cargar PROMOCIONES
$('body').on('TripsList',function(e, data){
	ui('section').load('aside #list', data);
});

// Codigo para cargar FANS
$('body').on('LoadFans',function(e, data){
	ui('section').load('aside #followers', data);
});


	
	



	$('#reset').click(function(){

	});
	$('#back').click(function(){

	});

});

function msgc(text){
	$('#anoun').text(text);
	$('#anoun').css('display','block');
	setTimeout(function(){
			$('#anoun').css('display','none');
	}, 2000);
}

// Generador de JSON para promociones

function Get_JSON(){
	var json_p = {};
	// $('#new-form').
	var ini = $('#new-form #ini').val();
	var fin = $('#new-form #fin').val();
	var hora = $('#new-form #hora').val();
	var fecha = $('#new-form #fecha').val();
	var minus = $('#new-form #minus').val();
	var description = $('#new-form #description').val();
	var plz = $('#new-form #plz').val();
	
	json_p = { ini:ini, fin:fin, hora:hora, fecha:fecha, minus:minus, plz:plz, description:description };

	console.log('El JSON construido');
	console.log(json_p);
	return json_p;
}

function validate(){
	var ini = $('#new-form #ini').val();
	var fin = $('#new-form #fin').val();
	var hora = $('#new-form #hora').val();
	var fecha = $('#new-form #fecha').val();
	var minus = $('#new-form #minus').val();
	var description = $('#new-form #description').val();
	var plz = $('#new-form #plz').val();

	if(ini!="" && fin!="" && hora!="" && fecha!="" && minus!="" && description!="" && plz!=""){
		return true;
	}else{
		return false;
	}
}