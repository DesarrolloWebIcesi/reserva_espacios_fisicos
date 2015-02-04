<?php 
/*
* Configuration
*
* Archivo de configuración de la aplicación
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-07-08
*/

// Configuracion del tiempo de sesión
$time_sesion= '43200'; // equivale a 10 minutos

//Correo remitente
$correo_remitente= "espaciosfisicos@listas.icesi.edu.co"; 

// Variables de conexion a controladors de sgs
$url_desarrollo_mantis= "http://192.168.220.28/solicitudes_sgs/control/";
$url_produccion_mantis= "http://www.icesi.edu.co/solicitudes_sgs/control/";

//url base mantis desarrollo y produccion
$url_desarrollo= "http://192.168.220.28";
$url_produccion= "http://www.icesi.edu.co";
$sgs_desarrollo= "/sgs";
$sgs_produccion= "/solicitud_servicios";

//url proteccion de datos
$url_datos_personales_desarrollo= "http://192.168.220.28/proteccion_datos/control/ProteccionDatos.php";

// url proteccion de datos produccion
$url_datos_personales_produccion= "http://www.icesi.edu.co/proteccion_datos/control/ProteccionDatos.php";

//Correo de pruebas
$correo_pruebas='alarango@icesi.edu.co';
$correo_pruebas1= 'alarango@icesi.edu.co';

//url inicio mantis
$url_inicio_mantis_desarrollo= 'http://192.168.220.28/sgs/login_page.php';
$url_inicio_mantis_produccion="http://www.icesi.edu.co/solicitud_servicios/login_page.php";

//controladores crear caso mantis
$controlador_multimedios="ControlProcesarSolicitudMultimedios.php";
$controlador_operaciones="ControlProcesarSolicitudOperaciones.php";
$controlador_planeacion= "ControlProcesarSolicitudPacad.php";
$controlador_servicios_generales="ControlProcesarSolicitudPlantaFisica.php";

//Configuracion de la oficina, correo y extensión de acuerdo al tipo de espacio o espacio fisico 
$espacios_fisicos= array('salon_con_videoproyector'=> array('oficina'=> 'SYRI-Multimedios', 'extensiones'=> '8730 - 8866 - 8067', 'correo'=> 'multimedios@listas.icesi.edu.co '), 'salon_sin_videoproyector'=> array('oficina'=> 'Planeación Académica', 'extensiones'=> '8358 - 8346 - 8273', 'correo'=> 'salones@icesi.edu.co'), 'camara_gesell'=> array('oficina'=> 'SYRI-Multimedios', 'extensiones'=> '8730 - 8866 - 8067', 'correo'=> 'multimedios@listas.icesi.edu.co '), 'salon_bienestar_universitario'=> array('oficina'=> 'Planeación Académica', 'extensiones'=> '8358 - 8346 - 8273', 'correo'=> 'salones@icesi.edu.co'), 'laboratorio'=> array('oficina'=> 'Planeación Académica', 'extensiones'=> '8358 - 8346 - 8273', 'correo'=> 'salones@icesi.edu.co'), 'auditorios'=>array('oficina'=> 'Planeación Académica', 'extensiones'=> '8358 - 8346 - 8273', 'correo'=> 'salones@icesi.edu.co'), 'sala computo'=> array('oficina'=>'SYRI-Operaciones', 'extensiones'=> '8358 - 8750 - 8744', 'correo'=> 'servicio-salas@listas.icesi.edu.co'), 'sala_reuniones_direccion'=> array('oficina'=>'Planeación Académica', 'extensiones'=> '8358 - 8346 - 8273', 'correo'=> 'salones@icesi.edu.co'), 'sala_videoconferencias_1y2'=> array('oficina'=> 'SYRI-Multimedios', 'extensiones'=> '8730 - 8866 - 8067', 'correo'=> 'multimedios@listas.icesi.edu.co '), 'espacios_uso_general'=> array('oficina'=> 'Servicios Generales', 'extensiones'=> '8743 - 8712', 'correo'=> 'servicios@listas.icesi.edu.co'),'laboratorios_multimedios'=> array('oficina'=> 'SYRI-Multimedios', 'extensiones'=> '8730 - 8866 - 8067', 'correo'=> 'multimedios@listas.icesi.edu.co '));

// Se configuran los dias de antelacion para cada uno de los tipos de espacios fisicos

$salon_con_video= '2';
$camara_gesell='2';
$salon_bienestar='1';
$laboratorios='1';
$auditorios='3';
$sala_computo='3';
$espacios_uso_general='3';
$saladereunionesyvideoconferencias= '1';

//Se configura las url de los ANS y las condiciones de uso de los diferentes tipos de espacios fisicos

//ANS (Acuerdo de Nivel de Servicio)
$reserva_salon_video_proyector=  'http://www.icesi.edu.co/servicios_apoyo/reserva_salon_video_proyector.php';
$reserva_salon_sin_videoproyector= 'http://www.icesi.edu.co/servicios_apoyo/reserva_salones_sin_video_proyector.php';
$reserva_salas_computo= 'http://www.icesi.edu.co/servicios_apoyo/servicio_de_salas_de_computo.php';
$reserva_espacios_general= 'http://www.icesi.edu.co/servicios_apoyo/reserva_espacios_uso_general.php';
$reserva_sala_reuniones_videoconferencias= 'http://www.icesi.edu.co/servicios_apoyo/sala_reuniones_videoconferencias.php';
$reserva_auditorios='http://www.icesi.edu.co/servicios_apoyo/reserva_auditorios.php';
$reserva_laboratorios='http://www.icesi.edu.co/servicios_apoyo/reserva_de_los_laboratorios.php';
$reserva_saladereunionesdacad= 'http://www.icesi.edu.co/servicios_apoyo/reserva_de_la_sala_de_reuniones_de_la_direccion_academica_y_sotano.php';
 
//Condiciones de uso
$condiciones_uso_salacomputo='http://www.icesi.edu.co/servicios_apoyo/condiciones_uso_salas_de_computo.php';

// Actualización de informacios datos personales

// Estudiantes de pregrado
$url_info_pregrado= 'http://www.icesi.edu.co/infopre/';
// estudiantes de postgrado
$url_info_postgrado= 'http://www.icesi.edu.co/infopost/';
//Colaboradores y profesor hora catedra
$url_info_emp_profhc= 'https://talentoicesi.icesi.edu.co/sse_generico/generico_login.jsp'; 


?>