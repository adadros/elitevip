var host = 'https://eliteexperience.vip';
var jq = jQuery;
var mtr = $;
var activity = null;
var _evento = {
	paquetes:[],
	detalles:[],
	productos:[],
	total:0,
	divisa:''
};
var _paquetes_selected=null;

var conektaSuccessResponseHandler= function(token){
	jq("#conektaTokenId").val(token.id);
	senTken();
};

var conektaErrorResponseHandler =function(response){
	Metro.infobox.create("<p>"+response.message_to_purchaser+"</p>", "bg-darkTaupe border bd-lightTaupe fg-white p-5");
}

function senTken(){
	var card = jq("#card").val();
	var name = jq("#name").val();
	var titulo = jq("#evento_titulo").val();
	var token = jq("#conektaTokenId").val();
	var ticket_detalle = jq('#ticket_detalle');
	var telefono = jq('#telefono').val();

	var params = {
		name:name,
		descripcion:titulo,
		brand: Conekta.card.getBrand(card),
		tipo:'card',
		telefono:telefono,
		tok:token,
		card:card,
		invitados:ticket_detalle[0].invitados,
		detalles:_evento.detalles,
		productos:_evento.productos,
		total: _evento.total,
		divisa:_evento.divisa
	};
	//console.log(params);

	doAjax('/evento/pagar', params, function (data) {
		if(data.getdata) {
			console.log(data);
		}
	});


}



function validateNumber(event) {
	var key = window.event ? event.keyCode : event.which;
	if (event.keyCode === 8 || event.keyCode === 46) {
		return true;
	} else if ( key < 48 || key > 57 ) {
		return false;
	} else {
		return true;
	}
};



document.addEventListener("DOMContentLoaded", function(event) {

	var tokenconekta = document.getElementById('token_conekta');
	if(typeof tokenconekta != "undefined" && tokenconekta != null ) {
		Conekta.setPublicKey(tokenconekta.value);
	}

	$("#card-form").submit(function(e){
		e.preventDefault();
	});

	var ismultiple = jq('ul.ismultiple');
	if(ismultiple.length>0){
		if(typeof ismultiple!= "undefined"){
			ismultiple.each(function(ind,v){

				var vals = []
				jq(v).find('li').each(function(i,j){
					if(jq(j).text()!="value")
						vals.push(jq(j).text())
				})
				if(vals.length>0) {
					var select = Metro.getPlugin(document.getElementById(jq(v).attr('data-id')), 'select');
					select.val(vals);
				}
			})
		}
	}

	var isredirect = jq('#redirect_after');
	if(isredirect.length>0){
		setTimeout(function(){
			var link = isredirect.val();
			document.location.href=host+'/'+link;
		},15000)
	}


});

function submit(){
	iniciaLoading();
	document.querySelector('form').submit()
}

function doAjax(url,params,funcion){
	jq.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	jq.ajax({
		url:host+url,
		method:"POST",
		data: JSON.stringify(params),
		dataType:'JSON',
		contentType:'application/json; charset=utf-8',
		cache:false,
		processData:false,
		success:function(data){
			if (funcion && typeof(funcion) == "function") {
				funcion(data);
			}
		},
		error:function(error){
			console.log(error.responseText);
		}

	});
}



function eventoGetSections(_this){
	resetea_paquetes();
	var section_handdler = document.getElementById('select_seccion');
	if(!document.body.contains(section_handdler)){

		var evento = jq(_this).attr('data-evento');
		var select = document.createElement('select');
		select.id = 'select_seccion';
		select.name = 'select_seccion';
		select.className = 'bg-black fg-white';
		select.dataset.role = 'select';
		select.dataset.filterPlaceholder = 'Buscar';
		select.dataset.clsOption = 'bg-black fg-lightTaupe bg-darkTaupe-hover fg-white-hover';
		select.dataset.clsSelectedItem = 'bg-black fg-lightTaupe fg-taupe-hover border bd-taupe';
		select.dataset.clsSelectedItemRemover = 'bg-black fg-taupe';
		select.dataset.clsDropList = 'bg-black fg-taupe';
		select.dataset.onChange = 'eventoGetPaquetes(this,'+evento+')';

		doAjax('/evento/secciones', {id: evento}, function (data) {
			if (data.getdata) {
				jq(data.secciones).each(function (i, v) {
					var option_child = document.createElement('option');
					option_child.value = v.idseccion;
					option_child.innerHTML = v.seccion;
					select.appendChild(option_child);

				});
				document.getElementById('secciones').appendChild(select);
				jq('#secciones').removeClass('d-none');
			}
		})
	}
}

