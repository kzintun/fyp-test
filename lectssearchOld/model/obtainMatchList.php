<?php
	// NOT IN USE TO BE REMOVED
	echo "HERE!";
	$matchArray=array();
	$matchListFull = array();
	$select = $_POST['select'];
	//print_r ($_POST['php_array']);
	$matchListFull = json_decode(stripslashes($_POST['php_array']));
	//$matchListFull = json.parse($_POST['php_array'].$select);
	



	$matchArray = $matchListFull[$select];

	//echo json_encode($matchArray);




?>





