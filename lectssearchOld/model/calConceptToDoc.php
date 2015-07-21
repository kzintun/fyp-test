<?PHP
function calculateConcepts($collection){

 $conceptXMLFile = './conceptDir/'.$collection.".xml";
 $conceptCount = array();
 include_once("model/loadXML.php");
 $xml=loadXML($conceptXMLFile);
 //$xml=simplexml_load_file('./conceptDir/'.$conceptXMLFile);
if($xml !== 0){
	foreach ($xml->children() as $concept) {
  
		foreach ($concept->children() as $keyword) {
	
			if (!isset($conceptCount[(String)$concept['id']][(String)$keyword['docName']]))
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']] = 1;
			}
			else
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']]++; 
			}
		}
    }
}
//echo '<pre>';
//print_r($conceptCount);
//echo '</pre>';
 if(empty($conceptCount)) {
 	$conceptCount = null;
 }
 return $conceptCount;
}
?>