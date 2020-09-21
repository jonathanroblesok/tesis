<?php 
require_once "../modelos/Producto.php";

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$categoria_id=isset($_POST["categoria_id"])? limpiarCadena($_POST["categoria_id"]):"";
$talla_id=isset($_POST["talla_id"])? limpiarCadena($_POST["talla_id"]):"";
$porcentaje=isset($_POST["porcentaje"])? limpiarCadena($_POST["porcentaje"]):"";

$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$precio_unitario=isset($_POST["precio_unitario"])? limpiarCadena($_POST["precio_unitario"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$stock_minimo=isset($_POST["stock_minimo"])? limpiarCadena($_POST["stock_minimo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";


switch ($_GET["op"]) {
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$imagen=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$imagen=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/".$imagen);
		}
	}
	if (empty($idproducto)) {
		$rspta=$producto->insertar($categoria_id,$talla_id,$codigo,$nombre,$precio_unitario,$stock,$stock_minimo,$descripcion,$imagen);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$producto->editar($idproducto,$categoria_id,$talla_id,$codigo,$nombre,$precio_unitario,$stock,$stock_minimo,$descripcion,$imagen);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$producto->activar($idproducto);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$producto->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->talla .' - '. $reg->tpTalla,
            "4"=>$reg->precio_unitario,
            "5"=>$reg->codigo,
            "6"=>mostrarStock($reg->stock),
            "7"=>$reg->stock_minimo,
            "8"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px'>",
            "9"=>$reg->descripcion,
            "10"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria=new Categoria();

			$rspta=$categoria->select();
			
			echo '<option value="">Seleccionar... </option>';
			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
			break;


			case 'filtrarCategoria':
			require_once "../modelos/Producto.php";
			$producto=new Producto();

			$rspta=$producto->filtrarCategoria();
			echo '<option value="">Seleccionar... </option>';
			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcategoria.'>'.$reg->categoria.'</option>';
			}
			break;


			case 'actualizarporcategoria':
		
			$rspta=$producto->actualizarporcategoria($categoria_id,$porcentaje);
			echo $rspta ?"Precios actualizados correctamente" : "No se pudo actualizar los precios";
		break;
			


		


		case 'selectTalla':
			require_once "../modelos/Talla.php";
			$talla=new Talla();

			$rspta=$talla->select();
			echo '<option value="">Seleccionar... </option>';
			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idtalla.'>'.$reg->nombre.'-'.$reg->tipo_persona_talla.'</option>';
			}
			break;




}
function mostrarStock($C){
if($C>10){
	return '<small class="btn-success" style="padding:10px">'.$C.'</small>';
}else if ($C>5) {
	return '<small class="btn-warning" style="padding:10px">'.$C.'</small>';
}else{
	return '<small class="btn-danger" style="padding:10px">'.$C.'</small>'; 
}
}
 


 ?>