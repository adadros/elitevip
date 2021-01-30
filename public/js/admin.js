Metro.utils.addLocale({
    'es-MX': {
        "calendar": {
            "months": [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre",
                "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
            ],
            "days": [
                "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado",
                "Do", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab",
                "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"
            ],
            "time": {
                "days": "Dias",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos"
            }
        },
        "buttons": {
            "ok": "Ok",
            "cancel": "Cancelar",
            "done": "Hecho",
            "today": "Hoy",
            "now": "Ahora",
            "clear": "Limpiar",
            "help": "Ayuda",
            "yes": "Si",
            "no": "No",
            "random": "Aleatorio"
        }
    }
});
var jq = jQuery;
var host = 'https://eliteexperience.vip';
var activity = null;
//var host = 'http://localhost:8000';
moment.locale('es');


/**opciones de Table*/
Metro.tableSetup({
    emptyTableTitle: "Nada que mostrar.",
    tableRowsCountTitle: "Muestra: ",
    tableSearchTitle: "Buscar:",
    tableInfoTitle: "mostrando de $1 a $2 de $3 resultados",
    paginationPrevTitle: "Anterior",
    paginationNextTitle: "Siguiente",
    allRecordsTitle: "Todos",
    inspectorTitle: "Inspector",
    tableSkipTitle: "Ir a la página",
    checkStoreKey:'TABLE:$1:KEYS',
});

var BotonUpload = [
    {
        html: "<span class='mif-bin'></span>",
        cls: "alert",
        onclick: "deleteImage(this)"
    }
];

var BtnSeccion = [
    {
        html: "<span class='mif-bin'></span>",
        cls: "alert",
        onclick: "$(this).parent().parent().parent().parent().remove()"
    }
]

/**metodo para realizar dialogs solo mensaje y metodo*/

function getMensajeDialogIF(titulo,mensaje,funcion_ok,funcion_cancel){

    Metro.dialog.create({
        title: titulo,
        content: mensaje,
        actions: [
            {
                caption: "Aceptar",
                cls: "js-dialog-close success",
                onclick: function(){
                    funcion_ok();

                }
            },
            {
                caption: "Cancelar",
                cls: "js-dialog-close alert",
                onclick: function(){
                    funcion_cancel();

                }
            }
        ]
    });
}


function doAjax(url,params,funcion){
    iniciaLoading();
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
            closeLoading();
            if (funcion && typeof(funcion) == "function") {
                funcion(data);
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });
}




/**on jQuery load document*/
$( function(){

    //fix seccion controller editable select
    var sselect = jq("#seccion_selected");
    if(sselect.length>0){
        var select_seccion = Metro.getPlugin(document.getElementById('tipo'), 'select');
        select_seccion.val(sselect.val());
    }

    var spaquete = jq("#paquete_selected");
    if(spaquete.length>0){
        var select_paquete = Metro.getPlugin(document.getElementById('divisa'), 'select');
        select_paquete.val(spaquete.val());
    }

    

} );


function openDialogUploadPortada(){

    var html = '<form action="" enctype="multipart/form-data" method="post" id="uploadPortadaFrm">'+
                '   <div class="form-group">'+
                        '<div class="row">'+
                        '   <div class="cell-md-12 cell-sm-12">'+
                        '       <input id="portada" name="portada" type="file" data-role="file" data-button-title="<span class=\'mif-folder\'></span>" >'+
                        '   </div>'+
                        '</div>'+
                '   </div>'+
                '</form>';

    Metro.dialog.create({
        title: "Imagen de portada",
        content: html,
        actions: [
            {
                caption: "Subir",
                cls: "js-dialog-close success",
                onclick: function(){
                    jq('#uploadPortadaFrm').on('submit',function(event){
                        jq('#uploadPortada').hide();
                        jq('#preview_portada').html('<span class="mif-spinner2 ani-pulse"></span>');
                        console.log(host);
                        event.preventDefault();
                        jq.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        jq.ajax({
                            url:host+"/admin/evtupload",
                            method:"POST",
                            data: new FormData(this),
                            dataType:'JSON',
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){

                                if(!data.error){
                                    jq('#preview_portada').html(data.upload_image);
                                }else{
                                    Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                                        onClose:function(){
                                            jq('#uploadPortada').show();
                                            jq('#preview_portada').html('');

                                        }
                                    });
                                }

                            }

                        });
                    });
                    jq('#uploadPortadaFrm').submit();

                }
            },
            {
                caption: "Cancelar",
                cls: "js-dialog-close alert",
                onclick: function(){
                    return false;
                }
            }
        ]
    });
}

