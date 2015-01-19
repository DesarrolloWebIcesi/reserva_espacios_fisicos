<?php

session_start();
/*
* Clase AutenticaLdap
*
* Clase para operaciones de autenticación de usuarios contra LDAP
* @author		Alejandro Orozco <aorozco@icesi.edu.co>
* @since	  2010-02-01
*/

include_once("../model/OracleServices.php");

class AutenticaLdap
{
	private $dnAnonimo = "cn=busqueda,cn=dsistemas,cn=users,dc=icesi,dc=edu,dc=co";
	private $passAnonimo = "lK3Bs0o";
	private $servidor_ldap="ldap://iden.icesi.edu.co/";
	private $dn = "";
	
	function autenticarUsuario($nombreUsuario, $clave)
	{
		$this->servidor_ldap="ldap://iden.icesi.edu.co/";
		
		if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3))
		{
			return 3;
		} 
		
		//Busqueda de información del usuario
		if($this->buscarUsuario($nombreUsuario, false))
		{
			//Antes del bind se podria hacer la condicion para establecer el tipo de usuario usando $this->dn
			$ds =ldap_connect($this->servidor_ldap);
			if(!$ds) 
			{
				return 3;
			}
			$bind = @ldap_bind($ds, $this->dn, $clave); 
		}
		else
		{
		   return 1;
		}
		
		if($bind)
		{	
			if(strpos($this->dn, "colaboradores")==true)
			{
				$_SESSION['tipo']='colaborador';
				
			}
			else if (strpos($this->dn, "pregrado")==true)
			{
				$_SESSION['tipo']='Estudiante Pregrado';
			}
			else if (strpos($this->dn, "profesores")== true)
			{
				$_SESSION['tipo']= "Profesor Hora Catedra";
			}
			else if(strpos($this->dn, "postgrado") == true)
			{
				$_SESSION['tipo']= "Estudiante Postgrado";
			}
			else if(strpos($this->dn, 'temporales')== true)
			{
				$_SESSION['tipo']= "Empleado Temporal";
			}
			else
			{
				$_SESSION['tipo']= "otro";
			}
			
			return 0;
			
		}
		return 2;
	}
	
	function autenticarUsuarioColaborador($nombreUsuario, $clave)
	{
		$this->servidor_ldap="ldap://iden.icesi.edu.co/";
		
		if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3))
		{
			return 3;
		} 
		
		//Busqueda de información del usuario
		if($this->buscarUsuario($nombreUsuario, false))
		{
			//Antes del bind se podria hacer la condicion para establecer el tipo de usuario usando $this->dn
			if(strpos($this->dn, "colaboradores")===false)
			{
				return 4;
			}
			else
			{
				$ds =ldap_connect($this->servidor_ldap);
				if(!$ds) 
				{
					return 3;
				}
				
				$_SESSION['tipo']='colaborador';
			}
			$bind = @ldap_bind($ds, $this->dn, $clave); 
		}
		else
		{
				return 1;
		}
		if($bind)
		{
			return 0;
		}
		return 2;
	}
	
	function buscarUsuario($idUsuario, $imprimirInformacion){
		$dsAnonimo =ldap_connect($this->servidor_ldap);
		$bindAnonimo = @ldap_bind($dsAnonimo, $this->dnAnonimo, $this->passAnonimo);
		$filtro="(cn=$idUsuario)";
		$sr=ldap_search($dsAnonimo, "cn=users,dc=icesi,dc=edu,dc=co", $filtro);
		$entries = ldap_get_entries($dsAnonimo, $sr);
		if(count($entries) > 0)
		{
			/*$_SESSION['nombre_completo']=$entries[0]['givenname'][0]." ".$entries[0]['sn'][0];
			$_SESSION['correo_electronico']=$entries[0]['mail'][0];
			$_SESSION['dn']=$entries[0]['dn'];
			$_SESSION['telefono']=$entries[0]['homephone'][0];*/
			
			$this->dn = $entries[0]['dn'];
			
			if(strpos($this->dn, "colaboradores")==true)
			{
			    $datos_resp= new OracleServices('../config/.config');
		        $datos_resp->conectar();
			    $sql= "select nombre_mostrar, correo_electr, extension, tel_residencia, celular, usuario from EMPLEADO where cedula='".$idUsuario."' and correo_electr is not null and nombre_mostrar is not null and activo='S'";
			   $resultado= $datos_resp->ejecutarConsulta($sql);
		       $result=$datos_resp->siguienteFila($resultado);
			   
			   if($datos_resp->numFilas($resultado) > 0)
		       {
				   $_SESSION['nombre_completo']= utf8_encode($result[0]);
				   $_SESSION['correo_electronico']=$result[1];
				   $_SESSION['extension']= $result[2];
				   $_SESSION['telefono']=$result[3];
				   $_SESSION['celular']=$result[4];
				   $_SESSION['codigo']= $result[5];
				   $_SESSION['dn']=$entries[0]['dn'];
				   
			   }
				
			}
			else 
			{
				$datos_resp= new OracleServices('../config/.config');
				$datos_resp->conectar();
				$sql= "select nombre_mostrar, codigo, correo_electronico, telefono_res, celular from VMBAS_USUARIOS_ACTUALES_MIN where identificacion= '".$idUsuario."' and correo_electronico is not null and nombre_mostrar is not null ";
				$resultado= $datos_resp->ejecutarConsulta($sql);
				$fila=$datos_resp->siguienteFila($resultado);
				
				$_SESSION['nombre_completo']= utf8_encode($fila[0]);
				$_SESSION['codigo']= $fila[1];
				$_SESSION['correo_electronico']=$fila[2];
				$_SESSION['telefono']=$fila[3];
				$_SESSION['celular']=$fila[4];
				$_SESSION['dn']=$entries[0]['dn'];
			}
			
			//Se cierra la conexión con la base de datos
			$datos_resp->desconectar();
			
			//$this->dn = $entries[0]['dn'];
			
			if($imprimirInformacion)
			{
				echo "<pre>".print_R($entries[0])."</pre><script languaje='Javascript'>
			    alert('Mire los datos!!!');</script>";
			}
			ldap_unbind($dsAnonimo);
			return true;
		}
		ldap_unbind($dsAnonimo);
		return false;
	}
}
?>