function eventoGetPaquetes(_this,evento){
	resetea_paquetes();
	var select_seccion = Metro.getPlugin(_this, 'select');
	var paquete_handdler = document.getElementById('select_paquete');


	if(document.body.contains(paquete_handdler)) {
		jq("#paquetes .container-paquete").html('');
		jq('#available-container').addClass('d-none');
	}
		var select = document.createElement('select');
		select.id = 'select_paquete';
		select.name = 'select_paquete';
		select.className = 'bg-black fg-white';
		select.dataset.role = 'select';
		select.dataset.filterPlaceholder = 'Buscar';
		select.dataset.clsOption = 'bg-black fg-lightTaupe bg-darkTaupe-hover fg-white-hover';
		select.dataset.clsSelectedItem = 'bg-black fg-lightTaupe fg-taupe-hover border bd-taupe';
		select.dataset.clsSelectedItemRemover = 'bg-black fg-taupe';
		select.dataset.clsDropList = 'bg-black fg-taupe';
		select.dataset.onChange = 'resetea_paquetes()';
		doAjax('/evento/paquetes', {id: evento, seccion: select_seccion.val()}, function (data) {
			if (data.getdata) {
				jq(data.paquetes).each(function (i, v) {
					var option_child = document.createElement('option');
					option_child.value = v.idpaquete;
					option_child.innerHTML = v.paquete;
					select.appendChild(option_child);
				});
				jq('#paquetes .container-paquete').append(select);
				jq('#paquetes').removeClass('d-none');
				jq('#available-container').removeClass('d-none');
			}
		})
}


function getAvailable(_this,evento){
	resetea_paquetes();
	jq(_this).attr('onclick','');
	jq(_this).attr('data-disabled','true');


	var select_seccion = Metro.getPlugin(document.getElementById('select_seccion'), 'select');
	var select_paquete = Metro.getPlugin(document.getElementById('select_paquete'), 'select');
	var select_fecha = Metro.getPlugin(document.getElementById('fechas'),'select');
	jq('#disponible').html('<span class="mif-spinner ani-pulse mif-5x"></span>').removeClass('d-none');
	doAjax('/evento/available', {id: evento, seccion: select_seccion.val(), paquete:select_paquete.val(), fecha:select_fecha.val()}, function (data) {
		if (data.getdata) {
			var disponibles = data.available;
			var ticket = data.ticket;
			jq(_this).attr('onclick','getAvailable(this,'+evento+')');
			jq(_this).attr('data-disabled','false');
			var disponible = '<div class="d-inline border border-dashed bd-lightTaupe p-2"><span class="ml-l fg-green">¡disponibles!</span> <span class="mif-tags fg-green ani-vertical"></span> <span class="badge bg-green fg-white">'+data.available+'</span></div>';
			if(parseInt(disponibles)==0){
				disponible = '<div class="d-inline border border-dashed bd-lightTaupe p-2"><span class="ml-l fg-red">¡No hay boletos!</span> <span class="mif-tags fg-red ani-vertical"></span> <span class="badge bg-red fg-white">'+data.available+'</span></div>';
			}else{
				jq('#disponible').html(disponible);
				jq('#idevento').val(evento);
				jq('#_for_fecha').html(select_fecha.val());
				jq('#_for_seccion').html(ticket.seccion);
				jq('#_for_paquete').html(ticket.paquete);
				jq('#_for_precio').html('$'+ticket.precio+' '+ticket.divisa);
				jq('#_for_disponibles').html(disponibles);
				muestra(jq('#tabla_disponibilidad'));
				_paquetes_selected = {
					fecha:select_fecha.val(),
					id:data.id,
					template:data.template,
					disponible:disponibles,
					ticket:ticket,
					cant:1,
				};
			}

		}
	})

}

function existePaqueteTicket(){
	var id = _paquetes_selected.id;
	var band=false;
	if(_evento.paquetes.length>0) {
		_evento.paquetes.forEach(function (val, ind) {
			if (val.id == id) {
				band = true;
			}
		});
	}
	return band;
}

