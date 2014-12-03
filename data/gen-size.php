<?php 
	$file = 'chr1_A.php';
	
	require $file;
	
	$tam = count($chr_ids);
	
	for($i = 0; $i < $tam; $i++)
	{
		echo $chr_ids[$i];
		echo ': ';
		$l = $chr_fin[$i] - $chr_ini[$i];
		//$l = $l/12;
		echo $l;
		echo ' px<br>';
	}
	
?>