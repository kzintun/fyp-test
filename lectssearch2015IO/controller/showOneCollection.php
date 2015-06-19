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

$database =$_GET['database'];
$xmlFile='./collections/'.$database.'.xml';
$errorMessage = null;
$docInfo = 0;
	
if (file_exists($xmlFile)){		

	include_once("model/loadXML.php");		
	$xml=loadXML($xmlFile);
	//~ $xml=loadCollectionXML($xmlFile);

	// TODO: preprare a session variable with the collections
	// to prevent loading the database again.
		 
	if ($xml === 0 ){		
		$errorMessage="Problem while loading $xmlFile";
		include_once("view/errorFile.php");
	}
	else{		
		include_once("model/getMetadataFromXmlCollection.php");
		//~ $docInfo=compileMetadataCollectionXml($xml);		
		$docInfo=getMetaDataFromXmlCollection($xml);		
	
		// see later for session variable.
		//~ $_SESSION['docInfo'] = $docInfo;
		include_once("model/calConceptToDoc.php");
		$treeTable=calculateConcepts($database);

		if ($docInfo != 0 ){
			include_once("view/displayAllXML.php");
		}
		
		else {
			$errorMessage="Path to XML file not set";
			include_once("view/errorFile.php");
		}		
	}	
}
else if(($docInfo == 0)&&($database == 'all')) {
			$errorMessage="No Search Results Found.";
			//include_once("view/errorFile.php");
			include_once("view/displayAllXML.php");
		}	
else{
	$errorMessage="Path to XML file not set";
	include_once("view/errorFile.php");
}

