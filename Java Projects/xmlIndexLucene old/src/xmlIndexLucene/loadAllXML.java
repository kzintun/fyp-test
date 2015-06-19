package xmlIndexLucene;

import java.io.File;
import java.io.IOException;
import javax.xml.parsers.ParserConfigurationException;
import org.apache.lucene.queryparser.classic.ParseException;
import org.xml.sax.SAXException;

public class loadAllXML {
	
	
	File FILES_TO_INDEX_DIRECTORY = new File("xmlDir");	// change the directory here / point to the directory that contains all XML files
	extractXML exl = new extractXML();
	
	public void loadAllXML() throws ParserConfigurationException, SAXException, IOException, ParseException
	{
		File[] files = FILES_TO_INDEX_DIRECTORY.listFiles();
	
		for (File file : files) {
			System.out.println(file.getName());
			exl.extractContent(file.getAbsoluteFile());
		}
	}
}

