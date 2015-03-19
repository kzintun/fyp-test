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

