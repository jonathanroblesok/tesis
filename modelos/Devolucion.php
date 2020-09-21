<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Devolucion{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($venta_id,$fecha_devolucion,$motivo){
	$sql="INSERT INTO devoluciones (venta_id,fecha_devolucion,motivo,condicion) VALUES ('$venta_id','$fecha_devolucion','$motivo','1')";
	return ejecutarConsulta($sql);
}

public function editar($iddevolucion,$venta_id, $fecha_devolucion,$motivo){
	$sql="UPDATE devoluciones SET venta_id='$venta_id', fecha_devolucion='$fecha_devolucion' , motivo='$motivo'
	WHERE iddevolucion='$iddevolucion'";
	return ejecutarConsulta($sql);
}
public function desactivar($iddevolucion){
	$sql="UPDATE devoluciones SET condicion='0' WHERE iddevolucion='$iddevolucion'";
	return ejecutarConsulta($sql);
}
public function activar($iddevolucion){
	$sql="UPDATE devoluciones SET condicion='1' WHERE iddevolucion='$iddevolucion'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($iddevolucion){
	$sql="SELECT * FROM devoluciones WHERE iddevolucion='$iddevolucion'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT d.iddevolucion,d.venta_id, v.num_comprobante AS numero, v.serie_comprobante AS serie, d.fecha_devolucion, d.motivo, d.condicion
FROM devoluciones d 
INNER JOIN ventas v ON d.venta_id=v.idventa

";
	return ejecutarConsulta($sql);
}


//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM devoluciones WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
