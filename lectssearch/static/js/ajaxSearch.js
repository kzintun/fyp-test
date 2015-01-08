// Created on 05 Jan 2015 by JH to allow search within Doc without page refresh
$('#searchBtn').click(function () {
	var currentURL = window.location.href;
	var searchField = $('#userSearchInput').val(); 
	var db = getUrlVars()["database"];
	var doc = getUrlVars()["document"];
	var kw = searchField;
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
		//console.log("Bef ajax");
		//console.log(urlSearch);
		$.ajax({
	        url: urlSearch,
	        type: 'POST',
	        success: function(data){
	        	//alert("HERE!");
	        	results = data;
	        	
	        	//$( "#test" ).html( data );
	        	//console.log(data);
	        	console.log(results);
	        	magor.magorPlayer.highlightMatches(results);
	        },
	        dataType:'json'
	        
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
		updateURL();
	}




});