<?php 
session_start();

/*------------------VERIFICAR QUE SEAL EL JEFE CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=2)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
	                    break;	            
	            case (1) :
	                    $home="home_admin.php";
	                    break;                                                             		
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
/*----------------------INICIO HABILITAR REGISTRO---------------------------*/
include('conexion/verificar_gestion.php');
$fecha = date("Y-m-d");
$inicio = $fecha;
$fin = $fecha;
if (isset($_POST['enviar'])) {
	$error=false;
	if (isset($_POST['inicio']) && isset($_POST['fin'])) {
		
		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];
		
		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		$fin_dia = substr($fin, 8);
		$fin_mes = substr($fin, 5,2);
		$fin_year = substr($fin, 0,4);
		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
				if($inicio>=$fecha){//corecto
					if ($fin>$inicio) {//corecto sobreescribir base de datos
						
					}
					else{
						$error = true;
						$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
					}
				}
				else{
					$error = true;
					$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error = true;
				$error_fecha_fin = "La fecha de finalizacion no es valida";
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es valida";
		}
	}
}

$titulo="Planificaci&oacute;n de actividades";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_consultor_jefe.php">Home Jefe Consultor TIS</a><span class="divider">/</span>
					</li>
					<li>
						<a href="planificacion.php">Planificaci&oacute;n de actividades</a>
					</li>				
				</ul>
			</div>
			<center><h3>Planificar las actividades de la Empresa TIS</h3></center>
			<?php if(!empty($id_gestion)) { 
				?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> 1. Habilitar registro de Grupo Empresas</h2>
					</div>
					<div class="box-content">
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="planificacion.php" accept-charset="utf-8">
							
								<div class="control-group">
								  <label class="control-label" for="tituloD">Habilitado: </label>
								  <div class="controls">
									<input type="checkbox" class="checkbox" id="newsletter" name="newsletter" checked=true/>
								  </div>
								</div>
								<fieldset id="newsletter_topics">
								<div class="control-group">
									<label class="control-label" for="descripcion">Desde:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Hasta:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
									</div>
								</div>
								</fieldset>	
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Aceptar</button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>
						        
							</form>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php }
			else{ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Planificacion de Actividades</h2>
					</div>
					<div class="box-content alerts">
						<?php 
							echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        Debe habilitar una gestion.</h4>
				                      	</div>";
						?>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } ?>
<?php include('footer.php'); ?>