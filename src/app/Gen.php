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
		
		//Cogemos el cromosoma que quiere
		$chr = $_POST["chr2"];
		
		//Guardamos el cromosoma
		define('_CHR', $chr);
		
		//Cogemos si ha seleccionado aplicar un filtro de Gauss
		$filtro_gauss = $_POST["gauss"];
		
		//Guardamos el filtro de Gauss utilizado
		define('_GAUSS', $filtro_gauss);
		
		//Archivos que vamos a incluir
		$chromosomeF = $folder.$chr.'_F.php';
		$chromosomeR = $folder.$chr.'_R.php';
		$chromosomeA = $folder.$chr.'_A.php';
		
		//Comprobamos si ha seleccionado algun gen
		if(isset($_POST['gen_'.$chr]))
		{
			//Cogemos el gen que quiere
			$gen_id = $_POST['gen_'.$chr];
				
			//Cogemos el margen que ha seleccionado
			$margen = $_POST['margen'];
				
			//Variables
			$margen_der = 0; $margen_izq = 0;
			
			$chr_idini = array();
			$chr_idfin = array();
			
			//Vectores para pasarle a la imagen
			$chr = array();
			$genes = array();
			
			//*********************************** Fichero de anotacion
		
			//Cargamos el fichero de anotacion
			$genes = CargarFichAnotacion($chromosomeA);
			
			//Creamos el titulo
			$titulo = 'Gene '.$genes[0][$gen_id].' ('._CHR.')';
			$nombre = _CHR.'_'.$genes[0][$gen_id];
			
			//Mostramos la info del proyecto
			ProyectoInfo($p_title, _ID, $p_autor, $p_descripcion, $p_date, $p_caducidad, true);
			
			//Mostramos la alerta
			ExplorerAlert();
			
			//*********************************** Fichero Forward
			
			//Incluimos el fichero forward
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
			
			//Escogemos el vector con menor numero de hits
			$tam = min(count($chr[1]), count($chr[3]));
			
			//Buscamos el indice donde empiezan los genes
			$chr_idini = BuscarIndiceGen($chr[0], $genes[2]);
			
			//Buscamos el indice donde terminan los genes
			$chr_idfin = BuscarIndiceGen($chr[0], $genes[3]);
			
			//Preparamos el margen a izquierda y a derecha
			$margen_izq = $chr_idini[$gen_id] - $margen;
			$margen_der = $chr_idfin[$gen_id] + $margen;
			
			//Cogemos los indices de los genes que caen dentro del margen y los ordenamos
			$id_selec = BuscarGenesMargen($chr_idini, $chr_idfin, $margen_izq, $margen_der);
			
			//Nos quedamos solo con los genes que nos interesan
			$genes[0] = SubSeleccionar($id_selec, $genes[0]);
			$genes[1] = SubSeleccionar($id_selec, $genes[1]);
			$genes[2] = SubSeleccionar($id_selec, $genes[2]);
			$genes[3] = SubSeleccionar($id_selec, $genes[3]);
			$nuevo_idi = SubSeleccionar($id_selec, $chr_idini);
			$nuevo_idf = SubSeleccionar($id_selec, $chr_idfin);
			
			//Actualizamos los margenes para que entren todos los genes
			$margen_izq = max(0, min($margen_izq, min($nuevo_idi)));
			$margen_der = min($tam - 1, max($margen_der, max($nuevo_idf)));
			
			//Creamos el vector que contiene todos los indices que estan contenidos en el margen
			$ids_chr = GenerarIndicesMargen($margen_izq, $margen_der);
			
			//Cogemos el indice de nuestro gen en el nuevo vector
			$nuevo_gen = SubSeleccionarID($id_selec, $gen_id);
			
			//Subseleccionamos el vector de posiciones
			$chr[0] = SubSeleccionar($ids_chr, $chr[0]);
			
			//Subseleccionamos el vector de valores del Forward
			$chr[1] = SubSeleccionar($ids_chr, $chr[1]);
			
			//Subseleccionamos el vector de valores del Reverse
			$chr[3] = SubSeleccionar($ids_chr, $chr[3]);
			
			//Borramos memoria
			unset($chr_idini); unset($chr_idfin);
			
			//Iniciamos el vector de nucleotidos para el explorador
			ExplorerIniciarNuc();
			
			//Guardamos la posicion de inicio
			$img_start = $margen_izq;
			
			//Generamos la imagen
			Img($chr, $genes, $titulo, $nuevo_gen, null);
			
			//Mostramos el explorador
			Explorer();
			
			//Generamos el boton para descargar las imagenes
			ImgBtn($nombre);
		}
		else
		{
			//Si no ha seleccionado alguno, mostramos un error
			echo '<div class="alert background-red">Error: there is not gen to show.</div>';
			echo '<br><br><br><br>';
		}
	}
	else
	{
		//Si no existe el fichero, es porque no existe el proyecto. Mostramos un error
		echo '<div class="alert background-red">Error: project does not exist.</div>';
		echo '<br><br><br><br>';
	}
?>
