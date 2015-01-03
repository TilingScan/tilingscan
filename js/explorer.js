//Variables para la imagen del fondo
var explorer_img = null;
var explorer_pos = 0;
var explorer_num = 0;
var explorer_can = null;
var explorer_vel = 70;
var explorer_evt = null;
var explorer_dib = false;

//Flechas
var explorer_flecha1 = null;
var explorer_flecha1_sel = null;
var explorer_activo1 = 0;
var explorer_flecha2 = null;
var explorer_flecha2_sel = null;
var explorer_activo2 = 0;

//Flechas de abajo
var explorer_flecha3 = '#1bbc9b';
var explorer_flecha4 = '#1bbc9b';
var explorer_espacio = '#e77e23';
var explorer_activo3 = 0;
var explorer_activo4 = 0;

//Lupa
var explorer_lupa = null;
var explorer_lupa_tam = 100;

//Para saber si se esta moviendo
var explorer_moviendo = false;
var explorer_moviendo_dir = 0;
var explorer_moviendo_int;

//Para mostrar la marca
var explorer_marca = false;

//Para calcular la distancia
var explorer_marca1_pos = null;
var explorer_marca1_inc = null;
var explorer_marca1_var = null;

var explorer_marca2_pos = null;
var explorer_marca2_inc = null;
var explorer_marca2_var = null;

//Para saber que gen esta activo
var explorer_gen_activo = -1;

//Para desactivar las marcas
var explorer_desactivar = false;

//Funcion que inicia el explorador
function ExplorerIniciar()
{
	//Iniciamos el canvas
	explorer_can = new jmCanvas('canvas', 930, 700);

	//Starting the canvas
	explorer_can.Start();
	
	//Iniciamos los elementos alternativos
	ExplorerCargarImgs();
	
	//Iniciamos la primera imagen
	ExplorerImg(0);
	
	//Evento on click
	document.getElementById('canvas').addEventListener('click', ExplorerClick, false);
	
	//Evento poner raton encima
	document.getElementById('canvas').addEventListener('mousemove', ExplorerStartOver, false);
	document.getElementById('canvas').addEventListener('mouseout', ExplorerEndOver, false);
	
	//Ocultamos el aviso
	var alert = document.getElementById('explorer_alert');
	
	//Comprobamos si existe
	if(alert === null)
	{
		//Nada
	}
	else
	{
		//Lo ocultamos
		alert.style.display = 'none';
	}
}

