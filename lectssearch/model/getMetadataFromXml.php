<!--Created on 18/10/2014 by JH-->

<?php 

function getMetadataFromXml($xml){
	$docInfo = array();
	$audioFormat = array('wav','mp3','aac');
	$videoFormat = array('mp4');
	$usefulInfo = array('xmlLoc','fileLoc','type','category','speaker','description');
	
	
	foreach ( $xml->document as $t ){
		$docName = $t->attributes()->name;
		$docInfo[(string) $docName][$usefulInfo[0]]='./'.$t->attributes()->xref;
		$docNameType=$t->attributes()->video;
		$docInfo[(string) $docName][$usefulInfo[1]]='./'.$docNameType;
		$docType=substr($docNameType,-3);
		if(in_array($docType,$audioFormat)){
			$docInfo[(string) $docName][$usefulInfo[2]]='Audio';
		}
		elseif(in_array($docType,$videoFormat)) {
			$docInfo[(string) $docName][$usefulInfo[2]]='Video';
		}
		else {
			$docInfo[(string) $docName][$usefulInfo[2]]='Unknown';
		}
		
		for ($a=3; $a<sizeof($usefulInfo); $a++) {
			if (isset($t->metadata->$usefulInfo[$a])) {
				$num = 1;
				$listOfNodes = "";		
				foreach ($t->metadata->$usefulInfo[$a] as $node) {
					if ($num > 1 ) {
						$listOfNodes .= ', ';
					}
					$listOfNodes .= $node->attributes()->name;
					$num++;
				}
				$docInfo[(string) $docName][$usefulInfo[$a]] = $listOfNodes;						
			}
			else {
				$docInfo[(string) $docName][$usefulInfo[$a]] = 'N.A.';
			}
		}
	}
	return $docInfo;
}

