<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class HistorialDePrecio{


	//implementamos nuestro constructor
public function __construct(){

}


//listar registros del Historial de precios
public function listarHistorialPrecio(){
	$sql="SELECT * From variacion_precio";
	return ejecutarConsulta($sql);
}
}

 ?>
