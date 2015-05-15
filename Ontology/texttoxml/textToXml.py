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

import xml.etree.cElementTree as ET
import re
import collections
import xml.dom.minidom


with open ('matching2.txt','r') as infile:
    data = infile.read()
my_list = data.splitlines()

root = ET.Element("menuTree")

filename = 'signalprocessing'
link = ET.SubElement(root, "link")
link.set("linkName",my_list[0])
link.set("type","parent")
link.set("parentId","root")
link.set("linkOnClick","appendToSearchBar('%s','%s')" % (my_list[0],filename))
nodeDic = {}
for item in my_list[1:]:
    #matchObj = re.match(r'(\d*)(.*?)\s(.*)',item,re.M|re.I)
    matchObj = re.match(r'(\d*)(([A-Z]\S*\s)*)(.*)',item,re.M)
    
    #print matchObj.group(1)
    #print matchObj.group(2)
    #print matchObj.group(3)
    #print matchObj.group(4)
    #key = matchObj.group(1)
    if matchObj.group(1) != '':
        nodeDic.setdefault(matchObj.group(1),[])
        nodeDic[matchObj.group(1)].append(matchObj.group(2).strip())

    #nodeDic.setdefault(matchObj.group(1),[])
        nodeDic[matchObj.group(1)].append(matchObj.group(4).strip())

nodeDic = collections.OrderedDict(sorted(nodeDic.items()))
#print nodeDic

conceptIndex = []
for item in nodeDic:
    conceptIndex.append(item)
print conceptIndex

for i in range(len(conceptIndex)):
    index = conceptIndex[i]
    if len(index) == 1:
        name = index
        vars()[name] = ET.SubElement(link,"link")
        vars()[name].set("linkName",nodeDic[index][0])
        if i != (len(conceptIndex) - 1):
            if index in conceptIndex[i+1]:
                vars()[name].set("type","parent")
                vars()[name].set("parentId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
            else:
                vars()[name].set("type","child")
                vars()[name].set("childId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
        else:
            vars()[name].set("type","child")
            vars()[name].set("childId",index)
            vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
            vars()[name].text = nodeDic[index][1]

    if len(index) == 2:
        name = index
        vars()[name] = ET.SubElement(vars()[index[0]],"link")
        vars()[name].set("linkName",nodeDic[index][0])
        if i != (len(conceptIndex) - 1):
            if index in conceptIndex[i+1]:
                vars()[name].set("type","parent")
                vars()[name].set("parentId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
            else:
                vars()[name].set("type","child")
                vars()[name].set("childId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
    

    if len(index) == 3:
        name = index
        vars()[name] = ET.SubElement(vars()[index[:2]],"link")
        vars()[name].set("linkName",nodeDic[index][0])
        if i != (len(conceptIndex) -1):
            if index in conceptIndex[i+1]:
                vars()[name].set("type","parent")
                vars()[name].set("parentId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
            else:
                vars()[name].set("type","child")
                vars()[name].set("childId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
        else:
            vars()[name].set("type","child")
            vars()[name].set("childId",index)
            vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
            vars()[name].text = nodeDic[index][1]

    if len(index) == 4:
        name = index
        vars()[name] = ET.SubElement(vars()[index[:3]],"link")
        vars()[name].set("linkName",nodeDic[index][0])
        if i != (len(conceptIndex) -1):
            if index in conceptIndex[i+1]:
                vars()[name].set("type","parent")
                vars()[name].set("parentId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
            else:
                vars()[name].set("type","child")
                vars()[name].set("childId",index)
                vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
                vars()[name].text = nodeDic[index][1]
        else:
            vars()[name].set("type","child")
            vars()[name].set("childId",index)
            vars()[name].set("linkOnClick","appendToSearchBar('%s','%s')" % (((''.join([c for c in nodeDic[index][0] if c.isupper()]))+index),"signalprocessing"))
            vars()[name].text = nodeDic[index][1]

'''name = str(matchObj.group(1))
vars()[name] = ET.SubElement(link, "link")
link0 = ET.SubElement(link, "link")
link0.set("linkName", nodeDic[matchObj.group(1)][0])
link0.set("type","parent")
link0.set("parentId",matchObj.group(1))
link0.text =nodeDic[matchObj.group(1)][1]'''
    
def indent(elem, level=0):
    i = "\n" + level*"  "
    if len(elem):
        if not elem.text or not elem.text.strip():
            elem.text = i + "  "
        if not elem.tail or not elem.tail.strip():
            elem.tail = i
        for elem in elem:
            indent(elem, level+1)
        if not elem.tail or not elem.tail.strip():
            elem.tail = i
    else:
        if level and (not elem.tail or not elem.tail.strip()):
            elem.tail = i

indent(root)
tree = ET.ElementTree(root)
tree.write("signalprocessing.xml")

