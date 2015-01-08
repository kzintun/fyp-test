

<?php 
//Created on 18/10/2014 by JH-->
//Modlfied on 14/11/10/2014 by BB-->
function getMetadataFromXmlDocument($xml){
	
	//~ Improvement could be to load directly the attributes
	// input: instance of the xml document
	// output: table with metada
		
	$docInfo = array();
	
	$docName = (string) $xml->attributes()->name;
	
	foreach ( $xml->metadata as $t ){
		
		$docInfo['xmlLoc']='./documents/'. $docName . '.xml';		
		$docInfo['description']= (string) $t->description;
		$docInfo['media']='./documents/'. (string) $t->media->attributes()->name ;
		$docInfo['type'] = (string) pathinfo($t->media->attributes()->name , PATHINFO_EXTENSION);
		$docInfo['speaker'] = array();		
		
		foreach ( $t->speakers->speaker as $spk){	
			$currSpk = (string) $spk->attributes()->name;
			if (preg_match("/unknown_/" , $currSpk )){
				$currSpk = (string) "unknown";
			}
			
			$currId  =  (int) $spk->attributes()->id;
			$docInfo['speaker'][(int) $currId] = $currSpk;
		}	
		$docInfo['speakerEdit'] = join(', ', $docInfo['speaker'] );
				
	}	
	//print_r($docInfo);
	return $docInfo;
}

