<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['historialDePrecio']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Historial de Precios </h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap">
    <thead>
      <th>Nombre</th>     
      <th>Descripcion</th>
      <th>Stock</th>
      <th>Precio unitario</th>
      <th>Nuevo Precio unitario</th>
      <th>Fecha de Modificacion</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Nombre</th>
      <th>Descripcion</th>
      <th>Stock</th>
      <th>Precio unitario</th>
      <th>Nuevo Precio Unitario</th>
      <th>Fecha de Modificacion</th>
    </tfoot>   
  </table>
</div>

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
 <script src="scripts/historialDePrecio.js"></script>
 <?php 
}

ob_end_flush();
  ?>

