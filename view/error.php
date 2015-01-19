<?php

/*
* error
*
* script para el manejo de errores de acceso no autorizado a algunos formularios 
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-07-16
*/

 session_start();
  
  if ($_SESSION['cedula']=="")
  {
    echo "<script language='javaScript'> ".
    "location.href='../index.php' </script>";
  }
  
  switch($_GET['mensaje'])
	{
		case 1:
			$mensaje = "No tiene los permisos suficientes para acceder a este formulario";							
		break;
		  $mensaje = "No tiene los permisos suficientes para acceder al listado de espacios fisicos";
		case 2:
		 $mensaje = "¡Solo los usuarios que hayan iniciado sesión en el sistema y tengan rol Colaborador pueden acceder a este listado directamente!";
		break;
		default:
			$mensaje = "Error desconocido";
		break;
	}
  
  
 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reserva de espacios fisicos - Universidad Icesi - Cali, Colombia</title>

<!-- css -->
<link rel="stylesheet" href="../css/error.css">


</head>

<body>

<div><?php include_once('../elements/cabezote.php');?></div>

<div class="container" style="width:100%">
  
  <div class="content">
  
  <div class="div-mensaje">
   <p id="text-form"> <?php echo $mensaje; ?></p>
  </div>
     
    
  </div> <!-- end .content -->
 
  <!-- end .container --></div>
  
  <div><?php include_once('../elements/footer.php');?></div>
   
</body>
</html>