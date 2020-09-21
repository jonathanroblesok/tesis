<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Pedido{

		
	//implementamos nuestro constructor
public function __construct(){

}
	
//metodo insertar registro
public function insertar($cliente_id,$usuario_id,$fecha,$observaciones,$total_pedido,$idproducto,$idtalla,$stock,$cantidad_producto,$idproductoinsumo,$idinsumo,$cantidad_insumo,$precio_compra){
	
	$sql="INSERT INTO pedidos (cliente_id,usuario_id,fecha,observaciones,total_pedido,condicion) VALUES ('$cliente_id','$usuario_id','$fecha','$observaciones','$total_pedido','0')";
	$idpedidonew=ejecutarConsulta_retornarID($sql);
	$num_elementos=0;
	$sw=true;
	 while ($num_elementos < count($idproducto)) {
	 	$sqldetallep = "INSERT INTO detalle_pedidos (pedido_id,producto_id,talla_id,stock,cantidad_producto) VALUES ('$idpedidonew','$idproducto[$num_elementos]','$idtalla[$num_elementos]','$stock[$num_elementos]','$cantidad_producto[$num_elementos]')";
	 	 ejecutarConsulta($sqldetallep) or $sw = false;
	 	 $num_elementos++;
	 }
	 $i = 0;
	 while($i <count($idproductoinsumo)){
	 	$consulta = "INSERT INTO pedidosxinsumos(pedido_id,producto_id,insumo_id,cantidad_insumo,precio_compra)VALUES('$idpedidonew','$idproductoinsumo[$i]','$idinsumo[$i]','$cantidad_insumo[$i]','$precio_compra[$i]')";
	 	ejecutarConsulta($consulta) or $sw = false;
	 	$i++;
	 }
	 return $sw;
}

public function desactivar($idpedido){
	$sql="UPDATE pedidos SET condicion='0' WHERE idpedido='$idpedido'";
	return ejecutarConsulta($sql);
}
public function activar($idpedido){
	$sql="UPDATE pedidos SET condicion='1' WHERE idpedido='$idpedido'";
	return ejecutarConsulta($sql);
}


 public function anular($idpedido){
 	$sql="UPDATE pedidos SET condicion='2' WHERE idpedido='$idpedido'";
	return ejecutarConsulta($sql);
 }


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idpedido){
	$sql="SELECT pe.idpedido,DATE(pe.fecha) as fecha,pe.cliente_id,p.nombre as cliente,u.idusuario,u.nombre as usuario, pe.observaciones,pe.condicion FROM pedidos pe INNER JOIN personas p ON pe.cliente_id=p.idpersona INNER JOIN clientes c ON pe.cliente_id=c.idcliente INNER JOIN usuarios u ON pe.usuario_id=u.idusuario WHERE idpedido='$idpedido'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idpedido){
	$sql="SELECT  dp.producto_id, p.nombre AS producto, 
dp.talla_id, t.tipo_persona_talla,t.nombre AS talla,
p.stock as stock, 
dp.cantidad_producto AS cantidad_producto  
FROM detalle_pedidos dp 
INNER JOIN productos p ON dp.producto_id=p.idproducto 
INNER JOIN tallas t ON dp.talla_id=t.idtalla 
WHERE dp.pedido_id='$idpedido'";
	return ejecutarConsulta($sql);
}
public function listarDetalleInsumo($idpedido){
	$sql="SELECT ip.idpedidoxinsumo,ip.producto_id, p.nombre AS producto, 
ip.insumo_id,
i.nombre,
ip.cantidad_insumo,
i.precio_compra, 
(ip.cantidad_insumo*i.precio_compra) AS subtotal 
FROM pedidosxinsumos ip  
INNER JOIN  productos p ON ip.producto_id=p.idproducto 
INNER JOIN insumos i ON ip.insumo_id=i.idinsumo  
WHERE ip.pedido_id='$idpedido'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT pe.idpedido,DATE(pe.fecha) AS fecha,
pe.cliente_id, p.nombre AS nombre, 
p.apellido AS apellido,u.nombre AS usuario, 
pe.observaciones,pe.total_pedido,pe.condicion  
FROM pedidos pe INNER JOIN personas p ON pe.cliente_id=p.idpersona 
INNER JOIN clientes c ON pe.cliente_id=c.idcliente 
INNER JOIN usuarios u ON pe.usuario_id=u.idusuario 
ORDER BY pe.fecha DESC";
	return ejecutarConsulta($sql);
}
	

public function ventacabecera($idpedido){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idpedido){
	$sql="SELECT  dp.descripcion as descripcion, dp.talla_id, t.nombre as talla, c.nombre as categoria, dp.cantidad as cantidad  FROM detalle_pedidos dp INNER JOIN tallas t ON dp.talla_id=t.idtalla INNER JOIN categorias c ON dp.categoria_id=c.idcategoria where dp.pedido_id='$idpedido'";
         return ejecutarConsulta($sql);
}


}

 ?>
