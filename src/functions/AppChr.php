<?php 
	//Funcion que devuelve un vector con los valores solo de los indices que le damos
	function SubSeleccionar($ids, $vector)
	{
		//Vector que devolveremos
		$valores = array();
		
		//Indice para el nuevo vector
		$j = 0;
	
		//Cojemos la dimension
		$dim = count($ids);
	
		//Cogemos solo los que necesitamos
		for($i = 0; $i < $dim; $i++)
		{
			//Guardamos el valor
			$valores[$j] = $vector[$ids[$i]];
			
			//Aumentamos el indice
			$j++;
		}
	
		//Devolvemos el nuevo vector
		return $valores;
	}
	
	//Funcion que ajusta el vector
	function AjustarChr($chr, $pos)
	{
		//Creamos el nuevo vector R
		$posR = array();
		$valR = array();
	
		//Cogemos las posiciones
		$val_F = $chr[0][$pos];
		$val_R = $chr[2][$pos];
		
		//Calculamos la diferencia
		$diferencia = $val_F - $val_R;
		
		//Comprobamos si se van mucho
		if(abs($diferencia) < 12)
		{
			//Si no se van mucho, los dejamos tal cual
		}
		else
		{
			//Si ya se van demasiado, los reajustamos
			$nuevo_pos = 0;
			$tamF = count($chr[1]);
			$tamR = count($chr[3]);
				
			//Buscamos el nuevo indice
			for($i = 0; $i < $tamR; $i++)
			{
				if($val_F <= $chr[2][$i])
				{
					//Si nos hemos pasado, cogemos el indice
					$nuevo_pos = max(0, $i - 1);
					
					//Salimos del for
					break;
				}
			}
			
			//Cogemos la diferencia
			$diff = $pos - $nuevo_pos;
			
			//Rellenamos el nuevo vector
			for($i = 0; $i < $tamF; $i++)
			{
				if($i - $diff < 0)
				{
					//Si el R aun no ha empezado
					$posR[$i] = $chr[2][0];
					$valR[$i] = $chr[3][0];
				}
				else if($i - $diff >= $tamR)
				{
					//Si el R ya ha terminado
					$posR[$i] = $chr[2][$tamR - 1];
					$valR[$i] = $chr[3][$tamR - 1];
				}
				else
				{
					//Si ya ha empezado y no se ha terminado el R
					$posR[$i] = $chr[2][$i - $diff];
					$valR[$i] = $chr[3][$i - $diff];
				}
			}
			
			//Modificamos
			$chr[2] = $posR;
			$chr[3] = $valR;
		}
	
		//Devolvemos el vector
		return $chr;
	}
?>