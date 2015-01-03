<?php
	//Expresion('30_0_F_signal.txt', '', 'F');
	
	//Funcion que procesa el fichero
	function Expresion($fich, $dest, $tipo)
	{	
		//Array
		$chr_nu = array();
		$chr_ex = array();
		$chr_list = array();
		$chr_id = '';
		$chr_num = 0;
		$i = 0;
		$i_max = 0;
		
		//Para que detecte automaticamente los saltos de linea
		ini_set('auto_detect_line_endings', true);
	
		//Abrimos el fichero
		$entrada = fopen($fich, 'r');
		
		//Contador de lineas en blanco
		$contador = 0;
	
		//Recorremos todo el fichero
		while( !feof($entrada) )
		{
			//Leemos # Secuence ID
			$string = fgets($entrada);
			
			//Reiniciamos el contador
			$contador = 0;
			
			//Bucle
			while(ExpresionSequence($string) === false)
			{
				//Leemos una nueva
				$string = fgets($entrada);
				
				//Aumentamos el contador
				$contador++;
				
				//Si lleva un rato
				if($contador > 20)
				{
					//Salimos
					break 2;
				}
			}
			
			//Sacamos el cromosoma
			$string = fgets($entrada);
			$chr_id = ExpresionGetCHR($string);
			$chr_nu = array();
			$chr_ex = array();
	
			//Obtenemos el numero de registros
			$string = fgets($entrada);
			$i_max = ExpresionGetHITS($string);
			$i = 0;
				
			//Linea en blanco
			$string = fgets($entrada);
				
			//Leemos todo el fichero
			while($i < $i_max)
			{
				//Cogemos la siguiente
				$string = fgets($entrada);
				
				//Cogemos la posicion
				$nu = ExpresionGetPOS($string);
				$chr_nu[$i] = $nu;
	
				//Cogemos la expresion
				$ex = ExpresionGetVAL($string);
				$chr_ex[$i] = $ex;
	
				//Aumentamos el i
				$i++;
			}
				
			//Guardamos el fichero
			$repetido = ExpresionGuardar($dest, $chr_id, $chr_nu, $chr_ex, $tipo);
			
			//Comprobamos si estaba repetido o no
			if($repetido == false)
			{
				//Si no estaba repetido, lo guardamos en la lista
				$chr_list[$chr_num] = $chr_id;
				$chr_num++;
			}
				
			//Linea en blanco
			$string = fgets($entrada);
		}
	
		//Cerramos el fichero
		fclose($entrada);
		
		
		//Si estamos guardando el forward, guardamos la lista
		if($tipo == 'F')
		{
			//Archivo de destino
			$file = $dest.'chr_list.php';
			
			//Creamos la lista
			ExpresionLista($file, $chr_list);
		}
		
		//Devolvemos el numero de cromosomas
		//return $chr_num;
	}
	
	//Funcion que devuelve true si la cadena $string contiene "Sequence"
	function ExpresionSequence($string)
	{
		//Buscamos "Sequence"
		$pos = stripos($string, "# Sequence");
		
		//Comprobamos si la ha encontrado
		if($pos === false)
		{
			//Devolvemos que no
			return false;
		}
		else
		{
			//Devolvemos que si
			return true;
		}
	}
	
	//Funcion que obtiene el cromosoma
	function ExpresionGetCHR($string)
	{
		//Cogemos el ID
		$rest = substr($string, 7);
	
		//Lo convertimos a entero
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $rest);
	}
	
	//Funcion que devuelve los hits
	function ExpresionGetHITS($string)
	{
		//Buscamos 'Hits'
		$pos = strpos($string, "Hits");
	
		//Cogemos solo el numero
		$rest = substr($string, $pos + 5);
		$rest = preg_replace('/[^A-Za-z0-9\. -]/', '', $rest);
	
		//Lo convertimos a entero
		return intval($rest);
	}
	
	//Funcion que devuelve la posicion
	function ExpresionGetPOS($string)
	{
		//Separamos
		$var = explode("	", $string);
	
		//Devolvemos la posicion
		return preg_replace('/[^A-Za-z0-9\. -]/', '', $var[0]);
	}
	
	//Funcion que devuelve la expresion
	function ExpresionGetVAL($string)
	{
		//Separamos
		$var = explode("	", $string);
	
		//Convertimos a caracteres correctos
		$valor = preg_replace('/[^A-Za-z0-9\. -]/', '', $var[1]);
		
		//Convertimos las comas en puntos
		$valor = str_replace(',', '.', $valor);
		
		//Devolvemos
		return $valor;
	}
	
	//Guarda los cromosomas
	function ExpresionGuardar($dest, $cr_id, $cr_nu, $cr_ex, $tipo)
	{
		//Variable para ver si esta repetido
		$repetido = false;
		
		//Nombre del fichero
		$file = $dest.$cr_id.'_'.$tipo.'.php';
		
		//Comprobamos si esta repetido
		if(file_exists($file))
		{
			//Si esta repetido, tenemos que juntar los dos vectores
			require $file;
			
			//Hacemos una copia
			$chr_p2 = $cr_nu;
			$chr_v2 = $cr_ex;
			
			//Comprobamos cual tiene que ir primero
			if($chr_p[0] < $chr_p2[0])
			{
				//Va primero el que teniamos
				$cr_nu = array_merge($chr_p, $chr_p2);
				$cr_ex = array_merge($chr_v, $chr_v2);
			}
			else
			{
				//Entonces va primero el nuevo
				$cr_nu = array_merge($chr_p2, $chr_p);
				$cr_ex = array_merge($chr_v2, $chr_v);
			}
			
			//Avisamos que estaba repetido
			$repetido = true;
		}
		
		//Ahora hay que comprobar si tiene fichero de anotacion
		if(file_exists($dest.$cr_id.'_A.php'))
		{
			//Guardamos el archivo $file
			$entrada = fopen($file, 'w');
			$long = count($cr_ex);
			
			//Primera linea
			fwrite($entrada, '<'.'?php ');
			
			//Iniciar el vector de posiciones
			fwrite($entrada, '$'.'chr_p = array'.'(); ');

			//Iniciar el vector de valores
			fwrite($entrada, '$'.'chr_v = array'.'(); ');
			
			for($i = 0; $i < $long; $i++)
			{
				//Guardamos la posicion
				fwrite($entrada, '$'.'chr_p['.$i.'] = '.$cr_nu[$i].'; ');
				
				//Guardamos el valor
				fwrite($entrada, '$'.'chr_v['.$i.'] = '.$cr_ex[$i].'; ');
			}
			
			//Ultima linea
			fwrite($entrada, '?'.'>');
			
			//Cerramos el fichero
			fclose($entrada);
			
			//Lo guardamos como 0777
			chmod($file, 0777);
		}
		else
		{
			//Si no tiene fichero de anotacion, no lo ponemos en la lista
			$repetido = true;
		}
		
		//Devolvemos si esta repetido o no
		return $repetido;
	}
	
	//Funcion que en vez de guardar los muestra
	function ExpresionMostrar($file, $cr_nu, $cr_ex)
	{
		//Mostramos el nombre
		echo $file.':<br>';
		
		//Contamos cuantos hay
		$long = count($cr_ex);
		
		//Bucle que los recorre
		for($i = 0; $i < $long; $i++)
		{
			echo $cr_nu[$i].' '.$cr_ex[$i].'<br>';
		}
	}
	
	//Esta funcion crea una lista con todos los cromosomas que hay en el fichero Foward
	function ExpresionLista($file, $chr_list)
	{
		//Guardamos el archivo $file
		$entrada = fopen($file, 'w');
		
		//Calculamos cuantos tenemos
		$long = count($chr_list);
		
		//Primera linea
		fwrite($entrada, '<'.'?php ');
		
		//Iniciar el vector de ids
		fwrite($entrada, '$'.'chr_list = array'.'(); ');
		
		//Recorremos todo el vector
		for($i = 0; $i < $long; $i++)
		{
			//Guardamos el id
			fwrite($entrada, '$'.'chr_list['.$i.'] = "'.$chr_list[$i].'"; ');
		}
		
		//Ultima linea
		fwrite($entrada, '?'.'>');
		
		//Cerramos el fichero
		fclose($entrada);
	
		//Lo guardamos como 0777
		chmod($file, 0777);
	}
	
	
?>