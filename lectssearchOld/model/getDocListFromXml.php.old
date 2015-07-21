<!--Modified on 11/10/2014 by JH to
	change docList to multidimensional array-->
<?php

function getDocListFromXml($xml){	
	$docList = array();
	$i = 0;
	//~ $doc = $xml-> getElementsByTagName('document');
	foreach ( $xml->document as $t ){
		//~ print $t->getAttribute('name') . "<br/>";
		//echo $t;
 		$docList[$i]['name'] = $t['name'];
 		$docList[$i]['loc'] = $t['xref'];
 		$i++;
	}
	return $docList;
}
