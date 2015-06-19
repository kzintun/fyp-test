#!/usr/bin/python
# -*- coding: utf-8 -*-
import argparse, os, time
import xml.etree.ElementTree as ET
# ================================================================== #
def loadDatabase(xmlFileName):
	'''
	input : xml file
	output: xml tree object
	descr : load or intialize xml tree
	'''
	if not os.path.exists(xmlFileName):
		print('new text database will be created in ' + os.path.basename(xmlFileName))
		builder = ET.TreeBuilder()
		builder.start('collection', {'name': os.path.basename(xmlFileName).split('.xml')[0], 'date': time.strftime("%d/%m/%Y")})
		builder.end('collection')
		root = builder.close()
		return root
		
	elif os.path.exists(xmlFileName):
		print('Using existing base ' + os.path.basename(xmlFileName) )
		xmlTree = ET.parse(xmlFileName)
		root = xmlTree.getroot()
		return root
	return -1

# ================================================================== #
def loadDocument(xmlFileName):
	'''
	input : xml file
	output: xml tree object
	descr : load xml tree
	'''
	#~ if not os.path.exists(xmlFileName):
	#~ print "the xml file does not exists, exiting"
	#~ exit()		
	#~ elif os.path.exists(xmlFileName):
	print('Using existing base ' + xmlFileName )
	xmlTree = ET.parse(xmlFileName)
	root = xmlTree.getroot()
	return root
	#~ return -1

# ================================================================== #
def loadList(f):
	if os.path.exists(f):
		fin = open(f, 'r')
		l = fin.readlines()
		ll = list()
		for i in l:
			ll.append(i.rstrip())
		fin.close()
		return ll
	else:
		return 0 
# ================================================================== #
def updateXml(xmlTree, listOfDoc,databaseName):
	docs = loadList(listOfDoc)
	docList = list()
	for docName in docs:
		for x in xmlTree.findall('document'):
			docList.append(x.get('name'))


		if docName not in docList:
			print '====> adding ' + docName + ' to the collection'
			xmlDoc = loadDocument('../lectssearchBB/documents/' + docName + '.xml')
			for x in xmlDoc.findall('content'):
				xmlDoc.remove(x)
			document = xmlTree.append(xmlDoc)
			
			currentPath = os.getcwd()
			os.chdir( '../lectssearchBB')
			print os.getcwd()
			print '=====> indexing the keywords in the collection'
			command = 'java -jar indexDoc.jar' +  ' ./documents/' + docName + '.xml' + ' ' +  databaseName
			os.system(command)
			print command
			os.chdir( currentPath)
			print os.getcwd()

			
	return xmlTree
# ============================================================= #
if __name__ == "__main__":
	'''
	inputs:  rttm asr, rttm story seg, video file , xml file 
	outputs: create or update XML file 
	TODO: update one input
	'''
	parser = argparse.ArgumentParser(description='Produce an image for a xml file.')
	parser.add_argument('--list',    dest='listFile',   required=True,  default=None , help='list of documents composing the collection')
	parser.add_argument('--xml',    dest='xmlFile',   required=False, default=None , help='list of documents composing the collection')
	args = parser.parse_args()

	rootName = args.listFile.split('.lst')[0]
	databaseName = os.path.basename(rootName)
	if args.xmlFile == None:
		args.xmlFile = rootName + '.xml'

	xmlTree         = loadDatabase(args.xmlFile)
	xmlTreeUpdated  = updateXml(xmlTree, args.listFile, databaseName)
	tree            = ET.ElementTree(xmlTreeUpdated)
	tree.write(args.xmlFile)
		



