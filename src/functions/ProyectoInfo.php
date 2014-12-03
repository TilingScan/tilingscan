<?php 
	//Funcion que muestra la info del proyecto
	function ProyectoInfo($title, $id, $autor, $descripcion, $date, $caducidad, $btn)
	{
		//Cogemos la fecha
		$f = ProyectoFechaFormato($caducidad);
		
		//Contenedor
		echo '<div class="form" align="left">';
		
		//Titulo del proyecto
		echo '<b class="h3">'.$title.'</b><br>';
		
		//Descripcion
		echo '<span class="h3">'.$descripcion.'</span><br><br>';
		
		//Info del proyecto
		echo '<span class="">ID: <b>'.$id.'</b></span><br>';
		echo '<span class="">Author: '.$autor.'</span><br>';
		echo '<span class="">Created '.ProyectoFechaFormato($date).'</span>';
		echo '&nbsp;&nbsp;';
		echo '<span class="color-red">(This project will be deleted on '.$f.')</span>';
		
		//Comprobamos si hay que mostrar el boton
		if($btn == true)
		{
			//Espacios
			echo '<br><br>';
			
			//Boton
			echo '<a href="./project?id='.$id.'" class="form-btn background-red">Project home</a>';
		}
		
		//Cerramos el contenedor
		echo '</div>';
		
		//Espacios
		echo '<br><br>';
	}
?>
