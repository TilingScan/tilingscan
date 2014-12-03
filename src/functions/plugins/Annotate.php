<?php
	//Funcion que recopila la info necesaria para el annotate
	function Annotate()
	{
		//Cogemos las variables globales
		global $chr, $genes, $p_title;
		
		//Generamos la info del proyecto
		$add = '?pro='.$p_title;
		
		//Generamos la info del cromosoma
		$add = $add.'&chr='._CHR;
		
		//Cogemos la longitud
		$tam = count($chr[0]);
		$lon = $chr[0][$tam-1] - $chr[0][0];
		$add = $add.'&len='.$lon;
		
		//Ponemos el inicio y el final
		$add = $add.'&ini='.$chr[0][0];
		$add = $add.'&end='.$chr[0][$tam-1];
		
		//Cogemos el valor medio
		$add = $add.'&wme='.AnnotateMean($chr[1]);
		$add = $add.'&cme='.AnnotateMean($chr[3]);
		
		//Cogemos los genes que estan en la region
		$add = $add.'&orf='.AnnotateOrfs($genes);
		
		//Generamos la url
		$url = _ANNOTATE_URL.$add;
		
		//Mostramos el boton
		echo '<a class="background-purple form-btn" href="'.$url.'" target="_blank">Add Region to Annotate!</a>';
	}
	
	//Funcion que genera la media
	function AnnotateMean($exp)
	{
		//Iniciamos la media
		$mean = 0;
		
		//Cogemos cuantos hay
		$tam = count($exp);
		
		//Recorremos
		for($i = 0; $i < $tam; $i++)
		{
			$mean = $mean + $exp[$i];
		}
		
		//Dividimos por cuantos hay
		$mean = $mean/$tam;
		
		//Redondeamos
		$mean = round($mean, 4);
		
		//Lo devolvemos
		return $mean;
	}
	
	//Funcion que devuelve la lista con los genes
	function AnnotateOrfs($genes)
	{
		//Iniciamos el string
		$orf = '';
		
		//Cogemos cuantos hay
		$tam = count($genes[0]);
		
		//Comprobamos si no hay
		if($tam == 0)
		{
			$orf = 'NO_ORF';
		}
		
		//Recorremos todos
		for($i = 0; $i < $tam; $i++)
		{
			//Guardamos el orf
			$orf = $orf.$genes[0][$i];
			
			//Cogemos el tipo
			if($genes[1][$i] == 'F')
			{
				//Esta en la Watson
				$tip = '(W)';
			}
			else
			{
				//Esta en la Crick
				$tip = '(C)';
			}
			
			//Lo ponemos
			$orf = $orf.$tip.',';
		}
		
		//Devolvemos
		return $orf;
	}
?>