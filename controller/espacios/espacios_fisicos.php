<?php 

/*
* controlador espacios_fisicos
*
* Controlador encargado de comunicarse con la clase espacios y la vista
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-20
*/

session_start();

include_once("../../class/espacios.php");
include_once("../../config/configuration.php");

// Se obtienen los diferentes tipos de espscios que se pueden reservar dependiendo del rol del usuario que se autentico
if($_POST['option']== 'tesp')
{
	$tipo= $_SESSION['tipo'];
	$tipoespacio= new espacios();
	$htmlselect= $tipoespacio->obtenerTipoEspacio($tipo);
	echo $htmlselect;

}

//Se obtiene los espacios fisicos de los diferentes tipos de espacio
else if($_POST['option']== 'esp_fis')
{
	if(isset($_POST['tespacio']))
	{
		$espaciofisico= new espacios();
		$htmlespacio= $espaciofisico->obtenerEspacioFisico($_POST['tespacio']);
		echo $htmlespacio;
	}
}

// Se obtiene los dias de antelacion para la reserva de los espacios fisicos
else if($_POST['option']== 'getAntelacion')
{
	if(isset($_POST['tipoespacio']) && isset($_POST['espacio']))
	{
		$espaciofisico= new espacios();
		
	  switch($_POST['tipoespacio'])
	  {
		  case 'scv':
		    $diasAntelacion= $salon_con_video;
			$descripcion_espacio= 'Salón con videoproyector';
			$oficina= 'SYRI-Multimedios';
			$correo_oficina=$espacios_fisicos['salon_con_videoproyector']['correo']; 
	        $extension_oficina=$espacios_fisicos['salon_con_videoproyector']['extensiones']; 
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio); 
		    echo json_encode($response);
		  break;
		  
		  case 'cg':
		    $diasAntelacion= $camara_gesell;
			$descripcion_espacio= 'Cámara de Gesell';
			$oficina= 'SYRI-Multimedios';
		    $correo_oficina= $espacios_fisicos['camara_gesell']['correo']; 
	        $extension_oficina= $espacios_fisicos['camara_gesell']['extensiones'];
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio); 
		    echo json_encode($response);
		  break;
		  
		  case 'sbu':
		    $diasAntelacion=$salon_bienestar;
			$descripcion_espacio= 'Salón de bienestar universitario';
			$oficina= 'Planeación Académica';
			$correo_oficina= $espacios_fisicos['salon_bienestar_universitario']['correo']; 
	        $extension_oficina= $espacios_fisicos['salon_bienestar_universitario']['extensiones'];
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio); 
		    echo json_encode($response);
		  break;
		  
		  case 'l':
		  	
		  	if($_POST['espacio']=="102F" || $_POST['espacio']=="103F")
		  	{
		  		$diasAntelacion= $laboratorios;
		  		$descripcion_espacio= 'Laboratorios';
		  		$oficina= 'SYRI-Multimedios';
		  		$correo_oficina= $espacios_fisicos['laboratorios_multimedios']['correo'];
		  		$extension_oficina= $espacios_fisicos['laboratorios_multimedios']['extensiones'];
		  	}
		  	else
		  	{
			    $diasAntelacion= $laboratorios;
				$descripcion_espacio= 'Laboratorios';
				$oficina= 'Planeación Académica';
				$correo_oficina= $espacios_fisicos['laboratorio']['correo']; 
		        $extension_oficina= $espacios_fisicos['laboratorio']['extensiones'];
		  	} 
		  	 
		     $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio); 
		     echo json_encode($response);
		     break;
		  
		  case 'a':
		    $diasAntelacion= $auditorios;
			$descripcion_espacio= 'Auditorios';
			$oficina= 'Planeación Académica';
			$correo_oficina= $espacios_fisicos['auditorios']['correo']; 
	        $extension_oficina= $espacios_fisicos['auditorios']['extensiones'];
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio);  
		    echo json_encode($response);
		  break;
		  
		  case 'sc':
		    $diasAntelacion= $sala_computo;
			$descripcion_espacio= 'Sala de Cómputo';
			$oficina= 'SYRI-Operaciones';
			$correo_oficina= $espacios_fisicos['sala computo']['correo']; 
	        $extension_oficina= $espacios_fisicos['sala computo']['extensiones'];
		   $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio); 
		    echo json_encode($response);
		  break;
		  
		  case 'ug':
		    $diasAntelacion= $espacios_uso_general;
			$descripcion_espacio= 'Espacios de uso general';
			$oficina= 'Servicios Generales';
			$correo_oficina= $espacios_fisicos['espacios_uso_general']['correo']; 
	        $extension_oficina=$espacios_fisicos['espacios_uso_general']['extensiones'];
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio);  
		    echo json_encode($response);
		  break;
		  
		  case 'sa':
		   if($_POST['espacio']=="SVC1" || $_POST['espacio']=="SVC2")
		   {
		    $diasAntelacion= $saladereunionesyvideoconferencias;
			$descripcion_espacio= 'Sala de reuniones';
			$oficina= 'SYRI-Multimedios';
			$correo_oficina= $espacios_fisicos['sala_videoconferencias_1y2']['correo']; 
	        $extension_oficina= $espacios_fisicos['sala_videoconferencias_1y2']['extensiones']; 
		    $response= array('dias'=> $diasAntelacion, 'correo'=>$correo_oficina, 'extension'=> $extension_oficina, 'oficina'=> $oficina, 'espacio'=> $descripcion_espacio);  
		    echo json_encode($response);
		   }
			break;
		  
		  
	  }// cierra switch
		
	}
}

// Se obtienen las url de los ANS y condiciones de uso de los tipos de espacio 
else if($_POST['option']== "getANS")
{
	
 if(isset($_POST['tipo_espacio']))
 {	
	switch($_POST['tipo_espacio'])
	  {
		  case 'scv':
		    $url_ans= $reserva_salon_video_proyector;
			//$url_condiciones= 'about:blank';
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'ssv':
		    $url_ans= $reserva_salon_sin_videoproyector;
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'cg':
		    $url_ans= '../view/info.php?mensaje=1';
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'sbu':
		    $url_ans= '../view/info.php?mensaje=1';
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'l':
		    $url_ans= $reserva_laboratorios;
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'a':
		    $url_ans= $reserva_auditorios;
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'sc':
		    $url_ans=$reserva_salas_computo;
			$url_condiciones= $condiciones_uso_salacomputo;
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'ug':
		    $url_ans= $reserva_espacios_general;
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		  break;
		  
		  case 'sa':
		   if($_POST['espacio']=="SVC1" || $_POST['espacio']=="SVC2")
		   {
		    $url_ans= $reserva_sala_reuniones_videoconferencias;
			$url_condiciones= '../view/info.php?mensaje=2';
		    $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		    echo json_encode($response);
		   }
		   else if($_POST['espacio']=="SDA"){
			 $url_ans= $reserva_saladereunionesdacad;
			 $url_condiciones= '../view/info.php?mensaje=2';
		     $response= array('ans'=> $url_ans, 'condiciones_uso'=>$url_condiciones); 
		     echo json_encode($response);  
		   }
		  break;
	  }// cierra switch
  }
	
}

?>