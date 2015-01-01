<?php include ('header.php'); ?>
<div class="container">
	<div class="rowa">
		<!-- LEFT SIDE-->
		<div class="col-lg-3">
			<div class="well hidden">
				Temp Placeholder
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<!-- /LEFT SIDE-->
		<div class="col-lg-7 col-lg-offset-1">
			<!-- VIDEO-->
			<div class="mediaContainer">
				<h2 class="videoTitle"><?php echo $document?></h2>
				<!-- Video pane=======================================-->

				<div class="media-box">
					<?php  $audioFormat = array('wav','mp3','aac');
						   $videoFormat = array('mp4');
						if (in_array($docInfo['type'],$audioFormat)) {
							$elementStartTag = "audio id='media'";
							$elementType = "audio/".$docInfo['type'];
							$elementEndTag = "/audio";
						}
						elseif (in_array($docInfo['type'],$videoFormat)) {
							$elementStartTag = "video id='media' height='320'";
							$elementType = "video/".$docInfo['type'];
							$elementEndTag = "/video";
						}
						else {
							$elementName = "video";
						}

					?>

			<div id="player" class="paused scroll-locked">
				<<?php echo $elementStartTag ?>>
					<source src="<?php  echo $docInfo['media'] ?>" type="<?php echo $elementType?>">
					<p>Your browser doesn't support HTML5 video.</p>
				<<?php echo $elementEndTag ?>>

				<div class="watermark">
					<div class="watermark-button">
						<i class="fa fa-play fa-3x"></i>
					</div>
				</div>

				<div class="control-box">
					<div class="control-box-inner">
						<div class="control">
							<div class="progress">
								<div class="progress-bar">

								<div class="track" style="width: 00%"></div>
								<div class="knob" style="left: 0%"></div>
								</div>
								<div class="highlights">

								</div>
								<div class="progress-bar">

								<div class="knob" style="left: 0%"></div>
								</div>



							</div>
						</div>
						<!--</div>-->


						<div class="pull-right">
							<div class="control-btn scroll-unlock" data-toggle="tooltip" title="Scroll locked"><i class="fa fa-lock"></i></div>
							<div class="control-btn scroll-lock" data-toggle="tooltip" title="Turn on scroll lock"><i class="fa fa-unlock"></i></div>
							<div class="control-btn subtitle-language" data-toggle="tooltip" title="Subtitle language">EN</div>
						</div>

						<div>
							<div class="control-btn play-btn" data-toggle="tooltip" title="Play"><i class="fa fa-play"></i></div>
							<div class="control-btn pause-btn" data-toggle="tooltip" title="Pause"><i class="fa fa-pause"></i></div>
							<span class="time-current">12:04</span>
							<span class="time-separator"> / </span>
							<span class="time-duration">30:00</span>

							<!-- TODO: put these controls in a drop-up menu -->
							<div class="control-btn prev-segment-btn" data-toggle="tooltip" title="Previous segment"><i class="fa fa-step-backward"></i></div>
							<div class="control-btn next-segment-btn" data-toggle="tooltip" title="Next segment"><i class="fa fa-step-forward"></i></div>
							<div class="control-btn prev-match-btn" data-toggle="tooltip" title="Previous match"><i class="fa fa-caret-up"></i></div>
							<div class="control-btn next-match-btn" data-toggle="tooltip" title="Next match"><i class="fa fa-caret-down"></i></div>
						</div>
					</div><!-- .control-box-inner -->
				</div><!-- .control-box -->
			</div><!-- #player -->

				</div><!-- .media-box -->


			</div>
			<div class="panel panel-default hidden-xs" style="margin-top: 30px;">
				<div class="panel-body">
				<!-- TABS CONTROLS -->
				<ul id="myTab" class="nav nav-tabs nav-justified">
					<li class="active"><a data-toggle="tab" href="#home">
						<i class="icon-info-sign"></i>TRANSCRIPT TAB </a></li>
						<li><a data-toggle="tab" href="#profile">
							<i class="icon-info-sign"></i>DESCRIPTION TAB </a></li>
				</ul>
				<!-- /TABS CONTROLS -->
				<!-- PANES -->
				<div id="myTabContent" class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<div class="transcriptions">
							<?php foreach($printScript as $key => $value){
								echo $printScript[$key]['speaker'];
								$t = $printScript[$key]['text'];
								echo $t. "<br/>" ;
							}?>
						</div>
					</div>

					<div id="profile" class="tab-pane fade widget-tags ">

							<table class="tableContainer">
								<tr>
									<td class="leftTableCol">Title: </td>
									<td class="rightTableCol"><?php echo $document?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Content Type: </td>
									<td class="rightTableCol"><?php echo $docInfo['type']?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Speaker(s): </td>
									<td class="rightTableCol"><?php echo $docInfo['speakerEdit']?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Description: </td>
									<td class="rightTableCol"><?php echo $docInfo['description']?><br></td>
								</tr>
							</table>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="./static/js/jquery-1.8.0.min.js" type='text/javascript'></script>
<script src="./static/js/magor.js" type="text/javascript"></script>
<script src="./static/js/magor-player.js" type="text/javascript"></script>
<script src="./static/js/magor-filter.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	//activate video player tooltips
	/*$(".control-btn").tooltip({ 'placement': 'top', 'container': 'body' });

	//handling the affix effect of column1
	var navbarHeight = $('.navbar').height();

	$(document).scroll(function(){
	/*var startAffixAt = $('.document-title').position().top + $('.document-title').height() + 50;
	var scroll = $(document).scrollTop();
	if (scroll >= startAffixAt) {
	if (!$('.column1').hasClass('affix'))
	$('.column1').addClass('affix').css({ top: $('.navbar').height() + 20 });
}
else {
$('.column1').removeClass('affix');
}
});*/


<?php	echo "var segments = [" ;
foreach($printScript as $key => $value){
	foreach ($printScript[$key]['table']  as $line){
		echo 'new magor.Segment('. $line."),\n" ;
	}
}
echo "];" 	;
?>

<?php
if( isset($matchList) ){
	echo 'var matches = [' . join(', ', $matchList) .'];'. "\n";
}
else{
	echo 'var matches = [];'. "\n";
}
?>

magor.magorPlayer = new magor.MagorPlayer(segments);
magor.magorPlayer.highlightMatches(matches);


});
</script>

		<?php include ('footer.php'); ?>
