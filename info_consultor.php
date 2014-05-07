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
/*----------------------FIN VERIFICACION------------------------------------*/

$titulo="Informacion del ".$quien_ingresa; 
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
						<a href='info_consultor.php?value=<?php echo $quien; ?>'> Informaci&oacute;n del usuario </a>
					</li>				
				</ul>
			</div>
			<center><h3>Informaci&oacute;n Consultor TIS</h3></center>
			<div class="row-fluid">
				<div class="box span12 center" id="print">
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Informaci&oacute;n del usuario: <?php echo $nombre_usuario; ?></h2>					
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
							<?php 
								include('conexion/conexion.php');
								$consulta_usuario = mysql_query("SELECT usuario.nombre_usuario,nombre,apellido,telefono,usuario.email,tiene_curriculum,ruta_curriculum,usuario.habilitado
																FROM usuario, consultor_tis
																WHERE usuario.nombre_usuario='$nombre_usuario' AND usuario.nombre_usuario=consultor_tis.nombre_usuario",$conn)
	                          					or die("Could not execute the select query.");

								$resultado = mysql_fetch_assoc($consulta_usuario);
								if(is_array($resultado) && !empty($resultado))
								{	
										$nombre= $resultado['nombre'];
										$apellido= $resultado['apellido'];
										$telefono= $resultado['telefono'];
										$email= $resultado['email'];
										if($resultado['tiene_curriculum']==1){
											$ruta_curriculum= $resultado['ruta_curriculum'];
										}
										if($resultado['habilitado']=1){
										$habilitado= "Si";	}
										else{
											$habilitado="No";
										}		
								}
								else{
									echo "<h4>No se Encontro ning&uacute;n registro";
								} ?>
								<table class="table table-striped">
								  	<tbody>
									<tr>
										<td><strong>Nombre de Usuario: </strong></td>
										<td class="center"><?php echo $nombre_usuario; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Nombre: </strong></td>
										<td class="center"><?php echo $nombre; ?></td>                                       
									</tr>
									<tr>
										<td><strong>Apellido: </strong></td>
										<td class="center"><?php echo $apellido; ?></td>                                      
									</tr>
									<tr>
										<td><strong>Tel&eacute;fono: </strong></td>
										<td class="center"><?php echo $telefono; ?></td>                                     
									</tr>
									<tr>
										<td><strong>Correo electr&oacute;nico: </strong></td>
										<td class="center"><?php echo $email; ?></td>                          
									</tr>
									<tr>
										<td><strong>Curr&iacute;culo: </strong></td>
										<td class="center"><?php if(isset($ruta_curriculum)){
										 echo "<a href=\" ".$ruta_curriculum."\"> <i class=\"icon-download-alt\"></i> Ver Curr&iacute;culo</a>"; }
										 else{
										 	echo "No disponible";
										 } ?></td>                          
									</tr>
									<tr>
										<td><strong>Habilitado: </strong></td>
										<td class="center"><?php echo $habilitado; ?></td>                          
									</tr>                                    
								  </tbody>
						 </table>
						 <div class="row-fluid">
							 <div class="span12" style="padding:10px;">  
							 	<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
								<a href="modificar_registro_consultor.php?value=<?php echo $quien; ?>"	 type="button" class="btn">Modificar Registro</a>
							</div>
						</div>
		                </div>
				</div>
			</div>
<?php include('footer.php'); ?>
