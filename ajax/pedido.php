<?php 
require_once "../modelos/Pedido.php";
if (strlen(session_id())<1) 
	session_start();
		
$pedido = new Pedido();
	
$idpedido=isset($_POST["idpedido"])? limpiarCadena($_POST["idpedido"]):"";
$cliente_id=isset($_POST["cliente_id"])? limpiarCadena($_POST["cliente_id"]):"";
$usuario_id=$_SESSION["idusuario"];
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$total_pedido=isset($_POST["total_pedido"])? limpiarCadena($_POST["total_pedido"]):"";

	
switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idpedido)) {
		$rspta=$pedido->insertar($cliente_id,$usuario_id,$fecha,$observaciones,$total_pedido,$_POST["idproducto"],$_POST["idtalla"],$_POST["stock"],$_POST["cantidad_producto"],$_POST["idproductoinsumo"],$_POST["idinsumo"],$_POST["cantidad_insumo"],$_POST["precio_compra"]); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos" ;
	}else{
        
	}
		break;
	
case 'desactivar':
		$rspta=$pedido->desactivar($idpedido);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$pedido->activar($idpedido);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'anular':
	 	$rspta=$pedido->anular($idpedido);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$pedido->mostrar($idpedido);
		echo json_encode($rspta);
		break;


	case 'listarDetalle':
		//recibimos el idpedido
		$id=$_GET['id'];

		$rspta=$pedido->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Descripcion</th>
        <th>Talle</th>
        <th>Stock Actual</th> 
        <th>Cantidad</th>
        <th>Agregar Insumo</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->producto.'</td>
			<td>'.$reg->talla.' - '.$reg->tipo_persona_talla.'</td>
			<td>'.$reg->stock.'</td>
			<td>'.$reg->cantidad_producto.'</td>
			<td></td>';
		}
		break;
		case 'listarDetalleInsumo':
		//recibimos el idpedido
		$id=$_GET['id'];

		$rspta=$pedido->listarDetalleInsumo($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Producto</th>
        <th>Insumo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Subtotal</th>
       	</thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->producto.'</td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad_insumo.'</td>
			<td>'.$reg->precio_compra.'</td>
			<td>'.$reg->subtotal.'</td></tr>';
			$total=$total+($reg->precio_compra*$reg->cantidad_insumo);
		}
		echo '<tfoot>
         <th>TOTAL</th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th><h4 id="total">$  '.$total.'</h4><input type="hidden" name="total_pedido" id="total_pedido"></th>
       </tfoot>';
		break;
			

    case 'listar':
		$rspta=$pedido->listar();
		$data=Array();
		while ($reg=$rspta->fetch_object()) {     
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpedido.')"><i class="fa fa-eye"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idpedido.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpedido.')"><i class="fa fa-eye"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idpedido.')"><i class="fa fa-check"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idpedido.')"><i class="fa fa-minus-circle"></i></button>', 

            "1"=>$reg->fecha,
            "2"=>$reg->nombre .'  '. $reg->apellido,
            "3"=>$reg->usuario,
            "4"=>$reg->observaciones,
            "5"=>$reg->total_pedido,
            "6"=>($reg->condicion)?'<span class="label bg-green">Confirmado</span>':'<span class="label bg-red">Pendiente</span>','<span class="label bg-red">Anulado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarc();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idcliente.'>'.$reg->nombre.'</option>';
			}
			break;


		case 'selectProducto':
			require_once "../modelos/Producto.php";
			$producto = new Producto();

			$rspta = $producto->listarp();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option id="option'.$reg->idproducto.'" value='.$reg->idproducto.'>'.$reg->nombre.'</option>';
			}
			break;

		case 'selectTalla':
			require_once "../modelos/Talla.php";
			$talla = new Talla();

			$rspta = $talla->listar();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idtalla.'>'.$reg->nombre.''.$reg->tipo_persona_talla.'</option>';
			}
			break;

		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria = new Categoria();

			$rspta = $categoria->listar();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
			break;




		case 'listarInsumos':
			require_once "../modelos/Insumo.php";
			$insumo=new Insumo();

			$rspta=$insumo->listarActivos();
			$data=Array();

			while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalleInsumo('.$reg->idinsumo.',\''.$reg->nombre.'\',\''.$reg->stock.'\','.$reg->precio_compra.')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>$reg->precio_compra,
            "6"=>"<img src='../files/insumos/".$reg->imagen."' height='50px' width='50px'>"
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

				break;

}
 ?>


 <?php
 /*require "../config/Conexion.php";

if(!empty($_POST)){
	if($_POST['action'] == 'infoProducto')
	{
		$producto_id=$_POST['producto_id'];
		$query = mysql_query($conexion, "SELECT idproducto, stock from productos  where idproducto=$producto_id and condicion =1  ");
	}
}*/

 ?>