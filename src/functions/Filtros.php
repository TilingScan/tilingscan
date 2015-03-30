<?php 
	//Esta funcion aplica el filtro de Gauss a los valores
	function FiltroGauss($var, $num)
	{
		//Variables para aplicar el filtro
		$aux = array();
		
		//Variables propias del filtro
		$a = 0.383;
		$b = 0.242;
		$c = 0.061;
		$d = 0.006;
		
		//Cogemos la dimension del vector
		$lon = count($var);
		
		//Aplicamos el filtrado de Gauss $num veces
		for($k = 0; $k < $num; $k++)
		{
			//Bucle que recorre todo el vector $var
			for($i = 0; $i < $lon; $i++)
			{
				$aux[3] = $var[$i];
				
				if($i - 1 < 0) $aux[2] = $var[$i];
				else $aux[2] = $var[$i-1];
				
				if($i - 2 < 0) $aux[1] = $var[$i];
				else $aux[1] = $var[$i-2];
				
				if($i - 3 < 0) $aux[0] = $var[$i];
				else $aux[0] = $var[$i-3];
				
				if($i + 1 >= $lon) $aux[4] = $var[$i];
				else $aux[4] = $var[$i+1];
				
				if($i + 2 >= $lon) $aux[5] = $var[$i];
				else $aux[5] = $var[$i+2];
				
				if($i + 3 >= $lon) $aux[6] = $var[$i];
				else $aux[6] = $var[$i+3];
				
				//Guardamos el nuevo valor
				$var[$i] = $aux[0]*$d + $aux[1]*$c + $aux[2]*$b + $aux[3]*$a + $aux[4]*$b + $aux[5]*$c + $aux[6]*$d;
			}
		}
		
		//Devolvemos el resultante
		return $var;
	}
?>