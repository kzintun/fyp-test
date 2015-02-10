$('.img-redirect').click(function() { 
	//console.log("CLICKED");
	console.log(this.id);
	var key = this.id;
	
	/*<?php
		$js_array = json_encode($finalResultArray);
		echo "var passArray = ". $js_array . ";\n";
	?>*/
	var passArray = <?php echo json_encode($matchSegmentArray); ?>;
	passArray = passArray[key];
	//var arr = $.map(passArray, function(el) { return el; });
	console.log(passArray);
	//console.log(arr);
	localStorage.setItem("matches", passArray);
	console.log(localStorage.getItem("matches"));
	//this.href="index.php?database="+<?php echo $finalResultArray[$key][0]['collection'];?>="&document="+key;
	//return false; 

});