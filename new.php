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
		<title>New project - TilingScan</title>
	</head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Espacios -->
		<br><br>
		
		<!-- Div principal -->
		<div class="main" align="center">
		
			<!-- Titulo -->
			<span class="h1">New project</span><br><br>
			
			<!-- Descripcion -->
			<span class="h2">Here you can create a new project:</span>
			
			<!-- Espacios -->
			<br><br><br>
			
			<!-- Formulario -->
			<form name="create" enctype="multipart/form-data" action="./upload" method="post" class="form">
			
				<!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000000000000000000000000000"> -->
				
				<!-- Titulo del proyecto -->
				<b>Project title:</b><br>
				<input name="titulo" id="titulo" type="text" class="input-500"><br><br>
				
				<!-- Descripcion del proyecto -->
				<b>Project description:</b><br>
				<textarea name="descripcion" id="descripcion" class="input-500"></textarea><br><br>
				
				<!-- Autor -->
				<b>Author:</b><br>
				<input name="autor" id="autor" type="text" class="input-500"><br><br>
				
				<!-- Fichero de anotacion -->
				<b>Annotation file:</b><br>
				<input name="file_A" id="file_A" type="file" class="input-500"><br><br>
				
				<!-- Strand -->
				<b>Experiment type:</b><br>
				<select name="strand" id="strand" class="select" onchange="NewCambiarStrand(this);">
					<option value="true">Strand specific</option>
					<option value="false">Non Strand specific</option>
				</select><br><br>
				
				<!-- Fichero forward -->
				<b>Forward file:</b><br>
				<input name="file_F" id="file_F" type="file" class="input-500"><br><br>
				
				<!-- Si es especifica -->
				<div id="reverse_box" style="display: block;">
				
					<!-- Fichero reverse -->
					<b>Reverse file:</b><br>
					<input name="file_R" id="file_R" type="file" class="input-500"><br><br><br>
				
				</div>
				
				<!-- Boton de enviar -->
				<input type="submit" value="Create!" class="form-btn background-blue"><br>
				
				<!-- Aviso -->
				<small>(Be patient)</small>
			
			<!-- Cerramos el form -->
			</form>
		
		</div>
		
		<!-- Espacios -->
		<br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>