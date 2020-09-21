
<?php 
  //activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['almacen']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
          <!-- <h2 class="page-header">

           Comprobante # str_pad ($venta=id,7 , '0', STR_PAD_LEFT)
          </h2> -->
      <div class="box">
<div class="box-header with-border">

<div class="box-header with-border">
  <h1 class="box-title">Devoluciones <button class="btn btn-success" onclick="mostrarformDevolucion(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formularioDevolucion" method="POST">
    
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Numero de Factura(*):</label>
      <select name="venta_id" id="venta_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Cliente(*):</label>
      <select name="cliente_id" id="cliente_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Usuario(*):</label>
      <select name="usuario_id" id="usuario_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
       <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Fecha de Devolucion(*):</label>
      <input class="form-control" type="date" name="fecha_devolucion" id="fecha_devolucion"  placeholder="Fecha de devolucion"  required>
    </div>
      <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Motivo(*): </label>
     <select name="motivo" id="motivo" class="form-control selectpicker" required>
        <option value="">Seleccionar Motivo...</option>
       <option value="Dañado">Dañado</option>
       <option value="Defectuoso">Defectuoso</option>
       <option value="Otro">Otro</option>
     </select>
    </div>

    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar" onclick="anular('.$reg->idventa.')"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  </form>
</div>
!--fin centro-->
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
require 'footer.php'
 ?>
 <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>
 <script src="scripts/devolucion.js"></script>

 <?php 
}

ob_end_flush();
  ?>