function deleteImage(_this){
    var imageObj = jq(_this).parent().parent().find('img');
    var image = imageObj.attr('data-image');
    var container = imageObj.attr('data-container');
    var btn = imageObj.attr('data-btn');
    var nombre = imageObj.attr('data-name');

    var params = {
        imagen:image
    }
    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Metro.dialog.create({
        title: "Aviso",
        content: "¿Estas seguro de eliminar la imagen de "+nombre+"?",
        actions: [
            {
                caption: "Ok",
                cls: "js-dialog-close success",
                onclick: function(){
                    jq.ajax({
                        url:host+"/admin/deleteimage",
                        method:"POST",
                        data: JSON.stringify(params),
                        dataType:'JSON',
                        contentType:'application/json; charset=utf-8',
                        cache:false,
                        processData:false,
                        success:function(data){
                            jq('#'+container).html('');
                            jq("#"+btn).show();
                        }

                    });
                }
            },
            {
                caption: "Cancelar",
                cls: "js-dialog-close alert",
                onclick: function(){
                    return false;
                }
            }
        ]
    });
}





function saveEvento(){

    var portada = jq('#img_portada').length>0 ? jq('#img_portada').val() : null;
    var calendar = Metro.getPlugin(document.getElementById('fechas'), 'calendar');
    var fechas_timestamp = calendar.getSelected();
    var fechas = [];
    jq(fechas_timestamp).each(function(i,v){
        var m = moment(v);
        fechas.push(m.format("Y-MM-DD"))
    });


    var descripcion = tinymce.get('descripcion').getContent();
    //var descripcion = jq('#descripcion').val();
    var tickets = getTicketsSecciones();

    var params = {
        titulo : jq("#titulo").val(),
        portada:portada,
        descripcion: descripcion,
        fechas:fechas,
        tickets:tickets

    }

    doAjax("/admin/evento/guardar",params,function(data){
       document.location.href= host+'/admin/eventos';
    });

}

function deleteEvento(_this){
    var id = jq(_this).attr('data-id');
    var name = jq(_this).attr('data-name');

    var params = {
        id:id,
    }


    doAjax('/admin/evento/eliminar',params,function(data){
       if(data.deleted){
            Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
            onClose:function(){
                var table = Metro.getPlugin("#eventos", "table");
                table.deleteItem(0, id);
                table.draw();
            }
            });
       }else{
            Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
            onClose:function(){
            }
            });
       }
    });




}


/**metodos tipo variable*/

var changeValuesInEvento = function(_this){


    var selected = jq(_this).find('option:selected');
    var divisa = selected.attr('data-divisa');
    var precio = selected.attr('data-precio');
    /**cambio los valores dados en el dialog de agregar secciones*/
    var select_divisa_add = Metro.getPlugin(document.getElementById('divisa_add'), 'select');
    var precio_add = document.getElementById('precio_add');
    if(typeof select_divisa_add != 'undefined'){
        select_divisa_add.value = divisa;
    }
    if(typeof precio_add != 'undefined'){
        precio_add.value=precio;
    }
}


