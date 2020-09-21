<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Proveedor{


	//implementamos nuestro constructor
public function __construct(){

}
	
//metodo insertar regiustro
public function insertar($razon_social,$nombre,$apellido,$tipo_documento_id,$num_documento,$direccion,$telefono,$email){
	$sql1= "INSERT INTO contactos(telefono,email) VALUES('$telefono','$email');";
	$contacto_id = ejecutarConsulta_retornarID($sql1);

	$sql2= "INSERT INTO personas(nombre,apellido,tipo_documento_id, contacto_id,num_documento,direccion) VALUES('$nombre','$apellido','$tipo_documento_id','$contacto_id','$num_documento','$direccion');";
	$persona_id = ejecutarConsulta_retornarID($sql2);


	$sql="INSERT INTO proveedores (persona_id,razon_social) VALUES ('$persona_id','$razon_social')";
	return ejecutarConsulta($sql);
	
}

	

public function editar($idproveedor,$persona_id,$razon_social){
	$sql="UPDATE proveedores SET persona_id='$persona_id', razon_social='$razon_social'
	WHERE idproveedor='$idproveedor'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idproveedor){
	$sql="DELETE FROM proveedores WHERE idproveedor='$idproveedor'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idproveedor){
	$sql="SELECT * FROM proveedores WHERE idproveedor='$idproveedor'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrarc($idpersona){
	$sql="SELECT cl.idcliente,cl.fecha_alta as fecha_alta, p.idpersona, p.nombre,tp.descripcion AS tipo_documento, p.num_documento as numero, p.nombre,p.apellido,  cp.telefono AS telefono,cp.email AS email FROM clientes cl inner join personas p on cl.persona_id=p.idpersona INNER JOIN tipo_documentos tp ON p.tipo_documento_id=tp.idtipo_documento INNER JOIN personas_contactos cp ON cp.idpersonas_contacto=p.idpersona INNER JOIN contactos c ON c.idcontacto=p.idpersona";
	return ejecutarConsultaSimpleFila($sql);
}


//listar registros
public function listar(){
	$sql="SELECT pr.idproveedor,
pr.razon_social AS razon_social,
p.nombre AS nombre,
p.apellido AS apellido,
p.tipo_documento_id,
td.descripcion AS tipo_documento,
p.num_documento AS numero,
c.idcontacto,
c.telefono AS telefono,
c.email AS email,
p.direccion AS direccion
FROM proveedores pr 
INNER JOIN personas p ON p.idpersona = pr.persona_id
INNER JOIN tipo_documentos td ON td.idtipo_documento = p.tipo_documento_id
LEFT JOIN contactos c ON c.idcontacto = p.contacto_id";
	return ejecutarConsulta($sql);
}
public function selectTPDNI(){
	$sql= "SELECT * from tipo_documentos";
	return ejecutarConsulta($sql);
}
}

 ?>
