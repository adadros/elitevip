var host = 'https://eliteexperiencevip.com';
var jq = jQuery;
var mtr = $;
var activity = null;
document.addEventListener("DOMContentLoaded", function(event) {

	var ismultiple = jq('ul.ismultiple')
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

function doAjax(url,params,success){
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
			try{
				success(data);
			}catch(err){
				console.log(err);
			}
		},
		error:function(error){
			console.log(error.responseText);
		}

	});
}



function eventoGetSections(_this){
	createTicketFake(0,null);
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
	createTicketFake(0,null);
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
		select.dataset.onChange = 'createTicketFake(0,null)';
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
	createTicketFake(0,null);
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
				createTicketFake(disponibles,ticket);
			}
			console.log(disponibles,ticket);
		}
	})

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


function pagarForm(){
	iniciaLoading();
	/*doAjax('/evento/payform', {id: evento, seccion: select_seccion.val(), paquete:select_paquete.val(), fecha:select_fecha.val()}, function (data) {
		if (data.getdata) {

		}
	})*/


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