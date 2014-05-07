<?php
session_start();

$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";

/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
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
if(isset($_POST['enviar'])){
	include('conexion/conexion.php');	
	$descripcionA=$_POST['descripcionA'];
	$descripcionB=$_POST['descripcionB'];
	$sobreA=$_FILES['documentoA'];
	$sobreB=$_FILES['documentoB'];
	$usuario=$_SESSION['nombre_usuario'];
	$errorA=false;
	/*SUBIDA DEL ARCHIVO ADJUNTO SOBRE A*/
	$documentoA="";
   	$tiene_doc=0;
    $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx');
	   if(!empty($_FILES['documentoA']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['documentoA']['name'];
            $nombre_tmp = $_FILES['documentoA']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['documentoA']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['documentoA']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreA'.$ext) ){
                              $error_docA='El archivo ya existe';
                              $errorA=true;
                        }
                        else{ 
                        	 $nombre_tmp_A=$nombre_tmp;
                             $documentoA='archivos/'.$usuario.'-'.'sobreA'.$ext;
                             $tiene_doc=1;
                        }
                     }
                     else{
                     		$error_docA='Error al subir el archivo';
                      		$errorA=true;
                       }
                    }
                else{  
                      $error_docA='El archivo debe un tama&ntilde;o menor a 1 Mega Byte';
                      $errorA=true;
                    }
            }
            else{
            	$errorA=true;
            	$error_docA='El formato del archivo no esta permitido';
            }

   	}
   	else
   	{
   		$error_docA='No se subio el sobre A';
   		$errorA=true;
   	}


	/*FIN ARCHIVO ADJUNTO*/

	/*SUBIDA DEL ARCHIVO ADJUNTO SOBRE B*/
	$errorB=false;
	$documentoB="";
   	$tiene_doc=0;
	   if(!empty($_FILES['documentoB']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['documentoB']['name'];
            $nombre_tmp = $_FILES['documentoB']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['documentoB']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['documentoB']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'sobreB'.$ext) ){
                              $error_docB='El archivo ya existe';
                              $errorB=true;
                        }
                        else{ 
                        	 if(!$errorA)
                        	 {
                        	 	$documentoA = str_replace(" ", "_", $documentoA);
                        	 	$documentoB='archivos/'.$usuario.'-'.'sobreB'.$ext;
                        	 	$documentoB = str_replace(" ", "_", $documentoB);
                        	 	move_uploaded_file($nombre_tmp_A, $documentoA);
                        	 	move_uploaded_file($nombre_tmp, $documentoB);
                             	$tiene_doc=1;
                             	header("Location: subir_grupo_empresa.php");
                             }
                        }
                     }
                     else{
                     		$error_docB='Error al subir el archivo';
                      		$errorB=true;
                       }
                    }
                else{  
                      $error_docB='El archivo debe un tama&ntilde;o menor A 1 Mega Byte';
                      $errorB=true;
                    }
            }
            else{
            	$errorB=true;
            	$error_docB='El formato del archivo no esta permitido';
            }

   	}
   	else
   	{
   		$error_docB='No se subio el sobre B';
   		$errorB=true;
   	}


	/*FIN ARCHIVO ADJUNTO*/

		if(!$errorA && !$errorB){
	      
            $sql = "INSERT INTO avance_semanal(grupo_empresa, fecha_establecida, titulo_avance, desc_avance, enlace_entregable)
	                VALUES ('$usuario', NOW(),'Sobre A', '$descripcionA', '$documentoA')";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        
	        $sql = "INSERT INTO avance_semanal(grupo_empresa, fecha_establecida, titulo_avance, desc_avance, enlace_entregable)
	                VALUES ('$usuario', NOW(),'Sobre B', '$descripcionB', '$documentoB')";
	        $result = mysql_query($sql,$conn) or die(mysql_error());

	        $sql = "INSERT INTO notificacion(tipo_notificacion, usuario, leido)
	                VALUES (1, '$usuario', 0)";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
		}
	}
	else{
		$descripcionA=NULL;
		$descripcionB=NULL;
		$sobreA=NULL;
		$sobreB=NULL;
		$usuario=NULL;
	}

$titulo="Publicar Documentos Grupo Empresa";
include('header.php');
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_grupo.php">Home Grupo Empresa</a><span class="divider">/</span>
					</li>
					<li>
						<a href="subir_grupo_empresa.php">Publicar Documentos</a>
					</li>				
				</ul>
			</div>
			<center><h3>Publicar Documentos</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de publicaci&oacute;n de Documentos</h2>
					</div>
					<div class="box-content">
						<?php if (!empty($id_gestion)){
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_grupo_empresa.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n Sobre A:</label>
									<div class="controls">
										<textarea id="descripcionA" placeholder="Descripci&oacute;n Sobre A" name="descripcionA" ><?php echo $descripcionA; ?></textarea>
									</div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Sobre A:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="documentoA" id="documento"  type="file" />
									<label class="error"><?php if(isset($error_docA)){ echo $error_docA; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n Sobre B:</label>
									<div class="controls">
										<textarea id="descripcionB" placeholder="Descripci&oacute;n Sobre B" name="descripcionB" ><?php echo $descripcionB; ?></textarea>
									</div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Sobre B:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="documentoB" id="documento"  type="file" />
									<label class="error"><?php if(isset($error_docB)){ echo $error_docB; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Publicar</button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
							</form>
							<?php 
								}
								else{
									echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        Debe habilitar una gestion.</h4>
				                      	</div>";
								}
							?>
		                </div>	
				</div><!--/span-->  
			</div><!-- fin row -->
<?php include('footer.php'); ?>