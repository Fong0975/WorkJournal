<?php

// judge before calculation
function isRightCount_on_off($path, $date){
	require_once($path."getData.php");
	//SELECT COUNT(`cr_ID`) FROM `clockrecord` WHERE (`cr_Date` = '2019-12-18' AND `cr_Type` ='休息開始')
	$count_on = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='上班')", ""))[0]);
	$count_off = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='下班')", ""))[0]);

	// echo "$count_break / $count_retur = ".($count_break == $count_return)."&".($count_break == 0);

	if($count_on == 1){
		return "true";
	}else{
		return "false";
	}

}

function isRightCount_break($path, $date){
	require_once($path."getData.php");
	//SELECT COUNT(`cr_ID`) FROM `clockrecord` WHERE (`cr_Date` = '2019-12-18' AND `cr_Type` ='休息開始')
	$count_break = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='休息開始')", ""))[0]);
	$count_return = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='休息結束')", ""))[0]);

	// echo "$count_break / $count_retur = ".($count_break == $count_return)."&".($count_break == 0);

	if($count_break == $count_return){
		return "true";
	}else{
		return "false";
	}

}

function getCount_break($path, $date){
	require_once($path."getData.php");
	//SELECT COUNT(`cr_ID`) FROM `clockrecord` WHERE (`cr_Date` = '2019-12-18' AND `cr_Type` ='休息開始')
	$count_break = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='休息開始')", ""))[0]);
	$count_return = intval(explode("@br@",getData_String("COUNT(cr_ID)", "clockrecord", "(cr_Date = '$date' AND cr_Type ='休息結束')", ""))[0]);

	// echo "$count_break / $count_retur = ".($count_break == $count_return)."&".($count_break == 0);

	if($count_break > $count_return){
		return $count_return;
	}else{
		return $count_break;
	}

}


function getHourBasicSalary($path){
	require_once($path."getData.php");

	$schedulingStation_string = explode("@br@",getData_String("ud_value", "userdefault", "ud_title = '基本薪資'", ""))[0];

	return floatval($schedulingStation_string);
}


function getSalary_withMinute($path, $minuteTime){
	$basicSalary_perMinute = getHourBasicSalary($path) / 60;

	return $basicSalary_perMinute * $minuteTime;
}

?>