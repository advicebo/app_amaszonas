var graph = new PlacesGraph()
var cache = new Cache();
var CurrentTrip = new Trip(); // Este es el viaje actual.

$(document).on('ready',function(){

	//Carga el Evento que crea el Cache de las ofertas
	Ajax('core/LoadCache.php', {} , 'LoadCache').activate();
	//Carga el Evento que crea el grafo de Rutas
	Ajax('core/LoadPlaces.php', {} , 'LoadPlaces').activate();



// ----------------------------------------------------------------------------
//					CLICK EN LA LISTA DE LAS PARTIDAS
// ----------------------------------------------------------------------------
	$('body').on('click','section #ini-list .cd-dropdown ul li', function(e){
		var id = parseInt(e.currentTarget.getAttribute('data-value')+"");

		$('#fin-list').html('');
		$('#fin-list').html( $('aside #place').html() );
		
		// Se renderiza la Lista de Opciones de Llegada
		ui('#fin-list #fin-sel').load('#fin-list #fin-sel', graph.getDESTINS(id) );
		// Se anima la Lista de Opciones de Llegada
		$('section #fin-list #fin-sel').dropdown();

		CurrentTrip.setINI(id);
		CurrentTrip.setFIN(-1);
		PreviousRender(); //Hace los preparativos antes de renderizar el Panel de Horarios.		
	});

// ----------------------------------------------------------------------------
//					CLICK EN LA LISTA DE LAS LLEGADAS
// ----------------------------------------------------------------------------
	$('body').on('click','section #fin-list .cd-dropdown ul li', function(e){
		var id = parseInt(e.currentTarget.getAttribute('data-value')+"");
		CurrentTrip.setFIN(id);
		PreviousRender();
	});



	// Funcion para agregar item a la lista de tramos
	$('body').on('click','.item-check', function(e){
		Ajax('core/GetTrip.php', { id:e.currentTarget.value } , 'AddItemStack').activate();
	});

	// Funcion para quitar items de la lista de tramos
	$('body').on('click','.item .delete', function(e){
		e.currentTarget.parentNode.parentNode.removeChild(e.currentTarget.parentNode);
		var id = e.currentTarget.parentNode.children[1].innerHTML;
		cache.remove(id);
		sumarPrecios();
		refresh();
	});
	
	// CARGA EL PRIMER PASO DE LA RESEVA DE OFERTAS
	ui('section').load('#zero', {});


// Click en el Boton EMPEZAR YA
 	$('body').on('click','#go', function(e){
		
		ui('section').load('#one', graph.getListPlaces() );

		$( 'section #ini-list #ini-sel' ).dropdown();
		$( 'section #fin-list #fin-sel' ).dropdown();
	
		blankRender();
	});

	$('body').on('click','#back2', function(e){
		$('#restart').click();
	});

// Click en el segundo siguiente
	$('body').on('click','#next2', function(e){
		var proced = false;
		switch(cache.getMAX()){
			case 1: case 2:
				if (cache.getMAX() == $('section #routes #item-list')[0].children.length){
					proced = true;
				}else{
					msgro('Debe elegir mas rutas...')
				}
			break;
			
			case 12:
				if ($('section #routes #item-list')[0].children.length >= 3){
					proced = true;
				}else{
					msgro('Debe elegir al menos 3 rutas para el tipo MULTITRAMO...')
				}
			break;
		}
		if(proced){
			var cnt = $('section #routes #item-list').html();
			var total = $('section #routes #total').html();
			// renderizamos el formulario
			ui('section').load('#two', {});	
			// Inertamos las rutas elegidas en el formulario
			$('#plain #destins').append(cnt);
			$('#plain #destins').append(total);
		}
	});


// Click en el tercer siguiente
	$('body').on('click','#form #next3', function(e){
		e.preventDefault();
		var ci = $('#form #ci').val();
		var email = $('#form #email').val();
		Ajax('core/validate_people.php', { ci:ci, correo:email } , 'validatePeople').activate();
	});


// Click en el boton de volver a empezar
	$('body').on('click', '#restart',function(e){
		e.preventDefault();
		location.reload();
	});


// BOTONES DE TIPOS DE VUELO
	$('body').on('click','#mi',function(){
		$('section #nav li').removeClass('current');
		$('#mi').addClass('current');
		msgro('Ud. ha elegido IDA');
		$('#item-list').html('');

		$('#total .total:first-child').text('0');
		cache.setMAX(1); refresh();
	});
	$('body').on('click','#miv',function(){
		$('section #nav li').removeClass('current');
		$('#miv').addClass('current');
		msgro('Escoja la ruta de IDA');
		$('#item-list').html('');

		$('#total .total:first-child').text('0');
		cache.setMAX(2); refresh();
	});
	$('body').on('click','#mm',function(){
		$('section #nav li').removeClass('current');
		$('#mm').addClass('current');
		msgro('Ud. ha elegido MULTITRAMO');
		$('#item-list').html('');

		$('#total .total:first-child').text('0');
		cache.setMAX(12); refresh();
	});

	$('#console').click(function(){
		console.log('------------------------------------------- MEMORIA ----------------------------------------------');
		console.log(cache.getMEMORY());
		console.log('--------------------------------------------------------------------------------------------------');
	});

	
});


