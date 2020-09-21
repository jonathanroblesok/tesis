<?php 
require_once "../modelos/Porcentaje.php";
	s
$porcentaje=new Porcentaje();

$idporcentaje=isset($_POST["idporcentaje"])? limpiarCadena($_POST["idporcentaje"]):"";
$categoria_id=isset($_POST["categoria_id"])? limpiarCadena($_POST["categoria_id"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idporcentaje)) {
		$rspta=$porcentaje->insertar($categoria_id,$monto);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$categoria->editar($idcategoria,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$porcentaje->desactivar($idporcentaje);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$porcentaje->activar($idporcentaje);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$porcentaje->mostrar($idporcentaje);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$porcentaje->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idporcentaje.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idporcentaje.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idporcentaje.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idporcentaje.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->nombre.' - '.$reg->tpTalla,
            "2"=>$reg->monto,
            "3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

		case 'porcentajeporcategoria':
		$rspta=$porcentaje->porcentajeporcategoria($idporcentaje,$categoria_id);
		echo $rspta ? "Porcentaje Aumentado correctamente" : "No se pudo aumentar el porcentaje";
		break;
}
 ?>