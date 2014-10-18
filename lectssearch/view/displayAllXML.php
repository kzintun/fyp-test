<!--Version 1.0 created on 30/09/2014 by JH-->
<!--Version 1.1 modified on 11/10/2014 by JH-->
<?php include_once('header.php'); ?>


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
				<?php foreach($docList as $docX) { 
					//print_r($docInfo);
					$doc = $docX['name'];
					$docLoc = $docX['loc'];
					$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $doc);
					//echo $doc;
					//$fileLoc = './databaseOut/'.$doc; 
					$keyTime = '00:00:00:00'; ?>
				<tr>
					<td>
						<div class="col-lg-2">
							<?php $param= $docInfo[(string)$doc]['fileLoc'];
							//echo $param?>
							<!--DYNAMIC LOADING OF VIDEOS NOT WORKING-->
							<script type="text/javascript">
								var para = <?php echo json_encode($param);?>;
								var id = <?php echo json_encode($doc); ?>;
								//alert(para);
								document.getElementById(id).onclick =loadVideo(para); 
								//onclick="javascript:loadVideo(\''.$param.'\');"
							</script>
							<a id="<?php echo $doc; ?>" class ="inline"  href="index.php?database=<?php echo $docInfo[(string)$doc]['category'];?>&document=<?php echo $doc; ?>">							
							<!--//loadVideo(para);"  href="index.php?document=<?php echo $doc; ?>">-->
							<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/audio.png"'>
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
									<td>&emsp;<?php echo $docInfo[(string)$doc]['speaker']?><br></td>
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
			</table>
			<!--<?php
			$j = 0;
			$countDoc = count($docList);
			while ($j < $countDoc) { 
				$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $docList[$j]);?>
			<div class="col-lg-2">
				<a href="index.php?database=<?php echo $dir .'/'.$docList[$j]; ?>">
				<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/audio.png"'>
				</a>
				<p><?php echo $fileName; 
				$j++; ?></p>
			</div>
			<div class="col-lg-8">
				<p>xx</p>
			</div>
			<?php } ?>-->
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>