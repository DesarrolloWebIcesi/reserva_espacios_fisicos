
<?php

/*
* Controlador cargar_datos
*
* Controlador que se encarga de cargar previamente los datos del responsable si este es estudiante o profesor hora catedra
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-24
*/

session_start();

// Controlador que trae los datos del responsable

if(isset($_POST['option'])== 'checkuser')
{
  // Rol del solicitante	
  $rol_solicitante=	$_SESSION['tipo'];
  $dependencia_usuario= $_SESSION['dependencia_solicitante'];
	
	// Se realiza la comprobación del rol del usuario
	if($rol_solicitante== 'Profesor Hora Catedra' || $rol_solicitante== 'Estudiante Pregrado' || $rol_solicitante== 'Estudiante Postgrado' )
	{   
	    $identificacion= $_SESSION['cedula'];
		$nombres= $_SESSION['nombre_completo'];
		$email=$_SESSION['correo_electronico'];
		$telefono=$_SESSION['telefono']; 
		$celular= $_SESSION['celular']; 
		$_SESSION['tipo_responsable']= $rol_solicitante;
		$_SESSION['dependencia_responsable']= $dependencia_usuario;
		// Se envia la respuesta en json a la vista
		$response= array('tipo'=> 1, 'cedula'=> $identificacion, 'nombres'=>utf8_encode($nombres), 'correo'=>$email, 'telefono'=>$telefono, 'celular'=> $celular, 'codigo'=> $_SESSION['codigo'], 'dependencia'=> $dependencia_usuario);
		echo json_encode($response);
	}
	else
	{
      // Se envia la respuesta en json a la vista 
  	  $response= array('tipo'=> 0);
	  echo json_encode($response); 	
	}
}

?>