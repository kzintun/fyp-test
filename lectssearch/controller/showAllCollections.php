 <?php

$dir='./collections';
$extension='.xml';
	
if (is_dir($dir)){
	// get collection file list
	include_once('model/getFileList.php');
	$fileList=getFileList($dir, $extension);
	
	if ( $fileList == 0 ){
		$errorMessage="[ERROR 1]: no collection found in $dir";
		include_once('view/errorFile.php');
	}
	else{
		$collections= array();
		//get info from collections
		include_once('model/getMetadataFromXmlCollection.php');
		include_once('model/loadXML.php');
		
		foreach($fileList as $file){
			$xmlCollection = loadXML($file);
			$compiledInfo = getMetadataFromXmlCollection($xmlCollection);
			$collections[$compiledInfo['name']] = $compiledInfo;
		}
		
		
		// display all collections using $collections
		include_once('view/displayAllDB.php');
	}	
}
else{
	$errorMessage="problem with database directory";
	include_once('view/errorFile.php');
}
