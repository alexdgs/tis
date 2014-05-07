<?php
session_start();
$quien_ingresa="Grupo Empresa";
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
include ('conexion/verificar_gestion.php');
/*--------------------------------VALIDAR REGISTRO------------------------------------*/
	if(isset($_POST['enviar'])){
		$error=false;
		/*VALORES GRUPO EMPRESA*/
		$usuario=$_POST['username'];
		$clave=$_POST['password']; /*$clave = md5($pass); QUITADO ==> CONTRASEÑA SIMPLE*/
		$nombre_largo=$_POST['lname'];
		$nombre_corto=$_POST['sname'];
		$sociedad=$_POST['choose_sociedad'];
		$eMail=$_POST['email'];
		$consultor=$_POST['choose_consultor'];
		/*VALORES REPRESENTANTE LEGAL*/
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

		if ($sociedad=='-1' ) {
			$error=true;
			$error_sociedad="Debe seleccionar una sociedad para su Grupo Empresa";
		}
		if ($consultor=='-1' ) {
			$error=true;
			$error_consultor="Debe seleccionar una Consultor para su Grupo Empresa";
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
		$consulta_nl = mysql_query("SELECT nombre_largo from grupo_empresa 
		                         where nombre_largo='$nombre_largo'",$conn)
		                         or die("Could not execute the select query.");
		$consulta_nc = mysql_query("SELECT nombre_corto from grupo_empresa 
		                         where nombre_corto='$nombre_corto'",$conn)
		                         or die("Could not execute the select query.");
		$consulta_cod = mysql_query("SELECT codigo_sis from integrante
		                         where codigo_sis='$cod_sis'",$conn)
		                         or die("Could not execute the select query."); 



		$resultado_usuario = mysql_fetch_assoc($consulta_usuario);
		$resultado_email = mysql_fetch_assoc($consulta_email);
		$resultado_nl = mysql_fetch_assoc($consulta_nl);
		$resultado_nc = mysql_fetch_assoc($consulta_nc);
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
		   if(is_array($resultado_nl) && !empty($resultado_nl)){
		     	if ($resultado_nl['nombre_largo']==$eMail) {
			              $error_nl="El nombre largo para ya esta registrado";
			              $error=true;
			      } 
		   }
		   if(is_array($resultado_nc) && !empty($resultado_nc)){
		     	if ($resultado_nc['nombre_corto']==$eMail) {
			              $error_nc="El nombre corto ya esta registrado";
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
		                VALUES ('$usuario','$clave','$eMail',4,0,$id_gestion)";
		        $result = mysql_query($sql,$conn) or die(mysql_error());

		        /*INSERTAR LA GRUPO EMPRESA*/
		        $sql = "INSERT INTO grupo_empresa (nombre_usuario, nombre_largo, nombre_corto, consultor_tis,rep_legal,sociedad)
		                VALUES ('$usuario','$nombre_largo','$nombre_corto','$consultor',NULL,'$sociedad')";
		        $result = mysql_query($sql,$conn) or die(mysql_error());


		   		/*INSERTAR AL INTEGRANTE*/
		   		$sql = "INSERT INTO integrante (nombre, apellido, telefono,codigo_sis,carrera,grupo_empresa,nombre_usuario)
		                VALUES ('$nombre_rep','$apellido_rep','$telefono_rep','$cod_sis',$carrera_rep,'$usuario','$usuario')";
		        $result = mysql_query($sql,$conn) or die(mysql_error());

		        /*BUSCAR LA el id del integrante*/
		        $consulta_rep = mysql_query("SELECT id_integrante from integrante 
		                         where nombre_usuario='$usuario'",$conn)
		                         or die("Could not execute the select query.");
		        $resultado_rep = mysql_fetch_assoc($consulta_rep); 
		        $rep_legal=(int)$resultado_rep['id_integrante'];
		        
		        /*ACTUALIZAR la grupo empresa*/
		        $sql = "UPDATE grupo_empresa SET  rep_legal=$rep_legal WHERE nombre_usuario = '$usuario'";
                $result = mysql_query($sql);

                for ($i=0; $i < sizeof($roles) ; $i++) { 
		        	$id_rol=(int)$roles[$i];
		        	$sql = "INSERT INTO rol_integrante (integrante,rol)
		                VALUES ($rep_legal,$id_rol)";
		       		$result = mysql_query($sql,$conn) or die(mysql_error());

		        } 
		       	header('Location: valido.php?value=4');
		   }
		}
		else{
			$usuario=NULL;
			$nombre_largo=NULL;
			$nombre_corto=NULL;
			$eMail=NULL;
			$nombre_rep=NULL;
			$apellido_rep=NULL;
			$cod_sis=NULL;
			$telefono_rep=NULL;
		}
	$titulo="Registro ".$quien_ingresa;
	include('header.php');
	/*----------------------FIN VALIDAR REGISTRO------------------------*/
 ?>
			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href="registro_grupo.php">Registro <?php echo $quien_ingresa; ?></a>
					</li>				
				</ul>
			</div>
			<center><h3><?php echo $titulo; ?></h3></center>
			<div class="row-fluid">
				<div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de registro: <?php echo $quien_ingresa; ?></h2>					
						</div>
						<div class="box-content" id="formulario">
						<?php 
						if($gestion_valida){

						?>	
						
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" accept-charset="utf-8" action="registro_grupo.php">
								<fieldset>
								<legend><h5>Datos de la Grupo Empresa</h5></legend>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre largo: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre largo Grupo Empresa" name="lname" id="lname" value='<?php echo $nombre_largo; ?>' >
									<label id="error_user" class="error"><?php if(isset($error_nl)){ echo $error_nl; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre corto: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre Corto Grupo Empresa" name="sname" id="sname" value='<?php echo $nombre_corto; ?>'>
									<label id="error_user" class="error"><?php if(isset($error_nc)){ echo $error_nc; } ?></label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Tipo de Sociedad: </label>
								  <div class="controls">
									<select id="choose_sociedad" name="choose_sociedad" data-rel="chosen">
										<option value="-1">-- Seleccione una sociedad --</option>
										<?php
			                               $consulta_sociedad = "SELECT *
														FROM sociedad";
			                               $resultado_sociedad = mysql_query($consulta_sociedad);
			                                while($row_sociedad = mysql_fetch_array($resultado_sociedad)) {
			                               		echo "<option value=\"".$row_sociedad['id_sociedad']."\">".$row_sociedad['descripcion']."</option>";
			                                }

			                             ?>
								  	</select>
								  	<label id="error_user" class="error"><?php if(isset($error_sociedad)){ echo $error_sociedad; } ?></label>
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
								  <label class="control-label" for="pass">Consultor TIS encargado: </label>
								  <div class="controls">
									<select id="choose_consultor" name="choose_consultor" data-rel="chosen">
									<option value="-1">-- Seleccione un Consultor --</option>
									<?php
		                               $consulta = "SELECT consultor_tis.nombre_usuario, consultor_tis.nombre , consultor_tis.apellido
													FROM consultor_tis, usuario
													WHERE usuario.nombre_usuario=consultor_tis.nombre_usuario AND habilitado=1";
		                               $resultado = mysql_query($consulta);
		                                while($row = mysql_fetch_array($resultado)) {
		                               		echo "<option value=\"".$row['nombre_usuario']."\">".$row['nombre']." ".$row['apellido']."</option>";
		                                }

		                             ?>
								  </select>
								  <label id="error_user" class="error"><?php if(isset($error_consultor)){ echo $error_consultor; } ?></label>
								  </div>
								</div>
								<br>
								<legend><h5>Datos del representate legal</h5></legend>
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
								<div class="control-group">
								  <label class="control-label" for="pass">C&oacute;digo SIS: </label>
								  <div class="controls">
									<input type="text" placeholder="C&oacute;digo SIS" name="codSIS" id="codSIS" value='<?php echo $cod_sis; ?>'>
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
									<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" id="telf" class="telefonos" value='<?php echo $telefono_rep; ?>'>
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
								  <label class="control-label" for="pass">Roles: </label>
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
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Registrar</button>
								 <button type="reset" class="btn">Restablecer</button>
								 </div>
								 </div>
						        </fieldset>
								</form>
								<?php
				                mysql_free_result($resultado_sociedad);
								mysql_free_result($resultado);
				                 }
				                else{
				                	 echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        <strong>No existe ninguna actividad para esta gestion.</strong></h4>
				                      </div>";;
				                } ?>
				              <!--/ELSE DE GESTION-->
		                </div>  
				</div>	
			</div>
<?php 
include('footer.php'); ?>
