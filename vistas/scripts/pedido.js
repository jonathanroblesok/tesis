var tabla;
	
//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

   //cargamos los items al select cliente
   $.post("../ajax/venta.php?op=selectCliente", function(r){
   	$("#cliente_id").html(r);
   	$('#cliente_id').selectpicker('refresh');
   });
	listarInsumos();
}

function cargarIDproducto(){
	var id = $("#producto_id").val();

	console.log(id)
};
//funcion limpiar
function limpiar(){

	$("#cliente_id").val("");
	$('#cliente_id').selectpicker('refresh');
	$("#observaciones").val("");
	$("#total_pedido").val("");
	$(".filas").remove();
	$("#total").html("0");

	//obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
	$("#fecha").val(today);


}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#bntAgregarDetalle").show();


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
			url:'../ajax/pedido.php?op=listar',
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

function listarInsumos(){
	tabla=$('#tblinsumos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax":
		{
			url:'../ajax/pedido.php?op=listarInsumos',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[0,"desc"]//ordenar (columna, orden)
	}).DataTable();
}

//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     //$("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/pedido.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		listar();
     	}
     });

     limpiar();
}

function mostrar(idpedido){
	$.post("../ajax/pedido.php?op=mostrar",{idpedido : idpedido},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#cliente_id").val(data.cliente_id);
			$("#cliente_id").selectpicker('refresh');
			$("#fecha").val(data.fecha);
			$("#observaciones").val(data.observaciones);
			$("#idpedido").val(data.idpedido);
			
			//ocultar y mostrar los botones
			
			$("#bntAgregarDetalle").hide();
			$("#btnGuardar").hide();
			$("#btnCancelar").show();
			$("#btnAgregarArt").hide();
		});
	$.post("../ajax/pedido.php?op=listarDetalle&id="+idpedido,function(r){
		$("#detalles").html(r);
	});
	$.post("../ajax/pedido.php?op=listarDetalleInsumo&id="+idpedido,function(r){
		$("#detallesinsumo").html(r);
	});

}


//funcion para desactivar
function anular(idpedido){
	bootbox.confirm("¿Esta seguro de ANULAR este PEDIDO?", function(result){
		if (result) {
			$.post("../ajax/pedido.php?op=anular", {idpedido : idpedido}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
	
//funcion para desactivar
function desactivar(idpedido){
	bootbox.confirm("¿Esta seguro de Anular este PEDIDO?", function(result){
		if (result) {
			$.post("../ajax/pedido.php?op=desactivar", {idpedido : idpedido}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idpedido){
	bootbox.confirm("¿Esta seguro de CONFIRMAR PEDIDO?" , function(result){
		if (result) {
			$.post("../ajax/pedido.php?op=activar" , {idpedido : idpedido}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}



var cont=0 ;
$("#btnGuardar").hide();



function agregarDetalle(producto_id,talla_id,stock){

			if($("#producto_id").length){

					$("#producto_id").attr('id','producto_id'+cont);
					$("#talla_id").attr('id','talla_id'+cont);
					$("#categoria_id").attr('id','categoria_id'+cont);
					$("#stock").attr('id','stock'+stock);
					console.log('hay producto_id');
				}else {
					console.log('no hay producto_id');
				}


		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
         '<td><select name="idproducto[]" id="producto_id" class="form-control selectpicker" onchange="cargarIDproducto()" data-live-search="true"><option>Seleccionar</option></select></td>'+
        '<td><select name="idtalla[]" id="talla_id" class="form-control selectpicker" data-live-search="true"><option>Seleccionar</option></select></td>'+
        '<td><input type=»text» readonly=»readonly» name="stock[]" id="stock" class="form-control"  value="'+stock+'"></td>'+
        '<td><input type="number" name="cantidad_producto[]" min="1" max="50" class="form-control" value=""></td>'+
        '<td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i></button></td>'
		'</tr>';
		cont++;
		detalles++;
		$('#detalles').append(fila);
		$.post("../ajax/pedido.php?op=selectProducto", function(r){
		   	$("#producto_id").html(r);
		   	$("#producto_id").selectpicker('refresh');
		   });

		//cargamos los items al celect talla
		   $.post("../ajax/producto.php?op=selectTalla", function(r){
		   	$("#talla_id").html(r);
		   	$("#talla_id").selectpicker('refresh');
		   });
		   evaluar();

//traer info del producto
$('producto_id').keyup(function(e) {
	e.preventDefault();


	var producto = $(this).val();
	var action = 'infoProducto';

	if (producto != '') 
	{

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			async: true,	
			data: {action:action, producto:producto},

			success:function(response) 
			{
				console.log(response);

			},
			error:function(response) {
			}

		});
	}
		
});
		   
}


function agregarDetalleInsumo(idinsumo,insumo,stock,precio_compra){
	var cantidad_insumo=1;
	console.log(stock);
		isproducto= $("#producto_id").val();
		nombre = $('#option'+isproducto).text();
		console.log(nombre);
		if (idinsumo!="") {
		var subtotal=cantidad_insumo*precio_compra;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="idproductoinsumo[]" value="'+isproducto+'">'+nombre+'</td>'+
        '<td><input type="hidden" name="idinsumo[]" value="'+idinsumo+'">'+insumo+'</td>'+
        '<td><input type="number" min="1" max="'+stock+'" name="cantidad_insumo[]" id="cantidad_insumo[]" value="'+cantidad_insumo+'"></td>'+
        '<td><input type=»text» readonly=»readonly» name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
        '<td><span id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
        '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
		'</tr>';
		cont++;
		detalles++;
		$('#detallesinsumo').append(fila);

	}else{
		alert("error al ingresar el detalle, revisar los datos del insumo ");
	}
}

function modificarSubtotales(){
	var cant=document.getElementsByName("cantidad_insumo[]");
	var prec=document.getElementsByName("precio_compra[]");
	var sub=document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpS=sub[i];

		inpS.value=inpC.value*inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML=inpS.value;
	}

	calcularTotales();
}

function calcularTotales(){
	var sub = document.getElementsByName("subtotal");
	var total=0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("$ " + total);
	$("#total_pedido").val(total);
	evaluar();
}



function evaluar(){

	if (detalles>0) 
	{
		$("#btnGuardar").show();
	}
	else
	{
		$("#btnGuardar").hide();
		cont=0;
	}
}


function eliminarDetalle(indice){
$("#fila"+indice).remove();
detalles=detalles-1;
evaluar();
}

init();