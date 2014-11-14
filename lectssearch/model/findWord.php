<?php

function findWord($sentenceString, $needle){	

	$arrayCoord = array();
	$counter = 0;
	
	$wordString = explode(" ", $sentenceString);
	
	for ($s = 0 ; $s < sizeof($wordString); $s++){
	
		if (strpos($wordString[$s],$needle) === false)
		{	
			$counter++;
		}
		else
		{
		 echo $needle . ' found at position: ' . $counter .'</br>';
		 array_push($arrayCoord,$counter);
		}

	}
	echo '</br> <pre>';
	print_r($arrayCoord);
	echo '</pre>';
	return $arrayCoord;
}


echo '</br>'.$c;
}