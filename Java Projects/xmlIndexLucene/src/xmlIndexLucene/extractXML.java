package xmlIndexLucene;

import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.apache.lucene.queryparser.classic.ParseException;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

public class extractXML {

	
	public void extractContent(File xmlFile, String colName) throws ParserConfigurationException, SAXException, IOException, ParseException{	
		
		// TODO Auto-generated method stub
				//	loading sample XML file
				//File xmlFile = new File("NewFile.xml");
				//File xmlFile1 = new File("C:\\Users\\KZT\\Downloads\\AaronHuey_2010X.xml");
				DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
				DocumentBuilder db = dbf.newDocumentBuilder();
				Document doc = db.parse(xmlFile);
				doc.getDocumentElement().normalize();
				int docCount = 0;
				
				//	printing<database> node
				//System.out.println("Root element :" + doc.getDocumentElement().getNodeName());
				
				//	get node with <document> tag
				NodeList nodeLst = doc.getElementsByTagName("document");
				
				//initializing variables
				sendIndexToLucene a = new sendIndexToLucene();
				String docName;
				String segID;
				String speaker;
				String senID;
				String senStartTime= "";
				String wID;
				String tword = null;
				String allIDs = null;
				String tScript = "";
				Map<String, String> newIndexData = new HashMap<String, String>();
				
				//	print output
				//System.out.println("--Information of XML doc--");
				
				//		***	<DOCUMENT>	***
				//	traverse <document> node
				  for (int s = 0; s < nodeLst.getLength(); s++) 
				  {
					  
					  Node fstNode = nodeLst.item(s);
				   
					  if (fstNode.getNodeType() == Node.ELEMENT_NODE) 
					  {
					      Element fstElmnt = (Element) fstNode;
					      docName = fstElmnt.getAttribute("name");
					      
					     // System.out.println("Document name: " + docName);
					     // System.out.println("\n\t\t----Entries to be added to Lucene---- \n"+ 
			    		 //			"Document Name,SegmentID,SpeakerID,sentenceID,starttime	\t	Script\n"+
			    		 // 			"------------------------------------------------------	\t\t------\n");
			    		  		
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
										      
										      //	traverse <word> node
										      for (int j=0; j< fstNmElmntLst.getLength(); j++)
										      {
										    	  Element fstNmElmnt = (Element) fstNmElmntLst.item(j);
										    	  
										    	  //	get wordID
										    	  wID = fstNmElmnt.getAttribute("id");
										    	  
										      	  NodeList fstNm = fstNmElmnt.getChildNodes();
										      	  tword =  ((Node) fstNm.item(0)).getNodeValue();
					
										      	 // System.out.println("\n"+allIDs);
										      	 // System.out.println("Word : Id-" + wID+ "\t Value-" + tword);
										      	  
										      	  //	add to lucene (NOT WORKING !) 
										      	  tScript += tword + " " ;
										      	  
										      }		// end <word> loop
										      newIndexData.put(allIDs, tScript);
										     
										      //	testing
										     //System.out.println(allIDs + "\t\t\t" +tScript);
										      
										      //	adding to lucene (Working !!!)
										      //	NOTE!! : adding the same entry will create a duplicate index 
										      // old method : calling lucene when indexing every sentence
										      //a.addToDoc1(allIDs, tScript, colName);      							      
								      
								      }		//	end <sentence> loop
					      	
					      }		//	end <segment> loop		
					  
					  }		// end if loop
					  
				  	}//	end <document> loop	
				  // Call Lucene to index every sentence at the end of reading the document
				  a.addToDoc1(newIndexData, colName);
	}
}
