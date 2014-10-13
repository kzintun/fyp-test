<!--Version 1.0 created on 30/09/2014 by JH-->
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
			<?php
			$i = 0;
			$count = count($fileList);
			while ($i < $count) { 
				$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileList[$i]);?>
			<div class="col-lg-6">
				<a href="index.php?database=<?php echo $fileName; ?>">
				<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/foldericon.png"'>
				</a>
				<p><?php echo $fileName; 
				$i++; ?></p>
			</div>
			<?php if ($i < $count) { 
				$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileList[$i]);?>
			<div class="col-lg-6">
				<a href="index.php?database=<?php echo $fileName; ?>">
				<img src="<?php echo './thumbnail/'.$fileName.'.png'?>" border="0" alt="database icon" height="128" width="128" onerror='this.onerror = null; this.src="./img/foldericon.png"'>
				</a>
				<p><?php echo $fileName;
				$i++; }?></p>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>