<?php 
require_once "../modelos/Cliente.php";
	
$cliente=new Cliente();

$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$persona_id=isset($_POST["persona_id"])? limpiarCadena($_POST["persona_id"]):"";
$fecha_alta=isset($_POST["fecha_alta"])? limpiarCadena($_POST["fecha_alta"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$tipo_documento_id=isset($_POST["tipo_documento_id"])? limpiarCadena($_POST["tipo_documento_id"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$contacto_id=isset($_POST["contacto_id"])? limpiarCadena($_POST["contacto_id"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$tipo_cliente_id=isset($_POST["tipo_cliente_id"])? limpiarCadena($_POST["tipo_cliente_id"]):"";






switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idcliente)) {
		$rspta=$cliente->insertar($fecha_alta,$nombre,$apellido,$tipo_documento_id,$num_documento,$tipo_cliente_id,$direccion,$telefono,$email);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$cliente->editar($idcliente,$fecha_alta,$nombre,$apellido,$tipo_documento_id,$num_documento,$tipo_cliente_id,$direccion,$telefono,$email);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$cliente->desactivar($idcliente);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$cliente->activar($idcliente);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$cliente->mostrarc($idcliente);
		echo json_encode($rspta);
		break;

   
		case 'listar':
		$rspta=$cliente->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrarc('.$reg->idcliente.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcliente.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->fecha_alta,
            "2"=>$reg->nombre .'    '.$reg->apellido,
            "3"=>$reg->tipo_documento,
            "4"=>$reg->numero,
            "5"=>$reg->telefono,	
            "6"=>$reg->email,
            "7"=>$reg->tipo_cliente,
            "8"=>'<button class="btn btn-warning btn-xs" onclick="mostrard('.$reg->idcliente.')"data-toggle="modal" data-target="#modalForm"><i class="fa fa-eye"></i></button>'.'<button class="btn btn-success btn-xs" onclick="asignaridCliente('.$reg->idpersona.')" data-toggle="modal" data-target="#modalForm"><i class="fa fa-plus"></i></button>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'TipoCliente':
			$respuesta = $cliente->TipoCliente();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $respuesta->fetch_object()) {
				echo '<option value='.$reg->idtipo_cliente.'>'.$reg->descripcion.'</option>';
			}
		break;

		case 'mostrarTPDNI':
			$respuesta = $cliente->selectTPDNI();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $respuesta->fetch_object()) {
				echo '<option value='.$reg->idtipo_documento.'>'.$reg->descripcion.'</option>';
			}
		break;


		case 'mostrarLocalidad':
			$respuesta = $cliente->SelectLoc();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $respuesta->fetch_object()) {
				echo '<option value='.$reg->idlocalidad.'>'.$reg->nombre.'</option>';
			}
		break;

		case 'guardarDireccion':
			require_once "../modelos/Domicilio.php";
			$domicilio = new Domicilio();
			$persona_id=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
			$localidad_id=isset($_POST["localidad_id"])? limpiarCadena($_POST["localidad_id"]):"";
			$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
			$barrio=isset($_POST["barrio"])? limpiarCadena($_POST["barrio"]):"";
			$calle=isset($_POST["calle"])? limpiarCadena($_POST["calle"]):"";
			$altura=isset($_POST["altura"])? limpiarCadena($_POST["altura"]):"";
			$numero_casa=isset($_POST["numero_casa"])? limpiarCadena($_POST["numero_casa"]):"";
			$manzana=isset($_POST["manzana"])? limpiarCadena($_POST["manzana"]):"";


			$rspta = $domicilio->insertar($persona_id,$localidad_id,$ciudad,$barrio,$calle,$altura,$numero_casa,$manzana);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";

		break;


		case 'mostrarDomicilio':
		$rspta=$cliente->mostrard($idcliente);
		echo json_encode($rspta);


}
 ?>