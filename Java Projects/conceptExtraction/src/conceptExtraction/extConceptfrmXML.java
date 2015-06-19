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

package conceptExtraction;

//<-----------------------2. Read XML transcript and perform string matching with concept-terms ------------------------------>
//Read each transcript and check if terms is found in each sentence, populate MultiMap of sentences metadata and concept

/**
 * @author Kyaw Zin Tun
 * @version 1.0
 */

import java.io.File;
import java.io.IOException;
import java.util.Arrays;
import java.util.Set;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;


import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

import com.google.common.collect.ArrayListMultimap;
import com.google.common.collect.Multimap;

public class extConceptfrmXML {
	
	Multimap<String, String> cncIdMap = ArrayListMultimap.create();
	
	public Multimap<String, String> getMapToWriteXML()
	{
		return cncIdMap;
	}
	
	public void extractContent(File xmlFile, String colName, Multimap<String, ?> multiMap) throws ParserConfigurationException, SAXException, IOException
	{	
		
				//	loading sample XML file
			
				DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
				DocumentBuilder db = dbf.newDocumentBuilder();
				Document doc = db.parse(xmlFile);
				doc.getDocumentElement().normalize();

				
				//	printing<database> node
				//System.out.println("Root element :" + doc.getDocumentElement().getNodeName());
				
				//	get node with <document> tag
				NodeList nodeLst = doc.getElementsByTagName("document");
				
				//initializing variables
				
				String docName;
				String segID;
				String speaker;
				String senID;
				String senStartTime= "";
				String tword = null;
				String allIDs = null;
				String tScript = "";
				String wID;
				int stID = 0;
				int enID = 0;
				
				//		***	<DOCUMENT>	***
				//	traverse <document> node
				  for (int s = 0; s < nodeLst.getLength(); s++) 
				  {
					  
					  Node fstNode = nodeLst.item(s);
				   
					  if (fstNode.getNodeType() == Node.ELEMENT_NODE) 
					  {
					      Element fstElmnt = (Element) fstNode;
					      docName = fstElmnt.getAttribute("name");
			    		  		
					      //	***	<SEGMENT>	***
					      //	get all nodes with the tag <segment>
					      NodeList SegElmntLst = fstElmnt.getElementsByTagName("segment");
					      
					      //	traverse <segment> node
					      for (int sg=0; sg<SegElmntLst.getLength(); sg++)
					      {
						      Element segElemnt = (Element) SegElmntLst.item(sg);
						      
							  //	get segment ID and speaker Name
							  segID = segElemnt.getAttribute("id");
							  speaker = segElemnt.getAttribute("spkName");
							      
								      //	***	<SENTENCE>	***
								      //	get all nodes with the tag <sentence>
								      NodeList SenElmntLst = segElemnt.getElementsByTagName("sentence");
								      
								      //	traverse <sentence> node
								      for (int snt=0; snt<SenElmntLst.getLength(); snt++)
								      {
									      Element senElemnt = (Element) SenElmntLst.item(snt);
									      
									      //	get sentence ID
									      senID = senElemnt.getAttribute("id");
									      senStartTime = senElemnt.getAttribute("startTime");
									      
									      
										      //	***	<WORD>	***
										      //	get all nodes with the tag <word>
										      NodeList fstNmElmntLst = senElemnt.getElementsByTagName("word");
										      
										      allIDs = docName +","+ segID +","+ speaker +","+ senID+ "," + senStartTime;
										      tScript = "";
										      
										      for (int j=0; j< fstNmElmntLst.getLength(); j++)
										      {
										    	  Element fstNmElmnt = (Element) fstNmElmntLst.item(j);
										    	
										    	  //	get wordID
										    	  wID = fstNmElmnt.getAttribute("id");
										    	  
										      	  NodeList fstNm = fstNmElmnt.getChildNodes();
										      	  tword =  ((Node) fstNm.item(0)).getNodeValue();
										      	
										      	  
										      	  // Form the sentence from each word nodes
										      	  tScript += tword + " " ;
										      	  
										      }		// end <word> loop
										      
										     
										    // to be read from XML
										    // 1. Check whether terms are found inside each transcript sentence 
										    // 2. True: Populate multimap with <concept, metadata of sentence transcript> pairs
										      
										    Set<String> keys = multiMap.keySet();
												 for (String key : keys)
												 {											         
													 boolean found = false;												 
													 for (Object ss : multiMap.get(key))
													 {
														 if(isContain(tScript, (String) ss))
														 {															 
															String[] wordL = ((String) ss).split(" ");
														     														 
															 stID = getPosition(tScript,wordL[0])-1;
															 enID = stID + wordL.length - 1;
															 cncIdMap.put(key, allIDs+","+Integer.toString(stID)+","+Integer.toString(enID)+","+colName+","+tScript);  
															 break;
														 }
													 }
										         }						      
								      
								      }		//	end <sentence> loop
					      	
					      }		//	end <segment> loop		
					  
					  }		// end if loop
					  
				  	}//	end <document> loop	
				  	
	}
	
	public int getPosition(String str, String substring){
		
	  return Arrays.asList(str.split("\\s+")).indexOf(substring)+1;
	  
	}
	
	/**
	 * This method check whether the keyword is exactly contained in the sentence string
	 * e.g. Source - 'This is the text string which contain key words of concept'
	 * 		subtext1 - 'keyword' , subtext2 - 'key word' , subtext3 - 'key words'
	 * 		subtext3 - return true 
	 * @param source One sentence string from transcription
	 * @param subtext The keywords to be string matched against source
	 * @return
	 */
	public static boolean isContain(String source, String subtext){
		
		String pattern = "\\b" +subtext+"\\b";
		Pattern p = Pattern.compile(pattern);
		Matcher m=p.matcher(source);
		return m.find();		
		
	}
}
