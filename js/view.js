//Funcion para descargar un zip con todas las imagenes
function DownloadAllImg()
{
	//Creamos el nuevo ZIP
	var zip = new JSZip();
	
	//Recorremos todas las imagenes
	for(var i = 0; i < num_img; i++)
	{
		//Cogemos la imagen
		DownloadSelectImg(zip, i);
	}
	
	//Generamos el zip
	var content = zip.generate({type:"blob"});
	
	//Lo descargamos
	saveAs(content, nombre + '.zip');
}

//Funcion para descargar un zip con la imagen seleccionada
function DownloadThisImg()
{	
	//Creamos el nuevo ZIP
	var zip = new JSZip();
	
	//Cogemos la imagen
	DownloadSelectImg(zip, explorer_num);
	
	//Generamos el zip
	var content = zip.generate({type:"blob"});
	
	//Generamos el numero
	var n = explorer_num + 1;
	
	//Descargamos
	saveAs(content, nombre + '_' + n + '.zip');
}

//Funcion que selecciona una imagen y la suma al contenedor
function DownloadSelectImg(zip, num)
{
	//Cogemos la imagen
	var img = document.getElementById('image_' + num).src;
	
	//Cogemos la base
	var img_base = img.substring(22);
	
	//Cogemos el numero original
	var img_n = num + 1;
	
	//Generamos el nombre
	var img_nom = nombre + '_' + img_n + '.png';
	
	//Lo sumamos al zip
	zip.file(img_nom, img_base, {base64: true});	
}

//Funcion que descarga el txt
function DownloadTxt()
{
	//Creamos el nuevo ZIP
	var zip = new JSZip();
	
	//Cogemos el contenido
	var txt = document.getElementById('window_txt').innerHTML;
	
	//Lo sumamos al zip
	zip.file(nombre + '.txt', txt);
	
	//Generamos el zip
	var content = zip.generate({type:'blob'});
	
	//Descargamos
	saveAs(content, nombre + '_txt.zip');
}

//Funcion que coge la opcion del select y cambia la imagen
function ViewChangeSection(id)
{
	//Cogemos la seccion que ha escogido
	var section = id.options[id.selectedIndex].value;
	
	//Cambiamos la imagen
	ExplorerImg(parseInt(section));
}