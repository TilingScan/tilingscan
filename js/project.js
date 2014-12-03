//Gen actual
var select_actual = '';

//Funcion que muestra el select para el gen
function ProjectCambiarSelectGEN(id)
{
	//Cogemos el que ha seleccionado
	var selectedOption = id.options[id.selectedIndex];
    var g = selectedOption.value;
	
	//Ocultamos el que ya estaba
	document.getElementById('gen_' + select_actual).style.display = 'none';
	
	//Activamos el nuevo
	document.getElementById('gen_' + g).style.display = 'block';
	
	//Cogemos el actual
	select_actual = g;
}

//Funcion que inicia el cromosoma actual
function ProjectIniciarSelectGEN()
{
	//Cogemos el ID
	var id = document.getElementById('chr2');
	
	//Comprobamos si existe
	if(id === null)
	{
		//Si no existe, no hacemos nada
	}
	else
	{
		//Cogemos el que esta seleccionado
		ProjectCambiarSelectGEN(id);
	}
}

//Time Out
setTimeout(function(){ ProjectIniciarSelectGEN(); }, 600);

//Variable para saber cual esta activada
var appproject_ahora = '';

//Funcion que muestra el ancla
function AppProjectMostrar(id)
{
	//Variable del div
	var div;
	
	//Si hay alguno activado, lo ocultamos
	if(appproject_ahora != '')
	{
		//Cogemos el ID
		div = document.getElementById('Project_' + appproject_ahora);
		
		//Comprobamos si existe
		if(div === null)
		{
			//Si no existe nada
		}
		else
		{
			//Si existe, lo ocultamos
			div.style.display = 'none';
		}
	}
	
	//Mostramos el nuevo
	div = document.getElementById('Project_' + id);
	
	//Comprobamos si existe
	if(div === null)
	{
		//Si no existe nada
	}
	else if(appproject_ahora != id)
	{
		//Si existe, lo mostramos
		div.style.display = 'block';
		
		//Guardamos el que esta ahora
		appproject_ahora = id;
	}
	else
	{
		//Borramos el que esta ahora
		appproject_ahora = '';
	}
}