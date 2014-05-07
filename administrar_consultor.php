<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
    if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=1)
    {/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
            $home="";
            switch  ($_SESSION['tipo']){
                    
                    case (2) :
                        $home="home_consultor_jefe.php";
                        break;
                    case (3) :
                         $home="home_consultor.php";
                         break;
                    case (4) :
                         $home="home_grupo.php";
                         break;
                    case (5) :
                        $home="home_integrante.php";
                        break;                                                                     
                  }   
            header("Location: ".$home);
    }
    elseif(!isset($_SESSION['nombre_usuario'])){
        header("Location: index.php");
    }
/*----------------------FIN VERIFICACION------------------------------------*/

$titulo="Administrar Consultores TIS";
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
						<a href="home_admin.php">Administrar Consultores TIS</a>
					</li>
				</ul>
			</div>
			<center><h3>Administrar Consultores TIS</h3></center>
			<div class="row-fluid">
		            <div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Consultores TIS registrados</h2>

					</div>
					<div class="box-content">
                       <form method="post" action="conexion/admin_consultor.php" accept-charset="utf-8">
						<table class="table table-striped">
						  <thead >
							  <tr >
								  <th>Usuario</th>
								  <th>Contrase&ntilde;a</th>
								  <th>Correo electr&oacute;nico</th>
								  <th>Curr&iacute;culo</th>
								  <th>Jefe Consultor</th>
                                  <th>Habilitado</th>
							  </tr>
						  </thead>
						  <tbody>
                            <?php
                              include('conexion/conexion.php');
                               $consulta = "SELECT u.nombre_usuario,clave,email,ruta_curriculum,tipo_usuario,habilitado
                                            FROM usuario u,consultor_tis c
                                            WHERE u.nombre_usuario = c.nombre_usuario";
                               $resultado = mysql_query($consulta);
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {
                               echo "
                                <tr>
    								 <td ><input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row["nombre_usuario"]." > </input>".$row['nombre_usuario']."
    								  </td>
    								<td>".$row["clave"]."</td>
    								<td >".$row["email"]."</td>  ";
                                       $aux= $row["ruta_curriculum"];
                                         if(empty($aux)){
                                             echo "  <td >No</td>  ";
                                         }
                                         else{
                                         echo " <td class=\"center\"> <a href=".$row["ruta_curriculum"]."> <i class=\"icon-download-alt\"></i> Descargar</a></td>";
                                         }
                                       $aux= $row["tipo_usuario"];
                                        if($aux=="2"){
                                           echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                        }
                                        $aux= $row["habilitado"];
                                        if($aux=="1"){
                                           echo "<td class=\"center\"><center> <input type=\"checkbox\" id=c".$identi." name=c".$identi." checked></center></td>";
                                         }
                                         else{
                                            echo "<td class=\"center\"><center> <input type=\"checkbox\" id=c".$identi." name=c".$identi."></center></td>";
                                        }
                        		 echo "	</tr> ";
                                 $identi++;
                                }

                             ?>

						  </tbody>
					  </table>
					  <div style="padding-left:10px;">
                      <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Guardar cambios</button>
                      </div>
                    </form>



					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>