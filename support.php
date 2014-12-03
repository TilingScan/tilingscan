<?php require 'src/config.php'; ?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Support - TilingScan</title>
	</head>
	<body>
		<!-- Head -->
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Principal -->
		<div class="main" align="center">
		
			<!-- Espacios -->
			<br><br>
			
			<!-- Titulo -->
			<span class="h1">Support</span><br><br>
			
			<!-- Descripcion -->
			<span class="h2">Do you need help? Want to report an issue? Contact us: </span>
			
			<!-- Espacios -->
			<br><br> 
			
			<!-- Cartel de enviado -->
			<?php 
				//Comprobamos si hemos enviado algo
				if(!empty($_GET))
				{
					//Ponemos el bloque
					echo '<div class="alert background-green">Your email has been sent. Thank you.</div>';
					
					//Espacios
					echo '<br><br>';
				}
			?>
			
			<!-- Formulario -->
			<form name="create" enctype="multipart/form-data" action="support?action=send" method="post" class="form">
				
				<!-- Nombre -->
				<b>Yout name:</b><br>
				<input name="name" id="name" type="text" class="input-500"><br><br>
				
				<!-- Email -->
				<b>Yout email:</b><br>
				<input name="email" id="email" type="text" class="input-500"><br><br>
				
				<!-- Asunto -->
				<b>Subject:</b><br>
				<input name="asunto" id="asunto" type="text" class="input-500"><br><br>
				
				<!-- Comentario -->
				<b>Message:</b><br>
				<textarea name="descripcion" id="descripcion" class="input-500"></textarea><br><br>
				
				<!-- Boton de enviar -->
				<input type="submit" value="Send" class="form-btn background-blue"><br>
				
				<!-- Aviso -->
				<small>All fields are required.</small>
			
			<!-- Cerramos el form -->
			</form>
			
		</div>
		
		<!-- Espacios -->
		<br><br>
		
		
		<!-- Pie de pagina -->
		<?php require 'src/theme/foot.php'; ?>
		
	</body>
</html>