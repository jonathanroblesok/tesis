<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['cuentas']==1) {

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
  <h1 class="box-title">Cuentas <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
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
                <h4 class="modal-title" id="myModalLabel">Gargar cuotas</h4>
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
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Usuario</th>
      <th>Monto max de venta Real</th>
      <th>Monto max de venta Actual</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Usuario</th>
      <th>Monto max de venta Real</th>
      <th>Monto max de venta Actual</th>
      <th>Estado</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
   
    <div class="form-group col-lg-8 col-md-8 col-xs-12">
      <label for="">Cliente(*):</label>
      <input class="form-control" type="hidden" name="idcuenta" id="idcuenta">
      <select name="cliente_id" id="cliente_id" class="form-control selectpicker" data-live-search="true" required>
        
      </select>
    </div>
      <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="">Fecha(*): </label>
      <input class="form-control" type="date" name="fecha_alta" id="fecha_alta" required>
    </div>
     <div class="form-group col-lg-2 col-md-2 col-xs-6">
      <label for="">Monto maximo de Venta Real: </label>
      <input class="form-control" type="number" name="monto_max_venta_real" id="monto_max_venta_real" maxlength="7" placeholder="Monto maximo de Venta Real: ">
    </div>
    <div class="form-group col-lg-2 col-md-2 col-xs-6">
      <label for="">Monto maximo de Venta Actual: </label>
      <input class="form-control" type="number" name="monto_max_venta_actual" id="monto_max_venta_actual" maxlength="7" placeholder="Monto maximo de Venta Actual: ">
    </div>

     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
    </form>
  </div>

  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/cuenta.js"></script>
 <?php 
}
  
ob_end_flush();
  ?>

