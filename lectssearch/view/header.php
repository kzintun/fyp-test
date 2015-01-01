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
			function updateURL(){
				var currentURL = window.location.href;
				var rootLink = location.protocol + '//' + location.host + location.pathname;
				var x = document.getElementById('userSearchInput');
				var db = getUrlVars()["database"];
				var doc = getUrlVars()["document"];
				var kw = getUrlVars()["keyword"];
				var myData = new Array();
				var out = new Array();

				if ( db != null ) {
					myData['database'] = db;
				}
				if ( doc != null ){
					myData['document'] = doc;
				}
				if ( x.value != '') {
					myData['keyword'] = x.value;
				}
				else if (kw != null) {
					myData['keyword'] = kw;
				}
				for (key in myData) {
					out.push(key + '=' + myData[key]);
				}
				//console.log(out);


				var out2 = out.join('&');
				if (out2 != ''){
					rootLink = rootLink + "?" + out2;
				}
				//alert(rootLink);
				searchForm.action = rootLink;
				localStorage.setItem("input", x.value);
			};


			window.onload = function(e){
				var db = getUrlVars()["database"];
				var doc = getUrlVars()["document"];
				var kw = getUrlVars()["keyword"];
				var x = document.getElementById('userSearchInput');
				if ((db === undefined)&&(doc === undefined)&&(kw === undefined)) {
						window.localStorage.removeItem(input);
						console.log(input);
						console.log("LS cleared!");
				}
				else {
					var input = localStorage.getItem("input");
				}
				if (input !== undefined) x.value = input;
				updateURL();
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
							<input class="form-control searchBar" type="text" name="searchfield" id="userSearchInput" placeholder="Search documents"/>
								<span class="input-group-btn">
								<button class="btn btn-default" id="searchBtn" type="submit" name="go" onclick="updateURL()">Search!</button>
							</span></div></form>
					</div>
				</div>
			</div>
		</div>

		<div id="wrap">
