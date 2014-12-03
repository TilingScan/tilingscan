<?php
	
	//Anotacion('C_albicans.gff', '');

	//Funcion que procesa el fichero de anotacion
	function Anotacion($fich, $dest)
	{
		//Variables para guardar los nombres
		$chr_nam = array();
		$chr_ids = array();
		$chr_ini = array();
		$chr_fin = array();
		$chr_tip = array();
		$chr_tam = 0;
		
		//Nombre del organismo
		$organismo = '';
		
		//Auxiliares
		$aux_nam = '';
		$aux_id = 0;
		$aux_tam = 0;
		
		//Abrimos el fichero
		$entrada = fopen($fich, 'r');
		
		//Guardamos todo el fichero en un string
		$string = fgets($entrada);
		
		//Cogemos el caracter que corresponde a un retorno de carro
		$car = chr(13);
		
		//Separamos el string por saltos de carro
		$var = explode($car, $string);
		
		//Cogemos la longitud
		$lon = count($var);
		
		//Recorremos todo el vector
		for($i = 0; $i < $lon; $i++)
		{
			//COmprobamos que no esta vacia
			if(!empty($var[$i]))
			{
				//Comprobamos que no sea de la cabecera o de la parte de DNA
				if($var[$i][0] != '#' && $var[$i][0] != '>')
				{
					//Cogemos el tipo
					$ti = AnotacionComprobarCHROMOSOME($var[$i]);
					
					//Comprobamos el tipo que es
					if($ti == 'CHR')
					{
						//Si es CHROMOSOME, iniciamos el cromosoma
							
						//Cogemos el nombre del cromosoma
						$chr_nam[$chr_tam] = AnotacionGetCHR($var[$i]);
							
						//Iniciamos el resto de vectores
						$chr_ids[$chr_tam] = array();
						$chr_ini[$chr_tam] = array();
						$chr_fin[$chr_tam] = array();
						$chr_tip[$chr_tam] = array();
							
						//Incrementamos el contador
						$chr_tam++;
						
						//Cogemos el organismo
						if($organismo == '')
						{
							$organismo = AnotacionGetOrganismo($var[$i]);
						}
					}
					else if($ti == 'ORF')
					{
						//Si no es CHROMOSOME
							
						//Cogemos el cromosoma que estamos
						$aux_nam = AnotacionGetCHR($var[$i]);
							
						//Cogemos el indice correcto
						$aux_id = AnotacionGetNUM($aux_nam, $chr_nam);
							
						//Cogemos la dimension
						$aux_tam = count($chr_ids[$aux_id]);
							
						//Cogemos la posicion inicial
						$chr_ini[$aux_id][$aux_tam] = AnotacionGetINI($var[$i]);
							
						//Cogemos la posicion final
						$chr_fin[$aux_id][$aux_tam] = AnotacionGetFIN($var[$i]);
							
						//Cogemos el tipo (forward o reverse)
						$chr_tip[$aux_id][$aux_tam] = AnotacionGetTIPO($var[$i]);
							
						//Cogemos el nombre
						$chr_ids[$aux_id][$aux_tam] = AnotacionGetID($var[$i]);
					}
				}
				
				//Fin comprobacion de la cabecera
			}
			
			//Fin comprobacion que no sea vacia
		}
		
		//Cerramos el fichero
		fclose($entrada);
		
		//Lo eliminamos, ya que no lo vamos a utilizar mas
		//unlink($fich);
		
		//Guardamos los ficheros de anotacion
		AnotacionGuardar($dest, $chr_nam, $chr_ids, $chr_tip, $chr_ini, $chr_fin);
		
		//Mostramos
		//AnotacionMostrar($dest, $chr_nam, $chr_ids, $chr_tip, $chr_ini, $chr_fin);
		
		//Devolvemos el organismo
		return $organismo;
	}
	
	//Funcion que comprueba si tenemos un ORF o no
	function AnotacionComprobarCHROMOSOME($txt)
	{
		//Lo que devolvemos
		$devolver = 'otro';
		$tx = 'otro';
		
		//Particionamos el string
		$txt2 = explode('	', $txt);
		
		//Si no esta vacio
		if(!empty($txt2[2]))
		{
			$tx = preg_replace('/[^A-Za-z0-9\. -]/', '', $txt2[2]);
		}
		
		//Comprobamos si tenemos un chromosome
		if($tx == 'chromosome')
		{
			//Si es chromosome, devolvemos un true
			$devolver = 'CHR';
		}
		
		//Comprobamos si tenemos un ORF
		if($tx == 'ORF')
		{
			//Si es chromosome, devolvemos un true
			$devolver = 'ORF';
		}
		
		//Lo devolvemos
		return $devolver;
	}
	
	//Funcion que devuelve el nombre del cromosoma
	function AnotacionGetCHR($txt)
	{
		//Particionamos el string
		$txt2 = explode('	', $txt);
		
		//Devolvemos el nombre del cromosoma
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $txt2[0]);
	}
	
	//Funcion que devuelve el nombre del organismo
	function AnotacionGetOrganismo($txt)
	{
		//Buscamos donde empiezan los caracteres que nos interesan
		$pos1 = strpos($txt, '_');
		$pos2 = strpos($txt, ';');
		
		//Longitud
		$lon = $pos2 - $pos1;
		
		//Cogemos el nombre
		$rest = substr($txt, $pos1 + 1, $lon - 1);
	
		//Devolvemos el nombre del organismo
		return $rest;
	}
	
	//Funcion que devuelve el numero del cromosoma
	function AnotacionGetNUM($nombre, $vector)
	{
		//Cogemos la dimension del vector
		$lon = count($vector);
		
		//Recorremos todo el vectro buscando el indice
		for($i = 0; $i < $lon; $i++)
		{
			//Comprobamos si coincide
			if($vector[$i] == $nombre)
			{
				//Si coincide, devolvemos el indice
				return $i;
			}
		}
	}
	
	
	//Funcion que devuelve la posicion inicial del gen
	function AnotacionGetINI($txt)
	{
		//Particionamos el string
		$txt2 = explode('	', $txt);
		
		//Devolvemos la posicion
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $txt2[3]);
	}
	
	//Funcion que devuelve la posicion final del gen
	function AnotacionGetFIN($txt)
	{
		//Particionamos el string
		$txt2 = explode('	', $txt);
	
		//Devolvemos la posicion
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $txt2[4]);
	}
	
	//Funcion que devuelve el tipo (Forward o Reverse)
	function AnotacionGetTIPO($txt)
	{
		//Particionamos el string
		$txt2 = explode('.	', $txt);
	
		//Cogemos el tipo
		$tipo = $txt2[1][0];
		
		//Comprobamos el tipo
		if($tipo == '+')
		{
			//Devolvemos Forward
			return 'F';
		}
		else
		{
			//Devolvemos Reverse
			return 'R';
		}
	}
	
	//Funcion que devuelve el nombre del gen
	function AnotacionGetID($txt)
	{
		//Cogemos el =
		$ini = strpos($txt, '=');
		
		//Cogemos el ;
		$fin = strpos($txt, ';');
		
		//Longitud
		$lon = $fin - $ini;
		
		//Cogemos el nombre
		$rest = substr($txt, $ini + 1, $lon - 1);
		
		//Devolvemos el nombre
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $rest);
	}
	
	//Funcion que guarda los ficheros de anotacion
	function AnotacionGuardar($dest, $chr_nam, $chr_ids, $chr_tip, $chr_ini, $chr_fin)
	{
		//Cogemos el numero de cromosomas que tenemos
		$tam = count($chr_nam);
		
		//Vector con los indices ordenados
		$ids = array();
		
		//Recorremos todo el vector
		for($i = 0; $i < $tam; $i++)
		{			
			//Cogemos cuantos genes tenemos guardados
			$num = count($chr_ids[$i]);
			
			//Ordenamos segun la posicion de inicio
			$ids = AnotacionOrdenar($chr_ini[$i]);
			
			//Creamos el archivo
			$file = $dest.$chr_nam[$i].'_A.php';			
			
			//Abrimos el archivo para su escritura
			$entrada = fopen($file, 'w');
			
			fwrite($entrada, '<'.'?php '); //Primera linea
			fwrite($entrada, '$'.'chr_ids = array'.'(); '); //Iniciar el vector de ids
			fwrite($entrada, '$'.'chr_tip = array'.'(); '); //Iniciar el vector de tipo (Reverse, Forward)
			fwrite($entrada, '$'.'chr_ini = array'.'(); '); //Iniciar el vector de posicion inicial
			fwrite($entrada, '$'.'chr_fin = array'.'(); '); //Iniciar el vector de posicion final
			
			//Recorremos todos
			for($j = 0; $j < $num; $j++)
			{
				//Guardamos el ID
				fwrite($entrada, '$'.'chr_ids['.$j.'] = "'.$chr_ids[$i][$ids[$j]].'"; ');
				
				//Guardamos el tipo de gen				
				fwrite($entrada, '$'.'chr_tip['.$j.'] = "'.$chr_tip[$i][$ids[$j]].'"; ');
				
				//Guardamos la posicion inicial
				fwrite($entrada, '$'.'chr_ini['.$j.'] = '.$chr_ini[$i][$ids[$j]].'; ');
				
				//Guardamos la posicion final
				fwrite($entrada, '$'.'chr_fin['.$j.'] = '.$chr_fin[$i][$ids[$j]].'; ');
			}
			
			fwrite($entrada, '?'.'>'); //Ultima linea
			
			//Cerramos el fichero
			fclose($entrada);
			
			//Lo guardamos como 0777
			chmod($file, 0777);
		}
		
		//Listo
	}
	
	//Funcion que ordena y devuelve un vector con los indices ordenador
	function AnotacionOrdenar($vector)
	{
		//Vector de indices
		$id = array();
		
		//Cogemos la dimension
		$tam = count($vector);
		
		//Iniciamos todo el vector
		for($i = 0; $i < $tam; $i++)
		{
			$id[$i] = $i;
		}
		
		//Ordenamos el vector $vector
		for($i = 1; $i < $tam; $i++)
		{
			$indice = $vector[$i];
			$indice2 = $id[$i];
			for($j = $i-1; $j >= 0 && $vector[$j] > $indice; $j--)
			{
				$vector[$j + 1] = $vector[$j];
				$id[$j + 1] = $id[$j];
			}
			$vector[$j + 1] = $indice;
			$id[$j + 1] = $indice2;
		}
		
		//Lo devolvemos
		return $id;
	}
	
	//Funcion que muestra lkos resultados por pantalla
	function AnotacionMostrar($dest, $chr_nam, $chr_ids, $chr_tip, $chr_ini, $chr_fin)
	{
		//Cogemos el numero de cromosomas que tenemos
		$tam = count($chr_nam);
		
		//Recorremos todo el vector
		for($i = 0; $i < $tam; $i++)
		{
			//Cogemos cuantos genes tenemos guardados
			$num = count($chr_ids[$i]);
				
			//Mostramos el nombre
			echo $chr_nam[$i].'<br>';
				
			//Recorremos todos
			for($j = 0; $j < $num; $j++)
			{
				//Mostramos el id
				echo ' '.$chr_ids[$i][$j].' ';
				
				//Guardamos el tipo de gen
				echo 'Tipo: '.$chr_tip[$i][$j].' ';
				
				//Guardamos la posicion inicial
				echo 'Ini: '.$chr_ini[$i][$j].' ';
				
				//Guardamos la posicion final
				echo 'Fin: '.$chr_fin[$i][$j].' <br>';
			}
		}
		//Listo
	}
?>