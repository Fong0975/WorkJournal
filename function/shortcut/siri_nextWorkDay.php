<?php

date_default_timezone_set('Asia/Taipei');
$nowDate = date("Y-m-d");

// $date = strtotime('2020/05/06 21:00:00');
// $nowDate = date('Y-m-d', $date);


$todayWork = getSchedulingWork($nowDate);

if(mb_strlen($todayWork[0], "utf-8") == 0){
	echo "尚未有排班資料可供查詢";
}else{
	$todayWorkStatus = getStatus_todayWork($todayWork);
	if($todayWorkStatus == "今天尚未開始工作"){
		echo $todayWorkStatus."，".getNextWork(false, $nowDate);
	}else{
		echo $todayWorkStatus."，".getNextWork(true, $nowDate);
	}
	

}


function getSchedulingWork($date){
	require_once("../getData.php");

	//SELECT * FROM `schedulingrecord` WHERE `sr_Date`
	
	$scheduling_string = explode("@br@",getData_String("sr_StartTime, sr_EndTime, sr_Station", "schedulingrecord", "sr_Date = '".$date."'", ""))[0];
	$scheduling_string = explode("/", $scheduling_string);
	
	return $scheduling_string;
}

function compareTime($time1, $time2){
	$date1 = new DateTime("$time1"); 
	$date2 = new DateTime("$time2"); 
	  
	// Compare the dates 
	if ($date1 > $date2) 
	    return "1"; 
	else
	    return "2"; 
}

function getStatus_todayWork($todayWork_array){

	if($todayWork_array[0] == "00:00" && $todayWork_array[1] == "00:00"){
		return "今天是休假日";
	}

	date_default_timezone_set('Asia/Taipei');
	$nowDate = date("Y-m-d");
	$nowDateTime = date("Y-m-d H:i");

	if(compareTime($nowDate." ".$todayWork_array[0], $nowDateTime) == "1"){
		return "今天尚未開始工作";
	}elseif(compareTime($nowDate." ".$todayWork_array[1], $nowDateTime) == "2"){
		return "今天已經結束工作了";
	}else{
		return "現在正在工作";
	}

}

function get_chinese_weekday($datetime)
{
    $weekday = date('w', strtotime($datetime));
    return '星期' . ['日', '一', '二', '三', '四', '五', '六'][$weekday];
}

function getNextWork($isTodayEndWork, $nowDate){

	$i = 0;
	if($isTodayEndWork){
		$i++;
	}
	$returnArray = array();

	$lastDays = 7- date('w',strtotime($nowDate. "+".$i." days"));

	do{
		// $dateStr = strtotime('');
		// $date = date( $dateStr);

		// $date->modify("+".$i." day");
		// $date = $date->format('Y-m-d');

		$Date = "$nowDate";
		$date = date('Y-m-d', strtotime($Date. "+".$i." days"));
		
		// echo $date;

		$workArray = getSchedulingWork($date);
		// echo "<br>$i->$date : ".$workArray[0]."~".$workArray[1]." ".$workArray[2];

		if(mb_strlen($workArray[0], "utf-8") == 5 && $workArray[0] != "00:00"){
			$dateNickname = "";
			if($i == 0){
				$dateNickname = "今天 ";
			}elseif($i == 1){
				$dateNickname = "明天 ";
			}if($i == 2){
				$dateNickname = "後天 ";
			}

			$returnArray = array($dateNickname, $date, $workArray[0], $workArray[1], $workArray[2]);
			break;
		}else{
			$returnArray = array();
			// break;
		}

		$i++;
	} while ( $i <= $lastDays );


	//get Countdown
	$diff = get_CountdownNext($returnArray[1]." ".$returnArray[2]);


	$newDateFormat = date('m月d日', strtotime($returnArray[1]));
	if(count($returnArray) == 0){
	return "目前尚未有下次上班的排班資料";
	}else{
		return "下次上班是 ".$returnArray[0].$newDateFormat." ".get_chinese_weekday($returnArray[1])." 的 ".$returnArray[2]." 到 ".$returnArray[3]."，工作崗位是：".$returnArray[4].$diff;
	}
	
}

function get_CountdownNext($nextStartTime){
	$nowDateTime = new DateTime('now');
	$workDateTime = new DateTime($nextStartTime.':00');

	$diff = $workDateTime->getTimestamp() - $nowDateTime->getTimestamp();

	if($diff > 86400){
		return "， 距離下次上班時間約還有".foo($diff);
	}else{
		return "， 距離下次上班時間約還有".foo($diff);
	}
	
}

function foo($seconds) {
  $t = round($seconds);

  $diff_day = intval($t/86400);
  $t -= ($diff_day * 86400);

  $diff_hour = intval($t/3600);
  $diff_minute = intval($t/60%60);

  $diff_str = "";
  if($diff_day > 0){
  	$diff_str .= $diff_day."日";
  }

  if($diff_hour > 0){
  	$diff_str .= $diff_hour."小時";
  }

  if($diff_minute > 0){
  	$diff_str .= $diff_minute."分鐘";
  }

  return $diff_str;
}

?>