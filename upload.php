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
			<span class="h1">New project</span>
			
			<!-- Espacios -->
			<br><br>

			<?php
				
				//Variable para saber si todo esta correcto
				$correcto = true;
				
				//Cogemos la info del autor y del titulo
				$p_autor = $_POST['autor'];
				$p_titulo = $_POST['titulo'];
				$p_descripcion = $_POST['descripcion'];
				$p_strand = $_POST['strand'];
				
				//Cogemos la fecha de caducidad
				$p_caducidad = ProyectoFechaCaducidad();
				
				//Creamos el ID del proyecto
				$p_id = CrearProyID();
				
				//Creamos la carpeta del proyecto
				CrearProyDir($p_id);
				
				//Cogemos la carpeta
				$p_folder = _DATA.$p_id.'/';	
				
				//************* Configuracion para subir los ficheros
				$upload_dir = $p_folder._TEMP;
				$upload_file = null;
				$upload_chr = 0;

				//************* Creamos el fichero de anotacion
				$upload_file = $upload_dir.basename($_FILES['file_A']['name']);
				
				//Comprobamos si los podemos mover a la carpeta temporal
				if(move_uploaded_file($_FILES['file_A']['tmp_name'], $upload_file))
				{
					//Comprobamos si es un zip
					$upload_file = CrearZip($upload_file, $upload_dir);
						
					//Analizamos el fichero de anotacion
					$p_organismo = Anotacion($upload_file, $p_folder);
				}
				else
				{
					//Si no se puede mover, mostramos el error
					echo '<span class="color-red">Error uploading Annotation file.</span><br>';
						
					//Marcamos como que se ha producido un error
					$correcto = false;
				}
				
				//************* Creamos el fichero de expresion F
				$upload_file = $upload_dir.basename($_FILES['file_F']['name']);
				
				//Comprobamos si los podemos mover a la carpeta temporal
				if(move_uploaded_file($_FILES['file_F']['tmp_name'], $upload_file))
				{
					//Comprobamos si es un zip
					$upload_file = CrearZip($upload_file, $upload_dir);
					
					///Analizamos el Forward
					Expresion($upload_file, $p_folder, 'F');
				}
				else
				{
					//Si no se puede mover, mostramos el error
					echo '<span class="color-red">Error uploading Forward file.</span><br>';
					
					//Marcamos como que se ha producido un error
					$correcto = false;
				}
				
				//************* Creamos el fichero de expresion R
				
				//Comprobamos si hay reverse
				if($p_strand == "true")
				{
					//Cogemos el fichero
					$upload_file = $upload_dir.basename($_FILES['file_R']['name']);
					
					//Comprobamos si los podemos mover a la carpeta temporal
					if(move_uploaded_file($_FILES['file_R']['tmp_name'], $upload_file))
					{
						//Comprobamos si es un zip
						$upload_file = CrearZip($upload_file, $upload_dir);
							
						//Analizamos el fichero Reverse
						Expresion($upload_file, $p_folder, 'R');
					}
					else
					{
						//Si no se puede mover, mostramos el error
						echo '<span class="color-red">Error uploading Reverse file.</span><br>';
							
						//Marcamos como que se ha producido un error
						$correcto = false;
					}
				}
				
				//Creamos el archivo de configuracion
				CrearProyConfig($p_id, $p_autor, $p_descripcion, $p_titulo, $p_organismo, $p_strand);
				
				//Eliminamos la carpeta temporal, ya que no la vamos a volver a utilizar
				EliminarDir($upload_dir);
								
				//Comprobamos si todo esta correcto
				if($correcto == true)
				{
					//Si todo esta correcto
			?>
			
			<!-- titulo de todo correcto -->
			<span class="h2">The project <b><?php echo $p_titulo; ?></b> has been created.</span><br><br>
			
			<!-- Contenedor -->
			<div class="form" align="center">
				
				<!-- Id del proyecto -->
				<span class="h3">Project ID: <b><?php echo $p_id; ?></b></span> &nbsp; &nbsp; 
				
				<!-- Info -->
				<b class="color-green">(Save this ID, because you need it to acces to your project).</b><br>
				
				<!-- Fecha de caducidad -->
				<span class="h3 color-red">This project will be deleted on <?php echo ProyectoFechaFormato($p_caducidad); ?></span>
				
			</div>
			
			<!-- Espacios -->
			<br><br>
			
			<!-- Boton de ir al proyecto -->
			<a href="./project?id=<?php echo $p_id; ?>" class="form-btn background-blue">View Project</a>
					
			<?php
					
				}
				else
				{
					//Si se ha producido algun error, borramos la carpeta
					EliminarDir($p_folder);
				}
			?>
		
		</div>
		
		<!-- Espacios -->
		<br><br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>