function ExplorerCargarImgs()
{
	//Iniciamos la flecha 1
	explorer_flecha1 = new Image();
	explorer_flecha1.src = 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAADICAYAAAD/V1GQAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gYWEBkPCUs95QAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAE/0lEQVR42u3aX0hbVxgA8HOTk2Qmx1gzmKvatasOhne6IirOZaB2E/Wp22KMMQ8ON8q20s1hhUyDG6OpSB6cSwcaCwWrxj91Y8J8sNA0tU4yRmH+h2J1upGmQxe995pe7zV7meCamEQZlI7ve7vhO98v371fck4glN1ufwE9gZCgJxQAAwwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMAAAwzw/xzGsSb29PScnJ+fL2cYplAUxWeDwWAiQghRFLUulUr/JITcomn6R4PBsBhLPSra/zK7urro2dlZM8/zBTKZ7C4h5KZKpbqvVqu9CCHk9/uPchz3IsMwRdvb26fkcvkdmqYv1dbWzh4KXltbw62trU0Mw1QTQvoKCwvtpaWlvkjFRkdHk1wu1zmWZQ2EkO6GhgarRqMRYoY9Ho/a6XR+K4piSl5eXm11dfXiQZ7ftWvX0j0ejwNjvGo0Gj/KycnZjDpcPp8P9/X1dQaDQXlVVdWZg6IIIWQyme4ZDIa3g8FgXG9vb4fP58NRYZvN9pUoikmVlZUf5Ofn+w87tQUFBX9VVFS8LwhCis1m+yIi3NHRcYrjuIq8vLyY0LW1NcxxnCQSnp2dfZbjuCqHw5G5L7ywsHCBENJrMpnuRUN9Ph+2Wq2Xm5ubbRsbG9L98mpqauaVSqVzbm7uQljY6XSe5Hn+teLi4m9iQVtbWy8HAoHSra2td9va2ioj5RcVFbXzPP/GwMDAiRB4ZmamXCaT/VxSUvIwUpGlpSVFS0vLlUAgUIoQQkqlsttsNvdFWlNWVvZAJpP9MjU1VRYCsyxbQAhxR+vUbre38zxfiBBCcXFx3zU1NTXLZLJgtLukVCpvsSz7eggsCEKySqW6f5BOrVZrnVqtFmOZckLIkiiKKSHwzs7Oc/Hx8b790Pb29s7dTpVKZffFixctsXS6G2q12ruzs5MUdqopigpbyOv1PrN3kUKhWD0IGnFblEgkD/x+/9FwSfn5+X6TyVSBMb6LEELr6+vmxsbGTw4CbWxsPC+RSLwhMMbYy3Hc8f0W5uTkbOp0uvcwxrP/7EqfWSyWs7HCDMOckEqlf4TAKpXq5ubm5luRFmu12nWTyaTf0/nnjY2Nn8YCsyxbEh8f7wqBaZq+IQjCqyMjI8mRCoTpvC5a58PDw6mCILxC0/SNENhgMCzK5fI7t2/fPhft3Wu12nWdTmfEGM8ghFAgEKC3t7ep/fInJyfPy+Vyt16vXwo71RkZGZc4jtN3d3e/FAuu1+uNCQkJX1sslrr9pvzq1asvcxz3TlZWVsve16Xl5eUJuxfZ2dkP3W73keXl5fOJiYnfp6amPoqEHzt2LHD69OmfFApFWHRiYuLI2NhYDyHken19/XDE/bihocGKMf69v7+/a3x8PPGwn1O3260ZHBy8gjFeNpvNLVEPAhqNRjAajR9SFPVoYGBg5PF9NJbo7OzMGhoaGqEoijMajR+H+1r9163ejeTkZD43N/cHj8eTurKycsnlciWLovhreno6G+2w53A4mldXV79UqVTXzWZzfVpaWuDpON4+HoODg8enp6ffZBhGKwjCcVEUUxFCSCqVrmCMlwkh45mZmTd0Ot1v/8mBHn60AQwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMAAAwwwwE8X/DevXiXhi4GpCAAAAABJRU5ErkJggg==';
	
	explorer_flecha1_sel = new Image();
	explorer_flecha1_sel.src = 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAADICAYAAAD/V1GQAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gcLDzEMRXaASgAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAENUlEQVR42u3bS0xcVRjA8f9lgBlmBoaBGd6P0vIUqsCMYrRpKxVcmZSYaqMxxqWJUSPqrokmamJqYzfduNBNw8bGZ+MDSiQxomCHh1I6QhPKDFhmhtfAPICB4qLaCPPggk2aNN+3Puf87nfznfOdxb3Kx89c3OQuRBJ3KQQWWGCBBRZYYIEFFlhggQUWWGCBBRZYYIEFFlhggQUWWGCBBRZYYIEFFlhggQUWWOB7HE5WO9CUb6CsKY/i+hx0Gano0lMBWFleI+xfY2rYy0TfDP4bwTsDZ+/L4KFnqymos+AdX8A96MU/EyI4vwKAMUtHRr6BkoYcbE9X8dcfs/R3OJmbXEq4rhLvg1AlSeHh52uoebwEZ7ebwS+vEV5cTbiY3qyl/ng51c3FjHa56Dt/lc2bm+rhVH0yx15rxGhJo/P0ZdWv79/ILDTS0m4j4Atz6ewAkfD6zsWlaBRa2m1oUpL46lTvrlGAxekAX5/qJVmroeV1G4pG2Rl+9MU69GYdnR86WAtG9ly1q8EInacvY7Sm8cgLtYlh6wETlUeL6DqjDlWSFFAS411nHFQ3F2MpM8WHHzxZjfOSi8XpwM6oRuHYqw0ceekBlAT4gnsZ549u7CerYsOmfAP5tdkMfnFNHfpKA2VN+VQeLqKquSTh+MHPxyk6aCEjVx8NlzXl4XHOE/Yn3jKalCSeeNNOWVM+AKOdkzi7XQnnhBZW8Ywt3J6zBS6oteAe9u2Y6WMv11NcnwPA+E9T9H46oqrYpoZ9FNRlR8NGSxpLM8FdZdpzbphNld+j+2eCGC1p0bDerCW0sBoXbWm33c50tHOSnz8Z2dX2Cs6voDfrYld1vIfXpGq2TFr2he5cWwzOr2DM0sUctBaM8M3bv+AdXwCg6bkaGp6q2BVkyNIR+qexRMHp/yn37REJr/P9B78xe90PgP1EJfc/uV81bMozEJgLR8PuIR/77LmJj8FAhIvv/Lol80aVmZfac3EP+aJhl8OD9UAmhmxdwgW2Z25TkbnRmoalzITL4YmG/TeCTI/M0tBWvnMDCET49t0+Zidu4dmlGQnHN7SVM/W7jyVPKHZV93c4qTxaTGahUTU+cGGMnnNDcceZi9OpOFxEf4czfpOYu77EaOckLe02Ug0pqlqf48J43ENEa0ihpd3Gle8mmHctJ+7HfeevEpgN0/qGHa0xZc/7VJueQutbdpY8oahsY8KbNze59NEAG5ENjr9/KKqPqgnLfhNt7x1ifWWD7rMDMd/Ijpe9+1pL+bNnCsdnY6oue7YTlVQeKeLKD5O7v+zt6Xpbb8VaYf7/19vtkZ6rp7Qxh8KDFjJyDRittzrNsjfEkifE9MgsLoeXZa+6c1yRH60EFlhggQUWWGCBBRZYYIEFFlhggQUWWGCBBRZYYIEFFlhggQUWWGCBBRZYYIEFFljgewv+G2pYla7HOtLFAAAAAElFTkSuQmCC';
	
	//Iniciamos la flecha 2
	explorer_flecha2 = new Image();
	explorer_flecha2.src = 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAADICAYAAAD/V1GQAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gYWEBkDAP1xzgAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAE8ElEQVR42u3abUgbdxgA8P8ld8nMXRIqo+2stp0iSGKdEw3OOqbtJtVPezExxhQ6UMq2stVCA6kGB51RJB86lw2MEwpijDG4DmEoFJqp28R1bEwyJxTrWzebbbrEuzM777x9qeBMTKIUSsfzfMvl7vndc/d/eQLBnE7ncfQEQoKeUAAMMMAAAwwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMAAAwwwwAADDDDAAAMMMMD/cxhP9kSPx5MZCASqaJp+RRCEZ0VRPIQQQhiGrUml0r8oivLn5OR8VVdXN5dMPizR/zJ7eno0gUDAynHcaYIgfqIo6o5CobivVqt/RwihcDh8lGGY52maLt/c3HxRJpN9q9Fo2urr6wMHgldXV/GOjo5rNE2fJ0nSU1ZW5qysrHwYL9nIyMhhv99/iabpWoqi+iwWy0epqal80vDdu3eVbrf7M57n03U6XYPZbL63n/fX19eXOTU11SOVSh8YjcZ3dTpdOOHgCgaDuNvt7hJFMcVoNL6xXxQhhOrq6uZqa2tfF0VR1t/f7woGg3hC2OFwfMjz/DG9Xl9fUlLy90FHbXFxcaimpqZBEIQjDofjely4u7v7FMuytQUFBRfjoSzLSlZXV/FkcJ1O18CyrL6rqyt/T3hmZuaqQqHwXLhw4de9koXDYWlLS4vDbrd/GusR7g6z2XyPoij37Ozs1Ziw1+s9yXHcy+Xl5Z3xEt24caNmY2PjrUgkcq6joyMp/MyZM59wHPeSx+PJjIKnp6crCYL4IdGUsVqt/QqFohchhCKRyLn29vae+fl5ebxrKioq/iAI4vtAIFAVBTMMc1qhUHyd6O4JghCbm5tbUlJSvkAIIY7jypxOZ2eiyimKGmMYpiQKFgThGEVR88mMWJVKJdjt9sb9VE6S5H2e59Oi4K2trSMqlWol2elCEITY2tpq28Y5jivr7Ox07YUrlcrg1tbW4ceyOxEEIcrl8uWdN7+ysvJMzCUSw8SYu5NEIlkJh8NH9wM3NTV9EAqFriCEEI7jP5rN5vOFhYXrsc4NhULPSSSSh1EVS6XS32iaPpksarPZLu5Af6murn57L/TRonMCx/GVKFipVPoZhqlIstLLa2tr13ZUaigtLV2Ld836+vprJEneiYK1Wu1tnudzh4aG0pOotDHZShFCaHh4OI3n+Re0Wu3tKNhgMMzLZLKxycnJ9/dKsLm5iUUiEe0jNFBdXW1KVClCCI2Pj1+SyWTfGI3GuZijOi8vr51l2Tdv3ryZs9cottlsjWq1+mODwZAU2tvbm82yrEGj0bTtPC6tqqpSb3/Iz8//c3x8XLm4uHhZrVbfysjIiOxOJJfLxbNnz34X67vdMTk5qR4dHe0jSfJLi8Xii7sfW63WdhzHFwYHB3vGxsZSDzrHJyYmDg0MDHyO4/gDi8ViT9gIqFQqwWQyvYdhGOvz+YZdLlfeftHu7u5TXq93GMOwf0wm0zux+q7/POrtSEtL44qKioanpqbSlpaW2vx+fzrP8z9nZ2cziZo9l8tlW15evk6S5C2r1XolKysr8nS0t7vD5/Mdn56efpWm6VKe508IgpDxaMVbxnF8gaKoidzc3Nt6vX7hsTT08KMNYIABBhhggAEGGGCAAQYYYIABBhhggAEGGGCAAQYYYIABBhhggAEGGGCAAQYYYIABfrrgfwEa0CXhlKOrYAAAAABJRU5ErkJggg==';
	
	explorer_flecha2_sel = new Image();
	explorer_flecha2_sel.src = 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAB4AAADICAYAAAD/V1GQAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3gcLDzEYX6xUNwAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAER0lEQVR42u3bW0ybZRjA8X8pBXqAcijlMMrsxmkD3FirGDfnHIJXS0YWdZkao4kXJkaNOO+WaKJLjBJ3My+80AsNV4unLNNwUBKVDLQMFEczUEYLg9IO1tKWQ4F6gSGy0hMuWbI87+WXr+/ve97veZ/3ufiq+OTpi2HuwkjhLg2BBRZYYIEFFlhggQUWWGCBBRZYYIEFFlhggQUWWGCBBRZYYIEFFlhggQUWWGCBBRb4HodTE71RX6TFXF9IyT4jan0aGZlpACzOL7PoW8Y5MMNY7zTeqcCdgfN2ZvHgqSqKaw24R+ZwDLjxTQXwzy4CoM3NQF+owVRnxPJUJTeGPPS12bl53RdzXkW0D0IVKQrqn93D3sZS7D84Gfh6lODcUszJ1Nnp1B0vo6rBxHCng8ufDxNeCycOq9SpPP76AXT5ajpabdya9Cf1/vRFWppOW/F7Fug6189ycCV+cimUChrfsJCaruTbMz1JowDeqQDfnOlBqUqhscWCQqmIDz/8fDW6fDXtH/zGUiC07axdDoRo/9CGJieDgy/UxIYNZj1VR010tNpio4r1HEgE72i1UXGkhPzd+uiw9WQl9h+dzDnno5sKePTlfTS8VrflEt4+bk36sXc6eOBk1dZwVoGGkloDV74ciTlR5dFSKg6XYK4vouHVxPArX41SVJ2HvkgbCZvri3Bdm4u7ZexdDq62j2/85onTVpSq2AVwwbuEyz6Lub4wEi6uyWNi0J1Q4vR8NsTITxMAmPYbeeyV/XEjdw66Ka42RMI6gxrvdGLlLhyG7vODSUXumw6gM6gjYU1OBoF/y2Ci45dPhzZw034jjS2WqHhwbglNTvqdO53m3UH++/DKNOXWqxTtkAjOLqLNzUgKrTtRjvXJCgBmRua4dLaP0MLKlvfqcjev6EbE/psL6Au1CaP3H9u1gXque/n+/V+jogCZBZqtYeeAm53WgoTQAyfKqX9mz0akF9+5zJI/dnm9z1qAc8AdCTtsLgxmPbp8ddxILUlECqDNyyB/dzYOmysS9rmCTPzupq65LG5jAOAZ83Lp3d64kQLUNZcxOeTZ1J1syuq+Njvlh0vIMWVGnaT7/AD9F64ljGbv0FFxxERfmz36ITHrmOfP78ZobLGQrlVFLR62CyMJHZlpWhWNLRauto9HtEIR+7ivzY7PFaTpLSvpmapt7+90nYqmN9e7kN4vhuM3AuEwdJ3rZ2Vxleb3DmHYpU8aNZj1HD97iNXQKp0f9W/ZdymP1Zx6+/aLaytr/NVzA51BzSMv1aIzqPH87SW0uBq32Xvoub0cfLGa0Z8n6f54kNXQWnJd5nbaW2N5zv9vbyMqj1FDqcXIjhoDWQUaMo2a9YrnXsDnCjD5h4fx/hnmXcGEXodC/mglsMACCyywwAILLLDAAgsssMACCyywwAILLLDAAgsssMACCyywwAILLLDAAgsssMAC31vwP1gUl/jxUIMBAAAAAElFTkSuQmCC';
	
	//Iniciamos la lupa
	explorer_lupa = new Image();
	explorer_lupa.src = 'data:image/png;base64, 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';
	
}

