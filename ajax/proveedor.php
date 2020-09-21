<?php 
require_once "../modelos/Proveedor.php";

$proveedor=new Proveedor();

$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$persona_id=isset($_POST["persona_id"])? limpiarCadena($_POST["persona_id"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$tipo_documento_id=isset($_POST["tipo_documento_id"])? limpiarCadena($_POST["tipo_documento_id"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$contacto_id=isset($_POST["contacto_id"])? limpiarCadena($_POST["contacto_id"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";




switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idproveedor)) {
		$rspta=$proveedor->insertar($razon_social,$nombre,$apellido,$tipo_documento_id,$num_documento,$direccion,$telefono,$email);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$proveedor->editar($idproveedor,$razon_social,$nombre,$apellido,$tipo_documento_id,$num_documento,$direccion,$telefono,$email);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$proveedor->desactivar($idproveedor);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$proveedor->activar($idproveedor);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$proveedor->mostrar($idproveedor);
		echo json_encode($rspta);
		break;

   
		  case 'listar':
		$rspta=$proveedor->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproveedor.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idproveedor.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->razon_social,
            "2"=>$reg->nombre,
            "3"=>$reg->tipo_documento,
            "4"=>$reg->numero,
            "5"=>$reg->telefono,
            "6"=>$reg->email,
            "7"=>$reg->direccion
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'mostrarTPDNI':
			$respuesta = $proveedor->selectTPDNI();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $respuesta->fetch_object()) {
				echo '<option value='.$reg->idtipo_documento.'>'.$reg->descripcion.'</option>';
			}
		break;
}
 ?>