
<?php

/*
* Controlador datos_responsable
*
* Controlador que se encarga de consultar los datos del responsable y se envia como parametro la cedula del usuario 
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-23
*/

session_start();

// Controlador que trae los datos del responsable

include_once("../../model/OracleServices.php");
include_once("../../class/usuario.php");

if(isset($_POST['option'])== 'datosresp')
{
	if(isset($_POST['identificacion']))
	{
		$identificacion= $_POST['identificacion'];
		$datos_resp= new OracleServices('../../config/.config');
		$datos_resp->conectar();
		$sql= "select nombre_mostrar, correo_electronico, telefono_res, celular, grp, codigo from VMBAS_USUARIOS_ACTUALES_MIN where identificacion= '".$identificacion."' and correo_electronico is not null and nombre_mostrar is not null ";
		$resultado= $datos_resp->ejecutarConsulta($sql);
		$fila=$datos_resp->siguienteFila($resultado);
		
		if($datos_resp->numFilas($resultado) > 0)
		{
			
		   if(strpos($fila[4], "colaboradores")==true)
		   { 
		      $_SESSION['tipo_responsable']='colaborador';
			  $datos_resp= new OracleServices('../../config/.config');
		      $datos_resp->conectar();
			  $sql= "select nombre_mostrar, correo_electr, extension, tel_residencia, celular, usuario from EMPLEADO where cedula='".$identificacion."' and correo_electr is not null and nombre_mostrar is not null and activo='S' ";
			  $resultado= $datos_resp->ejecutarConsulta($sql);
		      $result=$datos_resp->siguienteFila($resultado);
			  
			  //Se obtiene la dependencia a la que pertenece el usuario
			  $usuario= new usuario($_SESSION['tipo_responsable'], $identificacion, '../../config/.config');
			  $_SESSION['dependencia_responsable']= $usuario->obtenerDependenciaUsuario();
		
			   	
			  $response= array('error'=> 0, 'tipo'=> $tipo, 'nombre'=> utf8_encode($result[0]), 'correo'=> utf8_encode($result[1]), 'extension'=> $result[2], 'tel_residencia'=> $result[3], 'celular'=> $result[4], 'codigo'=> $result[5], 'tipo_responsable'=> $_SESSION['tipo_responsable'], 'dependencia_responsable'=> $_SESSION['dependencia_responsable']);
			  echo json_encode($response);
		    }
			else if (strpos($fila[4], "pregrado")==true || strpos($fila[4], "postgrado")== true  || strpos($fila[4], "profesores")== true || strpos($fila[4], "temporales") )
			{
				 if (strpos($fila[4], "profesores")== true)
				 {
				   $_SESSION['tipo_responsable']= "Profesor Hora Catedra";  
				 }
				 else if(strpos($fila[4], "postgrado") == true)
				 {
				   $_SESSION['tipo_responsable']= "Estudiante Postgrado";
				 }
				 else if(strpos($fila[4], "pregrado") == true)
				 {
				   $_SESSION['tipo_responsable']= "Estudiante Pregrado";
				 }
				  else if(strpos($fila[4], "temporales") == true)
				 {
				   $_SESSION['tipo_responsable']= "Empleado Temporal";
				 }
				 
				 //Se obtiene la dependencia a la que pertenece el usuario
			     $usuario= new usuario($_SESSION['tipo_responsable'], $identificacion, '../../config/.config');
			     $_SESSION['dependencia_responsable']= $usuario->obtenerDependenciaUsuario();
				
				 $response= array('error'=> 0, 'tipo'=> $tipo, 'nombre'=> utf8_encode($fila[0]), 'correo'=>utf8_encode($fila[1]), 'telefono'=> $fila[2], 'celular'=>$fila[3], 'codigo'=> $fila[5], 'tipo_responsable'=> $_SESSION['tipo_responsable'],'dependencia_responsable'=> $_SESSION['dependencia_responsable']);
				 echo json_encode($response);	
			 
			}
			else
			{
			  $response= array('error'=>2);
			  echo json_encode($response);	
			}
			
		}
		else
		{   // Se envia la respuesta a la vista con un parametro de error 
			$response= array('error'=> 1);
			echo json_encode($response);
		}
		
		//Se cierra la conexion con la base de datos
		$datos_resp->desconectar();	
    }
}



?>