function addSeccionInEvent(){

    var secciones = jq('#secciones_list > li');
    var data_divisa_selected = null;
    var data_precio = null;
    var li_secciones = '';
    if(secciones.length>0){
        secciones.each(function(i,v){
            li_secciones+='<option  value="'+jq(v).attr('data-value')+'">'+jq(v).text()+'</option>';
        })
    }

    var paquetes = jq('#paquetes_list > li');
    var li_paquetes = '';
    if(paquetes.length>0){
        paquetes.each(function(i,v){
            if(i==0){
                data_divisa_selected = jq(v).attr('data-divisa');
                data_precio = jq(v).attr('data-precio');
            }
            li_paquetes+='<option data-precio="'+jq(v).attr('data-precio')+'" data-divisa="'+jq(v).attr('data-divisa')+'" value="'+jq(v).attr('data-value')+'">'+jq(v).text()+'</option>';
        })
    }

    var divisas = jq('#divisas_list > li');
    var li_divisas = '';
    if(divisas.length>0){
        divisas.each(function(i,v){
            li_divisas+='<option '+(data_divisa_selected!=null?'selected="selected"':'')+' value="'+jq(v).attr('data-value')+'">'+jq(v).text()+'</option>';
        })
    }

    

    
    var html = '' +
        '<div class="form-group">' +
        '   <label>Secciones</label>' +
        '   <select id="seccion_add" data-role="select" >' +
        '' +li_secciones+
        '   </select>' +
        '</div>' +
        '<div class="form-group">' +
        '   <label>Paquetes</label>' +
        '   <select id="paquete_add" data-role="select">' +
        '' +li_paquetes+
        '   </select>' +
        '</div>' +
        '<div class="form-group">' +
        '   <label>Divisa</label>' +
        '   <select id="divisa_add" data-role="select">' +
        '' +li_divisas+
        '   </select>' +
        '</div>' +
        '<div class="form-group">' +
        '   <label>Precio</label>' +
        '   <input type="text" size="180" id="precio_add" value="'+data_precio+'" data-role="input">' +
        '</div>'+
        '<div class="form-group">' +
        '   <label>Cantidad</label>' +
        '   <input id="cantidad_add" data-min-value="1" type="number" value="1" class="small" data-role="spinner" data-step="1">' +
        '</div>';


    Metro.dialog.create({
        title: "Configurar sección",
        content: html,
        actions: [
            {
                caption: "Agregar",
                cls: "js-dialog-close success",
                onclick: function(){
                    addPanelSeccion();

                }
            },
            {
                caption: "Cancelar",
                cls: "js-dialog-close alert",
                onclick: function(){
                    return false;
                }
            }
        ],
        onDialogCreate:function(){
            //console.log('se creo el dialog y los elementos existen');
            /**agrego el evento de change in evento dialog*/
            var paq = jq('#paquete_add');
            //console.log('paq',paq);
            if(paq.length>0){
                document.getElementById('paquete_add').addEventListener('change',function(evt){
                    changeValuesInEvento(evt.target);
                });
            }


        }
    });








}

function buildSeccion(idseccion,label_seccion,idpaquete,label_paquete,cantidad_add,precio_add,divisa_add){


    var html = '' +
        '<div class="cell-lg-10 cell-md-12 cell-sm-12 cell-fs-12">' +
        '<div id="seccion_'+idseccion+'" data-role="panel" data-with="80%" data-title-caption="'+label_seccion+'" data-collapsible="true" data-custom-buttons="BtnSeccion">' +
        '   <span class="tag border bd-lightTaupe" data-seccion="'+idseccion+'" data-paquete="'+idpaquete+'" data-cantidad="'+cantidad_add+'" data-precio="'+precio_add+'" data-divisa="'+divisa_add+'" >' +
        '       <span class="title">'+label_paquete+' - $'+precio_add+' '+divisa_add+' </span>' +
        '       <span class="cantidad badge inline bg-black fg-white mt-1 mr-1">'+cantidad_add+'</span>' +
        '       <a role="button" onclick="$(this).parent().remove()" class="button bg-red fg-white small"><span class="mif-bin"></span></a>' +
        '   </span>' +
        '' +
        '</div>' +
        '</div>';

    return html;
}

