	<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Modelo{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($talla_id,$categoria_id,$usuario_id,$fecha,$total_compra,$insumo_id,$cantidad,$precio_compra){
	$sql="INSERT INTO modelos (talla_id,categoria_id,usuario_id,fecha,total_compra,estado) VALUES ('$talla_id','$categoria_id','$usuario_id','$fecha','$total_compra','Aceptado')";
	//return ejecutarConsulta($sql);
	 $idmodelonew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($insumo_id)) {

	 	$sql_detalle="INSERT INTO detalle_modelos (modelo_id,insumo_id,cantidad,precio_compra) VALUES('$idmodelonew','$insumo_id[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]')";

  		ejecutarConsulta($sql_detalle) or $sw=false;//
	 
	 	

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function anular($idmodelo){
	$sql="UPDATE modelos SET estado='Anulado' WHERE idmodelo='$idmodelo'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idmodelo){
	$sql="SELECT m.idmodelo,
DATE(m.fecha) AS fecha,
m.talla_id,t.nombre AS nombre,
t.tipo_persona_talla AS tpTalla,
m.categoria_id, c.nombre AS categoria, 
m.total_compra 
FROM modelos m 
INNER JOIN tallas t ON m.talla_id=t.idtalla 
INNER JOIN categorias c ON m.categoria_id=c.idcategoria 
WHERE idmodelo='$idmodelo'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idmodelo){
	$sql="SELECT dm.modelo_id,dm.insumo_id,a.nombre,dm.cantidad,dm.precio_compra, (dm.cantidad*dm.precio_compra) AS subtotal FROM detalle_modelos dm INNER JOIN insumos a ON dm.insumo_id=a.idinsumo WHERE dm.modelo_id='$idmodelo'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT m.idmodelo,DATE(m.fecha) AS fecha,m.talla_id,t.nombre AS nombre, t.tipo_persona_talla AS tpTalla,m.categoria_id,c.nombre AS categoria,u.idusuario,u.nombre AS usuario, m.total_compra,m.estado FROM modelos m INNER JOIN tallas t ON m.talla_id=t.idtalla INNER JOIN categorias c ON m.categoria_id=c.idcategoria INNER JOIN usuarios u ON m.usuario_id=u.idusuario ORDER BY m.idmodelo DESC";
	return ejecutarConsulta($sql);
}
	
public function ingresocabecera($idmodelo){
	$sql= "SELECT m.idmodelo, i.proveedor_id, p.nombre, p.apellido, p.tipo_documento_id, p.num_documento AS proveedor, cp.idpersonas_contacto,cp.valor AS contacto, i.usuario_id, u.nombre AS usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, DATE(i.fecha_hora) AS fecha, i.impuesto, i.total_compra FROM ingresos i INNER JOIN personas p ON i.proveedor_id=p.idpersona INNER JOIN personas_contactos cp ON cp.idpersonas_contacto=p.idpersona  INNER JOIN usuarios u ON i.usuario_id=u.idusuario WHERE i.idmodelo='$idmodelo'";
	return ejecutarConsulta($sql);
}

public function ingresodetalles($idmodelo){
	$sql="SELECT i.nombre AS insumo, i.codigo, dm.cantidad, dm.precio_compra, (dm.cantidad*dm.precio_compra) AS subtotal FROM detalle_ingresos dm INNER JOIN insumos i ON dm.insumo_id=i.idinsumo WHERE dm.ingreso_id='$idmodelo'";
         return ejecutarConsulta($sql);
}



}

 ?>
