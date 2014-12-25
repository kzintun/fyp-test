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
							$elementStartTag = "audio controls";
							$elementType = "audio/".$docInfo['type'];
							$elementEndTag = "/audio";
						}
						elseif (in_array($docInfo['type'],$videoFormat)) {
							$elementStartTag = "video id='media' controls preload='none' height='320'";
							$elementType = "video/".$docInfo['type'];
							$elementEndTag = "/video";
						}
						else {
							$elementName = "video";
						}
						
					?>

					<<?php echo $elementStartTag ?>>
						<source src="<?php  echo $docInfo['media'] ?>" type="<?php echo $elementType?>" >
						<?php  echo $docInfo['media'] ?>
						<p>Your browser doesn't support HTML5 video.</p>
					<<?php echo $elementEndTag ?>>
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

		<?php include ('footer.php'); ?>
