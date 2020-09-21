var tabla;
	
//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });
    $("#saveDireccion").on("submit",function(e){
   	guardaryeditardomicilio(e);
   });
   $.post("../ajax/cliente.php?op=mostrarTPDNI", function(r){
   	$("#tipo_documento_id").html(r);
   	$("#tipo_documento_id").selectpicker('refresh');
   });
   $.post("../ajax/cliente.php?op=mostrarLocalidad", function(r){
   	$("#localidad_id").html(r);
   	$("#localidad_id").selectpicker('refresh');
   });
 $.post("../ajax/cliente.php?op=TipoCliente", function(r){
   	$("#tipo_cliente_id").html(r);
   	$("#tipo_cliente_id").selectpicker('refresh');
   });
   
}

//funcion limpiar
function limpiar(){


			
			$("#nombre").val("");
			$("#apellido").val("");
			$("#tipo_documento_id").val("");
			$("#tipo_documento_id").selectpicker('refresh');
			$("#num_documento").val("");
			$("#telefono").val("");
			$("#email").val("");
			$("#tipo_cliente_id").val("");
			$("#tipo_cliente_id").selectpicker('refresh');
			$("#fecha_alta").val("");
}

//funcion mostrar formulario 
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}
function asignaridCliente(id){
	console.log(id);
	$("#idclientedireccion").val(id);
}

//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/cliente.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/cliente.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();

}

function guardaryeditardomicilio(e){
     e.preventDefault();//no se activara la accion predeterminada 
   
     var formData=new FormData($("#saveDireccion")[0]);

     $.ajax({
     	url: "../ajax/cliente.php?op=guardarDireccion",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });
}




function mostrarc(idcliente){
	$.post("../ajax/cliente.php?op=mostrar",{idcliente : idcliente},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#nombre").val(data.nombre);
			$("#apellido").val(data.apellido);
			$("#tipo_documento_id").val(data.tipo_documento_id);
			$("#tipo_documento_id").selectpicker('refresh');
			$("#num_documento").val(data.nro_doc);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#tipo_cliente_id").val(data.tipo_cliente_id);
			$("#tipo_cliente_id").selectpicker('refresh');
			$("#fecha_alta").val(data.fecha_alta);
			
		})
}


function mostrard(idcliente){
	$.post("../ajax/cliente.php?op=mostrarDomicilio",{idcliente : idcliente},
		function(data,status)
		{
			data=JSON.parse(data);

			$("#persona_id").val(data.persona_id);
			$("#localidad_id").val(data.localidad_id);
			$("#localidad_id").selectpicker('refresh');
			$("#ciudad").val(data.ciudad);
			$("#barrio").val(data.barrio);
			$("#calle").val(data.calle);
			$("#altura").val(data.altura);
			$("#numero_casa").val(data.numero_casa);
			$("#manzana").val(data.manzana);
			
		})
}


//funcion para desactivar
function eliminar(idcliente){
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function(result){
		if (result) {

			$.post("../ajax/cliente.php?op=eliminar", {idcliente : idcliente }, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();