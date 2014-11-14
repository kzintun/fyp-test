package xmlIndexLucene;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import javax.xml.parsers.ParserConfigurationException;

import org.apache.lucene.queryparser.classic.ParseException;
import org.xml.sax.SAXException;

public class loadAllXML {
	
	// change the directory here / point to the directory that contains all XML files
	//static File FILES_TO_INDEX_DIRECTORY = new File("xmlDir");	
	static extractXML exl = new extractXML();
	
	public static void main(String[] args){
		try {
			final File folder = new File("./xmlDir/");
			ArrayList<String> fdl = listFilesForFolder(folder);
			
			for (int i=0; i<fdl.size() ; i++){
				System.out.println("Folder: " +fdl.get(i));
				loadAllXML(fdl.get(i));
			}
			System.out.println("\n\nSuccessfully indexed all documents under the folders: " + fdl.toString());
		} catch (ParserConfigurationException | SAXException| IOException
				| ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	public static void loadAllXML(String collectionName) throws ParserConfigurationException, SAXException, IOException, ParseException
	{
		String newPath= "./xmlDir/"+collectionName;
		
		File FILES_TO_INDEX_DIRECTORY= new File(newPath);
		if (FILES_TO_INDEX_DIRECTORY.exists())
		{
			File[] files = FILES_TO_INDEX_DIRECTORY.listFiles();
			int docCount = 0;
			
			System.out.println("\nCollection: "+ collectionName + "\nProcessing the following XML(s):\n");
			
			for (File file : files) {
				System.out.print("Name: " +file.getName() + " File path: " + file.getAbsoluteFile());
				exl.extractContent(file.getAbsoluteFile(),collectionName);
				System.out.println("\t Done !");
				docCount++;
			}
			System.out.println("\n"+ docCount + " XML Document(s) added.\n\n");
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

