<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Talla{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($nombre,$tipo_persona_talla){
	$sql="INSERT INTO tallas (nombre, tipo_persona_talla) VALUES ('$nombre','$tipo_persona_talla')";
	return ejecutarConsulta($sql);
}

public function editar($idtalla,$nombre,$tipo_persona_talla){
	$sql="UPDATE tallas SET nombre='$nombre', tipo_persona_talla='$tipo_persona_talla'
	WHERE idtalla='$idtalla'";
	return ejecutarConsulta($sql);
}
public function desactivar($idtalla){
	$sql="UPDATE tallas SET condicion='0' WHERE idtalla='$idtalla'";
	return ejecutarConsulta($sql);
}
public function activar($idtalla){
	$sql="UPDATE tallas SET condicion='1' WHERE idtalla='$idtalla'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idtalla){
	$sql="SELECT * FROM tallas WHERE idtalla='$idtalla'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tallas";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM tallas WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
