<?php
session_start();
/*------------------VERIFICAR QUE SEAL LA GRUPO EMPRESA------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=4)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO       */
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
$titulo="P&aacute;gina de Calendario Grupo Empresas";
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
						<a href="calendario_grupo.php">Calendario De Tareas Del Grupo Empresas</a>
					</li>
				</ul>
			</div>

                  	<center><h3>Gesti&oacute;n de tareas por actividad</h3></center>



            <div class="row-fluid">
				<div class="box span center">
						<div class="box-header well">
							<h2><i class="icon-calendar"></i> Calendarion Grupo Empresa</h2>
						</div>
						<div class="box-content">















		<div id="example" style="margin: auto; width:80%; height: 80%">

		<div id="toolbar" class="ui-widget-header ui-corner-all" style="">
			<button class="btn btn-primary" id="BtnPreviousMonth">Anterior</button>
			<button class="btn btn-primary" id="BtnNextMonth">Siguiente</button>
			&nbsp;&nbsp;&nbsp;
			Fecha: <input type="text" id="dateSelect" size="10"/>
			&nbsp;&nbsp;&nbsp;
			<button class="btn btn-primary" id="BtnDeleteAll">Eliminar Todo</button>
		</div>

		<div id="mycal"></div>

		</div>

		<!-- debugging-->
		<div id="calDebug"></div>

		<!-- Add event modal form -->
		<style type="text/css">
			//label, input.text, select { display:block; }
			fieldset { padding:0; border:0; margin-top:25px; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips { border: 1px solid transparent; padding: 0.3em; }
		</style>
		<div id="add-event-form" title="A&ntilde;adir Tarea">
        <!-- action="add_tarea.php" -->
        <form>
        <?php
                  include('conexion/conexion.php');
                  $consulta_actividades_empresa = "SELECT age.id_actividad_grupo_empresa,age.fecha_inicio,age.fecha_fin,age.descripcion,age.entrega_producto
                                FROM entrega_producto ep,actividad_grupo_empresa age
                                WHERE ep.grupo_empresa='".$_SESSION['nombre_usuario']."' AND ep.id_entrega_producto=age.entrega_producto";
                  $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);
                  $CTA=0;
                                             while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                              {
                                                 echo "<input  type=\"hidden\" id=\"A1".$CTA."\"  name=\"A1".$CTA."\"  value=\"".$row_actividades_empresa['id_actividad_grupo_empresa']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A2".$CTA."\"  name=\"A2".$CTA."\"  value=\"".$row_actividades_empresa['fecha_inicio']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A3".$CTA."\"  name=\"A3".$CTA."\"  value=\"".$row_actividades_empresa['fecha_fin']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A4".$CTA."\"  name=\"A4".$CTA."\"  value=\"".$row_actividades_empresa['descripcion']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"A5".$CTA."\"  name=\"A5".$CTA."\"  value=\"".$row_actividades_empresa['entrega_producto']."\"  />";
                                             $CTA++;
                                              }
                                               echo "<input  type=\"hidden\" id=\"CTA\"  name=\"CTA\"  value=\"".$CTA."\"  />";


          ?>


        </form    >
                                     <form>
                                              <?php
                                                   $consulta_Tareas = "SELECT t.id_tarea,t.descripcion,t.integrante,t.actividad_grupo_empresa,t.fecha_inicio,t.fecha_fin,t.resultado,t.verificable,t.color_tarea,t.color_texto
                                                                                    FROM entrega_producto ep,actividad_grupo_empresa age,tarea t
                                                                                    WHERE ep.grupo_empresa='".$_SESSION['nombre_usuario']."' AND ep.id_entrega_producto=age.entrega_producto AND age.id_actividad_grupo_empresa=t.actividad_grupo_empresa";
                                                                      $resultado_Tareas = mysql_query($consulta_Tareas);
                                                  $CTT=0;
                                             while($row_Tareas = mysql_fetch_array($resultado_Tareas))
                                              {
                                                 echo "<input  type=\"hidden\" id=\"T1".$CTT."\"  name=\"A1".$CTT."\"  value=\"".$row_Tareas['id_tarea']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T2".$CTT."\"  name=\"A2".$CTT."\"  value=\"".$row_Tareas['descripcion']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T3".$CTT."\"  name=\"A3".$CTT."\"  value=\"".$row_Tareas['integrante']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T4".$CTT."\"  name=\"A4".$CTT."\"  value=\"".$row_Tareas['actividad_grupo_empresa']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T5".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['fecha_inicio']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T6".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['fecha_fin']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T7".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['resultado']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T8".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['verificable']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T9".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['color_tarea']."\"  />";
                                                 echo "<input  type=\"hidden\" id=\"T10".$CTT."\"  name=\"A5".$CTT."\"  value=\"".$row_Tareas['color_texto']."\"  />";
                                             $CTT++;
                                              }
                                                echo "<input  type=\"hidden\" id=\"CTT\"  name=\"CTT\"  value=\"".$CTT."\"  />";
                                               ?>



                                     </form>


			<form   method="POST"  accept-charset="utf-8"  name="form-reser" id="form-reser">
			<fieldset>
                <input  type="hidden" id="grupoEmpresa"  name="grupoEmpresa" value='<?php  echo "".$_SESSION['nombre_usuario'];  ?>' />
				<label for="name">Descripsi&oacute;n</label>
				<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
                <label for="responsable">Responsable</label>
                <select id="choose_responsable" name="choose_responsable" data-rel="chosen">
										<?php
                                        include ('conexion/conexion.php');
			                               $consulta_integrante = "SELECT  i.id_integrante,i.nombre,i.apellido
                                                                    from integrante i
                                                                    WHERE i.grupo_empresa='".$_SESSION['nombre_usuario']."'";
			                              $resultado_integrante = mysql_query($consulta_integrante);
			                                while($row_integrante = mysql_fetch_array($resultado_integrante)) {
			                               		echo "<option value=\"".$row_integrante['id_integrante']."\">".$row_integrante['nombre']."  ".$row_integrante['apellido']."</option>";
			                                }

			                             ?>
								  	</select>
                 <label for="responsable">Pertenece a la actividad</label>
                <select id="choose_actividad" name="choose_actividad" data-rel="chosen">
										<?php
                                         $consulta_actividades_empresa = "SELECT age.id_actividad_grupo_empresa,age.fecha_inicio,age.fecha_fin,age.descripcion,age.entrega_producto
                                                                          FROM entrega_producto ep,actividad_grupo_empresa age
                                                                          WHERE ep.grupo_empresa='".$_SESSION['nombre_usuario']."' AND ep.id_entrega_producto=age.entrega_producto";
                                                            $resultado_actividades_empresa = mysql_query($consulta_actividades_empresa);

                                             while($row_actividades_empresa = mysql_fetch_array($resultado_actividades_empresa))
                                              {  echo "<option value=\"".$row_actividades_empresa['id_actividad_grupo_empresa']."\">".$row_actividades_empresa['descripcion']."</option>";

                                              }
                                         ?>
								  	</select>
                 <label for="name">Resultado de la Conclusi&oacute;n de la tarea </label>
				<input type="text" name="res" id="res" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
                <table style="width:100%; padding:5px;">
					<tr>
						<td>
							<label>Fecha de inicio</label>
							<input type="text" name="startDate" id="startDate" value="" class="datepicker" style="margin-bottom:12px; width:95%; padding: .4em;"/>
						</td>
						<td>&nbsp;</td>
                        <td>
							<label>Fecha de Conclusi&oacute;n</label>
							<input type="text" name="endDate" id="endDate" value="" class="datepicker" style="margin-bottom:12px; width:95%; padding: .4em;"/>
						</td>
						<td>&nbsp;</td>


					</tr>

				</table>
				<table>
					<tr>
						<td>
							<label>Color de Tarea</label>
						</td>
						<td>
							<div id="colorSelectorBackground"><div style="background-color: #333333; width:30px; height:30px; border: 2px solid #000000;"></div></div>
							<input type="hidden" id="colorBackground" name="colorBackground" value="#333333">
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<label>Color de texto</label>
						</td>
						<td>
							<div id="colorSelectorForeground"><div style="background-color: #ffffff; width:30px; height:30px; border: 2px solid #000000;"></div></div>
							<input type="hidden" id="colorForeground" name ="colorForeground" value="#ffffff">
						</td>
					</tr>
				</table>
			</fieldset>
			</form>
		</div>

		<div id="display-event-form" title="Informaci&oacute;n de Tarea">

		</div>






		                </div>
				</div><!--/FORMULARIO DE INGRESO-->
			</div>












<?php include('footer.php');
















 ?>