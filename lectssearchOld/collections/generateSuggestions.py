#!/usr/bin/python
# -*- coding: utf-8 -*-
#WRITTEN BY JH TO GENERATE SUGGESTION XML
from string import punctuation
from itertools import tee, islice
from collections import Counter
import re
import argparse
import os
import time
import xml.etree.ElementTree as ET
from pprint import pprint
from os import path
import sys
from nltk.util import ngrams
from nltk.tag import pos_tag


from nltk.corpus import stopwords
stop = stopwords.words('english')
[stop.append(x) for x in ['okay','...','yeah', 'well','ok','okay','actually','<UNK>' ,
'UNK','point','eight','eighteen','eighty','eleven','fifteen','fifty','five','forty',
'four','fourteen','hundred','nine','nineteen','ninety','one','seven','seventeen',
'seventy','six','sixteen','sixty','ten','thirteen','thirty','thousand','three',
'twelve','twenty','two','zero', 'is', 'said', 'are', 'was', 'be', 'has', 'have',
'will', 'says', 'would', 'were', 'had', 'been', 'could', "'s", 'can', 'do', 'say', 'may',
'did', 'made', 'does', 'should', 'shall', 'talk', 'get', 'might', 'know', 'going', 'think',
'thought', 'though', "don't", "can't", "shouldn't", "wouldn't", "weren't", "ain't", "isn't",
'this', 'there', 'here', 'what', 'where', 'when', 'how', "i'll", "i'm", "it's", "that's", "there's",
'with', "here's", "there're", "there's", "the", "you", "u.", "k.", "s.", "a.", "today", "so", "who's"]]

# ================================================================== #

def getDocList(xml):
    docList = list()

    for doc in xml.findall("document"):
        #print doc.attrib['xref']
        docList.append(doc.get('xref'))
    return docList

# ================================================================== #

def getText(xml):
	text = list()

	for cont in xml.findall("content"):
		for seg in cont.findall("segment"):
			for sent in seg.findall("sentence"):
				for word in sent.findall("word"):
					text.append(word.text)
	return text

# ================================================================== #

def getCleanedText(text):
	return " ".join([i for i in text if i.lower() not in stop])

# ================================================================== #

def getNNP(text):
    textList = []
    if (type(text) != list):
        print "Cutting"
        textList = text.split()
    else:
        textList = text
    tagged_sent = pos_tag(textList)
    propernouns = [word for word,pos in tagged_sent if pos == 'NNP' or pos == "NN"]
    #print propernouns
    return propernouns

# ================================================================== #

def loadDatabase(xmlFileName):
	'''
	input : xml file
	output: xml tree object
	descr : load xml tree
	'''
	if not os.path.exists(xmlFileName):
		print "the xml file does not exists, exiting"
		return -1
	elif os.path.exists(xmlFileName):
		print('Using existing base ' + xmlFileName )
		xmlTree = ET.parse(xmlFileName)
		root = xmlTree.getroot()
		return root
	return -1

# ============================================================= #

def sort_items(x, y):
    """Sort by value first, and by key (reverted) second."""
    return cmp(x[1], y[1]) or cmp(y[0], x[0])

# ============================================================= #

def generateWordList(text):
    wordList = []
    for word in text:
        word.strip(punctuation).lower()
        wordList.append(word)
    return wordList

# ============================================================= #

def addCount(xgrams):
    words = {}
    for gram in xgrams:
        words[gram] = words.get(gram, 0) + 1
    return words

# ============================================================= #

def sortAndCmp(aDict, N):
     top_words = sorted(aDict.iteritems(), cmp=sort_items, reverse=True)[:N]
     return top_words


# ============================================================= #

def printToConsole(sortedWords):
    for grams, frequency in sortedWords:
        if (frequency > 1):
            print "%s: %d" % (grams, frequency)


# ============================================================= #

def remove1freq(sortedWords):
    cleanedSortedWords = [(grams, frequency) for (grams, frequency) in sortedWords if frequency > 1]
    return cleanedSortedWords


# ============================================================= #

