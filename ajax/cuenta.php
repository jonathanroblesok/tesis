<?php 
require_once "../modelos/Cuenta.php";
if (strlen(session_id())<1) 
	session_start();

$cuenta = new Cuenta();

$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$cliente_id=isset($_POST["cliente_id"])? limpiarCadena($_POST["cliente_id"]):"";
$usuario_id=$_SESSION["idusuario"];
$monto_max_venta_real=isset($_POST["monto_max_venta_real"])? limpiarCadena($_POST["monto_max_venta_real"]):"";
$monto_max_venta_actual=isset($_POST["monto_max_venta_actual"])? limpiarCadena($_POST["monto_max_venta_actual"]):"";
$fecha_alta=isset($_POST["fecha_alta"])? limpiarCadena($_POST["fecha_alta"]):"";



	

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idcuenta)) {
		$rspta=$cuenta->insertar($cliente_id,$usuario_id,$monto_max_venta_real,$monto_max_venta_actual,$fecha_alta); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
		break;
	
	case 'desactivar':
		$rspta=$cuenta->desactivar($idcuenta);
		echo $rspta ? "Cuenta cerrada correctamente" : "No se pudo cerrar la cuenta";
		break;
	case 'activar':
		$rspta=$cuenta->activar($idcuenta);
		echo $rspta ? "Cuenta abierta correctamente" : "No se pudo abrir la cuenta";
		break;

	case 'anular':
		$rspta=$cuenta->anular($idcuenta);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$cuenta->mostrar($idcuenta);
		echo json_encode($rspta);
		break;

		

    case 'listar':
		$rspta=$cuenta->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idcuenta.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcuenta.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->fecha,
            "2"=>$reg->nombre  .'    '.$reg->apellido,
            "3"=>$reg->usuario,
            "4"=>$reg->monto_real,
            "5"=>$reg->monto_actual,
            "6"=>($reg->condicion)?'<span class="label bg-green">Abierto</span>':'<span class="label bg-red">Cerrado</span>'
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
				echo '<option value='.$reg->idcliente.'>'.$reg->nombre.' ' .$reg->apellido.'</option>';
			}
			break;
			
			case 'listarArticulos':
			require_once "../modelos/Producto.php";
			$producto=new Producto();

				$rspta=$producto->listarActivosVenta();
		$data=Array();

		

				break;
}
 ?>