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

from __future__ import print_function
import glob
import os
from pyPdf import PdfFileReader
from stemming.porter2 import stem
import processText
import operator
import re

''' get a list of file names of all pdf/txt files
    @ param dirPath: directory path of the pdf/txt file folder
    @ return list of file names of corresponding format text files 
'''
#dirPath = "/Users/apple/Desktop/DearFYP/processText/data/docs/pdf"
def listFileNames(dirPath):
      fileNames = []
      os.chdir (dirPath)
      #for file in glob.glob("*.txt"):
      for file in glob.glob("*.pdf"):
            fileNames.append(file)
      return fileNames


''' get a dictionary of lecture index(from 1) and title
    @ param dirPath: directory path of the pdf/txt file folder
    @ return a dictionary of lecture index and title
      e.g. 1: u'Lecture 1: Introduction', 2: u'Lecture 10: Discrete-time Fourier series'
'''
def extractTitle(dirPath):
      fileTitles = {}
      fileName = listFileNames (dirPath)
      for index in range (len(fileName)):
            inputPdf = PdfFileReader(file("%s/%s" % (dirPath, fileName[index]),'rb'))
            fileTitles.setdefault(index+1,'')
            fileTitles[index+1] = inputPdf.getDocumentInfo().title
      return fileTitles

''' extract concepts from titles 
    @ param dirPath: directory path of the pdf file folder
    @ return a dictionary with concepts and their subconcepts
'''
def extractTitleKeywords(dirPath):
      fileTitle = extractTitle(dirPath)
      titleList = fileTitle.values()
      ''' step1: remove all the stop words in the titles '''
      stop_word_file_path = "/Users/apple/Desktop/DearFYP/processText/titleStoplist.txt"
      stopword_pattern = processText.build_stop_word_regex(stop_word_file_path)
      tem_titleKeywords = processText.generate_phrases(titleList,stopword_pattern)
      titleKeywordsList = []
      for index in range (len(tem_titleKeywords)):
                          keyword = re.sub(r'\d*','',tem_titleKeywords[index]).replace(':','')
                          titleKeywordsList.append(keyword.strip())
      print (titleKeywordsList)
      ''' step2: extract the titles that only have one word after removing stop words as concept to be stored in concept list''' 
      concept = []
      subclassOf = {}
      concept_stem = {}
      for keywords in titleKeywordsList:
        if len(keywords) == 0:
          titleKeywordsList.remove(keywords)
        else:
          matchObj = re.match(r'(\S*)(.*)',keywords,re.M)
          if len(matchObj.group(2)) == 0:
            concept.append(matchObj.group(1).title())
            subclassOf.setdefault(matchObj.group(1).title(),[])
            concept_stem.setdefault(stem(matchObj.group(1)).title(),'')
            concept_stem[stem(matchObj.group(1)).title()] = matchObj.group(1).title()
      remain_titleKeywordsList0 = list(set(titleKeywordsList)-set(concept))

      ''' step3: extract titles that contains the concept extracted from single word titles as sub-concept'''
      sub_concept = []
      for title in remain_titleKeywordsList0:
        stem_title0 = [stem(titleKeywords).title() for titleKeywords in title.split(" ")]      
        for keywords in stem_title0:
          if keywords in concept_stem.keys():
            subclassOf[concept_stem[keywords]].append(title)
            sub_concept.append(title)
      remain_titleKeywordsList1 = list(set(remain_titleKeywordsList0)-set(sub_concept))

      ''' step4: single word processing: 
        1)calculate word score of all the words considering frequency and word_position'''
      word_frequency = processText.calculate_word_scores(titleKeywordsList)
      word_position = processText.calculate_word_position(titleKeywordsList)
      word_scores = {}
      for word in word_frequency:
        word_scores.setdefault(word,0)
        word_scores[word] = word_frequency[word] + word_position[word]
      sortedScores0 = sorted(word_scores.iteritems(),key=operator.itemgetter(1),reverse=True)
      '''
        2)extract the words with high score as concepts and find their subconcepts''' 
      threshold = 8.0
      remain_titleKeywordsList = remain_titleKeywordsList1
      sortedScores = sortedScores0
      for item in sortedScores:
        if (stem(item[0].title()) not in concept_stem.keys()) and item[1] >= threshold:
          concept.append(item[0].title())
          print (item)
          subclassOf.setdefault(item[0].title(),[])
          concept_stem.setdefault(stem(item[0]).title(),'')
          concept_stem[stem(item[0]).title()] = item[0].title()
  
          for title in remain_titleKeywordsList:
            stem_title1 = [stem(titleKeywords).title() for titleKeywords in title.split(" ")]
            for keywords in stem_title1:
              if keywords in (stem(item[0]).title()):
                subclassOf[item[0].title()].append(title)
                sub_concept.append(title)
                remain_titleKeywordsList = list(set(remain_titleKeywordsList1)-set(sub_concept))
          word_frequency = processText.calculate_word_scores(remain_titleKeywordsList)
          word_position = processText.calculate_word_position(remain_titleKeywordsList)
          for word in word_frequency:
            word_scores.setdefault(word,0)
            word_scores[word] = word_frequency[word] + word_position[word]
          sortedScores = sorted(word_scores.iteritems(),key=operator.itemgetter(1),reverse=True)
      
      return subclassOf#sub_concept#concept_stem,concept,word_scores,sortedScores,titleKeywordsList,remain_titleKeywordsList0,remain_titleKeywordsList1,#,sortedWord_score

''' write the dictionary to a text file with the index of each concept
    @ param relationDict: dictionary got from concept extraction from titles 
    @ return a text file in the same folder of the pdf files 
'''
def writetotxt(relationDict):
      with open("dict1.txt","w") as myfile:
        list_keys = relationDict.keys()
        for i in range (len(list_keys)):
          myfile.write('%d' %i)
          myfile.write('\n')
          myfile.write(list_keys[i])
          myfile.write('\n')
          for j in range (len(relationDict[list_keys[i]])):
            myfile.write('%d%d' %(i,j))
            myfile.write('\b'+relationDict[list_keys[i]][j])
            myfile.write('\n') 
          
         
            

      
      
