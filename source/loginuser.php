<?php 
session_start();
    
/*
* Script loginuser
*
* script que se encarga de valdar que el usuario existe dentro del directorio activo con los datos proporcionados en el formulario de login
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-13
*/
	
	
	include_once("../class/AutenticaLdap.php");
	include_once("../class/usuario.php");
	
	$autentica = new AutenticaLdap();
	$log = $_POST['cedula'];
	$pass = $_POST['password'];
	
	$aut = $autentica->autenticarUsuario($log,$pass);
	switch($aut)
	{
		case 0:
		
			//$_SESSION['cedula'] = $log;
			if($_SESSION['tipo']== "otro")
			{
			   $_SESSION['cedula'] = "";	
			   $respuesta= array('error'=> 4);
			   echo json_encode($respuesta);
			}
			else
			{
				$_SESSION['cedula'] = $log;
				// Se asigna el tiempo de inicio de sesión
				$_SESSION["time"] = time();
				$usuario = new usuario($_SESSION['tipo'], $log, '../config/.config');
				$_SESSION['dependencia_solicitante']= $usuario->obtenerDependenciaUsuario(); 
				$respuesta= array('error'=> $aut);
				echo json_encode($respuesta);
			}
		break;
		case 1:
			$respuesta= array('error'=> $aut);
			echo json_encode($respuesta);
		break;
		case 2:
			$respuesta= array('error'=> $aut);
			echo json_encode($respuesta);
		break;
		case 3:
			$respuesta= array('error'=> $aut);
			echo json_encode($respuesta);
		break;
		case 4:
		   $respuesta= array('error'=> $aut);
		   echo json_encode($respuesta);
		break;
		default:
			$respuesta= array('error'=> $aut);
			echo json_encode($respuesta);
		break;
    }
 
?>
