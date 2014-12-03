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
		<title>Visualize gene - TilingScan</title></head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Espacios -->
		<br><br>
		
		<!-- Div principal -->
		<div class="main" align="center">
			
			<!-- Titulo -->
			<span class="h1">Visualize gene</span><br><br>
			
			<?php 
				//Incluimos toda la aplicacion
				require 'src/app/Gen.php';
			?>
	
		</div>
		
		<!-- Espacios -->
		<br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>