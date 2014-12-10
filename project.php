<?php
	//Incluimos el archivo de configuracion
	require 'src/config.php';
	
	//Incluimos las funciones
	require 'src/include.php';
	
?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Project dashboard - TilingScan</title>
	</head>
	<body>
	
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Espacios -->
		<br><br>
		
		<!-- Div principal -->
		<div class="main" align="center">
		
			<!-- Titulo -->
			<span class="h1">Project dashboard</span><br><br>
			
			<?php 
				
			//Cogemos el proyecto
			$id = $_GET["id"];
			
			//Cogemos el directorio
			$dir = _DATA.$id.'/';
			
			//Comprobamos si existe el fichero de configuracion
			if(!file_exists($dir.'config.php'))
			{
				//Si no existe el fichero, es porque no existe el proyecto. Mostramos un error
			?>
						
			<!-- Alerta -->
			<div class="alert background-red">Error: project does not exist.</div>
			
			<!-- Espacios -->
			<br><br><br><br>
			
			<?php
			
			}
			else
			{
				//Incluimos
				require $dir.'config.php';
			
				//Mostramos la web
			?>
					
			<!-- Info del proyecto -->
			<?php ProyectoInfo($p_title, $id, $p_autor, $p_descripcion, $p_date, $p_caducidad, false); ?>
			
			<!-- Botones con las aplicaciones -->
			<a class="dashboard-btn background-blue" onclick="AppProjectMostrar('Chr');">Visualize chromosome</a>
			<a class="dashboard-btn background-red" onclick="AppProjectMostrar('Gene');">Visualize gene</a>
			<a class="dashboard-btn background-water" onclick="AppProjectMostrar('Window');">Window Search</a>
			
			<!-- Espacios -->
			<br><br>
			
			<!-- Visualizar todo el cromosoma -->
			<div align="center" id="Project_Chr" style="display: none;">
			
				<!-- Contenedor -->
				<div class="form" align="center">
					
					<!-- Titulo -->
					<span class="h2">Visualize chromosome</span>
					
					<!-- Espacios -->
					<br><br>
					
					<!-- Formulario -->
					<form enctype="multipart/form-data" action="./view-chr?id=<?php echo $id; ?>" method="post">
					
					<table border="0" width="900" algin="center" class="h4">
						<tr>
							<td width="300" height="70" valign="middle">Select chromosome: </td>
							<td valign="middle"><?php ListaCHRAnnotation($dir, '', 1); ?></td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Gauss Filter (5 coef.): </td>
							<td valign="middle"><input type="text" name="gauss" class="input" value="3">&nbsp; times. 
							<span class="color-red">&nbsp; (0 = No filter)</span>
							</td>
						</tr>
					</table>
					
					<!-- Espacios -->
					<br>
					
					<!-- Boton de enviar -->
					<input type="submit" value="Visualize" class="form-btn background-green"><br>
					<small>(Be patient)</small>
					
					</form>
					
				</div>
				
			</div>
			
			
			
			<!-- Mostrar un gen -->
			<div align="center" id="Project_Gene" style="display: none;">
				
				<!-- Contenedor -->
				<div class="form" align="center">
					
					<!-- Titulo -->
					<span class="h2">Visualize gene</span>
					
					<!-- Espacios -->
					<br><br>
					
					<!-- Formulario -->
					<form enctype="multipart/form-data" action="./view-gene?id=<?php echo $id; ?>" method="post">
					
					<table border="0" width="900" algin="center" class="h4">
						<tr>
							<td width="300" height="70" valign="middle">Select chromosome: </td>
							<td valign="middle">
								<?php ListaCHRAnnotation($dir, 'ProjectCambiarSelectGEN(this);', 2); ?> 
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Select gene: </td>
							<td valign="middle"><?php ListaGEN($dir); ?></td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Margin: </td>
							<td valign="middle"><input type="text" name="margen" class="input " value="100">&nbsp; probes. 
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Gauss Filter (5 coef.): </td>
							<td valign="middle"><input type="text" name="gauss" class="input" value="3">&nbsp; times. 
							<span class="color-red">&nbsp; (0 = No filter)</span>
							</td>
						</tr>
					</table>
					
					<!-- Espacios -->
					<br>
					
					<!-- Boton de enviar -->
					<input type="submit" value="Visualize" class="form-btn background-red"><br>
					<small>(Be patient)</small>
					
					</form>
					
				</div>
				
			</div>
			
			<!-- Buscar ventanas -->
			<div align="center" id="Project_Window" style="display: none;">
				
				<!-- Contendor -->
				<div class="form" align="center">
				
					<!-- Titulo -->
					<span class="h2">Window search</span>
					
					<!-- Espacios -->
					<br><br>
					
					<!-- Formulario -->
					<form enctype="multipart/form-data" action="./view-window?id=<?php echo $id; ?>" method="post">
					
					<table border="0" width="920" algin="center" class="h4">
						<tr>
							<td width="300" height="70" valign="middle">Select chromosome: </td>
							<td valign="middle"><?php ListaCHRAnnotation($dir, '', 3); ?></td>
						</tr>
						<tr <?php if($p_strand == false) echo 'style="display:none;"'; ?>>
							<td width="300" height="70" valign="middle">Search in </td>
							<td valign="middle">
								<select name="CADENA" class="select">
									<option value="Forward" selected>Forward</option>
									<option value="Reverse">Reverse</option>
								</select>&nbsp; strand.
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Gauss Filter (5 coef.): </td>
							<td valign="middle"><input type="text" name="gauss" class="input" value="3">&nbsp; times. 
							<span class="color-red">&nbsp; (0 = No filter)</span>
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Window Size: </td>
							<td valign="middle"><input type="text" name="VEN" class="input" value="10">&nbsp; probes.
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Margin: </td>
							<td valign="middle"><input type="text" name="margen" class="input" value="50">&nbsp; probes.
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Threshold: </td>
							<td valign="middle"><input type="text" name="UMBRAL" class="input" value="0.4">
							</td>
						</tr>
						<tr>
							<td width="300" height="70" valign="middle">Percentage: </td>
							<td valign="middle"><input type="text" name="PORCENTAJE" class="input" value="75">&nbsp; %
							</td>
						</tr>
					</table>
					
					<!-- Espacios -->
					<br>
					
					<!-- Boton de enviar -->
					<input type="submit" value="Search" class="form-btn background-water "><br>
					<small>(Be patient)</small>
					
					</form>
					
				</div>
				
			</div>
			
			<?php } ?>
			
		</div>
		
		<!-- Espacios -->
		<br><br><br>
		
		<?php require 'src/theme/foot.php'; ?>
	
	</body>
</html>

