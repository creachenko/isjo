<?php
session_start();
include 'class/funciones.php';
if (isset($_SESSION["ses_id"])) {
  $obj=new funcionesBD();
}else{
  echo '<script>
  alert("Tienes que loguearte");
  window.location= "index.php";
  </script>';
};
include 'layouts/header.php'; ?>

<div class="jumbotron">
<h1>Bienvenido</h1>
<p>Seleccione una opcion del menu lateral para continuar</p>
<img src="img/col.jpg"  width="1000" height="453">
</div>



                <!-- /.row -->
<?php include 'layouts/footer.php'; ?>
