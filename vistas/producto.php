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
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Producto <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> <button class="btn btn-success" onclick="actualizarprecio" id="formularioPrecio" data-toggle="modal" data-target="#modalForm"><i class="fa fa-plus-circle"></i>ActualizarPrecios</button> <a target="_blank" href="../reportes/rptproductos.php"><button class="btn btn-info">Reporte</button></a></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->

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
                <h4 class="modal-title" id="myModalLabel">Actualizar precios de los Productos</h4>
            </div>
            <form role="form"  name="actualizarprecio" id="FormularioPrecio" method="POST">
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                  <div class="form-group">
                          <label for="">Porcentaje(*):</label>
                          <input  type="number" class="form-control" min="1" max="100" name="porcentaje" id="porcentaje" placeholder="%"/>
                      </div>
                  <div class="form-group ">
                      <label for="">Filtrar por(*):</label>
                      <select name="categoria_id" id="idcategoria" class="form-control selectpicker" data-Live-search="true" required></select>
                  </div>                 
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                <button type="submit" class="btn btn-primary submitBtn" id="btnGuardarPrecio" >Enviar</button>
            </div>
  </form>
        </div>
    </div>
</div>


<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap">
    <thead>
      <th>Opciones</th>
      <th>Nombre</th>
      <th>Categoria</th>
      <th>Talla</th>
      <th>Precio Unitario</th>
      <th>Codigo</th>
      <th>Stock</th>
      <th>Stock Minimo</th>
      <th>Imagen</th>
      <th>Descripcion</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
       <th>Opciones</th>
      <th>Nombre</th>
      <th>Categoria</th>
      <th>Talla</th>
      <th>Precio Unitario</th>
      <th>Codigo</th>
      <th>Stock</th>
      <th>Stock Minimo</th>
      <th>Imagen</th>
      <th>Descripcion</th>
      <th>Estados</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <!--<div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Color(*):</label>
      <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
      <input class="form-control" type="text" name="color" id="bau maxlength="100" onclick="startColorPicker(this)" required>
    </div>-->
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre(*):</label>
      <input class="form-control" type="hidden" name="idproducto" id="idproducto">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Categoria(*):</label>
      <select name="categoria_id" id="categoria_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
     <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Stock(*):</label>
      <input class="form-control" type="number" name="stock" id="stock" min="1" max="256" placeholder="Stock"  required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Stock Minimo(*):</label>
      <input class="form-control" type="number" name="stock_minimo" id="stock_minimo" min="1" max="256" placeholder="Stock Minimo"  required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Talla(*):</label>
      <select name="talla_id" id="talla_id" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Precio Unitario(*):</label>
      <input class="form-control" type="text" name="precio_unitario" id="precio_unitario" maxlength="256" placeholder="Precio Unitario">
    </div>
       <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Descripcion(*):</label>
      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
    </div>
        <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Imagen(*):</label>
      <input class="form-control" type="file" name="imagen" id="imagen">
      <input type="hidden" name="imagenactual" id="imagenactual">
      <img src="" alt="" width="150px" height="120" id="imagenmuestra">
    </div>
     
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Codigo(*):</label>
      <input class="form-control" type="text" name="codigo" id="codigo" placeholder="codigo del producto" required>
      <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
      <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
      <div id="print">
        <svg id="barcode"></svg>
      </div>
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
require 'footer.php'
 ?>
 <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>
 <script src="scripts/producto.js"></script>

 <?php 
}

ob_end_flush();
  ?>