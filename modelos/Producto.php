<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Producto{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($categoria_id,$talla_id,$codigo,$nombre,$precio_unitario,$stock,$stock_minimo,$descripcion,$imagen){
	$sql="INSERT INTO productos (categoria_id,talla_id,codigo,nombre,precio_unitario,stock,stock_minimo,descripcion,imagen,condicion)
	 VALUES ('$categoria_id','$talla_id','$codigo','$nombre','$precio_unitario','$stock','$stock_minimo','$descripcion','$imagen','1')";
	return ejecutarConsulta($sql);
}

public function editar($idproducto,$categoria_id,$talla_id,$codigo,$nombre,$precio_unitario,$stock,$stock_minimo,$descripcion,$imagen){
	$sql="UPDATE productos SET categoria_id='$categoria_id', talla_id='$talla_id', codigo='$codigo', nombre='$nombre', precio_unitario='$precio_unitario', stock='$stock',stock_minimo='$stock_minimo',descripcion='$descripcion',imagen='$imagen' 
	WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}
public function desactivar($idproducto){
	$sql="UPDATE productos SET condicion='0' WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}
public function activar($idproducto){
	$sql="UPDATE productos SET condicion='1' WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idproducto){
	$sql="SELECT * FROM productos WHERE idproducto='$idproducto'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT a.idproducto,a.categoria_id,c.nombre as categoria,a.talla_id,t.nombre as talla ,t.tipo_persona_talla as tpTalla,a.codigo, a.nombre,a.precio_unitario,a.stock,a.stock_minimo,a.descripcion,a.imagen,a.condicion FROM productos a INNER JOIN categorias c ON a.categoria_id=c.idcategoria INNER JOIN tallas t ON a.talla_id=t.idtalla";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idproducto,a.categoria_id,c.nombre as categoria,a.talla_id,t.nombre as talla ,t.tipo_persona_talla as tpTalla,a.codigo, a.nombre,a.precio_unitario,a.stock,a.descripcion,a.imagen,a.condicion FROM productos a INNER JOIN categorias c ON a.categoria_id=c.idcategoria INNER JOIN tallas t ON a.talla_id=t.idtalla WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idproducto,a.categoria_id,c.nombre AS categoria,
a.talla_id,t.nombre AS talla ,
a.codigo, a.nombre,a.precio_unitario,a.stock,a.stock_minimo,
a.precio_unitario
 AS precio_venta,a.descripcion,a.imagen,a.condicion 
FROM productos a
INNER JOIN categorias c ON a.categoria_id=c.idcategoria 
INNER JOIN tallas t ON a.talla_id=t.idtalla 
WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

public function actualizarporcategoria($categoria_id,$porcentaje){
	$sql="UPDATE productos SET precio_unitario= precio_unitario *$porcentaje/100+precio_unitario 
WHERE  categoria_id='$categoria_id' ";
	return ejecutarConsulta($sql);
}
 
public function filtrarCategoria(){
	$sql="SELECT c.idcategoria, c.nombre  AS categoria,
p.nombre AS producto 
FROM productos p
INNER JOIN categorias c ON p.categoria_id=c.idcategoria";
	return ejecutarConsulta($sql);

}
//listar registros de los productos
public function listarp(){
	$sql="SELECT * FROM productos";
	return ejecutarConsulta($sql);
}




}
 ?>
