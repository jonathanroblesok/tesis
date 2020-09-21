<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Domicilio{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($persona_id,$localidad_id,$ciudad,$barrio,$calle,$altura,$numero_casa,$manzana){
	$sql= "INSERT INTO domicilios (persona_id,localidad_id,ciudad,barrio,calle,altura,numero_casa,manzana) VALUES('$persona_id','$localidad_id','$ciudad','$calle','$barrio','$altura','$numero_casa','$manzana');";
	return  ejecutarConsulta($sql);

}

public function editar($iddomicilio,$persona_id,$localidad_id,$ciudad,$barrio,$calle,$altura,$numero_casa,$manzana){
	$sql="UPDATE domicilios SET persona_id='$persona_id', localidad_id='$localidad_id', ciudad='$ciudad', barrio='$barrio', calle='$calle', altura='$altura', numero_casa='$numero_casa', manzana='$manzana' 
	WHERE iddomicilio='$iddomicilio'";
	return ejecutarConsulta($sql);
}
public function desactivar($iddomicilio){
	$sql="UPDATE domicilios SET condicion='0' WHERE iddomicilio='$iddomicilio'";
	return ejecutarConsulta($sql);
}
public function activar($idcategoria){
	$sql="UPDATE domicilios SET condicion='1' WHERE iddomicilio='$iddomicilio'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($iddomicilio){
	$sql="SELECT * FROM domicilios WHERE iddomicilio='$iddomicilio'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM domicilios";
	return ejecutarConsulta($sql);
}


//listar registros
public function listarc(){
	$sql="SELECT * FROM domicilios";
	return ejecutarConsulta($sql);
}

//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM domicilios WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
