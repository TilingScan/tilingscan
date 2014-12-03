<?php 
	//Cogemos el id del proyecto
	$id = $_GET['id'];
	
	//Guardamos la ID
	define('_ID', $id);
	
	//Creamos la carpeta contenedora
	$folder = _DATA.$id.'/';
	
	//Comprobamos si existe el fichero de configuracion
	if(file_exists($folder.'config.php'))
	{
		//Si existe, lo incluimos
		require $folder.'config.php';
		
		//Cogemos el cromosoma que quiere
		$chr = $_POST["chr1"];
		
		//Guardamos el cromosoma
		define('_CHR', $chr);
		
		//Mostramos la info del proyecto
		ProyectoInfo($p_title, _ID, $p_autor, $p_descripcion, $p_date, $p_caducidad, true);
		
		//Mostramos la alerta
		ExplorerAlert();
		
		//Cogemos si ha seleccionado aplicar un filtro de Gauss
		$filtro_gauss = $_POST["gauss"];
		
		//Guardamos el filtro de Gauss utilizado
		define('_GAUSS', $filtro_gauss);
		
		//Archivos que vamos a incluir
		$chromosomeF = $folder.'chr'.$chr.'_F.php';
		$chromosomeR = $folder.'chr'.$chr.'_R.php';
		$chromosomeA = $folder.'chr'.$chr.'_A.php';
		
		//Vectores para pasarle a la imagen
		$chr = array();
		$genes = array();
		
		//Creamos el titulo
		$titulo = 'Chromosome '._CHR;
		
		//***************** Procesamos el A
		
		//Cargamos el fichero de anotacion
		$genes = CargarFichAnotacion($chromosomeA);
		
		//***************** Procesamos el F
		
		//Incluimos el archivo
		require $chromosomeF;
				
		//Aplicamos el filtro de Gauss
		$chr_v = FiltroGauss($chr_v, $filtro_gauss);
		
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
			$chr_v = FiltroGauss($chr_v, $filtro_gauss);
			
			//Alineamos
			$chr_N = AlinearHebras($chr_p, $chr_v);
		}
		
		//Guardamos
		$chr[2] = $chr_N[0];
		$chr[3] = $chr_N[1];
		
		//Borramos los vectores para ahorrar memoria
		unset($chr_p); unset($chr_v); unset($chr_N);
		
		//Iniciamos el vector de nucleotidos para el explorador
		ExplorerIniciarNuc();
		
		//Generamos la imagen
		Img($chr, $genes, $titulo, -1, null);
		
		//Mostramos el explorador
		Explorer();
		
		//Generamos el boton para descargar las imagenes
		ImgBtn('CHR_'._CHR);
	}
	else
	{
		//Si no existe el fichero, es porque no existe el proyecto. Mostramos un error
		echo '<div class="alert background-red">Error: project does not exist.</div>';
		echo '<br><br><br><br>';
	} 
?>