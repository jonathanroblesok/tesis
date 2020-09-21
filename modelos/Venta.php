<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Venta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($cliente_id,$usuario_id,$tipo_venta_id,$tipo_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$producto_id,$cantidad,$precio_unitario,$descuento){
	$sql="INSERT INTO ventas (cliente_id,usuario_id,tipo_venta_id,tipo_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado) VALUES ('$cliente_id','$usuario_id','$tipo_venta_id','$tipo_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
	//return ejecutarConsulta($sql);
	 $idventanew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($producto_id)) {

	 	$sql_detalle="INSERT INTO detalle_ventas (venta_id,producto_id,cantidad,precio_unitario,descuento) VALUES('$idventanew','$producto_id[$num_elementos]','$cantidad[$num_elementos]','$precio_unitario[$num_elementos]','$descuento[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function anular($idventa){
	$sql="UPDATE ventas SET estado='Anulado' WHERE idventa='$idventa'";
	return ejecutarConsulta($sql);
}


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.cliente_id,p.nombre as cliente,u.idusuario,u.cargo as usuario, v.tipo_venta_id, tv.descripcion, v.tipo_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM ventas v INNER JOIN personas p ON v.cliente_id=p.idpersona  INNER JOIN clientes c ON v.cliente_id=c.idcliente INNER JOIN usuarios u ON v.usuario_id=u.idusuario
	INNER JOIN tipo_ventas tv on v.tipo_venta_id=tv.idtipo_venta WHERE idventa='$idventa'";
	return ejecutarConsultaSimpleFila($sql);
}
//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrarDevolucion($iddevolucion){
	$sql="SELECT d.iddevolucion,
		d.venta_id AS venta,
		d.cliente_id,
		p.nombre AS cliente,
		d.usuario_id,
		u.cargo AS usuario, 
		d.motivo AS motivo,
		d.fecha_devolucion AS fecha
		FROM devoluciones d
		INNER JOIN ventas v ON d.venta_id=v.idventa
		INNER JOIN personas p ON d.cliente_id=p.idpersona  
		INNER JOIN clientes c ON d.cliente_id=c.idcliente 
		INNER JOIN usuarios u ON d.usuario_id=u.idusuario 
		WHERE iddevolucion='$iddevolucion'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idventa){
	$sql="SELECT dv.venta_id,dv.producto_id,a.nombre,a.precio_unitario,dv.cantidad,dv.descuento,(dv.cantidad*a.precio_unitario-dv.descuento) as subtotal FROM detalle_ventas dv INNER JOIN productos a ON dv.producto_id=a.idproducto WHERE dv.venta_id='$idventa'";
	return ejecutarConsulta($sql);
}
public function listarDetalleDevolucion($idventa){
	$sql="SELECT dv.venta_id,dv.producto_id,a.nombre,a.precio_unitario,dv.cantidad FROM detalle_ventas dv INNER JOIN productos a ON dv.producto_id=a.idproducto WHERE dv.venta_id='$idventa'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) AS fecha,v.cliente_id,p.nombre AS nombre, p.apellido AS apellido, tc.descripcion AS tipo_cliente, u.idusuario,u.cargo AS usuario,v.tipo_venta_id,tv.descripcion AS tipo_venta, v.tipo_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM ventas v INNER JOIN personas p ON v.cliente_id=p.idpersona INNER JOIN tipo_clientes tc ON v.cliente_id=tc.idtipo_cliente  INNER JOIN tipo_ventas tv on v.tipo_venta_id=tv.idtipo_venta INNER JOIN usuarios u ON v.usuario_id=u.idusuario ORDER BY v.fecha_hora DESC";
	return ejecutarConsulta($sql);
}
public function listarDevolucion(){
	$sql="SELECT d.iddevolucion,
		d.venta_id AS venta,
		d.cliente_id,
		p.nombre AS cliente,
		d.usuario_id,
		u.cargo AS usuario, 
		d.motivo AS motivo,
		d.fecha_devolucion AS fecha
		FROM devoluciones d
		INNER JOIN ventas v ON d.venta_id=v.idventa
		INNER JOIN personas p ON d.cliente_id=p.idpersona  
		INNER JOIN clientes c ON d.cliente_id=c.idcliente 
		INNER JOIN usuarios u ON d.usuario_id=u.idusuario 
		ORDER BY v.idventa DESC";
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
u.cargo AS usuario,
v.tipo_venta_id,
tv.descripcion AS tipo_venta,
tc.descripcion AS tipo_cliente, 
v.tipo_comprobante, 
v.num_comprobante, 
DATE(v.fecha_hora) AS fecha, 
v.impuesto, v.total_venta 
FROM ventas v 
INNER JOIN personas p ON v.cliente_id=p.idpersona
LEFT JOIN contactos c ON c.idcontacto = p.contacto_id 
INNER JOIN tipo_clientes tc ON v.cliente_id=tc.idtipo_cliente
INNER JOIN tipo_ventas tv ON v.tipo_venta_id=tv.idtipo_venta
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

 public function selectTipoVenta(){
 	$sql="SELECT * FROM tipo_ventas";
	return ejecutarConsulta($sql);
 }

public function IncrementarVenta(){
	$sql="SELECT MAX(idventa) + 1 FROM Ventas";
		return ejecutarConsulta($sql);

}

}



 ?>
