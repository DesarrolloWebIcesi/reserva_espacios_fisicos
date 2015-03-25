<?php

session_start();


/*
* sgs
*
* controlador que se encarga de crear los casos em el sistema de gestion de solicitudes
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-07-08
*/

// Clase para realizar peticiones http
include_once('../../class/curl.php');
// Clase para manejo de datos personales
include_once('../../class/datos_personales.php');
// Archivo de configuracion de la aplicacion
include_once('../../config/configuration.php');
// Clase para el envio de correos
include_once('../../lib/phpmailer/class.phpmailer.php');

// variable utilizada para desarrrollo y pruebas
$desarrollo= false;
$url="";
$control="";
$correo_oficina="";
$extension_oficina="";
$url_caso="";
$correo_solicitante="";
$correo_responsable="";
$url_protecccion_datos="";
$url_inicio_mantis="";
$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

// Variables enviadas por POST reserva de espacios				
$nombre_solicitante= trim($_POST['nombre_solicitante']);
$id_solicitante= trim($_POST['id_solicitante']);
$telefono_solicitante= trim($_POST['telefono_solicitante']);	
$email_solicitante= trim($_POST['email_solicitante']);
$codigo_solicitante= trim($_POST['codigo_solicitante']);
$nombre_responsable= trim($_POST['nombre_responsable']);
$id_responsable= trim($_POST['id_responsable']);
$telefono_responsable= trim($_POST['telefono_responsable']);
$email_responsable= trim($_POST['email_responsable']);
$codigo_responsable= trim($_POST['codigo_responsable']);
$nombre_actividad= trim($_POST['nombre_actividad']);
$descripcion_actividad= trim($_POST['descripcion_actividad']);
$fecha_reserva= trim($_POST['fecha_reserva']);
$hora_inicio= trim($_POST['hora_inicio']);
$hora_final= trim($_POST['hora_final']);
$numero_personas= trim($_POST['numero_personas']);
$observaciones= trim($_POST['observaciones']);
$oficina= trim($_POST['oficina']);
$tipo_espacio= trim($_POST['tipo_espacio']);
$espacio_fisico= trim($_POST['espacio_fisico']);
$descripcion_tipo= trim($_POST['desc_tipo_espacio']);
$descripcion_espacio= trim($_POST['desc_esp_fisico']);
$software_principal= trim($_POST['software_principal']);
$software_secundario= trim($_POST['software_secundario']);
$codigo_software_p= trim($_POST['cod_soft_principal']);
$codigo_software_s= trim($_POST['cod_soft_secundario']);
$zona_recibo= trim($_POST['zonarecibo']);

// Variables proteccion de datos personales
$aceptacion= "S";
$correo= trim($_POST['email_solicitante']);
$documento=trim($_POST['id_solicitante']);
$entramite="";
$ip= $_SERVER["REMOTE_ADDR"];
$lider="";
$motivo="";
$negacion="";
$per_consecutivo="";
$periodo_acad="";
$respuesta="";
$sistema="Reserva de Espacios Fisicos";



// Cambiar fecha formulario a formato dia/mes/año
$string_fecha= explode('-', $fecha_reserva);
$fecha_formato= $string_fecha[2]."-".$mes[(int)$string_fecha[1]]."-".$string_fecha[0];
$fecha_hora= date('d')."-".$mes[date('n')]."-".date('Y')." ".date('H').":".date('i').":".date('s');
$msgemail="";

$asunto = utf8_decode("Sol"." ". trim($_POST['desc_tipo_espacio']). "-" .$fecha_formato." ".trim($_POST["hora_inicio"])."-".trim($_POST["hora_final"])."-".trim($_POST["nombre_responsable"])."-".trim($_POST["nombre_actividad"]));

// Variable que se utiliza para efectos de pruebas
if ($desarrollo){
  $url= $url_desarrollo_mantis;	
  $url_caso= $url_desarrollo.$sgs_desarrollo."/view.php?id=";
  $correo_solicitante= $correo_pruebas;
  $correo_responsable= $correo_pruebas1;
  $url_proteccion_datos= $url_datos_personales_desarrollo;
  $url_inicio_mantis= $url_inicio_mantis_desarrollo;
}
else {
  $url=$url_produccion_mantis;
  $url_caso= $url_produccion.$sgs_produccion."/view.php?id=";
  $correo_solicitante= $email_solicitante;
  $correo_responsable= $email_responsable;
  $url_proteccion_datos= $url_datos_personales_produccion;
  $url_inicio_mantis= $url_inicio_mantis_produccion;
}		

