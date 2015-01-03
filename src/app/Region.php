<?php 
	//Cogemos el id del proyecto
	$id = $_GET['id'];
	
	//Guardamos la ID
	define('_ID', $id);
	
	//Creamos la carpeta
	$folder = _DATA.$id.'/';
	
	//Comprobamos si existe el archivo de configuracion
	if(file_exists($folder.'config.php'))
	{
		//Si existe, lo incluimos
		require $folder.'config.php';
		
		//Cogemos los datos que hemos obtenido
		$chr = $_GET['chr'];
		$ini = $_GET['ini'];
		$fin = $_GET['fin'];
		$gauss = $_GET['gauss'];
		
		//Valor de la escala
		$escala_val = 'auto';
		
		//Comprobamos si ha modificado la escala
		if(!empty($_POST))
		{
			//Si la ha modificado, lo cogemos
			$img_zoom = intval($_POST['zoom']);
		}
		
		//Guardamos el cromosoma
		define('_CHR', $chr);
		
		//Guardamos el filtro de Gauss utilizado
		define('_GAUSS', $gauss);
		
		//Archivos que vamos a incluir
		$chromosomeF = $folder.$chr.'_F.php';
		$chromosomeR = $folder.$chr.'_R.php';
		$chromosomeA = $folder.$chr.'_A.php';
		
		//Titulos
		$titulo = 'Region '._CHR.'';
		$nombre = 'R_'._CHR.'';
		
		//Generamos la nueva url
		$url = 'view-region.php?id='._ID.'&chr='._CHR.'&ini='.$ini.'&fin='.$fin.'&gauss='._GAUSS;
		
		//Variables
		$chr = array();
		$genes = array();
		
		//*********************************** Fichero Forward
			
		//Incluimos el fichero forward
		require $chromosomeF;
			
		//Aplicamos el filtro de Gauss
		$chr_v = FiltroGauss($chr_v, $gauss);
		
		//Alineamos
		$chr_N = AlinearHebras($chr_p, $chr_v);
		
		//Guardamos
		$chr[0] = $chr_N[0];
		$chr[1] = $chr_N[1];
		
		//*************** Procesamos el R
		
		//Comprobamos si es especifico de hebra
		
		if($p_strand)
		{
			//Incluimos el archivo
			require $chromosomeR;
			
			//Aplicamos el filtro de Gauss
			$chr_v = FiltroGauss($chr_v, $gauss);
			
			//Alineamos
			$chr_N = AlinearHebras($chr_p, $chr_v);
		}
		
		//Guardamos
		$chr[2] = $chr_N[0];
		$chr[3] = $chr_N[1];
		
		//Borramos los vectores para ahorrar memoria
		unset($chr_p); unset($chr_v); unset($chr_N);
		
		//Cogemos la dimension minima
		$tam = min(count($chr[1]), count($chr[3]));
		
		//Cogemos los margenes
		$margen_izq = max($ini, 0);
		$margen_der = min($fin, $tam - 1);
		
	?>
	
	<!-- Info de la region -->
	<div class="form" align="left">
		
		<!-- Id del proyecto -->
		<span class="h4">Project ID: <?php echo _ID; ?></span><br>
		
		<!-- Cromosoma -->
		<span class="h4">Chromosome: <?php  echo _CHR; ?></span><br>
		
		<!-- Intervalo -->
		<span class="h4">Interval: [<?php echo $chr[0][$margen_izq]; ?>, 
		<?php echo $chr[0][$margen_der]; ?>]</span><br>
		
		<!-- Escala -->
		<span class="h4">X-scale: <?php echo $img_zoom; ?>x zoom</span>
		
		<!-- Espacios -->
		<br><br>
	
		<!-- Boton volver atras -->
		<a href="project.php?id=<?php echo _ID; ?>" class="form-btn background-red">Project home</a>
		
	</div>
	
	<!-- Espacios -->
	<br><br>
	
	<?php 
		//Alerta
		ExplorerAlert();
		
		//*********************************** Fichero de anotacion
			
		//Cogemos el fichero de anotacion		
		$genes = CargarFichAnotacion($chromosomeA);
		
		//Comprobamos si hay genes
		if(file_exists($chromosomeA))
		{
			//Buscamos el indice donde empiezan los genes
			$chr_idini = BuscarIndiceGen($chr[0], $genes[2]);
				
			//Buscamos el indice donde terminan los genes
			$chr_idfin = BuscarIndiceGen($chr[0], $genes[3]);
				
			//Cogemos los indices de los genes que caen dentro del margen y los ordenamos
			$id_selec = BuscarGenesMargen($chr_idini, $chr_idfin, $margen_izq, $margen_der);
			
			//Nos quedamos solo con los genes que nos interesan
			$genes[0] = SubSeleccionar($id_selec, $genes[0]);
			$genes[1] = SubSeleccionar($id_selec, $genes[1]);
			$genes[2] = SubSeleccionar($id_selec, $genes[2]);
			$genes[3] = SubSeleccionar($id_selec, $genes[3]);
		}
		
		//Creamos el vector que contiene todos los indices que estan contenidos en el margen
		$ids_chr = GenerarIndicesMargen($margen_izq, $margen_der);
		
		//Subseleccionamos el vector de posiciones
		$chr[0] = SubSeleccionar($ids_chr, $chr[0]);
		
		//Subseleccionamos el vector de valores del Forward
		$chr[1] = SubSeleccionar($ids_chr, $chr[1]);
	
		//Subseleccionamos el vector de valores del Reverse
		$chr[3] = SubSeleccionar($ids_chr, $chr[3]);
		
		//Iniciamos el vector de nucleotidos para el explorador
		ExplorerIniciarNuc();
		
		//Desactivamos las marcas
		ExplorerDesactivarMarcas();
		
		//Generamos la imagen
		Img($chr, $genes, $titulo, -1, null);
		
		//Mostramos el explorador
		Explorer();
		
		?>
		
		<!-- Formulario para hacer zoom -->
		<div class="form" align="center">
		
			<!-- Titulo -->
			<span class="h2">Zoom</span><br><br>
			
			<!-- Formulario para modificar la resolucion -->
			<form enctype="multipart/form-data" action="<?php echo $url; ?>" method="post">
				
				<!-- Seleccion de la escala eje X -->
				X-scale (Zoom in/out): 
				<select name="zoom" class="select">
					<option value="1">auto (1x)</option>
					<option value="2">2x</option>
					<option value="3">3x</option>
					<option value="4">4x</option>
				</select>
				
				<!-- Boton enviar -->
				<input type="submit" value="Readjust" class="background-blue search-btn">
				
			</form>
		
		</div>
		
		<!-- Espacios -->
		<br>
		
		<?php
		//Generamos el boton para descargar las imagenes
		ImgBtnRegion($nombre);
		
		//Mostramos la info para el annotate
		Annotate();
	}
	else
	{
		//Si no existe el fichero, es porque no existe el proyecto. Mostramos un error
		echo '<div class="alert background-red">Error: project does not exist.</div>';
		echo '<br><br><br><br>';
	}
?>