<?php

/*
* usuario
*
* Clase que atraves de metodos auxiliares obtiene información del usuario que solicita la reserva
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-10-07
*/

class usuario 
{   
    // Rol del usuario
	private $rol_usuario;
	//Identificación del usuario
	private $identificacion;
	//Archivo de conexión a la base de datos
	private $conexion;
	
	 // Metodo constructoe de la clase	
    public function __construct($rol_usuario, $identificacion, $conexion ) 
	{  
      $this->rol_usuario= $rol_usuario;
	  $this->identificacion=$identificacion;
	  $this->conexion=$conexion;
  
    }
	
	// Metodo que retorna la dependencia de un usuario
	public function obtenerDependenciaUsuario()
   {
	   $dependencia_conexion= new OracleServices($this->conexion);
	   $dependencia_conexion->conectar(); 
	   $sql="";
	      
	   switch($this->rol_usuario)
	   {
		   case 'colaborador':
		   //Consulta colaboradores
		   $sql= "select DAT.NOMBRE_MOSTRAR
		   from VMBAS_USUARIOS_ACTUALES_MIN usu, VMBAS_USUARIOS_ACTUALES2 dat
		   where USU.IDENTIFICACION =  DAT.IDENTIFICACION
		   and usu.IDENTIFICACION= '".$this->identificacion."'
		   and DAT.CODIGO like 'UO%'";
		  
		   break;
		  
		   case 'Estudiante Pregrado':
		    // Consulta estudiantes de pregrado
		    $sql= "select PRO.DESCRIPCION
			from VMBAS_USUARIOS_ACTUALES_MIN usu, tbas_alumnos alu, tbas_programas pro
			where USU.IDENTIFICACION = ALU.NUMID
			and usu.IDENTIFICACION= '".$this->identificacion."'
			and PRO.CODIGO = SUBSTR(fprebus_cod_prog_estud(ALU.CODIGO, 'S'),0,2)";
		  
		   break;
		   
		   case 'Estudiante Postgrado':
		    // Consulta estudiantes de posgrado
		    $sql= "select PRO.NOMBRE
			from VMBAS_USUARIOS_ACTUALES_MIN usu, estudiante_pos alu, programa pro
			where USU.IDENTIFICACION = ALU.DOCUMENTO_ID
			and usu.IDENTIFICACION= '".$this->identificacion."'
			and PRO.CODIGO = SUBSTR(FPOSBUS_PROG_ESTUDIANTE(ALU.CODIGO),0,2)";
		   break;
		   
		   case 'Profesor Hora Catedra':
		   //Consulta de profesores 
		   $sql= "select da.DESCRIPCION from TBAS_PROFESORES p, TBAS_DEPTOS_ACAD da
           where p.dpto_acad_codigo= da.codigo and p.cedula= '".$this->identificacion."' and retirado= 'N'";
		   break;
		   
		   case 'Empleado Temporal':
		   //Consulta de empleados temporales 
		   $sql="select d.descripcion from EMP_DEP_TEMP edt, dependencia d, EMPLEADOS_TEMP e
		   where edt.CODIGO_DEP= d.CODIGO
		   and e.CEDULA= edt.CEDULA
		   and e.CEDULA= '".$this->identificacion."'
		   and e.ACTIVO='S'";
		   break;
		  
	   }// fin switch
	   
	   $resultado= $dependencia_conexion->ejecutarConsulta($sql);
	   $result=$dependencia_conexion->siguienteFila($resultado);
			   
	   if($dependencia_conexion->numFilas($resultado) > 0)
	   {
		  return $dependencia=utf8_encode(ucwords(mb_strtolower($result[0]))); 
	   }
	   else
	   {
		 return $dependencia= "Universidad Icesi";   
	   }
	   
	   // Se cierra la conexion BD
	  $dependencia_conexion->desconectar();    
	   
   }// cierra función
	
}//  cierra clase

?>