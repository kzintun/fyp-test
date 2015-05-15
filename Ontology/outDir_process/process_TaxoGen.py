"""
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
 * @author Liu Xiao (c) 2015
 """

from __future__ import division
from stemming.porter2 import stem
import re

'''
        process results from taxoGen
'''

''' read FinalTermlist txt to store the concepts TaxoGen extracts to a list '''
#path = "/Users/apple/Desktop/DearFYP/outDir_process/taxogen_normalized/6/FinalTermList.txt"
path = "/Users/apple/Desktop/DearFYP/outDir_process/taxogen_sentence/6/FinalTermList.txt"
with open (path, 'r') as infile:
        data = infile.read()
my_list_concept = data.splitlines()
concept = []
for item in my_list_concept:
        if item.title() not in concept:
                concept.append(item.title())
print "Number of concepts FinalTermlist extracts: %d" %len(concept)

stem_concept = []
for item in concept:
        item = stem(item).title()
        if item not in stem_concept:
                stem_concept.append(item)
print "Number of stemmed concepts FianlTermList extracts: %d" %len(stem_concept)

'''read FinalTaxonomicRelation results from taxoGen and store into a list'''
#path = "/Users/apple/Desktop/DearFYP/outDir_process/taxogen_normalized/6/FinalTaxonomicRelation.txt"
path = "/Users/apple/Desktop/DearFYP/outDir_process/taxogen_sentence/6/FinalTaxonomicRelation.txt"
with open (path,'r') as infile:
	data = infile.read()
my_list_relation = data.splitlines()
print "Number of relationships FianlTaxonomicRelation extract: %d" %len(my_list_relation)

subclass = []
superclass = []
relation_dict = {}
for item in my_list_relation:
	matchObj = re.match (r'(([a-zA-Z0-9]+).*)(>>>)(.*)',item,re.M)
        relation_dict.setdefault(stem(matchObj.group(1)).title(),[])
        relation_dict[stem(matchObj.group(1)).title()].append(stem(matchObj.group(4)).title())

	if matchObj.group(1).title() not in superclass:
		superclass.append(matchObj.group(1).title())
	if matchObj.group(4).title() not in subclass:
		subclass.append(matchObj.group(4).title())

print "Number of superclass FinallTaxonomicRelation extracts: %d" %len(superclass)
#print (superclass)
print "Number of subclass FinalTaxonomicRelation extracts: %d" %len(subclass)
#print "Subclass-of relationships FianlTaxonomicRelation extracts:"
#print relation_dict
print "Number of subclass-of relationships FinalTaxonomicRelation extracts: %d" %len(relation_dict)
#print (relation_dict.keys())


processed_relation_dict = {}
for item in relation_dict:
        if (stem(item) in stem_concept):
                processed_relation_dict.setdefault(item,[])
                processed_relation_dict[item] = relation_dict[item]
        elif ((stem(subitem) for subitem in relation_dict[item]) in stem_concept):
                processed_relation_dict.setdefault(item,[])
                processed_relation_dict[item] = relation_dict[item]
        else:
                continue

print "Number of subclass-of relationships whose superclass or subclass are extracted as concepts (valid subclass-of relationship): %d" %len(processed_relation_dict)
#print processed_relation_dict

path = "/Users/apple/Desktop/dict1.txt"
with open (path, 'r') as infile:
        data = infile.read()

my_list_manual = data.splitlines()
conceptManual = []
for item in my_list_manual:
        if item not in conceptManual:
                conceptManual.append(item.strip().title())

manuallyConceptList = []
for item in conceptManual:
        if (item != ''):
                if item[0].isdigit():
                        matchObj = re.match(r'([0-9]+)((.[0-9]+)?(.[0-9]+)?(.[0-9]+)?)(\s)(.*)',item,re.M|re.I)
                        '''print matchObj.group(1)
                        print matchObj.group(2)
                        print matchObj.group(3)
                        print matchObj.group(4)
                        print matchObj.group(5)
                        #print matchObj.group(6) //space
                        print matchObj.group(7) '''
                        
                        manuallyConceptList.append(matchObj.group(7).title())

print "Number of concepts in manual concept tree: %d" %len(manuallyConceptList)

matchedConcept = []

for item in manuallyConceptList:
        if (stem(item).title()) in stem_concept:
                matchedConcept.append(item)
        elif (stem(item).title()) in processed_relation_dict.keys():
                matchedConcept.append(item)
        elif (stem(item).title()) in processed_relation_dict.values():
                matchedConcept.append(item)
print "Concepts in manual tree that are also extracted by TaxoGen: "
print matchedConcept
print "Number of mathed concepts: %d" %len(matchedConcept)

NumberOfValidConcepts = len(processed_relation_dict)
for item in processed_relation_dict:
        NumberOfValidConcepts += len(processed_relation_dict[item]) 
print "Number of valid concepts Taxogen extracts: %d" %(NumberOfValidConcepts)

recall_taxoGen = len(matchedConcept) / len(manuallyConceptList)
precision_taxoGen = len(matchedConcept) / NumberOfValidConcepts
print "Recall Value (NO. of matched concepts / total NO. of concepts in manual tree): %f" %recall_taxoGen
print "Precision Value (No. of matched concepts / total NO. concepts extracted by Taxogen): %f" %precision_taxoGen


