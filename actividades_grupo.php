<?php
session_start();


/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
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
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
include("conexion/verificar_integrantes.php");
$fecha = date("Y-m-d");
$inicio = $fecha;
$fin = $fecha;
if (isset($_POST['enviar'])) {
	$error=false;
	if (isset($_POST['inicio']) && isset($_POST['fin'])) {

		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];

		$ini_dia = substr($inicio, 8);
		$ini_mes = substr($inicio, 5,2);
		$ini_year = substr($inicio, 0,4);

		$fin_dia = substr($fin, 8);
		$fin_mes = substr($fin, 5,2);
		$fin_year = substr($fin, 0,4);
		if(@checkdate($ini_mes, $ini_dia, $ini_year)){
			if (@checkdate($fin_mes, $fin_dia, $fin_year)) {
				if($inicio>=$fecha){//corecto
					if ($fin>$inicio) {//corecto sobreescribir base de datos
                    include('conexion/conexion.php');
                                         $descripcion=$_POST['descripcionG'];
                                         $pago=$_POST['pagos'];
                                         $sql = "INSERT INTO entrega_producto (id_entrega_producto,grupo_empresa,fecha_establecida,descripcion,fecha_entrega,observacion,pago_asociado)
                                                  VALUES (' ','".$_SESSION['nombre_usuario']."','$fin','$descripcion',NULL,' ','$pago')";
                                                                                            	     $result = mysql_query($sql,$conn) or die(mysql_error());



                                               $sql = "     SELECT ep.id_entrega_producto
                                                            FROM entrega_producto ep
                                                            WHERE  ep.grupo_empresa='".$_SESSION['nombre_usuario']."' and ep.fecha_establecida='$fin' and ep.descripcion='$descripcion' and ep.pago_asociado='$pago'";
                                               $resulta = mysql_query($sql,$conn) or die(mysql_error());
                                               while($row_a = mysql_fetch_array($resulta)) {
                                                                 $sql2 = "INSERT INTO actividad_grupo_empresa (fecha_inicio,fecha_fin,descripcion,entrega_producto)
                                                                  VALUES ('$inicio','$fin','$descripcion','".$row_a['id_entrega_producto']."')";
                                                                  $result2 = mysql_query($sql2,$conn) or die(mysql_error());
                                                                    break;
                                               }
                                                header('Location: actividades_grupo.php');

					}
					else{
						$error = true;
						$error_fecha_fin = "La fecha de finalizaci&oacute;n no debe ser menor o igual a la fecha de inicio";
					}
				}
				else{
					$error = true;
					$error_fecha_ini = "La fecha de inicio no debe ser menor a la fecha presente";
				}
			}
			else{
				$error = true;
				$error_fecha_fin = "La fecha de finalizacion no es valida";
			}
		}
		else{
			$error = true;
			$error_fecha_ini = "La fecha de inicio no es valida";
		}
	}
}


