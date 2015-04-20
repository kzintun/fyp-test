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
 */

//	Description: Extract information from lucene search result
//	input = Lucene search result stored in array
//	output = 2-D array of search result array[index]['*usefulinfo']
//	*usefulinfo= document name, segementID, sentenceID, start time/wordID, text
//	need to reorganize by database in case of search in multiple databases


function getInfoFromSearch($luceneOut){

	$fileinfo = array();
	$searchDocInfo = array();
	$counter = 0;

	foreach ($luceneOut as $file){

		$fileinfo = explode(",", $file);

		if ($counter!=0){
				$searchDocInfo[$counter-1]['docname'] = $fileinfo[0];
				$searchDocInfo[$counter-1]['segmentID'] = $fileinfo[1];
				$searchDocInfo[$counter-1]['speakerID'] = $fileinfo[2];
				$searchDocInfo[$counter-1]['sentenceID'] = $fileinfo[3];
				$searchDocInfo[$counter-1]['startTime'] = $fileinfo[4];
				$searchDocInfo[$counter-1]['text'] = $fileinfo[5];
				$searchDocInfo[$counter-1]['word'] = "";
		}
		$counter++;
	}
	$counter=0;
	//print_r($searchDocInfo);
	return $searchDocInfo;
}
