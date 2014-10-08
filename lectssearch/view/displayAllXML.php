<!--Version 1.0 created on 30/09/2014 by JH-->
<?php include_once('header.php'); ?>


<div class="container">
	<div class="row">
		<div class="col-lg-3">
			<div class="well">
				Temp Placeholder 
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-1">
			<table>
				<?php foreach($docList as $doc) { 
					$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $doc);?>
				<tr>
					<td>
						<div class="col-lg-2">
							<a href="index.php?document=<?php echo './databaseOut/'.$doc; ?>">
							<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/audio.png"'>
							</a>
						</div>
					</td>
					<td>
						<div >
							<table>
								<tr>
									<td>Title: </td>
									<td><?php echo $fileName?> </td>
								</tr>
								<tr>
									<td>Category: </td>
									<td><?php echo 'TEST'?></td>
								</tr>
								<tr>
									<td>Speaker: </td>
									<td><?php echo $docInfo[(string)$doc]['speaker']?> </td>
								</tr>
								<tr>
									<td>Description: </td>
									<td><?php echo $docInfo[(string)$doc]['description']?> </td>
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