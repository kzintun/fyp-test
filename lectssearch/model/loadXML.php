<?php

function loadXML ($docDir){
	// very simple function that uses simplexml to create an instance of the xml file
	// input: well formatted XML text file
	// ouput : instance of the document
	// TODO add more error message
	if (file_exists($docDir)) {
		$docXML = simplexml_load_file($docDir);
		return $docXML;
	} 
	else {
		return 0;
	}
}
