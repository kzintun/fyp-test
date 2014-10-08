<?php
//To read individual XML file and store them into an array.
function getInfoFromDocList($docList) {	
	$docInfo = array();
	$dir='./databaseOut/';
	$extension='.xml';
	$usefulInfo = array('speaker','description');
	include_once ("model/loadXML.php");
	
	foreach ($docList as $document) {
		$docDir=$dir.$document.$extension;
		//echo $document;
		$docXML=loadXML($docDir);
		//print_r ($docXML);
		if ($docXML !== 0) {
			for ($a=0; $a<sizeof($usefulInfo); $a++) {
				if (isset($docXML->document->metadata->$usefulInfo[$a])) {
					$docInfo[(string)$document][$usefulInfo[$a]]= $docXML->document->metadata->$usefulInfo[$a]->attributes()->name;	
				}
				else {
					$docInfo[(string)$document][$usefulInfo[$a]] = 'NA';
				}
			}
		}
	}
	
	return $docInfo;
}