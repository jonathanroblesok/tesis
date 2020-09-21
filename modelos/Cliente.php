	<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Cliente{


	//implementamos nuestro constructor
public function __construct(){

}
	
//metodo insertar regiustro
public function insertar($fecha_alta,$nombre,$apellido,$tipo_documento_id,$num_documento,$direccion,$telefono,$tipo_cliente_id,$email){
	$sql1= "INSERT INTO contactos(telefono,email) VALUES('$telefono','$email');";
	$contacto_id = ejecutarConsulta_retornarID($sql1);

	$sql2= "INSERT INTO personas(nombre,apellido,tipo_documento_id, contacto_id,num_documento,direccion) VALUES('$nombre','$apellido','$tipo_documento_id','$contacto_id','$num_documento','$direccion');";
	$persona_id = ejecutarConsulta_retornarID($sql2);

	



	$sql="INSERT INTO clientes (persona_id,tipo_cliente_id,fecha_alta) VALUES ('$persona_id','$tipo_cliente_id','$fecha_alta')";
	return ejecutarConsulta($sql);
	
}



public function editar($idcliente,$persona_id,$tipo_cliente_id,$fecha){
	$sql="UPDATE clientes SET persona_id='$persona_id', tipo_cliente_id='$tipo_cliente_id',	fecha_alta='$fecha_alta'
	WHERE idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idcliente){
	$sql="DELETE FROM clientes WHERE idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}
	
//metodo para mostrar registros
public function mostrar($idcliente){
	$sql="SELECT * FROM clientes WHERE idcliente='$idcliente'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrarc($idcliente){
	$sql="SELECT cl.idcliente,
cl.fecha_alta AS fecha_alta,
p.nombre AS nombre,
p.apellido AS apellido,
p.tipo_documento_id,
td.descripcion AS tipo_documento,
p.num_documento AS nro_doc,
c.idcontacto,
c.telefono AS telefono,
c.email AS email,
tc.descripcion AS tipo_cliente,
p.direccion AS direccion
FROM clientes cl 
INNER JOIN personas p ON p.idpersona = cl.persona_id
INNER JOIN tipo_documentos td ON td.idtipo_documento = p.tipo_documento_id
INNER JOIN tipo_clientes tc ON tc.idtipo_cliente=cl.tipo_cliente_id
LEFT JOIN contactos c ON c.idcontacto = p.contacto_id 
WHERE idcliente='$idcliente'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrard($idcliente){
	$sql="SELECT c.idcliente,c.persona_id, d.iddomicilio,
d.localidad_id,
l.nombre AS localidad,
d.ciudad AS ciudad,
d.barrio AS barrio,
d.calle AS calle,
d.altura AS altura,
d.numero_casa AS numero_casa,
d.manzana AS manzana
FROM domicilios d
INNER JOIN personas p ON d.persona_id=p.idpersona
INNER JOIN clientes c ON c.persona_id=p.idpersona
INNER JOIN localidades l ON d.localidad_id=l.idlocalidad
WHERE idcliente='$idcliente'";
	return ejecutarConsultaSimpleFila($sql);

}

//listar registros
public function listar(){
	$sql="SELECT p.idpersona, cl.idcliente,
cl.fecha_alta AS fecha_alta,
p.nombre AS nombre,
p.apellido AS apellido,
p.tipo_documento_id,
td.descripcion AS tipo_documento,
p.num_documento AS numero,
c.idcontacto,
c.telefono AS telefono,
c.email AS email,
tc.descripcion AS tipo_cliente,
p.direccion AS direccion
FROM clientes cl 
INNER JOIN personas p ON p.idpersona = cl.persona_id
INNER JOIN tipo_documentos td ON td.idtipo_documento = p.tipo_documento_id
INNER JOIN tipo_clientes tc ON tc.idtipo_cliente=cl.tipo_cliente_id
LEFT JOIN contactos c ON c.idcontacto = p.contacto_id";
	return ejecutarConsulta($sql);
}
public function selectTPDNI(){
	$sql= "SELECT * from tipo_documentos";
	return ejecutarConsulta($sql);
}
public function SelectLoc(){
	$sql= "SELECT * from localidades";
	return ejecutarConsulta($sql);
}
public function TipoCliente(){
	$sql= "SELECT * from tipo_clientes";
	return ejecutarConsulta($sql);
}
}

 ?>
