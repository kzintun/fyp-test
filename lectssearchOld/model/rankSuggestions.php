<?php 
//Created on 09-Mar-2015 by JH-->
function sksort(&$array, $subkey="id", $sort_ascending=false) {
//http://php.net/manual/en/function.ksort.php
    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge( (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);

    else $array = $temp_array;
}

function rankSuggestions($rawSuggestionList) {
	$rankedSuggestionList = array();
	$orderby = "count";
/*	foreach ($rawSuggestionList as $k=>$subArray) {
		foreach ($subArray as $name) {
			foreach ($name as $key=$value) {
				$rankedSuggestionList[$name]+=$value;
			}
	    	
	  	}
	}*/
	//sorted($rawSuggestionList, key=attrgetter('count'), reverse=True);
	//array_multisort($rankedSuggestionList[$orderby],SORT_DESC,$rawSuggestionList); 

	sksort($rawSuggestionList, $orderby); //sort descendingly

	foreach($rawSuggestionList as $rawSuggestion) {
		array_push($rankedSuggestionList, $rawSuggestion['name']);
	}
	return array_unique($rankedSuggestionList);
}