function ExplorerImg(num)
{
	//Activamos las imagenes de las flechas
	explorer_activo3 = 1;
	explorer_activo4 = 1;
	
	//Comprobamos que no nos salgamos
	if(num <= 0)
	{
		//Eviamos que valga negativo
		num = 0;
		
		//Bloqueamos el boton de imagen anterior
		explorer_activo3 = 0.4;
	}
	
	if(num + 1 >= num_img)
	{
		//Evitamos salirnos
		num = num_img - 1;
		
		//Bloqueamos el boton de imagen siguiente
		explorer_activo4 = 0.4;
	}
	
	//Cargamos la imagen *num*
	explorer_img = new Image();
	
	//Cogemos el src de la imagen
	explorer_img.src = document.getElementById('image_' + num).src;
	
	//Activamos que se inicie el explorador cuando se haya cargado
	explorer_img.onload = function(){ ExplorerDibujar(); };
	
	//Reseteamos las variables
	explorer_pos = 0;
	explorer_num = num;
	explorer_gen_activo = -1;
	
	//Desactivamos que se pueda mover
	explorer_moviendo = false;
	explorer_activo1 = 0;
	explorer_activo2 = 0;
	
	//Activamos para dibujar
	explorer_dib = true;
	
	//Reiniciamos las marcas
	ExplorerMarcaReiniciar();
}

