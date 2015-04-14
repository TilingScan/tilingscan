<?php 
	
	//Funcion que devuelve el color azul
	function ColorAzul($img)
	{
		//Original imagecolorallocate($img, 74, 137, 220);
		return imagecolorallocate($img, 31, 88, 167);
	}
	
	//Funcion que devuelve el color rojo
	function ColorRojo($img)
	{
		//Original imagecolorallocate($img, 233, 87, 63);
		return imagecolorallocate($img, 189, 48, 24);
	}
	
	//Funcion que devuelve el color morado
	function ColorMorado($img)
	{
		return imagecolorallocate($img, 154, 87, 180);
	}
	
	//Funcion que devuelve el color blanco
	function ColorBlanco($img)
	{
		return imagecolorallocate($img, 255, 255, 255);
	}
	
	//Funcion que devuelve el color negro
	function ColorNegro($img)
	{
		return imagecolorallocate($img, 67, 74, 84);
	}
	
	//Funcion que devuelve el color gris
	function ColorGris($img)
	{
		return imagecolorallocate($img, 170, 178, 189);
	}

?>