// Se contruye la url del controlador que crea casos dependiendo de la oficina a la cual va dirigida la solicitud
switch($oficina)
{
	case 'SYRI-Multimedios': 
	 $url= $url.$controlador_multimedios;
	 break;
	 
	case 'SYRI-Operaciones':
	$url= $url.$controlador_operaciones;
	break;
	
	case 'Servicios Generales':
	$url= $url.$controlador_servicios_generales;
	break; 
	
	case 'Planeación Académica':
	 $url= $url.$controlador_planeacion;
	break; 
}

//  Se define el correo y las extensiones de la oficina encargada dependiendo del espacio fisico a reservar
switch($tipo_espacio)
{
	case 'ug':
	$correo_oficina= $espacios_fisicos['espacios_uso_general']['correo']; 
	$extension_oficina= $espacios_fisicos['espacios_uso_general']['extensiones'];
	break;
	
	case 'sc':
	$correo_oficina= $espacios_fisicos['sala computo']['correo']; 
	$extension_oficina= $espacios_fisicos['sala computo']['extensiones'];
	break;
	
	case 'scv':
	$correo_oficina= $espacios_fisicos['salon_con_videoproyector']['correo']; 
	$extension_oficina= $espacios_fisicos['salon_con_videoproyector']['extensiones'];
	break;
	
	case 'ssv':
	$correo_oficina= $espacios_fisicos['salon_sin_videoproyector']['correo']; 
	$extension_oficina= $espacios_fisicos['salon_sin_videoproyector']['extensiones'];
	break;
	
	case 'cg':
	$correo_oficina= $espacios_fisicos['camara_gesell']['correo']; 
	$extension_oficina= $espacios_fisicos['camara_gesell']['extensiones'];
	break;
	
	case 'sbu':
	$correo_oficina=$espacios_fisicos['salon_bienestar_universitario']['correo']; 
	$extension_oficina= $espacios_fisicos['salon_bienestar_universitario']['extensiones'];
	break;
	
	case 'a':
	$correo_oficina= $espacios_fisicos['auditorios']['correo']; 
	$extension_oficina= $espacios_fisicos['auditorios']['extensiones'];
	break;
	
	case 'sa':

	 //if($espacio_fisico== "SDA"){

		/*
		 * @author	Christian David Criollo <cdcriollo@icesi.edu.co>
		* @since	2015-01-28
		* Se adiciono el espacio fisico Sala de reuniones multiple segun caso de soporte 171594 SGS
		*/
	 if($espacio_fisico== "SDA" || $espacio_fisico== "SRMU"){
	   $correo_oficina= $espacios_fisicos['sala_reuniones_direccion']['correo']; 
	   $extension_oficina=$espacios_fisicos['sala_reuniones_direccion']['extensiones'];	 
	 }
	 else if($espacio_fisico=="SVC1" || $espacio_fisico=="SVC2"){
		 $correo_oficina=$espacios_fisicos['sala_videoconferencias_1y2']['correo']; 
	     $extension_oficina= $espacios_fisicos['sala_videoconferencias_1y2']['extensiones']; 
	  }
	  break;
	  
	 case 'l': 
	  if($espacio_fisico=="102F" || $espacio_fisico=="103F"){
		$correo_oficina= $espacios_fisicos['sala_videoconferencias_1y2']['correo']; 
	    $extension_oficina= $espacios_fisicos['sala_videoconferencias_1y2']['extensiones'];       
	  }
	  else{
		 $correo_oficina= $espacios_fisicos['laboratorio']['correo']; 
	     $extension_oficina= $espacios_fisicos['laboratorio']['extensiones'];   
	  }
	  break;	
}

   // Se construye  el texto que ira en la descripcion del caso y en el cuerpo del correo que se envia al usuario
   
      $msg = "Solicitud de"." ".trim($_POST['desc_tipo_espacio'])." - " . $fecha_hora . "\n\n";
	  $msg .= "Datos del solicitante:\n";
	  $msg .= "\tTipo: ". trim($_SESSION['tipo']). "\n";
	  $msg .= "\tDependencia / Programa: ". trim($_SESSION['dependencia_solicitante']). "\n";
	  $msg .= "\tNombre y apellidos: " .trim($_POST["nombre_solicitante"]) . "\n";
	  $msg .= "\tIdentificación: " . trim($_POST["id_solicitante"]) . "\n";
	  
	  if($_SESSION['tipo']== "Estudiante Pregrado" || $_SESSION['tipo']== "Estudiante Postgrado")
	  {
		$msg .= "\tCódigo: " . trim($_POST['codigo_solicitante']) . "\n";  
	  }
	   
	  $msg .= "\tTeléfono: " . trim($_POST["telefono_solicitante"])."\n";
	  $msg .= "\tCorreo electrónico: " .trim($_POST["email_solicitante"])."\n\n";
	
	  $msg .= "Datos del responsable:\n";
	  $msg .= "\tTipo: ". trim($_SESSION['tipo_responsable']). "\n";
	  $msg .= "\tDependencia / Programa: ". trim($_SESSION['dependencia_responsable']). "\n";
	  $msg .= "\tNombre y apellidos: ". trim($_POST["nombre_responsable"]) . "\n";
	  $msg .= "\tIdentificación: " . trim($_POST["id_responsable"]) . "\n";
	  
	  if($_SESSION['tipo_responsable']== "Estudiante Pregrado" || $_SESSION['tipo_responsable']== "Estudiante Postgrado"){
		$msg .= "\tCódigo: ".trim($_POST['codigo_responsable']) . "\n";  
	  }
	  
	  $msg .= "\tTeléfono: ".trim($_POST["telefono_responsable"]) . "\n";
	  $msg .= "\tCorreo electrónico: " . trim($_POST["email_responsable"]) . "\n\n";
	
	  $msg .= "Datos de la reserva:\n";
	  $msg .= "\tNombre de la actividad: " . trim($_POST["nombre_actividad"]) . "\n";
	  $msg .= "\tDescripción de la actividad: " . trim($_POST["descripcion_actividad"])."\n";
	  $msg .= "\tFecha reserva: " . trim($fecha_formato)."\n";
	  $msg .= "\tHora inicial: " . trim($_POST["hora_inicio"]) . "\n";
	  $msg .= "\tHora final: " . trim($_POST["hora_final"]) . "\n";
	  $msg .= "\tEspacio físico: " . trim($_POST['desc_esp_fisico']) . "\n";
	  
	  if($tipo_espacio=="sc")
	  {
		 $msg .="\tSoftware primario: ". trim($_POST["software_principal"])."\n"; // se visualiza como <codigo> <nombre>
		 $msg .="\tSoftware secundario: ".trim($_POST["software_secundario"])."\n"; // se visualiza como <codigo> <nombre>   
	  }
          
          if($tipo_espacio=="a")
	  {
	      $msg .="\tRequiere zona de recibo: ". trim($_POST["zonarecibo"])."\n"; // Se muestra en la descripcion del caso si el usuario requiere zona de recibo 
	  }
	  
	  $msg.= "\tNúmero de personas: " . trim($_POST["numero_personas"])."\n";
	  $msg.= "\tObservaciones: " . trim($_POST["observaciones"])."\n\n";
	  
	  
	  $msg.="Su solicitud de reserva de"." ".trim($_POST['desc_tipo_espacio']). " ha sido enviada con éxito. Por favor espere respuesta por parte de la Oficina de ".$oficina."\n\n";
	$msg.="Información de la oficina\n";
	$msg.="\tCorreo: ".$correo_oficina."\n";
	$msg.="\tTeléfono: 555 2334 ext. ".$extension_oficina."\n\n";