function ExplorerDibujar()
{
	//Borramos todo
	explorer_can.DeleteAll();
	
	//Pintamos de blanco
	explorer_can.Rectangle('#ffffff', 0, 0, explorer_can.width, explorer_can.height, 1);
	
	//Situamos la imagen de fondo
	explorer_can.Image(explorer_img, explorer_pos, 0, 1);
	
	//Situamos las flechas
	explorer_can.Image(explorer_flecha1,   0, 100, 0.3);
	explorer_can.Image(explorer_flecha2, 900, 100, 0.3);
	
	//Si se esta moviendo
	explorer_can.Image(explorer_flecha1_sel,   0, 100, explorer_activo1);
	explorer_can.Image(explorer_flecha2_sel, 900, 100, explorer_activo2);
	
	//Flechas de abajo
	explorer_can.Rectangle(explorer_espacio, 360, 650, 210, 50, 1);
	explorer_can.Rectangle(explorer_flecha3,   0, 650, 360, 50, explorer_activo3);
	explorer_can.Rectangle(explorer_flecha4, 570, 650, 360, 50, explorer_activo4);
	
	//Ponemos el contador de secciones
	var num_ahora = explorer_num + 1;
	explorer_can.Text('Section ' + num_ahora + ' / ' + num_img, 'OpenSans', '#ffffff', 14, 'center', 465, 655);
	ExplorerSituarInterval(explorer_num, 465);
	
	//Seccion anterior
	if(explorer_activo3 == 1)
	{
		explorer_can.Text('Prev section', 'OpenSans', '#ffffff', 14, 'center', 180, 655);
		ExplorerSituarInterval(explorer_num - 1, 180);
	}
	
	//Seccion siguiente
	if(explorer_activo4 == 1)
	{
		explorer_can.Text('Next section', 'OpenSans', '#ffffff', 14, 'center', 750, 655);
		ExplorerSituarInterval(explorer_num + 1, 750);
	}
	
	
	var p1, p2, dist;
	
	//Situamos las marcas
	if(explorer_marca1_pos != null)
	{
		//Calculamos la posicion
		p1 = explorer_pos - explorer_marca1_inc + explorer_marca1_pos;
		
		//Ponemos la marca
		ExplorerMarcaPoner('#e77e23', p1, explorer_marca1_val);
	}
	
	if(explorer_marca2_pos != null)
	{
		//Calculamos la posicion
		p2 = explorer_pos - explorer_marca2_inc + explorer_marca2_pos;
		
		//Ponemos la marca
		ExplorerMarcaPoner('#e77e23', p2, explorer_marca2_val);
		
		//Si la segunda esta activa, mostramos la distancia entre ambas
		dist = explorer_marca2_val - explorer_marca1_val;
		
		//Ponemos el cuadro arriba
		explorer_can.Rectangle('#e77e23', p1, 281, p2 - p1, 19, 1);
		explorer_can.Rectangle('#e77e23', p1 - 35, 281, 70, 19, 1);
		explorer_can.Rectangle('#e77e23', p2 - 35, 281, 70, 19, 1);
		
		//Destacamos la region
		explorer_can.Rectangle('#e77e23', p1, 100, p2 - p1, 200, 0.3);
		
		//Ponemos la lupa
		explorer_can.Image(explorer_lupa, p1 + (p2 - p1)/2 - explorer_lupa_tam/2, 150, 0.9);
		
		//Situamos la posicion
		explorer_can.Text(Math.abs(dist), 'OpenSans', '#ffffff', 14, 'center', p1 + (p2 - p1)/2, 281);
	}
	
	//Reseteamos el estlo del cursor
	document.body.style.cursor = 'auto';
	
	//Situamos el gen que esta activo
	if(explorer_gen_activo != -1)
	{
		//Ponemos el cursor con la mano
		document.body.style.cursor = 'pointer';
		
		//Cogemos los valores del gen
		var px = explorer_genes_px[explorer_num][explorer_gen_activo];
		var py = explorer_genes_py[explorer_num][explorer_gen_activo];
		var an = Math.max(explorer_genes_an[explorer_num][explorer_gen_activo], 130);
		
		//Dibujamos
		explorer_can.Rectangle('#f2c311', explorer_pos + px, py, an, 40, 0.1);
	}
	
}

