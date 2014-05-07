<?php
session_start();
if(isset($_SESSION['nombre_usuario']))
{
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
                case (2) :
                	$home="home_consultor_jefe.php";
                    break;
                case (1) :
                    $home="home_admin.php";
                    break;                                                             		
          }   
	header("Location: ".$home);
}
$quien_ingresa="Grupo Empresa - Integrante";
$pag_registro="registro_grupo.php";
include('conexion/verificar_gestion.php');
if($gestion_valida){
	$error=false;
	if (isset($_POST['aceptar'])) {
		$usuario = $_POST['username'];
		$clave = $_POST['password'];
		$consulta_sql="SELECT nombre_usuario, tipo_usuario 
					from usuario 
					where nombre_usuario='$usuario' and clave='$clave' and (tipo_usuario=4 || tipo_usuario=5)AND habilitado=1 AND gestion=$id_gestion";
					$consulta = mysql_query($consulta_sql,$conn)
					or die("Could not execute the select query.");
					$resultado = mysql_fetch_assoc($consulta);
	
					if(is_array($resultado) && !empty($resultado))
					{	
						$_SESSION['tipo']= $resultado['tipo_usuario'];
						$nombre_valido = $resultado['nombre_usuario'];
						$_SESSION['nombre_usuario'] = $nombre_valido;//nombre del usuario						
					}
				else{	

						$error=true;
						$error_sesion="Los datos son incorrectos o usted no esta habilitado";
					}
					if(!$error){
						if(isset($_SESSION['nombre_usuario']) && isset($_SESSION['tipo']))
						{
							$home="";
							switch  ($_SESSION['tipo']){
										case (5) :
							                	$home="home_integrante.php";
							                    break;
						            	case (4) :
						                	$home="home_grupo.php";
						                    break;                                           		
						          }   
							header("Location: ".$home);
						}
						mysql_free_result($consulta);
					}
	}

}

$titulo="Iniciar sesi&oacute;n ".$quien_ingresa; 
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href="iniciar_sesion.php?value=3">Iniciar sesi&oacute;n <?php echo $quien_ingresa; ?></a>
					</li>				
				</ul>
			</div>
			<center><h3>Iniciar sesi&oacute;n: <?php echo $quien_ingresa; ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de inicio de sesi&oacute;n: <?php echo $quien_ingresa; ?></h2>					
						</div>
						<div class="box-content">
							<?php if ($gestion_valida) {
							 ?>
							
	                  		<form class="form-horizontal" id="signupForm" style="text-align:left;" action="iniciar_sesion_grupo.php" method="post" accept-charset="utf-8">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>
								</div>
								<div class="control-group">
								<div class="controls">
						         <button type="submit" name ="aceptar"class="btn btn-primary" id="enviar">Ingresar</button>
								 <button type="reset" class="btn">Restablecer</button>
								 <label class="error"><?php if(isset($error_sesion)){ echo $error_sesion; } ?></label>
								 </div>
								 </div> 
							  </fieldset>
							</form>
							<?php } 
							else{
							echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        No existe ninguna actividad para esta gest&oacute;n.</h4>
				                      	</div>";
						
							}    ?>	    
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->	
			</div>
<?php include('footer.php'); ?>
