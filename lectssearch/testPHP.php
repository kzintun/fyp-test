<?php 
session_start();

$docList = array('AaronHuey_2010X','AdamSadowsky_2010X');
//print_r ($docList);

include_once('model/getInfoFromDocList.php');
$docInfo = getInfoFromDocList($docList);

print_r ($docInfo);

?>



	