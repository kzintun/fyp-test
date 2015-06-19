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

//<-----------------------------------3. Write to XML ---------------------------------------------------->
//Retrieve <concept,metada> and write them out to XML which will be used for concept-search in Lectssearch

import java.io.*;

import org.jdom2.Attribute;
import org.jdom2.Document;
import org.jdom2.Element;
import org.jdom2.output.Format;
import org.jdom2.output.XMLOutputter;

import com.google.common.collect.Multimap;

import java.awt.Window.Type;
import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.TreeMap;



public class writeConceptToXML {
	
	
	public static void main(String[] args) throws IOException{
		
	}

	public static void writeoutToXML(Multimap<String, String> hMap) throws IOException{
		
		try {
			 
				Element data = new Element("conceptList");
				Document doc = new Document(data);
				
				
				for (String str : hMap.keySet()) {
					
					Element concept = new Element ("concept");
					concept.setAttribute(new Attribute("name", str));
					concept.setAttribute(new Attribute("id", str));
					concept.setAttribute(new Attribute("collection", "signalprocessing"));
					
					doc.getRootElement().addContent(concept);
				
			    	for (String mapValue : hMap.get(str)){
			    		String[] array = mapValue.split(",");
			    		concept.addContent(new Element("keyword").setAttribute("docName", array[0])
			    												 .setAttribute("segID", array[1])
			    												 .setAttribute("spkID",array[2])
																 .setAttribute("senID", array[3])
																 .setAttribute("startTime", array[4])
																 .setAttribute("startWID", array[5])
																 .setAttribute("endWID", array[6])
																 //.setAttribute("concept", str) array[7] = collection name
																 .setAttribute("text", array[8])
																	);
			    		
			  
			        }
			    }
				
				
				;
				XMLOutputter xmlOutput = new XMLOutputter();
		 
				// display nice nice
				xmlOutput.setFormat(Format.getPrettyFormat());
				// Specify the path to save the newly created concept XML
				xmlOutput.output(doc, new FileWriter("./conceptDir/signalprocessing.xml"));
		 
				System.out.println("File Saved!");
			  } catch (IOException io) {
				System.out.println(io.getMessage());
			  }
	}
	
}
