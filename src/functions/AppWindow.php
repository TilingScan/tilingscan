<?php
	//Funcion que devuelve los puntos de inicio y fin de la region en
	//el nuevo vector de posiciones
	function WindowLocalizarPosiciones($chr, $ini, $fin)
	{
		//Creamos el nuevo vector en el que los contendremos
		$vector = array();
		
		//Buscamos el primero
		$i = 0;
		while($chr[$i + 1] < $ini)
		{
			$i++;
		}
		
		//Lo guardamos
		$vector[0] = $i;
		
		//Buscamos donde termina
		while($chr[$i + 1] < $fin)
		{
			$i++;
		}
		
		//Lo guardamos
		$vector[1] = $i;
				
		//Devolvemos el vector
		return $vector;
	}
	
	//Funcion que devuelve los indices donde inicia y termina la imagen
	function WindowIndicesMargen($chr, $izq, $der)
	{
		//Iniciamos el vector
		$vector = array();
		
		//Buscamos donde empieza
		$ini = 0;
		while($chr[$ini + 1] < $izq)
		{
			$ini++;
		}
		
		//Buscamos donde termina
		$fin = $ini;
		while($chr[$fin + 1] < $der)
		{
			$fin++;
		}
		
		//Lo creamos
		$j = 0;
		for($i = $ini; $i <= $fin; $i++)
		{
			$vector[$j] = $i;
			$j++;
		}
		
		//Lo devolvemos
		return $vector;
	}
	
	//Funcion que inicia el fichero de registro
	function WindowIniTxt()
	{
		//Cogemos las variables
		global $UMBRAL, $MARGEN, $VEN;
		
		//Iniciamos la variable
		$txt = "";
		
		//Guardamos la info del programa
		$txt = $txt._NAME." "._VERSION." \n";
		$txt = $txt._AUTHORS." \n";
		$txt = $txt._COPY." \n \n";
		
		//Guardamos la info del proyecto
		$txt = $txt."Project ID	"._ID." \n";
		
		//Guardamos el cromosoma
		$txt = $txt."Chromosome	"._CHR." \n \n";
		
		//Guardamos la informacion proporcionada
		$txt = $txt."Tthreshold	".$UMBRAL." \n";
		$txt = $txt."Margin	".$MARGEN." \n";
		$txt = $txt."Window size	".$VEN." \n";
		
		//Guardamos otro salto de linea
		$txt = $txt." \n";
		
		//Guardamos la primera fila
		$txt = $txt."window_num	window_start (nuc)	window_end (nuc)	mean_A	mean_B	mean_C";
		
		//Finalizamos la linea
		$txt = $txt." \n";
		
		//Lo devolvemos
		return $txt;
	}
	
	//Funcion que genera la informacion sobre la ventana
	function WindowSaveTxt($txt)
	{
		//Cogemos las variables globales
		global $chr, $bien_ini, $bien_fin, $window_cont, $valor_meA, $valor_meB, $valor_meC;
		
		//Guardamos
		$txt = $txt.$window_cont."	".$chr[0][$bien_ini]."	".$chr[0][$bien_fin]."	";
		$txt = $txt.$valor_meA."	".$valor_meB."	".$valor_meC;
		
		//Finalizamos la linea
		$txt = $txt." \n";
		
		//Devolvemos el texto
		return $txt;
	}
	
	//Funcion que genera el fichero de salida
	function WindowTxt($txt)
	{
		//Creamos el boton para descargar el texto
		echo '<a class="background-water form-btn" onclick="DownloadTxt();">Download .txt</a>';
		
		//Creamos el Div
		echo '<pre style="display: none;" id="window_txt">';
		
		//Introducimos el contenido
		echo $txt;
		
		//Cerramos el Div
		echo '</pre>';
	}
	
	//Funcion para girar el array