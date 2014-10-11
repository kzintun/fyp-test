<html>

<script type="text/javascript" src="./js/jwplayer.js"></script>
<script type="text/javascript" src="./js/jwplayer.html5.js"></script>

<body>
<div id="test44">ASD</div>
<li><a href="javascript:loadVideo('./data/AdamGrosser_2007.mp3')">Video 1</a></li>

<script type="text/javascript">
    jwplayer("test44").setup({
        file: "http://localhost/lectssearch/data/lecture1.mp4",
        image: "http://mydomaincom/muposterpic.png",
        width: "100%",
        aspectratio: "16:9"
    });
</script>

<script type="text/javascript">
function loadVideo(myFile)
{
	alert(myFile);
	jwplayer().load([{	
		file:myFile }]);
	jwplayer().play();
	
};
</script>

</body>

</html>