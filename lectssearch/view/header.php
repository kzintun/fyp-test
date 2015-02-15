<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Lects Search</title>
		<link rel="shortcut icon" href="./img/default/favicon.png" />



		<link href="./static/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="./static/css/bootstrap.min.css" rel="stylesheet" media="screen"/>
		<link href="./static/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
		<link href="./static/css/video-js.min.css" rel="stylesheet"  />
		<link href="./static/css/font-awesome.min.css" rel="stylesheet"  />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="./static/css/xmltree.css" type="text/css" media="screen" />


		<link href="./static/css/style.css" rel="stylesheet" type="text/css" />



		<!-- <link href="./static/css/style.css"  rel="stylesheet" type="text/css" />
		<link href="./static/css/styles.css"  rel="stylesheet" type="text/css" />
		<link href="./static/css/speaker-info.css"  rel="stylesheet" type="text/css" />
		<link href="./static/libs/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="./static/css/bootswatch/readable-2.3.1.min.css" rel="stylesheet" />
		<link href="./static/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> -->
	</head>
	<body>



		<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
			<div class="container">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span><span class="icon-bar"></span>
						<span class="icon-bar"></span></button>
						<a class="navbar-brand" href="index.php">
							<img class="lsicon" alt="logo" src="./img/default/logo.png"/>
							Lects Search
						</a>
					</div>
				<!-- /.container-fluid --></div>
				</div>
		</nav>

		<script type="text/javascript">
		<!-- To pass in search text into URL-->
		function updateURL1(){
			var currentURL = window.location.href;
			var userInput = document.getElementById('userSearchInput').value;
			//alert(currentURL);

			if (currentURL.search("document=")>-1) {
				currentURL = currentURL.substring(0, currentURL.search("document=")-1);
			}
			if (currentURL.search("keyword=")>-1) {
				currentURL = currentURL.substring(0, currentURL.search("keyword=")-1);
			}
			searchForm.action = currentURL+"&keyword=" + userInput;

			if (currentURL.search("database=")==-1) {
				//currentURL = currentURL+ "?database=all";
				searchForm.action = currentURL+"?keyword=" + userInput;
			}

		    //var lnk = document.getElementById('searchForm');
		    //searchForm.action = currentURL+"&keyword=" + userInput;
		};
		</script>

		<script type="text/javascript">

			function getUrlVars() {
				var vars = {};
				var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
				});
				return vars;
			}

			// Written by JH to pass in search text into URL
			// Modified by BB to mak it more generic
			function updateURL(db, kw, con){
				//console.log("HEREEE");
				var currentURL = window.location.href;
				var rootLink = location.protocol + '//' + location.host + location.pathname;
				var x = document.getElementById('userSearchInput');
				if (db == null) db = getUrlVars()["database"];
				var doc = getUrlVars()["document"];
				if (kw == null) kw = getUrlVars()["keyword"];
				else if (kw.trim() == '') kw = null;
				console.log(kw);
				if (con == null) con = getUrlVars()["concept"];
				var myData = new Array();
				var out = new Array();

				if ( db != null ) {
					myData['database'] = db;
				}
				if ( doc != null ){
					myData['document'] = doc;
				}
				if ( con != null ) {
					myData['concept'] = con;
				}
				if (kw != null) {
					myData['keyword'] = kw;
				}
				else if (( x.value.trim() != '') && (x.value.search("{") === -1)) {
					myData['keyword'] = x.value;
				}
				for (key in myData) {
					out.push(key + '=' + myData[key]);
				}
				//console.log(out);


				var out2 = out.join('&');
				if (out2 != ''){
					rootLink = rootLink + "?" + out2;
					//console.log(rootLink);
				}
				
				searchForm.action = rootLink;
				console.log(rootLink);
				localStorage.setItem("input", x.value);
			};


			function appendToSearchBar(concept, collection) {
				//var rootLink = location.protocol + '//' + location.host + location.pathname;
				var x = document.getElementById('userSearchInput');
				var input = localStorage.getItem("input");
				var cDB = localStorage.getItem("cDB");
				var conceptList = "";
				var keywordList;
				//var conceptArray = new Array();
				var repeated = -1;
				var newSearch = -1;
				var searchString = "";

				if (collection !== undefined) {
					if (cDB !== collection) {
						newSearch = 1;
						localStorage.setItem("cDB", collection);
					}
				}
				else localStorage.setItem("cDB", "all");
				
				if ((input !== undefined) && (newSearch != 1)) {
					var start = input.search("{");
					var end = input.search("}");
					if (start !== -1) {
						conceptList = input.substring(start+1,end);
						//console.log(conceptList);
						keywordList = input.substring(end+1,input.length);
						//console.log(keywordList);
						var conceptArray = conceptList.split(", ");
						//console.log("Printing conceptArray");
						//console.log(conceptArray);
						for (i = 0; i < conceptArray.length; i++) {
							if(conceptArray[i]==concept){
								repeated = 1;
								break;
							}
						}
						//var found = $.inArray(concept, conceptArray) > -1;
					}
				}


				if (concept !== undefined)  {
					//console.log(x.value);
					if((conceptList != "")&&(x.value != "")) {
						//console.log("in this loop");
						if (repeated == -1) {
							conceptList += ", ";
							conceptList += concept;
							searchString += "{"+ conceptList + "}";
							searchString += keywordList;
						}
						else{
							searchString = input;		
						}
						
					}
					else {
						searchString = "{"+ concept + "}";
					}
					x.value = searchString;
					localStorage.setItem("input", searchString);
					
					console.log(localStorage);
					if (repeated == -1) {
						$('#searchBtn').click();
					}
					
				}
			}

			window.onload = function(e){
				var db = getUrlVars()["database"];
				var doc = getUrlVars()["document"];
				var kw = getUrlVars()["keyword"];
				var con = getUrlVars()["concept"];
				var x = document.getElementById('userSearchInput');
				if ((db === undefined)&&(doc === undefined)&&(kw === undefined)) {
						localStorage.removeItem("input");
						localStorage.removeItem("keyword");
						localStorage.removeItem("cDB");
						//localStorage.clear();
						//console.log(input);
						console.log("LS cleared!");
				}
				else {
					var input = localStorage.getItem("input");
				}
				if (doc === undefined) {
					
					localStorage.removeItem("matches");
					console.log("Cleared matches");
					var matches = localStorage.getItem("matches");
					console.log(localStorage);
				}
				else if ((doc !== undefined) && ((kw !== null)||(con !== null))) {
					document.getElementById('userSearchInput').placeholder="Search within this document";
				}
				if (input !== undefined) x.value = input;
				//if (kw !== undefined) localStorage.setItem("input", x.value);
				//updateURL();
			}
		</script>

		<div class="jumbotron">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-lg-offset-1">
						<img alt="logo" class="lslogo pull-left" src="./img/default/logo.png" />
						<p id="lslabel">   Lects Search</p>
					</div>
					<div class="col-lg-7 ">
					<form class="form-search" id="searchForm" method="post">
						<div class="input-group">
							<input class="form-control searchBar" type="text" name="searchfield" id="userSearchInput" placeholder="Search for documents"/>
								<span class="input-group-btn">
								<button class="btn btn-default" id="searchBtn" type="submit" name="go" >Search!</button>
							</span></div></form>
					</div>
				</div>
			</div>
		</div>

		<div id="wrap">
	<script type="text/javascript">
			$(document).ready(function(){
				var options = {  
					xmlUrl: './static/xml/conceptTree.xml',
					storeState: true
				};
				console.log(options);
				$('#xmlMenuTree').xmltree(options);
			});
	</script>