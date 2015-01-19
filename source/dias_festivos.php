<?php
/*
* Script dias-festivos
*
* script php que se encarga de traer los dias festivos del año en curso y almacenarlos en un array
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-08-21
*/

include_once("../model/OracleServices.php");
$ano= date('Y');
$formato= 'j-m-Y';
$fecha_actual= date('j-m-Y');
$fecha_fin= "31-12-".$ano."";
$dias_festvos= array();


$festivos= new OracleServices('../config/.configsiaepre');
$festivos->conectar();
$sql= "SELECT festivo FROM tbas_dias_festivos WHERE FESTIVO between to_date('$fecha_actual', 'dd/mm/yyyy') AND to_date('$fecha_fin','dd/mm/yyyy')";
$result=$festivos->ejecutarConsulta($sql);
$fila= $festivos->siguienteFila($result);
	  
  while (($row = oci_fetch_array($result, OCI_BOTH)) != false)  
  {
	  $festivo = split("/", $row['FESTIVO']);
	  $dias_festvos[] = date($formato, mktime (0,0,0,$festivo[1], $festivo[0], $festivo[2]));  
  }
  
 var_dump($dias_festvos);
	  
	  // Se cierra la conexion BD
	 $festivos->desconectar();


?>