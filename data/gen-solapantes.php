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
				$hay = false;
				for($j = $i + 1; $j < $tam; $j++)
				{
					if($chr_ini[$i] <= $chr_ini[$j] && $chr_ini[$j] <= $chr_fin[$i] && $chr_tip[$j] == $tipo)
					{
						if($hay == false)
						{
							echo '<br>';
							$hay = true;
							echo 'Solapantes con '.$chr_ids[$i].' ( '.$chr_ini[$i].' , '.$chr_fin[$i].' )<br>';
						}
						echo '   '.$chr_ids[$j].' ( '.$chr_ini[$j].' , '.$chr_fin[$j].' )<br>';
					}
				}
			}
		}			
	}
	
?>