<?php include_once('header.php'); ?>


<div class="container">
	<div class="rowa">
		<div class="col-lg-3">
			<div class="well hidden">
				Temp Placeholder
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-1">
			<ul class="list-group">
			<?php foreach($docInfo as $key => $value) {
				$audioFormat = array('wav','mp3','aac');
				$videoFormat = array('mp4');
				if (in_array($docInfo[(string)$key]['type'],$audioFormat)) {
					$defaultIcon = "./img/default/audio.png";
				}
				elseif (in_array($docInfo[(string)$key]['type'],$videoFormat)) {
					$defaultIcon = "./img/default/video.png";
				}
				else {
					$defaultIcon = "./img/default/unknown.png";
				}

			?>
				<li class="list-group-item ">
					<div class="media">

					  	<div class="media-body col-lg-9">
					  		<table class="tableContainer">
								<tr>
									<td class="leftTableCol">Title: </td>
									<td class="rightTableCol"><?php echo $key?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Content Type: </td>
									<td class="rightTableCol"><?php echo $docInfo[(string)$key]['type']?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Speaker(s): </td>
									<td class="rightTableCol"><?php echo $docInfo[(string)$key]['speakerEdit']?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Description: </td>
									<td class="rightTableCol"><?php echo $docInfo[(string)$key]['description']?><br></td>
								</tr>
							</table>
						 </div>
						 <a class="media-right media-middle" href="index.php?database=<?php echo $_GET['database'];?>&document=<?php echo $key; ?>">
				    		<img class="docIcon" src="<?php echo './img/thumbnail/'.$key.'.png'?>" border="0" alt="database icon" onerror='this.onerror = null; this.src="<?php echo $defaultIcon?>"'>
					  	</a>
					</div>
			  </li>

			<?php } ?>
			</ul>
			<!--<table>
			<h4 class="list-group-item-heading"></h4>
			    <p class="list-group-item-text">...</p>
				<?php foreach($docInfo as $key => $value) {
					//print_r($docInfo);
					$doc = $key;
					$docLoc = $docInfo[(string)$doc]['xmlLoc'];
					$fileName = $doc;
					//preg_replace('/\\.''[^.\\s]{3,4}$/', '', $doc);
					//echo $doc;
					//$fileLoc = './databaseOut/'.$doc;
				?>
				<tr>
					<td>
						<div class="col-lg-2">
							<?php $param= $docInfo[(string)$doc]['xmlLoc'];
							//echo $param?>
							<!--DYNAMIC LOADING OF VIDEOS NOT WORKING
							<a id="<?php echo $doc; ?>" class ="inline"  href="index.php?database=<?php echo $_GET['database'];?>&document=<?php echo $doc; ?>">
							<!--//loadVideo(para);"  href="index.php?document=<?php echo $doc; ?>">
							<img class="docIcon" src="<?php echo './img/thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" onerror='this.onerror = null; this.src="./img/default/audio.png"'>
							<?php echo '</a>'?>
						</div>
					</td>
					<td>
						<div >
							<table>
								<tr>
									<td>Title: </td>
									<td>&emsp;<?php echo $fileName?><br></td>
								</tr>
								<tr>
									<td>Content Type: </td>
									<td>&emsp;<?php echo $docInfo[(string)$doc]['type']?><br></td>
								</tr>
								<tr>
									<td>Speaker(s): </td>
									<td>&emsp;<?php echo $docInfo[(string)$doc]['speakerEdit']?><br></td>
								</tr>
								<tr>
									<td>Description: </td>
									<td>&emsp;<?php echo $docInfo[(string)$doc]['description']?><br></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<?php } ?>
			</table>-->
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>
