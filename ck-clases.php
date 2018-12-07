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

$clases = $obj->obtenerClasesDeMaestro($_SESSION['ses_id']);

?>
<?php include_once('layouts/header.php'); ?>
<h1 class="page-header">
    Mis Clases
</h1>
<div class="row">
    <div class="col-md-8">

        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
            </li>
            <li>
                <i class="fa fa-briefcase" aria-hidden="true"></i> Mis Clase
            </li>

      	</ol>
    </div>
    <div class="col-md-4">
      <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="ck-clases.php">Clases</a></li>
        <li role="presentation"><a href="ck-tareas.php">Tareas</a></li>
      </ul>
    </div>
</div>

<?php if($clases->num_rows == 0){echo "<h1 style='color:red'>Aun no se le han asignado Clases</h1>";} ; while ($row = mysqli_fetch_assoc($clases)) { ?>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h1 class="panel-title"><?php echo $row['nombreCurso']."-". $row['seccion']." // ". $row['nombreAsignatura'] ?></h1>
				<small class="pull-rigth">Total Alumnos: <?php $row2 = $obj->contarEstudiantesPorClase($row['idCurso']);
															echo $row2['totalAlumnos'];?></small>
			</div>
			<div class="panel-body">
				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="button" class="btn btn-warning btn-block" name="verAlumnos"  value="<?php echo $row['idClase'] ?>" data-toggle='modal' data-target='#modalCuadroAlumnos'><i class="fa fa-list-ol"></i> Ver Alumnos</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-danger btn-block" name="asignarTarea" value="<?php echo $row['idClase'] ?>" data-toggle='modal' data-target='#modalAsignarTarea'> <i class="fa fa-plus"></i> Asignar Tarea</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-success btn-block" name="button"><i class="fa fa-check-square-o"></i>Tareas</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-info btn-block" name="button"><i class="fa fa-check-square-o"></i>Examen</button>
					</div>
				</div>

			</div>

		</div>
	</div>
<?php } ?>

<!-- Modal -->
<div id="modalAsignarTarea" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignar tarea</h4>
      </div>
      <div class="modal-body">
				<div class="row">
					<div class="col-md-7">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<strong>
				          <span class="glyphicon glyphicon-pencil"></span>
				          <span>Nueva Tarea</span>
				       </strong>
				       <small class="pull-right">Puntos Acumulativos Usados: <strong>{suma_puntos} / 70</strong></small>
							</div>
							<div class="panel-body">
		              <div class="form-row">
		                <div class="form-group col-md-9">
		                  <label>Nombre Tarea</label>
		                  <input type="text" class="form-control" placeholder="P.j Tarea de Investigacion">
		                  <small class="text-muted">Nombre para identificar esta tarea mas adelante</small>
		                </div>
		                <div class="form-group col-md-3">
		                  <label>Valor</label>
		                  <input type="number" class="form-control">
		                  <small class="text-muted">Asigne los puntos de esta tarea</small>
		                </div>
		              </div>
		              <div class="form-row">
		                <div class="form-group col-md-5">
		                  <label>Tipo Tarea</label>
		                  <select class="form-control" name="">
		                    <option selected disabled>--Seleccione una Opcion</option>
		                    <option value="">Tarea en Clase</option>
		                    <option value="">Tarea extra Clase</option>
		                  </select>
		                  <small class="text-muted">Seleccione si la tarea es en clase o para casa</small>
		                </div>
		              </div>
		              <div class="form-row">
		                <div class="form-group col-md-7">
		                  <label for="inputCity">Fecha Entrega de la Tarea</label>
		                  <input type="date" class="form-control">
		                  <small class="form-text text-muted">Si la tarea sera revisada hoy mismo NO escoja una fecha solo presione el boton 'Revisar Tarea Hoy'</small>
		                </div>
						         </div>
						         <div class="form-row">
						           <div class="col-md-6">
						             <button type="button" name="button" class="btn btn-primary btn-lg btn-block">Revisar Tarea Hoy</button>
						           </div>
						           <div class="col-md-6">
						             <button type="button" name="button" class="btn btn-warning btn-lg btn-block" >Programar</button>
						           </div>
						         </div>
						       </div>
						</div>
					</div>
					<div class="col-md-5">
		      <div class="panel panel-info">
		        <div class="panel-heading">
		          <strong>
		            <span class="glyphicon glyphicon-th-list"></span>
		            <span>Tarea Ingresadas</span>
		         </strong>
		        </div>
		        <form>
		           <table class="table table-bordered">
		             <thead>
		               <tr>
		                 <th>Tarea</th>
		                 <th>Fecha entrega</th>
		                 <th>Acciones</th>
		               </tr>
		             </thead>
		             <tbody id='tableTareas'></tbody>
		           </table>
		         <div class="panel-footer">

		         </div>
		        </form>
		        </div>
		       </div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success">Crear Tarea</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="modalCuadroAlumnos" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Listado Alumnos</h4>
      </div>
      <div class="modal-body">
        <table class="table">
        	<thead>
        		<tr>
							<th>#</th>
        			<th>Nombre</th>
							<th>Nota</th>
        		</tr>
        	</thead>
					<tbody id="tableAlumnos"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$("button[name='verAlumnos']").on('click',function () {
		var idClase1 = $(this).val();
		console.log(idClase1);
			$("#tableAlumnos").empty();

		$.ajax({
			method:"POST",
			url:"class/ck-scriptObtenerEstudiantesPorClase.php",
			data:{idClase: idClase1},
			dataType: "json",
			success:function (respuesta) {
				var i = 1;
				$.each(respuesta,function (key,value) {
					$("#tableAlumnos").append("<tr><td>"+i+"</td><td>"+value.nombreEstudiante+" "+value.apellidoEstudiante+"</td></tr>")
					i++;
				})

			},
			error:function (error,error1,error2) {
				console.log("Hubo un error");
			}
		})
	})

	$("button[name='asignarTarea']").on('click',function () {
		var idClase1 = $(this).val();
		console.log(idClase1);
			$("#tableTareas").empty();

		$.ajax({
			method:"POST",
			url:"class/ck-scriptObtenerTareasPorClase.php",
			data:{idClase: idClase1},
			dataType: "json",
			success:function (respuesta) {
				console.log(respuesta);
				var i = 1;
				$.each(respuesta,function (key,value) {
					$("#tableTareas").append("<tr><td>"+value.nombreTarea+"</td><td>"+value.fechaEntrega+"</td><td>Eliminar</td></tr>");
				})

			},
			error:function (error,error1,error2) {
				console.log("Hubo un error");
			}
		})
	})

</script>
   <?php
   if (isset($notifyVerification)) {
     echo $obj->notify($notifyVerification[0],$notifyVerification[1]);
   }?>
   <?php include_once('layouts/footer.php'); ?>
