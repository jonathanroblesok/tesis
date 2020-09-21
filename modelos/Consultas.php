<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Consultas{


	//implementamos nuestro constructor
public function __construct(){

}
	
//listar registros
public function comprasfecha($fecha_inicio,$fecha_fin){
	$sql="SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto,i.estado FROM ingresos i INNER JOIN personas p ON i.proveedor_id=p.idpersona INNER JOIN usuarios u ON i.usuario_id=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
	return ejecutarConsulta($sql);
}


public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente){
	$sql="SELECT DATE(v.fecha_hora) AS fecha, u.nombre AS usuario,
 	p.nombre AS cliente,
  	v.tipo_comprobante,
 	v.serie_comprobante,
  	v.num_comprobante ,
  	v.total_venta,
  	v.impuesto,
  	v.estado 
 	FROM ventas v 
 	INNER JOIN personas p ON v.cliente_id=p.idpersona  
 	INNER JOIN clientes c ON v.cliente_id=c.idcliente
 	INNER JOIN usuarios u ON v.usuario_id=u.idusuario 
 	WHERE DATE(v.fecha_hora) BETWEEN '$fecha_inicio' AND '$fecha_fin' AND v.cliente_id = '$idcliente'";

	return ejecutarConsulta($sql);
}

public function totalcomprahoy(){
	$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingresos WHERE DATE(fecha_hora)=curdate()";
	return ejecutarConsulta($sql);
}

public function totalventahoy(){
	$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM ventas WHERE DATE(fecha_hora)=curdate()";
	return ejecutarConsulta($sql);
}

public function comprasultimos_10dias(){
	$sql=" SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_compra) AS total FROM ingresos GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
	return ejecutarConsulta($sql);
}

public function ventasultimos_12meses(){
	$sql=" SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM ventas GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
	return ejecutarConsulta($sql);
}
	
public function productosmasvendidos(){
	$sql="SELECT p.nombre,
		SUM(dv.cantidad) AS vendido
		FROM detalle_ventas dv
		INNER JOIN ventas v ON dv.venta_id= v.idventa
		INNER JOIN productos p ON dv.producto_id= p.idproducto			
		GROUP BY p.nombre
		ORDER BY vendido DESC;";
	return ejecutarConsulta($sql);
}
public function productosmasvendidosfecha($fecha_inicio,$fecha_fin){
	$sql="SELECT DATE(v.fecha_hora) AS fecha,
		p.nombre as nombre,
		SUM(dv.cantidad) AS vendido
		FROM detalle_ventas dv
		INNER JOIN ventas v ON dv.venta_id= v.idventa
		INNER JOIN productos p ON dv.producto_id= p.idproducto			
		WHERE DATE(v.fecha_hora) BETWEEN '$fecha_inicio' AND '$fecha_fin' 
		GROUP BY p.nombre
		ORDER BY vendido DESC;";
	return ejecutarConsulta($sql);
}

public function clientemasfrecuente($fecha_inicio,$fecha_fin){
	$sql="SELECT DATE(v.fecha_hora) AS fecha,
p.nombre, p.apellido, 
  SUM(dv.cantidad) AS CantidadVendida,
  SUM(v.total_venta) AS MontoTotal
FROM detalle_ventas dv
INNER JOIN ventas v ON dv.venta_id=v.idventa
INNER JOIN clientes c ON v.cliente_id=c.idcliente
INNER JOIN personas p ON c.persona_id=p.idpersona
WHERE DATE(v.fecha_hora) BETWEEN '$fecha_inicio' AND '$fecha_fin' 
GROUP BY p.nombre
ORDER BY MontoTotal DESC;";
	return ejecutarConsulta($sql);
}






 

       }
 
 
  ?>
