<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['compras']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Proveedores <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap">
    <thead>
      <th>Opciones</th>
      <th>Razon Social</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Numero</th>
      <th>Telefono</th>
      <th>Email</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Razon Social</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Numero</th>
      <th>Telefono</th>
      <th>Email</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre</label>
      <input class="form-control" type="hidden" name="idproveedor" id="idproveedor">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del proveedor" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Apellido</label>
      <input class="form-control" type="text" name="apellido" id="apellido" maxlength="100" placeholder="Apellido del proveedor" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Razon Social</label>
      <input class="form-control" type="text" name="razon_social" id="razon_social" maxlength="100" placeholder="Razon Social" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Tipo Documento</label>
      <select name="tipo_documento_id" id="tipo_documento_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Numero de documento</label>
      <input class="form-control" type="text" name="num_documento" id="num_documento"  placeholder="Número de Documento">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Telefono</label>
      <input class="form-control" type="text" name="telefono" id="telefono"  placeholder="Telefono">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Email</label>
      <input class="form-control" type="email" name="email" id="email" placeholder="Email">
    </div>
    <!--  <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Contacto</label>
      <select name="personas_contacto_id" id="personas_contacto_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
   
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Descripcion del contacto</label>
      <input class="form-control" type="text" name="valor" id="valor" maxlength="20" placeholder="Número de Telefono">
    </div> -->
     <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Direccion</label>
      <textarea class="form-control" type="text" name="direccion" id="direccion" maxlength="20" placeholder="Direccion"></textarea>
      
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>

      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  </form>
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
 <script src="scripts/proveedor.js"></script>
 <?php 
}

ob_end_flush();
  ?>
