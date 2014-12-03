<?php
	
	//Funcion que muestra el explorador
	function Explorer()
	{
		//Cojemos las variables globales
		global $img_num, $img_ini, $img_fin, $p_organismo;
		
		//Mostramos el canvas
		echo '<canvas id="canvas" width="950" height="750"></canvas>';
		
		//Activamos el javascript
		echo '<script type="text/javascript">';
		
		//Guardamos el ID del proyecto
		echo 'var proyecto_id = "'._ID.'"; ';
		
		//Guardamos el cromosoma
		echo 'var proyecto_chr = "'._CHR.'"; ';
		
		//Guardamos el filtro de gauss
		echo 'var proyecto_gauss = "'._GAUSS.'"; ';
		
		//Guardamos el organismo
		echo 'var proyecto_organismo = "'.$p_organismo.'"; ';
		
		//Activamos el explorador
		echo 'setTimeout(function(){ ExplorerIniciar(); }, 500); ';		
		
		//Cerramos el Javascript
		echo '</script>';
		
		//Espacios entre el canvas
		echo '<br><br>';
	}
	
	//Funcion que inicia el vector de posiciones de nucleotidos
	function ExplorerIniciarNuc()
	{		
		//Activamos el javascript
		echo '<script type="text/javascript">';
	
		//Vector para saber las posiciones de inicio
		echo 'var explorer_inicio = new Array(); ';
		
		//Para saber los valores
		echo 'var explorer_arr = new Array(); ';
		
		//Para saber el el eje de la Y
		echo 'var explorer_ymin = new Array(); ';
		echo 'var explorer_ymax = new Array(); ';
		
		//Para saber los genes
		echo 'var explorer_genes_id = new Array(); ';
		echo 'var explorer_genes_px = new Array(); ';
		echo 'var explorer_genes_py = new Array(); ';
		echo 'var explorer_genes_an = new Array(); ';
	
		//Cerramos
		echo '</script>';
	}
	
	//Funcion que guarda el vector con los nucleotidos
	function ExplorerGuardarNuc($vec, $ini, $fin, $pos, $minmax)
	{
		//Cojemos las variables globales
		global $img_start;
		
		//Contadores de los genes
		global $img_genes_cont, $img_genes_id, $img_genes_px, $img_genes_py, $img_genes_an;
		
		//Iniciamos el script
		echo '<script type="text/javascript">';
		
		//Generamos el verdadero inicio
		$start = $ini + $img_start;
		
		//Lo guardamos
		echo 'explorer_inicio['.$pos.'] = '.$start.'; ';
		
		//Iniciamos el array
		echo 'explorer_arr['.$pos.'] = new Array(); ';
		
		//Recorremos todo el vector
		$j = 0;
		for($i = $ini; $i < $fin; $i++)
		{
			//Lo guardamos
			echo 'explorer_arr['.$pos.']['.$j.'] = '.$vec[$i].'; ';
			
			//Aumentamos el contador
			$j++;
		}
		
		//Guardamos el valor del eje Y
		echo 'explorer_ymax['.$pos.'] = '.$minmax[0].'; ';
		echo 'explorer_ymin['.$pos.'] = '.$minmax[1].'; ';
		
		//Iniciamos los arrays de los genes
		echo 'explorer_genes_id['.$pos.'] = new Array(); ';
		echo 'explorer_genes_px['.$pos.'] = new Array(); ';
		echo 'explorer_genes_py['.$pos.'] = new Array(); ';
		echo 'explorer_genes_an['.$pos.'] = new Array(); ';
		
		//Guardamos los genes
		for($i = 0; $i < $img_genes_cont; $i++)
		{
			//Lo guardamos
			echo 'explorer_genes_id['.$pos.']['.$i.'] = "'.$img_genes_id[$i].'"; ';
			echo 'explorer_genes_px['.$pos.']['.$i.'] = '.$img_genes_px[$i].'; ';
			echo 'explorer_genes_py['.$pos.']['.$i.'] = '.$img_genes_py[$i].'; ';
			echo 'explorer_genes_an['.$pos.']['.$i.'] = '.$img_genes_an[$i].'; ';
		}
		
		//Cerramos el script
		echo '</script>';
	}
	
	//Funcion que muestra un aviso de que se esta cargando
	function ExplorerAlert()
	{
		//Div contenedor
		echo '<div id="explorer_alert">';
		
		//Creamos la alerta
		echo '<div class="alert background-yellow">Generating images. Please wait...</div>';
		
		//Espacios
		echo '<br><br><br><br>';
		
		//Cerramos el contenedor
		echo '</div>';
	}
	
	//Funcion que desactiva la funcion de marcas
	function ExplorerDesactivarMarcas()
	{
		//Activamos el javascript
		echo '<script type="text/javascript">';
		
		//Desactivamos las marcas
		echo 'var explorer_desactivar = true; ';
		
		//Cerramos
		echo '</script>';
	}
	
?>