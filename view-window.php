<?php
	//Incluimos el archivo de configuracion
	require 'src/config.php';
	
	//Incluimos las funciones
	require 'src/include.php';
	
?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Window search - TilingScan</title>
	</head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Espacios -->
		<br><br>
		
		<!-- Div principal -->
		<div class="main" align="center">
		
			<!-- Titulo -->
			<span class="h1">Window Search</span><br><br>
		
			<?php
				//Incluimos toda la aplicacion
				require 'src/app/Window.php';
			?>
		
		</div>
		
		<!-- Espacios -->
		<br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>