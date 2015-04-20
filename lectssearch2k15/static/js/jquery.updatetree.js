/*
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
 * @author Ong Jia Hui (c) 2015
 */
 
(function($){ 
	// Written by JH to update the concept Tree with count of documents
	$.fn.updateTree = function(treeArray, selectedDoc) {
		//console.log(treeArray);
		//var updatingNode = null;
		if(treeArray) {
			updateZero(treeArray);
			for (topic in treeArray){
				var node = treeArray[topic];
				//console.log(topic);
				
				if(selectedDoc == null) {
					//console.log("NO doc");
					var sum = 0;
					for (doc in node) {
						//var count = node[doc];
						sum++;
					}
					updateTopic(topic, sum);
				}
				else {
					//console.log("HAVE doc");
					var sum = 0;
					for (doc in node) {
						if (doc == selectedDoc) {
							sum = node[selectedDoc];
							console.log(topic + " "+sum);
							
						}
					}
					updateTopic(topic, sum);
				}
				
				//console.log(updatingNode);
				
				//console.log("UPDATE SECOND");
				
				
				
			}
		}
		else console.log("OUT");

		function updateTopic(topic, sum) {
			var updatingNode = document.getElementById(topic);
			var text = " (" + sum + ")";
			//console.log(topic + text);
			if(updatingNode != null) updatingNode.innerHTML += text;	

		}
		
		function updateZero(treeArray) {
			var x = document.getElementsByClassName("nodeLink");
			var zeroText = " (0)";
			for (var i = 0; i < x.length; i++) {
				var nodeId = x[i].getAttribute('id');
				//console.log(nodeId);
				if(!(nodeId in treeArray)) {
					// console.log(nodeId + " empty");
					var node = document.getElementById(nodeId);
					//console.log(node);
					node.innerHTML += zeroText;
				}
			}
		}
		function updateAgain(tries) {
			console.log("Updating Concept Tree Again, try: " + tries);
			$('#xmlMenuTree').updateTree(treeArray,doc,tries);
		}

	}
})(jQuery);

