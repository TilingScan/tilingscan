<?php require 'src/config.php'; ?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Welcome to TilingScan App</title>
	</head>
	<body>
	
		<!-- Cabecera -->
		<?php require 'src/theme/menu.php'; ?>
			
		<!-- Presentacion -->
		<div align="center" class="pre">
		
			<!-- Espacios -->
			<br><br><br><br>
			
			<!-- Logo -->
			<div class="pre-logo"></div>
			
			<!-- Espacios -->
			<br><br>
			
			<!-- Texto -->
			<span class="pre-h1">Analyze Tiling Array results Online.</span><br>
			<span class="pre-h2">An application for the identification of differentially expressed <br>DNA regions in Tiling microarray data.</span>
			
			<!-- Espacios -->
			<br><br><br>
			
			<!-- Boton usar la app -->
			<a href="./dashboard" class="pre-btn">Start using TilingScan</a>
			
			<!-- Espacios -->
			<br><br><br><br><br><br>
			
		</div>
		
		<!-- Tabla -->
		<div class="table" align="center">
			
			<!-- Celda Tutorial -->
			<div class="table-cell">
				<span class="h2">Tutorial</span><br>
				Information about how to use TilingScan.<br><br>
				<a href="./tutorial" class="table-btn background-orange">Read the tutorial</a>
			</div>
			
			<!-- Celda Soporte -->
			<div class="table-cell">
				<span class="h2">Support</span><br>
				You need help? Want to report an issuse?<br><br>
				<a href="./support" class="table-btn background-green">Contact us</a>
			</div>
			
		</div>
		
		<!-- Espacios -->
		<br><br>
		
		<!-- Pie de pagina -->
		<?php require 'src/theme/foot.php'; ?>
		
	</body>
</html>