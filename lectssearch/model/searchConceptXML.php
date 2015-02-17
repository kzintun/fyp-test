<?PHP

// Search concept ID from concept.xml inside conceptDir folder
// return the all the child nodes '<keyword>' of matching parent '<concept>' ID
// return array of simplexml object


function searchConceptXML($concept,$collection){


$xml=simplexml_load_file('./conceptDir/'.$collection);
$query = $concept;

//echo 'concept to look for is: ' . $query . '<br>';
/* Search for <a><b><c> */
$result = $xml->xpath('concept/keyword[../@id = "'.$query.'"]');


return $result;
}
?>