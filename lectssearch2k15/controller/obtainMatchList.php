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
$document=html_entity_decode($_POST['document']);
$database =html_entity_decode($_POST['database']);
$matches = json_decode($_POST['matches'],true);

if (isset($document)){	
	$xmlLoc = './documents/'.$document.'.xml';
	if (file_exists($xmlLoc)){	
		
		//  TODO session variable with xmlDocumentContent
		// => to prevent loading twice in a session
		//~ $_SESSION['xml'] = $xml->asXML();
		
		include_once("model/loadXML.php");
		//~ $xml=loadXMLFile($xmlLoc);
		$xml=loadXML($xmlLoc);
		
		 //~ metada and transcription should come together.
		include_once("model/getMetadataFromXmlDocument.php");
		$docInfo = getMetadataFromXmlDocument($xml);
		
		//~ TODO: add a session variable	with the transcript
		include_once("model/loadTranscript.php");
		$transcript = loadTranscript($xml);
		
		include_once("model/prepareSegTranscript.php");
		$printScript = prepSegTranscript($transcript, $docInfo , $document);
		
		//print_r($printScript);
		// need to preprare also the text for the description. (no loop in the view)
		if  (isset($matches)) {
			
			include_once('./model/createEquivalence.php');
			$equivalence = createEquivalence($printScript);
			include_once("model/getMatchList.php");
			$matchList = getMatchList($equivalence, $matches);
			//$matchList = getMatchList($printScript[0]['eq'], $matches);
		}
		else{
			$matchList = array();
		}
		echo json_encode($matchList);
	}
}
