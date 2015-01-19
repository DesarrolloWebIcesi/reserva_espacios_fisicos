<?php

/*
* datos_personales
*
* Clase que se encarga de insertar en la tabla TAUD-DISCLAIMER la aceptación de los términos de la ley 1581 DE 2012 protecion de datos personales
* @author	Christian David Criollo <cdcriollo@icesi.edu.co>
* @since	2014-08-15
*/


// Clase para realizar peticiones http
include_once('../class/curl.php');
// Archivo de configuracion de la aplicacion
include_once('../config/configuration.php');


class datos_personales
{
	private $aceptacion;
	private $correo;
	private $documento;
	private $ip;
	private $sistema;
	private $periodo_acad; 
    private $per_consecutivo; 
    private $respuesta; 
    private $entramite; 
    private $lider; 
    private $motivo; 
    private $negacion;
	private $url; 
	

	
 // Metodo constructoe de la clase	
    public function __construct($aceptacion,$correo,$documento,$ip,$sistema,$periodo_acad,$per_consecutivo,$respuesta ,$entramite ,$lider ,$motivo ,$negacion, $url ) 
	{  
      $this->aceptacion= $aceptacion;
	  $this->correo=$correo;
	  $this->documento=$documento;
	  $this->entramite=$entramite;
	  $this->ip=$ip;
	  $this->lider=$lider;
	  $this->motivo= $motivo;
	  $this->negacion= $negacion;
	  $this->per_consecutivo= $per_consecutivo;
	  $this->periodo_acad=$periodo_acad;
	  $this->respuesta= $respuesta;
	  $this->sistema=$sistema;
	  $this->url= $url;
    }
    
	//Funcion que se encarga de insertar en la tabla TAUD_DISCLAIMER la aceptación por parte del usuario de la ley de protección de datos personales
    public function insertar_datos_personales()
    {
	   $post_data= array("aceptacion"=>$this->aceptacion, "correo"=> $this->correo, "documento"=>$this->documento, "ip"=> $this->ip, "sistema"=> $this->sistema, "periodo_acad"=> $this->periodo_acad, "per_consecutivo"=> $this->per_consecutivo, "respuesta"=> $this->respuesta, "entramite"=> $this->entramite, "lider"=> $this->lider, "motivo"=> $this->motivo, "negacion"=>$this->negacion); 
       
		$proteccion_datos= new curl();
		//url proteccion de datos
		//$url_proteccion_datos= "http://192.168.220.28/proteccion_datos/control/ProteccionDatos.php";
		$respuesta= $proteccion_datos->post($this->url, $post_data); 
		return $respuesta;
	 
  }
 
}

?>