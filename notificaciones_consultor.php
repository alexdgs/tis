<?php
session_start();
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
					<?php
					include('conexion/conexion.php');
											$consulta = "SELECT g.nombre_usuario, a.enlace_entregable e1, b.enlace_entregable e2, g.nombre_largo
											FROM notificacion n, grupo_empresa g, avance_semanal a, avance_semanal b
											WHERE n.usuario in (SELECT nombre_usuario 
																FROM grupo_empresa s
																WHERE consultor_tis='$usuario') 
											AND n.tipo_notificacion=1
											And n.usuario=g.nombre_usuario
											AND g.nombre_usuario=a.grupo_empresa AND g.nombre_usuario=b.grupo_empresa
											AND a.titulo_avance='Sobre A' 
											AND b.titulo_avance='Sobre B'
											GROUP BY g.nombre_usuario";
                               $resultado = mysql_query($consulta);
                               $arreglo= mysql_fetch_assoc($resultado);
                               
						if (is_array($arreglo) && !empty($arreglo)) {
							 echo "
							 <div class=\"box-content\">
							<form name=\"form-data\" class=\"form-horizontal cmxform\" method=\"POST\" action=\"conexion/notificaciones_contrato.php\" accept-charset=\"utf-8\">	
							<table class=\"table\">
							  <thead >
								  <tr >
									  <th>Grupo Empresa</th>
									  <th>Sobre A</th>
									  <th>Sobre B</th>
									  <th>Enviar Contrato</th>
									  <th>Rechazar</th>
								  </tr>
							  </thead>
							  <tbody>";
                            
                              $consulta = "SELECT g.nombre_usuario, a.enlace_entregable e1, b.enlace_entregable e2, g.nombre_largo
											FROM notificacion n, grupo_empresa g, avance_semanal a, avance_semanal b
											WHERE n.usuario in (SELECT nombre_usuario 
																FROM grupo_empresa s
																WHERE consultor_tis='$usuario') 
											AND n.tipo_notificacion=1
											And n.usuario=g.nombre_usuario
											AND g.nombre_usuario=a.grupo_empresa AND g.nombre_usuario=b.grupo_empresa
											AND a.titulo_avance='Sobre A' 
											AND b.titulo_avance='Sobre B'
											GROUP BY g.nombre_usuario";
                               $resultado = mysql_query($consulta);
                               
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								 <td ><input type=\"hidden\" id=a".$identi." name=a".$identi." value=\"".$row["nombre_usuario"]."\" > </input>".$row['nombre_largo']."
    								  </td>
    								  <td class=\"center\"> <a href=".$row["e1"]."> <i class=\"icon-download-alt\"></i> Descargar</a></td>
    								  <td class=\"center\"> <a href=".$row["e2"]."> <i class=\"icon-download-alt\"></i> Descargar</a></td>
    								  <td class=\"center\"> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></td>
    								  <td class=\"center\"> <input type=\"checkbox\" id=c".$identi." name=c".$identi."></td>";
                                    
                        		 echo "	</tr> ";
                                 $identi++;
                                }

                             
                                echo "
								</tbody>
								  </table>
								  <div style=\"padding-left:10px;\">
			                      <button name=\"enviar\" type=\"submit\" class=\"btn btn-primary\" id=\"enviar\">Aceptar</button>
			                      </div>
			                    </form>
			                    </div>";
						}
                         else{
                         	echo "
                         	<div class=\"box-content alerts\">
                         	<div align=\"center\">
	                        <h4><i class=\"icon-info-sign\"></i>
	                        No existe ninguna notificaci&oacute;n.</h4>
	                      	</div>
	                      	</div>";
                         }
                      ?>
					
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>