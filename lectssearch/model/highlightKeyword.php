<?php

// input = subject array , keywords array
// output = subject array with keywords bol
// highlight the keywords
function highlightKeyword($haystackArray, $keyword) {
	$keywordList = explode(" ", $keyword);
	for ($k=0 ; $k < sizeof($haystackArray); $k++){
			foreach($keywordList as $word){
			
				$haystack= $haystackArray[$k]['text'];
				$needle= $word;
				
				// return $haystack if there is no strings given, nothing to do.
				if (strlen($haystack) < 1 || strlen($needle) < 1) {
				}
				else{
				preg_match_all("/\b$needle+\b/i", $haystack, $matches);
				
				if (is_array($matches[0]) && count($matches[0]) >= 1) {
					foreach ($matches[0] as $match) {
						$haystack= str_replace($match, '<b>'.$match.'</b>', $haystack);
					}
				}
				$haystackArray[$k]['text']=$haystack;
				}
			}
			
	}
    return $haystackArray;
}
?>