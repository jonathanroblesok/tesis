<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Insumo{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($categoria_id,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="INSERT INTO insumo (categoria_id,codigo,nombre,stock,descripcion,imagen,condicion)
	 VALUES ('$categoria_id','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
	return ejecutarConsulta($sql);
}

public function editar($idinsumo,$categoria_id,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="UPDATE insumos SET categoria_id='$categoria_id',codigo='$codigo', nombre='$nombre',stock='$stock',descripcion='$descripcion',imagen='$imagen' 
	WHERE idinsumo='$idinsumo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idinsumo){
	$sql="UPDATE insumos SET condicion='0' WHERE idinsumo='$idinsumo'";
	return ejecutarConsulta($sql);
}
public function activar($idinsumo){
	$sql="UPDATE insumos SET condicion='1' WHERE idinsumo='$idinsumo'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idinsumo){
	$sql="SELECT * FROM insumos WHERE idinsumo='$idinsumo'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT a.idinsumo,a.categoria_id,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM insumos a INNER JOIN categorias c ON a.categoria_id=c.idcategoria";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idinsumo,a.categoria_id,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.precio_compra,a.descripcion,a.imagen,a.condicion FROM insumos a INNER JOIN categorias c ON a.categoria_id=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idinsumo,a.categoria_id,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idinsumo=a.idinsumo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM insumo a INNER JOIN Categoria c ON a.categoria_id=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
