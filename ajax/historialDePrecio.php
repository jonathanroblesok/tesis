<?php 
require_once "../modelos/HistorialDePrecio.php";

$historialDePrecio=new HistorialDePrecio();

$idhistorialDePrecio=isset($_POST["idhistorialDePrecio"])? limpiarCadena($_POST["idhistorialDePrecio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$precio_unitario=isset($_POST["precio_unitario"])? limpiarCadena($_POST["precio_unitario"]):"";
$nuevo_precio_unitario=isset($_POST["nuevo_precio_unitario"])? limpiarCadena($_POST["nuevo_precio_unitario"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";


switch ($_GET["op"]) {

    case 'listarHistorialPrecio':
		$rspta=$historialDePrecio->listarHistorialPrecio();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
			"0"=>$reg->nombre,
            "1"=>$reg->descripcion,
            "2"=>$reg->stock,
            "3"=>$reg->precio_unitario,
            "4"=>$reg->nuevo_precio_unitario,
            "5"=>$reg->fecha);
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