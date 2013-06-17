
var Loader = function(caja){
	this.caja = caja; //caja para la animacion

	// this.screen.width = x;
	// this.yy = y;
	
	this.active = function(){
			console.log('Se ACTIVO el loader');
			$(caja).css({
				'width': screen.width,
				'height': (screen.height*0.9),
				'display':'block'
			});
		}
	this.inactive = function(){
			console.log('Se DESACTIVO el loader');
			$(caja).css({
				'width': screen.width,
				'height': (screen.height*0.9),
				'display':'none'
			});
		}
	
}


// Ajax('archivo_destino.php', { algun:'JSON de Envio' }).send(); //Para enviar Datos
// Ajax('archivo_destino.php', { algun:'JSON de Envio' }, 'Evento').activate(); //Para recibir Datos y Activar un evento

/*---------------------------------------------------------------------------------------------
 Funcion ajax para hacer  peticiones ajax
---------------------------------------------------------------------------------------------
destinity = archivo que procesara la peticion, 
data = json con información para el procesado,
trigent = evento personalizado que se activara cuando la peticion sea exitosa
---------------------------------------------------------------------------------------------*/
var x = screen.width;
var y = screen.height;

var load = new Loader( '#wrap' );
function Ajax(destinity, data, trigent){
/*
---------------------------------------------------------------------------------------------
	// SEND : es para enviar Datos
---------------------------------------------------------------------------------------------
	// ACTIVATE : es para enviar datos, recibir datos y luego activar un evento personalizado
---------------------------------------------------------------------------------------------*/
	return {
		sending : function(){
			load.active();
			$.ajax({
				url: destinity,
				type: 'POST',
				data: data,
				success: function(data) {
					console.log('Se enviaron los datos a: \n '+ destinity +' Exitosamente...!!')
					console.log(data);
				},
				complete: function(){ load.inactive(); },				
				error: function(jqXHR,status,error){
					console.log(jqXHR);
					console.log(status);
					console.log(error);
				}
			});
		},

		activate : function(){
			load.active();
			$.ajax({
				url: destinity,
				type: 'POST',
				data: data,
				dataType:'json',
				success: function(info) {
				    console.log('Se activo el triger');
					console.log('Se recibieron los datos y se ejecuto el evento '+ trigent +' Exitosamente...!!')
					$('body').trigger( trigent, [ info ]);
				},				
				complete: function(){ load.inactive(); },
				error: function(jqXHR,status,error){
					console.log(jqXHR);
					console.log(status);
					console.log(error);
				}
			});
		}
	}
}
	


// Plugin para resetear formularios

function ui(id){
	return {
		clean : function(){
			document.getElementById(id).reset();
		},
		load : function( tmp, data ){
			var temp = $(tmp).html().trim();
			$(id).html();
			var html = Mustache.to_html( temp, data );
			$(id).html(html);
		},
		append : function( tmp, data ){
			var temp = $(tmp).html().trim();
			$(id).html();
			var html = Mustache.to_html( temp, data );
			$(id).append(html);
		}
	}
}

// String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };


function trim(str) {
	var txt = str.split(" ");
	var retro="";
	for(i = 0; i < txt.length; i++)
	retro += txt[i];
	return retro;

}

function Find(array, element){
	var xode=false;
	for (var i = 0; i < array.length; i++) {
		if(array[i]==element){
			xode=true;
		}
	}
	return xode;
}


// Funcion para escribir mensajes en el panel
function msgro(text){
	$('#msg').text(text);
	$('#msg').animate({'opacity':1},500);
	setTimeout(function(){
		$('#msg').animate({'opacity':0},500);
	},2500);
}

// Funcion para escribir mensajes en el formulario
function msgb(text){
	$('#msgb').text(text);

	$('#msgb').animate({'opacity':1},500);
	setTimeout(function(){
		$('#msgb').animate({'opacity':0},500);
	},2500);
}


function CompareDates(fecha, fecha2){
	// 2013-06-04 08:00	
    var xYear=fecha.substring(0, 4);  
    var xMonth=fecha.substring(5, 7);  
    var xDay=fecha.substring(8, 10); 
    var xHour=fecha.substring(11, 13); 
    var xMinute=fecha.substring(14, 16); 

    // console.log('Fecha1 = [ '+xYear+"-"+xMonth+"-"+xDay+" "+xHour+":"+xMinute+" ]");

    var yYear=fecha2.substring(0, 4);  
    var yMonth=fecha2.substring(5, 7);  
    var yDay=fecha2.substring(8, 10);  
    var yHour=fecha2.substring(11, 13); 
    var yMinute=fecha2.substring(14, 16); 

	// console.log('Fecha2 = [ '+yYear+"-"+yMonth+"-"+yDay+" "+yHour+":"+yMinute+" ]");

    if (xYear> yYear){  
        return(true)  
    }else{  
      if (xYear == yYear){   
        if (xMonth> yMonth){  
            return(true)  
        }else{   
          if (xMonth == yMonth){  
            if (xDay> yDay){ return(true); }
            else{ 
            	if(xDay == yDay ){
            		if(xHour> yHour){ return(true); }
            		else{ return(false); }
            	}
            	else{ return(false); }            	
            }
          }  
          else { return(false); }
        }  
      }  
      else { return(false); }
    }  
} 
