<?php
require_once "../config/Conexion.php";

$año=$_POST['año'];
 
 /**
  * 
  */
 class Controlador{
       
public function __construct(){
             # code...
       }
 
public function consul($enero, $febero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre,$data){

$enero=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=1 AND YEAR(fecha_hora='$año'))");
$febero=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=2 AND YEAR(fecha_hora='$año'))");
$marzo=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=3 AND YEAR(fecha_hora='$año'))");
$abril=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=4 AND YEAR(fecha_hora='$año'))");
$mayo=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=5 AND YEAR(fecha_hora='$año'))");
$junio=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=6 AND YEAR(fecha_hora='$año'))");
$julio=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=7 AND YEAR(fecha_hora='$año'))");
$agosto=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=8 AND YEAR(fecha_hora='$año'))");
$octubre=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=8 AND YEAR(fecha_hora='$año'))");
$septiembre=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=9 AND YEAR(fecha_hora='$año'))");
$octubre=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=10 AND YEAR(fecha_hora='$año'))");
$noviembre=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=11 AND YEAR(fecha_hora='$año'))");
$diciembre=mysql_fetch_array("SELECT SUM(total_venta) AS r FROM ventas WHERE MONTH(fecha_hora=12 AND YEAR(fecha_hora='$año'))");
 
$data= array(0=>round($enero['r'],1),
             1=>round($febero['r'],1),
             2=>round($marzo['r'],1),
             3=>round($abril['r'],1),
             4=>round($mayo['r'],1),
             5=>round($junio['r'],1),
             6=>round($julio['r'],1),
             7=>round($agosto['r'],1),
             8=>round($septiembre['r'],1),
             9=>round($octubre['r'],1),
             10=>round($noviembre['r'],1),
             11=>round($diciembre['r'],1)
             );
 
       echo json_encode($data);
 }
}
?>