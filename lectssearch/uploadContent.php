
<!--Version 1.0 created on 14/09/2014 by JH-->
<?php include ('view/header.php'); ?>
<script type="text/javascript">

	function ChangeDropdowns(value){
    if(value=="vid"){
        document.getElementById('video').style.display="block";
		document.getElementById('document').style.display="none";
		if (vidstat.value="p") {
			document.getElementById('processed').style.display="block";
			document.getElementById('unprocessed').style.display="none";

		}
		else {
			document.getElementById('processed').style.display="none";
			document.getElementById('unprocessed').style.display="block";
		}
		
    }
    else if(value=="doc"){
        document.getElementById('video').style.display="none";
		document.getElementById('document').style.display="block";
		document.getElementById('processed').style.display="none";
		document.getElementById('unprocessed').style.display="none";
    }
	}

	
	function ChangeVid(value){
    if(value=="p"){
        document.getElementById('processed').style.display="block";
		document.getElementById('unprocessed').style.display="none";
    }else if(value=="u"){
        document.getElementById('processed').style.display="none";
		document.getElementById('unprocessed').style.display="block";
    }
	}
		
</script>
<div id="main" class="content">
	<center>
	<div id="mainlogo" style="height: 231px; margin-top: 20px">
		<div style="padding-top: 50px">
			<img alt="logo" src="img/logo.png" />
			<div style="color: #777; font-size: 16px; font-weight: bold; position: relative; left: 158px; top: 5px">
				Nanyang Technological University </div>
		</div>
	</div>
	</center></div>
<div class="container">
	<div class="well">
		<div class="row-fluid">
			<form id="register" action="#" class="form-horizontal" enctype="multipart/form-data" method="POST">
				<fieldset>
				<!-- Form Name -->
				<legend>Content Upload</legend>
				<!-- Select Basic -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="selectbasic">Content 
					Type: *</label>
					<div class="col-md-6">
						<select id="selectbasic" class="form-control" name="selectbasic" onchange="ChangeDropdowns(this.value);">
						<option value="vid">Video</option>
						<option value="doc">Document</option>
						</select> </div>
				</div>
				<div id="video">
					<div class="form-group">
						<label class="col-md-4 control-label" for="vidstat">Video 
						Status:</label>
						<div class="col-md-6">
							<select id="vidstat" class="form-control" name="vidstat" onchange="ChangeVid(this.value);">
							<option value="p">Processed</option>
							<option value="u">Unprocessed</option>
							</select> </div>
					</div>
					<div id="processed">
						<div class="form-group">
							<label class="col-md-4 control-label" for="vidloc">Video 
							Location:</label>
							<div class="col-md-4">
								<input id="vidloc" class="input-file" name="vidloc" type="file">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="vidtopic">
							Video Topic:</label>
							<div class="col-md-4">
								<div class="radio">
									<label for="vidtopic-0">
									<input id="vidtopic-0" checked="checked" name="vidtopic" type="radio" value="1"> 
									Aeronautics </label></div>
								<div class="radio">
									<label for="vidtopic-1">
									<input id="vidtopic-1" name="vidtopic" type="radio" value="2"> 
									DSP </label></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="audloc">Audio 
							File:</label>
							<div class="col-md-4">
								<input id="audloc" class="input-file" name="audloc" type="file">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="transloc">
							Transcript File:</label>
							<div class="col-md-4">
								<input id="transloc" class="input-file" name="transloc" type="file">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="date">Video 
							Date:</label>
							<div class="col-md-4">
								<div id="datetimepicker1" class="input-group date">
									<input class="form-control" type="text" />
									<span class="input-group-addon">
									<span class="glyphicon-calendar glyphicon">
									</span></span></div>
							</div>
						</div>
					</div>
					<div id="unprocessed" style="display: none">
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="vidtitle">
							Video Title:</label>
							<div class="col-md-6">
								<input id="vidtitle" class="form-control input-md" name="vidtitle" placeholder="Enter title of video" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="vidtopic2">
							Video Topic:</label>
							<div class="col-md-4">
								<div class="radio">
									<label for="vidtopic2-0">
									<input id="vidtopic2-0" checked="checked" name="vidtopic2" type="radio" value="1"> 
									Aeronautics </label></div>
								<div class="radio">
									<label for="vidtopic2-1">
									<input id="vidtopic2-1" name="vidtopic2" type="radio" value="2"> 
									DSP </label></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="vidlink">
							Video Link:</label>
							<div class="col-md-6">
								<input id="vidlink" class="form-control input-md" name="vidlink" placeholder="Enter url of video" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="date">Video 
							Date:</label>
							<div class="col-md-4">
								<div id="datetimepicker1" class="input-group date">
									<input class="form-control" type="text" />
									<span class="input-group-addon">
									<span class="glyphicon-calendar glyphicon">
									</span></span></div>
							</div>
						</div>
					</div>
				</div>
				<div id="document" style="display: none">
					<div class="form-group">
						<label class="col-md-4 control-label" for="doctitle">Doc 
						Title:</label>
						<div class="col-md-6">
							<input id="doctitle" class="form-control input-md" name="doctitle" placeholder="Enter title of document" type="text">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="docloc">Doc Location:
						</label>
						<div class="col-md-4">
							<input id="docloc" class="input-file" name="docloc" type="file">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="doctopic">Doc 
						Topic:</label>
						<div class="col-md-4">
							<div class="radio">
								<label for="doctopic-0">
								<input id="doctopic-0" checked="checked" name="doctopic" type="radio" value="1"> 
								Aeronautics </label></div>
							<div class="radio">
								<label for="doctopic-1">
								<input id="doctopic-1" name="doctopic" type="radio" value="2"> 
								DSP </label></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="date">Doc Date:</label>
						<div class="col-md-4">
							<div id="datetimepicker1" class="input-group date">
								<input class="form-control" type="text" />
								<span class="input-group-addon">
								<span class="glyphicon-calendar glyphicon">
								</span></span></div>
						</div>
					</div>
				</div>
				<input id="upload" class="upload" name="upload" type="submit" value="Submit">
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php include ('view/footer.php');?>