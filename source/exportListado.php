<?php

/**
 * Este script se encarga de generar el reporte de espacios fisicos en formato PDF.
 * @author Cristian David Criollo - cdcriollo
 * @since 01/07/2014
 */

/**
 * Libreria de consultas de los eventos
 */
 
 include_once ('../lib/ezpdf/class.ezpdf.php');
 header('Content-Type: text/html; charset=UTF-8');

session_start();
setlocale(LC_TIME, 'es_CO');
$hoy = date("l, j \d\e F \d\e Y - H:i");
$hoy = utf8_encode(strftime('%A, %d de %B de %Y')." - ".date('H:i'));

       
  // Creando el objeto PDF
  $pdf = new Cezpdf("letter", "landscape");
  //Límites X: 792, Y: 612
  
  // Estableciendo las margenes
  $pdf->ezSetMargins(30, 30, 30, 30);

  // Generando el encabezado
  $encabezado = $pdf->openObject();
  $imagen = "../images/logo_icesi.jpg";
  if (file_exists($imagen)) {
    $pdf->addJpegFromFile($imagen, 30, 552, 100, 32);
  }
  //Título
   $pdf->ezSetY(582);
   $pdf->selectFont("../lib/ezpdf/fonts/Helvetica-Bold.afm");
   $pdf->ezText("<b>SISTEMA DE RESERVA DE ESPACIOS FISICOS</b>", 16, array('left' => 265));
   $pdf->ezText("Reporte de espacios físicos", 12, array('left' => 370));
   $pdf->selectFont("../lib/ezpdf/fonts/Helvetica.afm");
   $pdf->ezText(" ", 10, array('left' => 0));

   //Barra gris
    $pdf->addJpegFromFile('../images/barra.jpg', 30, 520, 730, 17);
    $pdf->selectFont("../lib/ezpdf/fonts/Courier.afm");
    $pdf->ezSetY(535);
    $pdf->ezSetY(535);
    $pdf->ezText($hoy, 10, array('justification' => 'centre'));
    $pdf->ezStartPageNumbers(680, 35, 10, "right", utf8_decode("Página {PAGENUM} de {TOTALPAGENUM}"));
    $pdf->selectFont("../lib/ezpdf/fonts/Helvetica.afm");

    // Cerrando objetos que irán en todas las páginas
    $pdf->closeObject();
    $pdf->addObject($encabezado, 'all');


    // Agregando objetos a todas las páginas
    $pdf->ezSetMargins(102, 50, 30, 30);
    $pdf->ezSetY(521);

   // Seleccionando fuente helvetica normal
    $pdf->selectFont("../lib/ezpdf/fonts/Helvetica.afm");

     // Asignando salto de línea a 10pt
     $pdf->ezSetDy(10);
    // Datos de la tabla
    $datos =$_SESSION['datos_listado'];
		
    // Títulos para la tabla
    $titulos = array('CODIGO' => '<b>Código</b>', 'DESCRIPCION' => '<b>Descripción</b>', 'CAPACIDAD' => '<b>Capacidad</b>');
  // Configuración para la tabla
    $configuracion = array('showHeadings' => 1, 'shaded' => 0, 'showLines' => 2, 'width' => 730, 'xPos' => 35, 'xOrientation' => 'right');
	
   // Escribiendo dos saltos de línea
    $pdf->ezText(" ");
    $pdf->ezText(" ");
	
    // Dibujando la tabla
        $pdf->ezTable($datos, $titulos, "", $configuracion);
        $pdf->ezText(" ");

        // Entregando el pdf
        if (isset($d) && $d) {
            $pdfcode = $pdf->ezOutput(1);
            $pdfcode = str_replace("\n", "\n<br>", htmlspecialchars($pdfcode));
            echo '<html><body>';
            echo trim($pdfcode);
            echo '</body></html>';
        } else {
            $pdf->ezStream();
        }
      
?>