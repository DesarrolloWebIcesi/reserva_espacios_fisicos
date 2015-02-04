<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<title>Reserva de espacios fisicos - Universidad Icesi - Cali, Colombia</title>
<!--javascript -->
<script src="js/jquery-1.9.1.min.js"></script>
<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
<!--<script src="js/jquery_validate.js"></script>-->
<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>
<script src="js/login.js"></script>
<!--<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->

<!-- css -->
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/login.css">
<link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

</head>

<!--<div id="div_borowser" style="background:#0C3; border: 1px solid #000; margin:10px 10px 10px 10px; width:auto; height:auto">
<p style="font-size:12px; color:#FFF; margin:5px 5px 5px 5px; font-weight:bold;">Está usando una versión antigua de su navegador. Esta aplicación hace uso de características avanzadas que no son soportadas por navegadores antiguos, por lo que le recomendamos actualizar su navegador a la versión más reciente para ver esta aplicación de forma correcta.</p>
</div>-->

<body>

<div><?php include_once('elements/cabezote.php');?></div>

<div class="container" style="width:100%">
  
  <div class="content">
  
   <p id="text-form" style="text-align:center"> Bienvenido al sistema de reserva de espacios físicos de la universidad Icesi, por favor ingrese su documento de identidad y contraseña de usuario único  para ingresar al sistema.
    </p>
    
    <section id="content">
		<form action="" id="formlogin">
			<h1>Iniciar sesi&oacuten</h1>
			<div>
              <!--<label for="cedula">Cedula</label> -->
		      <input type="text" placeholder="Cédula"  id="cedula" name="cedula" class="required" />
			</div>
			<div>
                <!--<label>Contraseña</label>-->
				<input type="password" placeholder="Contraseña"  id="password" class="required" />
			</div>
			<div>
				<input type="button" id="button-login" value="Ingresar" />
			</div>
            <script type="text/javascript" src="js/placeholders.jquery.min.js"></script>
		</form><!-- form -->
	</section><!-- content -->
    
  </div> <!-- end .content -->
  
  <p id="info-contraseña"> Si olvidó su contraseña o nunca ha ingresado,  <a href="https://iden.icesi.edu.co/sso/jsp/newpassword.jsp" title="solicite una nueva contraseña ">solicite una nueva contraseña pulsando aquí</a>. </p>
  
  <p id="info-contraseña"><a href="http://www.icesi.edu.co/manuales/manual_formulario_reservas.pdf" target="_blamk"> Manual de usuario </a></p>
  <!-- end .container --></div>
  <div align="center" style="margin-top:50px;">
    <p id="text-form">Navegadores Recomendados ultimas versiones</p>
    <p><img src="images/chrome.png" title="Google Chrome"/> <img src="images/firefox.png" title="Firefox"/> <img src="images/opera.png" title="Opera"/> <img src="images/Internet-explorer.png" title="Internet Explorer"/></p>
  </div>
  
  
  <footer id="colophon">
    <div><?php include_once('elements/footer.php');?></div>
  </footer>
  
  <div id="dialog-message" style="display:none;">
    <span class="ui-icon" style="float:left; margin:0 7px 0 0;" id="dialog-icon"></span>
    <span id="text-message"></span>
  </div> 
   
</body>
</html>