function addTicket(){
	if(_paquetes_selected.disponible>0) {
		var container_paquetes=jq('#paquetes_tickets');
		var next_btn = jq('#btn_invitados');
		if (!existePaqueteTicket()) {
			_evento.paquetes.push(_paquetes_selected);
			var _ticket = jq('<div/>',{
				class:'t-fake cell-lg-4 cell-md-6 cell-sm-6 cel-fs-6',
				id:'t_'+_paquetes_selected.id,
				html:_paquetes_selected.template
			});
			container_paquetes.append(_ticket);
			container_paquetes.removeClass('d-none');
			next_btn.removeClass('d-none');
		} else {
			Metro.infobox.create("<p>Ya has seleccionado este paquete.</p>", "bg-darkTaupe border bd-lightTaupe fg-white p-5");
		}
	}else{
		Metro.infobox.create("<p>No existen boletos disponibles para este paquete.</p>", "bg-darkTaupe border bd-lightTaupe fg-white p-5");
	}
	//createDataTicketFake(paquetes.disponible,paquetes.ticket)
}


function createTicketFake(qty,data){
	var tfake = jq('#ticket-fake');
	if(data===null){
		reseteaBoletoAvailable();
	}else{
		createDataTicketFake(qty,data);
		tfake.removeClass('d-none');
	}
}

function createDataTicketFake(qty,data){
	var personas = data.personas;
	var divisa = data.divisa;
	var precio = data.precio;
	var seccion = data.seccion;
	var paquete = data.paquete;
	var select_fecha = Metro.getPlugin(document.getElementById('fechas'), 'select');
	jq('#for_date').html(select_fecha.val());
	jq('#for_seccion').html(seccion);
	jq('#for_paquete').html(paquete);
	jq('#for_price').html('$ '+precio+' '+divisa);
	jq('#for_persona').html(personas+' <i class="fas fa-user-tag"></i>');
	var element_cant = Metro.getPlugin(document.getElementById('cantidad'),'spinner');
	element_cant.val(1);
	element_cant.options.maxValue = parseInt(qty);
	element_cant.options.minValue = 1;

}

function reseteaBoletoAvailable(){
	jq('#ticket-fake').addClass('d-none');
	jq('#disponible').html('');
	jq('#for_date').html('N/D');
	jq('#for_seccion').html('N/D');
	jq('#for_paquete').html('N/D');
	jq('#for_price').html('N/D');
	jq('#for_persona').html('N/D');
	jq('#cantidad').val(0);
}

function back_apartar(){
	jq('#apartar').removeClass('d-none');
	jq('#titulo_apartar_container').removeClass('d-none');
	jq('#configurar').addClass('d-none');
	jq('#user_container').html('');
	ejecutaPaso('prev');
}

/**funcion para crear un user para ticket*/
function createUserTicket(ticket){
	var ticket = '<div class="card bg-black border bd-lightTaupe ticket-folio my-2" data-tid="'+ticket.id+'" data-folio="'+ticket.folio+'" data-seccion="'+ticket.seccion+'" data-paquete="+ticket.paquete+" >' +
		'<div class="card-header op-darkTaupe-hi fg-lightTaupe border-none">' +
		'<div>Invitados por boleto <b class="fg-lightTaupe">('+ticket.personas+')</b></div>' +
		'<div>Folio: ' + ticket.folio +' </div>'+
		'</div>' +
		'<div class="card-content op-black-hi py-2">' +
		'' + createInvitado(ticket.personas)+
		'</div>' +
		'</div>';

	var tfolio = jq('<div/>',{
		html:ticket
	});

	return tfolio;
}

function ejecutaPaso(paso){
	var stepper = Metro.getPlugin('#stepper','stepper');
	stepper[paso]();
}

/**validando que los campos de invitados esten llenos*/
function validateInvitados(){
	var users = [];
	var errors = false;
	jq('.ticket-folio').each(function(idx,tick){
		var folio = jq(tick).attr('data-folio');
		var idt = jq(tick).attr('data-tid');
		jq(tick).find('.user-tickets').each(function(uindx, uticket){
			if(jq(uticket).find('input').val()!=""){
				users.push({ invitado:jq(uticket).find('input').val().toUpperCase(), folio:folio, id:idt  })
			}else{
				errors=true;
			}
		});
	});
	return { users:users, err:errors };
}


