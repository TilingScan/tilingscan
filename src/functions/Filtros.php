<?php 
	//Esta funcion aplica el filtro de Gauss a los valores
	function FiltroGauss($var, $num)
	{
		//Variables para aplicar el filtro
		$aux = array();
		
		//Variables propias del filtro
		$a = 0.3989;
		$b = 0.2420;
		$c = 0.0540;
		
		//Cogemos la dimension del vector
		$lon = count($var);
		//Aplicamos el filtrado de Gauss $num veces
		for($k = 0; $k < $num; $k++)
		{
			//Bucle que recorre todo el vector $var
			for($i = 0; $i < $lon; $i++)
			{
				$aux[2] = $var[$i];
				
				if($i - 1 < 0) $aux[1] = $var[$i];
				else $aux[1] = $var[$i-1];
				
				if($i - 2 < 0) $aux[0] = $var[$i];
				else $aux[0] = $var[$i-2];
				
				if($i + 1 >= $lon) $aux[3] = $var[$i];
				else $aux[3] = $var[$i+1];
				
				if($i + 2 >= $lon) $aux[4] = $var[$i];
				else $aux[4] = $var[$i+2];
				
				//Guardamos el nuevo valor
				$var[$i] = $aux[0]*$c + $aux[1]*$b + $aux[2]*$a + $aux[3]*$b + $aux[4]*$c;
			}
		}
		
		//Devolvemos el resultante
		return $var;
	}
?>