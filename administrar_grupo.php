<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
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

$titulo="Administrar Grupo Empresas";

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
						<a href="administrar_integrante.php">Administrar Integrantes</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Integrantes</h3></center>
			<div class="row-fluid">
		            <div class="box span12" id="print">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-check"></i> Habilitar Integrantes</h2>

					</div>
					<div class="box-content">
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_grupo.php" accept-charset="utf-8">	
						<table class="table">
						  <thead >
							  <tr >
								 	  <th>Nombre Largo</th>
									  <th>Nombre Usuario</th>
									  <th>Representante Legal</th>
									  <th>Habilitado</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<input type="hidden" id="consultor" name="consultor" value=<?php echo $nombre_usuario ?> ></input>
                            <?php
                              include('conexion/conexion.php');
                               $integrantes ="SELECT g.nombre_largo, g.nombre_usuario, i.nombre n2, i.apellido a2, u.habilitado
												FROM grupo_empresa g, consultor_tis c, usuario u, integrante i
												WHERE c.nombre_usuario = '$nombre_usuario'
												AND c.nombre_usuario = g.consultor_tis
												AND g.nombre_usuario = u.nombre_usuario
												AND i.nombre_usuario = g.nombre_usuario";
                               $resultado = mysql_query($integrantes);
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td >".$row["nombre_largo"]."</td>
    								  <td><input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row["nombre_usuario"]."></input>".$row["nombre_usuario"]."</td>
    								 
    								  <td>".$row["n2"]." ".$row["a2"]."</td>";
                                        
                                 $aux= $row["habilitado"];
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
					    <div class="control-group">
							
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar Cambios</button>
							
						</div>
                    </form>



					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>