function ExplorerSituarInterval(n, px)
{
	//Cogemos los valores
	var valor_ini = explorer_arr[n][0];
	var valor_fin = explorer_arr[n][explorer_arr[n].length - 1];
	
	//Situamos el valor
	explorer_can.Text('[' + valor_ini + ', ' + valor_fin + ']', 'OpenSans', '#ffffff', 14, 'center', px, 672);
}

function ExplorerClick(e) 
{
	//Obtenemos la posicion real
	var parentPosition = ExplorerGetPosition(e.currentTarget);
	
	//Calculamos donde ha pulsado
    var x = e.clientX - parentPosition.x;
    var y = e.clientY - parentPosition.y;
    
    //Comporbamos si ha pulsado en las flechas de abajo
    if(x <= 400 && 650 <= y && y <= 700)
    {
    	//Imagen anterior
    	ExplorerImg(explorer_num - 1);
    }
    else if(550 <= x && 650 <= y && y <= 700)
    {
    	//Imagen siguiente
    	ExplorerImg(explorer_num + 1);
    }
    //Comprobamos si ha pulsado en la zona de la grafica
    else if(30 <= x && x <= 900 && 100 <= y && y <= 300 && explorer_desactivar == false)
    {
		//Cogemos el valor
		var val = ExplorerObtenerVal(x);
		
		//Comprobamos que marca esta activa
		if(explorer_marca1_pos == null && typeof val != 'undefined')
		{
			//Si la marca 1 esta desactivada
			explorer_marca1_pos = x;
			explorer_marca1_inc = explorer_pos;
			explorer_marca1_val = ExplorerObtenerVal(x);
		}
		else if(explorer_marca2_pos == null && typeof val != 'undefined')
		{
			//Si la marca 2 esta desactivada
			explorer_marca2_pos = x;
			explorer_marca2_inc = explorer_pos;
			explorer_marca2_val = ExplorerObtenerVal(x);
			
			//Evitamos que se muestre la marca verde
			explorer_marca = false;
		}
		else
		{
			//Si ambas estan activas, comprobamos si ha pulsado en la zona delimitada
			if(ExplorerComprobarPulsadoZoom(x))
			{
				//Abrimos la nueva ventana con la region
				ExplorerAbrirPopUp();
			}
			else
			{
				//Si no, borramos las marcas
				ExplorerMarcaReiniciar();
			}
		}
    }
    //Comprobamos si ha pulsado en la zona de los genes
    else if(30 <= x && x <= 900 && 320 <= y && y <= 640)
    {
    	//Comprobamos si ha pulsado en algun gen
    	ExplorerClickGen(x,y);
    }
}

