<?php
	//Incluimos el archivo de configuracion
	require 'src/config.php';
	
	//Incluimos las funciones
	require 'src/include.php';
	
	//Funcio que busca las cadenas en el fichero seleccionado
	function SearchBuscar($vect, $file)
	{
		//Iniciamos las variables
		$encontrado = false;
		$devolver = 0;
		$p_autor = '';
		$p_title = '';
		$p_descripcion = 'This is a demo project for try TilingScan.';
	
		//Incluimos el fichero
		include _DATA.$file.'/config.php';
	
		//Buscamos para cada string dentro del vector
		for($i = 0; $i < count($vect); $i++)
		{
		//Buscamos coincidencias en el ID del proyecto
		$busca1 = strpos($file, $vect[$i]);
			
		//Buscamos coincidencias en el titulo del proyecto
		$busca2 = strpos($p_title, $vect[$i]);
			
		//Buscamos coincidencias en el autor
		$busca3 = strpos($p_autor, $vect[$i]);
			
		//Comprobamos si hemos encontrado algo
		if($busca1 === false && $busca2 === false && $busca3 === false)
		{
		//Si no ha encontrado nada, que siga
		}
		else
		{
		//Si hemos encontrado algo, activamos la etiqueta
			$encontrado = true;
	
			//Cerramos el bucle
			break;
		}
		}
	
		//Si hemos encontrado algo
		if($encontrado == true)
		{
			//Titulo del proyecto
			echo '<a href="./project?id='.$file.'" class="search-resul">'.$p_title.'</a><br>';
			
			//Descripcion del proyecto
			echo $p_descripcion.'<br>';
			
			//Id del proyecto
			echo '<a href="./project?id='.$file.'" class="search-info"> ID: <b>'.$file.'</b></a><br>'; 
			
			//Autor del proyecto
			echo '<span class="search-info"> Author: '.$p_autor.'</span><br>';
			
			//Fecha de creacion
			echo '<span class="search-info"> Created: '.ProyectoFechaFormato($p_date).'</span><br>';
		
			//Espacios para separar
			echo '<br><br>';
				
			//Para que devuelva que ha encontrado algo
			$devolver = 1;
		}
	
		//Devolvemos si ha encontrado algo o no
		return $devolver;
	}
	
?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Search - TilingScan</title>
	</head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Div principal -->
		<div class="main">
			
			<!-- Espacios -->
			<br><br>
			
			<!-- Cuadro de busqueda -->
			<div align="center">
			
				<!-- Titulo -->
				<span class="h1">Search project</span><br><br>
				
				<!-- Formulario -->
				<form enctype="multipart/form-data" action="./search" method="post">

					<!-- Campo de texto -->
					<input type="text" class="input-500" name="search" placeholder="Project ID, name or author">
					
					<!-- Boton-->
					<input type="submit" value="Search" class="search-btn">
					
				</form>
			</div>
	
			<?php
			
			//Comprobamos si hemos enviado algo
			if(!empty($_POST))
			{
				//Cogemos lo que ha buscado
				$search = $_POST['search'];
				
				//Eliminamos los caracteres especiales
				$search = preg_replace('/[^A-Za-z0-9\. -]/', '', $search);
				
				//Contador de resultados obtenidos
				$cont = 0;
				
				//Espacios
				echo '<br>';
				
				//Comprobamos que no este vacio
				if(!empty($search))
				{
					//Avisamos de lo que estamos buscando
					echo '<span class="h2">Search results for "'.$search.'":</span><br><br>';
				
					//Fragmentamos
					$search = explode(' ', $search);
				
					//Abrimos la carpeta con los proyectos
					$dh = opendir(_DATA);
				
					//Buscamos en todos los proyectos
					while (($file = readdir($dh)) !== false)
					{
						//Evitamos los de siempre
						if( "." == $file || ".." == $file )
						{
							continue;
						}
				
						//Si hemos encontrado algun proyecto, buscamos en el
						$cont = $cont + SearchBuscar($search, $file);
					}
				
					//Cerramos el directorio
					closedir($dh);
				}
				
				//Comprobamos si ha encontrado algo o no
				if($cont == 0)
				{
					//Si no ha encontrado nada, avisamos
					echo '<span class="h2 color-red">No matches found.</span>';
					echo '<br><br><br>';
				}
				else
				{
					//Mostramos cuantos ha encontrado
					echo $cont.' results found.';
				}
			}
			else
			{
				echo '<br><br><br>';
			}
		?>
		
		</div>
		
		<!-- Espacios -->
		<br><br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>
