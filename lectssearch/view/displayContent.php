<!--Version 1.0 created on 20/09/2014 by JH-->
<!--Version 1.1 created on 11/10/2014 by JH to:
	Enable JWplayer playback
	Fill in description tab
	Fill in transcription tab
-->
<?php include ('header.php'); ?>
<div class="container">
	<div class="rowa">
		<!-- LEFT SIDE-->
		<div class="col-lg-3">
			<div class="well">
				Temp Placeholder 
				<p><br><br><br><br><br><br><br><br><br><br><br><br><br></p>
			</div>
		</div>
		<!-- /LEFT SIDE-->
		<div class="col-lg-7 col-lg-offset-1">
			<!-- VIDEO-->
			<div class="vendor">
				<h2><?php echo $document?></h2>
				<div id="video44">asd</div>
				
			</div>
			<div class="panel panel-default hidden-xs" style="margin-top: 30px;">
				<div class="panel-body">
					<!-- TABS CONTROLS -->
					<ul id="myTab" class="nav nav-tabs nav-justified">
						<li class="active"><a data-toggle="tab" href="#home">
						<i class="icon-info-sign"></i>DESCRIPTION TAB </a></li>
						<li><a data-toggle="tab" href="#profile">
						<i class="icon-info-sign"></i>TRANSCRIPT TAB </a></li>
					</ul>
					<!-- /TABS CONTROLS -->
					<!-- PANES -->
					<div id="myTabContent" class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<p>
								<table>
								<tr>
									<td>Title: </td>
									<td>&emsp;<?php echo $document?><br></td>
								</tr>
								<tr>
									<td>Content Type: </td>
									<td>&emsp;<?php echo $selected['type']?><br></td>
								</tr>
								<tr>
									<td>Speaker(s): </td>
									<td>&emsp;<?php echo $selected['speaker']?><br></td>
								</tr>
								<tr>
									<td>Description: </td>
									<td>&emsp;<?php echo $selected['description']?><br></td>
								</tr>
							</table>
								<br><br><br><br><br><br><br><br><br><br><br>
							</p>
							
							
							
						</div>
						<div id="profile" class="tab-pane fade widget-tags ">
							<p><?php echo $printScript?></p>
								
												
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		
<?php include ('footer.php'); ?>