package xmlIndexLucene;

import java.io.File;
import java.io.IOException;
import java.util.Collections;

import org.apache.lucene.analysis.Analyzer;
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.analysis.util.CharArraySet;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.document.StringField;
import org.apache.lucene.document.TextField;
import org.apache.lucene.index.DirectoryReader;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.IndexWriterConfig;
import org.apache.lucene.queryparser.classic.ParseException;
import org.apache.lucene.queryparser.classic.QueryParser;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.Query;
import org.apache.lucene.search.ScoreDoc;
import org.apache.lucene.search.TopScoreDocCollector;
import org.apache.lucene.store.Directory;
import org.apache.lucene.store.FSDirectory;
import org.apache.lucene.store.RAMDirectory;
import org.apache.lucene.store.SimpleFSDirectory;
import org.apache.lucene.util.Version;

public class sendIndexToLucene {
	 
	File FILES_TO_INDEX_DIRECTORY = new File("F:\\eclipse\\workplace\\xmlIndexLucene\\indexDir");

 public void addToDoc(String id, String word) throws IOException, ParseException {
	  	
	
	  // 0. Specify the analyzer for tokenizing text.
	    //    The same analyzer should be used for indexing and searching
	    StandardAnalyzer analyzer = new StandardAnalyzer(Version.LUCENE_40);

	    // 1. create the indexed
	    //FSDirectory index = new FSDirectory();
	    SimpleFSDirectory d = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY);
	    	
	    IndexWriterConfig config = new IndexWriterConfig(Version.LUCENE_40, analyzer);
	    IndexWriter w = new IndexWriter(d, config);
	    
	    Document doc = new Document();
	    doc.add(new TextField("word", word, Field.Store.YES));

	    // use a string field for ids because we don't want it tokenized
	    doc.add(new StringField("ids", id, Field.Store.YES));
	    w.addDocument(doc);
	    w.close();
	    
	    // display/query the indexed entries
	    //readIndex("aa");
  }
 
 public void readIndex(String querystr) throws ParseException, IOException{
		
	 	// 1. initialize
	 	StandardAnalyzer analyzer = new StandardAnalyzer(Version.LATEST);
	 	
	 	// 1.a. without removing stopwords (not working!)
	 	//Analyzer analyzer1 = new StandardAnalyzer(Version.LUCENE_40, CharArraySet.EMPTY_SET); 
	 	
	 	SimpleFSDirectory ind = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY);
	 	
	 	// 2. query word
	    //String querystr = "photographs";
	    
	    
	    // the "word" arg specifies the default field to use
	    // when no field is explicitly specified in the query.
	    Query q = new QueryParser(Version.LATEST, "word", analyzer).parse(querystr);

	    // 3. search
	    int hitsPerPage = 20;
	    IndexReader reader = DirectoryReader.open(ind);
	    IndexSearcher searcher = new IndexSearcher(reader);
		TopScoreDocCollector collector = TopScoreDocCollector.create(hitsPerPage, true);
		searcher.search(q, collector);
		ScoreDoc[] hits = collector.topDocs().scoreDocs;
	
		// 4. display results
		System.out.println("Found " + hits.length + " hits.");
		System.out.println("\n\t\t----Search Results from Lucene---- \n"+ 
				"Document Name,SegmentID,SpeakerID,sentenceID,starttime	\t	Script\n"+
				"------------------------------------------------------	\t\t------\n");
		for(int i=0;i<hits.length;++i) {
		  int docId = hits[i].doc;
		  Document d = searcher.doc(docId);
		  System.out.println((i + 1) + ". " + d.get("ids").trim() + "\t\t" + d.get("word").trim());
		}
		
	    // reader can only be closed when there
	    // is no need to access the documents any more.
	    reader.close();
 }

  }