$titulo="P&aacute;gina de inicio Grupo Empresas";
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
						<a href="actividades_grupo.php">Actividades Grupo Empresa</a>

					</li>
				</ul>
			</div>
			<center><h3>Cuadro de Actividades </h3></center>
             <?php if ($cantidad_valida) { ?>
			<div class="row-fluid">
				<div class="box span12 center" id="print">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Actividades Programadas</h2>
						</div>
						<div class="box-content padding-in" style="text-align:left;" >
                                            <!--  <form name="activi" class="form-horizontal cmxform" method="POST" id="activi" action="rmactivi.php" accept-charset="utf-8"  >  -->
                                        <input type="hidden" id="ge" name="ge"value="<?php echo $_SESSION['nombre_usuario'];?>"/>
                                       <TABLE id="dataTable" name="dataTable" class="table table-striped"  >
                                          <thead>
                                            <TR>
                                            <TH>Descripci&oacute;n</TH>
                                            <TH>Fecha Inicio</th>
                                            <TH>Fecha Conclusi&oacute;n </th>
                                            <TH>Pago Asociado </th>
                                          <!--   <TH>Eliminar </TH>

                                           <th>Entrega Producto</th>   -->
                                            </TR>
                                           </thead>
                                            <tbody>

                                             <?php
                                                 include('conexion/conexion.php');
                                                   $consulta_actividades_empresa = "SELECT age.id_actividad_grupo_empresa,age.fecha_inicio,age.fecha_fin,age.descripcion,age.entrega_producto ,ep.pago_asociado
                                                                                    FROM entrega_producto ep,actividad_grupo_empresa age
                                                                                    WHERE ep.grupo_empresa='".$_SESSION['nombre_usuario']."' AND ep.id_entrega_producto= age.entrega_producto";
                                                                                    $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                                                                                    $CAA=0;
                                                                                     while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                                                                      {         echo "  <TR> ";
                                                                                                                           //  echo "<input  type=\"hidden\" id=\"A1".$CTA."\"  name=\"A1".$CTA."\"  value=\"".$row_actividades_empresa['id_actividad_grupo_empresa']."\"  />";
                                                                                                                           //  echo "<input  type=\"hidden\" id=\"A2".$CTA."\"  name=\"A2".$CTA."\"  value=\"".$row_actividades_empresa['fecha_inicio']."\"  />";
                                                                                                                           //  echo "<input  type=\"hidden\" id=\"A3".$CTA."\"  name=\"A3".$CTA."\"  value=\"".$row_actividades_empresa['fecha_fin']."\"  />";
                                                                                                                           //  echo "<input  type=\"hidden\" id=\"A4".$CTA."\"  name=\"A4".$CTA."\"  value=\"".$row_actividades_empresa['descripcion']."\"  />";
                                                                                                                           //  echo "<input  type=\"hidden\" id=\"A5".$CTA."\"  name=\"A5".$CTA."\"  value=\"".$row_actividades_empresa['entrega_producto']."\"  />";
                                                                                              echo "
                                                                                            <TD>".$row_actividades_empresa['descripcion'] ." </TD>
                                                                                            <TD>".$row_actividades_empresa['fecha_inicio']."</TD>
                                                                                            <TD>".$row_actividades_empresa['fecha_fin']."</TD>
                                                                                            <TD>".$row_actividades_empresa['pago_asociado']."</TD> ";
                                                                                           // <TD><INPUT type=\"checkbox\" id=\"A4".$CAA."\"  name=\"A4".$CAA."\"  style=\"max-width: 80px !important \"   id=\"".$CAA."\" name=\"".$CAA."\"/>  </TD>




                                                                                                    echo "<input  type=\"hidden\" id=\"A0".$CAA."\"  name=\"A0".$CAA."\"  value=\"".$row_actividades_empresa['id_actividad_grupo_empresa']."\"  />";

                                                                                                     /* <select style=\"max-width: 60px !important id=\"seleca".$CAA."\" name=\"selea".$CAA."\" data-rel=\"chosen\">";
                                                                                                       $consulta_entrega ="SELECT ep.id_entrega_producto ,ep.descripcion
                                                                                                                            from entrega_producto ep
                                                                                                                            WHERE ep.grupo_empresa='".$_SESSION['nombre_usuario']."'";
                                                                                                        $resultado_entrega = mysql_query($consulta_entrega);
                                                                                                        while($row_entrega = mysql_fetch_array($resultado_entrega))
                                                                                                        { echo "<option style=\"max-width: 60px !important value=\"".$row_entrega['id_entrega_producto']."\">".$row_entrega['id_entrega_producto']." :".$row_entrega['descripcion']."</option>";  }
                                                                                                    echo " 	</select>
                                                                                                   */
                                                                                                     echo      "</TR>";
                                                                                      $CAA++;
                                                                                      }
                                                                                   // echo "<input  type=\"hidden\" id=\"CAA\"  name=\"CAA\"  value=\"".$CAA."\"  />";
                                                                                    if($CAA==0){
                                                                                      echo "<center><h4>Noexiste ninguna actividad programada.</h4></center>";
                                                                                    }
                                                                                                                                  ?>
                                                 </tbody>
                                                  </TABLE>
                                               <!-- <input type="submit" name="eliminar" value="Guardar Cambios" class="btn btn-primary"  />     -->
		                </div>                 <!-- </form>-->
				</div>
			</div>
            <br>
            <center><h3> Agregar actividades </h3></center>
            <div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-plus-sign"></i> Agregar Actividad</h2>
						</div>
						<div class="box-content alerts">
                        <br>
						<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action="actividades_grupo.php" accept-charset="utf-8">

								<div class="control-group">
								  <label class="control-label" >Descripci&oacute;n: </label>
								  <div class="controls">
									<input type="text" name="descripcionG" id="descripcionG" placeholder="Ingrese una descripci&oacute;n"/>
								  </div>
								</div>
                                <div class="control-group">
								  <label class="control-label" for="tituloD">Pago ($us): </label>
								  <div class="controls">
									<input type="text" class ="pagos" name="pagos" id="pagos" placeholder="Ingresar pago"/>
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" >Fecha inicio:</label>
									<div class="controls">
										<input type="text" class="datepicker" etitable='false' name="inicio" id="inicio" value="<?php echo $inicio; ?>">
										<label class="error"><?php if(isset($error_fecha_ini)){ echo $error_fecha_ini; } ?></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="descripcion">Fecha conclusi&oacute;n:</label>
									<div class="controls">
										<input type="text" class="datepicker" name="fin" id="fin" value="<?php echo $fin; ?>" >
										<label class="error"><?php if(isset($error_fecha_fin)){ echo $error_fecha_fin; } ?></label>
									</div>
								</div>

								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Aceptar</button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>

							</form>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
                <?php } else{ ?>
                <div class="row-fluid">
				<div class="box span12">
						<div class="box-header well">
							<h2><i class="icon-info-sign"></i> Actividades Programadas</h2>
						</div>
						<div class="box-content alerts">
								<center><h4>Debe habilitar m&aacute;s integrantes.</h4></center>
						</div>
					</div><!--/span-->
				</div><!-- fin row -->
                <?php } ?>
<?php include('footer.php'); ?>