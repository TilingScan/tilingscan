
//Funcion que muestra o no el fichero reverse
function NewCambiarStrand(id)
{
	//Cogemos el que ha seleccionado
	var selectedOption = id.options[id.selectedIndex];
	
	//Cogemos el valor
    var val = selectedOption.value;
    
    //Cogemos el div
    var div = document.getElementById('reverse_box');
    
    //Comprobamos si es true o false
    if(val == "true")
    {
    	//Mostramos el div
    	div.style.display = 'block';
    }
    else
    {
    	//Ocultamos el div
    	div.style.display = 'none';
    }
}

