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
 
function compileMetadataFromXmlCollection($xml){
	
	//~ Improvement could be to load directly the attributes
	// input: instance of the xml document
	// output: table with metada
		
	$docInfo = array();
	
	$docName = (string) $xml->attributes()->name;
	$docDate = (string) $xml->attributes()->date;
	$description = (string) $xml->attributes()->description;
	
	$spkList = array();
	$typeList = array();
	$counter = 0;
	
	foreach ( $xml as $document ){	
		//~ $docInfo['xmlLoc']='./documents/'. $docName . '.xml';		
		//~ $docInfo['description']= (string) $t->description->textContent;
		//~ $docInfo['media']='./documents/'. (string) $t->media->attributes()->name ;
		//~ $docInfo['type'] = (string) pathinfo($t->media->attributes()->name , PATHINFO_EXTENSION);
		//~ $docInfo['speaker'] = array();		
		$counter++;
		$typeList[ (string) pathinfo($document->metadata->media->attributes()->name , PATHINFO_EXTENSION)] = 1;
		
		foreach ( $document->metadata->speakers->speaker as $spk){	
			$spkList[(string) $spk->attributes()->name] = 1;
		}
	}
	
	$spkNb = 0;
	foreach($spkList as $s){
		$spkNb++;
	}
	
	$type = array();
	foreach($typeList as $t => $tt){
		$type[] = $t;
	}
	
	
	$docInfo['name'] = $docName;
	$docInfo['date'] = $docDate;
	$docInfo['description'] = $description;
	$docInfo['nbSpeaker'] = $spkNb;
	$docInfo['type'] = join(', ', $type);
	$docInfo['nbDocument'] = (string) $counter;
	
	return $docInfo;
}
