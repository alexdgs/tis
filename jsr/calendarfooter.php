
<!-- Some CSS for our example. (Not required for calendar plugin. Used for example.)-->
<style type="text/css" media="screen">
.shadow {
	-moz-box-shadow: 3px 3px 4px #aaaaaa;
	-webkit-box-shadow: 3px 3px 4px #aaaaaa;
	box-shadow: 3px 3px 4px #aaaaaa;
	/* For IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa')";
	/* For IE 5.5 - 7 */
	filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa');
}
</style>

<script type="text/javascript">
$(document).ready(function(){

	var clickDate = "";
	var clickAgendaItem = "";
    var ctt=0;
    Tareas= new Array();
    var fecha_ini="";
    var fecha_fin="";
    var titulo="";
	/**
	 * Initializes calendar with current year & month
	 * specifies the callbacks for day click & agenda item click events
	 * then returns instance of plugin object
	 */
	var jfcalplugin = $("#mycal").jFrontierCal({
		date: new Date(),
		dayClickCallback: myDayClickHandler,
		agendaClickCallback: myAgendaClickHandler,
		agendaDropCallback: myAgendaDropHandler,
		agendaMouseoverCallback: myAgendaMouseoverHandler,
		applyAgendaTooltipCallback: myApplyTooltip,
		agendaDragStartCallback : myAgendaDragStart,
		agendaDragStopCallback : myAgendaDragStop,
		dragAndDropEnabled: true
	}).data("plugin");

	/**
	 * cuando se presiona para mover el evento
	 */
	function myAgendaDragStart(eventObj,divElm,agendaItem){
                    aaa
          titulo = agendaItem.title;
		  fecha_ini = agendaItem.startDate;
		  fecha_fin = agendaItem.endDate;
	   /*	if(divElm.data("qtip")){
             divElm.qtip("destroy");

		} */
	};

	/**
	 * cuando se arrastra el evento fuera del calen ario
	 */
	function myAgendaDragStop(eventObj,divElm,agendaItem){
	//alert("drag stop");
	};

	/**
	 * Custom tooltip - use any tooltip library you want to display the agenda data.
	 * for this example we use qTip - http://craigsworks.com/projects/qtip/
	 *
	 * @param divElm - jquery object for agenda div element
	 * @param agendaItem - javascript object containing agenda data.
	 */
	function myApplyTooltip(divElm,agendaItem){

		// Destroy currrent tooltip if present
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}

		var displayData = "";

		var title = agendaItem.title;
		var startDate = agendaItem.startDate;
		var endDate = agendaItem.endDate;
		var allDay = agendaItem.allDay;
		var data = agendaItem.data;
      /*
        var startYear = startDtArray[0];
					var startMonth = startDtArray[1];
					var startDay = startDtArray[2];
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					var endMonth = endDtArray[1];
					var endDay = endDtArray[2];
					endMonth = endMonth.replace(/^[0]+/g,"");
					endDay = endDay.replace(/^[0]+/g,"");      */
		displayData += "<br><b> Descripci&oacute;n: " + title+ "</b><br><br>";
		if(allDay){
			displayData += "(Tareas del dia)<br><br>";
		}else{
			displayData += "<b>Fecha inicio:</b> " + startDate + "<br>" + "<b>Fecha de concluci&oacute;n:</b> " + endDate + "<br><br>";
           //  displayData += "<b>Fecha inicio: </b> " + startYear +"-"+startMonth+"-"+startDay +"<br>" + "<b>Fecha de concluci&oacute;n:</b> " + endYear +"-"+endMonth +"-"+endDay+"< br><br>";

		}
		for (var propertyName in data) {
		  	displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
		}
		// use the user specified colors from the agenda item.
		var backgroundColor = agendaItem.displayProp.backgroundColor;
		var foregroundColor = agendaItem.displayProp.foregroundColor;
		var myStyle = {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10,
			textAlign: "left",
			tip: true,
			name: "dark" // other style properties are inherited from dark theme
		};
		if(backgroundColor != null && backgroundColor != ""){
			myStyle["backgroundColor"] = backgroundColor;
		}
		if(foregroundColor != null && foregroundColor != ""){
			myStyle["color"] = foregroundColor;
		}
		// apply tooltip
		divElm.qtip({
			content: displayData,
			position: {
				corner: {
					tooltip: "bottomMiddle",
					target: "topMiddle"
				},
				adjust: {
					mouse: true,
					x: 0,
					y: -15
				},
				target: "mouse"
			},
			show: {
				when: {
					event: 'mouseover'
				}
			},
			style: myStyle
		});

	};




	/**
	 * Make the day cells roughly 3/4th as tall as they are wide. this makes our calendar wider than it is tall.
	 */
	jfcalplugin.setAspectRatio("#mycal",0.75);

	/**
     * lansador del menu cuando clickea en una selda para anadir evento
	 */
	function myDayClickHandler(eventObj){
		// Get the Date of the day that was clicked from the event object
		var date = eventObj.data.calDayDate;
		// store date in our global js variable for access later
		clickDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
		// open our add event dialog
		$('#add-event-form').dialog('open');
	};

	/**
	 * Called when user clicks and agenda item
	 * use reference to plugin object to edit agenda item
	 */
	function myAgendaClickHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;
		// pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		clickAgendaItem = agendaItem;
		$("#display-event-form").dialog('open');
	};

	/**
	 * mueve evento.
	 */
	function myAgendaDropHandler(eventObj){

		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;
		// date agenda item was dropped onto
		var date = eventObj.data.calDayDate;
		// Pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
//            alert("la tarea " + agendaItem.title +" con fecha  de inicio :"+ fecha_ini +"y fecha fecha e conclusion :"+ fecha_fin +
  //			" se cambiara a fecha de inicio : " + agendaItem.startDate + " y fecha fecha e conclusion : "+agendaItem.endDate);

                     var grupoem = jQuery.trim($("#grupoEmpresa").val());
                     var formData = new FormData();
                     formData.append("grupoEmpresa", grupoem );
                     formData.append("what", agendaItem.title );
                     formData.append("startDate", agendaItem.startDate );
                     formData.append("endDate", agendaItem.endDate );
                     formData.append("fechaini", fecha_ini );
                     formData.append("fechafin", fecha_fin );
                     formData.append("operacion","update"  );
                         var xhr = new XMLHttpRequest();
                            xhr.open("POST", "add_tarea.php");
                            xhr.send(formData);

	};

	/**
	 * Called when a user mouses over an agenda item
	 */
	function myAgendaMouseoverHandler(eventObj){
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		//alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
	};
	/**
	 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
	 */
	$("#dateSelect").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd'
	});

	/**
	 * Set datepicker to current date
	 */
	$("#dateSelect").datepicker('setDate', new Date());
	/**
	 * Use reference to plugin object to a specific year/month
	 */
	$("#dateSelect").bind('change', function() {
		var selectedDate = $("#dateSelect").val();
		var dtArray = selectedDate.split("-");
		var year = dtArray[0];
		// jquery datepicker months start at 1 (1=January)
		var month = dtArray[1];
		// strip any preceeding 0's
		month = month.replace(/^[0]+/g,"")
		var day = dtArray[2];
		// plugin uses 0-based months so we subtrac 1
		jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
	});
	/**
	 * Initialize previous month button
	 */
	$("#BtnPreviousMonth").button();
	$("#BtnPreviousMonth").click(function() {
		jfcalplugin.showPreviousMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
		return false;
	});
	/**
	 * Initialize next month button
	 */
	$("#BtnNextMonth").button();
	$("#BtnNextMonth").click(function() {
		jfcalplugin.showNextMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
		return false;
	});

	/**
	 * Initialize delete all agenda items button
	 */
	$("#BtnDeleteAll").button();
	$("#BtnDeleteAll").click(function() {


                             var grupoem = jQuery.trim($("#grupoEmpresa").val());
                     var formData = new FormData();
                     formData.append("grupoEmpresa", grupoem );
                     formData.append("operacion","deleteall");
                         var xhr = new XMLHttpRequest();
                            xhr.open("POST", "add_tarea.php");
                            xhr.send(formData);

		jfcalplugin.deleteAllAgendaItems("#mycal");

		return false;
	});

	/**
	 * Initialize iCal test button
	 */
	$("#BtnICalTest").button();
	$("#BtnICalTest").click(function() {
		// Please note that in Google Chrome this will not work with a local file. Chrome prevents AJAX calls
		// from reading local files on disk.
		jfcalplugin.loadICalSource("#mycal",$("#iCalSource").val(),"html");
		return false;
	});


	/**
	 * Initialize add event modal form
	 */
	$("#add-event-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			  'Guardar Evento': function()
        {

                var res=$("#res").val()
				var what = jQuery.trim($("#what").val());
                var hoy=new Date();
                var startDate = $("#startDate").val();
					var startDtArray = startDate.split("-");
					var startYear = startDtArray[0];
					var startMonth = startDtArray[1];
					var startDay = startDtArray[2];
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var endDate = $("#endDate").val();
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					var endMonth = endDtArray[1];
					var endDay = endDtArray[2];
					endMonth = endMonth.replace(/^[0]+/g,"");
					endDay = endDay.replace(/^[0]+/g,"");
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay));
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay));

                                       /*
                                           var haveactividad=false;
                                           var CTAphp= $("#CTA").val();
                                           var cta=0;
                                           var id_acti="";
                                           while(cta<=CTAphp){
                                                var a1 =  $("#A1"+cta).val();
                                                var a2 =  $("#A2"+cta).val();
                                                var a3 =  $("#A3"+cta).val();
                                					var fiDtArray = a2.split("-");             var ffDtArray = a3.split("-");
                                					var fiYear = fiDtArray[0];                 var ffYear = ffDtArray[0];
                                					var fiMonth = fiDtArray[1];                var ffMonth = ffDtArray[1];
                                					var fiDay = fiDtArray[2];                  var ffDay = ffDtArray[2];
                                					fiMonth = fiMonth.replace(/^[0]+/g,"");    ffMonth = ffMonth.replace(/^[0]+/g,"");
                                					fiDay = fiDay.replace(/^[0]+/g,"");        ffDay = ffDay.replace(/^[0]+/g,"");

                                                   if( parseInt(startYear)>= parseInt(fiYear) && parseInt(endYear)<= parseInt(ffYear)&&
                                                      (  (parseInt(startMonth)>= parseInt(fiMonth)&&parseInt(startYear) == parseInt(fiYear) )||
                                                         (parseInt(startMonth)<= parseInt(fiMonth)&&parseInt(startYear) > parseInt(fiYear) )
                                                      ) &&


                                                       parseInt(endMonth)<= parseInt(ffMonth)// &&
                                                        //parseInt(startDay)>= parseInt(fiDay) && parseInt(endDay)<= parseInt(ffDay)
                                                     ){
                                                        id_acti=a1;

                                                      }
                                                    cta++;
                                           }
                                        */
                    var actividad=$("#choose_actividad").val();
                 if(actividad==null||actividad==""){
                             alert("Debe elaborar su cuadro de actividades antes de gestionar la tareas");
                 }
                 else if(parseInt(startYear)<parseInt(hoy.getFullYear())||(parseInt(startMonth)-1<parseInt(hoy.getMonth())&&parseInt(startYear)<=parseInt(hoy.getFullYear()))||(parseInt(startMonth)-1>parseInt(hoy.getMonth())&&parseInt(startYear)<parseInt(hoy.getFullYear()))||
                  (parseInt(startDay)<parseInt(hoy.getDay())&&(parseInt(startMonth)-1<parseInt(hoy.getMonth())&&parseInt(startYear)<=parseInt(hoy.getFullYear())))||
                 (parseInt(startDay)<parseInt(hoy.getDay())&&(parseInt(startMonth)-1>parseInt(hoy.getMonth())&&parseInt(startYear)<parseInt(hoy.getFullYear())))||
                 (parseInt(startDay)>parseInt(hoy.getDay())&&(parseInt(startMonth)-1<parseInt(hoy.getMonth())&&parseInt(startYear)<=parseInt(hoy.getFullYear()))) ||
                 (parseInt(startDay)>parseInt(hoy.getDay())&&(parseInt(startMonth)-1>parseInt(hoy.getMonth())&&parseInt(startYear)<parseInt(hoy.getFullYear())))
                 ){
                    alert("La fecha de inicion no es valida hace referencia a una fecha pasada");
                 }
				else if(what == ""){
					alert("debe ingresar detalles de la tarea");
				}
                else if(res==""){
                    alert("debe ingresar detalles del resultado de la culminacion de tarea");
                }
                else{
                    var grupoem = jQuery.trim($("#grupoEmpresa").val());
                     var formData = new FormData();
                     formData.append("grupoEmpresa", grupoem );
                     formData.append("what", what );
                     formData.append("choose_responsable", $("#choose_responsable").val() );
                     formData.append("startDate", startDate );
                     formData.append("choose_actividad", $("#choose_actividad").val() );
                     formData.append("endDate", endDate );
                     formData.append("colorBackground", $("#colorBackground").val() );
                     formData.append("colorForeground", $("#colorForeground").val() );
                     formData.append("res", $("#res").val() );
                     formData.append("operacion","insert"  );
                         var xhr = new XMLHttpRequest();
                            xhr.open("POST", "add_tarea.php");
                            xhr.send(formData);

					// add new event to the calendar
					jfcalplugin.addAgendaItem(
						"#mycal",
						what,
						startDateObj,
						endDateObj,
						false,
						{},
						{
							backgroundColor: $("#colorBackground").val(),
							foregroundColor: $("#colorForeground").val()
						}
					);
                   // $('#form-reser').submit();
                	$(this).dialog('close');
		}

			},
			'Cancelar': function() {
				$(this).dialog('close');
			}
		},
		open: function(event, ui){
			// initialize start date picker
			$("#startDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
			// initialize end date picker
			$("#endDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
			// initialize with the date that was clicked
			$("#startDate").val(clickDate);
			$("#endDate").val(clickDate);
			// initialize color pickers
			$("#colorSelectorBackground").ColorPicker({
				color: "#333333",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorBackground div").css("backgroundColor", "#" + hex);
					$("#colorBackground").val("#" + hex);
				}
			});
			//$("#colorBackground").val("#1040b0");
			$("#colorSelectorForeground").ColorPicker({
				color: "#ffffff",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorForeground div").css("backgroundColor", "#" + hex);
					$("#colorForeground").val("#" + hex);
				}
			});
			//$("#colorForeground").val("#ffffff");
			// put focus on first form input element
			$("#what").focus();
		},
		close: function() {
			// reset form elements when we close so they are fresh when the dialog is opened again.
			$("#startDate").datepicker("destroy");
			$("#endDate").datepicker("destroy");
			$("#startDate").val("");
			$("#endDate").val("");
			$("#startHour option:eq(0)").attr("selected", "selected");
			$("#startMin option:eq(0)").attr("selected", "selected");
			$("#startMeridiem option:eq(0)").attr("selected", "selected");
			$("#endHour option:eq(0)").attr("selected", "selected");
			$("#endMin option:eq(0)").attr("selected", "selected");
			$("#endMeridiem option:eq(0)").attr("selected", "selected");
			$("#what").val("");
			//$("#colorBackground").val("#1040b0");
			//$("#colorForeground").val("#ffffff");
		}
	});

	/**
	 * Initialize display event form.
	 */
	$("#display-event-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			'Cancelar': function() {
				$(this).dialog('close');
			},
			'Eliminar': function() {
				if(confirm("desea eliminar esta tarea?")){
					if(clickAgendaItem != null){

                     var agendaItem = jfcalplugin.getAgendaItemById("#mycal",clickAgendaItem.agendaId);
                     var grupoem = jQuery.trim($("#grupoEmpresa").val());
                     var formData = new FormData();
                     formData.append("grupoEmpresa", grupoem );
                     formData.append("what", agendaItem.title );
                     formData.append("startDate", agendaItem.startDate );
                     formData.append("endDate", agendaItem.endDate );
                     formData.append("operacion","deletetarea"  );
                         var xhr = new XMLHttpRequest();
                            xhr.open("POST", "add_tarea.php");
                            xhr.send(formData);


						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
						//jfcalplugin.deleteAgendaItemByDataAttr("#mycal","myNum",42);
					}
					$(this).dialog('close');
				}
			}
		},
		open: function(event, ui){
			if(clickAgendaItem != null){
				var title = clickAgendaItem.title;
				var startDate = clickAgendaItem.startDate;
				var endDate = clickAgendaItem.endDate;
				var allDay = clickAgendaItem.allDay;
				var data = clickAgendaItem.data;
				// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
				$("#display-event-form").append(
					"<br><b> Descripci&oacute;n:</b> " + title+ "<br><br>"
				);
				if(allDay){
					$("#display-event-form").append(
						"(All day event)<br><br>"
					);
				}else{
					$("#display-event-form").append(
						"<b>Fecha inicio:</b> " + startDate + "<br>" +
						"<b>Fecha concluci&oacute;n:</b> " + endDate + "<br><br>"
					);
				}
				for (var propertyName in data) {
					$("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
				}
			}
		},
		close: function() {
			// clear agenda data
			$("#display-event-form").html("");
		}
	});

	/**
	 * Initialize our tabs
	 */
	$("#tabs").tabs({
		/*
		 * Our calendar is initialized in a closed tab so we need to resize it when the example tab opens.
		 */
		show: function(event, ui){
			if(ui.index == 1){
				jfcalplugin.doResize("#mycal");
			}
		}
	});
       /*	$(".ui-dialog-buttonset button:eq(0)").click(function() {
           $('#form-reser').submit();
    	}); */


           var CTTphp=$("#CTT").val();
           while(ctt<=CTTphp){
             var t1=$("#T1"+ctt).val();
             var t2=$("#T2"+ctt).val();
             var t3=$("#T3"+ctt).val();
             var t4=$("#T4"+ctt).val();
             var t5=$("#T5"+ctt).val();
             var t6=$("#T6"+ctt).val();
             var t7=$("#T7"+ctt).val();
             var t8=$("#T8"+ctt).val();
             var t9=$("#T9"+ctt).val();
             var t10=$("#T10"+ctt).val();
                    var startDate = t5;
					var startDtArray = startDate.split("-");
					var startYear = startDtArray[0];
					var startMonth = startDtArray[1];
					var startDay = startDtArray[2];
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var endDate = t6;
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					var endMonth = endDtArray[1];
					var endDay = endDtArray[2];
					endMonth = endMonth.replace(/^[0]+/g,"");
					endDay = endDay.replace(/^[0]+/g,"");
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay));
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay));
             Tareas[ctt]=new Array(t1,t2,t3,t4,t5,t6,t7,t8,t9,t10);
              	jfcalplugin.addAgendaItem(
						"#mycal",
						t2,
						startDateObj,
						endDateObj,
						false,
						{

						},
						{
							backgroundColor: ""+t9,
							foregroundColor: ""+t10
						}
					);


              ctt++;
           }
           var CTAphp= $("#CTA").val();
           var cta=0;
           Actividades=new Array();
           while(cta<=CTAphp){
                var a1 =  $("#A1"+cta).val();
                var a2 =  $("#A2"+cta).val();
                var a3 =  $("#A3"+cta).val();
                var a4 =  $("#A4"+cta).val();
                var a5 =  $("#A5"+cta).val();
              Actividades[cta]=new Array(a1,a2,a3,a4,a5);

                    cta++;
           }







});

</script>


             <style type="text/css">
			//label, input.text, select { display:block; }
			fieldset { padding:0; border:0; margin-top:25px; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips { border: 1px solid transparent; padding: 0.3em; }
		</style>