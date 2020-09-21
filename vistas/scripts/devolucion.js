var tabla;
	
//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })

   //cargamos los items al celect categoria
   $.post("../ajax/devolucion.php?op=selectVenta", function(r){
   	$("#venta_id").html(r);
   	$("#venta_id").selectpicker('refresh');
   });
}

//funcion limpiar
function limpiar(){
	$("#motivo").val("");
	$("#iddevolucion").val("");


	//obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
	$("#fecha_devolucion").val(today);

	$("#venta_id").val("");
	$("#venta_id").selectpicker('refresh');
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
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/devolucion.php?op=listar',
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
     // $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/devolucion.php?op=guardaryeditar",
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

// function mostrar(idinsumo){
// 	$.post("../ajax/insumo.php?op=mostrar",{idinsumo : idinsumo},
// 		function(data,status)
// 		{
// 			data=JSON.parse(data);
// 			mostrarform(true);

// 			$("#categoria_id").val(data.categoria_id);
// 			$("#categoria_id").selectpicker('refresh');
// 			$("#codigo").val(data.codigo);
// 			$("#nombre").val(data.nombre);
// 			$("#stock").val(data.stock);
// 			$("#descripcion").val(data.descripcion);
// 			$("#imagenmuestra").show();
// 			$("#imagenmuestra").attr("src","../files/insumos/"+data.imagen);
// 			$("#imagenactual").val(data.imagen);
// 			$("#idinsumo").val(data.idinsumo);
// 			generarbarcode();
// 		})
// }


//funcion para desactivar
function desactivar(idcategoria){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/categoria.php?op=desactivar", {idcategoria : idcategoria}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idcategoria){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/categoria.php?op=activar" , {idcategoria : idcategoria}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}



function imprimir(){
	$("#print").printArea();
}

init();