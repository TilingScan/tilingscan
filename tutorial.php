<?php require 'src/config.php'; ?>
<html>
	<head>
		<!-- Head -->
		<?php require 'src/theme/head.php'; ?>
		
		<!-- Titulo de la web -->
		<title>Tutorial - TilingScan</title>
	</head>
	<body>
		<!-- Head -->
		<?php require 'src/theme/menu.php'; ?>
		
		<!-- Principal -->
		<div class="main" align="left">
		
			<!-- Espacios -->
			<br><br>
			
			<!-- Div centrado -->
			<div align="center">
			
				<!-- Titulo -->
				<span class="h1">TilingScan Tutorial</span>
			
			</div>
			
			<!-- Espacios -->
			<br><br><br>
			
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('1');">About TilingScan.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="1">
					TilingScan is a WebApp for the analysis of differentially expressed DNA regions in tiling microarray data in a strand-specific manner. <br>
					TilingScan can load data from tiling array results as genome graphs, which display probe intensity alongside the genomic sequence, aligning it onto the reference genome provided by the user. <br>
					It allows customized visualization of either specific chromosomes or specific genes of interest. <br><br>
					
					<div align="center"><img src="img/tutorial/0.png" border="0"></div><br><br>
					
					By uploading data sets that reflect the ratio between two experimental conditions, peaks and valleys of intensity display differentially expressed regions. 
					Along with their visualization, TilingScan provides the user with a tool to accurately locate and identify these regions, recording useful information such as their chromosomal coordinates, length, and mean intensity value on each DNA strand. <br> 
					All images, tables and results provided by the application can be downloaded for further analysis.
					
					<br><br>
					
					<div class="tutorial-close"  onclick="AbrirCerrar('1');">Close</div>
				</div>
				
			</div>
			
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('2');">Requirements.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="2">
					You only need a web browser to execute TilingScan. No other software are required.<br>
					Compatible browsers:<br>
					<ul>
						<li>Internet Explorer 10+</li>
						<li>Google Chrome 35+</li>
						<li>Firefox 31+</li>
						<li>Safari 7+</li>
					</ul>
					
					<div class="tutorial-close"  onclick="AbrirCerrar('2');">Close</div>
				</div>
				
			</div>
			
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('3');">Introducing the app: Dashboard.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="3">
					When you enter the App, you will see the following image on the screen:<br><br>
					<div align="center"><img src="img/tutorial/1.png" border="0"></div>
					<ol>
						<li><b>Project search</b>: Here you can search for all the already existing projects that you have previously created. By introducing the Project ID, project name or the name of the author all uploaded data sets will be displayed.</li>
						<li><b>Create new project</b>: Opens the page where you can upload your data to create a new project.  You can give it a name and save it. TilingScan will also provide your new project with an automatically generated identifier (Project ID)..</li>
						<li><b>Try the app</b>: If you do not have any data sets yet, you can try all the app features with demo data.</li>
					</ol>
										
					<div class="tutorial-close"  onclick="AbrirCerrar('3');">Close</div>
				</div>
				
			</div>
			
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('4');">Create new project.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="4">
					By clicking on Create new project, you can upload the data files needed to use TilingScan.<br><br>
					<div align="center"><img src="img/tutorial/2.png" border="0"></div><br>
					You must provide the following information:<br>
					<ul>
						<li><b>Project title</b>: this will help you to differentiate projects.</li>
						<li><b>Project author</b>: your name.</li>
						<li><b>Annotation file</b>: File containing the genome annotation of the organism of study <span class="color-red">(See data formats)</span>.</li>
						<li><b>Experiment type</b>: You can select your experiment type by providing strand-specific (e.g. GRO data) or non-strand specific data (e.g. ChIP-on-chip data).</li>
						<li><b>Experimental data files</b> <span class="color-red">(See data formats)</span>:<br>
							<ul>
								<li><b>Forward file</b>: file with expression of the Forward (Plus, Watson) strand.</li>
								<li><b>Reverse file</b>: file with expression of the Reverse (Minus, Crick) strand.</li>
							</ul>
						</li>	
					</ul>
					<b class="color-green">TIP</b>: You can upload every file compressed in a .zip file.<br><br>
					
					After selecting you data files, click on <b>Create!</b> to upload them to the server. 
					The size of this type of files is usually large, so this process may take a few minutes. <br>					
					Once the upload is complete, an automatically generated identifier will be assigned to your project (<b>Project ID</b>). 
					You may want to save this ID for future access to it via the project home. 
					Alternatively, you can search for it by providing the application with either the project or the user name.<br><br>
					
					<b class="color-red">IMPORTANT NOTE</b>: You can create an unlimited number of projects, <b>but every project will only be available over 60 days</b>. Sixty days after the date of creation <b>the project will be automatically deleted</b>. 
					
					<br><br>
					
					<div class="tutorial-close"  onclick="AbrirCerrar('4');">Close</div>
				</div>
				
			</div>
			
						
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('6');">Data formats.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="6">
					
					<b class="tutorial-sec">Annotation file</b><br>
					GFF stands for 'general feature format' or 'gene finding format'; it is a tab-delimited file with 9 columns. There are several types of GFF files that use incompatible syntax. The original GFF format is GFF1. A variant called GTF is also used. GFF3 has been proposed to extend on GFF and to constrain the specification more tightly to avoid mutually-incompatible versions of GFF.<br><br>
					The annotation file must be an <b>.gff</b> (Generic Feature Format Version 3 , GFF3) file.<br>
					Please see <a href="http://www.sequenceontology.org/resources/gff3.html" target="_blank">http://www.sequenceontology.org/resources/gff3.html</a> 
					for a detailed description of the Generic Feature Format (GFF).
					
					<br><br>
					
					<b class="tutorial-sec">Experimental files</b><br>
					To upload you data files, create a tabulated text file (.txt) containing the following information::<br><br>
					<div align="center"><img src="img/tutorial/12.png" border="0"></div><br>
					
					<ul>
						<li>Line 1: <b>"# Sequence [tabulation] sequence number (optional)"</b>. You just have to write the word sequence for the program to start reading your data. The sequence number is optional.</li>
						<li>Line 2: <b>"# Name [tabulation] chr number"</b>. This will identify the chromosome the probes contain information for.</li>
						<li>Line 3: <b>"#Numer of hits [tabulation]  number of hits"</b>. This tells the program how many lines of probes it has to read. In the case of the example, it will read 94972 lines in a row until the next set of probes (Sequence 2).</li>
						<li>Line 4: Leave blank space</li>
						<li>Line 5: Probe position, followed by tabulation and signal intensity of the probe, ie <b>"probe [tabulation] signal"</b>.</li>
					</ul>
					
					<b class="color-red">NOTE</b>: In between sequences, you have to leave a blank space.
					
					<br><br>
					
					<b class="tutorial-sec">Download example files</b><br>
					You can download an example data set <a href="https://dl.dropboxusercontent.com/u/224579124/TilingScanExample.zip" target="_blank">here</a>.
										
					<br><br>
					
					<div class="tutorial-close"  onclick="AbrirCerrar('6');">Close</div>
				</div>
				
			</div>
			
			
			<div class="tutorial-item">
			
				<!-- Titulo -->
				<b class="tutorial-title" onclick="AbrirCerrar('5');">Tools.</b>
				
				<!-- Contenido -->
				<div class="tutorial-cont" id="5">
					
					<b class="tutorial-sec">Visualize Chromosome</b><br>
					By clicking on Visualize chromosome and selecting your chromosome of interest, you can visualize the expression alongside the entire chromosome. 
					To do so, you must set the desired Gauss filter repetition times (default is 3 times). 
					The more times the filter is applied, the smoother the signal profile will look.<br><br>
					<div align="center"><img src="img/tutorial/3.png" border="0"></div><br>
					So as to facilitate the visualization, the whole chromosome length is split in sections. 
					You can scroll left/right to move along the section, as well as to go back and forth to the different sections by selecting them in the pull down menu (bottom, left). 
					You can download all generated images, either individually or all of them at once.<br><br>
					<div align="center"><img src="img/tutorial/4.png" border="0"></div>
					
					<br><br>
					
					<b class="tutorial-sec">Visualize Gene</b><br>
					By clicking on Visualize gene you can visualize the expression of a specific gene. To do so, you have to select:<br><br>
					<div align="center"><img src="img/tutorial/5.png" border="0"></div>
					<ul>
						<li>The chromosome in which the gene is encoded (Select chromosome).</li>
						<li>The systematic identifier of the gene of interest (ORF name) in Select gene.</li>
						<li>The margins for the representation of the gene, in terms of length of the flanking regions. (Margin). For example, if you select 100 probes for the margin, you will display the entire ORF length + 100 bp up/downstream. If other ORFs are encoded whithin the margins, they will also be displayed.</li>
						<li>Gauss filter: Smoothing of the signal. Gauss filter of 5 coefficients.</li>
					</ul>
					TilingScan will open a detailed image of the selected gene:<br><br>
					<div align="center"><img src="img/tutorial/6.png" border="0"></div>
					
					<br><br>
					
					<b class="tutorial-sec">Window Search</b><br>
					Window search is a tool for the detection and identification of differentially expressed regions.<br>
					
					By selecting your chromosome of interest, you will locate and identify them. An array of images containing all detected regions will be displayed. <br><br>	
					<div align="center"><img src="img/tutorial/7.png" border="0"></div><br>
					For all the these regions, TilingScan will automatically register the following features:
					<ul>
						<li>Project name (data set from which the regions were obtained).</li>
						<li>Chromosome (Chromosome in which the regions are encoded).</li>
						<li>Lenght (Lenght of the region).</li>
						<li>Start (Chromosomal coordinates of the start point).</li>
						<li>End  (Chromosomal coordinates of the end point ).</li>
						<li>Watson Y- mean (Mean intensity value all along the region on the Forward strand).</li>
						<li>Crick Y-mean (Mean intensity value all along the region on the Reverse strand).</li>
						<li>Orfs (Systematic ID of all ORFs encoded within the detected region, if any).</li>
					</ul>
					To start your search, you have to select the following features:<br><br>
					<div align="center"><img src="img/tutorial/8.png" border="0"></div>
					<ul>
						<li><b>Chromosome</b>: Chromosome on which the search will be made.</li>
						<li><b>Strand</b>: Strand on which the search will be made.</li>
						<li><b>Gauss filter</b>: Smoothing of the signal. Gauss filter of 5 coefficients.</li>
						<li><b>Window size</b>: Lenght of the region to search for differences.</li>
						<li><b>Margin</b>: Number of probes on both sides of the detected region.</li>
						<li><b>Threshold:</b> </li>
					</ul>
					
					<br><br>
					
					<b class="tutorial-sec">Selection and visualization of manually delimited regions</b><br>
					When you are visualizing either an entire chromosome or a specific gene, you can delimit a region of interest by clicking on the graph. 
					When you delimit a region, it will automatically get highlighted and a magnifying glass icon will appear in the center, along with the length of the region in bp, and the start and end points (bar at the bottom). <br><br>
					<div align="center"><img src="img/tutorial/9.png" border="0"></div><br>
					By clicking on the magnifying glass icon, you will open the image of the delimited region in a new window, that can be adjusted to your convenience.<br><br>
					<div align="center"><img src="img/tutorial/10.png" border="0"></div><br>
					
					<br><br>
					
					<b class="tutorial-sec">Annotate!</b><br>
					Annotate! Is a tool that allows the annotation of manually selected regions of interest. 
					When you delimit a region manually, you can click on Annotate! (purple button at the bottom) to register information about it. 
					TilingScan will automatically register the following features:
					<ul>
						<li>Project name (data set from which these regions were obtained).</li>
						<li>Chromosome (Chromosome in which the regions are encoded).</li>
						<li>Lenght (Lenght of the detected region).</li>
						<li>Start (Chromosomal coordinates of the start point ).</li>
						<li>End (Chromosomal coordinates of the end point ).</li>
						<li>Watson Y- mean (Mean intensity value all along the region on the Forward strand).</li>
						<li>Crick Y-mean (Mean intensity value all along the region on the Reverse strand).</li>
						<li>Orfs (Systematic ID of all ORFs encoded within the detected region, if any).</li>						
					</ul>
					All this information will be recorded in a table that will automatically open in a new window.<br><br>
					<div align="center"><img src="img/tutorial/11.png" border="0"></div><br>
					You can edit, delete, and save the information to your convenience. 
					This information is saved automatically in your computer, so newly annotated regions will be added to your list as you select them. <br><br>
					<b>NOTE</b>: This information is not uploaded to the server, so it will only be available in the one computer the analysis has been started at. 
					If you wish to continue with the analysis using a different computer, you can download the list for further use.
					
					<br><br>
					
					<div class="tutorial-close"  onclick="AbrirCerrar('5');">Close</div>
				</div>
			</div>
			
			<!-- Espacios -->
			<br><br>
			
		</div>
		
		<!-- Pie de pagina -->
		<?php require 'src/theme/foot.php'; ?>
		
	</body>
</html>