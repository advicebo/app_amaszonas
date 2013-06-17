
var Cache = function(){

	this.memoria = [];
	this.max = 1;
	this.horas = 0;

	this.setHORAS = function(n){ this.horas = n; }
	this.getHORAS = function(){ return this.horas; }
	
	this.setMAX = function(n){ this.memoria = []; this.max = n; }
	this.getMAX = function(){ return this.max; }


	this.nro = function (){ return this.memoria.length; }


	this.getMEMORY = function(){ return this.memoria; }

	this.add = function(item){
		var status = false;
		switch(this.max){
			case 1: 
				if(this.memoria.length < this.max){ 
					this.memoria.push(item); status = true; 
					msgro('Excelente, ahora haga click en "Siguiente"');
				}else{
					msgro('Lo sentimos solo puede elegir un destino en el modo IDA');
					refresh();
				}				
			break;
			case 2:
				if(this.memoria.length == 2){
					msgro('Lo sentimos solo puede elegir dos destinos en el modo IDA y VUELTA');
				}

				if( this.memoria.length == 1 ){
					if ( item.getINI() == this.memoria[0].getFIN() && item.getFIN() == this.memoria[0].getINI() ) {
						if ( CompareDates( item.datetime, this.memoria[0].getDATETIME() ) ){
							this.memoria.push(item); status = true; 
							msgro('Excelente, ahora haga click en "Siguiente"');
						}else{
							msgro('La ruta de vuelta debe ser posterior a la ruta de ida');
							refresh();
						}
					}else{
						msgro('La ruta de vuelta no corresponde a la ruta de ida');
					}
				}
				
				if(this.memoria.length == 0){ 
					this.memoria.push(item); status = true; 
					msgro('Ahora escoja la ruta de VUELTA');
				}					
								
			break;
			case 12:
				if(this.memoria.length < this.max){
					if (this.memoria.length == 0){
						this.memoria.push(item); status = true;	
						msgro('Elija la siguiente Ruta...');
					}else{
						if ( item.getINI() == this.memoria[this.memoria.length-1].getFIN() ){
							if ( CompareDates(item.datetime, this.memoria[this.memoria.length-1].getDATETIME()) ){
								this.memoria.push(item); status = true; 
								msgro('Excelente, puede agregar mas Rutas...o hacer click en "Siguiente"');
							}else{
								msgro('La ruta elegida debe ser posterior a las rutas anteriores...');
							}
						}else{
							msgro('El Lugar de Partida no coincide con el Lugar de llegada anterior');
						}
					}					
				}else{
					msgro('Lo sentimos Ud. ya no puede agregar más Rutas..');
				}

			break;
		}

		return status;
	}

	this.remove = function(id){
					var index = 0;
					var aux = [];
					for (var i = 0; i < this.memoria.length; i++) {
						if(this.memoria[i].id!=id){
							aux[index]=this.memoria[i];
							index++;
						}
					}
					this.memoria = aux;
				}

	this.find = function(id){
					var result = false; var i = 0;
					while(!result && i < this.memoria.length){
						if(this.memoria[i].id==id){
							result=true;
						}
						i++;
					}
					return result;
				}
   
    this.getPZ = function (id) {
					var result = false; var i = 0;
					var pz = '';
					while(!result && i < this.memoria.length){
						if(this.memoria[i].id==id){
							result=true;
							pz = this.memoria[i].pz;
						}
						i++;
					}
					return pz;
				}

	this.setPZ = function (id, pz) {
					var result = false; var i = 0;
					var pz = '';
					while(!result && i < this.memoria.length){
						if(this.memoria[i].id==id){
							this.memoria[i].pz = pz;
							result=true;
						}
						i++;
					}	
					console.log('Se guardó el cambio en memoria id='+id+' plazas='+pz);
				}

}


// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -------------------------- GRAPH OF PLACES AND TRACES -----------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------




