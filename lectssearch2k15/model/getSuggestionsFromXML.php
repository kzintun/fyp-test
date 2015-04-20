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

function getSuggestionsFromXML($xml, $database, $document) {
	$rawSuggestionList = array();	
	$counter = 0;
	
	if (($document == null) && ($database == "all")) {
		foreach ($xml as $suggestion){
			$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
			$rawSuggestionList[$counter]['count'] = (int)$suggestion['total'];
			$counter++;
		}

	}
	elseif (($document != null)&& ($database != "all")) {
		foreach ($xml->suggestion as $suggestion){
			foreach($suggestion->collection as $collection) {
				foreach($collection->occurrence as $occurrence) {
					if($occurrence->attributes()->document == $document) {
						$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
						$rawSuggestionList[$counter]['count'] = (int)$occurrence['count'];
						$counter++;
					}		
				}	
			}
		}
	}
	elseif (($document == null)&& ($database != "all")) {
		//echo $database;
		foreach ($xml->suggestion as $suggestion){
			//print_r($suggestion);
			foreach($suggestion->collection as $collection) {
				//print_r($collection->attributes()->db);
				if($collection->attributes()->db == $database) {
					$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
					$rawSuggestionList[$counter]['count'] = (int)$collection['subtotal'];
					$counter++;			
				}
			}
		}
	}
	else {
		$rawSuggestionList = null;
	}
	return $rawSuggestionList;
}

