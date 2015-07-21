// Created on 05 Jan 2015 by JH to allow search within Doc without page refresh
$('#searchBtn').click(
function() {
	console.log("IN AJAXSEARCH");
	var currentURL = window.location.href;
	var searchField = $('#userSearchInput').val(); 
	var db = getUrlVars()["database"];
	var doc = getUrlVars()["document"];
	var kw = searchField;
	var matches = localStorage.getItem("matches");
	var keyword = localStorage.getItem("keyword");

	if (kw.length === 0) {

		if (keyword !== null ) {
			console.log(localStorage);
			kw = keyword;
			localStorage.removeItem("keyword");
		}
		else {
			if (matches !== null) {
				matches = JSON.parse(matches);
				magor.magorPlayer.unhighlightMatches(matches);
				localStorage.removeItem("matches");
			}
		
			message="Please enter a query.";
			$('#alertResults').html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
		
			return false;
		}
	}
	//console.log("IN AJAXSEARCH GOT INPUT");
	//var kw = getUrlVars()["keyword"];
	var results = [];
	//console.log(db);
	//console.log(doc);
	//console.log(kw);
	//console.log(searchField);
	urlSearch = currentURL + "&keyword=" + kw;
	//urlSearch = "./controller/searchKeywordInDocument.php";
	results = new Array();
	if (( db != null) && (doc != null )){
		console.log("Bef ajax");
		//console.log(urlSearch);
		if(matches !== null) {
			console.log("IN");
			matches = JSON.parse(matches);
			magor.magorPlayer.unhighlightMatches(matches);
			localStorage.removeItem("matches");
			matches = localStorage.getItem("matches");
			console.log(matches);
		}
		$.ajax({
	        url: urlSearch,
	        type: 'POST',
	        success: function(data){
	        	//alert("HERE!");
	        	results = data;
	        	
	        	//$( "#test" ).html( data );
	        	console.log("PRINTING RESULTS");
	        	console.log(results);
        		if (results.length == 0) {
        			message="No occurence found for <strong>"+kw+"</strong>, please refine your search.";
	        		$('#alertResults').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
        		}
        		else {
		        	localStorage.setItem("matches", JSON.stringify(results));
		        	message="<strong>"+ results.length +"</strong> occurrence(s) of <strong>" + kw+"</strong> found in this document.";
		        	$('#alertResults').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
		        	magor.magorPlayer.highlightMatches(results);
	        	}
	        }
	        //dataType:'json'
	        
	    });

	  	//console.log(results);
	  	return false;
	    //console.log("Out of ajax");
	    //request.done(function( data ) {
		//	$( "#test" ).html( data );
		//});
		//var matches
		//if( results != null ){
		//	var matches =  results.join(",");
		//}
	   // console.log(matches);
	    //magor.magorPlayer.highlightMatches(matches);

        
	}
	else {
		console.log("changing page");
		if(localStorage.getItem("input") != undefined) {
			var kw = localStorage.getItem("input");
		}
		else var kw = null;
		if(localStorage.getItem("cDB") != undefined) {
			var db = localStorage.getItem("cDB");
		}
		else var db = "all";
		updateURL(db, kw);
	}


});