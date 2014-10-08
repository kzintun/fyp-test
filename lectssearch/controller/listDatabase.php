<?php

if (isset($dir)){
	//~ echo $dir;
	//~ get array with xml files
	//~ TODO:search in collection (longer)
	include_once('model/getFileList.php');
	$fileList=getFileList($dir, $extension);
	//~ echo count($fileList);
	
	if ( $fileList == 0 ){
		//~ array list is empty
		$errorMessage="No $extension file found in $dir";
		include_once('view/errorFile.php');
	}
	else{
		
		include_once('view/displayAllDB.php');
	}	
}
else{
	$errorMessage="problem with database directory";
	include_once('view/errorFile.php');
}
