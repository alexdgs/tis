<?php
session_start();
/*------------------VERIFICAR QUE SEAL EL ADMINISTRADOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
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

$titulo="Administrar Integrantes";

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
						<form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_integrante.php" accept-charset="utf-8">	
						<table class="table">
						  <thead >
							  <tr >
								 	  <th>Nombre de Usuario</th>
									  <th>Nombre</th>
									  <th>Apellido</th>
									  <th>Tel&eacute;fono</th>
									  <th>Correo Electr&oacute;nico</th>
									  <th>C&oacute;digo SIS</th>
									  <th>Habilitado</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<input type="hidden" id="grupo" name="grupo" value=<?php echo $nombre_usuario ?> ></input>
                            <?php
                              include('conexion/conexion.php');
                               $integrantes ="SELECT id_integrante, nombre, apellido, telefono, codigo_sis, nombre_carrera, usuario.nombre_usuario, email,habilitado from integrante, usuario, carrera where grupo_empresa='$nombre_usuario' and  usuario.nombre_usuario=integrante.nombre_usuario AND carrera=carrera.id_carrera";
                               $resultado = mysql_query($integrantes);
                               $identi=0;
                                while($row = mysql_fetch_array($resultado)) {

                               echo "
                                <tr>
    								  <td ><input type=\"hidden\" id=a".$identi." name=a".$identi." value=\"".$row["nombre_usuario"]."\" ></input> ".$row["nombre_usuario"]."</td>
    								  <td>".$row["nombre"]."</td>
    								  <td>".$row["apellido"]."</td>
    								  <td>".$row["telefono"]."</td>
    								  <td>".$row["email"]."</td>
    								  <td>".$row["codigo_sis"]."</td> ";
                                        
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
							
						         <button name="enviar" type="submit" class="btn btn-primary" id="enviar">Guardar Cambios</button>
								 <button type="button" class="btn" onclick="imprimir();">Imprimir</button>
							
						</div>
                    </form>



					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>