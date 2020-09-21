<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Persona{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($tipo_documento_id,$nombre,$num_documento,$apellido){
	$sql="INSERT INTO personas (tipo_documento_id,nombre,apellido,num_documento) VALUES ('$tipo_documento_id','$nombre','$apellido','$num_documento')";
	return ejecutarConsulta($sql);
}



public function editar($idpersona,$tipo_documento_id,$nombre,$apellido,$num_documento){
	$sql="UPDATE personas SET tipo_documento_id='$tipo_documento_id', nombre='$nombre',apellido='$apellido',num_documento='$num_documento'
	WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idpersona){
	$sql="DELETE FROM personas WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idpersona){
	$sql="SELECT * FROM personas WHERE idpersona='$idpersona'";
	return ejecutarConsultaSimpleFila($sql);
}




//listar registros


public function listarp(){
	$sql="SELECT * FROM proveedores  inner join personas on personas.idpersona = proveedores.persona_id";
	return ejecutarConsulta($sql);
}
public function listarc(){
	$sql="SELECT * FROM clientes inner join personas on personas.idpersona = clientes.persona_id inner join tipo_clientes on tipo_clientes.idtipo_cliente= clientes.tipo_cliente_id";
	return ejecutarConsulta($sql);
}
}

 ?>