function pasoPago(){
	invitados = validateInvitados();
	if(!invitados.err) {
		jq('#detallepago').removeClass('d-none');
		jq('#configurar').addClass('d-none');
		var ticket_detalle = jq('#ticket_detalle');
		var monto_table = jq('#monto > tbody');
		if (_evento.detalles.length>0) {
			var tickets = _evento.detalles;
			var sumaTotal = 0;
			/**tickets folios*/
			ticket_detalle[0].invitados = invitados.users;
			var divisa = '';
			/**tickets folios*/
			tickets.forEach(function (ticket_arr,ind) {
				if(ticket_arr.length>0){
					var cantidad_temp = parseInt(ticket_arr.length);
					var ticket = ticket_arr[0];
					var tr = jq('<tr/>', {
						html: '<td>'+ ticket.seccion + ' - ' + ticket.paquete + '</td><td>'+ticket.fecha+'</td><td>'+cantidad_temp+' pza(s)</td><td align="right">$' + ticket.precio + ' ' + ticket.divisa+'</td>'
					});
					var producto = {
						name: 'Boleto fecha '+ticket.fecha,
						description: 'seccion: '+ticket.seccion+' paquete:'+ticket.paquete,
						unit_price: ticket.precio * 100,
						quantity: cantidad_temp
					};
					var producto_detalle = {
						cantidad:cantidad_temp,
						idseccion:ticket.idseccion,
						idpaquete:ticket.idpaquete,
						idevento:ticket.idevento,
						precio:ticket.precio
					};
					_evento.productos.push(producto);
					_evento.detalles.push(producto_detalle);
					monto_table.append(tr);
					sumaTotal += parseFloat(ticket.precio*cantidad_temp);
					divisa = ticket.divisa;
				}
			});
			var stTr = jq('<tr/>', {
				class: 'u-hline',
				html: '<td><b>Total a pagar</b></td><td colspan="2">&nbsp;</td><td align="right" class="f-size-18 text-bold">$' + sumaTotal + ' ' + divisa + '</td>'
			});
			monto_table.append(stTr);
			ticket_detalle[0].monto = '$'+sumaTotal+' '+divisa;
			_evento.total = sumaTotal;
			_evento.divisa = divisa;

		}
		ejecutaPaso('next');
	}else{
		Metro.infobox.create("<p>El campo de invitado es requerido, llene los campos que faltan por cada boleto.</p>", "bg-darkTaupe border bd-lightTaupe fg-white p-5");
	}
}
function irAPago(){
	jq('#detallepago').addClass('d-none');
	var ticket_detalle = jq('#ticket_detalle');
	var monto = jq('#for_monto');
	monto.html('<b class="fg-black bg-lightTaupe f-size-20 p-4 rounded">'+ticket_detalle[0].monto+'</b>');
	ejecutaPaso('next');
	jq('#pagar').removeClass('d-none');
}

function procesaPago(){
	var carform = jq("#card-form");
	Conekta.Token.create(carform,conektaSuccessResponseHandler,conektaErrorResponseHandler);
}

function getBrandCard(){
	var card = document.getElementById('card');
	var brand = Conekta.card.getBrand(card.value);
	var cardbrand = document.getElementById('card_brand');
	switch (brand){
		case 'visa':
			cardbrand.className="mif-visa mif-4x";
			break;
		case 'mastercard':
			cardbrand.className='mif-mastercard mif-4x';
			break;
		case 'amex':
			cardbrand.className='mif-amex mif-4x';
			break;
		default:
			cardbrand.className='mif-credit-card mif-4x';
			break;
	}
}



function createInvitado(cant){
	var input = '';
	if(parseInt(cant)>0){
		for(var i=0; i<cant; i++){
			input+='<div class="row user-tickets">' +
				'<div class="cell-md-8 mx-4">' +
				'	<label>Invitado '+(i+1)+'</label> ' +
				'	<input type="text" class="metro-input" data-role="input" data-validate="required" >' +
				'</div>' +
				'</div>';
		}
	}
	return input;
}


function usersForm(){

	var evento = jq('#idevento').val();
	if(_evento.paquetes.length>0){
		_evento.paquetes.forEach(function(val,ind){
			var id = val.id;
			var ecant = Metro.getPlugin(document.getElementById(id+'_cantidad'),'spinner');
			val.cant = ecant.val();
			val.idevento = evento;
		});
	}

	_evento.paquetes.forEach(async function(val,ind){

		var params = {
			id:val.idevento,
			cantidad:val.cant,
			fecha:val.fecha,
			seccion:val.ticket.idseccion,
			paquete:val.ticket.idpaquete
		};
		var _promesa = await doPromise('/evento/payform',params);
		var detalles = [];

		/**armo los usuarios*/
		if(_promesa.getdata){
			//console.log(_promesa);
			//closeLoading();
			if(_promesa.ticket.length>0){
				//Precarga de datos del ticket
				jq('#apartar').addClass('d-none');
				jq('#titulo_apartar_container').addClass('d-none');
				ejecutaPaso('next');
				jq('#configurar').removeClass('d-none');
				var ticket_detalle = jq('#ticket_detalle');
				var detalle_arr = [];
				var user_container;
				//console.log(_promesa.ticket[0]);
				var _fecha = jq('<div/>',{
					class:'row',
					html:'<div class="cell-md-12 pb-1 text-right fg-white" style="border-bottom:1px solid rgba(155,155,155,.2);">'+_promesa.ticket[0].seccion+' - '+_promesa.ticket[0].paquete+' - <b class="fg-green">'+_promesa.fecha+'</b></div>'
				});
				jq('#user_container').append(_fecha);
				_promesa.ticket.forEach(function(val,ind){
					console.log(val);
					jq('#user_container').append(createUserTicket(val));
					detalle_arr.push(val);
				});
				_evento.detalles.push(detalle_arr);

				//ticket_detalle[0].detalle;
				//jq('#user_container').append(user_container);

				//jq('#user_container input:first').val(_promesa.profile);
				//Precarga de datos del ticket
			}
		}

		/**armo los usuarios*/

	});



}