/*
---------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
										FUNCIONES INDEPENDIENTES
---------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------*/

// Evento para cargar el grafo de Rutas

$('body').on('LoadPlaces',function(e, data){
	graph.create(data.places,data.traces,data.hours);
});

 // Eventos Personalizados paa generar templates

// CARGA LOS PANLES DE LOS DIAS CON LAS HORAS DE SALIDA DE LAS OFERTAS(ALIAS STACKS)
$('body').on('RenderPanel',function(e, data){
	console.log('---------------------------------------- DATOS DE LOAD PANEL -----------------------------------------');
	console.log(data);
	console.log('------------------------------------------------------------------------------------------------------');

	loadTmp('#lock-one', data.one );
	loadTmp('#lock-two', data.two );
	loadTmp('#lock-three', data.three );
	loadTmp('#lock-four', data.four );
	loadTmp('#lock-five', data.five );
	loadTmp('#lock-six', data.six );
	loadTmp('#lock-seven', data.seven );
	refresh();
});

// CARGA LAS VARIBLES DE CONFIGURACION GLOBALES

$('body').on('LoadCache',function(e, data){
	cache.setHORAS(data.horas);
	cache.setMAX(1);
	var elems = ['one','two','three','four','five','six','seven'];
	for (var i = 0; i < data.week.length; i++) {
		$('#d-'+elems[i]+' cite').html('<cite>'+data.week[i].day+'</cite><small><b>'+data.week[i].date.substring(0,3)+'</b> '+data.week[i].date.substring(3,data.week[i].date.length)+'</small>');
	};
	
	console.log('---------------------------------------- DATOS DEL SETTING -------------------------------------------');
	console.log(data);
	console.log('-----------------------cache----------------------------');
	console.log(cache);
	console.log('------------------------------------------------------------------------------------------------------');
	
});


// AGREGA EL ITEM ELEGIDO A LA LISTA DE ITEMS DE RUTAS ELEGIDAS

$('body').on('AddItemStack',function(e, data){

	var SelTrip = new Trip();

	SelTrip.initialize({
		ini: data.ini,
		fin: data.fin,
		id: data.id,
		description: data.description,
		price: data.price,
		places: data.places,
		hour: data.hour,
		route: data.route,
		date: data.date,
		datesp: data.datesp,
		datetime: data.datetime
	});

	console.log( SelTrip );
	console.log( SelTrip.datax() );


	// var datax=data.stacks[0];


	if(cache.add( SelTrip )){
		ui('#item-list').append('#node', SelTrip.datax() );
		console.log('--------->CACHE MAXIMO '+cache.getMAX()+'<---------');
	}
	else{
		console.log('--------->NO SE PUDO AGREGAR<---------');		
	}

	sumarPrecios();
});


// Funcion para validar si una persona esta registrada y si no lo esta la agrega y agrega tambien sus rutas elegidas

