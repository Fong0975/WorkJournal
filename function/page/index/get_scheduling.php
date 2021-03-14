<?php

function getScheduling_workTime_string($date){

	$startTime = getScheduling_workTime($date, "START");
	$endTime = getScheduling_workTime($date, "END");

	if(mb_strlen($startTime, "utf-8") == 0 || mb_strlen($endTime, "utf-8") == 0 ){
		return "尚未排班";
	}

	$workTime_string = $startTime."～".$endTime;
	if($startTime == "00:00" && $endTime == "00:00"){
		$workTime_string = "X";
	}

	return $workTime_string;
}

function getScheduling_workTime($date, $getType){
	require_once("function/getData.php");

	$scheduling_string = explode("@br@",getData_String("*", "schedulingrecord", "sr_Date = '$date'", ""))[0];
	$scheduling_array = explode("/",$scheduling_string);

	if($getType =="START"){
		$workTime = $scheduling_array[2];
	}elseif($getType == "END"){
		$workTime = $scheduling_array[3];
	}else{
		$workTime = "";
	}

	return $workTime;
}

function getScheduling_workTimeSpan($date, $getType){
	require_once("function/getWorkTime.php");

	$startTime = getScheduling_workTime($date, "START");
	$endTime = getScheduling_workTime($date, "END");
	if($getType == "WITH_BREAKTIME"){
		$difference_of_minute = getWorkTime_range_minute_withBreak($startTime, $endTime);
	}else{
		$difference_of_minute = getWorkTime_range_minute($startTime, $endTime);
	}
	
	if($difference_of_minute == 0){return "";}

	$hr = sprintf("%d", floor($difference_of_minute / 60));
	$min = sprintf("%d", floor($difference_of_minute % 60));

	$str_TimeSpan = "";
	if($hr > 0){
		$str_TimeSpan .= $hr."小時";
		if($min > 0){$str_TimeSpan .= " ".$min."分鐘";}

	}else{
		$str_TimeSpan .= $min."分鐘";
	}

	if($getType == "WITH_BREAKTIME"){
		return "(扣除休息時間：$str_TimeSpan)";
	}else{
		return $str_TimeSpan;
	}

}

function getScheduling_station($date){
	$schedulingStation_string = explode("@br@",getData_String("sr_Station", "schedulingrecord", "sr_Date = '$date'", ""))[0];

	return $schedulingStation_string;
}

function getScheduling_image_name($date){
	$path = "images/scheduling/".$date;
	
	
	if(file_exists($path.".png")){
		return $date.".png";
	}elseif(file_exists($path.".jpeg")){
		return $date.".jpeg";
	}elseif(file_exists($path.".jpg")){
		return $date.".jpg";
	}else{
		return "";
	}
}

function getScheduling_image_path($date){
	$path = "images/scheduling/".$date;
	
	
	if(file_exists($path.".png")){
		return $path.".png";
	}elseif(file_exists($path.".jpeg")){
		return $path.".jpeg";
	}elseif(file_exists($path.".jpg")){
		return $path.".jpg";
	}else{
		return "";
	}
}

function getScheduling_salary($date){
	require_once("function/getWorkTime.php");
	require_once("function/getSalary.php");

	$startTime = getScheduling_workTime($date, "START");
	$endTime = getScheduling_workTime($date, "END");
	$schedulingWorkTime = getWorkTime_range_minute_withBreak($startTime, $endTime);

	$salary_float = floatval(getSalary_withMinute("function/", $schedulingWorkTime));
	if($salary_float > 0){
		$salary_string = sprintf("%02d", $salary_float);
	}else{
		$salary_string = $salary_float;
	}
	

	return $salary_string;
}


?>