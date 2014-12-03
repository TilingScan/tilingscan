<?php 
	//Mostramos la lista de cromosomas
	function ListaCHR($folder, $func, $num)
	{
		//Incluimos la lista de cromosomas
		require $folder.'chr_list.php';
		
		//Iniciamos el select
		echo '<select name="chr'.$num.'" id="chr'.$num.'" class="select" onchange="'.$func.'">';
		
		//Contamos todos los que hay
		$lon = count($chr_list);
		
		//Bucle que muestra todos los cromosomas
		for($i = 0; $i < $lon; $i++)
		{
			echo '<option value="'.$chr_list[$i].'">Chromosome '.$chr_list[$i].'</option>';
		}
		
		//Cerramos el select
		echo '</select> ';
	}
	
	//Funcion que devuelve una lista con los cromosomas que tengan fichero de anotacion
	function ListaCHRAnnotation($folder, $func, $num)
	{
		//Incluimos la lista de cromosomas
		require $folder.'chr_list.php';
	
		//Iniciamos el select
		echo '<select name="chr'.$num.'" id="chr'.$num.'" class="select" onchange="'.$func.'">';
	
		//Contamos todos los que hay
		$lon = count($chr_list);
	
		//Bucle que muestra todos los cromosomas
		for($i = 0; $i < $lon; $i++)
		{
			//Comprobamos si existe fichero de anotacion para ese cromosoma
			if(file_exists($folder.'chr'.$chr_list[$i].'_A.php'))
			{
				//Si existe lo sumamos a la lista
				echo '<option value="'.$chr_list[$i].'">Chromosome '.$chr_list[$i].'</option>';
			}
		}
	
		//Cerramos el select
		echo '</select> ';
	}
	
	//Mostramos la lista de genes
	function ListaGEN($folder)
	{
		//Incluimos la lista de cromosomas
		require $folder.'chr_list.php';
		
		//Contamos todos los que hay
		$lon = count($chr_list);
		
		//Para saber cual es el primero que existe
		$primero = -1;
		
		//Recorremos todos
		for($i = 0; $i < $lon; $i++)
		{
			//Cogemos el nombre del fichero de anotacion
			$nombre = 'chr'.$chr_list[$i].'_A.php';
			
			//Comprobamos si existe
			if(file_exists($folder.$nombre))
			{
				require $folder.$nombre;
					
				//Contamos cuantos genes hay
				$num = count($chr_ids);
					
				//Iniciamos el select
				echo '<select name="gen_'.$chr_list[$i].'" id="gen_'.$chr_list[$i].'" class="select" ';
					
				//Hacemos visible solo el primero
				if($i > 0)
				{
					echo 'style="display: none;"';
				}
					
				//Terminamos el select
				echo '>';
				
				//Ordenamos
				$ordenados = ListaOrdenarGenes($chr_ids);
					
				//Recorremos todos
				for($j = 0; $j < $num; $j++)
				{
					echo '<option value="'.$ordenados[0][$j].'">'.$ordenados[1][$j].'</option>';
				}
					
				//Cerramos el select
				echo '</select>';
				
				//Guardamos el primero que existe
				if($primero == -1)
				{
					$primero = $i;
				}
			}
			else
			{
				//Si no existe, mostramos un aviso
				echo '<b id="gen_'.$chr_list[$i].'" ';
				
				//Lo ocultamos
				echo 'style="display: none;"';
					
				//Terminamos el aviso
				echo '> No genes for this chromosome</b>';
			}
			
		}
		
		//Avisamos de cual esta activado
		echo '<script type="text/javascript">select_actual = "'.$chr_list[0].'";</script>';
	}
	
	//Funcion que ordena los genes
	function ListaOrdenarGenes($ids)
	{
		//Vector
		$vector = array();
		
		//Contenido
		$vector[0] = array(); //Indice original
		$vector[1] = $ids;     //IDs
		$vector[2] = array(); //Numero
		
		//Dimension
		$tam = count($ids);
		
		//Rellenamos los que faltan
		for($i = 0; $i < $tam; $i++)
		{
			//Ponemos la posicion original
			$vector[0][$i] = $i;
			
			//Cogemos el numero
			$vector[2][$i] = ListaCogerGenID($ids[$i]);
		}
		
		//Ordenamos $vector[2]
		for($i = 1; $i < $tam; $i++)
		{
			$indice0 = $vector[0][$i];
			$indice1 = $vector[1][$i];
			$indice2 = $vector[2][$i];
			
			for($j = $i-1; $j >= 0 && $vector[2][$j] > $indice2; $j--)
			{
				$vector[0][$j + 1] = $vector[0][$j];
				$vector[1][$j + 1] = $vector[1][$j];
				$vector[2][$j + 1] = $vector[2][$j];
			}
			
			$vector[0][$j + 1] = $indice0;
			$vector[1][$j + 1] = $indice1;
			$vector[2][$j + 1] = $indice2;
		}
		
		
		//Lo devolvemos
		return $vector;
	}
	
	//Funcion que devuelve el entero relativo al gen
	function ListaCogerGenID($text)
	{	
		//Cogemos la dimension
		$tam = strlen($text);
		
		//Cogemos el primer .
		$pos = strpos($text, '.');
		
		//Si no existe, mostramos un error
		if($pos === false) die('Error loading genes...');
		
		//Cogemos lo que nos interesa
		$rest = substr($text, $pos + 1, $tam - $pos - 1);
		
		//Buscamos si existe otro .
		$pos2 = strpos($rest, '.');
		
		//Comprobamos
		if($pos2 !== false)
		{
			//Si existe otro punto, cortamos
			$rest = substr($rest, 0, $pos2);
		}
		
		//Devolvemos el entero
		return intval($rest);
	}
?>