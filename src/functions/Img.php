<?php
	//Contadores de las posiciones de los genes
	$g_F = 0;
	$g_R = 0;
	$g_max = 4;
	
	//Contador del numero de imagenes
	$img_num = 0;
	$img_ini = array();
	$img_fin = array();
	
	//Para saber la posicion de inicio
	$img_start = 0;
	
	//Incremento para el marcador de Kb
	$img_kb_inc = 10;
	
	//Zoom
	$img_zoom = 1;
	
	//Para los genes
	$img_genes_cont = 0;
	$img_genes_id = array();
	$img_genes_px = array();
	$img_genes_py = array();
	$img_genes_an = array();
	
	//Funcion que genera las imagenes
	function Img($chr, $genes, $titulo, $gen_sel, $ventana)
	{
		/*
		 * VARIABLES DE ENTRADA
		 * chr: vector que contiene los datos de posicion y expresion
		 * 	chr[0] = posicion  F
		 * 	chr[1] = expresion F
		 *  chr[2] = posicion  R
		 * 	chr[3] = expresion R
		 * 
		 * genes: vector que contiene los datos de los genes
		 * 	genes[0] = ids de los genes
		 * 	genes[1] = Si el gen esta en la F o en la R
		 * 	genes[2] = Nucleotido de inicio del gen
		 * 	genes[3] = Nucleotido de final del gen
		 * 
		 * ventana: ventana seleccionada
		 *  ventana[0] = posicion inicial de la ventana
		 *  ventana[1] = posicion final de la ventana
		 *  
		 */
		
		//Variables globales
		global $img_num, $img_ini, $img_fin, $img_kb_inc, $img_zoom;
		global $img_genes_cont, $img_genes_id, $img_genes_px, $img_genes_py, $img_genes_an;
		
		//Cogemos la dimension de la zona a pintar
		$hits = min(count($chr[1]), count($chr[3]));
		
		//Contamos cuantas imagenes van a ser necesarias
		$num_img = ImgInt($hits/_IMG_ANC);
		
		//Buscamos el indice donde empiezan los genes
		$genes_ini = BuscarIndiceGen($chr[0], $genes[2]);
		
		//Buscamos el indice donde terminan los genes
		$genes_fin = BuscarIndiceGen($chr[0], $genes[3]);
		
		//Para evitar errores
		$chr[0][$hits] = $chr[0][$hits - 1];
		$chr[1][$hits] = $chr[1][$hits - 1];
		$chr[3][$hits] = $chr[3][$hits - 1];
		$genes_ini[count($genes_ini)] = $hits + 10000;
		
		//Pasamos a log2
		$chr = ImgLog2($chr, $hits);
		
		//Iniciamos el contador de Kb
		$img_kb = ImgIniciarKb($chr[0][0]);
		
		//Variables para recorrer
		$i = 0; //Recorre el vector chr[0]
		$i_ini = 0;
		$i_fin = 0;
		$j = 0; //Recorre la imagen
		$g = 0; //Recorre los genes
		$chr_minmax = array();
		
		//Para saber las posiciones del vector de nucleotidos
		$nuc_ini = 0;
		$nuc_fin = 0;
		
		//Variables de la imagen
		$img = null;
		$img_anc = _IMG_ANC + _IMG_ANC_MARGEN;
		$img_alt = _IMG_ALT;
		$img_src = null;		
		
		//Bucle
		for($k = 0; $k < $num_img; $k++)
		{			
			//Comprobamos si es la ultima imagen
			if($k == $num_img -1)
			{
				//Si es la ultima, ponemos solo lo que nos queda
				$img_anc = $img_zoom*($hits - _IMG_ANC*($k)) + _IMG_ANC_MARGEN + 120; // 120 es el margen final
				
				//Comprobamos si no tiene la anchura minima
				if($img_anc < _IMG_MIN)
				{
					$img_anc = _IMG_MIN;
				}
			}
			
			//Reiniciamos el contador para esta imagen
			$j = 0;
			
			//Reiniciamos los contadores de los genes
			$img_genes_cont = 0;
			$img_genes_id = array();
			$img_genes_px = array();
			$img_genes_py = array();
			$img_genes_an = array();
			
			//Cogemos en cual empieza
			$nuc_ini = $i;
			
			//Cogemos cuantos hits vamos a hacer
			$i_ini = $i;
			$i_fin = min($i + $img_anc - _IMG_ANC_MARGEN - 1, $hits);
			
			//Cogemos el maxio y em minimo
			$chr_minmax = ImgBuscarMax($chr[1], $chr[3], $i_ini, $i_fin);
			
			//Ajustamos los valores a la zona de la imagen
			$chr[1] = ImgAjustar($chr[1], $chr_minmax, $i_ini, $i_fin);
			$chr[3] = ImgAjustar($chr[3], $chr_minmax, $i_ini, $i_fin);
			
			//Buscamos los ejes
			$chr_ejes = ImgBuscarEjes($chr_minmax);
			
			//Guardamos el ID
			$img_id = $img_num + $k;
			
			//Creamos la imagen
			$img = ImgIniciar($img_anc, $img_alt, $chr_ejes);
			
			//Situamos el valor inicial del nucleotido
			//$img = ImgSituarNucleotido($img, $i, 0, $chr);
			
			//Recorremos
			while($j < $img_anc - _IMG_ANC_MARGEN - 1 && $i < $hits)
			{
				//Situamos el contador de Kb
				if($chr[0][$i] <= $img_kb*1000 && $img_kb*1000 <= $chr[0][$i + 1])
				{
					//Lo dibujamos
					$img = ImgDibujarKb($img, $j, $i, $img_kb);
					
					//Aumentamos el contador
					$img_kb = $img_kb + $img_kb_inc;
				}
					
				//Situamos la expresion solo si no estamos al final
				if($j < $img_anc - _IMG_ANC_MARGEN - 2 && $i < $hits - 1)
				{
					$img = ImgExpresion($img, $i, $j, $chr);
				}
				
				//Comprobamos si estamos en el ID donde empieza/termina la region
				if(!is_null($ventana))
				{
					//Comprobamos si empieza o si termina
					if($ventana[0] == $i || $ventana[1] == $i)
					{
						//Decidimos si estamos al principio o al final
						if($ventana[0] == $i)
						{
							//Estamos al principio
							$tipo = 1;
						}
						else
						{
							//Estamos al final
							$tipo = -1;
						}
						
						//Dibujamos la region
						$img = ImgWindow($img, $i, $j, $chr, $tipo);
					}
				}
				
				//Buscamos si hay algun gen que empiece en el punto en el que estamos
				while($genes_ini[$g] <= $i)
				{
					//Comprobamos si el indice en el que estamos coincide
					if($genes_ini[$g] == $i)
					{
						//Si coincide, lo pintamos
						$img = ImgGen($img, $i, $j, $g, $genes, $genes_ini, $genes_fin, $img_anc, $gen_sel);
					}
				
					//Aumentamos el contador de indices
					$g++;
				}
				
				//Si estamos al principio, buscamos si hay algún gen a medias
				if($j == 0)
				{
					//Cogemos un nuevo contador
					$g2 = max(0, $g - 20);
					
					//Buscamos los anteriores
					while($genes_ini[$g2] < $i)
					{
						//Comprobamos si esta a mitad de pintar
						if($genes_ini[$g2] < $i && $genes_fin[$g2] >= $i)
						{
							//Si coincide, lo pintamos
							$img = ImgGen($img, $i, $j, $g2, $genes, $genes_ini, $genes_fin, $img_anc, $gen_sel);
						}
					
						//Aumentamos el contador de indices
						$g2++;
					}
				}
				
				//Incrementamos los contadores
				$j = $j + $img_zoom;
				$i++;
			}
			
			//Cogemos en cual ha terminado
			$nuc_fin = $i;
			
			//Situamos el valor final del nucleotido
			//$img = ImgSituarNucleotido($img, $i - 1, $j, $chr);
			
			//Situamos los textos
			$img = ImgSituarTextos($img, $img_anc, $img_alt, $titulo);
			
			//Situamos la dimension en nucleotidos de la imagen
			$img = ImgSituarNucleotido($img, $chr, $nuc_ini, $nuc_fin);
			
			//Creamos la leyenda
			$img = ImgLeyenda($img);
			
			//Generamos la imagen
			ob_start();
			
			imagepng($img, null, 3);
			
			// Capture the output
			$imagedata = ob_get_contents();
			
			// Clear the output buffer
			ob_end_clean();
			
			//Liberamos memoria
			imagedestroy($img);
			
			//Mostramos la imagen
			ImgMostrar($imagedata, $img_id);
			
			//Guardamos el vector con los nucleotidos
			ExplorerGuardarNuc($chr[0], $nuc_ini, $nuc_fin, $img_num + $k, $chr_minmax);
			
			//Guardamos las posiciones inicial y final
			$img_ini[$img_num + $k] = $chr[0][$nuc_ini];
			$img_fin[$img_num + $k] = $chr[0][$nuc_fin];
		}
		
		//Aumentamos el contador global de imagenes
		$img_num = $img_num + $num_img;
	}
	
	//Funcion que muestra la imagen
	function ImgMostrar($img_src, $img_id)
	{
		echo '<img src="data:image/png;base64,'.base64_encode($img_src).'" id="image_'.$img_id.'" style="display: none;">';
	}
	
	//Funcion que inicia la imagen con los ejes y todo
	function ImgIniciar($anc, $alt, $ejes)
	{
		//Iniciamos la imagen
		$img = imagecreatetruecolor($anc + 30, $alt);
		
		//Iniciamos los colores
		$blanco = ColorBlanco($img);
		$negro = ColorNegro($img);
		$gris = ColorGris($img);
		
		//Creamos el fondo
		imagefilledrectangle($img, 0, 0, $anc + 30, $alt, $blanco);
		
		//Creamos el eje vertical
		imageline($img, _IMG_ANC_MARGEN, _IMG_ALT_TITULO, _IMG_ANC_MARGEN, _IMG_ALT_TITULO + _IMG_ALT_ZONA - 1, $negro);
		
		//Creamos el eje horizontal
		imageline($img, _IMG_ANC_MARGEN, _IMG_ALT_TITULO + _IMG_ALT_ZONA - 1, $anc, _IMG_ALT_TITULO + _IMG_ALT_ZONA - 1, $negro);
		
		//Creamos el eje horizontal de los genes
		imageline($img, _IMG_ANC_MARGEN, _IMG_ALT_TITULO + _IMG_ALT_ZONA + 15 + (_IMG_ALT_GEN/2) , $anc, _IMG_ALT_TITULO + _IMG_ALT_ZONA + 15 + (_IMG_ALT_GEN/2) , $gris);
		
		//Creamos cuantos ejes hay
		$ejes_num = count($ejes[0]);
		
		//Situamos los ejes
		for($i = 0; $i < $ejes_num; $i++)
		{
			//Situamos
			$img = ImgSituarEje($img, $ejes[0][$i], $ejes[1][$i], $anc);	
		}

		//Devolvemos la imagen
		return $img;
	}
	
	//Funcion que situa el eje
	function ImgSituarEje($img, $pos, $num, $anc)
	{
		//Colores
		$negro = ColorNegro($img);
		$gris = ColorGris($img);
		
		//Situamos el eje horizontal
		imageline($img, _IMG_ANC_MARGEN + 1, _IMG_ALT_TITULO + $pos, $anc, _IMG_ALT_TITULO + $pos, $gris);
			
		//Situamos el numerito
		imagettftext($img, 10, 0, 15, _IMG_ALT_TITULO + $pos + 5, $negro, _FONT, $num);
		
		//Devolvemos la imagen
		return $img;
	}
	
	//Funcion que situa los textos
	function ImgSituarTextos($img, $anc, $alt, $titulo)
	{
		//Iniciamos los colores
		$blanco = ColorBlanco($img);
		$negro = ColorNegro($img);
		$azul = ColorAzul($img);
		$rojo = ColorRojo($img);
		
		//Ponemos el rectangulo arriba
		imagefilledrectangle($img, 30, 0, $anc, _IMG_ALT_TITULO, $blanco);
		
		//Situamos el texto
		imagettftext($img, 40, 0, 1, 55, $negro, _FONT, $titulo);
		
		//Titulos para los genes
		imagettftext($img, 15, 90, 20, _IMG_ALT_TITULO + _IMG_ALT_ZONA + (_IMG_ALT_GEN/2), $azul, _FONT, 'Watson strand');
		imagettftext($img, 15, 90, 20, _IMG_ALT_TITULO + _IMG_ALT_ZONA + _IMG_ALT_GEN, $rojo, _FONT, 'Crick strand');
		
		//La devolvemos
		return $img;
	}
	
	//Funcion que dibuja el nucleotido en la posicion deseada
	/*
	function ImgSituarNucleotido($img, $i, $j, $chr)
	{
		//Iniciamos el color
		$negro = ColorNegro($img);
		
		//Situamos el valor
		imagettftext($img, 10, 0, _IMG_ANC_MARGEN + $j, _IMG_ALT_TITULO + _IMG_ALT_ZONA + 13, $negro, _FONT, $chr[0][$i]);
		
		//Devolvemos la imagen
		return $img;
	}
	*/
	function ImgSituarNucleotido($img, $chr, $ini, $fin)
	{
		//Iniciamos el color
		$gris = ColorNegro($img);
		
		//Generamos el titulo
		$tit = '['.$chr[0][$ini].', '.$chr[0][$fin - 1].']';
	
		//Situamos el valor
		imagettftext($img, 14, 0, 3, 88, $gris, _FONT, $tit);
	
		//Devolvemos la imagen
		return $img;
	}
	
	//Funcion que situa la leyenda
	function ImgLeyenda($img)
	{
		//Cogemos el global
		global $p_strand;
		
		//Comprobamos si es especifico de hebra
		if($p_strand == true)
		{
			//Cogemos los colores
			$azul = ColorAzul($img);
			$rojo = ColorRojo($img);
			$blanco = ColorBlanco($img);
			
			//Posiciones de la leyenda
			$px = _IMG_ANC_MARGEN + 180;
			$py = 86;
			
			//Ponemos el fondo de la leyenda
			//imagefilledrectangle($img, $px, $py, $px + 85, $py + 30, $blanco);
			
			//Ponemos el texto
			imagettftext($img, 10, 0, $px     , $py, $azul, _FONT, 'Forward');
			imagettftext($img, 10, 0, $px + 80, $py, $rojo, _FONT, 'Reverse');
			
			//Ponemoslas rectas de muestra
			imagefilledrectangle($img, $px + 55 , $py - 6, $px + 75 , $py - 4,  $azul);
			imagefilledrectangle($img, $px + 132, $py - 6, $px + 152, $py - 4, $rojo);
		}
		
		//Devolvemos la imagen
		return $img;
	}
	
	//Funcion que dibuja las lineas de la expresion
	function ImgExpresion($img, $i, $j, $chr)
	{
		//Variables globales
		global $img_zoom;
		
		//Cogemos los colores
		$azul = ColorAzul($img);
		$rojo = ColorRojo($img);
		
		//Pintamos la recta del Reverse
		$o_x = _IMG_ANC_MARGEN + $j;
		$f_x = _IMG_ANC_MARGEN + $j + $img_zoom;
		$o_y = _IMG_ALT_TITULO + $chr[3][$i];
		$f_y = _IMG_ALT_TITULO + $chr[3][$i + 1];
		//imageline($img, $o_x, $o_y, $f_x, $f_y, $rojo);
		ImgBoldLine($img, $o_x, $o_y, $f_x, $f_y, $rojo);
	
		//Pintamos la recta del Forward
		$o_x = _IMG_ANC_MARGEN + $j;
		$f_x = _IMG_ANC_MARGEN + $j + $img_zoom;
		$o_y = _IMG_ALT_TITULO + $chr[1][$i];
		$f_y = _IMG_ALT_TITULO + $chr[1][$i + 1];
		//imageline($img, $o_x, $o_y, $f_x, $f_y, $azul);
		ImgBoldLine($img, $o_x, $o_y, $f_x, $f_y, $azul);
		
		//Devolvemos la imageen
		return $img;
	}
	
	//Funcion que dibuja la linea si estamos en una region
	function ImgWindow($img, $i, $j, $chr, $tipo)
	{
		//Cogemos los colores
		$morado = ColorMorado($img);
		
		//Valores para la recta
		$o_x = _IMG_ANC_MARGEN + $j;
		$f_x = _IMG_ANC_MARGEN + $j + 1;
		$o_y = _IMG_ALT_TITULO;
		$f_y = _IMG_ALT_TITULO + _IMG_ALT_GEN + _IMG_ALT_ZONA;
		
		//Pintamos la recta
		imagefilledrectangle($img, $o_x, $o_y, $f_x , $f_y,  $morado);
		
		//Situamos la posicion		
		imagettftext($img, 10, 0, _IMG_ANC_MARGEN + $j + 5, _IMG_ALT_TITULO + _IMG_ALT_ZONA + 13, $morado, _FONT, $chr[0][$i]);
		
		//Ponemos si es el inicio o al final
		$o_x = _IMG_ANC_MARGEN + $j;
		$f_x = _IMG_ANC_MARGEN + $j + 9*$tipo;
		$o_y = _IMG_ALT_TITULO;
		$f_y = _IMG_ALT_TITULO + 3;
		
		//Pintamos la base de la flecha
		imagefilledrectangle($img, $o_x, $o_y, $f_x , $f_y,  $morado);
		
		//Ponemos la punta de la recta
		$o_x = _IMG_ANC_MARGEN + $j + 9*$tipo;
		$f_x = _IMG_ANC_MARGEN + $j + 4*$tipo;
		$o_y = _IMG_ALT_TITULO;
		$f_y = _IMG_ALT_TITULO + 4;
		
		ImgBoldLine($img, $o_x, $o_y, $f_x, $f_y, $morado, 3);
		
		//Devolvemos la imagen
		return $img;
	}
	
	//Funcion que dibuja los genes
	function ImgGen($img, $i, $j, $g, $genes, $genes_ini, $genes_fin, $anc_max, $gen_sel)
	{
		//Cogemos las variables globales
		global $g_F, $g_R, $g_max, $img_zoom;
		
		//Contadores de los genes
		global $img_genes_cont, $img_genes_id, $img_genes_px, $img_genes_py, $img_genes_an;
		
		//Colores
		$azul = ColorAzul($img);
		$rojo = ColorRojo($img);
		$gris = ColorGris($img);
		$morado = ColorMorado($img);
		
		//Variables del rectangulo del gen
		$box_anc = ($genes_fin[$g] - $genes_ini[$g])*$img_zoom;
		$box_alt = 2;
		$box_pox = _IMG_ANC_MARGEN + $j;
		$box_poy = _IMG_ALT_TITULO + _IMG_ALT_ZONA;
		$boc_col = null;
		$box_zona = _IMG_ALT_GEN/(2*$g_max);
		
		//Variables del texto
		$tex_pox = _IMG_ANC_MARGEN + $j;
		$tex_poy = 0;
		$tex_tam = 10;
		$tex_t1 = $genes[0][$g];
		$tex_t2 = '['.$genes[2][$g].', '.$genes[3][$g].']';
		
		//Comprobamos la anchura de la caja
		if($genes_ini[$g] < $i)
		{
			//Rectificamos
			$box_anc = $genes_fin[$g] - $i;
		}
		
		//Comprobamos el tipo
		if($genes[1][$g] == 'F')
		{
			$box_poy = _IMG_ALT_TITULO + _IMG_ALT_ZONA + 20 + $g_F*($box_zona);
			$box_col = $azul;
			$g_F++;
		}
		else
		{
			$box_poy = _IMG_ALT_TITULO + _IMG_ALT_ZONA + 20 + (_IMG_ALT_GEN/2) + $g_R*($box_zona);
			$box_col = $rojo;
			$g_R++;
		}
		
		//Hacemos para que no se salga de la zona de imagen
		if($anc_max <= $box_pox + $box_anc)
		{
			$box_anc = $anc_max - $box_pox;
		}
		
		//Dibujamos el gen
		imagefilledrectangle($img, $box_pox, $box_poy, $box_pox + $box_anc, $box_poy + $box_alt, $box_col);
		
		//Comprobamos si es el gen seleccionado
		if($gen_sel >= 0)
		{
			if($gen_sel == $g)
			{
				//Si es el gen seleccionado, dibujamos dos rectas
				//verticales al principio y al final del gen
				imageline($img, _IMG_ANC_MARGEN + $j, _IMG_ALT_TITULO, _IMG_ANC_MARGEN + $j, $box_poy, $morado);
				imageline($img, _IMG_ANC_MARGEN + $j + $box_anc, _IMG_ALT_TITULO, _IMG_ANC_MARGEN + $j + $box_anc, $box_poy, $morado);
			}
		}
		
		//Situamos el texto
		$tex_poy = $box_poy + 5 + $tex_tam;
		imagettftext($img, $tex_tam, 0, $tex_pox, $tex_poy, $box_col, _FONT, $tex_t1);
		imagettftext($img, $tex_tam, 0, $tex_pox, $tex_poy + 2*$tex_tam - 6, $box_col, _FONT, $tex_t2);
		
		//Comprobamos los indices
		if($g_F == $g_max)
		{
			$g_F = 0;
		}
		if($g_R == $g_max)
		{
			$g_R = 0;
		}
		
		//Guardamos el gen
		$img_genes_id[$img_genes_cont] = $tex_t1;
		$img_genes_px[$img_genes_cont] = $box_pox;
		$img_genes_py[$img_genes_cont] = $box_poy;
		$img_genes_an[$img_genes_cont] = $box_anc;
		
		//Aumentamos el contador
		$img_genes_cont++;
		
		//Devolvemos
		return $img;
	}
	
	
	//Funcion que busca el maximo entre los dos vectores
	function ImgBuscarMax($vector1, $vector2, $ini, $fin)
	{
		//Array para guardar el maximo y el minimo
		$minmax = array();

		//Iniciamos las variables
		$maximo = -1000;
		$minimo =  1000;
	
		//Juntamos loss dos vectores
		//$result = array_merge($vector1, $vector2);
	
		//Cogemos la dimension
		//$lon = count($result);
	
		//Buscamos el maximo en el vector
		for($i = $ini; $i < $fin; $i++)
		{
			//Buscamos el maximo
			
			//Comprobamos si es maximo en el vector 1
			if($maximo < $vector1[$i])
			{
				//Lo guardamos
				$maximo = $vector1[$i];
			}
			
			//Comprobamos si es maximo en el vector 2
			if($maximo < $vector2[$i])
			{
				//Lo guardamos
				$maximo = $vector2[$i];
			}
			
			//Buscamos el minimo
			
			//Comprobamos si es minimo en el vector 1
			if($minimo > $vector1[$i])
			{
				//Lo guardamos
				$minimo = $vector1[$i];
			}
				
			//Comprobamos si es maximo en el vector 2
			if($minimo > $vector2[$i])
			{
				//Lo guardamos
				$minimo = $vector2[$i];
			}
			
		}
		
		//Lo guardamos en el array
		$minmax[0] = $maximo + 0.05;
		$minmax[1] = $minimo - 0.05;
	
		//Lo devolvemos
		return $minmax;
	}
	
	//Esta funcion ajusta los valores a la zona de la imagen
	function ImgAjustar($var, $minmax, $ini, $fin)
	{
		//Cogemos las variables
		$maximo = $minmax[0];
		$minimo = $minmax[1];
	
		//Una vez tenemos el maximo y el minimo, ajustamos los valores
		for($i = $ini; $i < $fin; $i++)
		{
			//Ajustamos antiguo //$aux = $altura - $altura*($aux/$maximo);
			
			//Convertimos el valor
			$var[$i] = ImgValorConvertido($var[$i], $maximo, $minimo);
		}
	
		//Devolvemos
		return $var;
	}
	
	//Esta funcion busca donde estarian situados los ejes
	function ImgBuscarEjes($minmax)
	{
		//Cogemos el minimo y el maximo
		$maximo = $minmax[0];
		$minimo = $minmax[1];
		
		//Creamos los vectores para saber el valor y la posicion del eje
		$ejes_pos = array();
		$ejes_val = array();

		//Cogemos el valor de inicio
		$ini = intval($minimo);
		
		//Comprobamos para que no se salga
		if($ini < $minimo)
		{
			//Aumentamos uno para evitar que se salga de la zona de dibujo
			$ini = $ini + 1;
		}
		
		//Contador
		$j = 0;
		
		//Bucle para los positivos
		for($i = $ini; $i < $maximo; $i++)
		{
			//Gurdamos el eje
			$ejes_pos[$j] =  ImgValorConvertido($i, $maximo, $minimo);
			
			//Guardamos el velor
			$ejes_val[$j] = $i;
			
			//Aumentamos el contador
			$j++;
		}
		
		//Creamos el array con los ejes
		$ejes = array();
		
		//Guardamos
		$ejes[0] = $ejes_pos;
		$ejes[1] = $ejes_val;
		
		//Devolvemos los ejes
		return $ejes;
	}
	
	//Funcion que devuelve el valor convertido
	function ImgValorConvertido($val, $maximo, $minimo)
	{
		//Devolvemos el valor ajustado a la zona
		return _IMG_ALT_ZONA - _IMG_ALT_ZONA*(($val - $minimo)/($maximo - $minimo));
	}
	
	//Funcion que pasa un numero a entero
	function ImgInt($num)
	{
		//Iniciamos
		$int = 0;
		
		//Lo pasamos a entero
		for($i = 0; $i < $num; $i++)
		{
			$int++;
		}
		
		//Lo devolvemos
		return $int;
	}
	
	//Funcion que inicia el contador de Kb
	function ImgIniciarKb($ini)
	{
		//Cogemos el incremento
		global $img_kb_inc;
		
		//Iniciamos el contador
		$cont = 0;
		
		//Lo buscamos
		while($cont*1000 < $ini)
		{
			//Incrementamos
			$cont = $cont + $img_kb_inc;
		}
				
		//Lo devolvemos
		return $cont;
	}
	
	//Funcion que dibuja el marcador de las Kb
	function ImgDibujarKb($img, $j, $i, $kb)
	{
		//Iniciamos el color
		$gris = ColorGris($img);
		
		//Calculamos la recta
		$o_x = _IMG_ANC_MARGEN + $j;
		$f_x = _IMG_ANC_MARGEN + $j;
		$o_y = _IMG_ALT_TITULO;
		$f_y = _IMG_ALT_TITULO + _IMG_ALT_ZONA + 15;
		
		//La situamos
		imageline($img, $o_x, $o_y, $f_x, $f_y, $gris);
		
		//Creamos el texto
		$text = $kb.' Kb';
		
		//Lo situamos
		imagettftext($img, 10, 0, $f_x + 3, $f_y, $gris, _FONT, $text);
		
		//Devolvemos la image
		return $img;
	}
	
	//Funcion que crea un boton para descargar todas las imagenes
	function ImgBtn($nombre)
	{
		//Mostramos el script
		ImgScriptBtn($nombre);
		
		//Mostramos el boton para ir a una region concreta
		ImgGoToRegion();
		
		//Mostramos el boton
		echo '<a class="form-btn background-blue" onclick="DownloadThisImg();">Download this image</a>';
		echo '<a class="form-btn background-red" onclick="DownloadAllImg();">Download all images</a>';
	}
	
	//Funcion que crea un boton para descargar la imagen de la region
	function ImgBtnRegion($nombre)
	{
		//Mostramos el script
		ImgScriptBtn($nombre);
	
		//Mostramos el boton
		echo '<a class="background-blue form-btn" onclick="DownloadThisImg();">Download Region</a>';
	}
	
	//Funcion que genera el script necesario para el boton y el explorador
	function ImgScriptBtn($txt)
	{
		//Cogemos el numero de imagenes total
		global $img_num, $img_zoom;
		
		//Iniciamos el javascript
		echo '<script type="text/javascript">';
		
		//Mostramos el numero de imagenes
		echo 'var num_img = '.$img_num.'; ';
		
		//Mostramos el zoom utilizado
		echo 'var zoom = '.$img_zoom.'; ';
		
		//Mostramos el nombre
		echo 'var nombre = "'.$txt.'"; ';
		
		//Cerramos el script
		echo '</script>';
	}
	
	//Funcion que muestra el select para ir a una region concreta
	function ImgGoToRegion()
	{
		//Cogemos cuantas imagenes hay
		global $img_num, $img_ini, $img_fin;
		
		//Contenedor
		echo '<div class="form" align="center">';
		
		//Titulo
		echo '<span class="h2">Jump to section:</span><br><br>';
		
		//Mostramos el select
		echo '<select id="select_region" class="select" onchange="ViewChangeSection(this);">';
		
		//Rellenamos el select
		for($i = 0; $i < $img_num; $i++)
		{
			//Creamos el numero de la seccion real
			$n = $i + 1;
			
			//Creamos el intervalo
			$interval = '['.$img_ini[$i].', '.$img_fin[$i].']';
			
			//Lo mostramos
			echo '<option value="'.$i.'">Section '.$n.' '.$interval.'</option>';
		}
		
		//Cerramos el select
		echo '</select> ';
		
		//Cerramos el contenedor
		echo '</div>';
		
		//Espacios
		echo '<br>';
	}
	
	//Funcion que pinta una linea con una anchura determinada
	function ImgBoldLine($resource, $x1, $y1, $x2, $y2, $Color, $BoldNess=2, $func='imageline')
	{
		$center = round($BoldNess/2);
		for($i=0;$i<$BoldNess;$i++)
		{
			$a = $center-$i; if($a<0){$a -= $a;}
			for($j=0;$j<$BoldNess;$j++)
			{
				$b = $center-$j; if($b<0){$b -= $b;}
				$c = sqrt($a*$a + $b*$b);
				if($c<=$BoldNess)
				{
					$func($resource, $x1 +$i, $y1+$j, $x2 +$i, $y2+$j, $Color);
				}
			}
		}
	}
	
	//Funcion que calcula el log2 de los datos de expresion
	function ImgLog2($chr, $hits)
	{
		//Recorremos todo el vector
		for($i = 0; $i < $hits; $i++)
		{
			//Calculamos el log2
			$chr[1][$i] = log($chr[1][$i], 2);
			$chr[3][$i] = log($chr[3][$i], 2);
		}
		
		//Devolvemos el vector
		return $chr;
	}
	
?>