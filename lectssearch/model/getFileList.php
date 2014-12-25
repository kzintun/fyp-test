<?php

function getFileList($dir, $extension){
	//~ echo $dir . ' ';
	//~ echo $extension . ' ';
	//if $extension = null
	//$extension = '';
	
	$listing = scandir($dir);
	$outList = array();
	
	foreach( $listing as $file ){
		//~ echo $File ;
		if (strpos($file, $extension) !== false) {
			$outList[] = $file;
		}
	}
	return $outList;
}
