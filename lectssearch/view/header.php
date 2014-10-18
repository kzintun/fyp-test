<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--Version 1.0 created on 14/09/2014 by JH-->
<!--Version 1.1 modified on 30/09/2014 by JH-->
<!--Version 1.2 modified on 18/10/2014 by JH to add in search url-->

<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Lects Search</title>
		
		<link href="./css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="./css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
		<link href="./css/style.css" rel="stylesheet" type="text/css" />
		<link href="./css/jquery-ui.css"rel="stylesheet" type="text/css"  />
		
	<body>
		<nav class="navbar navbar-fixed-top navbar-default" role="navigation">
			<div class="container">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span><span class="icon-bar"></span>
						<span class="icon-bar"></span></button>
						<a class="navbar-brand" href="index.php">Home</a> </div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<!--<li><a href="index.php">Home</a></li>-->
							<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">More..
							<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="uploadContent.php">Upload Content</a></li>
								<li><a href="#">About LS</a></li>
								<li><a href="#">FAQ</a></li>
								<li class="divider"></li>
								<li><a href="#">Temp Video Page</a></li>
								<li><a href="#">Credits</a></li>
							</ul>
							</li>
						</ul>
					</div>
					<!-- /.navbar-collapse --></div>
				<!-- /.container-fluid --></div>
		</nav>
		
		<script type="text/javascript">
		<!-- Written by JH to pass in search text into URL-->
		function updateURL(){
			var currentURL = window.location.href;
			//alert(currentURL);
			if (currentURL.search("database")==-1) {
				currentURL = currentURL+ "?database=all";
			}
		    var userInput = document.getElementById('userInput').value;
		    var lnk = document.getElementById('searchForm');
		    searchForm.action = currentURL+"&search=" + userInput;
		}
		</script>
		
		<div class="jumbotron">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-lg-offset-1">
						<img alt="logo" class="pull-left" height="35" src="img/banner.png" width="200" />
					</div>
					<div class="col-lg-7 ">
					<form class="form-search" id="searchForm" method="post">
						<div class="input-group">
							<input class="form-control" type="text" name="searchfield" id="userInput"/>
								<span class="input-group-btn">
								<button class="btn btn-default" type="submit" name="go" onclick="updateURL()">Go!</button>
							</span></div></form>
					</div>
				</div>
			</div>
		</div>
		
		<div id="wrap">





