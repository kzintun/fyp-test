<!--Created on 30/09/2014 by JH-->
<!--Modified on 11/10/2014 by JH to add in reading of:
	Content type &
 	Multiple speakers-->
 	
<?php
//To read individual XML file and store them into an array.
function getInfoFromDocList($docList) {	
	$docInfo = array();

	//$dir='./databaseOut/';
	//$extension='.xml';
	$audioFormat = array('wav','mp3','aac');
	$videoFormat = array('mp4');
	$usefulInfo = array('xmlLoc','fileLoc','type','speaker','description');
	include_once ("model/loadXML.php");
	//print_r($docList);
	
	foreach ($docList as $docX) {
		//$docDir=$dir.$document.$extension;
		$docDir='./'.$docX['loc'];
		$document = $docX['name'];
		//echo $docDir;
		$docXML=loadXML($docDir);
		//print_r ($docXML);
		if ($docXML !== 0) {
			$docInfo[(string)$document][$usefulInfo[0]]=$docDir;
			if (isset($docXML->document) )
			{
				$docNameType=$docXML->document->attributes()->video;
				$docInfo[(string)$document][$usefulInfo[1]]='./data/'.$docNameType;
				$docType=substr($docNameType,-3);
				//echo $docType;
				if(in_array($docType,$audioFormat)){
					$docInfo[(string)$document][$usefulInfo[2]]='Audio';
				}
				elseif(in_array($docType,$videoFormat)) {
					$docInfo[(string)$document][$usefulInfo[2]]='Video';
				}
				else {
					$docInfo[(string)$document][$usefulInfo[2]]='Unknown';
				}
			}	
			for ($a=3; $a<sizeof($usefulInfo); $a++) {
				if (isset($docXML->document->metadata->$usefulInfo[$a])) {
					//$num = $docXML->document->metadata->$usefulInfo[$a]->count();
					//$listOfNodes = $docXML->document->metadata->$usefulInfo[$a]->attributes()->name;
					//while ($num > 1) {
					//	$listOfNodes .= ', '.$docXML->document->metadata->$usefulInfo[$a]->attributes()->name;	
					//	$num--;
					//}	
					
					$num = 1;
					$listOfNodes = "";		
					foreach ($docXML->document->metadata->$usefulInfo[$a] as $node) {
						if ($num > 1 ) {
							$listOfNodes .= ', ';
						}
						$listOfNodes .= $node->attributes()->name;
						$num++;
					}
					$docInfo[(string)$document][$usefulInfo[$a]] = $listOfNodes;						
				}
				else {
					$docInfo[(string)$document][$usefulInfo[$a]] = 'NA';
				}
			}
		}
	}
	
	return $docInfo;
}