<?php
	//Incluimos el archivo de configuracion
	require 'src/config.php';
	
	//Incluimos las funciones
	require 'src/include.php';
	
	//Comprobamos si hay que eliminar algun proyecto
	//ProyectoEliminar();
	
?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Dashboard - TilingScan</title>
	</head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Portada -->
		<div align="center" class="main">
		
			<!-- Espacios -->
			<br><br>
			
			<!-- Presentacion -->
			<span class="h1">Dashboard</span><br><br>
			<span class="h2">Search for an existing project, create a new project or try the app.</span>
			
			<!-- Espacios -->
			<br><br><br>
			
			<!-- Botones para buscar o crear uno nuevo -->
			<a href="./search" class="dashboard-btn background-blue">Search project</a>
			<a href="./new" class="dashboard-btn background-red">Create new project</a>
			<a href="./project?id=demo" class="dashboard-btn background-water">Try the app</a>
			
			<!-- Espacios -->
			<br><br><br>
			
		</div>
		
		<!-- Espacios -->
		<br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>
	