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
	function extractMatchListFromArray($finalResultArray){

		$matchList = array();
		foreach($finalResultArray as $key => $value) {
			$matchList[$key] = array();
			$matchList[$key]['results'] = array();
			//$spkerList = array();
			foreach ($value as $key2) {
				//foreach ($key2 as $key3) {
				//echo $key2['segmentID'];
				$segList = array();
				$segID = $key2['segmentID'];
				$senID = $key2['sentenceID'];
				$text = $key2['text'];
				//$spkerID = $key2['speakerID'];
				//if(!(isset($matchList[$key][$spkerID]['results'])) {
				//	$matchList[$key]['results'][$spkerID] = array();
				//}

				if(!(isset($matchList[$key]['results'][$segID]))) {
					$matchList[$key]['results'][$segID] = array();
				}
				if(!(isset($matchList[$key]['results'][$segID][$senID]))) {
					$matchList[$key]['results'][$segID][$senID] = array();
				}
				//array_push($matchList[$key]['results'][$segID], $senID);

				//$matchList[$key]['results'][$segID][$senID]['text'] = $text;
				//array_push($matchList[$key], $key2['segmentID']);
			}
		//}
		}
		//print_r($matchList);
		return $matchList;
	}
?>
