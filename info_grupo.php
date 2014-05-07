<?php
session_start();

$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";

/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']==2 || $_SESSION['tipo']==1 || $_SESSION['tipo']==3))
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
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
/*----------------------FIN VERIFICACION------------------------------------*/

$titulo="Informacion de la Grupo Empresa"; 
include('header.php');
 ?>
<script type="text/javascript">
	function imprimir(){
  var objeto=document.getElementById('print');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento

  	var css = ventana.document.createElement("link");
	css.setAttribute("href", "css/style.css");
	css.setAttribute("rel", "stylesheet");
	css.setAttribute("type", "text/css");
	ventana.document.head.appendChild(css);


  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}

</script>


			<div>
				<ul class="breadcrumb">					
					<li>
						<a href="index.php">Inicio</a><span class="divider">/</span>
					</li>
					<li>
						<a href='info_grupo.php'> Informaci&oacute;n de usuario </a>
					</li>				
				</ul>
			</div>
			<center><h3>Informaci&oacute;n de la Grupo Empresa</h3></center>
			<div class="row-fluid">
				<div class="box span12 " id="print">
					<?php if ($_SESSION['tipo']==5) { ?>
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Informaci&oacute;n del integrante: <?php echo $nombre_usuario; ?></h2>					
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
							<?php 
								include('conexion/conexion.php');
								$consulta_int = mysql_query("SELECT id_integrante,nombre, apellido, telefono, codigo_sis, nombre_carrera, usuario.nombre_usuario, email,habilitado, grupo_empresa from integrante, usuario, carrera where integrante.nombre_usuario='$nombre_usuario' and  usuario.nombre_usuario=integrante.nombre_usuario AND carrera=carrera.id_carrera",$conn)
	                          					or die("Could not execute the select query.");

								$resultado_int = mysql_fetch_assoc($consulta_int);
								$grupo_empresa = $resultado_int['grupo_empresa'];
								$consulta_usuario = mysql_query("SELECT nombre_largo, nombre_corto, email, abreviatura, consultor_tis.nombre,consultor_tis.apellido, habilitado
																FROM grupo_empresa, usuario, sociedad, consultor_tis
																WHERE grupo_empresa.nombre_usuario=usuario.nombre_usuario AND grupo_empresa.sociedad=sociedad.id_sociedad AND grupo_empresa.consultor_tis=consultor_tis.nombre_usuario AND grupo_empresa.nombre_usuario='$grupo_empresa'",$conn)
	                          					or die("Could not execute the select query.");

								$resultado = mysql_fetch_assoc($consulta_usuario);
								if(is_array($resultado) && !empty($resultado))
								{	
										$nombre_largo=$resultado['nombre_largo'];
										$nombre_corto=$resultado['nombre_corto'];
										$email= $resultado['email'];
										$sociedad=$resultado['abreviatura'];
										$nombre_cons=$resultado['nombre'];
										$apellido_cons=$resultado['apellido'];
										if($resultado['habilitado']=1){
										$habilitado= "Si";	}
										else{
											$habilitado="No";
										}
										?>
										<br>
									<table class="table table-striped">
										<thead>
										<th>
											<h4>Grupo Empresa</h4>
										</th>
									</thead>
								  	<tbody>
									<tr>
										<td><strong>Nombre largo: </strong></td>
										<td class="center"><?php echo $nombre_largo." ".$sociedad; ?></td>                                       
									</tr>
									<tr>
										<td><strong>Nombre corto: </strong></td>
										<td class="center"><?php echo $nombre_corto." ".$sociedad; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Correo electr&oacute;nico: </strong></td>
										<td class="center"><?php echo $email; ?></td>                                     
									</tr>
									<tr>
										<td><strong>Consultor TIS: </strong></td>
										<td class="center"><?php echo $nombre_cons." ".$apellido_cons; ?></td>                          
									</tr>
									<tr>
										<td><strong>Habilitado: </strong></td>
										<td class="center"><?php echo $habilitado; ?></td>                          
									</tr>                                    
								 	<tr>
										<td><br><br><h4>Integrante:</h4></td>
										<td></td>
									</tr>
								  	<tr>
										<td><strong>Nombre de Usuario: </strong></td>
									<td class="center"><?php echo $nombre_usuario; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Nombre: </strong></td>
										<td class="center"><?php echo $resultado_int['nombre']; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Apellido: </strong></td>
										<td class="center"><?php echo $resultado_int['apellido']; ?></td>                                       
									</tr>
									<tr>
										<td><strong>Tel&eacute;fono: </strong></td>
										<td class="center"><?php echo $resultado_int['telefono']; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Correo electr&oacute;nico: </strong></td>
										<td class="center"><?php echo $resultado_int['email']; ?></td>                                     
									</tr>
									<tr>
										<td><strong>C&oacute;digo SIS: </strong></td>
										<td class="center"><?php echo $resultado_int['codigo_sis']; ?></td>                          
									</tr>
									<tr>
										<td><strong>Carrera: </strong></td>
										<td class="center"><?php echo $resultado_int['nombre_carrera']; ?></td>                          
									</tr>
									<tr>
										<td><strong>Habilitado: </strong></td>
										<td class="center"><?php if($resultado_int['habilitado']=1){
															echo "Si";	}
															else{
																echo "No";
															} ?>
										</td>                          
									</tr>                                     
								  </tbody>
						 		</table>

								<?php		
								}
								else{
									echo "<center><h4>No se Encontro ning&uacute;n registro</center>";
								} ?>
						 <div class="row-fluid">
							 <div class="span12" style="padding:10px;">  
							 	<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
								
							</div>
						</div>
		                </div>
		                <?php }
		                elseif($_SESSION['tipo']==4) { ?>
		                	<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Informaci&oacute;n de la Grupo Empresa</h2>					
						</div>
						<div class="box-content padding-in"  >
							<?php 
								include('conexion/conexion.php');
								$consulta_usuario = mysql_query("SELECT  nombre_largo, nombre_corto, email, abreviatura, consultor_tis.nombre,consultor_tis.apellido, habilitado
																FROM grupo_empresa, usuario, sociedad, consultor_tis
																WHERE grupo_empresa.nombre_usuario=usuario.nombre_usuario AND grupo_empresa.sociedad=sociedad.id_sociedad AND grupo_empresa.consultor_tis=consultor_tis.nombre_usuario AND grupo_empresa.nombre_usuario='$nombre_usuario'",$conn)
	                          					or die("Could not execute the select query.");

								$resultado = mysql_fetch_assoc($consulta_usuario);
								$consulta_representante = mysql_query("SELECT id_integrante,nombre, apellido, telefono, codigo_sis, nombre_carrera, usuario.nombre_usuario, email,habilitado from integrante, usuario, carrera where integrante.nombre_usuario='$nombre_usuario' and  usuario.nombre_usuario=integrante.nombre_usuario AND carrera=carrera.id_carrera",$conn)
	                          					or die("Could not execute the select query.");

								$resultado_representante = mysql_fetch_assoc($consulta_representante);
								if(is_array($resultado) && !empty($resultado) && is_array($resultado_representante) && !empty($resultado_representante) )
								{	
										$nombre_largo=$resultado['nombre_largo'];
										$nombre_corto=$resultado['nombre_corto'];
										$email= $resultado['email'];
										$sociedad=$resultado['abreviatura'];
										$nombre_cons=$resultado['nombre'];
										$apellido_cons=$resultado['apellido'];
										if($resultado['habilitado']=1){
										$habilitado= "Si";	}
										else{
											$habilitado="No";
										}
										?>
										<br>
									<table class="table table-striped">
									<thead>
										<th>
											<h4>Grupo Empresa</h4>
										</th>
									</thead>
								  	<tbody>
									<tr>
										<td><strong>Nombre largo: </strong></td>
										<td class="center"><?php echo $nombre_largo." ".$sociedad; ?></td>                                       
									</tr>
									<tr>
										<td><strong>Nombre corto: </strong></td>
										<td class="center"><?php echo $nombre_corto." ".$sociedad; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Correo electr&oacute;nico: </strong></td>
										<td class="center"><?php echo $email; ?></td>                                     
									</tr>
									<tr>
										<td><strong>Consultor TIS: </strong></td>
										<td class="center"><?php echo $nombre_cons." ".$apellido_cons; ?></td>                          
									</tr>
									<tr>
										<td><strong>Habilitado: </strong></td>
										<td class="center"><?php echo $habilitado; ?></td>                          
									</tr>                                    

									<tr>
										<td><br><br><h4>Representante Legal:</h4></td>
										<td></td>
									</tr>	
						 		
								
								  	<tr>
										<td><strong>Nombre de Usuario: </strong></td>
										<td class="center"><?php echo $nombre_usuario; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Nombre: </strong></td>
										<td class="center"><?php echo $resultado_representante['nombre']; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Apellido: </strong></td>
										<td class="center"><?php echo $resultado_representante['apellido']; ?></td>                                       
									</tr>
									<tr>
										<td><strong>Tel&eacute;fono: </strong></td>
										<td class="center"><?php echo $resultado_representante['telefono']; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Correo electr&oacute;nico: </strong></td>
										<td class="center"><?php echo $resultado_representante['email']; ?></td>                                     
									</tr>
									<tr>
										<td><strong>C&oacute;digo SIS: </strong></td>
										<td class="center"><?php echo $resultado_representante['codigo_sis']; ?></td>                          
									</tr>
									<tr>
										<td><strong>Carrera: </strong></td>
										<td class="center"><?php echo $resultado_representante['nombre_carrera']; ?></td>                          
									</tr>
									<tr>
										<td><strong>Habilitado: </strong></td>
										<td class="center"><?php echo $habilitado; ?></td>                          
									</tr>                                     
								  </tbody>
						 		</table>

								<?php }
								else{
									echo "<center><h4>No se Encontro ning&uacute;n registro</h4></center>";
								} ?>
								
						 <div class="row-fluid">
							 <div class="span12" style="padding:10px;">  
							 	<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
								
							</div>
						</div>
		                </div>
		               <?php } ?>
				</div>
			</div>
<?php include('footer.php'); ?>
