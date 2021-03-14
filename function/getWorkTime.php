<?php

function getWorkTime_range_minute($start, $end){
	$s_date="2015-10-17 $start:00";
	$e_date="2015-10-17 $end:00";


	$second1=floor((strtotime($e_date)-strtotime($s_date)));//兩個日期時間 相差 幾秒
	$diffMin = floor(($second1%86400)/3600) * 60 + floor((($second1%86400)%3600)/60);

	return $diffMin;
}

function getWorkTime_range_minute_withBreak($start, $end){
	$s_date="2015-10-17 $start:00";
	$e_date="2015-10-17 $end:00";


	$second1=floor((strtotime($e_date)-strtotime($s_date)));//兩個日期時間 相差 幾秒
	$diffMin = floor(($second1%86400)/3600) * 60 + floor((($second1%86400)%3600)/60);


	$breakTimes = getWorkTime_break_time($diffMin);
	$breakTime_minute = 30 * $breakTimes;
	$diffMin -= $breakTime_minute;

	return $diffMin;
}


function getMidnightTime($path){
	require_once($path."getData.php");

	$midnightTime_morning = explode("@br@",getData_String("ud_value", "userdefault", "(ud_title = '早夜津貼時間')", ""))[0];

	return $midnightTime_morning;
}


function getWorkTime_break_time($workTime_minute){
	$breakTime_Scheduling = 0;

	if($workTime_minute >= 270){
		do{
			$workTime_minute -= 270;
			$breakTime_Scheduling ++;
		} while ( $workTime_minute >= 270 );
	}
		
	return $breakTime_Scheduling;
}

function getFormatTimeString_minute($minute){
	$hr = 0;
	$min = $minute;

	if($min < 60){
		return $min." 分鐘";
	}

	do{
	    $min -= 60;
	    $hr += 1;
	} while ($min >= 60);

	if($min > 0){
		return $hr." 小時".$min." 分鐘";
	}else{
		return $hr." 小時";
	}
}

?>