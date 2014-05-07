<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
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
	          }   
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/

						 

$titulo="Notificaciones";
$usuario=$_SESSION['nombre_usuario'];
include('header.php');
 ?>
 			<!--PARTICIONAR
 			<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
			</li>-->
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_admin.php">Notificaciones</a>
					</li>
				</ul>
			</div>
			<center><h3>Notificaciones</h3></center>
			<div class="row-fluid">
		            <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Notificaciones</h2>

					</div>
					
					
					<div class="box-content">
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/notificaciones_resp_contrato.php" accept-charset="utf-8">	
						<table class="table">
						  <thead >
							  <tr >
								  <th>Tipo Notificaci&oacute;n</th>
								  <th>Fuente</th>
								  <th>Enlace Documento</th>
								  <th>Le&iacute;do</th>
								  
							  </tr>
						  </thead>
						  <tbody>
						  	<input type="hidden" id="usuario" name="usuario" value=<?php echo $nombre_usuario ?> ></input>
                           <?php 
                              include('conexion/conexion.php');
                               $consulta = "SELECT n.tipo_notificacion, t.descripcion, c.nombre, c.apellido, d.ruta_documento, n.leido
											FROM notificacion n, tipo_notificacion t, grupo_empresa g, consultor_tis c, documento_consultor d
											WHERE n.usuario='$usuario'
											AND n.tipo_notificacion = t.id_tipo_notificacion
											AND (n.tipo_notificacion=2 OR n.tipo_notificacion=3)
											AND n.usuario=g.nombre_usuario
											AND g.consultor_tis=c.nombre_usuario
											AND c.nombre_usuario=d.consultor_tis
											AND d.nombre_documento='Contrato'";
                               $resultado = mysql_query($consulta);
                               $identi=0;
                               
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
                                	  <input type=\"hidden\" id=c".$identi." name=c".$identi." value=".$row["tipo_notificacion"]."></input>
    								  <td >".$row["descripcion"]."</td>
    								  <td >".$row["nombre"]." ".$row["apellido"]."</td>";
    								  if ($row["tipo_notificacion"] == 2) {
	    								  	echo"
	    								  <td class=\"center\"> <a href=".$row["ruta_documento"]."> <i class=\"icon-download-alt\"></i> Descargar</a></td>";
	    							  }
	    							  elseif($row["tipo_notificacion"] == 3)
	    							  {
	    							  		echo "
	    								  <td >".'No'."</td>";
	    							  }
    							
                                       $aux= $row["leido"];
                                        if($aux=="1"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                        } 
                                        
                        		 echo "	</tr> ";
                                 $identi++;
                                }

                            ?>
                                
						  </tbody>
					  </table>
					  <div style="padding-left:10px;">
                      <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar</button>
                      </div>
                    </form>
                    </div>

				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>