<?php

/*
* Listado de espacios fisicos
*
* Listado con los espacios fisicos disponibles para reserva
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-06-26
*/

session_start();

if ($_SESSION['cedula']=="")
{
	echo "<script language='javaScript'> location.href='../index.php' </script>";	
}
else
{
	if ($_SESSION['tipo'] != "colaborador")
	{
		echo "<script language='javaScript'> location.href='../view/error.php?mensaje=2' </script>";   
	}
}

include_once('../model/OracleServices.php');


$reporte= new OracleServices('../config/.config');
$reporte->conectar();
$sql=  "SELECT CODIGO, DESCRIPCION, CAPACIDAD FROM TBAS_ESPACIOS_FISIC WHERE ESTADO='A' ORDER BY TIPO, BLOQUE";  
$resultado= $reporte->ejecutarConsulta($sql);
$fila= $reporte->siguienteFila($resultado);
$espacios= array();
?>

<p style="text-align:center"><a href="../source/exportListado.php"><img src="../images/logopdf.png" title="Exportar a PDF"/></a></p>

<table cellpadding="0" cellspacing="0" border="1" align="center" width="600">
<tr>
 <td colspan="3"><div><img style="float: left; vertical-align:middle; padding:0px 10px 10px 10px" src="../images/logo_icesi.png" /> <p style="text-align:center;"><b>DIRECCI&OacuteN DE SERVICIOS Y RECURSOS DE INFORMACI&OacuteN </b> </br> <b>LISTADO DE ESPACIOS F&IacuteSICOS</b></p> </div></td>
</tr>

<tr style="background-color:#CCC">
 <th>C&oacutedigo</th> 
 <th>Descripci&oacuten </th> 
 <th>Capacidad</th> 
</tr>

<tr>
 <td><?php echo $fila[0]; ?></td>
 <td><?php echo htmlentities(utf8_encode($fila[1]), ENT_QUOTES); ?></td>
 <td><?php echo $fila[2]; ?></td>
</tr>

	  
<?php 

$datos['CODIGO']=$fila[0];
$datos['DESCRIPCION'] = utf8_encode($fila[1]);
$datos['CAPACIDAD'] =$fila[2];
$espacios[]=$datos;

while (($row = oci_fetch_row($resultado)) != false ) 
{

   $datos['CODIGO']=$row[0];
   $datos['DESCRIPCION'] = utf8_encode($row[1]);
   $datos['CAPACIDAD'] =$row[2];
   $espacios[]=$datos;
	
?>

<tr>
 <td><?php echo $row[0]; ?></td>
 <td><?php echo htmlentities(utf8_encode($row[1]), ENT_QUOTES); ?></td>
 <td><?php echo $row[2]; ?></td>
</tr>
  
<?php }
?>

</table>
	  
<?php // Se cierra la conexion BD
$reporte->desconectar(); 
$_SESSION['datos_listado']= $espacios; 
//print_r($_SESSION['datos_listado']);  
?>