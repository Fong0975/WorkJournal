<?php

deleteRecord($_GET['id']);
header('Location: ../../../clock_records.php');
exit;

function deleteRecord($id){
	require "../../link_database_info.php";
	require_once("../../getData.php");

	$strData = getData_String("*", "clockrecord", "cr_ID = '$id'", "");
	$arrDataRow=explode('@br@',$strData)[0];
	$thatDate = explode("/",$arrDataRow)[1];
	$date_lastMonth= date("Y-m-d", strtotime("-14 day"));


	if(strtotime($thatDate) >= strtotime($date_lastMonth)){
		$sql_command = "DELETE FROM clockrecord WHERE cr_ID = '$id'";
		echo $sql_command;

		$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
		mysqli_set_charset($sql_connect, "utf8");
		$query = mysqli_query($sql_connect,$sql_command );
		
		return !$query;
	}
}

?>