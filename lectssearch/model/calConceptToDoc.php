<?PHP



function calculateConcepts($collection){

 $conceptXMLFile = $collection.".xml";
 $conceptCount = array();
 $xml=simplexml_load_file('./conceptDir/'.$conceptXMLFile);

	foreach ($xml->children() as $concept) {
  
		foreach ($concept->children() as $keyword) {
	
			if (!isset($conceptCount[(String)$concept['id']][(String)$keyword['docName']]['count']))
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']]['count'] = 1;
			}
			else
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']]['count']++; 
			}
		}
    }

echo '<pre>';
print_r($conceptCount);
echo '</pre>';

 return $conceptCount;
}
?>