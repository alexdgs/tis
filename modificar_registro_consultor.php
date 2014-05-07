<?php
session_start();
if (isset($_GET['value']) && $_SESSION['tipo']==$_GET['value']) {
	$quien=$_GET['value'];
}
else{
	header('Location: index.php');
}
$quien_ingresa="";
$pag_ini="";
switch  ($quien){
                case (3) :
                	{$quien_ingresa="Consultor TIS";
                	$pag_ini="home_cosultor.php";
                    break;}
                case (2) :
                	{$quien_ingresa="Jefe Consultor TIS";
                	$pag_ini="home_consultor_jefe.php";
                    break; }                                                            		
 } 

/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=$quien)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
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




$titulo="Modificar datos ".$quien_ingresa;

include('header.php');
include('conexion/conexion.php');
$user=$_SESSION['nombre_usuario'];
$sql = 	"SELECT nombre_usuario, nombre, apellido, telefono
				 FROM consultor_tis
				 WHERE nombre_usuario = '$user'";
		$auxiliar = mysql_query($sql);
		$result = mysql_fetch_array($auxiliar);

		$nom_usuario=$result['nombre_usuario'];
		$nom=$result['nombre'];
		$ape=$result['apellido'];
		$telf=$result['telefono'];

		$sql = 	"SELECT email
				 FROM usuario
				 WHERE nombre_usuario = '$user'";
		$auxiliar = mysql_query($sql);
		$result = mysql_fetch_array($auxiliar);

		$mail=$result['email'];

/*--------------------------------VALIDAR REGISTRO------------------------------------*/
if(isset($_POST['enviar'])){
	/*VALORES DE FORMULARIO*/
	$usuario=$_POST['username'];
	$apellido=$_POST['lastname'];
	$nombre=$_POST['firstname'];
	$telfFijo=$_POST['telf'];
	$eMail=$_POST['email'];
	                       
	$error=false;
	
	     if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
	        $sql = "UPDATE consultor_tis as a
					SET nombre='$nombre'
					WHERE a.nombre_usuario='$user'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $sql = "UPDATE consultor_tis as a
					SET apellido='$apellido'
					WHERE a.nombre_usuario='$user'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $sql = "UPDATE consultor_tis as a
					SET telefono='$telfFijo'
					WHERE a.nombre_usuario='$user'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $sql = "UPDATE usuario as a
					SET email='$eMail'
					WHERE a.nombre_usuario='$user'";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

			$nom=$nombre;
			$ape=$apellido;
			$telf=$telfFijo;
			$mail=$eMail;
	        ?>
	   <?php }
	}
	else{
		$usuario=NULL;
		$apellido=NULL;
		$nombre=NULL;
		$telfFijo=NULL;
		$eMail=NULL;
	}
	/*----------------------FIN VALIDAR REGISTRO------------------------*/
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href='<?php echo $pag_ini; ?>'> Home <?php echo $quien_ingresa; ?> </a><span class="divider">/</span>
					</li>
					<li>
						<a href='info_consultor.php?value=<?php echo $quien; ?>'> Informaci&oacute;n del usuario </a><span class="divider">/</span>
					</li>
					<li>
						<a href='modificar_registro_consultor.php?value=<?php echo $quien; ?>'> Modificar registro </a>
					</li>				
				</ul>
			</div>
			<center><h3>Modificar registro Consultor TIS</h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de modificaci&oacute;n</h2>					
						</div>
						<div class="box-content" id="formulario">
						</br>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="modificar_registro_consultor.php" accept-charset="utf-8">
								<fieldset>
								
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre" name="firstname" id="firstname" value='<?php echo $nom; ?>' >
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" id="lastname" value='<?php echo $ape; ?>'>
								  </div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="pass">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" id="telf" value='<?php echo $telf; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail" name="email"  id="email" value='<?php echo $mail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar Cambios</button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
								</form>
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->	
			</div>

<?php include('footer.php'); ?>
