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
			$nombre = $chr_list[$i].'_A.php';
			
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
		$vector[1] = $ids;    //IDs
		
		//Dimension
		$tam = count($ids);
		
		//Ordemos $vector[1]
		$vector[1] = natcasesortv($vector[1]);
		
		//Cogemos los indices originales
		for($i = 0; $i < $tam; $i++)
		{
			//Buscmos el indice
			$j = array_search($vector[1][$i], $ids);
			
			//Lo guardamos
			$vector[0][$i] = $j;
		}
		
		//Lo devolvemos
		return $vector;
	}
	
	//Funcion que devuelve un array ordenado
	function natcasesortv($array)
	{
		//Ordenamos el array alfanumericamente
		natcasesort($array);

		//Ponemos los indices correctos
		$array = array_values($array);
		
		//Lo devolvemos
		return $array;
	}
?>