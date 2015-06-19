#!/usr/bin/python
# -*- coding: utf-8 -*-
import argparse
import os
import time
import xml.etree.ElementTree as ET
from pprint import pprint
from os import path
import sys
import wordcloud
from nltk.corpus import stopwords
stop = stopwords.words('english')
[stop.append(x) for x in ['okay','...','yeah', 'well','ok','okay','actually','<UNK>' , 'UNK','point','eight','eighteen','eighty','eleven','fifteen','fifty','five','forty','four','fourteen','hundred','nine','nineteen','ninety','one','seven','seventeen','seventy','six','sixteen','sixty','ten','thirteen','thirty','thousand','three','twelve','twenty','two','zero']]

# ================================================================== #
def produceWordCloud(inputText, outputPng):
	words = wordcloud.process_text(inputText, max_features=400)
	elements = wordcloud.fit_words(words, width=800, height=500)
	wordcloud.draw(elements, outputPng, width=800, height=500, scale=2)

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
	return " ".join([i for i in text if i not in stop])

# ================================================================== #

def loadDatabase(xmlFileName):
	'''
	input : xml file
	output: xml tree object
	descr : load xml tree
	'''
	if not os.path.exists(xmlFileName):
		print "the xml file does not exists, exiting"
		exit()		
	elif os.path.exists(xmlFileName):
		print('Using existing base ' + xmlFileName )
		xmlTree = ET.parse(xmlFileName)
		root = xmlTree.getroot()
		return root
	return -1

# ============================================================= #

if __name__ == "__main__":
	'''
	inputs:  rttm asr, rttm story seg, video file , xml file 
	outputs: create or update XML file 
	'''
	parser = argparse.ArgumentParser(description='Produce an image for a xml file.')
	parser.add_argument('--xmlFile',    dest='xmlFile',   required=True,default=None , help='provide a XML file to update')
	args = parser.parse_args()

	nameRoot = args.xmlFile.split('.xml')[0]	
	pngFile  = nameRoot + '.png'
	
	xmlTree = loadDatabase(args.xmlFile)
	text    = getText(xmlTree)
	cleanedText = getCleanedText(text)
	produceWordCloud(cleanedText, pngFile)
	print "==== done ==== "

# =============================================================== #
