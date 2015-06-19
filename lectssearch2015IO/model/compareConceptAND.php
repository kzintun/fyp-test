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
 * @author Kyaw Zin Tun (c) 2015
 */

function compareConcepts($curConArray,$newConArray){

	
	$matchedArray = array();
	$counter = 0;

	foreach($curConArray as $arr1){
				//echo '<pre>';
				//print_r($arr1);
				//echo '</pre>';
		//echo 'array1 :'. $arr1['docname'] . '<br>';
		
		foreach($newConArray as $arr2){
			//echo 'array2 :'. $arr2['docname'] . '<br>';
			
			if($arr2['docname']==$arr1['docname'] && $arr2['segmentID']==$arr1['segmentID'] && $arr2['sentenceID']==$arr1['sentenceID']){
            //echo $arr1['docname'] .'<br>';
			$matchedArray[$counter] = $arr1;
			$matchedArray[$counter]['swID'] .= ' '. $arr2['swID']; 
			$matchedArray[$counter]['ewID'] .= ' '. $arr2['ewID']; 
			$counter++;
			}
		}
	}			
			
	return $matchedArray;
}
