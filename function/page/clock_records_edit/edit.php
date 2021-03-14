<?php

require_once('../../check_dateFormat.php');

$clockID = $_POST['clockID'];
$clockDate = $_POST['clockDate'];
$clockTime = $_POST['clockTime'];
$clockType = $_POST['clockType'];


if(checkFormat_Time($clockTime)){
	UpdateClock($clockID,$clockDate,$clockTime,$clockType);
	header('Location: ../../../clock_records.php');
	exit;
}else{
	header('Location: ../../../clock_records.php?err=sql_query_error');
	exit;
}

function UpdateClock($ID,$DATE,$TIME,$TYPE){
	require "../../link_database_info.php";

	$sql_command = "UPDATE clockrecord SET cr_Date = '$DATE', cr_Time='$TIME', cr_Type= '$TYPE' WHERE cr_ID = '$ID'";
	echo $sql_command;

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
	
	return !$query;
}

?>