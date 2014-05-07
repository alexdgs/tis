<?php
session_start();

$quien_ingresa="Grupo Empresa";
$pag_ini="home_grupo.php";
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']!=2 && $_SESSION['tipo']!=3))
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

include('conexion/verificar_gestion.php');
if(isset($_POST['enviar'])){
	include('conexion/conexion.php');	
	$descripcionA=$_POST['descripcionA'];
	$usuario=$_SESSION['nombre_usuario'];
	$errorA=false;
	/*SUBIDA DEL ARCHIVO ADJUNTO SOBRE A*/
	$contrato="";
   	$tiene_doc=0;
    $ext_permitidas = array('.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx');
	   if(!empty($_FILES['contrato']['name'])){
	   		$idUnico = time();

            $nombre_archivo = $_FILES['contrato']['name'];
            $nombre_tmp = $_FILES['contrato']['tmp_name'];
            $ext = substr($nombre_archivo, strpos($nombre_archivo, '.'));
            $tamano = $_FILES['contrato']['size'];             
            $limite = 1000 * 1024;
            if(in_array($ext, $ext_permitidas)){
            	if( $tamano <= $limite ){
                    if( $_FILES['contrato']['error'] <= 0 ){
                    	if( file_exists( 'archivos/'.str_replace(" ", "_", $usuario).'-'.'Contrato'.$ext)){
                              $error_docA='El archivo ya existe';
                              $errorA=true;
                        }
                        else{ 
                             move_uploaded_file($nombre_tmp, 'archivos/'.str_replace(" ", "_", $usuario).'-'.'Contrato'.$ext);
                             $contrato='archivos/'.str_replace(" ", "_", $usuario).'-'.'Contrato'.$ext;
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
   		$error_docA='No se subio el Contrato';
   		$errorA=true;
   	}


	

		if(!$errorA){
	      
            $sql = "INSERT INTO documento_consultor(nombre_documento, descripsion_documento, ruta_documento, fecha_documento, documento_jefe, consultor_tis, gestion)
	                VALUES ('Contrato','$descripcionA','$contrato', NOW(), 0, '$usuario',$id_gestion)";
	        $result = mysql_query($sql,$conn) or die(mysql_error());
	        header("Location: index.php");
		}
	}
	else{
		$descripcionA=NULL;
		$descripcionB=NULL;
		$sobreA=NULL;
		$sobreB=NULL;
		$usuario=NULL;
	}

$titulo="Publicar Contrato";
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
						<a href="subir_grupo_empresa.php">Publicar Contrato</a>
					</li>				
				</ul>
			</div>
			<center><h3>Publicar Contrato</h3></center>
			<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-edit"></i> Formulario de publicaci&oacute;n de Contrato</h2>
					</div>
					<div class="box-content">
						<?php if (!empty($id_gestion)){
						?>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_contrato.php" accept-charset="utf-8">
								<fieldset>
								<div class="control-group">
									<label class="control-label" for="descripcion">Descripci&oacute;n Contrato:</label>
									<div class="controls">
										<textarea id="descripcionA" placeholder="Descripci&oacute;n del contrato" name="descripcionA" ><?php echo $descripcionA; ?></textarea>
									</div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Contrato:</label>
								  <div class="controls">
									<input class="input-file uniform_on" name="contrato" id="contrato"  type="file" />
									<label class="error"><?php if(isset($error_docA)){ echo $error_docA; } ?></label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Publicar Contrato</button>
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