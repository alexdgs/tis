<?php
session_start();
/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
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
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
include("conexion/verificar_integrantes.php");
include("conexion/verificar_gestion.php");
if(!$cantidad_valida && isset($_POST['enviar'])){
		$error=false;
		/*VALORES de usuario*/
		$usuario=$_POST['username'];
		$clave=$_POST['password']; /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
		$eMail=$_POST['email'];
		/*VALORES de integrante*/
		$cod_sis = $_POST['codSIS'];
		$nombre_rep = $_POST['firstname'];
		$apellido_rep = $_POST['lastname'];
		$telefono_rep = $_POST['telf'];
		$carrera_rep = $_POST['choose_carrera'];
		if (isset($_POST['roles'])) {
			$roles = $_POST['roles'];
			if (sizeof($roles)==0) {
				$error=true;
				$error_rol="Debe seleccionar m&iacute;nimamente un rol";
			}
		}
		else{
			$error=true;
			$error_rol="Debe seleccionar m&iacute;nimamente un rol";
		}
		if ($carrera_rep=='-1' ) {
			$error=true;
			$error_carrera="Debe seleccionar una carrera";
		}
		$consulta_usuario = mysql_query("SELECT nombre_usuario from usuario 
		                          where nombre_usuario='$usuario'",$conn)
		                          or die("Could not execute the select query.");
		$consulta_email = mysql_query("SELECT email from usuario 
		                         where email='$eMail'",$conn)
		                         or die("Could not execute the select query.");
		
		$consulta_cod = mysql_query("SELECT codigo_sis from integrante
		                         where codigo_sis='$cod_sis'",$conn)
		                         or die("Could not execute the select query."); 



		$resultado_usuario = mysql_fetch_assoc($consulta_usuario);
		$resultado_email = mysql_fetch_assoc($consulta_email);
		$resultado_cod = mysql_fetch_assoc($consulta_cod);
		
		  if(is_array($resultado_usuario) && !empty($resultado_usuario))//ya existe usuario o email
		    {     
			      if ($resultado_usuario['nombre_usuario']==$usuario) { 
			              $error_user="El usuario ya esta registrado";
			              $error=true;
			       }   
	      
		     }
		   if(is_array($resultado_email) && !empty($resultado_email)){
		     	if ($resultado_email['email']==$eMail) {
			              $error_email="El correo electr&oacute;nico ya esta registrado";
			              $error=true;
			      } 
		   }
		   if(is_array($resultado_cod) && !empty($resultado_cod)){
		     	if ($resultado_cod['codigo_sis']==$eMail) {
			              $error_cod="El integrante ya est&aacute; registrado";
			              $error=true;
			      } 
		   }

		   if(!$error){/*SI NO HAY NINGUN ERROR REGISTRO*/
		   		/*INSERTAR EL USUARIO*/
		        $sql = "INSERT INTO usuario (nombre_usuario, clave, email, tipo_usuario, habilitado,gestion)
		                VALUES ('$usuario','$clave','$eMail',5,1,$id_gestion)";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
		        /*INSERTAR AL INTEGRANTE*/
		   		$sql = "INSERT INTO integrante (nombre, apellido, telefono,codigo_sis,carrera,grupo_empresa,nombre_usuario)
		                VALUES ('$nombre_rep','$apellido_rep','$telefono_rep','$cod_sis',$carrera_rep,'$nombre_usuario','$usuario')";
		        $result = mysql_query($sql,$conn) or die(mysql_error());
		        $consulta_int = mysql_query("SELECT id_integrante from integrante 
		                         where codigo_sis='$cod_sis'",$conn)
		                         or die("Could not execute the select query.");
		        $resultado_int = mysql_fetch_assoc($consulta_int); 
		        $id_integrante=$resultado_int['id_integrante'];
		        for ($i=0; $i < sizeof($roles) ; $i++) { 
		        	$id_rol=(int)$roles[$i];
		        	$sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($id_integrante,$id_rol)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());

		        } 
		       	header('Location: valido.php?value=4');
		   }
		}
		else{
			$usuario=NULL;
			$nombre_corto=NULL;
			$eMail=NULL;
			$nombre_rep=NULL;
			$apellido_rep=NULL;
			$cod_sis=NULL;
			$telefono_rep=NULL;
		}



$titulo="P&aacute;gina de inicio Grupo Empresas";
include('header.php'); ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_grupo.php">Home Grupo Empresa</a>
					</li>				
				</ul>
			</div>
			<center><h3>Bienvenida Grupo Empresa</h3></center>
			<?php if (!$cantidad_valida) { ?>
			<div class="row-fluid">
				<div class="box span12 ">
					<div class="box-header well">
					<h2><i class="icon-warning-sign"></i> Importante: Agregar Integrante a la Grupo Empresa</h2>					
					</div>
					<div class="box-content" id="formulario">
						Para que su Grupo Empresa quede completamente habilitada debe agregar por lo menos <b><?php echo $cantidad_faltante; ?> integrantes m&aacute;s</b>.
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="home_grupo.php">
							<fieldset>
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username" value='<?php echo $usuario; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_user)){ echo $error_user; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Confirmar Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Confirmar Contrase&ntilde;a" name="confirm_password" id="confirm_password">
								  </div>
								</div>
								<div class="control-group" >
								  <label class="control-label"  for="pass">C&oacute;digo SIS: </label>
								  <div class="controls">
									<input type="text" placeholder="C&oacute;digo SIS" name="codSIS" id="codSIS" class="codigos"value='<?php echo $cod_sis; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_cod)){ echo $error_cod; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre del representate" class="firstnames" name="firstname" id="firstname" value='<?php echo $nombre_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value='<?php echo $apellido_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono fijo" class="telefonos" name="telf" id="telf" value='<?php echo $telefono_rep; ?>'>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail de la Grupo-Empresa" name="email"  id="email" value='<?php echo $eMail; ?>'>
									<label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Carrera: </label>
								  <div class="controls">
									<select id="choose_carrera" name="choose_carrera" data-rel="chosen">
										<option value="-1">-- Seleccione una carrera --</option>
										<?php
			                               $consulta_carrera = "SELECT *
														FROM carrera";
			                               $resultado_carrera = mysql_query($consulta_carrera);
			                                while($row_sociedad = mysql_fetch_array($resultado_carrera)) {
			                               		echo "<option value=\"".$row_sociedad['id_carrera']."\">".$row_sociedad['nombre_carrera']."</option>";
			                                }

			                             ?>
								  	</select>
								  	<label id="error_user" class="error"><?php if(isset($error_carrera)){ echo $error_carrera; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Roles del integrante: </label>
								  <div class="controls">
									<select name="roles[]" multiple data-rel="chosen">
										<?php
			                               $consulta_carrera = "SELECT id_rol, nombre
														FROM rol";
			                               $resultado_carrera = mysql_query($consulta_carrera);
			                                while($row_sociedad = mysql_fetch_array($resultado_carrera)) {
			                               		echo "<option value=\"".$row_sociedad['id_rol']."\">".$row_sociedad['nombre']."</option>";
			                                }

			                             ?>
									  </select>
									<label id="error_user" class="error"><?php if(isset($error_rol)){ echo $error_rol; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Agregar Integrante</button>
								 <button type="reset" class="btn">Restablecer</button>
								 </div>
								 </div>
						        </fieldset>
								</form>	
								</div>
							</div>
						</div>
			 	
			<?php }
			else{ ?>
				<div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Informacion</h2>
						</div>
						<div class="box-content alerts">
								Bienvenida Grupo Empresa a la <b>Gesti&oacute;n <?php echo $nombre_gestion; ?></b>, en este sitio usted podr&aacute; administrar las
								actividades de su Grupo Empresa,tambi&eacute;n la entrega de los sobres A y B, entregar su producto, etc.<br>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
				<?php 
				if ($numero_integrantes<5) { ?>
					<div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-plus-sign"></i> Nota</h2>
						</div>
						<div class="box-content alerts">
								Si usted desea puede agregar <b><?php echo $cantidad_faltante; ?> integrantes m&aacute;s <a href="agregar_integrante.php">aqu&iacute;.</a> </b><br>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
				<?php }	
			}

			 include('footer.php'); ?>