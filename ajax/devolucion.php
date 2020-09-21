<?php 
require_once "../modelos/Devolucion.php";

$devolucion=new Devolucion();

$iddevolucion=isset($_POST["iddevolucion"])? limpiarCadena($_POST["iddevolucion"]):"";
$venta_id=isset($_POST["venta_id"])? limpiarCadena($_POST["venta_id"]):"";
$fecha_devolucion=isset($_POST["fecha_devolucion"])? limpiarCadena($_POST["fecha_devolucion"]):"";
$motivo=isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($iddevolucion)) {
		$rspta=$devolucion->insertar($venta_id,$fecha_devolucion,$motivo);
		echo $rspta ;
	}else{
         $rspta=$devolucion->editar($iddevolucion,$venta_id,$fecha_devolucion,$motivo);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$devolucion->desactivar($iddevolucion);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$devolucion->activar($iddevolucion);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$devolucion->mostrar($iddevolucion);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$devolucion->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddevolucion.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->iddevolucion.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddevolucion.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->iddevolucion.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->numero.' - '.$reg->serie,
            "2"=>$reg->fecha_devolucion,
            "3"=>$reg->motivo,
            "4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;


		case 'selectVenta':
		require_once "../Modelos/Venta.php";
		$venta= new Venta();

		$rspta=$venta->selectVenta();
		echo '<option value="">Seleccionar...</option>';

		while ($reg=$rspta->fetch_object()) {
			echo '<option value=' . $reg->idventa.'>'.$reg->num_comprobante.'  -  '.$reg->serie_comprobante.'</option>';
		}
			break;

}
 ?>