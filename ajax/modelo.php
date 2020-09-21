<?php 
require_once "../modelos/Modelo.php";
if (strlen(session_id())<1) 
	session_start();
	
$modelo=new Modelo();

$idmodelo=isset($_POST["idmodelo"])? limpiarCadena($_POST["idmodelo"]):"";
$talla_id=isset($_POST["talla_id"])? limpiarCadena($_POST["talla_id"]):"";
$categoria_id=isset($_POST["categoria_id"])? limpiarCadena($_POST["categoria_id"]):"";
$usuario_id=$_SESSION["idusuario"];
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";


	
switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idmodelo)) {
		$rspta=$modelo->insertar($talla_id,$categoria_id,$usuario_id,$fecha,$total_compra,$_POST["idinsumo"],$_POST["cantidad"],$_POST["precio_compra"]);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
		break;
	

	case 'anular':
		$rspta=$modelo->anular($idmodelo);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el modelo";
		break;
	
	case 'mostrar':
		$rspta=$modelo->mostrar($idmodelo);
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//recibimos el idmodelo
		$id=$_GET['id'];

		$rspta=$modelo->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Insumo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Subtotal</th>
       	</thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_compra.'</td>
			<td>'.$reg->subtotal.'</td></tr>';
			$total=$total+($reg->precio_compra*$reg->cantidad);
		}
		echo '<tfoot>
         <th>TOTAL</th>
         <th></th>
         <th></th>
         <th></th>
         <th><h4 id="total">$  '.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
         <th></th>
       </tfoot>';
		break;

    case 'listar':
		$rspta=$modelo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->estado=='Aceptado')?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idmodelo.')"><i class="fa fa-eye"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idmodelo.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idmodelo.')"><i class="fa fa-eye"></i></button>',
            "1"=>$reg->fecha,
            "2"=>$reg->nombre .' - '. $reg->tpTalla,
            "3"=>$reg->categoria,
            "4"=>$reg->usuario,
            "5"=>$reg->total_compra,
            "6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectTalla':
			require_once "../modelos/Talla.php";
			$talla = new Talla();

			$rspta = $talla->listar();
			echo '<option value="">Seleccionar... </option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idtalla.'>'.$reg->nombre.' - '.$reg->tipo_persona_talla.'</option>';
			}
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



			case 'listarInsumos':
			require_once "../modelos/Insumo.php";
			$insumo=new Insumo();

				$rspta=$insumo->listarActivos();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idinsumo.',\''.$reg->nombre.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>"<img src='../files/insumos/".$reg->imagen."' height='50px' width='50px'>"
          
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