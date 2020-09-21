<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['ventas']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Clientes <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
  <!-- Button to trigger modal -->
<!-- <button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
    Domicilio
</button> -->

<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Gargar datos del Domicilio del Cliente</h4>
            </div>
            <form role="form" name="guardarDireccion" id="saveDireccion">
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                
                  <div class="form-group">
                       <input class="form-control" type="hidden" name="idpersona" id="idclientedireccion">
                        <label for="">Localidad</label>
                        <select name="localidad_id" id="localidad_id" class="form-control selectpicker" data-Live-search="true" required></select>
                    </div>
                    <div class="form-group">
                        <label for="">Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Cuidad"/>
                    </div>
                    <div class="form-group">
                        <label for="">Barrio</label>
                        <input type="text" class="form-control" name="barrio" id="barrio" placeholder="Barrio"/>
                    </div>
                    <div class="form-group">
                        <label for="">Calle</label>
                        <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle"/>
                    </div>
                    <div class="form-group">
                        <label for="">Altura</label>
                        <input type="text" class="form-control" name="altura" id="altura" placeholder="Altura"/>
                    </div>
                    <div class="form-group">
                        <label for="">Numero de Casa</label>
                        <input type="text" class="form-control" name="numero_casa" id="numero_casa" placeholder="Numero de Casa"/>
                    </div>
                    <div class="form-group">
                        <label for="">Manzana</label>
                        <input type="text" class="form-control" name="manzana" id="manzana" placeholder="Manzana"/>
                    </div>
              
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary submitBtn" >Enviar</button>
            </div>
  </form>
        </div>
    </div>
</div>

  <div class="box-tools pull-right">
    
  </div>

</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap">
    <thead>
      <th>Opciones</th>
      <th>Fecha de alta</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Numero</th>
      <th>Telefono</th>
      <th>Email</th>
      <th>Tipo de Cliente</th>
      <th>Direccion</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Fecha de alta</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Numero</th>
      <th>Telefono</th>
      <th>Email</th>
      <th>Tipo de Cliente</th>
      <th>Direccion</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre</label>
      <input type="hidden"  class="form-control" name="idcliente" id="idcliente">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del cliente" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Apellido</label>
      <input class="form-control" type="text" name="apellido" id="apellido" maxlength="100" placeholder="Apellido del cliente" required>
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
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Tipo de Cliente(*): </label>
      <select  name="tipo_cliente_id" id="tipo_cliente_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
     <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="">Fecha(*): </label>
      <input class="form-control" type="date" name="fecha_alta" id="fecha_alta" required>
    </div>
      
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
 <script src="scripts/cliente.js"></script>
 <?php 
}

ob_end_flush();
  ?>
