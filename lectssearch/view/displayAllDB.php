<!--Version 1.0 created on 30/09/2014 by JH-->
<?php include_once('header.php'); ?>


<div class="container">
	<div class="rowa">
		<div class="col-lg-3 ">
			<div class="well hidden">
				Temporary Placeholder Here
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<div class="col-lg-7 col-lg-offset-1">
			<?php
				$i = 0;
				$count = count($fileList);
				while ($i < $count) { 
					$fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileList[$i]); 
			?>
			<div class="col-lg-6" align="center">
				<div class="img-with-text">
				<a href="index.php?database=<?php echo $fileName; ?>">
				<img class="collectionImg" src="<?php echo './img/collections/'.$fileName.'.png'?>" border="0" alt="database icon" onerror='this.onerror = null; this.src="./img/collections/altcollection.png"'>
				</a>
				<p class="collectionName"><?php echo $fileName; 
				$i++; ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>