function buildPaquete(idseccion,idpaquete,label_paquete,cantidad_add,precio_add,divisa_add){
    var html = '' +
        '   <span class="tag border bd-lightTaupe" data-seccion="'+idseccion+'" data-paquete="'+idpaquete+'" data-cantidad="'+cantidad_add+'" data-precio="'+precio_add+'" data-divisa="'+divisa_add+'" >' +
        '       <span class="title">'+label_paquete+' -  $'+precio_add+' '+divisa_add+' </span>' +
        '       <span class="cantidad badge inline bg-black fg-white mt-1 mr-1">'+cantidad_add+'</span>' +
        '       <a role="button" onclick="$(this).parent().remove()" class="button bg-red fg-white small"><span class="mif-bin"></span></a>' +
        '   </span>';

    return html;
}

function getTicketsSecciones(){
    var container_exists = jq('#container_secciones > div').length>0 ? true : false;
     var secciones = [];
     if(container_exists){
        jq('#container_secciones span.tag').each(function(i,v){
            var dato = jq(v);
            var ticket = {
                seccion:dato.attr('data-seccion'),
                paquete:dato.attr('data-paquete'),
                divisa:dato.attr('data-divisa'),
                precio:dato.attr('data-precio'),
                cantidad:dato.attr('data-cantidad'),
            }
            secciones.push(ticket);
        })
     }
     return secciones;
}

function addPanelSeccion(){

    var idseccion = jq('#seccion_add').val();
    var label_seccion = document.getElementById('seccion_add')[document.getElementById('seccion_add').selectedIndex].innerHTML;
    var idpaquete = jq('#paquete_add').val();
    var label_paquete = document.getElementById('paquete_add')[document.getElementById('paquete_add').selectedIndex].innerHTML;
    var precio_selected = jq('#precio_add').val();
    var divisa_selected = jq('#divisa_add').val();
    var container_exists = jq('#container_secciones > div').length>0 ? true : false;
    var cantidad_add = jq('#cantidad_add').val();


    if(container_exists){
        if(jq('#seccion_'+idseccion).length>0){
            var _paquete = jq('#seccion_'+idseccion).find('.tag[data-paquete='+idpaquete+']');
            if(_paquete.length>0){
                var precio_tmp = jq(_paquete).attr('data-precio');
                var divisa_tmp = jq(_paquete).attr('data-divisa');

                if( (divisa_tmp==divisa_selected) && (precio_tmp==precio_selected)  ){
                    var cant = parseInt(jq(_paquete).find('.cantidad').text());
                    var new_cant = parseInt(cantidad_add)+cant;
                    jq(_paquete).find('.cantidad').html(new_cant);
                    jq(_paquete).attr('data-cantidad',new_cant);
                }else{
                    jq('#seccion_'+idseccion).append(buildPaquete(idseccion,idpaquete,label_paquete,cantidad_add,precio_selected,divisa_selected));
                }
            }else{
                jq('#seccion_'+idseccion).append(buildPaquete(idseccion,idpaquete,label_paquete,cantidad_add,precio_selected,divisa_selected));
            }
        }else{
            jq('#container_secciones').append(buildSeccion(idseccion,label_seccion,idpaquete,label_paquete,cantidad_add,precio_selected,divisa_selected));
        }
    }else{
        jq('#container_secciones').append(buildSeccion(idseccion,label_seccion,idpaquete,label_paquete,cantidad_add,precio_selected,divisa_selected));
    }


}