function iniciaLoading(){
	activity = Metro.activity.open({
		type: 'cycle',
		//style:'dark',
		overlayColor: '#AEA073',
		text: '<div class=\'mt-2 text-small\'>Espere por favor...</div>',
		overlayAlpha: .5
	});
}

function closeLoading(){
	Metro.activity.close(activity);
}

function oculta(elemento){
	elemento.addClass('d-none');
}

function muestra(elemento){
	elemento.removeClass('d-none');
}

function resetea_paquetes(){
	oculta(jq('#tabla_disponibilidad'));
	jq('#disponible').html('');
}

function removeTicket(id){
	anime({
		targets: '#t_'+id,
		scale: [1,.6],
		opacity: [1,0],
		duration:450,
		easing: 'easeInOutExpo',
		complete: function() {
			jq('#t_'+id).remove();
			removeTicketFromEvent(id);
		}
	}
	);
}

function removeTicketFromEvent(id){
	var temp_array = [];
	if(_evento.paquetes.length>0){
		_evento.paquetes.forEach(function(val,ind){
			if(val.id!=id){
				temp_array.push(val);
			}
		});
		_evento.paquetes = temp_array;
	}
	if(_evento.paquetes.length==0){
		jq('#btn_invitados').addClass('d-none');
	}
	
}

function slideUpApartar(_this,id){
	var btn = jq(_this);
	var span = jq(_this).find('span');
	jq(id).addClass('collapse');
	btn.attr('onclick','slideDownApartar(this,\''+id+'\')');
	span.removeClass('mif-arrow-up');
	span.addClass('mif-arrow-down');
	jq('#text_apartar').removeClass('d-none');
	anime({
			targets: id,
			opacity: [1,0],
			duration:450,
			easing: 'easeInOutExpo'
		}
	);
}

function slideDownApartar(_this,id){
	var btn = jq(_this);
	var span = jq(_this).find('span');
	jq(id).removeClass('collapse');
	jq('#text_apartar').addClass('d-none');
	btn.attr('onclick','slideUpApartar(this,\''+id+'\')');
	span.removeClass('mif-arrow-down');
	span.addClass('mif-arrow-up');
	anime({
			targets: id,
			opacity: [0,1],
			duration:450,
			easing: 'easeInOutExpo'
		}
	);



}
/**promesa de los usuarios formulario por ticket**/



function doRecursiveAjaxEventos(url,evento,cuenta){

	jq.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	if(cuenta<evento.length) {
		var _evento = evento[cuenta];
		var ticket = _evento.ticket;
		var param_data = {
			id:_evento.idevento,
			seccion: ticket.idseccion,
			paquete: ticket.idpaquete,
			fecha: _evento.fecha,
			cantidad: parseInt(_evento.cant)
		};
		console.log(param_data);

		jq.ajax({
			url: host + url,
			method: "POST",
			data: JSON.stringify(param_data),
			dataType: 'JSON',
			contentType: 'application/json; charset=utf-8',
			cache: false,
			processData: false,
			success: function (data) {
				console.log(data);
				cuenta++;
				doRecursiveAjaxEventos(url,evento,cuenta);
			}
			,
			error:function(error){
				console.log(error.responseText);
			}
		});


	}

}


function doPromise(url,param) {

	return new Promise((resolve, reject) => {
			jq.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			jq.ajax({
			url: host + url,
			type: 'POST',
			dataType: 'JSON',
			contentType: 'application/json; charset=utf-8',
			cache: false,
			processData: false,
			data: JSON.stringify(param),
			success: function (data) {
				resolve(data)
			},
			error: function (error) {
				reject(error)
			},
		})
	});

}

