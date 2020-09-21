<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Cuenta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($cliente_id,$usuario_id,$monto_max_venta_real,$monto_max_venta_actual,$fecha_alta){
	$sql="INSERT INTO cuentas (cliente_id,usuario_id,monto_max_venta_real,monto_max_venta_actual,fecha_alta,condicion) VALUES ('$cliente_id','$usuario_id','$monto_max_venta_real','$monto_max_venta_actual','$fecha_alta','1')";
	//return ejecutarConsulta($sql);

	 return ejecutarConsulta($sql);
}


public function editar($idcuenta,$monto_max_venta_real,$monto_max_venta_actual,$fecha_alta){
	$sql="UPDATE cuentas SET cliente_id='$cliente_id', monto_max_venta='monto_max_venta', monto_max_venta_actual='monto_max_venta_actual', fecha_alta='fecha_alta'
	WHERE idcategoria='$idcategoria'";
	return ejecutarConsulta($sql);
}

public function desactivar($idcuenta){
	$sql="UPDATE cuentas SET condicion='0' WHERE idcuenta='$idcuenta'";
	return ejecutarConsulta($sql);
}
public function activar($idcuenta){
	$sql="UPDATE cuentas SET condicion='1' WHERE idcuenta='$idcuenta'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idcuenta){
	$sql="SELECT * FROM cuentas WHERE idcuenta='$idcuenta'";
	return ejecutarConsultaSimpleFila($sql);
}

public function anular($idcuenta){
	$sql="UPDATE cuentas SET condicion='Anulado' WHERE idcuenta='$idcuenta'";
	return ejecutarConsulta($sql);
}





//listar registros
public function listar(){
	$sql="SELECT cu.idcuenta,DATE(cu.fecha_alta) AS fecha,cu.cliente_id,p.nombre as nombre, p.apellido as apellido,u.idusuario,u.nombre AS usuario, cu.monto_max_venta_real as monto_real, cu.monto_max_venta_actual as monto_actual, cu.condicion FROM cuentas cu INNER JOIN personas p ON cu.cliente_id=p.idpersona INNER JOIN clientes c ON cu.cliente_id=c.idcliente INNER JOIN usuarios u ON cu.usuario_id=u.idusuario ORDER BY cu.idcuenta DESC";
	return ejecutarConsulta($sql);
}
	
	
public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, 
v.cliente_id, 
p.nombre, 
p.apellido, 
p.tipo_documento_id, 
p.num_documento AS cliente,
c.idcontacto,
c.telefono AS telefono,
c.email AS email,  
v.usuario_id, 
u.nombre AS usuario, 
v.tipo_comprobante, 
v.serie_comprobante, 
v.num_comprobante, 
DATE(v.fecha_alta) AS fecha, 
v.impuesto, v.total_venta 
FROM ventas v 
INNER JOIN personas p ON v.cliente_id=p.idpersona
LEFT JOIN contactos c ON c.idcontacto = p.contacto_id 
INNER JOIN usuarios u ON v.usuario_id=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idventa){
	$sql="SELECT a.nombre AS producto, a.codigo,  d.cantidad,a.precio_unitario, d.descuento, (d.cantidad*a.precio_unitario-d.descuento) AS subtotal FROM detalle_ventas d INNER JOIN productos a ON d.producto_id=a.idproducto WHERE d.venta_id='$idventa'";
         return ejecutarConsulta($sql);
}

public function selectVenta(){
	$sql="SELECT * FROM ventas WHERE estado='Aceptado'";
	return ejecutarConsulta($sql);
}

}



 ?>
