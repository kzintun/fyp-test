<!--Version 1.0 created on 14/09/2014 by JH-->
<!--Version 1.1 modified on 30/09/2014 by JH-->
<!--Version 1.2 modified on 09/10/2014 by JH-->

<div id="push"></div>
</div>
    <div id="footer">
      <div class="container">
        <p class="muted credit">&copy 2014</p>
		<p class="muted credit">This website requires javascript.</p>
      </div>
    </div>
	<script type="text/javascript">
	<?php 
		$myArr=json_encode($document);
		echo"var myArr=".$myArr.";\n";
	?>
	</script>		
	<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/jwplayer.js"></script>
	<script type="text/javascript" src="./js/jwplayer.html5.js"></script>
	

	<script src="./js/jquery-ui.js"></script>
	<script src="./js/videoDesChange.js" type="text/javascript"></script>
	
	<script type="text/javascript">
			
jwplayer("video44").setup({
				"flashplayer":"jwplayer.flash.swf",
				file: "./data/"+myArr+".mp3",
				"autostart": "false",
                "controlbar.position": "bottom",
				width: "100%",
				aspectratio: "16:9"
		
         });
function loadVideo(myFile)
{
	jwplayer().load([{	
		//"file":myFile+"image/"+myFile+".mp4",
		//file:myFile	
		file: "./data/"+myFile+".mp3"
		}]);
	jwplayer().play();
	
};	     
	</script>
	
	

</body>
</html>