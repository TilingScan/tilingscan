<?php 
	//Iniciamos la fecha de caducidad estandar
	$p_caducidad = 99991231;
	
	//Funcion que genera la fecha actual
	function ProyectoFecha()
	{
		//Establecemos la zona horaria
		date_default_timezone_set('Europe/Madrid');
		
		//Cogemos la fecha actual
		$dia = intval(date('j'));
		$mes = intval(date('n'));
		$year = intval(date('Y'));
		
		//Devolvemos
		return array($dia, $mes, $year);
	}
	
	//Funcion que devuelve la fecha actual en nuestro formato
	function ProyectoFechaActual()
	{
		//Cogemos la fecha actual
		$f = ProyectoFecha();
	
		//Generamos la fecha de caducidad en nuestro formato
		$fecha = $f[2]*10000 + $f[1]*100 + $f[0];
	
		//Devolvemos
		return $fecha;
	}
	
	//Funcion que general la fecha de caducidad
	function ProyectoFechaCaducidad()
	{
		//Cogemos la fecha actual
		$f = ProyectoFecha();
		
		//Generamos el mes de caducidad
		$f[1] = $f[1] + 2;
		
		//Comprobamos que no nos pasemos del 12
		if($f[1] > 12)
		{
			//Reseteamos los meses
			$f[1] = $f[1] - 12;
			
			//Sumamos uno al year
			$f[2] = $f[2] + 1;
		}
		
		//Generamos la fecha de caducidad en nuestro formato
		$fecha = $f[2]*10000 + $f[1]*100 + $f[0];
		
		//Devolvemos
		return $fecha;
	}
	
	//Funcion que devuelve el dia actual en formato correcto
	function ProyectoFechaFormato($fecha)
	{
		//Separamos
		$dia = $fecha%100; $fecha = $fecha/100;
		$mes = $fecha%100; $fecha = $fecha/100;
		$year = $fecha%10000;
		
		//Cogemos el mes
		$mes = date('F', mktime(0, 0, 0, $mes, 10));
		
		//Devolvemos la fecha en formato estandar
		return $mes.' '.$dia.', '.$year;
	}
	
?>