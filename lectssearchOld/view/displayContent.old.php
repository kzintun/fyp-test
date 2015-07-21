<!--Version 1.0 created on 20/09/2014 by JH-->
<!--Version 1.1 created on 11/10/2014 by JH to:
	Enable JWplayer playback
	Fill in description tab
	Fill in transcription tab
-->
<?php include ('header.php'); ?>
<div class="container">
	<div class="rowa">
		<!-- LEFT SIDE-->
		<div class="col-lg-3">
			<div class="well">
				Temp Placeholder 
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<!-- /LEFT SIDE-->
		<div class="col-lg-7 col-lg-offset-1">
			<!-- VIDEO-->
			<div class="vendor">
				<h2><?php echo $document?></h2>
				<div id="video44">...Loading video...</div>
			</div>
			
			<div class="panel panel-default hidden-xs" style="margin-top: 30px;">
				<div class="panel-body">
				
					<!-- TABS CONTROLS -->
					<ul id="myTab" class="nav nav-tabs nav-justified">
						<li class="active"><a data-toggle="tab" href="#home">
						<i class="icon-info-sign"></i>DESCRIPTION TAB </a></li>
						<li><a data-toggle="tab" href="#profile">
						<i class="icon-info-sign"></i>TRANSCRIPT TAB </a></li>
					</ul>
					<!-- /TABS CONTROLS -->
	<!--test-->				
	<ul>
    <li>State: <span id="stateText">IDLE</span></li>
    <li>Elapsed time: <span id="elapsedText">0</span></li>
	</ul>

					<!-- PANES -->
					<div id="myTabContent" class="tab-content">
					
						<!--Populating DESCRIPTION TAB -->
						<div id="home" class="tab-pane fade in active">
							<p> <?php echo $printDescript?></p>		
						</div>
						
						<!--Populating TRANSCRIPT TAB -->
						<div id="profile" class="tab-pane fade widget-tags ">
							<p><?php echo $printTranscript?></p>					
						</div>
					
					</div>
					<!-- /PANES -->	
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php 
		$myArr=json_encode($document);
		echo"var myArr=".$myArr.";\n";
	?>
</script>	
<script type="text/javascript">		
	jwplayer("video44").setup({
					
					file: "./data/"+myArr+".mp3",
					"autostart": "false",
					"controlbar.position": "bottom",
					width: "100%",
					aspectratio: "16:9",
					events:{ 
						onTime: function(event) {
							updateValues();
							//var state = jwplayer("container").getState();
							//var elapsed = jwplayer("container").getPosition();
						
							//if (event.position > 10) {
								// do sth
							//	alert(" 10 secs into the vid");
							//}
						}
					}
	});
</script>	 
<script type ="text/javascript">
	function setText(id, messageText) {
		document.getElementById(id).innerHTML = messageText;
	}

	function updateValues() {
		var state = jwplayer("video44").getState();
		var elapsed = jwplayer("video44").getPosition();
		setText("stateText", state);
		setText("elapsedText", elapsed);
	}
	
	function checkTime() {
	
		// get the $sentence array that hold the startingtime of each sentence in sequential order
		// compare with current video position
		// if current.position == sentence[ ].startTime
				// highlight that sentence
				// look for the value of starttime in $printTranscript string and change value ???
				// increment i
				
	}
</script>

	
	
<?php include ('footer.php'); ?>