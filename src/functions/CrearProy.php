<?php
	//Funcion que crea el ID del proyecto
	function CrearProyID()
	{
		//Definimos la franja horaria
		date_default_timezone_set('Europe/Madrid');
		
		//Creamos el id del proyecto
		$p_id = md5(''.time().''.rand(0, 99999));
		$p_id = substr($p_id, 0, 10);
		
		//Comprobamos que no exista ya un proyecto con ese ID
		$prueba = $p_id;
		$cont = 0;
		while(file_exists(_DATA.$prueba.'/config.php'))
		{
			//Si existe, cambiamos el nombre
			$cont++;
			$prueba = $p_id.$cont;
		}
		
		//Comprobamos si hemos tenido que modificar el ID
		if($cont > 0)
		{
			//Guardamos el nuevo ID del proyecto
			$p_id = $p_id.$cont;
		}
		
		//Devolvemos el ID
		return $p_id;
	}
	
	//Funcion que crea la carpeta del proyecto
	function CrearProyDir($p_id)
	{
		//Creamos la carpeta
		$p_folder = _DATA.$p_id;
		
		//Creamos la carpeta
		mkdir($p_folder, 0777);
		
		//Modificamos la ruta
		$p_folder = $p_folder.'/';
		
		//Cambiamos los permisos
		chmod($p_folder, 0777);
		
		//Creamos la carpeta temporal
		mkdir($p_folder._TEMP, 0777);
		
		//Cambiamos los permisos de la carpeta temporal
		chmod($p_folder._TEMP, 0777);
	}
	
	//Funcion que guarda el fichero de configuracion
	function CrearProyConfig($p_id, $p_autor, $p_descripcion, $p_title, $p_organismo, $p_strand)
	{		
		//Creamos la carpeta
		$p_folder = _DATA.$p_id.'/';
		
		//Cogemos la fecha de creacion
		$p_date = ProyectoFechaActual();
		
		//Cogemos la fecha de caducidad
		$p_caducidad = ProyectoFechaCaducidad();
		
		//Reemplazamos los ' dentro de la descripcion
		$p_descripcion = str_replace('\'', '"', $p_descripcion);
		
		//Abrimos el fichero
		$entrada = fopen($p_folder.'config.php', 'w');
		
		//Primera linea
		fwrite($entrada, '<'.'?php ');
		
		//Guardamos la fecha de creacion
		fwrite($entrada, '$'.'p_date = '.$p_date.'; ');
		
		//Guardamos la fecha de caducidad
		fwrite($entrada, '$'.'p_caducidad = '.$p_caducidad.'; ');
		
		//Guardamos el email
		fwrite($entrada, '$'.'p_autor = "'.$p_autor.'"; ');
		
		//Guardamos el titulo
		fwrite($entrada, '$'.'p_title = "'.$p_title.'"; ');
		
		//Guardamos la descripcion
		fwrite($entrada, '$'.'p_descripcion = "'.$p_descripcion.'"; ');
		
		//Guardamos el organismo
		//fwrite($entrada, '$'.'p_organismo = "'.$p_organismo.'"; ');
		
		//Guardamos la strand
		fwrite($entrada, '$'.'p_strand = '.$p_strand.'; ');
		
		//Ultima linea
		fwrite($entrada, '?'.'>');
		
		//Cerramos el fichero
		fclose($entrada);
		
		//Cambiamos los permisos
		chmod($p_folder.'config.php', 0777);
		
		//Devolvemos el ID
		return $p_id;
	}
?>