<?php
	//Funcion que elimina los proyectos antiguos
	function ProyectoEliminar()
	{
		//Vector para eliminar
		$eliminar = array();
		$k = 0;
		
		//Cogemos la fecha actual
		$fecha = ProyectoFechaActual();
		
		//Abrimos la carpeta con los proyectos
		$dh = opendir(_DATA);
		
		//Buscamos en todos los proyectos
		while (($file = readdir($dh)) !== false)
		{
			//Evitamos los de siempre
			if( "." == $file || ".." == $file )
			{
				continue;
			}
		
			//Si hemos encontrado algun proyecto, incluimos el archivo de configuracion
			include _DATA.$file.'/config.php';
			
			//Comprobamos si hemos pasado la fecha de caducidad
			if($fecha > $p_caducidad)
			{
				//Lo sumamos para borrar
				$eliminar[$k] = $file;
				
				//Aumentamos el contador
				$k++;
			}
		}

		//Cerramos el directorio
		closedir($dh);
		
		//Borramos
		for($i = 0; $i < $k; $i++)
		{
			//Eliminamos el directorio
			EliminarDir(_DATA.$eliminar[$i]);
		}
	}
	
	//Funcion que elimina un directorio y todo su contenido
	function EliminarDir($dir)
	{
		//Cogemos todos los archivos que esten contenido en el directorio
		$files = array_diff(scandir($dir), array('.','..'));
		
		//Para cada archivo
		foreach ($files as $file)
		{
			//Eliminamos
			(is_dir($dir.'/'.$file)) ? EliminarDir($dir.'/'.$file) : EliminarArchivo($dir.'/'.$file);
		}
		
		//Finalmente, borramos la carpeta
		return rmdir($dir);
	}
	
	//Funcion que elimina un archivo
	function EliminarArchivo($file)
	{
		//Eliminamos el fichero
		unlink($file);
	}
	
	//Mismas funciones pero en ingles
	function DeleteDir($dir)
	{
		EliminarDir($dir);
	}
	
	function DeleteFile($file)
	{
		EliminarArchivo($file);
	}
?>