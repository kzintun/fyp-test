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

// <--------------------------------- Main Class ----------------------------------------->
// Run this to perform concept annotation processing and generate an XML for concept Search

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collection;
import java.util.Collections;
import java.util.Comparator;
import java.util.Set;
import java.util.List;

import javax.xml.parsers.ParserConfigurationException;

import org.xml.sax.SAXException;

import com.google.common.collect.ArrayListMultimap;
import com.google.common.collect.Multimap;

public class loadConceptfrmXML {
	
	// change the directory here / point to the directory that contains all XML files
	//static File FILES_TO_INDEX_DIRECTORY = new File("xmlDir");	
	static extConceptfrmXML exl = new extConceptfrmXML();
	static ConceptTextToMap smv = new ConceptTextToMap();
	static writeConceptToXML wtx = new writeConceptToXML();
	Multimap<String, String> multiMapz = ArrayListMultimap.create();

	
	public static void main(String[] args) {
		try {
			final File folder = new File("./xmlDir/");
			ArrayList<String> fdl = listFilesForFolder(folder);
			
			//for (int i=0; i<fdl.size() ; i++){
			//	System.out.println("Folder: " +fdl.get(i));
			//	loadAllXML(fdl.get(i));
			//}
			// Currently testing on Signal Processing Concept Annotation
			loadAllXML("signalprocessing");
			
			//System.out.println("\n\nSuccessfully indexed all documents under the folders: " + fdl.toString());
		} catch (ParserConfigurationException | SAXException| IOException e) {
			// TODO Auto-generated catch block
			((Throwable) e).printStackTrace();
		}
	}
	public static void loadAllXML(String collectionName) throws ParserConfigurationException, SAXException, IOException
	{
		String newPath= "./xmlDir/"+collectionName;
		Multimap cncMap = ConceptTextToMap.getConcept();
		
		File FILES_TO_INDEX_DIRECTORY= new File(newPath);
		if (FILES_TO_INDEX_DIRECTORY.exists())
		{
			File[] files = FILES_TO_INDEX_DIRECTORY.listFiles();
		
			int docCount = 0;
			
			System.out.println("\nCollection: "+ collectionName + "\nProcessing the following XML(s):\n");
			
			for (File file : files) {
				System.out.println("Name: " +file.getName() + " File path: " + file.getAbsoluteFile());
				exl.extractContent(file.getAbsoluteFile(),collectionName, cncMap);
				System.out.println("\t Done !");
				docCount++;
			}
			System.out.println("\n"+ docCount + " XML Document(s) added.\n\n");
			
			Multimap finalCncMap = exl.getMapToWriteXML(); 				// retrieve multimap with <concept, metadata of sentence transcript> pairs
			
			// --							Testing Block								-- //
			BufferedWriter bufferedWriter = new BufferedWriter(new FileWriter("temp.txt"));
			Set<String> keys = finalCncMap.keySet(); 
	        // iterate through the key set and display key and values
	        for (String key : keys) {
	        	bufferedWriter.write("Concept = " + key);
	            bufferedWriter.newLine();
	            bufferedWriter.write("Keyword = " + finalCncMap.get(key) + "\n");
	            bufferedWriter.newLine();
	        }
	        // --							Testing Block								-- //
	        
	        wtx.writeoutToXML(finalCncMap);
		}
		else
			System.out.println("Directory " + "does not exisit");
	}
	
	public static ArrayList<String> listFilesForFolder(final File folder) {
		ArrayList <String> folderList = new ArrayList();
	    for (final File fileEntry : folder.listFiles()) {
	        if (fileEntry.isDirectory()) {
	        	folderList.add (fileEntry.getName());
	        
	           //System.out.println( fileEntry.getName());
	        } 
	    }
		return folderList;
	}
}