//Se construye el array con los datos que se enviaran a los respectivos controladores
$postData = array("correo_oficina" =>$correo_oficina, "oficina" => $oficina, 'telefono_oficina'=> $extension_oficina, 'nombre_solicitante'=> $nombre_solicitante, 'id_solicitante'=> $id_solicitante, 'telefono_solicitante'=> $telefono_solicitante, 'email_solicitante'=> $email_solicitante, 'nombre_responsable'=> $nombre_responsable, 'id_responsable'=> $id_responsable, 'telefono_responsable'=> $telefono_responsable, 'email_responsable'=> $email_responsable, 'nombre_actividad'=> $nombre_actividad, 'descripcion_actividad'=> $descripcion_actividad, 'fecha_reserva'=> $fecha_reserva, 'hora_inicio'=> $hora_inicio, 'hora_final'=> $hora_final, 'numero_personas'=> $numero_personas, 'observaciones'=> $observaciones, 'tipo_espacio'=> $tipo_espacio, 'espacio_fisico'=> $espacio_fisico, 'desc_tipo_espacio'=> $descripcion_tipo, 'desc_esp_fisico'=>$descripcion_espacio, 'software_principal'=>$software_principal, 'software_secundario'=>$software_secundario, 'cod_soft_principal'=> $codigo_software_p, 'cod_soft_secundario'=>$codigo_software_s, 'msg'=> $msg, 'asunto'=> $asunto); 

