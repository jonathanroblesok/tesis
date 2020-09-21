<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Categoria{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($nombre){
	$sql="INSERT INTO categorias (nombre,condicion) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);
}

public function editar($idcategoria,$nombre){
	$sql="UPDATE categorias SET nombre='$nombre' 
	WHERE idcategoria='$idcategoria'";
	return ejecutarConsulta($sql);
}
public function desactivar($idcategoria){
	$sql="UPDATE categorias SET condicion='0' WHERE idcategoria='$idcategoria'";
	return ejecutarConsulta($sql);
}
public function activar($idcategoria){
	$sql="UPDATE categorias SET condicion='1' WHERE idcategoria='$idcategoria'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idcategoria){
	$sql="SELECT * FROM categorias WHERE idcategoria='$idcategoria'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM categorias";
	return ejecutarConsulta($sql);
}


//listar registros
public function listarc(){
	$sql="SELECT * FROM categorias";
	return ejecutarConsulta($sql);
}

//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM categorias WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
