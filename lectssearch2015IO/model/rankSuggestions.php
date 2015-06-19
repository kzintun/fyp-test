<?php 
/*
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Ong Jia Hui (c) 2015
 */

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

	sksort($rawSuggestionList, $orderby); //sort in descending 'count'

	foreach($rawSuggestionList as $rawSuggestion) {
		array_push($rankedSuggestionList, $rawSuggestion['name']);
	}
	return array_unique($rankedSuggestionList);
}

