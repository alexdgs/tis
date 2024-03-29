	<?php
		if(!isset($titulo)){
			header('Location: index.php');
		}
		 if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
				<!-- content ends  final del conenido-->
				</div>
				<?php 
					include('nav-derecha.php');
				?>	
		<?php } ?>
		</div><!--/fluid-row-->
		<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
		
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<footer>
			<p class="pull-left">&copy; <a href="#" target="_blank">Derechos Reservados </a> <?php echo date('Y') ?></p>
			<p class="pull-right">Powered by: <a href="mailto:oasissd.srl@gmail.com">Oasis S.D.</a></p>
		</footer>
		<?php } ?>

	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- jQuery -->
	<script src="js/jquery-1.7.2.min.js"></script>

	<script src="js/script.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>
	<!-- validation plugin -->	
	<script src="js/jquery.validate.js"></script>
	<script>

$(document).ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
			firstname: {
				required: true,
				minlength: 3,
				maxlength : 32
			},
			lastname: {
				required: true,
				minlength: 3,
				maxlength : 32
			},
			username: {
				required: true,
				minlength: 5,
				maxlength : 20
			},
			telf: {
				required: true,
				minlength: 7
			},
			password: {
				required: true,
				minlength: 5,
				maxlength: 20
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required",
			descripcion: {
				required: true,
				minlength: 10,
				maxlength: 256
			},
			titulo: {
				required: true,
				minlength: 10,
				maxlength: 32
			},
			descripcionA: {
				required: true,
				minlength: 32,
				maxlength: 250
			},
			descripcionB: {
				required: true,
				minlength: 32,
				maxlength: 250
			},
			tituloD: {
				required: true,
				minlength: 10,
				maxlength: 32
			},
			lname: {
				required: true,
				minlength: 10,
				maxlength: 64
			},
			descripcionG: {
				required: true,
				minlength: 10,
				maxlength: 256
			},
			sname: {
				required: true,
				minlength: 5,
				maxlength: 20
			},
			codSIS: {
				required: true,
				minlength: 9
			},
            pagos: {
                required: true,
				maxlength: 3
            }
		},
		messages: {
			firstname:{
				required: "Ingrese su nombre",
				minlength: "El nombre debe consistir de 3 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 32 caracteres m&aacute;ximo"
			},
			lastname: {
				required: "Ingrese su apellido",
				minlength: "El apellido debe consistir de 3 caracteres m&iacute;nimo",
				maxlength: "El apellido debe consistir de 32 caracteres m&aacute;ximo"
			},
			username: {
				required: "Ingrese nombre de usuario",
				minlength: "El nombre de usuario debe consistir de 5 caracteres minimo",
				maxlength: "El nombre de usuario debe consistir de 20 caracteres maximo"
			},
			telf: {
				required: "Ingrese tel&eacute;fono",
				minlength: "El telefono debe consistir de 7 n&uacute;meros"
			},
			password: {
				required: "Ingrese contrase&ntilde;a",
				minlength: "La contrase&ntilde;a debe consistir de 5 caracteres minimo",
				maxlength: "La contrase&ntilde;a debe consistir de 20 caracteres maximo"
			},
			confirm_password: {
				required: "Ingrese contrase&ntilde;a",
				minlength: "La contrase&ntilde;a debe consistir de 5 caracteres minimo",
				maxlength: "La contrase&ntilde;a debe consistir de 20 caracteres maximo",
				equalTo: "Las contrase&ntilde;as no coinciden"
			},
			email: "Ingrese un correo valido",
			agree: "Debe aceptar nuestros terminos",
			descripcion: {
				required: "Ingrese una descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "La descripci&oacute;n debe consistir de 256 caracteres m&aacute;ximo"
			},
			descripcionG: {
				required: "Ingrese una descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "La descripci&oacute;n debe consistir de 64 caracteres m&aacute;ximo"
			},
			titulo: {
				required: "Ingrese un t&iacute;tulo",
				minlength: "El titulo debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El titulo debe consistir de 32 caracteres maximo"
			},
			descripcionA: {
				required: "Ingrese descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 32 caracteres minimo",
				maxlength: "La descripci&oacute;n debe consistir de 250 caracteres maximo"
			},
			descripcionB: {
				required: "Ingrese descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 32 caracteres minimo",
				maxlength: "La descripci&oacute;n debe consistir de 250 caracteres maximo"
			},
			tituloD: {
				required: "Ingrese un t&iacute;tulo",
				minlength: "El titulo debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El titulo debe consistir de 32 caracteres m&aacute;ximo"
			},
			lname: {
				required: "Ingrese el nombre largo de la Grupo-Empresa",
				minlength: "El nombre debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 64 caracteres m&aacute;ximo"
			},
			sname: {
				required: "Ingrese el nombre corto de la Grupo-Empresa",
				minlength: "El nombre debe consistir de 5 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 20 caracteres m&aacute;ximo"
			},
			codSIS: {
				required: "Ingrese su c&oacute;digo SIS correspondiente",
				minlength: "El nombre debe consistir de 9 caracteres "
			},
            pagos: {
                required: "Ingrese Pago",
				maxlength: "El pago debe consistir de 3 digitos"
            }
		}
	});

	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});

	jQuery.validator.addMethod("firstnames", function( value, element ) {
		var result = this.optional(element) || value.length >= 3 && /[a-z]/i.test(value) && !/\d/.test(value);
		
		return result;
	}, "El nombre debe tener mínimo 3 caracteres y no contener números");

	jQuery.validator.addMethod("lastnames", function( value, element ) {
		var result = this.optional(element) || value.length >= 2 && /[a-z]/i.test(value) && !/\d/.test(value);
		
		return result;
	}, "El apellido debe tener mínimo 2 caracteres y no contener números");

	jQuery.validator.addMethod("telefonos", function( value, element ) {
		var result = this.optional(element) || value.length >= 7 && value.length < 9 && /\d/.test(value) && !/[a-z]/i.test(value);

		return result;
	}, "El telefono debe tener entre 7 y 8 caracteres y contener solo números");

    jQuery.validator.addMethod("pagos", function( value, element ) {
		var result = this.optional(element) || value.length < 4 && /\d/.test(value) && !/[a-z]/i.test(value);

		return result;
	}, "El pago debe tener menos de 4 digitos y contener solo números");

    jQuery.validator.addMethod("codigos", function( value, element ) {
		var result = this.optional(element) || value.length == 9  && /\d/.test(value) && !/[a-z]/i.test(value);

		return result;
	}, "El c&oacute;digo SIS debe consistir de 9 digitos y contener solo números");

	//code to hide topic selection, disable for demo
	var newsletter = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital = newsletter.is(":checked");
	var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
});
</script>
	
	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- subir archivo -->
	<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	<script src="js/noticias.js"></script>
	 
    <?php
          include('conexion/verificar_gestion.php');
          if ($gestion_valida && $titulo="Sistema de Apoyo a la Empresa TIS") {
               $consulta = "SELECT COUNT(*) as numero
                            FROM documento_consultor
                            WHERE  documento_jefe= '1' AND gestion=$id_gestion";
               $resultado = mysql_query($consulta);
               $res = mysql_fetch_array( $resultado);
               $num=  $res['numero'];
               if($res['numero']>3){
                                       ?>
                <script language="JavaScript" type="text/javascript">
						    var nume='<?php  echo $num;  ?>'

							 setTamAviso( 130 );
							 setNumAvisos( nume );
							 timerID = setTimeout("moverAvisos()", 1000);
						    </script>


             <?php
                }
            }
     ?>
        <!-- Inicio Calendario de tareas -->
<script type="text/javascript" src="js/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js"></script>
<script type="text/javascript" src="js/lib/jshashtable-2.1.js"></script>
<script type="text/javascript" src="js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js"></script>
<!--<script type="text/javascript" src="js/manipulacion.js"></script> -->
 <?php include ('jsr/calendarfooter.php');
     // include ('jsr/calendariofooter.php');
   ?>

<!--  fin Calendario de tareas -->
</body>
</html>