$('body').on('validatePeople',function(e, data){
	console.log('-------------------data followers');
	console.log(data.followers);

	if(data.followers.length>0){
		var id = data.followers[0].id;
		var memory = cache.getMEMORY();
		msgb('Gracias por confiar en nosotros nuevamente, revise su correo y confirme su(s) reserva(s)');

		console.log('-------------------longitud del cache');
		console.log(memory.length);
		console.log('-------------------cache como al');
		console.log(memory);


		for (var i = 0; i < memory.length ; i++) {
			Ajax('core/AddPeople.php', { id:id, stack:memory[i].id } ).sending();
		}
		setTimeout(function(){
			$('#restart').click();
		},7000);
		
	}
	else{
		var ci = $('#ci').val();
		var name = $('#name').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		if (trim(ci)!="" && trim(name)!="" &&  trim(email)!="" &&  trim(phone)!="") {
			Ajax('core/AddPeople.php', { ci:ci, nombre:name, correo:email, telefono:phone }).sending();
			$('#next3').click();
			msgb('Se ha registrado satisfactoriamente');
		}else{
			msgb('Llene sus datos correctamente');			
		}
	}
});

function loadTmp(id, data){
	var tmp="";
	$(id).html('');
	if(data.length>0){
		var index = 1; 
		for (var j = 0; j < data.length ; j++) {
			var turn = true;
			while( turn ){
				if (parseInt(data[j].hora) == index ){
					tmp +='<span class="locked">';
					// tmp +='<span class=wrap></span>';
			    	tmp +='<i class="icon-user asiento"></i>';
			    	tmp +='<i id="pz-'+data[j].id+'"class="stack">'+data[j].plazas+'</i>';
			    	tmp +='<div class="squaredTwo">';
			    	tmp +='<input type="radio" class="item-check" value="'+data[j].id+'" id="'+data[j].id+'" name="option" />';
			        tmp +='<label for="'+data[j].id+'"></label>';
			        tmp +='</div>';
			    	tmp +='</span>';
			    	index++;
			    	turn = false;
				}else{
					tmp +='<span class="locked"></span>';
					index++;
				}				
			}	
		}

		while( index<=cache.getHORAS() ){
			tmp +='<span class="locked"></span>';
			index++;
		}
		
	}
	else{
		for (var i = 1; i <= cache.horas; i++) {
			tmp +='<span class="locked"></span>';
		}
	}

	$(id).html(tmp);

}


function sumarPrecios(){
	// Realizamos la suma de los precios
	var items = $('#item-list')[0].children.length;
	if (items>0){
		var tt = 0;
		console.log($('#item-list'));
		console.log('nro de hijos'+items);
		for (var i = 0; i < items; i++) {
			tt += parseInt($('#item-list')[0].children[i].childNodes[11].innerHTML);
		}
		$('#total .total:first-child').text(tt);
	}
	else{
		$('#total .total:first-child').text('0');	
	}
}




function refresh(){
	var memory = cache.getMEMORY();

	$('.item-check').removeAttr('checked');
	for (var i = 0; i < memory.length; i++) {
		$('#'+memory[i].id).attr('checked','checked');
	}
}

// Funcion para validar que tanto el Ruta de Partida como de Llegada hayan sido escogidas
function PreviousRender(){

	console.log(CurrentTrip)

	if (CurrentTrip.isValid()){
		console.log('Hay que renderizar-------------------------------------------------------------------');
		var ini = CurrentTrip.getINI();
		var fin = CurrentTrip.getFIN();

		console.log(ini);
		console.log(fin);

		Ajax('core/RenderPanel.php', { ini:ini,fin:fin } , 'RenderPanel').activate();	
	}else{
		msgro('Por favor escoja el lugar de Destino...');
		blankRender();		
	}

}

function blankRender(){
	loadTmp('#lock-one', [] );
	loadTmp('#lock-two', [] );
	loadTmp('#lock-three', [] );
	loadTmp('#lock-four', [] );
	loadTmp('#lock-five', [] );
	loadTmp('#lock-six', [] );
	loadTmp('#lock-seven', [] );
}