function ExplorerClickGen(x,y)
{
	//Buscamos el gen sobre el que ha pulsado
	var gen = ExplorerBuscarGen(x,y);
	
	//Comprobamos si no esta vacio
	if(gen != -1)
	{
		//Creamos la URL
		var URL = 'http://www.candidagenome.org/cgi-bin/locus.pl?locus=';
		URL = URL + explorer_genes_id[explorer_num][gen];
		//URL = URL + '&organism=' + proyecto_organismo;
		
		//Creamos la ventana
		var win = window.open(URL, '_blank');ç
		
		//Abrimos
		win.focus();
	}
}

function ExplorerBuscarGen(x,y)
{
	//Variable que vamos a devolver
	var gen = -1;
	
	//Obtenemos donde ha pulsado en verdad
	x = ExplorerObtenerPos(x);
	
	//Variables auxiliares
	var px, py, an;
	
	//Contamos cuantos genes tenemos
	num_genes = explorer_genes_id[explorer_num].length;
	
	//Buscamos si hemos pulsado en alguno
	for(var i = 0; i < num_genes; i++)
	{
		//Cogemos las variables
		px = explorer_genes_px[explorer_num][i] - 30;
		py = explorer_genes_py[explorer_num][i];
		an = Math.max(explorer_genes_an[explorer_num][i], 130);
		
		//Comprobamos si ha pulsado en ese
		if(px <= x && x <= px + an && py <= y && y <= py + 40)
		{
			//Si es este gen, lo guardamos
			gen = i;
			
			//Finalizamos el bucle
			break;
		}
	}
	
	//Devolvemos
	return gen;
}