def writeToXML(collectionName, sugName, docName, cleanedSortedWords):
    sugLoc = "../suggestionDir/" + sugName
    #suggestionXMLFileName = "suggestions.xml"

    if not os.path.exists(sugLoc):
        root = ET.Element("root")

    else:
        root = loadDatabase(sugLoc)
        if root == -1:
            return -1;

    #suggestions = ET.SubElement(root, "suggestion")
    #collections = ET.SubElement(suggestions, "collection")
    #occurrences = ET.SubElement(collections, "occurrence")

    for grams, frequency in cleanedSortedWords:
        wordString = ' '.join(grams)
        wordCount = str(frequency)
        print 'suggestion[@name="'+wordString+'"]'
        suggestion = root.findall('./suggestion[@name="'+wordString+'"]')
        if suggestion:
            print "EXISTING SUGGESTION FOUND"
            totalCount = int(suggestion[0].get('total'))
            collection = suggestion[0].findall('./collection[@db="'+collectionName+'"]')
            if not collection:
                print "COLLECTION FOUND"
                collections = ET.SubElement(suggestion[0], "collection", db=collectionName, subtotal=wordCount)
                occurrences = ET.SubElement(collections, "occurrence", document=docName, count=wordCount)
                totalCount += frequency
                suggestion[0].attrib["total"] = str(totalCount)
            else:
                subtotal = int(collection[0].get('subtotal'))
                occurrence = collection[0].findall('./occurrence[@document="'+docName+'"]')
                if occurrence:
                    for o in occurrence:
                        wrongCount = int(o.get('count'))
                        subtotal -= wrongCount
                        totalCount -= wrongCount
                        collection[0].remove(o)
                occurrences = ET.SubElement(collection[0], "occurrence", document=docName, count=wordCount)
                subtotal += frequency
                totalCount += frequency
                suggestion[0].attrib["total"] = str(totalCount)
                collection[0].attrib["subtotal"] = str(subtotal)

                #document = collection.findall('occurrence [@document='+docName+']')

        else:
            print "NO EXISTING SUGGESTION FOUND"
            suggestions = ET.SubElement(root, "suggestion", name=wordString, total=wordCount)
            collections = ET.SubElement(suggestions, "collection", db=collectionName, subtotal=wordCount)
            occurrences = ET.SubElement(collections, "occurrence", document=docName, count=wordCount)

    tree = ET.ElementTree(root)
    tree.write(sugLoc, encoding='utf-8', xml_declaration=True)


# ============================================================= #


if __name__ == "__main__":
    '''
    inputs:  collection list XML
    outputs: create or update suggestion XML
    '''
    parser = argparse.ArgumentParser(description='Produce an image for a xml file.')
    parser.add_argument('--colFile',    dest='xmlFile',   required=True,default=None , help='provide a col file to read')
    parser.add_argument('--sugFile',    dest='sugFile',   required=True,default=None , help='provide a XML file to update')
    args = parser.parse_args()

    collectionName = args.xmlFile.split('.xml')[0]
    sugName = args.sugFile
    #collectionName = "signalprocessing"
    #pngFile  = nameRoot + '.png'

    collectionTree = loadDatabase(args.xmlFile)
    if collectionTree == -1:
        exit();
    documentList = getDocList(collectionTree)

    N = 30
    for docLoc in documentList:

        docLoc = "../" + docLoc
        docName = docLoc[13:-4]
        xmlTree = loadDatabase(docLoc)
        if xmlTree == -1:
            continue
        text = getText(xmlTree)
        #print text
        cleanedText = getCleanedText(text)
        noun = getNNP(cleanedText)
        wordList = generateWordList(noun)
        #print wordList
        #up to trigrams for current implementation, can be changed in for loop
        for gram in range(1,4):
            words = {}
            x_grams = ngrams(wordList, gram)
            words = addCount(x_grams)

            sortedWords = sortAndCmp(words, N)
            cleanedSortedWords = remove1freq(sortedWords)

            if not cleanedSortedWords:
                continue

            print "\nPRINTING %d-GRAMS" % gram

            printToConsole(cleanedSortedWords)
            writeToXML(collectionName, sugName, docName, cleanedSortedWords)

    print "==== done ==== "


# =============================================================== #
