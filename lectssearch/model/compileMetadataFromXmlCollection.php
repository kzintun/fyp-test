<?php 
function compileMetadataFromXmlCollection($xml){
	
	//~ Improvement could be to load directly the attributes
	// input: instance of the xml document
	// output: table with metada
		
	$docInfo = array();
	
	$docName = (string) $xml->attributes()->name;
	$docDate = (string) $xml->attributes()->date;
	$description = (string) $xml->attributes()->description;
	
	$spkList = array();
	$typeList = array();
	$counter = 0;
	
	foreach ( $xml as $document ){	
		//~ $docInfo['xmlLoc']='./documents/'. $docName . '.xml';		
		//~ $docInfo['description']= (string) $t->description->textContent;
		//~ $docInfo['media']='./documents/'. (string) $t->media->attributes()->name ;
		//~ $docInfo['type'] = (string) pathinfo($t->media->attributes()->name , PATHINFO_EXTENSION);
		//~ $docInfo['speaker'] = array();		
		$counter++;
		$typeList[ (string) pathinfo($document->metadata->media->attributes()->name , PATHINFO_EXTENSION)] = 1;
		
		foreach ( $document->metadata->speakers->speaker as $spk){	
			$spkList[(string) $spk->attributes()->name] = 1;
		}
	}
	
	$spkNb = 0;
	foreach($spkList as $s){
		$spkNb++;
	}
	
	$type = array();
	foreach($typeList as $t => $tt){
		$type[] = $t;
	}
	
	
	$docInfo['name'] = $docName;
	$docInfo['date'] = $docDate;
	$docInfo['description'] = $description;
	$docInfo['nbSpeaker'] = $spkNb;
	$docInfo['type'] = join(', ', $type);
	$docInfo['nbDocument'] = (string) $counter;
	
	return $docInfo;
}
