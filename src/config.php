<?php

	//Activamos que muestre todos los errores
	error_reporting(-1);
	ini_set('display_errors', '1');
	
	//URL
	define('_URL', 'http://biprote.uv.es/');

	//Nombre del programa
	define('_NAME', 'TilingScan');
	
	//Fecha
	define('_VERSION', 'Version 0.1, 2014');
	
	//Autores
	define('_AUTHORS', 'Vicente Arnau, Jose E. Perez, Ana Miguel, Jose M. Juanes');
	
	//Copyright
	define('_COPY', 'Univ. de Valencia, SPAIN');
	
	//Carpeta de datos
	define('_DATA', 'app/data/');
	
	//Carpeta temporal
	define('_TEMP', 'temp/');
	
	//Fuente
	define('_FONT', 'css/opensans.ttf');
	
	//Anchura de la imagen
	define('_IMG_ANC', 5000);
	
	//Anchura minima de la imagen
	define('_IMG_MIN', 950);
	
	//Anchura para la escala
	define('_IMG_ANC_MARGEN', 30);
	
	//Altura de la imagen
	define('_IMG_ALT', 640);
	
	//Altura del titulo
	define('_IMG_ALT_TITULO', 100);
	
	//Altura de la zona de dibujo
	define('_IMG_ALT_ZONA', 200);
	
	//Altura de la zona de los genes
	define('_IMG_ALT_GEN', 320);
	
	//Tolerancia para rellenar las hebras
	define('_TOL', 10);
	
	//Organismo base
	$p_organismo = 'C_albicans_SC5314';
	
	//Descripcion
	$p_descripcion = 'This is a demo project for try TilingScan.';
	
	//Strand
	$p_strand = true;
	
	//Localizacion de Annotate
	define('_ANNOTATE_URL', 'http://www.jmjuanes.es/annotate/app.html');
	
?>