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
include('conexion/verificar_gestion.php');
if (!$gestion_valida) {
	$fecha = date("Y-m-d");
	$inicio = $fecha;
	$fin = NULL;
	$descripcion=NULL;
	$year = date('Y');
	$mes = date('m');
	if($mes >=1 && $mes <=6){
		$gestion = "1-".$year;
	}
	else{
		$gestion = "2-".$year;
	}

	if (isset($_POST['enviar'])) {
		$error=false;

		$inicio = $_POST['inicio'];
		$descripcion = $_POST['descripcionG'];
		$gestion=$_POST['gestion'];
		$fin = $_POST['fin'];

		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if(!empty($fin)){
				$fin_dia = substr($fin, 8);
				$fin_mes = substr($fin, 5,2);
				$fin_year = substr($fin, 0,4);
				if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
					if($inicio>=$fecha){//corecto
						if ($fin>$inicio) {//corecto escribir en base de datos
							$sql = "INSERT INTO gestion_empresa_tis(gestion,fecha_ini_gestion,fecha_fin_gestion,gestion_activa,descripcion_gestion)
									VALUES('$gestion','$inicio','$fin',1,'$descripcion')";
					        $result = mysql_query($sql,$conn) or die(mysql_error());
					        header("Location: home_consultor_jefe.php");
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
				if($inicio>=$fecha){//corecto
						$sql = "INSERT INTO gestion_empresa_tis(gestion,fecha_ini_gestion,fecha_fin_gestion,gestion_activa,descripcion_gestion)
									VALUES('$gestion','$inicio',NULL,1,'$descripcion')";
					    $result = mysql_query($sql,$conn) or die(mysql_error());
					    header("Location: home_consultor_jefe.php");
					}
					else{
						$error = true;
						$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
					}
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es valida";
		}
	}
}
$titulo="P&aacute;gina de inicio Jefe Consultor TIS";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_consutor_jefe.php">Home Jefe Consultor TIS</a>
					</li>				
				</ul>
			</div>
			<center><h3>Bienvenido Jefe Consultor TIS</h3></center>
			<?php 
			if (!$gestion_valida) { ?>
				<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-warning-sign"></i> Importante</h2>
					</div>
					<div class="box-content alerts">
					<span class="pull-left">					
							Para poder utilizar el sistema usted debe habilitar una <b>Nueva Gesti&oacute;n.</b>
							<br><br>
					</span><br><br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="home_consultor_jefe.php" accept-charset="utf-8">
								<fieldset>
								<input type="hidden" name="gestion" id="gestion" value="<?php echo $gestion; ?>">
								<div class="control-group">
								  <label class="control-label" >Gesti&oacute;n: </label>
								  <div class="controls" style="padding-top:3px; font-size:13px;">
								  	<?php echo $gestion; ?>
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Inicio de gesti&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" editable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Fin de gesti&oacute;n (*):</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>">
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n:</label>
									<div class="controls">
										<input placeholder="Breve descripcion" type="text" name="descripcionG" id="descripcionG" value="<?php echo $descripcion; ?>">
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Aceptar</button>
								 </div>
								 </div>
								 <span class="pull-left">					
									(*) No es obligatorio indicar la fecha de finalizacion de la gesti&oacute;n.
								</span><br>
						        </fieldset>
							</form>										
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } 
			else{ ?>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Informacion</h2>
					</div>
					<div class="box-content alerts">
									
							Bienvenido Consultor TIS a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; realizar la publicaci&oacute;n de avisos
							 y documentos, realizar el seguimiento de las Grupo Empresas que se inscribieron con usted, enviar mensajes a cualquier usuario
							 del sistema y tambi&eacute;n podr&aacute; participar del espacio de discuci&oacute;n donde las grupo empresas
							 inscritas con usted dejaran preguntas o dudas esperando su respuesta.
							<br>						
					</div>	
				</div><!--/span-->  
			</div><!-- fin row -->
			<?php } ?>
			
<?php include('footer.php'); ?>