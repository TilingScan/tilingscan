<?php 
	$file = 'chr1_A.php';
	
	showCHR($file, 'F');
	showCHR($file, 'R');
	
	function showCHR($file, $tipo)
	{
		require $file;
		$tam = count($chr_ids);
		echo '<b>'.$tipo.'</b><br>';
		
		for($i = 0; $i < $tam; $i++)
		{
			if($chr_tip[$i] == $tipo)
			{
				echo $chr_ids[$i];
				echo ': ';
				$ini = intval($chr_ini[$i]/12);
				$fin = intval($chr_fin[$i]/12);
				echo $ini;
				echo ' to ';
				echo $fin;
				echo ' <br>';
			}
		}
		
	}
?>