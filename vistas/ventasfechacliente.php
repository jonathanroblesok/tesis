<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';


if ($_SESSION['consultav']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Consulta de Ventas por Fecha</h1>
  <div class="box-tools pull-right">
    
  </div>
</div>


<script type="text/javascript" src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript" src="../public/js/Chart.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.min.js"></script>

<style>
.caja{
  margin: auto;
  max-width: 100px;
  padding: 20px;
  border: 1px solid #BDBDBD;
}
.caja{
 
  width: 100%;
  font-size: 16px;
  padding: 5px;
  }
.resultado{
  margin: auto;
  margin-top: 40px;
  width: 1000px;
  }
</style>
<body>
  
<div class="caja">
<select onChange="mostrarResultados(this.values);">
<?php
for($i=2000;$i<2020;$i++){
  if($i==2015){
    echo "<option value=".$i.'"selected>'.$i.'</option>';
  }else{
    echo "<option value=".$i.'">'.$i.'</option>';
  }
}
?>
</select>
</div>
<div class="resultados"><canvas id="grafico"></canvas>
</div>
</body>

<script>
$(document).ready(mostrarResultados(2015));
function mostrarResultados(año){
  $.ajax({

    type:'POST',
    url:'../modelos/Controlador.php?op=consul',
    data:'año='+año,
    success:function(data){

      var valores= eval(data);
        var e=[0];
        var f=[1];
        var m=[2];
        var a=[3];
        var ma=[4];
        var j=[5];
        var jl=[6];
        var ag=[7];
        var s=[8];
        var o=[9];
        var n=[10];
        var d=[11];

        var Datos={
          label:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          datasets:[{
            fillColor:'rgba(91,228,146,0,6)',//Color de las barras
            strokeColor: 'rgba(57,194,112,0,7)',//Color del borde de las barras
            highlightFill: 'rgba(73,206,180,0,6)',//Color "HOVER" de las barras
            highlightStroke: 'rgba(66,196,157,0,7)',//Color "HOVER" del borde de las barras
            data:[e,f,m,a,ma,jl,ag,s,o,n,d]

          }]
        }
      
      var contexto= document.getElementById('grafico').getContext('2d');
      window.Barra= new Chart(contexto, Datos, {responsive: true});
    }
  });
  return false;
} 
</script>
</html>

<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <label>Fecha Inicio</label>
    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
  </div>
  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <label>Fecha Fin</label>
    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
  </div>
  <div class="form-inline col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <label>Cliente</label>
    <select name="cliente_id" id="cliente_id" class="form-control selectpicker" data-live-search="true" required>
    </select>
  </div>
    <div class="form-inline col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <label>&nbsp</label><br>
      <button class="btn btn-success" onclick="listar()">Mostrar</button>
    </div>
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap">
    <thead>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Cliente</th>
      <th>Comprobante</th>
      <th>Número</th>
      <th>Total Ventas</th>
      <th>Impuesto</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Proveedor</th>
      <th>Comprobante</th>
      <th>Número</th>
      <th>Total Compra</th>
      <th>Impuesto</th>
      <th>Estado</th>
    </tfoot>   
  </table>
</div>

<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/ventasfechacliente.js"></script>
 <?php 
}

ob_end_flush();
  ?>

