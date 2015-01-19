
/*
* reservas
*
* javascript en donde se realiza el manejo de las acciones y eventos del formuulario con jquery
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-09
*/

// Inicialización de jquery
$(function(){
	
	 $("#show_edit").hide();
	 
	//Se precargan los tipos de espacio dependiendo del tipo de usuario 
	obtenerTipoEspacio();
	// variable que contiene la identificacion del solicitante
	var cedula_solicitante= $("#id_solicitante").val();
	// Se verifica si el usuario que se logeo es de tipo estudiante o profesor
	cargarDatosResponsable(cedula_solicitante);
	
	//Se esconden los elementos
	$("#espacio_fisico").css('display', 'none');
	$("#lblespacio").css('display', 'none');
	$("#software_principal").css('display', 'none');
	$("#lblsoftwarep").css('display', 'none');
	$("#software_secundario").css('display', 'none');
	$("#lblsoftwares").css('display', 'none');
	
	//Se desabilitan campos del solicitante
	$("#telefono_sol").attr('disabled',"disabled");
    $("#email_sol").attr('disabled',"disabled");
	$("#div_aud").hide();
	
	//Desabilitan campos del responsable
	$("#nombre_resp").attr('disabled',"disabled");
    $("#email_resp").attr('disabled',"disabled");
    $("#telefono_resp").attr('disabled',"disabled");
	$("#dependencia_resp").attr('disabled',"disabled");
	
	//Limpia el foemulario para una nueva reserva
	jQuery.fn.resetear = function () {
      $(this).each (function() { this.reset(); });
    }
	

    // plugin para formulario paso a paso 
	$("#wizard").steps({
         headerTag: "h2",
         bodyTag: "section",
         transitionEffect: "slideLeft",
		 enableAllSteps: false,
         onFinished: function (event, currentIndex)
         { 
		 
		    var validacion_form= $("#reservas").valid();
			
			
			if(validacion_form)
			{
			    var t_espacio= $("#tipo_espacio").val();
				var esp_fisico= $("#espacio_fisico").val();
				var oficina="";
				var descripcion_tipo="";
				var descripcion_espacio="";
				var software_principal= "N/A";
				var software_secundario= "N/A";	
				var cod_soft_principal="";
				var cod_soft_secundario="";
		     
			  switch(t_espacio){
				  
				case 'ug':
				 oficina= "Servicios Generales";
				 descripcion_tipo=$("#tipo_espacio option:selected").text();
				 descripcion_espacio= $("#espacio_fisico option:selected").text();
				 break;
				case 'sc': 
				 oficina="SYRI-Operaciones";
				 descripcion_tipo= $("#tipo_espacio option:selected").text();
				 descripcion_espacio= descripcion_tipo;
				 software_principal= $("#software_principal option:selected").text();
				 software_secundario= $("#software_secundario option:selected").text();
				 cod_soft_principal= $("#software_principal").val();
				 cod_soft_secundario= $("#software_secundario").val();
				 break;
				case 'scv':  
				  oficina="SYRI-Multimedios";
				  descripcion_tipo=$("#tipo_espacio option:selected").text();
				  descripcion_espacio= descripcion_tipo;
				  break; 
				case 'ssv': 
				  oficina="Planeación Académica";
				  descripcion_tipo=$("#tipo_espacio option:selected").text();
				  descripcion_espacio= descripcion_tipo;
				  break;  
				case 'cg': 
				  oficina="SYRI-Multimedios";
				  descripcion_tipo=$("#tipo_espacio option:selected").text();
				  descripcion_espacio= $("#tipo_espacio option:selected").text();
				  break;  
				case 'sbu':
				  oficina="Planeación Académica";
				  descripcion_tipo=$("#tipo_espacio option:selected").text();
				  descripcion_espacio= $("#espacio_fisico option:selected").text();
				  break; 
				case 'a': 
				  oficina="Planeación Académica";
				  descripcion_tipo=$("#tipo_espacio option:selected").text();;
				  descripcion_espacio= descripcion_tipo;
				  break;  
				case 'sa': 
				  if(esp_fisico=="SVC1" || esp_fisico=="SVC2"){
					oficina="SYRI-Multimedios";
				    descripcion_tipo=$("#tipo_espacio option:selected").text();
					descripcion_espacio= $("#espacio_fisico option:selected").text();  
				  }
				  else if(esp_fisico=="SDA"){
					oficina="Planeación Académica";
				    descripcion_tipo=$("#tipo_espacio option:selected").text();
					descripcion_espacio= $("#espacio_fisico option:selected").text();    
				  }
				 break;
				 
				 case 'l':
				  if(esp_fisico== "102F" || esp_fisico=="103F"){
					oficina="SYRI-Multimedios";
				    descripcion_tipo=$("#tipo_espacio option:selected").text();
					descripcion_espacio= $("#espacio_fisico option:selected").text(); 
				  }
				  else{
					oficina="Planeación Académica";
				    descripcion_tipo=$("#tipo_espacio option:selected").text();
					descripcion_espacio= $("#espacio_fisico option:selected").text(); 
				  }
				  break;
			  }
			 
              // Información de la reserva recolectada para enviar al controlador encargado
			    var data = {
				'nombre_solicitante': $("#nombre_solicitante").val(),
				'id_solicitante': $("#id_solicitante").val(),
				'telefono_solicitante': $("#telefono_sol").val(),
				'email_solicitante': $("#email_sol").val(),
				'nombre_responsable': $("#nombre_resp").val(),
				'id_responsable': $("#cedula_resp").val(),
				'telefono_responsable': $("#telefono_resp").val(),
				'email_responsable': $("#email_resp").val(),
				'nombre_actividad': $("#nombre_actividad").val(),
				'descripcion_actividad': $("#descripcion").val(),
				'fecha_reserva': $("#fecha").val(),
				'hora_inicio': $("#hora_inicio").val(),
				'hora_final': $("#hora_final").val(),
				'numero_personas': $("#No_personas").val(),
				'observaciones': $("#observaciones").val(),
				'oficina': oficina,
				'tipo_espacio': t_espacio,
				'espacio_fisico': esp_fisico,
				'desc_tipo_espacio': descripcion_tipo,
				'desc_esp_fisico': descripcion_espacio,
				'software_principal': software_principal,
				'software_secundario': software_secundario,
				'cod_soft_principal': cod_soft_principal,
				'cod_soft_secundario': cod_soft_secundario,
				'codigo_solicitante': $("#cod_solicitante").val(),
				'codigo_responsable':  $("#cod_responsable").val()
					
			 }
			 
			if( $("#email_sol").val() != '' && $("#telefono_sol").val() != '' && $("#email_resp").val() != '' && $("#telefono_resp").val()             != '' )
	        {
			 
			 // llamada ajax al controlador
			 $.ajax({
			   
			   url: '../controller/mantis/sgs.php',  
			   data: data,
			   type: 'post',
			   dataType:"json",
			   success: function(response) {
				 // Se procesa la respuesta del servidor 
				 if(response.id_caso >= 0 && response.id_caso != null)
				 { 
					var mensaje= "Su solicitud de reserva de"+" "+ response.reserva + " " +"ha sido recibida por la Oficina de" +" " +response.oficina+" y podrá hacerle seguimiento a través del Sistema de Gestión de Solicitudes, en el sitio de Servicios de Apoyo.\n\nEnlace del caso:\n\t" + response.url_caso +"\n\n"; 
					var titulo= "Confirmación de reserva";
					var ancho= 500;
					var alto=70;
					var tipo= 1;
					mostrarDialogo(mensaje, titulo, ancho, alto, tipo); 
					$("#reservas").resetear();
                    
				 }
				 else if(response.error==4)
				 {
					var mensaje= "Existen campos vacíos en el formulario, por favor actualice sus datos"; 
					var titulo= "Campos Vacios";
					var ancho= 350;
					var alto=40;
					var tipo= 3;
					dialogoGeneral(mensaje, titulo, ancho, alto, tipo); 
				 }
				 else
				 {
					var mensaje= "No se pudo enviar su solicitud de reserva de"+" "+ response.reserva + ","+response.url_sesion_mantis;
					var titulo= "Error reserva espacio físico";
					var ancho= 450;
					var alto=40;
					var tipo= 3;
					mostrarDialogo(mensaje, titulo, ancho, alto, tipo);  
					
        
				 }
			   
			   }
			 });
			 } // cierra if validación campos vacios
			 else
			 {
				var mensaje= "Existen campos vacíos en el formulario, por favor actualice sus datos"; 
				var titulo= "Campos Vacíos";
				var ancho= 350;
				var alto=40;
				var tipo= 3;
				dialogoGeneral(mensaje, titulo, ancho, alto, tipo); 	
			}
		  }// cierra if validacion form 
         },
		 onStepChanging: function (event, currentIndex, newIndex)
         {  
		    // desabilita la validación en campos que estan desabilitados o escondidos 
            $("#reservas").validate().settings.ignore = ":disabled,:hidden";
		
			// permite ir hacia atras incluso si el paso actual contiene campos con errores. 
			if(currentIndex > newIndex)
			{
				return true;
			}
			
            return $("#reservas").valid();
			
         },
         onFinishing: function (event, currentIndex)
         {
			// desabilita la validación en campos que estan desabilitados o escondidos  
            $("#reservas").validate().settings.ignore = ":disabled";
            return $("#reservas").valid();
         },
		 labels: {
			finish: "Enviar",
			next: "Siguiente",
			previous: "Anterior",
        }


     });// cierra steps
	 
	
	// inhabilita el evento enter a todos los campos tipo input
	$("input").keydown(function(event) {
	  
		 if (event.keyCode == '13') 
		 {
			return false; 
		 }
	});
	 
	 // Función que se encarga de obtener los tipos de espacio dependiendo del rol del usuario 
	 function obtenerTipoEspacio()
	 {
		 
		 var data= 
		 {
			 'option': 'tesp'
		 }
			
			$.ajax({
		     url: '../controller/espacios/espacios_fisicos.php',  
		     type: 'post',
		     data: data,
		     dataType:"html",
		     success: function(response) {
			   $("#tipo_espacio").html(response);    
		     }
		 });  
	}
	
	//Función que se encarga de obtener las url de las condiciones de uso y ans de los tipos y espacios fisicos
	function obtenerAnsCondicionesdeuso(tipoespacio, espacio)
	{
	
		var data=
		{
		  'option': 'getANS',
		  'tipo_espacio': tipoespacio,
		  'espacio': espacio	
		}
	  
		
		$.ajax({
		     url: '../controller/espacios/espacios_fisicos.php',  
		     type: 'post',
		     data: data,
		     dataType:"json",
		     success: function(response) {
			   //Asigno las url a los enlaces de ANS y condiciones de uso enviadas por el servidor
			   $("#ans").attr('href', response.ans);
			   $("#condiciones").attr('href', response.condiciones_uso);	
				 
			 }
		});
	}
	
	// Función que se encarga de cargar los datos del responsable previamente
	function cargarDatosResponsable()
	 {
		 var data= 
		 {'option': 'checkuser'}
			
			$.ajax({
		     url: '../controller/usuario/cargar_datos.php',  
		     type: 'post',
		     data: data,
		     dataType:"json",
		     success: function(response) {
			   if(response.tipo == 1)
			   {
				  var cedula= response.cedula;
				  var nombres= response.nombres;
				  var correo= response.correo; 
				  var telefono= response.telefono;
				  var celular= response.celular;
				  var dependencia= response.dependencia;
				  $("#cedula_resp").val(cedula);
				  $("#nombre_resp").val(nombres); 
				  $("#email_resp").val(correo);
				  $("#cod_responsable").val(response.codigo);
				  $("#dependencia_resp").val(dependencia);
				  $("#cedula_resp").attr('disabled',"disabled");
				  
				  if(response.celular== null)
				  {
					$("#telefono_resp").val(response.telefono);
					
				  }
				  else
				  {
					 $("#telefono_resp").val(response.celular); 
				  }
			   }
		     }
		 });  
	}
	
	//Función que desabilita el dia domingo del datepicker
	function domingos(date)
	{ 
		 var day = date.getDay();
		// aqui se indica el numero correspondiente a los dias que ha de bloquearse (el 0 es Domingo, 1 Lunes, etc...)
		return [(day != 0), ''];
		  
    }
   
   
   function festivos(date) 
   {
	  
	var unavailableDates = ["13-10-2014","3-11-2014"];
    fecha = date.getDate() + "-" + (date.getMonth()+1) + "-" +date.getFullYear();
    if ($.inArray(fecha, unavailableDates) < 0 ) {
        return [true,""];
    } else {
        return [false,""];
    }
  }
   
  
	// función que se encarga de validar los dias de antelacion de la fecha de reserva
	function obtenerDiasAntelacion(tipoespacio, espaciofisico)
	{
		var data= 
		 { 
		   'option': 'getAntelacion',
		   'tipoespacio': tipoespacio,
		   'espacio': espaciofisico
		 }
			
			$.ajax({
		     url: '../controller/espacios/espacios_fisicos.php',  
		     type: 'post',
		     data: data,
		     dataType:"json",
		     success: function(response){
			   
			var fecha= new Date();
			var anoActual= fecha.getFullYear();
			var mesActual= fecha.getMonth()+1;
			var diaActual= fecha.getDate();
			var fechaActual = new Date(anoActual,mesActual,diaActual);
			
			var parts= $("#fecha").val().split('-');
			var anofecha= parseInt(parts[0]);
			var mesfecha= parseInt(parts[1]);
			var diafecha= parseInt(parts[2]);
			var fechaForm = new Date(anofecha,mesfecha,diafecha);
			
			var diasDif = fechaForm.getTime() - fechaActual.getTime();
			var dias = Math.floor(diasDif/(1000 * 60 * 60 * 24));
			var tipo_espacio_ant= $("#tipo_espacio").val();
			var antelacion= parseInt(response.dias);
			
			
			if(dias < antelacion)
			{
			  $("#fecha").val("");
			  $("#fecha").addClass('error');
			  var mensaje= "De acuerdo con el ANS, la solicitud de reserva de"+" "+response.espacio+" "+"debe hacerse con al menos"+"              "+response.dias+" "+"días hábiles de anticipación. <br/>" + "Por favor comuníquese con la oficina de"+" "+response.               oficina+" " +"con el fin de recibir orientación para gestionar su solicitud: <br />"  +"Teléfono: 555-2334 extensiones"               +" "+response.extension+"<br/>"+"Correo Electrónico:"+" "+response.correo ; 
			  var titulo= "Error fecha reserva";
			  var ancho= 600;
			  var alto= 50;
			  var tipo= 3;
			  dialogoGeneral(mensaje, titulo, ancho, alto, tipo);
			}
			else
			{
			  $("#fecha").removeClass('error');	
			}	
          }
		 });  
	}// cierra funcion
	
	// Función utilizada para mostrar los mensajes al usuario
	function mostrarDialogo(mensaje, titulo, ancho, alto, tipo)
	{
		
	  $("#text-message").html(mensaje);
	  $('#dialog-icon').removeClass();
	  $('#dialog-icon').addClass('ui-icon');
	  switch(tipo){
		case 1:
		  clase = 'ui-state-default';
		  $('#dialog-icon').addClass('ui-icon-info');
		  break;
		case 2:
		  clase = 'ui-state-active';
		  $('#dialog-icon').addClass('ui-icon-alert');
		  break;
		case 3:
		  clase = 'ui-state-error';
		  $('#dialog-icon').addClass('ui-icon-circle-close');
		  break;
		case 4:
		  clase = 'ui-state-default';
		  $('#dialog-icon').addClass('ui-icon-circle-check');
		  break;
		default:
		  clase = 'ui-state-default';
		   $('#dialog-icon').addClass('ui-icon-notice');
		  break;
	  }
	  
	  $( "#dialog-message" ).dialog({
		modal: true,
		show:{
		  effect: 'blind',
		  duration: 1000 	
		},
		hide:{
		 effect: 'explode',
		 duration: 1000	
		},
		buttons: {
		  "Nueva Solicitud": function() {
			$(location).attr('href','../view/reservas.php#wizard-h-0');
			location.reload();
		  }, 
		  
		  "Cerrar Sesión": function() {
			$(location).attr('href','../source/cerrar_sesion.php');
		  }
		},
		title: titulo,
		closeOnEscape: true,
		draggable: false,
		resizable: false,
		show: 'fade',
		hide: 'fade',
		width: ancho,
		minHeight: alto,
		dialogClass: clase
	  })
  }// cierra funcion
  
  
  // Dialogo para validar dias de antelación fecha reserva
  
  function dialogoGeneral(mensaje, titulo, ancho, alto, tipo)
	{
		
	  $("#text-message").html(mensaje);
	  $('#dialog-icon').removeClass();
	  $('#dialog-icon').addClass('ui-icon');
	  switch(tipo){
		case 1:
		  clase = 'ui-state-default';
		  $('#dialog-icon').addClass('ui-icon-info');
		  break;
		case 2:
		  clase = 'ui-state-active';
		  $('#dialog-icon').addClass('ui-icon-alert');
		  break;
		case 3:
		  clase = 'ui-state-error';
		  $('#dialog-icon').addClass('ui-icon-circle-close');
		  break;
		case 4:
		  clase = 'ui-state-default';
		  $('#dialog-icon').addClass('ui-icon-circle-check');
		  break;
		default:
		  clase = 'ui-state-default';
		   $('#dialog-icon').addClass('ui-icon-notice');
		  break;
	  }
	  
	  $( "#dialog-message" ).dialog({
		modal: true,
		show:{
		  effect: 'blind',
		  duration: 1000 	
		},
		hide:{
		 effect: 'explode',
		 duration: 1000	
		},
		buttons: {
		  "Aceptar": function() {
			 $(this).dialog( "close" );
		  }  
		},
		title: titulo,
		closeOnEscape: true,
		draggable: false,
		resizable: false,
		show: 'fade',
		hide: 'fade',
		width: ancho,
		minHeight: alto,
		dialogClass: clase
	  })
  }// cierra funcion
	
	 
	 //Configuracion de las reglas de validacion para el formulario
	 $("#reservas" ).validate({
      rules: {
       No_personas: {
         required: true,
         digits:true,
         min:1,
         //number: true
       },
	 
	  nombre_actividad:{
		required: true,  
	  },
	  
	  descripcion: {
		required: true  
	  },
	  
	  tipo_espacio: {
		required: true  
	  },
	  
	  fecha: {
		 required: true, 
		 date: true,
	  },
	  
	  hora_inicio: {
		required: true,
	  },
	  
	  hora_final: {
		required: true,
		validatehours: true   
	  },
	  
	  valid_user:{
		required: true,  
	  },
	  
	  telefono_sol: {
		required: true,  
	  },
	  
	  email_sol: {
		required: true,
		email: true   
	  },
	  
	  cedula_resp: {
         required: true,
      },
	  
	  telefono_resp: {
         required: true,
      },
	  
	  email_resp: {
		required: true,
		email: true   
	  },
	  
	  nombre_resp: {
		 required: true,  
	  }
	  
	 
  }
});
	 
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	
	// Calendario de jqueryui 
    $('#fecha').datepicker({
	
		minDate: 'today',
		dateFormat: 'yy-mm-dd',
		changeMonth: true, 
		changeYear: true,
		yearRange: '-200:+1',
		showOn: 'button',
		buttonImage: '../images/calendar.png',
		buttonimageOnly: true,
		buttonText: "De click para seleccionar una Fecha", 
		onSelect: function (dateText, inst) 
		{
			var tipo_espacio_ant= $("#tipo_espacio").val();
			var espacio_fisico_ant= $("#espacio_fisico").val();
			if(tipo_espacio_ant != "ssv" || espacio_fisico_ant != "SDA" )
			 //Obtiene los dias de antelacion con los ciales se deben reservar un espacio fisico
			 obtenerDiasAntelacion(tipo_espacio_ant, espacio_fisico_ant);
         },
		 beforeShowDay: domingos,
	
       });
   
   
   // Hora de jquery ui
   $('#hora_inicio').timepicker({
     hours: { starts: 7, ends: 21 },
     minutes: { interval: 30 },
     rows: 3,
     showPeriodLabels: true,
     minuteText: 'Minutos',
	 showOn: 'button',
     button: $('#mostrar_hora_inicio'),
  });

  $('#hora_final').timepicker({  
    hours: { starts: 7, ends: 22 },
    minutes: { interval: 30 },
    rows: 3,
    showPeriodLabels: true,
    minuteText: 'Minutos',
	showOn: 'button',
    button: $('#mostrar_hora_final'),
  });
  
  
 // Evento que trae la información del responsable una vez pierde el foco
 $("#cedula_resp").blur(function(){
	
	var identificacion= $("#cedula_resp").val();
	
	var data = {
		'identificacion': identificacion,
		'option': 'datosresp'
	 }
	 
	 $.ajax({
	   
	   url: '../controller/usuario/datos_responsable.php',  
	   data: data,
	   type: 'post',
	   dataType:"json",
	   success: function(response) {
		  
		 if(response.error== 0) 
		 {
		  $("#nombre_resp").val(response.nombre);
		  $("#email_resp").val(response.correo);
		  $("#dependencia_resp").val(response.dependencia_responsable)
		  $("#cod_responsable").val(response.codigo);
		  
		  if(response.tipo_responsable == "colaborador" )
		  {
			  if(response.extension != null)
			  {
				 $("#telefono_resp").val(response.extension); 
			  }
			  else
			  {
				  if(response.celular != null)
				  {
					$("#telefono_resp").val(response.celular);   
				  }
				  else
				  {
					 $("#telefono_resp").val(response.telefono);  
				  }
			  }
			  
			 $("#show_edit").show(); 
		  }
		  else
		  {
			  if(response.celular != null)
			  {
				$("#telefono_resp").val(response.celular);  
			  }
			  else
			  {
				 $("#telefono_resp").val(response.telefono);  
			  }
			  
			  if(response.tipo_responsable== "Empleado Temporal")
			  {
				$("#show_edit").show();  
			  }
			  
		  }
		 }
		 else if(response.error== 2)
		 {
			$("#cedula_resp").val("");
			$("#nombre_resp").val("");
		    $("#email_resp").val("");
		    $("#telefono_resp").val("");
			$("#dependencia_resp").val("");
			$("#show_edit").hide(); 
			var mensaje= "El usuario no posee el rol necesario para esta reserva"; 
			var titulo= "Error de permisos";
			var ancho= 350;
			var alto=40;
			var tipo= 3;
			dialogoGeneral(mensaje, titulo, ancho, alto, tipo); 
			
		 }
		 else if (response.error==1) 
		 {
			$("#cedula_resp").val("");
			$("#nombre_resp").val("");
		    $("#email_resp").val("");
		    $("#telefono_resp").val("");
			$("#dependencia_resp").val("");
			$("#show_edit").hide(); 
			var mensaje= "No se encontró el usuario, verifique su identificación o que tenga sus datos actualizados"; 
			var titulo= "Error de identificación";
			var ancho= 350;
			var alto=40;
			var tipo= 3;
			dialogoGeneral(mensaje, titulo, ancho, alto, tipo);
		
		 }
		   
	   }
	 }); 

 });
 
    
	//evento que habilita los campos telefono y correo del solicitante si el rol es estudiante o profesor hora catedra
	$("#edit").click(function () {
	  
	  $("#telefono_sol").removeAttr("disabled");
      $("#email_sol").removeAttr("disabled");
	  $("#telefono_sol").focus();
	});
	
	$("#edittel_sol_col").click(function() {
	  $("#telefono_sol").removeAttr("disabled");
	  $("#telefono_sol").val("");
	  $("#telefono_sol").focus();	
    });
	
	$("#edittel_resp_col").click(function() {
	  $("#telefono_resp").removeAttr("disabled");
	  $("#telefono_resp").val("");
	  $("#telefono_resp").focus();	
    });
	
 
   /* Evento que dependiendo del tipo de espacio que se seleccione activa 
    la lista de espacios fisicos relacionados con el tipo de espacio */
   
   $('#tipo_espacio').change(function(){
	   
	 var valor= this.value;
	 var option= 'esp_fis';
	 var data;
	 
	 // Si se selecciona otro tipo de espacio se dejan vacios los campos que hayan sido rellenados previamente
     if($("#fecha").val().length > 0){
		$("#fecha").val(""); 
	 }
	 
	 if($("#hora_inicio").val().length > 0){
		$("#hora_inicio").val(""); 
	 }
	 
	 if($("#hora_final").val().length > 0){
		$("#hora_final").val(""); 
	 }
	 
	 var tipo_espacio_ans= $("#tipo_espacio").val();
     var espacio_fisico_ans= $("#espacio_fisico").val();
			
	//Obtien las urls de los ans y condiciones de uso de acuerdo al tipo de espacio seleccionado
	obtenerAnsCondicionesdeuso(tipo_espacio_ans, espacio_fisico_ans);
					 
	 
	 // Si se selecciona cualquiera de estos tipos de espacio se adiciona la regla de validacion requerido al campo espacio fisico
	 if(valor == "sbu" || valor=='ug' || valor=='l'  || valor=='sa')
	 {
		 $("#espacio_fisico").rules("add", {  
                required: true, 
                messages: {  
                    required: "Este campo es obligatorio.",  
                }  
        }); 
	 }
	 else
	{
		 $( "#espacio_fisico" ).rules( "remove" ); 
	}
	 
	 // Si se selecciona el tipo de espacio sala de computo se adiciona la regla de validacion requerido al campo software principal y secundario
	 if(valor=="sc")
	 {
		$("#software_principal").rules("add", {  
                required: true, 
                messages: {  
                    required: "Este campo es obligatorio.",  
                }  
        }); 
		
		$("#software_secundario").rules("add", {  
                required: true, 
                messages: {  
                    required: "Este campo es obligatorio.",  
                }  
        }); 
		
		var softwareP= 'softwareP'; 
		var softwareS= 'softwareS'; 
	 }
	 else
	 {
		var softwareP= 'ninguno'; 
		var softwareS= 'ninguno';
		$( "#software_principal" ).rules( "remove" );
		$( "#software_secundario" ).rules( "remove" );
	 }
	 
	 if(valor=="a")
	 {
		$("#div_aud").show('clip');
	 }
	 else
	{
	  $("#div_aud").hide(); 
	}
	
	
	 if(valor == "sbu" || valor=='ug' || valor=='l' || valor=='sc' || valor=='sa')
	 {
	   	data = {
		'option': option,
		'tespacio': valor
	   }
	   

		 $.ajax({
		   
		   url: '../controller/espacios/espacios_fisicos.php',  
		   data: data,
		   type: 'post',
		   dataType:"html",
		   success: function(response) {
			   
			  if(valor == "sbu" || valor=='ug' || valor=='l' || valor=='sa') 
			  {
				  var option_espacios= "<option value=''>Seleccione</option>";
				  $("#espacio_fisico").html(option_espacios);
				  $("#espacio_fisico").append(response);
				  $("#espacio_fisico").show('slow');  
				  $("#lblespacio").show('slow');
				  $("#software_principal").hide();  
				  $("#lblsoftwarep").hide(); 
				  $("#software_secundario").hide();  
				  $("#lblsoftwares").hide(); 
				   
			  }
			  else if(valor == 'sc')
			  {
				 var option_soft_princ= "<option value=''>Selecione</option>"; 
				 var option_soft_sec= "<option value='Ninguno'>Ninguno</option>";
				 $("#software_principal").html(option_soft_princ);
				 $("#software_principal").append(response);
				 $("#software_secundario").html(option_soft_sec);
				 $("#software_secundario").append(response);
				 $("#software_principal").show('slow');  
				 $("#lblsoftwarep").show('slow'); 
				 $("#software_secundario").show('slow');  
				 $("#lblsoftwares").show('slow');
				 $("#espacio_fisico").hide();  
				 $("#lblespacio").hide(); 
			  }
		   }
		 }); 
	 }
	 else
	 {
		$("#espacio_fisico").hide();  
	    $("#lblespacio").hide();
		$("#software_principal").hide();  
		$("#lblsoftwarep").hide(); 
		$("#software_secundario").hide();  
		$("#lblsoftwares").hide();   
	 }
	
	 	  
   });
   
   /*$("#software_principal").change(function(event){
		
      var id = $("#software_principal").find(':selected').val();
      $("#software_secundario").load('../source/soft_secundario.php?id='+id);
	 	
    });*/
   
   // Configuracion de nensajes jquery validator
    $.extend(jQuery.validator.messages, {
	  required: "Este campo es obligatorio.",
	  email: "Por favor, escriba una dirección de correo válida",
	  date: "Por favor, escribe una fecha válida.",
	  dateISO: "Por favor, escribe una fecha (ISO) válida.",
	  number: "Por favor, escriba un número entero válido.",
	  digits: "Por favor, escribe sólo dígitos.",
	  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
	  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
	  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
	  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
	  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
	  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
  });
  
  // Valida que la hora final de la reserva no sea menor que la hora de inicio
  jQuery.validator.addMethod("validatehours", function(value, element) {
   
      var partirhorainicio= $("#hora_inicio").val().split(":");
	  var partirhorafinal= $("#hora_final").val().split(":");
      var horainicio= parseInt(partirhorainicio[0]*60) + parseInt(partirhorainicio[1]) ;
      var horafinal=  parseInt(partirhorafinal[0]*60) + parseInt(partirhorafinal[1]) ;
	  var validacion= true;
	
     if (horainicio >= horafinal){
	    validacion= false;
     }
		
	   return validacion;
		 
   }, "La hora final de la reserva debe ser mayor que la hora de inicio"
  );
  
 
});// jquery