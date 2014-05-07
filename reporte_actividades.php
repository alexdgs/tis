<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
	            case (2) :
	                	$home="home_consultor_jefe.php";
	                    break;
	            case (3) :
	                    $home="home_consultor.php";
	                    break;                                                             		
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/

						 

$titulo="Reporte Actividades";
$usuario=$_SESSION['nombre_usuario'];
include('header.php');
 ?>
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_admin.php">Reporte Actividades</a>
					</li>
				</ul>
			</div>
			<center><h3>Reporte Actividades</h3></center>
			<div class="row-fluid">
		            <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Reporte Actividades</h2>

					</div>
					<div class="box-content">
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/notificaciones_resp_contrato.php" accept-charset="utf-8">	

						<table class="table table-bordered table-striped">
						  

						  	<input type="hidden" id="usuario" name="usuario" value=<?php echo $nombre_usuario ?> ></input>
                            <?php
                              include('conexion/conexion.php');
                               $consulta = "SELECT a.descripcion, a.fecha_inicio, a.fecha_fin
											FROM actividad_grupo_empresa a, entrega_producto e, grupo_empresa g 
											WHERE g.nombre_usuario='$nombre_usuario'
											AND e.grupo_empresa = g.nombre_usuario
											AND a.entrega_producto = e.id_entrega_producto";
                               $resultado = mysql_query($consulta);
                               $identi=0;
                               
                                while($row = mysql_fetch_array($resultado)) {
                                	echo
                                	"<thead >
										  <tr >
											  <th colspan=\"2\"> <center>Actividad : "." ".$row["descripcion"]." <br>Duracion: ".$row["fecha_inicio"]." - ".$row["fecha_inicio"]." </center></th>
										      
										  </tr>
									  </thead>";
									  $des = $row["descripcion"];
									  	$tareas = "SELECT t.descripcion, i.nombre, t.fecha_inicio, t.fecha_fin
													FROM tarea t, grupo_empresa g, actividad_grupo_empresa a, entrega_producto e, integrante i 
													WHERE g.nombre_usuario = '$nombre_usuario'
													AND e.grupo_empresa=g.nombre_usuario
													AND a.descripcion = '$des'
													AND a.entrega_producto = e.id_entrega_producto
													AND t.actividad_grupo_empresa = a.id_actividad_grupo_empresa
													AND i.id_integrante = t.integrante";

                               			$res_tareas = mysql_query($tareas);
                               			
                               			while($con = mysql_fetch_array($res_tareas)) {
                               				echo"
												  <tr >
													  <td colspan=\"1\"> <b>Tarea : "." </b>".$con["descripcion"]." <br><b>Duracion: </b>".$con["fecha_inicio"]." - ".$con["fecha_inicio"]."</td>
													  <td colspan=\"1\"><b>Responsable : </b> ".$con["nombre"]."</td>
												  </tr>
												  ";
                               			}
                                }

                               

                             ?>

						  
					  </table>
					  <div style="padding-left:10px;">
                      <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar</button>
                      </div>
                    </form>



					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>