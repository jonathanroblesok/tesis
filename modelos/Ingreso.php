	<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Ingreso{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($proveedor_id,$usuario_id,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$insumo_id,$cantidad,$precio_compra){
	$sql="INSERT INTO ingresos (proveedor_id,usuario_id,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado) VALUES ('$proveedor_id','$usuario_id','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
	//return ejecutarConsulta($sql);
	 $idingresonew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($insumo_id)) {

	 	$sql_detalle="INSERT INTO detalle_ingresos (ingreso_id,insumo_id,cantidad,precio_compra) VALUES('$idingresonew','$insumo_id[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]')";

  		ejecutarConsulta($sql_detalle) or $sw=false;//
	 
	 	

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function anular($idingreso){
	$sql="UPDATE ingresos SET estado='Anulado' WHERE idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idingreso){
	$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.proveedor_id,p.nombre as proveedor,u.idusuario,u.nombre as usuario, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingresos i INNER JOIN personas p ON i.proveedor_id=p.idpersona INNER JOIN proveedores pr ON i.proveedor_id=pr.idproveedor INNER JOIN usuarios u ON i.usuario_id=u.idusuario WHERE idingreso='$idingreso'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idingreso){
	$sql="SELECT di.ingreso_id,di.insumo_id,a.nombre,di.cantidad,di.precio_compra, (di.cantidad*di.precio_compra) AS subtotal FROM detalle_ingresos di INNER JOIN insumos a ON di.insumo_id=a.idinsumo WHERE di.ingreso_id='$idingreso'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.proveedor_id,p.nombre as nombre, p.apellido as apellido,u.idusuario,u.nombre as usuario, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingresos i INNER JOIN personas p ON i.proveedor_id=p.idpersona INNER JOIN proveedores pr ON i.proveedor_id=pr.idproveedor INNER JOIN usuarios u ON i.usuario_id=u.idusuario ORDER BY i.fecha_hora DESC";
	return ejecutarConsulta($sql);
}
	
public function ingresocabecera($idingreso){
	$sql= "SELECT i.idingreso, i.proveedor_id, p.nombre, p.apellido, p.tipo_documento_id, p.num_documento AS proveedor, cp.idpersonas_contacto,cp.valor AS contacto, i.usuario_id, u.nombre AS usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, DATE(i.fecha_hora) AS fecha, i.impuesto, i.total_compra FROM ingresos i INNER JOIN personas p ON i.proveedor_id=p.idpersona INNER JOIN personas_contactos cp ON cp.idpersonas_contacto=p.idpersona  INNER JOIN usuarios u ON i.usuario_id=u.idusuario WHERE i.idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

public function ingresodetalles($idingreso){
	$sql="SELECT a.nombre AS insumo, a.codigo, di.cantidad, di.precio_compra, (di.cantidad*di.precio_compra) AS subtotal FROM detalle_ingresos di INNER JOIN insumos a ON di.insumo_id=a.idinsumo WHERE di.ingreso_id='$idingreso'";
         return ejecutarConsulta($sql);
}



}

 ?>
