<!--26 JAN 2015 - AMENDED BY JH TO FIX VARIOUS UI BUGS-->

<?php include_once('header.php'); ?>
<script type="text/javascript">
	function ExpandCollapse(theDiv) {
			el = document.getElementById(theDiv);
			if(el.style.display == 'none'){
				el.style.display = ''; }
			else {
				el.style.display = 'none'; }
			return false; }
</script>

<script >
// Jquery to limit overflow of text into ...
$(document).ready(function() {
     $(".ellipsis").dotdotdot();
});
</script>

<div class="container">
	<!--<script type="text/javascript">
		$(document).ready(function(){
			var options = {  
				xmlUrl: './static/xml/conceptTree.xml',
				storeState: true
			};
			//console.log(options);
			$('#xmlMenuTree').xmltree(options);
		});
	</script>-->
	<div class="rowa">
		<!-- LEFT SIDE-->
		<div class="col-lg-3">
			<div class="well" >
				<div id="xmlMenuTree"></div>
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-1">
			<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>Found <strong><?php echo sizeof($finalResultArray); ?></strong> result(s)!</span></div>
			<ul class="list-group">
			<?php foreach($finalResultArray as $key => $value) {
				/*$audioFormat = array('wav','mp3','aac');
				$videoFormat = array('mp4');
				if (in_array($finalResultArray[(string)$key]['type'],$audioFormat)) {
					$defaultIcon = "./img/default/audio.png";
				}
				elseif (in_array($finalResultArray[(string)$key]['type'],$videoFormat)) {
					$defaultIcon = "./img/default/video.png";
				}
				else {*/
					$defaultIcon = "./img/default/video.png";
				//}

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
									<td class="leftTableCol">Collection: </td>
									<td class="rightTableCol"><?php echo $finalResultArray[$key][0]['collection']?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Number of Keyword(s) Found: </td>
									<td class="rightTableCol"><?php echo $finalDisplayArray[$key]?><br></td>
								</tr>
								<tr>
									<td class="leftTableCol">Preview Text: </td>
									<td class="rightTableCol"><div class="ellipsis" style="word-wrap: break-word;"><?php echo $finalResultArray[$key][0]['text']?></div></td>
								</tr>
								<tr>
									<td class="leftTableCol"></td>
									<td class="rightTableCol">
										<br>
										<button class="btn btn-primary btn-sm" type="submit" name="go" onclick="ExpandCollapse('<?php echo 'idS-'.$key; ?>'); ">Show more results</button>
									</td>
								</tr>
								<tr id="<?php echo 'idS-'.$key; ?>" style="display:none">
									<td class="leftTableCol"></td>
									<td class="rightTableCol">
										<div >
											<table class="table table-hover">
												<thead>
													<tr>
														<th align="center" width="20%"> Start Time</th>
														<th align="center" width="80%"> In Text</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($k= 0 ; $k < sizeof($finalResultArray[$key]); $k++){
																$time = $finalResultArray[$key][$k]['startTime'];?>
													<tr>
														<td><a id="<?php echo 'tid-'.$key; ?>" class ="inline img-redirect"  href="index.php?database=<?php echo $finalResultArray[$key][$k]['collection'];?>&document=<?php echo $key;?>&seek=<?php echo $time;?>">
														<?php echo $finalResultArray[$key][$k]['startTime'] ?></a></td>
														<td><?php echo $finalResultArray[$key][$k]['text'] ?></td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>

							</table>
						 </div>
					 		<a id="<?php echo $key; ?>" class="media-right media-middle img-redirect" href="index.php?database=<?php echo $finalResultArray[$key][0]['collection'];?>&document=<?php echo $key; ?>">
					    		<img class="docIcon" src="<?php echo './img/thumbnails/'.$key.'.png'?>" border="0" alt="database icon" onerror='this.onerror = null; this.src="<?php echo $defaultIcon?>"'>
						  	</a>
						
					</div>
			  </li>

			<?php } ?>
			</ul>




		</div>
	</div>
</div>
			<script>
			$('.img-redirect').click(function() { 
				//console.log("CLICKED");
				console.log(this.id);
				var key = this.id;
				
				/*<?php
					$js_array = json_encode($finalResultArray);
					echo "var passArray = ". $js_array . ";\n";
				?>*/
				var passArray = <?php echo json_encode($matchSegmentArray);?>;
				passArray = passArray[key];
				//var arr = $.map(passArray, function(el) { return el; });
				console.log(passArray);
				//console.log(arr);
				localStorage.setItem("matches", passArray);
				console.log(localStorage.getItem("matches"));
				//this.href="index.php?database="+<?php echo $finalResultArray[$key][0]['collection'];?>="&document="+key;
				//return false; 

			});
			</script>

<?php include_once('footer.php'); ?>