function ExplorerAbrirPopUp()
{
	//Obtenemos las posiciones
	var p1 = ExplorerObtenerPos(explorer_marca1_pos);
	var p2 = ExplorerObtenerPos(explorer_marca2_pos);
	
	//Obtenemos las posiciones de inicio reales
	var ini = explorer_inicio[explorer_num] + Math.floor(Math.min(p1, p2)/zoom);
	var fin = explorer_inicio[explorer_num] + Math.floor(Math.max(p1, p2)/zoom);
	
	//Creamos al URL
	var URL = './view-region?id=' + proyecto_id + '&chr=' + proyecto_chr + '&ini=' + ini + '&fin=' + fin + '&gauss=' + proyecto_gauss;
	
	//Abrimos la regon
	var win = window.open(URL, '_blank');
	win.focus();
}

function ExplorerComprobarPulsadoZoom(x)
{
	//Lo que devolvemos
	var pulsado = false;
	
	//Calculamos las posiciones
	var p1 = explorer_pos - explorer_marca1_inc + explorer_marca1_pos;
	var p2 = explorer_pos - explorer_marca2_inc + explorer_marca2_pos;
	
	//Cogemos la inicial y la final
	var ini = Math.min(p1, p2);
	var fin = Math.max(p1, p2);
	
	//Comprobamos si ha pulsado dentro
	if(ini <= x && x <= fin)
	{
		//Marcamos coomo que si ha pulsado
		pulsado = true;
	}
	
	//Devolvemos si ha pulsado o no
	return pulsado;
}

function ExplorerObtenerPos(x)
{
	//Calculamos la posicion en la que se encuentra ahora
	var pos = x + (-explorer_pos) - 30;
	
	//Lo devolvemos
	return pos;
}

function ExplorerObtenerVal(x)
{
	//Obtenemos la posicion
	var pos = ExplorerObtenerPos(x);
	
	//Corregimos por el zoom
	pos = Math.floor(pos/zoom);
	
	//Obtenemos el valor
	var val = explorer_arr[explorer_num][pos];
	
	//Lo devolvemos
	return val;
}

function ExplorerStartOver(e)
{
	//Obtenemos la posicion
	var parentPosition = ExplorerGetPosition(e.currentTarget);
	
	//Calculamos donde ha pulsado
    var x = e.clientX - parentPosition.x;
    var y = e.clientY - parentPosition.y;
    
    //Comprobamos que estamos en la zona de dibujo
    if( 100 < y && y < 300 )
    {
    	//Comprobamos si esta dentro de la zona de dibujo
	    if( 30 <= x && x < 900 )
	    {
	    	//Dibujamos
	        ExplorerDibujar();
	        
	        //Para evitar dibujar mas de lo necesario
	        explorer_dib = true;
	        
	        //Calculamos el valor, para evitar undefined
	        var val = ExplorerObtenerVal(x);
	        
	    	//Situamos la posicion solo si esta activada
	        if(explorer_marca == true && typeof val != 'undefined')
	        {
	        	//Dibujamos la marca
	        	ExplorerMarcaPoner('#2dcc70', x, val);
	        	
	        	//Dibujamos la distancia hasta el eje Y
	        	ExplorerMarcaY('#2dcc70', x, y);
	        }
	    	
	    	//Desactivamos que se mueva
	    	ExplorerMoverDesactivar();
	    }
	    else if(explorer_moviendo == false)
	    {
	    	//Si esta encima de alguna de las flechas, activamos para que se mueva
	    	explorer_moviendo = true;
	    	
	    	//Activamos el set time out
	    	ExplorerMoverTimeOut();
	    	
	    	//Guardamos la direccion
	    	if( x <= 30 )
	    	{
	    		//Se mueve hacia la izquierda
	    		explorer_moviendo_dir = 'izq';
	    	}
	    	else
	    	{
	    		//Se mueve hacia la derecha
	    		explorer_moviendo_dir = 'der';
	    	}
	    }
    }
    else
    {
    	//Desactivamos que se mueva
    	ExplorerMoverDesactivar();
    	
    	//Comprobamos si esta encima de algun gen
    	if(30 <= x && x <= 900 && 320 <= y && y <= 640)
    	{
    		//Cogemos el gen sobre el que esta encima
    		var actual = ExplorerBuscarGen(x,y);
    		
    		//Comprobamos si ha cambiado
    		if(actual != explorer_gen_activo)
    		{
    			//Si es distinto, lo guardamos
    			explorer_gen_activo = actual;
    			
    			//Activamos para que dibuje
    			explorer_dib = true;
    		}
    	}
    	
    	//Dibujamos para quitar el marcador verde y las flechas moradas
    	ExplorerDibujarComprobar();
    }
}

