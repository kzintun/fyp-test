<?php
//global $xml;
//global $xml ;
function loadDatabase ( $xmlFile){
	if (file_exists( $xmlFile)) {
	$xml = simplexml_load_file($xmlFile);
	return $xml;
	} 
	else {
		return 0;
	}

}