var PlacesGraph = function(){

	this.Graph = [];
	this.Traces;
	this.Places;
	this.Hours;

	this.create = function(places, traces, hours){

		this.Traces = traces;
		this.Places = places;
		this.Hours = hours;

		for (var i = 0; i < this.Places.length; i++) {
			this.Graph.push(new Array);
		 	for (var j = 0; j < this.Places.length; j++) {
  		 		var status = 0; 
		 		if ( this.existTRACE( this.Places[i].id+'-'+this.Places[j].id ) ){
		 			this.Graph[i][j] = 1;
		 		}else{
			 		this.Graph[i][j] = 0;
		 		}
		 	}
		} 
	}

	this.getGRAPH = function(x,y){
		if (x!=undefined){
			if (y!=undefined){
				return(this.Graph[x][y]);
			}else{ return(this.Graph[x]); }
		}else{ return(this.Graph); }
	}
	this.getTRACES = function(){ return(this.Traces) }
	this.getPLACES = function(){ return(this.Places); }

	this.getListPlaces = function(){ return({ 'places':this.Places,'hours':this.Hours }); }

	this.existTRACE = function(trace){//trace es una cadena de texto con un camino
		var res = false; var j = 0;
		while(j< this.Traces.length && !res){
			if(this.Traces[j].trazo==trace){ res = true; }
			j++;
		}
		return res;
	}
	this.getDESTINS = function(id){
		var lugs = [];
		if(this.Graph.length>0 && this.Traces.length>0){
			for (var i = 0; i < this.Graph[id].length; i++) {
				if(this.Graph[id][i]==1){ lugs.push( this.Places[i] );	}
			}
			var json = { 'places':lugs };
			console.log(json);
			return json;
		}else{
			console.log('No se ha creado el Grafo aún');
			return {};
		}
	}
}



// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -------------------------- CLASE PARA VALIDAR VIAJES -----------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

var Trip = function(){

// Atributes
	this.ini = -1;
	this.fin = -1;
	this.id = '';
	this.description = '';
	this.price = '';
	this.places = '';
	this.hour = '';
	this.route = '';
	this.date = '';
	this.datesp = '';
	this.datetime = '';

// Construct
	this.init = function(ini,fin){
		this.ini = ini;
		this.fin = fin;
	}

// Getters and Setters
	this.getINI = function(){ return this.ini; }
	this.setINI = function(val){ this.ini = val; }

	this.getFIN = function(){ return this.fin; }
	this.setFIN = function(val){ this.fin = val; }
	
	this.getID = function(){ return this.id; }
	this.setID = function(val){ this.id = val; }

	this.getDESC = function(){ return this.description; }
	this.setDESC = function(val){ this.description = val; }

	this.getPRICE = function(){ return this.price; }
	this.setPRICE = function(val){ this.price = val; }

	this.getPLACES = function(){ return this.places; }
	this.setPLACES = function(val){ this.places = val; }

	this.getHOUR = function(){ return this.hour; }
	this.setHOUR = function(val){ this.hour = val; }

	this.getROUTE = function(){ return this.route; }
	this.setROUTE = function(val){ this.route = val; }

	this.getDATE = function(){ return this.date; }
	this.setDATE = function(val){ this.date = val; }

	this.getDATESP = function(){ return this.datesp; }
	this.setDATESP = function(val){ this.datesp = val; }

	this.getDATETIME = function(){ return this.datetime; }
	this.setDATETIME = function(val){ this.datetime = val; }

// Global Setter
	this.initialize = function(args){
		this.ini = args.ini;
		this.fin = args.fin;
		this.id = args.id;
		this.description = args.description;
		this.price = args.price;
		this.places = args.places;
		this.hour = args.hour;
		this.route = args.route;
		this.date = args.date;
		this.datesp = args.datesp;
		this.datetime = args.datetime;
	}

	this.isValid = function(){
		if( this.ini!=-1 && this.fin!=-1 ){ return true; }
		else{ return false; }
	}


// JSON Maker
	this.datax = function(){
		return {
			ini : this.ini,
			fin : this.fin,
			id : this.id,
			description : this.description,
			price : this.price,
			places : this.places,
			hour : this.hour,
			route : this.route,
			date : this.date,
			datesp : this.datesp,
			datetime : this.datetime
		}
	}

}
