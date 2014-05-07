<!-- INICIO DE BARRA DERECHA-->
<?php
		if(!isset($titulo)){
			header('Location: index.php');
		}
?>
			<div class="span2">
				<?php if ($sesion_valida) /*SI LA SESION EL VALIDA MOSTRAR*/
				{ ?>
					<div class="box" style="margin-top:0;">
						<div class="box-header well">
							<h2><i class="icon-check"></i> Notificaciones</h2>
												
						</div>
						<div class="box-content">
                        <?php
                          if($_SESSION['tipo']==1) {
                                include("./conexion/notificaciones_admin.php");
                          }
                         else{ ?>

	                  		<ul>
	                  			<li>Mensaje de</li>
	                  			<li>Consultor x solicita aprovacion de registro</li>
	                  		</ul>
                          <?php }  ?>
		                 </div>
				</div>
				<?php } ?>
						                 		
	             <span class="datepicker"></span>                
	                  
				<!--/span2-->
				<?php if(!$sesion_valida){ ?>
				<div class="box" style="">
						<div class="box-header well">
							<h2><i class="icon-check"></i> Nota</h2>
												
						</div>
						<div class="box-content">
	                  		Para ingresar al sistema su Grupo Empresa debe estar previamente <a href="registro_grupo.php">registrada</a> en el Sistema.	        
		                 </div>
				</div>
				<div class="box navegacion-derecha">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Grupo Empresa</h2>					
						</div>
						<div class="box-content">
	                  		<form class="form" action="conexion/verificar.php" method="post">
									<input name="tipo" value=4 type="hidden"><!-- CAMPO HIDDEN PARA GRUPO CAMBIAR¡¡-->						
									<div class="input-prepend">
										<span class="add-on"><i class="icon-user"></i></span><input placeholder="Grupo Empresa" class="input-large span10" name="username" id="username" type="text"  />
									</div>
									<div class="clearfix"></div>

									<div class="input-prepend">								
										<span class="add-on"><i class="icon-lock"></i></span><input placeholder="Contrase&ntilde;a" class="input-large span10" name="password" id="password" type="password"/>
									</div>
									
									<div class="clearfix"></div>									
									<p class="center">
									<button type="submit" class="btn btn-primary">Ingresar</button>
									</p>
								
							</form>            
		                  </div>
				</div><!--/FORMULARIO DE INGRESO-->
				<?php } ?>
			</div>	<!-- FIN DE BARRA DE NAVEGACION DERECHA-->