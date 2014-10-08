<?php

function getDocListFromXml($xml){	
	$docList = array();
	//~ $doc = $xml-> getElementsByTagName('document');
	foreach ( $xml->document as $t ){
		//~ print $t->getAttribute('name') . "<br/>";
 		$docList[] = $t['name'];
	}
	return $docList;
}
