<?php

$dateArray = $_POST["weekScheduling_date"];
$startTimeArray = $_POST["weekScheduling_time_start"];
$endTimeArray = $_POST["weekScheduling_time_end"];
// $filesArray = $_FILES["schedulingFile"];
$stationArray = array(getStrStation($_POST["schedulingStation_0"]), getStrStation($_POST["schedulingStation_1"]), getStrStation($_POST["schedulingStation_2"]), getStrStation($_POST["schedulingStation_3"]), getStrStation($_POST["schedulingStation_4"]), getStrStation($_POST["schedulingStation_5"]), getStrStation($_POST["schedulingStation_6"]));

for($i = 0; $i < 7; $i++){
	$startTime = substr($startTimeArray[$i], 0, 2).":".substr($startTimeArray[$i], -2);
	$endTime = substr($endTimeArray[$i], 0, 2).":".substr($endTimeArray[$i], -2);
	insertScheduling($dateArray[$i],$startTime, $endTime, $stationArray[$i]);
}

echo "[DATE]<br>".implode("<br>", $dateArray)."<br><br>" ;
echo "[START TIME]<br>".implode("<br>", $startTimeArray)."<br><br>" ;
echo "[END TIME]<br>".implode("<br>", $endTimeArray)."<br><br>" ;
// echo "[FILES]<br>".checkFiles($dateArray, $filesArray, "<br>")."<br><br>" ;
echo "[STATION]<br>".implode("<br>", $stationArray)."<br><br>" ;

header("Location: ../../../" );
exit;


function insertScheduling($DATE,$START, $END,$STATION){
	require "../../link_database_info.php";

	$sql_command = "INSERT INTO schedulingrecord (sr_Date, sr_StartTime, sr_EndTime, sr_Station) VALUES ('$DATE','$START','$END', '$STATION')";
	echo $sql_command."<BR>";

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
	
	return !$query;
}

function getStrStation($oriStr){
	$doneStr = "";

	if(count($oriStr) == 0){
		return "";
	}

	try {
	    foreach ($oriStr as $value) {
		    if($doneStr != ""){
		    	$doneStr .= ",".$value;
		    }else{
		    	$doneStr = $value;
		    }
		}

	} catch (Exception $e) {
	    
	}

	return $doneStr;
}

?>