// Created on 05 Jan 2015 by JH to allow search within Doc without page refresh
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
 
$('#searchBtn').click(
function() {
	console.log("IN AJAXSEARCH");
	var currentURL = window.location.href;
	var searchField = $('#userSearchInput').val(); 
	var db = getUrlVars()["database"];
	var doc = getUrlVars()["document"];
	var con = "";
	var kw = "";

	var start = searchField.search("{");
	var end = searchField.search("}");

	if (start !== -1) {
		var conceptList = searchField.substring(start+1,end);
		//console.log(conceptList);
		var keywordList = searchField.substring(end+1,searchField.length);
		//console.log(keywordList)
		con = conceptList;
		if (keywordList.trim() != "") {
			kw = keywordList.trim();
		}
		else {
			kw = '';
		}
	}
	else {
		kw = searchField.trim();
		con = null;
	}

	var matches = localStorage.getItem("matches");
	//console.log("PRINTING MATCHES");
	//console.log(matches);
	//var keyword = localStorage.getItem("keyword");

	if (searchField.length === 0) {

		//if (keyword !== null ) {
		//	console.log(localStorage);
		//	kw = keyword;
		//	localStorage.removeItem("keyword");
		//}
		//else {
			if (matches !== null) {
				//if(typeof(matches)==String) 
				matches = JSON.parse(localStorage.getItem("matches"));
				matches = matches.split(",").map(Number);
				magor.magorPlayer.unhighlightMatches(matches);
				localStorage.removeItem("matches");
			}
		
			message="Please enter a query.";
			$('#alertResults').html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
		
			return false;
		//}
	}
	console.log("IN AJAXSEARCH WITH INPUT");
	//var kw = getUrlVars()["keyword"];
	var results = [];
	//console.log(db);
	//console.log(doc);
	//console.log(kw);
	//console.log(searchField);
	var urlSearch = currentURL;
	if (con != "") urlSearch= urlSearch + "&concept=" + con;
	if (kw != "") urlSearch= urlSearch + "&keyword=" + kw;
	//urlSearch = "./controller/searchKeywordInDocument.php";
	results = new Array();
	if (( db != null) && (doc != null )){
		console.log("Bef ajax");
		//console.log(urlSearch);
		if(matches !== null) {
			//console.log(matches);
			matches = JSON.parse(localStorage.getItem("matches"));
			matches = matches.split(",").map(Number);
			//console.log(matches);
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
	        	results = data.trim();
	        	results = results.substring(1,results.length-1);
	        	
	        	//if(data != null) results = results.trim();
	        	
	        	//$( "#test" ).html( data );
	        	console.log("AJAXSEARCH PRINTING RESULTS");
	        	console.log(results);
        		if ((results.length == 0)||(results == null)) {
        			message="No occurence found for <strong>"+searchField+"</strong>, please refine your search.";
	        		$('#alertResults').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
        		}
        		else {
		        	localStorage.setItem("matches", JSON.stringify(results));
		        	//localStorage.setItem("matches",results);
		        	results = results.split(",").map(Number);
		        	message="<strong>"+ results.length +"</strong> occurrence(s) of <strong>" + searchField+"</strong> found in this document.";
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
		var x = document.getElementById('userSearchInput');
		if(localStorage.getItem("input") != undefined) {
			var input = localStorage.getItem("input");
			if (x.value === input) {
				var sstring = input;
				console.log("Using LS");
			}
			else {
				var sstring = x.value;
				console.log("Using Bar");
			}
			var start = sstring.search("{");
			var end = sstring.search("}");

			if (start !== -1) {
				var conceptList = sstring.substring(start+1,end);
				//console.log(conceptList);
				var keywordList = sstring.substring(end+1,sstring.length);
				//console.log(keywordList)
				con = conceptList;
				if (keywordList.trim() != "") {
					kw = keywordList.trim();
				}
				else {
					kw = '';
				}
			}
			else {
				kw = sstring.trim();
				con = null;
			}
			console.log("Printing kw and con below");
			console.log(kw);
			console.log(con);
		}
		else {
			var kw = null;
			var con = null;
		}
		if(localStorage.getItem("cDB") != undefined) {
			var db = localStorage.getItem("cDB");
		}
		else{
			var db = getUrlVars()["database"];
			if (db == null) {
				var db = "all";
			}

		} 
		updateURL(db, kw, con);
	}


});