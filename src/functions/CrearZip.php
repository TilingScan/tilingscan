<?php
	//Funcion que comprueba si es un zip y lo extrae
	function CrearZip($file, $folder)
	{
		//Cambiamos los permisos
		chmod($file, 0777);
		
		//Creamos el zip
		$zip = new ZipArchive;
		
		//Abrimos el fichero y conprobamos si es un .zip
		if($zip->open($file) === true)
		{
			//Cogemos el nombre del archivo
			$filename = $zip->getNameIndex(0);
			
			//Lo extraemos
			$zip->extractTo($folder);
			
			//Cerramos el zip
			$zip->close();
			
			//Creamos el nuevo archivo
			$file = $folder.$filename;
		}
		
		//Cambiamos los permisos
		chmod($file, 0777);
		
		//Devolvemos el archivo
		return $file;
	}
?>