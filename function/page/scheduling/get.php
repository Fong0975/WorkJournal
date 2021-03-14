<?php

function getSchedulingTime_start($path){
	require_once($path."getData.php");
	$userDefault = getData_String("ud_value", "userdefault", "ud_title = '排班時間-開始'", "");
	

	if(strlen($userDefault) == 5){
		return $userDefault;
	}else{
		return "08:00";
	}
	
}

function getSchedulingTime_end($path){
	require_once($path."getData.php");
	$userDefault = getData_String("ud_value", "userdefault", "ud_title = '排班時間-結束'", "");
	

	if(strlen($userDefault) == 5){
		return $userDefault;
	}else{
		return "23:00";
	}
	
}



// --------------------------------- get week scheduling --------------------------------- 
function getWeekScheduling_show($path,$y,$m,$d){
	require_once($path."get_scheduling.php");
	
	$monday_d = getMonday($y,$m,$d);
	$monday_m = $m;
	
	if($monday_d > $d){
		$monday_m --;
	}

	
	
	$week=Array("一","二","三","四","五","六","日");
	$str = "";
	
	for($i = 0; $i<7; $i++){
		
		$theDate = date("Y-m-d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")));
		$scheduling_salary = getScheduling_salary($theDate);
		
		$str .= "<p style='margin: 0px 0px;'>".date("Y-m-d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")))." (".$week[$i].")  ".getScheduling_workTime_string($theDate)."<span style='margin-left: 10px; font-size: 12pt; color:#9c9c9c;'>(".number_format($scheduling_salary).")</span>
			 ".getScheduling_station($theDate)."</p><br>";
	}
	
	
	return $str;
}


function getWeekScheduling_copy($path,$y,$m,$d){
	require_once($path."get_scheduling.php");

	$monday_d = getMonday($y,$m,$d);
	$monday_m = $m;
	
	if($monday_d > $d){
		$monday_m --;
	}
	
	$week=Array("一","二","三","四","五","六","日");

	$cal_result=ceil(intval($monday_d)/7);
	if(date('w', strtotime($y."-".$m."-01")) != 1){
		$cal_result ++;
	}



	$str = $monday_m."月の第".$cal_result."個禮拜\n";
	
	for($i = 0; $i<7; $i++){
		$theDate = date("Y-m-d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")));

		$str .= date("Y-m-d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")))." (".$week[$i].")  ".getScheduling_workTime_string($theDate)." ".getScheduling_station($theDate)."\n";
	}
	
	
	return $str;
}

function getWeekScheduling_csv($path,$y,$m,$d){
	require_once($path."get_scheduling.php");
	
	$monday_d = getMonday($y,$m,$d);
	$monday_m = $m;
	
	if($monday_d > $d){
		$monday_m --;
	}

		
	for($i = 0; $i<7; $i++){
		
		$theDate = date("Y-m-d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")));
		$date = date("Y/m/d",strtotime("+$i day",strtotime("$y-$monday_m-$monday_d")));
		$clock = explode("～",getScheduling_workTime_string($theDate));
		if($clock[0] == "X"){continue;}
		$des = str_replace(",", "、", getScheduling_station($theDate));

		$csv_arr[] = array("上班","$date",$clock[0],"$date",$clock[1],$des);
		
	}
	
	
	return $csv_arr;
}

function getMonday($y,$m,$d){
	$weekday =  date("w", mktime(0,0,0,$m,$d,$y));
	$diffDay = 0;
	

	
	if($weekday == 0){
		$diffDay = 6;
	}else{
		$diffDay = ($weekday - 1);
	}
	
	return date("d",strtotime("-$diffDay day",strtotime("$y-$m-$d")));
}

function isExistScheduling($date){
	require_once("function/getData.php");
	$schedulingID_string = getData_String("sr_ID", "schedulingrecord", "sr_Date = '$date'", "");
	$schedulingID = intval($schedulingID_string);

	if($schedulingID > 0){
		return true;
	}else{
		return false;
	}
}

// --------------------------------- get exist scheduling --------------------------------- 
function getScheduled($path, $date){
	require_once($path."getData.php");
	$scheduled_string = explode("@br@", getData_String("*", "schedulingrecord", "sr_Date = '$date'", ""))[0];
	$scheduled_array = explode("/", $scheduled_string);

	return $scheduled_array;
}

function isExistSchedulingImage($path,$date){
	$path = $path.$date;
	
	
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
?>