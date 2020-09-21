var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })
    $("#FormularioPrecio").on("submit",function(e){
    	guardarprecio(e);
    });

// //cargamos los items al celect categoria
   $.post("../ajax/producto.php?op=selectCategoria", function(r){
   	$("#categoria_id").html(r);
   	$("#categoria_id").selectpicker('refresh');
   });   

     //cargamos los items al celect categoria
   $.post("../ajax/producto.php?op=filtrarCategoria", function(r){
   	$("#idcategoria").html(r);
   	$("#idcategoria").selectpicker('refresh');
   });


//cargamos los items al celect talla
   $.post("../ajax/producto.php?op=selectTalla", function(r){
   	$("#talla_id").html(r);
   	$("#talla_id").selectpicker('refresh');
   });
   $("#imagenmuestra").hide();

}

//funcion limpiar
function limpiar(){
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val(""); 
	$("#precio_unitario").val("");
	$("#stock").val("");
	$("#stock_minimo").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idproducto").val("");
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

function actualizarPrecio(id){
	console.log(id);
	$("#actualizarprecio").val(id);
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
			url:'../ajax/producto.php?op=listar',
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
     	url: "../ajax/producto.php?op=guardaryeditar",
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


function guardarprecio(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardarPrecio").prop("disabled",true);
     var formData=new FormData($("#FormularioPrecio")[0]);

     $.ajax({
     	url: "../ajax/producto.php?op=actualizarporcategoria",
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


function mostrar(idproducto){
	$.post("../ajax/producto.php?op=mostrar",{idproducto : idproducto},
		function(data,status)
		{	

			data=JSON.parse(data);
			mostrarform(true)

			$("#categoria_id").val(data.categoria_id);
			$("#categoria_id").selectpicker('refresh');
			$("#talla_id").val(data.talla_id);
			$("#talla_id").selectpicker('refresh');
			$("#codigo").val(data.codigo);
			$("#nombre").val(data.nombre); 
			$("#precio_unitario").val(data.precio_unitario);
			$("#stock").val(data.stock);
			$("#stock_minimo").val(data.stock_minimo);
			$("#descripcion").val(data.descripcion);
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src","../files/productos/"+data.imagen);
			$("#imagenactual").val(data.imagen);
			$("#idproducto").val(data.idproducto);
			generarbarcode();
		})
}


//funcion para desactivar
function desactivar(idproducto){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/producto.php?op=desactivar", {idproducto : idproducto}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idproducto){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/producto.php?op=activar" , {idproducto : idproducto}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
function actualizarporcategoria(idproducto){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/producto.php?op=activar" , {idproducto : idproducto}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function generarbarcode(){
	codigo=$("#codigo").val();
	JsBarcode("#barcode",codigo);
	$("#print").show();

}

function imprimir(){
	$("#print").printArea();
}

init();