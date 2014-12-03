<?php
	//Funcion que carga el fichero de anotacion
	function CargarFichAnotacion($fich)
	{
		//Iniciamos el vector
		$genes = array();
		$genes[0] = array();
		$genes[1] = array();
		$genes[2] = array();
		$genes[3] = array();
		
		//Incluimos el fichero de anotacion
		if(file_exists($fich))
		{
			//Ya que puede ser que sean secuencias de control, y por
			//lo tanto no exista fichero de anotacion
			require $fich;
		
			//Guardamos los vectores en el nuevo array
			$genes[0] = $chr_ids;
			$genes[1] = $chr_tip;
			$genes[2] = $chr_ini;
			$genes[3] = $chr_fin;
		
			//Borramos los vectores para ahorrar memoria
			unset($chr_ids); unset($chr_tip); unset($chr_ini); unset($chr_fin);
		}
		
		//Lo devolvemos
		return $genes;
	}
	
	//Funcion que busca el indice en el que empieza cada gen
	function BuscarIndiceGen($v_pos, $v_ind)
	{
		//Creamos el array
		$pos = array();
	
		//Contamos cuantos hay que recorrer
		$tam_ids = count($v_ind);
		$tam_pos = count($v_pos);
	
		$j = 0;
	
		//Recorremos todos
		for($i = 0; $i < $tam_ids; $i++)
		{
			//Comprobamos que no nos hayamos salido
			if($j < $tam_pos)
			{
				//Buscamos el indice en el que empieza
				while($v_pos[$j] < $v_ind[$i])
				{
					//Aumentamos el contador
					$j++;
	
					//Comprobamos que no nos hayamos salido
					if($j >= $tam_pos)
					{
						//Si nos hemos salido, quitamos uno
						$j = $tam_pos - 1;
	
						//Salimos del bucle
						break;
					}
				}
			}
			
			//Cuando salimos del bucle, es que lo hemos encontrado
			$pos[$i] = $j;
		}
	
		//Lo devolvemos
		return $pos;
	}
	
	//Funcion que busca y devuelve los indices de los genes que caen dentro del margen
	function BuscarGenesMargen($ini, $fin, $izq, $der)
	{
		//Vector con los ids que vamos a devolver
		$ids = array();
		$j = 0;
		
		//Contamos cuantos hay
		$tam = count($ini);
		
		//Buscamos los genes que queden por la izquierda
		for($i = 0; $i < $tam; $i++)
		{
			if($izq <= $fin[$i] && $ini[$i] <= $der)
			{
				//Lo sumamos al vector
				$ids[$j] = $i;
				$j++;
			}
		}
		
		//Lo devolvemos ordenado
		return OrdenarVector($ids);
	}
	
	//Funcion que ordena un vector
	function OrdenarVector($vector)
	{
		//Cogemos la dimension
		$tam = count($vector);
		
		//Ordenamos el vector $vector
		for($i = 1; $i < $tam; $i++)
		{
			$indice = $vector[$i];
			for($j = $i-1; $j >= 0 && $vector[$j] > $indice; $j--)
			{
				$vector[$j + 1] = $vector[$j];
			}
			$vector[$j + 1] = $indice;
		}
		
		//Lo devolvemos
		return $vector;
	}
	
	//Funcion que devuelve el indice de nuestro gen en el nuevo vector
	function SubSeleccionarID($ids, $gen)
	{
		//Cogemos la dimension
		$dim = count($ids);
		
		//Recorremos todo buscandolo
		for($i = 0; $i < $dim; $i++)
		{
			if($ids[$i] == $gen)
			{
				//Si lo hemos encontrado, devolvemos el indice
				return $i;
			}
		}
	}
	
	//Funcion que devuelve un vector con incides comprendidos entre dos valores
	function GenerarIndicesMargen($izq, $der)
	{
		//Iniciamos el vector
		$vector = array();
		$j = 0;
		
		//Lo creamos
		for($i = $izq; $i <= $der; $i++)
		{
			$vector[$j] = $i;
			$j++;
		}
		
		//Lo devolvemos
		return $vector;
	}
	
?>