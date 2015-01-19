<?php
/*
* Script soft_secundario
*
* script php que se encarga de traer el software secundario dependiendo del software principal que se seleccione y los espacios fisicos en donde este se encuentre. 
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-08-20
*/

include_once("../model/OracleServices.php");

// id del software principal seleccionado 
$id= $_GET['id'];

$software= new OracleServices('../config/.config');
$software->conectar();
$sql= "SELECT DISTINCT A.RECURSO_CODIGO, B.DESCRIPCION FROM TBAS_RECURSOS_ESPACIO A, TBAS_RECURSOS B WHERE ESPACIO_CODIGO IN
(SELECT C.ESPACIO_CODIGO FROM TBAS_RECURSOS_ESPACIO C, TBAS_ESPACIOS_FISIC D WHERE C.ESPACIO_CODIGO = D.CODIGO AND C.RECURSO_CODIGO = '".$id."') AND A.RECURSO_CODIGO= B.CODIGO AND A.recurso_codigo like 'SW%' ORDER BY B.DESCRIPCION";
		  
	  
	  $result=$software->ejecutarConsulta($sql);
	  $fila= $software->siguienteFila($result);
	  
	  echo '<option value="'.htmlentities("Ninguno").'">Ninguno</option>'; 
	  echo '<option value="'.htmlentities($fila['RECURSO_CODIGO']).'">'.htmlentities($fila['DESCRIPCION']).'</option>'; 
	  while (($row = oci_fetch_array($result, OCI_BOTH)) != false)  
	  {
        echo '<option value="'.htmlentities($row['RECURSO_CODIGO']).'">'.htmlentities($row['DESCRIPCION']).'</option>'; 
      }
	  
	  // Se cierra la conexion BD
	 $software->desconectar();


?>