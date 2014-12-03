var abierto = '0';

function AbrirCerrar(id)
{
	//Cogemos el div
	var div = document.getElementById(id);
	
	//Lo cerramos
	div.style.display = (div.style.display == 'block') ? 'none':'block';
}

function AbrirCerrar2(id)
{
	//Cogemos el div
	var div = document.getElementById(id);
	
	//Lo cerramos
	div.style.display = 'none';
	
	//Comprobamos si lo estamos abriendo o cerrando
	if(abierto == id)
	{
		//Ya no hay ninguno abierto
		abierto = '0';
	}
	else
	{
		//Lo que queremos es abrirlo
		div.style.display = 'block';
		
		//Cerramos el anterior si existe
		if(abierto != '0')
		{
			document.getElementById(abierto).style.display = 'none';
		}
		
		//Guardamos
		abierto = id;
	}
}

//Evitar seleccionar
//document.onselectstart = function(){ return false; };


