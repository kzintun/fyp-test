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
 * @author Bejamin Bigot (c) 2013
 * @author Ong Jia Hui (c) 2015
 * @author Kyaw Zin Tun (c) 2015
 */
//	Description: Create a multidimensional array of search results
// 		 Format: Array{ [$documentname] =>	Array(
//											[index: 0 - N] => Array (
//																	['segmentID'] => valueA
//				 								     				['speakerID'] => valueB	
//												     				['sentenceID'] => valueC
//                                    				 				['wordID/startTime'] => valueD
//                                     				 				['text'] => valueE	))}
//	input = sorted 2D array that stored search results
//	output = a multidimensional array following the above mentioned format.

function aggregate($srList,$collection){
  $aggregated = array();
  $counter = 0;
  foreach($srList as $result){
	if(!array_key_exists($result['docname'], $aggregated)){
	  $counter = 0;
	}
	  $aggregated[$result['docname']][$counter]['segmentID']= $result['segmentID'];
	  $aggregated[$result['docname']][$counter]['speakerID']= $result['speakerID'];
	  $aggregated[$result['docname']][$counter]['sentenceID']= $result['sentenceID'];
	  $aggregated[$result['docname']][$counter]['startTime']= $result['startTime'];
	  $aggregated[$result['docname']][$counter]['text']= $result['text'];
	  $aggregated[$result['docname']][$counter]['word']= $result['word'];
	  $aggregated[$result['docname']][$counter]['collection']= $collection;
	  $aggregated[$result['docname']][$counter]['rank']= $result['rank'];
	  $counter++;
  }
  return $aggregated;
}


			