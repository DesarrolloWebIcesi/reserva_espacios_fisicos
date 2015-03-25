
<?php session_start(); 
include_once('../config/configuration.php');

if ($_SESSION['cedula']=="")
{
	echo "<script language='javaScript'> location.href='../index.php' </script>";	
}
else if ($_SESSION['tipo']=="otro")
{
  echo "<script language='javaScript'> location.href='error.php?mensaje=1' </script>";   	
}
else 
{
	if(time()-$_SESSION['time'] < $time_sesion){
		// No se realiza ninguna acción
	}
	else{	 	
	  header("location: ../source/cerrar_sesion.php");	
	}
	
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<title>Reserva de espacios fisicos</title>

     <!-- javascript-->
     <script src="../js/jquery-1.9.1.min.js"></script>
     <script type="text/javascript" src="../js/jquery.steps.min.js"></script>
     <script type="text/javascript" src="../js/reservas.js"></script>
     <script type="text/javascript" src="../js/jquery-ui-1.10.4.min.js"></script>
     <script type="text/javascript" src="../js/jquery.ui.datepicker-es.js"></script>
     <script type="text/javascript" src="../js/jquery.ui.timepicker-es.js"></script>
     <script type="text/javascript" src="../js/jquery.ui.timepicker.js"></script>
     <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
     <!--<script type="text/javascript" src="../js/jquery_validateold.js"></script>-->
    
     <!-- css--> 
     <link rel="stylesheet" href="../css/reserva.css">
     <link rel="stylesheet" href="../css/normalize.css">
     <link rel="stylesheet" href="../css/main.css">
     <link rel="stylesheet" href="../css/jquery-ui.min.css">
     <link rel="stylesheet" href="../css/jquery.ui.timepicker.css">
     <link href="../images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
       
</head>

<body>

<div><?php include_once('../elements/cabezote.php');?></div>

<div id="leftbar">

    <div style="margin-top:90px">
        <p align="center"><img src="../images/1403051511_user.png" /></p>
        <p style="text-align:center; font-weight:bold"> <?php echo $_SESSION['nombre_completo']; ?> </br> <?php echo $_SESSION['dependencia_solicitante']; ?></br>
          <?php echo $_SESSION['cedula']; ?> </br> <?php if($_SESSION['tipo']== 'Estudiante Pregrado' || $_SESSION['tipo']== 'Estudiante Postgrado' ) {?>  <?php echo 'Codigo:'.$_SESSION['codigo'];?> </br> <?php } ?> <?php echo $_SESSION['tipo']; ?> </br><?php if($_SESSION['tipo']=="colaborador"){?> <img src="../images/reporte.png" style="vertical-align:middle"/><a style="text-decoration:none" href="../reports/listado_espacios.php" id="listado" target="_blank">Listado espacios físicos</a> </br> <?php }?>
         <?php if ( $_SESSION['tipo']=="colaborador" || $_SESSION['tipo']=="Profesor Hora Catedra") {?>
             Actualice sus datos <a href="<?php echo $url_info_emp_profhc; ?>" target="_blank" style="text-decoration:none;">aquí</a>
          <?php }
		  else if($_SESSION['tipo']== 'Estudiante Pregrado'){?>
			Actualice sus datos <a href="<?php echo $url_info_pregrado; ?>" target="_blank" style="text-decoration:none">aquí</a>  
		  <?php } 
		  else if($_SESSION['tipo']== 'Estudiante Postgrado') { ?>
			Actualice sus datos <a href="<?php echo $url_info_postgrado; ?>" target="_blank" style="text-decoration:none">aquí</a>    
		  <?php } ?>
        </p>
        <p style="text-align:center; font-size:14px;"> Los campos con el formato en <b>negrilla</b> </br> son obligatorios.</br>
        <img src="../images/logout.png" style="vertical-align:middle"/> <a style="text-decoration:none" href="../source/cerrar_sesion.php">Cerrar sesión</a> </p> 
        <p style="text-align:center; font-size:14px;"> <a href="http://www.icesi.edu.co/manuales/manual_formulario_reservas.pdf" target="_blamk"> Manual de usuario </a></p> 
        
     </div> 
 </div>

<div class="content" style="margin-top:10px; width:80%; float:right;">
           <form id="reservas" action="#">
            <div id="wizard">
                <h2>Datos del solicitante</h2>
                <section>
                 <fieldset>
                   <table>
                     <tr>
                       <td><label class="label-bold" for="telefonosol">Teléfono/Ext:</label></td> 
                       <td><input id="telefono_sol" name="telefono_sol" type="text" size="30" value="<?php 
					   if($_SESSION['tipo']== 'colaborador')
					   {
						 if($_SESSION['extension']=='' || $_SESSION['extension']== null ) 
						 { 
						   if($_SESSION['celular'] != '' && $_SESSION['celular'] !=  null )
						   {
						     echo $_SESSION['celular'];
						   }
						   else
						   {
							 echo $_SESSION['telefono'];   
						   }
						 }
						 else
						 {
							echo $_SESSION['extension']; 
						 }
						 
						  ?>
                         
                         <?php }
						 else
						 {
						   if($_SESSION['celular']=='' || $_SESSION['celular']== null ) 
						   { 
						      echo $_SESSION['telefono'];
						   }
						   else
						   {
							 echo $_SESSION['celular'];   
						   }
						 } 
					
						 ?>
					   
					     " /></td> 
                       <?php if($_SESSION['tipo']== 'colaborador' ||  $_SESSION['tipo']== 'Empleado Temporal'){ ?>
                       <td><img src="../images/edit1.png" id="edittel_sol_col" style="vertical-align:middle" title="Editar telefono solicitante" /></td><?php }?>
                       
                     </tr>
                     
                     <tr>
                      <td><label class="label-bold" for="email_sol">Correo electrónico:</label></td>
                      <td><input id="email_sol" name="email_sol" type="text" size="30" value="<?php echo $_SESSION['correo_electronico'];?>" /></td>
                      <?php if($_SESSION['tipo']== 'Estudiante Pregrado' || $_SESSION['tipo']== 'Estudiante Postgrado' ||  $_SESSION['tipo']== 'Profesor Hora Catedra' ){ ?>
                       <td><img src="../images/edit1.png" id="edit" style="vertical-align:middle" title="Editar telefono y correo solicitante" /></td> 
                      <?php }?>
                      <input type="hidden" id="nombre_solicitante" name="nombre_solicitante" value="<?php echo $_SESSION['nombre_completo']; ?>" />
                      <input type="hidden" id="id_solicitante" name="id_solicitante" value="<?php echo $_SESSION['cedula']; ?>" />
                      <input type="hidden" id="cod_solicitante" name="cod_solicitante" value="<?php echo $_SESSION['codigo']; ?>" />
                      <input type="hidden" id="rol_solicitante" name="rol_solicitante" value="<?php echo $_SESSION['tipo']; ?>" />
                      </tr>
                    </table>  
                </fieldset>
                
                </section>

                <h2>Datos del responsable</h2>
                <section>
                   <fieldset>
                   
                   <table>
                       <tr>
                         <td><label class="label-bold" for="cedula_resp">Identificación:</label></td>
                         <td><input id="cedula_resp" name="cedula_resp" type="text" size="35" /></td>
                       </tr>
                       
                       <tr>
                         <td><label class="label-bold" for="dependencia_resp">Dependencia / Programa:</label></td>
                         <td><input id="dependencia_resp" name="dependencia_resp" type="text" size="35" /></td>
                       </tr>
                       
                       <tr>
                         <td><label class="label-bold" for="nombre_resp">Nombres y apellidos:</label></td>
                         <td><input id="nombre_resp" name="nombre_resp" type="text" size="35" readonly /></td>
                       </tr>
                       
                       <tr>
                         <td><label class="label-bold" for="email_resp">Correo electrónico:</label></td>
                         <td><input id="email_resp" name="email_resp" type="text" size="35" readonly /></td>
                       </tr>
                       
                       <tr>
                         <td><label class="label-bold" for="telefono_resp">Teléfono/Ext:</label></td>
                         <td><input id="telefono_resp" name="telefono_resp" type="text" size="35"/></td>
                         <td id="show_edit"><img src="../images/edit1.png" id="edittel_resp_col" style="vertical-align:middle" title="Editar telefono responsable" /></td>
                       </tr>
                      <input type="hidden" id="cod_responsable" name="cod_responsable" value="" />
                   </table> 
                </fieldset>  
                </section>

                <h2>Datos de la reserva</h2>
                <section>
                  <table>
                   <tr>
                     <td><label class="label-bold" for="nombre_actividad">Nombre de la actividad:</label></td>
                     <td><input id="nombre_actividad" name="nombre_actividad" type="text" style="display:inline-block" size="35" /></td>
                   </tr> 
                   
                   <tr>
                    <td><label class="label-bold" for="descripcion" >Descripción de la actividad:</label></td>
                    <td><textarea rows="2" cols="32" style="display:inline-block" id="descripcion"  name="descripcion"></textarea></td>
                   </tr>
                   
                   <tr> 
                    <td><label class="label-bold" for="tipo_espacio" >Tipo espacio físico:</label></td>
                    <td><select size="1" id="tipo_espacio" name="tipo_espacio" ></select></td>
                    <td>
                       <div id="div_aud" class="div-msg-aud">
                         <p class="p-text-aud"> No se debe fumar, ni ingresar alimentos y/o bebidas al interior de los auditorios</p>
                         </div>
                    </td>
                    </tr>
                    
                     <tr>
                       <td><label class="label-bold" for="espacio_fisico" id="lblespacio">Espacio físico:</label></td>
                       <td><select size="1" id="espacio_fisico" name="espacio_fisico"> </select> </td>
                     </tr>
                    
                      <tr>
                       <td><label class="label-bold" for="software_principal" id="lblsoftwarep">Software Principal:</label></td>
                       <td>
                         <select size="1" id="software_principal" name="software_principal" >
                    
                         </select>
                       </td>
                      </tr>
                      
                      <tr>
                       <td><label class="label-bold" for="software_secundario" id="lblsoftwares">Software Secundario:</label></td>
                       <td>
                         <select size="1" id="software_secundario" name="software_secundario">
                         </select>
                       </td>
                      </tr>
                   
                   <tr>
                     <td><label class="label-bold" for="fecha" >Fecha reserva:</label></td>
                     <td><input id="fecha" name="fecha" type="text" size="25" readonly /></td>
                    </tr> 
                    
                    <tr>
                       <td><label class="label-bold" for="hora_inicio" >Hora inicio reserva:</label></td>
                       <td><input type="text" id="hora_inicio"  name="hora_inicio" size="25" readonly />
                        <button id="mostrar_hora_inicio" title="De click para seleccionar una hora"><img src="../images/clock.png" style="cursor:pointer; vertical-align:middle" /></button>
                       </td>
                       <td>
                       <div id="div_aud_2" class="div-msg-aud">
                         <p class="p-text-aud"> Tener presente solicitarlo 30 minutos antes de iniciar el evento, para efectos de organización y pruebas</p>
                         </div>
                       </td>
                    </tr> 
                    
                    <tr>     
                      <td><label class="label-bold" for="hora_final" >Hora finalización reserva:</label></td>
                      <td><input type="text" id="hora_final" name="hora_final" size="25" readonly />
                      <button id="mostrar_hora_final"  title="De click para seleccionar una hora"><img src="../images/clock.png" style="cursor:pointer; vertical-align:middle"/></button>
                      </td>
                    </tr>
                    
                    <tr> 
                        <td><label class="label-bold" for="zrecibo" id="lblzrecibo" >Requiere zona de recibo:</label></td>
                        <td>
                          <select size="1" id="zrecibo" name="zrecibo" >
                           <option value="No">No </option>
                           <option value="Si">Si </option>
                         </select>
                        </td>
                    </tr>
                    </table>
                       
                </section>

                <h2>Finalizar solicitud</h2>
                <section>
                 <table>    
                  <tr>
                    <td><label class="label-bold" for="No_personas" >Número de personas:</label></td>
                    <td><input id="No_personas" name="No_personas" type="text" /></td>
                  </tr>
                  <tr>  
                    <td><label for="observaciones"  >Observaciones:</label></td>
                    <td><textarea rows="4" cols="50" id="observaciones"  name="observaciones"></textarea> </td>
                   </tr>
                  </table>
                    <input type="checkbox" name="valid_user" id="valid_user" />Acepto que he leido el 
                    <a id="ans" target="_blank">Acuerdo de Nivel de Servicio</a> y las <a id="condiciones" target="_blank">condiciones de uso</a> del recurso.
                </section>
            </div><!-- wizard-->
           </form> <!-- form-->
        </div><!-- wrap-->
        
     <!-- footer de la pagina-->
       <div><?php include_once('../elements/footer.php');?></div>
     
  
  <!-- end .container </div>  -->   
   
 
   <div id="dialog-message" style="display:none">
    <span class="ui-icon" style="float:left; margin:0 7px 0 0;" id="dialog-icon"></span>
    <span id="text-message"></span>
   </div>     
        
</body>
</html>