// Se valida que los campos email responsable, email solicitante, telefono responsable y telefono del solicitante no esten vacios

if ($_POST['telefono_solicitante'] != '' && $_POST['email_solicitante'] !='' && $_POST['telefono_responsable'] != '' && $_POST['email_responsable']!= '')
{

//Se instancia un objeto de la clase curl
$caso_mantis= new curl();

// Se hace la conexion http a la url especificada y se envian los parametros por POST
$id_caso= $caso_mantis->post($url, $postData);
// Se comprueba que el caso haya sido creado o no sea nulo

//$idcasoerror= 'ERROR -2';

$cadenaerror= "ERROR";
$pos= strpos($id_caso, $cadenaerror);

if($id_caso >= 0 && $pos===false)
{	
	$msg_saludo= "Cordial saludo, \n\n";
	$msg_inicio= "Hemos registrado los siguientes datos respecto a su solicitud de reserva \n\n";
	$msg_sgs.= "Su solicitud de reserva de"." ".trim($_POST['desc_tipo_espacio'])." ". "ha sido recibida por la Oficina de"." ".$oficina." y podrá hacerle seguimiento a través del Sistema de Gestión de Solicitudes \n\n en el siguiente enlace:\n\t"
.$url_caso.$id_caso."\n\n";

  $msg_final="Estos datos han sido registrados para propósitos de contacto, en caso de alguna eventualidad con su solicitud, la información personal del solicitante y/o responsable que fueron modificadas para esta solicitud no han sido actualizadas en nuestras bases de datos.";

	
	$mensaje= $msg_saludo.$msg_sgs.$msg_inicio.$msg.$msg_final;
	
	//Se instancia un objeto de la clase phpmailer
	$email= new phpmailer();
	// Asignando el tipo de envío de correo
    $email->IsMail();
    // Asignando la dirección de correo
    $email->AddAddress($correo_solicitante);
	// Se envia correo con copia al responsable de la reserva
	$email->AddCC($correo_responsable); 
    // Agregando el correo del remitente
    $email->From = $correo_remitente;
    // Agregando el nombre del remitente
    $email->FromName = utf8_decode($oficina);
    // Agregando el asunto
    $email->Subject = $asunto;
    // Agregando el cuerpo del correo
    $email->Body= utf8_decode($mensaje);
	//Se envia el correo
	$exito= $email->Send();
	
  /*Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas  
  para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
  del anterior, para ello se usa la funcion sleep*/
  	
  /*$intentos=1; 
  
  while ((!$exito) && ($intentos < 3)) {
	sleep(5);
     	$exito = $email->Send();
     	$intentos=$intentos+1;	
   }
 		
   if(!$exito)
   {
	$msgemail= "Problemas enviando correo electrónico a ".$correo_pruebas." "."<br/>".$email->ErrorInfo;
	
   }*/
   
   
    //llamado metodo clase proteccion de datos
  $proteccion_datos= new datos_personales($aceptacion,$correo,$documento,$ip, $sistema, $periodo_acad, $per_consecutivo, $respuesta,       $entramite,$lider,$motivo,$negacion, $url_proteccion_datos);
  $proteccion_datos->insertar_datos_personales();
   
	// Se envia la respuesta a la vista
  $url_sgs= "<a target='_blank' href=".$url_caso.$id_caso.">ir al caso </a>";
  $response=array('id_caso'=> $id_caso, 'oficina'=> $oficina, 'reserva'=> $descripcion_tipo, 'url_caso'=> $url_sgs, 'status_email'=> $exito);
  echo json_encode($response);	
  
 
  
}
else{
 $url_sesion_mantis= "si usted nunca ha ingresado al SGS por favor <a href= ". $url_inicio_mantis." target=_blank >inicie sesión en el sistema</a> e intente enviar la solicitud nuevamente.";	
 $response= array('id_caso'=> -1,'reserva'=> $descripcion_tipo, 'url_sesion_mantis'=> $url_sesion_mantis);
 echo json_encode($response);	
}
} // cierra validacion campos
else
{
	$response=array('error'=> 4, 'mensaje'=> "Existen datos vacios en el formulario por favor actualice sus datos");
	echo json_encode($response);
}


?>