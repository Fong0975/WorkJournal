<?php

function getClock_time($path, $date, $type){
	require_once($path."getData.php");
	// echo getData_String("cr_ID", "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", "")."<BR>";

	// SELECT `cr_Time` FROM `clockrecord` WHERE `cr_Date` = '2019-12-18' AND `cr_Type` = '上班'
	$clockTime = "";
	$clockTime = explode("@br@",getData_String("cr_Time", "clockrecord", "(cr_Date = '$date' AND cr_Type = '$type')", ""))[0];

	return $clockTime;
}

function getClock_time_break($path, $date){
	require_once($path."getData.php");

	$breakTime = explode("@br@",getData_String("cr_Time", "clockrecord", "(cr_Date = '$date' AND cr_Type = '休息開始')", "ORDER BY cr_Time"));
	$returnTime = explode("@br@",getData_String("cr_Time", "clockrecord", "(cr_Date = '$date' AND cr_Type = '休息結束')", "ORDER BY cr_Time"));

	$count = (count($breakTime) > count($returnTime))? count($breakTime):count($returnTime);

	$str = "";
	for($i = 0; $i < $count; $i++){
		if(isset($breakTime[$i])){
			$break_thisTime = $breakTime[$i];
		}else{
			$break_thisTime = "";
		}

		if(isset($returnTime[$i])){
			$return_thisTime = $returnTime[$i];
		}else{
			$return_thisTime = "";
		}

		if(mb_strlen($break_thisTime, "utf-8") == 5 || mb_strlen($return_thisTime, "utf-8") == 5){
			$str .= "<span style='margin-right: 20px;'>$break_thisTime ～ $return_thisTime</span>";
		}
		
	}

	return $str;
}


function getClock_time_break_nonFormated($path, $date){
	require_once($path."getData.php");

	$breakTime = explode("@br@",getData_String("cr_Time", "clockrecord", "(cr_Date = '$date' AND cr_Type = '休息開始')", "ORDER BY cr_Time"));
	$returnTime = explode("@br@",getData_String("cr_Time", "clockrecord", "(cr_Date = '$date' AND cr_Type = '休息結束')", "ORDER BY cr_Time"));

	$count = (count($breakTime) > count($returnTime))? count($breakTime):count($returnTime);

	$str = "";
	for($i = 0; $i < $count; $i++){
		if(isset($breakTime[$i])){
			$break_thisTime = $breakTime[$i];
		}else{
			$break_thisTime = "";
		}

		if(isset($returnTime[$i])){
			$return_thisTime = $returnTime[$i];
		}else{
			$return_thisTime = "";
		}

		if(mb_strlen($break_thisTime, "utf-8") == 5 || mb_strlen($return_thisTime, "utf-8") == 5){
			$str .= "$break_thisTime~$return_thisTime@@";
		}
		
	}

	return $str;
}

?>