/**funciones para paquetes*/
function savePaquete(){
    iniciaLoading();



    var params = {
        action : 'nuevo',
        nombre : jq("#nombre").val(),
        divisa : jq("#divisa").val(),
        precio: jq("#precio").val(),
        personas: jq("#personas").val()
    }


    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jq.ajax({
        url:host+"/admin/paquete/guardar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();
            if(data.saved){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        document.location.href = host+'/admin/paquetes';
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){
                        jq("#nombre").val('');
                        jq("#divisa").val('');
                        jq("#precio").val('');
                        jq("#personas").val('');
                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });
}

function updatePaquete(id){
    iniciaLoading();
    var params = {
        id:id,
        nombre : jq("#nombre").val(),
        divisa : jq("#divisa").val(),
        precio: jq("#precio").val(),
        personas: jq("#personas").val()
    }

    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jq.ajax({
        url:host+"/admin/paquete/actualizar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();


            if(data.updated){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        document.location.href = host+'/admin/paquetes';
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){

                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });
}

function deletePaquete(_this){
    var id = jq(_this).attr('data-id');

    iniciaLoading();
    var params = {
        id:id,
    }

    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    jq.ajax({
        url:host+"/admin/paquete/eliminar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();
            if(data.deleted){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        var table = Metro.getPlugin("#paquetes", "table");
                        table.deleteItem(0, id);
                        table.draw();
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){

                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });


}

/**secciones ajax methods*/

function setSelected(_this,id){
    var _id = jq(_this).attr('id');
    var select = Metro.getPlugin(document.getElementById(_id), 'select');
    select.val([id]);
}

function saveSeccion(){
    iniciaLoading();
    var params = {
        tipo : jq("#tipo").val(),
        nombre: jq("#nombre").val(),
    }

    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jq.ajax({
        url:host+"/admin/seccion/guardar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();
            if(data.saved){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        document.location.href = host+'/admin/secciones';
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){
                        jq("#nombre").val('');
                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });
}

function updateSeccion(id){
    iniciaLoading();
    var params = {
        id:id,
        nombre : jq("#nombre").val(),
        tipo: jq("#tipo").val(),
    }

    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jq.ajax({
        url:host+"/admin/seccion/actualizar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();
            if(data.updated){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        document.location.href = host+'/admin/secciones';
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){

                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });
}

function deleteSeccion(_this){
    var id = jq(_this).attr('data-id');

    iniciaLoading();
    var params = {
        id:id,
    }

    jq.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    jq.ajax({
        url:host+"/admin/seccion/eliminar",
        method:"POST",
        data: JSON.stringify(params),
        dataType:'JSON',
        contentType:'application/json; charset=utf-8',
        cache:false,
        processData:false,
        success:function(data){
            closeLoading();
            if(data.deleted){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        var table = Metro.getPlugin("#secciones", "table");
                        table.deleteItem(0, id);
                        table.draw();
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){

                    }
                });
            }
        },
        error:function(error){
            console.log(error.responseText);
        }

    });


}

/**usuarios methods*/
function aprobarUsuario(_this){

    var id = jq(_this).attr('data-id');
    var nombre = jq(_this).attr('data-nombre');
    var email = jq(_this).attr('data-email');

    getMensajeDialogIF('¿Deseas aprobar al usuario '+nombre+'?', ''+
        '<div style="align:justify;">Una vez que aceptes, el sistema le enviará al <b>usuario pendiente</b> un correo con sus datos necesarios para acceder a su perfil.<br><br>' +
        'Se le generará una contraseña de forma automática y aleatoria.</div>'
        ,
    function(){

        doAjax('/admin/usuario/aprobar',{id:id, nombre:nombre, email:email},function(data){
            if(data.activated){
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                    onClose:function(){
                        jq(_this).removeAttr('onclick');
                        jq(_this).removeClass('bg-green-hover bg-primary');
                        jq(_this).addClass('bg-taupe fg-white');
                        jq(_this).parent().find('.stitle').html('Aprobado');
                    }
                });
            }else{
                Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                    onClose:function(){

                    }
                });
            }
        })
        
    },function(){
        return false;
    }

    );
}

function updateUsuario(){

    
}

function saveUsuario(){
    var nombre = jq('#nombre').val();
    var apellido = jq('#apellido').val();
    var correo = jq('#correo').val();
    var role = jq('#role').val();
    var chk_aprobar = Metro.getPlugin(document.getElementById('aprobar'),'checkbox');
    //var aprobar = chk_aprobar.;

    console.log(aprobar);

    /*
    doAjax('/admin/usuario/guardar',{nombre:nombre, apellido:apellido, role:role, correo:correo},function(data){
        if(data.saved){
            Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'success',{
                onClose:function(){
                    document.location.href=host+'/admin/usuarios';
                }
            });
        }else{
            Metro.infobox.create('<h3>Aviso</h3><p>'+data.message+'</p>', 'alert',{
                onClose:function(){

                }
            });
        }
    })*/
}

function deleteUsuario(_this){
    console.log('delete usuarios');
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