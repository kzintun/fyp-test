
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

<div class="container">
	<div class="rowa">
		<div class="col-lg-3">
			<div class="well">
				Temp Placeholder
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-1">
			<table>
				<tr>
					<td><em>Found <?php echo sizeof($finalResultArray); ?> results ! </em><br></br>
					</td>
				</tr>
				<?php foreach($finalDisplayArray as $key => $value) {
							$doc = $key;
							$fileName = $doc;
							$keyTime = '00:00:00:00'; ?>
				<tr>
					<td>
						<div class="col-lg-2">

							<a id="<?php echo $doc; ?>" class ="inline"  href="index.php?database=<?php echo $finalResultArray[$key][0]['collection'];?>&document=<?php echo $doc; ?>">							
							<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/audio.png"'>
							<?php echo '</a>'?>
						</div>
					</td>
					<td>
						<div >
							<table>
								<tr>
									<td width="40%"><strong>Title:</strong> </td>
									<td width="60%"><?php echo $fileName?><br></td>
								</tr>
								<tr>
									<td width="40%"><strong>Collection:</strong> </td>
									<td width="60%"><?php echo $finalResultArray[$key][0]['collection']?><br></td>
								</tr>
								<tr>
									<td width="40%"><strong>Keyword(s) Found:</strong> </td>
									<td width="60%"><?php echo $finalDisplayArray[$key] ?><br></td>

								</tr>
								<tr>
									<td width="40%"><strong>Preview text:</strong> </td>
									<td width="60%" align="justify"><?php echo $finalResultArray[$key][0]['text']?><br></td>
								</tr>
								<tr>
									<td>
										<button class="btn btn-primary btn-sm" type="submit" name="go" onclick="ExpandCollapse('<?php echo 'idS-'.$doc; ?>'); ">Show more results</button>
									</td>
								</tr>
								<tr id="name1" style="display:none">
									<td><strong>Time</strong> </td>
									<td><strong>Text</strong><br></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr id="<?php echo 'idS-'.$doc; ?>" style="display:none">
					<td></td>
					<td>
						<div >
							<table class="table table-hover">
								<thead>
									<tr>
										<th align="center" width="20%"> Start Time</th>
										<th align="center" width="80%"> In Text</th>
									</tr>
								</thead>
								<tbody>
									<?php for ($k= 0 ; $k < sizeof($finalResultArray[$doc]); $k++){
												$time = $finalResultArray[$doc][$k]['startTime'];?>
									<tr>
										<td><a id="<?php echo 'tid-'.$doc; ?>" class ="inline"  href="index.php?database=<?php echo $finalResultArray[$doc][$k]['collection'];?>&document=<?php echo $doc;?>&seek=<?php echo $time;?>">
										<?php echo $finalResultArray[$doc][$k]['startTime'] ?></a></td>
										<td><?php echo $finalResultArray[$doc][$k]['text'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>

				<?php } ?>
			</table>

		</div>
	</div>
</div>


<?php include_once('footer.php'); ?>
