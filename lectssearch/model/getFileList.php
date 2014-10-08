<?php

function getFileList($dir, $extension){
	//~ echo $dir . ' ';
	//~ echo $extension . ' ';
	$listing = scandir($dir);
	$outList = array();
	
	foreach( $listing as $File ){
		//~ echo $File ;
		if (strpos($File, $extension) !== false) {
			$outList[] = $File;
		}
	}
	return $outList;
}
