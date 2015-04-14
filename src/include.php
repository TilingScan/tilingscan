<?php 
	
	//Incluimos las funciones para crear un proyecto
	require 'src/functions/CrearZip.php';
	require 'src/functions/CrearProy.php';
	require 'src/functions/CrearAnotacion.php';
	require 'src/functions/CrearExpresion.php';
	
	//Incluimos las funciones de la representacion
	require 'src/functions/Img.php';
	require 'src/functions/Filtros.php';
	require 'src/functions/Alinear.php';
	require 'src/functions/AppChr.php';
	require 'src/functions/AppGene.php';
	require 'src/functions/AppWindow.php';
	
	//Incluimos las funciones del proyecto
	require 'src/functions/ProyectoLista.php';
	require 'src/functions/ProyectoInfo.php';
	require 'src/functions/ProyectoEliminar.php';
	require 'src/functions/ProyectoFecha.php';
	
	//Incluimos los plugins
	require 'src/functions/plugins/Explorer.php';
	require 'src/functions/plugins/Annotate.php';
	require 'src/functions/plugins/Colores.php';
?>