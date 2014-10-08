<?php
//global $xml;
//global $xml ;
function loadDatabase ( $xmlFile){
	if (file_exists( $xmlFile)) {
	global $xml;
	//~ $xml = new DOMDocument();
	//~ $xml->load($xmlFile);
	//~ echo $xml->saveXML();
	$xml = simplexml_load_file($xmlFile);
	return $xml;
	} 
	else {
		return 0;
	}

}
