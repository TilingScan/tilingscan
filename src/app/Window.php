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
		$chr = $_POST['chr3'];
		
		//Guardamos el cromosoma
		define('_CHR', $chr);
	
		//Mostramos la info del proyecto
		ProyectoInfo($p_title, _ID, $p_autor, $p_descripcion, $p_date, $p_caducidad, true);
	
		//Mostramos la alerta
		ExplorerAlert();
	
		//Cogemos si ha seleccionado aplicar un filtro de Gauss
		$filtro_gauss = $_POST['gauss'];
	
		//Guardamos el filtro de Gauss utilizado
		define('_GAUSS', $filtro_gauss);
	
		//Cogemos la dimension de la ventana (minimo)
		$VEN = $_POST['VEN'];
	
		//Definimos el umbral
		$UMBRAL = floatval($_POST['UMBRAL']);
	
		//Comprobamos el umbral
		if($UMBRAL <= 0 || $UMBRAL > 1)
		{
			//Mostramos el error
			die('Error: you must set an Threshold value between 0 and 1.');
		}
		
		//Definimos el porcentaje
		$PORCENTAJE = intval($_POST['PORCENTAJE']);
		
		//Comprobamos el porcentaje
		if($PORCENTAJE < 0 || $PORCENTAJE > 100)
		{
			//Mostramos el error
			die('Error: you must set an Percentage value between 0 and 100.');
		}
		else
		{
			//Convertimos a valor entre 0 y 1
			$PORCENTAJE = $PORCENTAJE/100;
		}
		
		//Definimos el margen
		$MARGEN = intval($_POST['margen']);
	
		//Seleccionamos en cual quiere detectar ventanas (Forward o Reverse)
		$CADENA = $_POST['CADENA'];
	
		//Archivos que vamos a incluir
		$chromosomeF = $folder.'chr'.$chr.'_F.php';
		$chromosomeR = $folder.'chr'.$chr.'_R.php';
		$chromosomeA = $folder.'chr'.$chr.'_A.php';
	
		$titulo = 'Window Search Chr '._CHR.' ('.$CADENA.')';
		$nombre = 'W_CHR'._CHR.'_'.$CADENA;
	
		//Variables
		$chr = array();
		$genes = array();
		
		//Variable que almacena las regiones detectadas
		$ini_array = array();
		$fin_array = array();
	
		//Variable para generar el texto
		$window_txt = WindowIniTxt();
	
		//Variable que cuenta el numero de regiones detectadas
		$window_cont = 0;
	
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
	
	
		//********************************** Seleccionamos en cual se quiere detectar ventanas
	
		if($CADENA == 'Forward')
		{
			//Guardamos el vector de valores del Forward en el indice
			$analizar = $chr[1];
		}
		else
		{
			//Guardamos el vector de valores del Reverse en el indice y damos la vuelta
			$analizar = array_reverse($chr[3]);
		}
	
		//Cogemos la dimension minima
		$tam = min(count($chr[1]), count($chr[3]));
	
		//*********************************** Fichero de anotacion
			
		//Variable para saber si hay fichero de anotacion
		$anotacion = false;
	
		$genes = CargarFichAnotacion($chromosomeA);
	
		//Incluimos el fichero de anotacion
		if(file_exists($chromosomeA))
		{
			//Buscamos el indice donde empiezan los genes
			$chr_idini = BuscarIndiceGen($chr[0], $genes[2]);
				
			//Buscamos el indice donde terminan los genes
			$chr_idfin = BuscarIndiceGen($chr[0], $genes[3]);
				
			//Marcamos que si que hay fichero de anotacion
			$anotacion = true;
		}
	
		//Iniciamos el vector de nucleotidos para el explorador
		ExplorerIniciarNuc();
	
		//Iniciamos la media A
		$meA = 0;
		for($i = 0; $i < $VEN && $i < $tam; $i++)
		{
			$meA = $meA + $analizar[$i];
		}
	
		//Iniciamos la media B
		$meB = 0;
		for($i = $VEN; $i < ($VEN + $VEN) && $i < $tam; $i++)
		{
			$meB = $meB + $analizar[$i];
		}
	
		//Iniciamos las otras variables
		$escalon = 0;
		$entra = 0;
	
		//Bucle que detecta las ventanas
		for($i = $VEN; $i < ($tam - $VEN) && $i < $tam; $i++)
		{
			//Actualizamos las medias
			$meA = $meA + $analizar[$i] - $analizar[$i-$VEN];
			$meB = $meB + $analizar[$i + $VEN] - $analizar[$i];
				
			//Calculamos el valor de la media
			$valor_meA = $meA/$VEN;
			$valor_meB = $meB/$VEN;
			
			//Diferencia
			$dif = $valor_meB - $valor_meA;
			$dif_i= (1/$valor_meB) - (1/$valor_meA);
				
			if($dif >= $UMBRAL)
			{
				//Ventana positiva
				$escalon = 1;
			}
			
			if($dif_i >= $UMBRAL)
			{
				//Ventana negativa
				$escalon = 0;
			}
			
			//Marcamos si entra o no
			$entra = 0;
			
			if(($dif >= $UMBRAL) || ($dif_i >= $UMBRAL))
			{
				//--> para que ventana positiva este por encima de 1+(porcentaje*UMBRAL)
				if(($escalon == 1) && ($valor_meB > (1.0 + ($UMBRAL*$PORCENTAJE))))
				{
					//Entramos en la region
					$entra = 1;
				}
				
				//--> para que ventana negativa este por debajo de 1-(porcentaje*UMBRAL)
				if(($escalon == 0) && ((1/$valor_meB) > (1.0 + ($UMBRAL*$PORCENTAJE))))
				{
					//Entramos en la region
					$entra = 1;
				}
			}
			
			//Si hemos entrado en la region
			if($entra == 1)
			{
				//Guardamos la diferencia con la que entra
				$dif_entrada = $dif;
				$dif_entrada_i= $dif_i;
				
				//Guardamos el valor media de B con el que entra
				$v_meB_entrada = $valor_meB;
				
				//Inicio de region
				$ini_reg = $i;
				
				//Iniciamos la media de la ventana C
				$meC = 0;
				
				for($j = $i + $VEN + 1; $j < ($i + $VEN + $VEN + 1); $j++)
				{
					$meC = $meC + $analizar[$j];
				}
				
				$valor_meC = $meC/$VEN;
		
				$masi = 1; //--> nuevo, anyado uno más!!
	
				if($escalon == 1)
				{
					$dif = $valor_meB - $valor_meC;
						
					while(($dif < $UMBRAL) &&  ($valor_meB > (1.0 + ($UMBRAL*$PORCENTAJE))) && (($i + $VEN + $masi) < ($tam - $VEN)))
					{
						$meB = $meB + $analizar[$i + $VEN + $masi];
						$meC = $meC + $analizar[$i + $VEN + $VEN + $masi] - $analizar[$i + $VEN + $masi];
						$valor_meC = $meC/$VEN;
						$valor_meB = $meB/($VEN + $masi);
						$dif = $valor_meB - $valor_meC;
		
						$masi++;
					}
				}
				else
				{
					$dif_i = (1/$valor_meB) - (1/$valor_meC);
					
					while(($dif_i < $UMBRAL) && ((1/$valor_meB) > (1.0 + ($UMBRAL*$PORCENTAJE))) && (($i + $VEN + $masi)<($tam - $VEN)))
					{
						$meB = $meB + $analizar[$i + $VEN + $masi];
						$meC = $meC + $analizar[$i + $VEN + $VEN + $masi] - $analizar[$i + $VEN + $masi];
						$valor_meC = $meC/$VEN;
						$valor_meB = $meB/($VEN + $masi);
						$dif_i = (1/$valor_meB) - (1/$valor_meC);
		
						$masi++;
					}
				}
						
				$fin_reg = $i + $VEN + $masi - 1;  //--> salgo con masi++ --> (masi-1)
	
				if($fin_reg >= $tam - $VEN - 1)
				{
					//printf("\nRegion sin final!!\n");
				}
				else if($ini_reg !== 0 && $fin_reg !== 0)
				{
					//Aumentamos el contador
					$window_cont++;					
					
					//Pasamos al indice correcto
					if($CADENA == 'Forward')
					{
						//Lo dejamos como esta
						$bien_ini = $ini_reg;
						$bien_fin = $fin_reg;
					}
					else
					{
						//Aplicamos el cambio
						$bien_ini = count($chr[3]) - $fin_reg - 1;
						$bien_fin = count($chr[3]) - $ini_reg - 1;
					}
				
					//Generamos la info de la region
					$window_txt = WindowSaveTxt($window_txt);

					//Guardamos la region para representarla despues
					$ini_array[$window_cont - 1] = $bien_ini;
					$fin_array[$window_cont - 1] = $bien_fin;
				}
	
				$meA = $meC;
				$i = $fin_reg + $VEN;
	
				$meB = 0;
				for($j = 0; $j < $VEN && $i + $j + 1 < $tam; $j++) //MODIFICADO!!!!!!!!!!!!!!!!!!!
				{
					$meB = $meB + $analizar[$i + 1 + $j];
				}
	
			}//--> del if(UMBRAL)
		}//--> del for inicial.
		
		//Si estamos en el Reverse, representamos al reves
		if($CADENA == 'Reverse')
		{
			//Invertimos los vectores
			$ini_array = array_reverse($ini_array);
			$fin_array = array_reverse($fin_array);
		}
		
		//Generamos las imagenes
		for($m = 0; $m < $window_cont; $m++)
		{
			//Vectores para pasarle a la imagen
			$chr2 = array();
			$genes2 = array();
			$ventana = array();
			
			//Punto de inicio y final
			$margen_izq = max(0, $ini_array[$m] - $VEN - $MARGEN + 2);
			$margen_der = min($tam, $fin_array[$m] + $VEN + $MARGEN - 2);
			
			//Iniciamos el vector con los genes
			$genes2[0] = array();
			$genes2[1] = array();
			$genes2[2] = array();
			$genes2[3] = array();
			
			//Si hemos cargado el fichero de anotacion
			if($anotacion == true)
			{
				//Cogemos los indices de los genes que caen dentro del margen y los ordenamos
				$id_selec = BuscarGenesMargen($chr_idini, $chr_idfin, $margen_izq, $margen_der);
			
				//Nos quedamos solo con los genes que nos interesan
				$genes2[0] = SubSeleccionar($id_selec, $genes[0]);
				$genes2[1] = SubSeleccionar($id_selec, $genes[1]);
				$genes2[2] = SubSeleccionar($id_selec, $genes[2]);
				$genes2[3] = SubSeleccionar($id_selec, $genes[3]);
			}
			
			//Creamos el vector que contiene todos los indices que estan contenidos en el margen
			$ids_chr = GenerarIndicesMargen($margen_izq, $margen_der);
			
			//Cogemos los nuevos ids de la ventana
			$ventana[0] = min($VEN + $MARGEN - 2, $ini_array[$m]);
			$ventana[1] = ($fin_array[$m] - $ini_array[$m]) + $ventana[0];
				
			//Subseleccionamos el vector de posiciones
			$chr2[0] = SubSeleccionar($ids_chr, $chr[0]);
				
			//Subseleccionamos el vector de valores del Forward
			$chr2[1] = SubSeleccionar($ids_chr, $chr[1]);
			
			//Subseleccionamos el vector de valores del Reverse
			$chr2[3] = SubSeleccionar($ids_chr, $chr[3]);
			
			//Guardamos la posicion de inicio
			$img_start = $margen_izq;
			
			//Generamos la imagen
			Img($chr2, $genes2, $titulo, -1, $ventana, $margen_izq);
		}
	
		//Mostramos el explorador
		Explorer();
	
		//Generamos el boton para descargar las imagenes
		ImgBtn($nombre);
	
		//Generamos el fichero de salida
		WindowTxt($window_txt);
	}
	else
	{
		//Si no existe el fichero, es porque no existe el proyecto. Mostramos un error
		echo '<div class="alert background-red">Error: project does not exist.</div>';
		echo '<br><br><br><br>';
	}	
?>