function ExplorerEndOver(e)
{
	//Desactivamos que se mueva
	ExplorerMoverDesactivar();
	
	//Dibujamos para quitar las flechas moradas
	ExplorerDibujarComprobar();
}

function ExplorerDibujarComprobar()
{
	//Comprobamos si hay que dibujar para quitar el marcador verde y las flechas moradas
	if(explorer_dib == true)
	{
		//Marcamos para que no vuelva a dibujar
		explorer_dib = false;
		
		//Dibujamos, quitando asi la marca verde
		ExplorerDibujar();
	}
}
 
function ExplorerGetPosition(element) 
{
	//Iniciamos
	var xPosition = 0;
	var yPosition = 0;
	
	while (element) 
	{
		xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
		yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
		element = element.offsetParent;
	}
	
	//Devolvemos
	return { x: xPosition, y: yPosition };
}

function ExplorerMoverDesactivar()
{
	//Comprobamos si se estaba moviendo
	if(explorer_moviendo == true)
	{
		//Descativamos el time out
		clearTimeout(explorer_moviendo_int);
	}
	
	//Marcamos como que no esta moviendo
	explorer_moviendo = false;
	explorer_moviendo_dir = 0;
	
	//Reseteamos los botones
	explorer_activo1 = 0;
	explorer_activo2 = 0;
	
	//Marcamos para que dibuje
	explorer_dib = true;
}

function ExplorerMoverTimeOut()
{
	//Comprobamos si se esta moviendo
	if(explorer_moviendo == true)
	{
		//Activamos el time out
		explorer_moviendo_int = setTimeout(function(){ ExplorerMover(); }, 100);
	}
	else
	{
		//Reseteamos los botones
		explorer_activo1 = 0;
		explorer_activo2 = 0;
	}
}

function ExplorerMover()
{
	//Reseteamos los botones
	explorer_activo1 = 0;
	explorer_activo2 = 0;
	
	//Movemos la imagen
	if(explorer_moviendo_dir == 'izq')
	{
		//Movemos a la izquierda
		explorer_pos = explorer_pos + explorer_vel;
		
		//Si nos hemos pasado
		if(explorer_pos > 0)
		{
			explorer_pos = 0;
		}
		
		//Marcamos para que se ponga la flecha morada
		explorer_activo1 = 1;
	}
	else if(explorer_moviendo_dir == 'der')
	{
		//Movemos a la derecha
		explorer_pos = explorer_pos - explorer_vel;
		
		//Si nos hemos pasado
		if(explorer_pos < 930 - explorer_img.width + 85)
		{
			explorer_pos = 930 - explorer_img.width;
		}
		
		//Marcamos para que se ponga la flecha morada
		explorer_activo2 = 1;
	}
	
	//Activamos el siguiente time out
	ExplorerMoverTimeOut();
	
	//Dibujamos
	ExplorerDibujar();
}


//Para reiniciar las marcas
function ExplorerMarcaReiniciar()
{
	//Reiniciamos la marca 1
	explorer_marca1_pos = null;
	explorer_marca1_inc = null;
	explorer_marca1_var = null;
	
	//Reiniciamos la marca 2
	explorer_marca2_pos = null;
	explorer_marca2_inc = null;
	explorer_marca2_var = null;
	
	//Activamos para que se muestre la marca
	explorer_marca = true;
}

function ExplorerMarcaPoner(color, x, val)
{
	//Si estamos, dibujamos la recta
	explorer_can.Line(color, 2, x, 100, x, 650, 1);
	
	//Ponemos el cuadro debajo
	explorer_can.Rectangle(color, x - 35, 300, 70, 19, 1);
	
	//Situamos la posicion
	explorer_can.Text(val, 'OpenSans', '#ffffff', 14, 'center', x, 300);
}

function ExplorerMarcaY(color, x, y)
{
	//Situamos la recta desde el punto (x,y) hasta el (30, y)
	explorer_can.Line(color, 2, x, y, 30, y, 1);
	
	//Ponemos el recuadro verde
	explorer_can.Rectangle(color, 0, y - 15, 30, 30, 1);
	
	//Calculamos el valor de la Y
	var val = ((200 - (y - 100))/200)*(explorer_ymax[explorer_num] - explorer_ymin[explorer_num]) + explorer_ymin[explorer_num];
	
	//Cogemos solo dos decimales
	val = val.toFixed(2);
	
	//Lo situamos
	explorer_can.Text(val, 'OpenSans', '#ffffff', 14, 'center', 15, y - 10);
}
