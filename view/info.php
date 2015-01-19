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
			$mensaje = "Este espacio fisico no posee ANS (Acuerdo Nivel Servicio)";							
		break;
		case 2:
		 $mensaje = "Este espacio fisico no posee condiciones de uso";
		break;
	}
  
  
 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reserva de espacios fisicos - Universidad Icesi - Cali, Colombia</title>

<!-- css -->
<link rel="stylesheet" href="../css/info.css">


</head>

<body>

<div><?php include_once('../elements/cabezote.php');?></div>

<div class="container" style="width:100%">
  
  <div class="content">
  
  <div class="div-mensaje">
    
    
       <img src="../images/Information.png" style="float:left; padding:5px;" />
   
    <p id="text-form"> 
      <?php echo $mensaje; ?>
      </p>
     
  </div>
     
    
  </div> <!-- end .content -->
 
  <!-- end .container --></div>
  
  <div><?php include_once('../elements/footer.php');?></div>
   
</body>
</html>