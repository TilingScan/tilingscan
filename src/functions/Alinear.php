<?php
	//Funcion que completa los datos que faltan en las hebras
	function AlinearHebras($chr_p, $chr_v)
	{
		//Nucleotidos por sonda
		$nuc = AlinearEstudiarSondas($chr_p);
	
		//Creamos la tolerancia
		$tol = $nuc*_TOL;
	
		//Nuevo array
		$nuevo = array();
	
		//En el nuevo, tenemos el de posicion y el de expresion
		$nuevo[0] = array();
		$nuevo[1] = array();
	
		//Dimenson
		$tam = count($chr_p);
	
		//Contadores
		$i = 0;
		$j = 0;
		$k = 0;
	
		//Otras
		$inc = 0;
	
		//Insertamos el primero
		$nuevo[0][$j] = $chr_p[$i];
		$nuevo[1][$j] = $chr_v[$i];
	
		//Bucle
		for($i = 1; $i < $tam; $i++)
		{
			//Aumentamos el contador de la j
			$j = $j + 1;
				
			//Contamos la distancia
			$dist = $chr_p[$i] - $chr_p[$i - 1];
				
			//Comprobamos cuanto vale la distancia
			if($dist > $nuc && $dist <= $tol)
			{
				//Reiniciamos el contador
				$k = 1;
		
				//Vamos aumentando el contador
				while($dist - $k*$nuc > 0)
				{
					//Calculamos el incremento
					$inc = ($chr_v[$i] - $chr_v[$i - 1])*($k*$nuc/$dist);
						
					//Insertamos
					$nuevo[0][$j] = $chr_p[$i - 1] + $k*$nuc;
					$nuevo[1][$j] = $chr_v[$i - 1] + $inc;
						
					//Aumentamos los contadors
					$k = $k + 1;
					$j = $j + 1;
				}
			}
				
			//Insertamos el que estamos en la i
			$nuevo[0][$j] = $chr_p[$i];
			$nuevo[1][$j] = $chr_v[$i];
		}
	
		//Devolvemos
		return $nuevo;
	}
	
	//Funcion que realiza el estudio de cuantas sondas entre cada uno
	function AlinearEstudiarSondas($chr)
	{
		//Creamos el vector con las diferencias
		$dif = array();
		
		//Cogemos la dimension
		$tam = count($chr)/2;
		
		//Bucle
		for($i = 1; $i < $tam; $i++)
		{
			//Guardamos la diferencia
			$dif[$i - 1] = $chr[$i] - $chr[$i - 1];
		}
		
		//Creamos el array con todas las diferencias
		$dif = array_count_values($dif);
		
		//Cogemos el maximo
		$maximo = max($dif);
		
		//Buscamos el maximo en el array
		while($actual = current($dif))
		{
			//Comprobamos si el actual es el que buscamos
			if($actual == $maximo)
			{
				//Devolvemos el indice
				return key($dif);
			}
			
			//Pasamos al siguiente
			next($dif);
		}
		
		//Si ha ocurrido algun fallo
		return 12;
	}
?>