<?php

function loadXML ($docDir){
	if (file_exists($docDir)) {
		//global $docXML;
		$docXML = simplexml_load_file($docDir);
		return $docXML;
	} 
	else {
		return 0;
	}

}