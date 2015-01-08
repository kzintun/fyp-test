
<?php 
//Created on 18/10/2014 by JH-->
//Modlfied on 14/11/10/2014 by BB-->
function getMetadataFromXmlCollection($xml){
	//~ Improvement could be to load directly the attributes
	$docInfo = array();
	foreach ( $xml->document as $t ){
		$docName = $t->attributes()->name;
		//~ echo $docName;
		$docInfo[(string) $docName]['xmlLoc']='./documents/'. $docName . '.xml';		
		$docInfo[(string) $docName]['description']=$t->metadata->description;
		$docInfo[(string) $docName]['media']='./documents/'. $t->metadata->media->attributes()->name ;
		$docInfo[(string) $docName]['type'] = pathinfo($t->metadata->media->attributes()->name , PATHINFO_EXTENSION);
		$docInfo[(string) $docName]['speaker'] = array();		
		
		foreach ( $t->metadata->speakers->speaker as $spk){	
			$currSpk = (String) $spk->attributes()->name;
			$currId  =  (int) $spk->attributes()->id;
			if (preg_match("/unknown_/" , $currSpk )){
				$currSpk = (string) "unknown";
			}
			$docInfo[(string) $docName]['speaker'][(int) $currId] = $currSpk;
		}	
		$docInfo[(string) $docName]['speakerEdit'] = join(', ', $docInfo[(string) $docName]['speaker'] );	
	}
	return $docInfo;
}



	
		
