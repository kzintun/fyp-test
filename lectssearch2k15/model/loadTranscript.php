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

function loadTranscript($xml) {
	// load transcription  from an $xml object in an array
	// currently like this but not correct
	// $transcript ["idSegment"] => segment['segInfo']// ["idSentence"] => sentence["sentenceInfo"] ["idWord"] => word["wordInfo"]	
	// the following is more accessible
	
	// $transcript is the final array
	$transcript = array();	
	$content = $xml->content;
	$sentCounter = 0;	
	
	// ============================= //
	// For each segment in the content of the current XML
	foreach ($content->segment as $seg) {		
		$segId = (int) $seg->attributes()->id;				
		$transcript[$segId] = array();
		$transcript[$segId]['content'] = array();
		$transcript[$segId]['spkName'] = (string) $seg->attributes()->spkName;
		$transcript[$segId]['startTime'] = (string) $seg->attributes()->startTime;
		$transcript[$segId]['endTime'] = (string) $seg->attributes()->endTime;
				
		// ============================= //
		// Set Sentences for each sentence of the current segment				
		foreach ($seg->sentence as $sen) {
			$sentId = (int) $sen->attributes()->id;
			$transcript[$segId]['content'][$sentId]['content'] = array();
			$transcript[$segId]['content'][$sentId]['spkName'] = (string) $sen->attributes()->spkName;
			$transcript[$segId]['content'][$sentId]['startTime'] = (string) $sen->attributes()->startTime;
			$transcript[$segId]['content'][$sentId]['endTime'] = (string) $sen->attributes()->endTime;
			$transcript[$segId]['content'][$sentId]['id'] = $sentCounter++;
			
			// ============================= //
			// Set Words, foreach word contained in the current sentence, in the current segment
			foreach ( $sen->word as $wd ){
				$wordId = (int) $wd->attributes()->id;
				//~ $transcript[$segId]['content'][$sentId]['content'] = array();
				//~ $transcript[$segId]['content'][$sentId]['content'][$wordId] = array();
				$transcript[$segId]['content'][$sentId]['content'][$wordId]['spkName'] = (string) $wd->attributes()->spkName;
				$transcript[$segId]['content'][$sentId]['content'][$wordId]['startTime'] = (string) $wd->attributes()->startTime;
				$transcript[$segId]['content'][$sentId]['content'][$wordId]['endTime'] = (string) $wd->attributes()->endTime;
				$transcript[$segId]['content'][$sentId]['content'][$wordId]['word'] = strip_tags($wd->asXml());
			}	
		}		
	}
	return $transcript;
}

