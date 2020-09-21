var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });
   $.post("../ajax/proveedor.php?op=mostrarTPDNI", function(r){
   	$("#tipo_documento_id").html(r);
   	$("#tipo_documento_id").selectpicker('refresh');
   });
}

//funcion limpiar
function limpiar(){

	$("#nombre").val("");
	$("#nombre").val("");
	$("#tipo_documento_id").val("");
	$("#num_documento").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#direccion").val("");
	$("#razon_social").val("");



	$("#persona_id").val("");
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
			url:'../ajax/proveedor.php?op=listar',
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
     	url: "../ajax/proveedor.php?op=guardaryeditar",
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

function mostrar(idpersona){
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#nombre").val(data.nombre);
			$("#apellido").val(data.apellido);
			$("#tipo_documento_id").val(data.tipo_documento_id);
			$("#tipo_documento_id").selectpicker('refresh');
			$("#num_documento").val(data.num_documento);
			$("#nombre").val(data.nombre);
			$("#descripcion").val(data.descripcion);
			$("#direccion").val("");
			$("#fecha").val(data.fecha);
			$("#persona_id").val(data.persona_id);
		})
}


//funcion para desactivar
function eliminar(idproveedor){
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function(result){
		if (result) {

			$.post("../ajax/proveedor.php?op=eliminar", {idproveedor : idproveedor }, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();