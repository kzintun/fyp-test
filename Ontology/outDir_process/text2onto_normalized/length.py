
path = "/Users/apple/Desktop/text2onto/6/subclassOf.txt"
text = open(path,'r').read().split(', subclass-of')
print len(text)

'''text = open(path,'r').read().split('subclass-of')
output = []
for subclass in text:
	subclass = subclass.rstrip(", ").replace("(","").replace(")","")
	splitSubclass = subclass.split(", ")
	output.append (splitSubclass)
print output'''