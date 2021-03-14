<?php


//$clock_work =  array("2019-12-27 00:00~00:00", "2019-12-28 00:00~00:00", "2019-12-29 12:00~17:00");
//$clock_break = array();
//$midnightRange = "23:00~06:00";





//$figureArray_work = getFigureArray_work($clock_work);
//$figureArray_break = getFigureArray_break($clock_break);
//$figureArray = getFigureArray_remix($figureArray_work, $figureArray_break);
//for($i = 0; $i < 24; $i++){
//	echo "$i->".$figureArray[$i]."<br>";
//}
//echo "Total: ".array_sum($figureArray);
//echo "(normal:".getWorkTimeLength_normal($figureArray, $midnightRange)." / midnight: ".getWorkTimeLength_midnight($figureArray, $midnightRange).")";

function getSalary($path, $date){
	require_once($path."getWorkTime.php");

	$figureArray_work = getFigureArray_work(getClockRecordCombo($path, $date, "ON/OFF"));
 	$figureArray_break = getFigureArray_break(getClockRecordCombo($path, $date, "BREAK"));
 	$figureArray = getFigureArray_remix($figureArray_work, $figureArray_break);

	$timeRange_midnight = getMidnightTime($path);
	$workTime_normal_length = getWorkTimeLength_normal($figureArray, $timeRange_midnight);
	$workTime_midnight_length = getWorkTimeLength_midnight($figureArray, $timeRange_midnight);
	$workTime_midnight_length_caculated =  $workTime_midnight_length * getSpecialRate($path, $date, "MIDNIGHT");

	$salary = ($workTime_normal_length + $workTime_midnight_length_caculated) / 60 * getBasicSalary_fromRecord($path, $date);
	$salary = getSalary_specialDay($path, $date, $salary);

	$salary = round($salary,2);

	if($salary > 0){
		return "$ <span class='salaryText'>$salary<span>";
	}else{
		return "";
	}
	
}

function getSalary_num($path, $date){
	require_once($path."getWorkTime.php");

	$figureArray_work = getFigureArray_work(getClockRecordCombo($path, $date, "ON/OFF"));
 	$figureArray_break = getFigureArray_break(getClockRecordCombo($path, $date, "BREAK"));
 	$figureArray = getFigureArray_remix($figureArray_work, $figureArray_break);

	$timeRange_midnight = getMidnightTime($path);
	$workTime_normal_length = getWorkTimeLength_normal($figureArray, $timeRange_midnight);
	$workTime_midnight_length = getWorkTimeLength_midnight($figureArray, $timeRange_midnight);
	$workTime_midnight_length_caculated =  $workTime_midnight_length * getSpecialRate($path, $date, "MIDNIGHT");

	$salary = ($workTime_normal_length + $workTime_midnight_length_caculated) / 60 * getBasicSalary_fromRecord($path, $date);
	$salary = getSalary_specialDay($path, $date, $salary);

	$salary = round($salary,2);

	return $salary;
	
}


// ====================================== [S] Get Clock Records ====================================== 
function getClockRecordCombo($path, $date, $type){
	require_once($path."/page/index/get_clock.php");

	if($type == "ON/OFF"){
		$workTime_start = getClock_time($path, $date, "上班");
  		$workTime_end = getClock_time($path, $date, "下班");

  		date_default_timezone_set("Asia/Taipei");
		if($date == date("Y-m-d", time()) && mb_strlen($workTime_start,"utf-8") == 5 && mb_strlen($workTime_end,"utf-8") == 0){
			$workTime_end = date("H:i", time()); 
		}

		if(strrpos($workTime_start, ":") != 2){
		    return array();
		}else{
		    return  array("$date $workTime_start~$workTime_end");
		}
	}elseif($type == "BREAK"){
		$clock_break = explode("@@", getClock_time_break_nonFormated($path, $date)); 

		for($i = 0; $i < count($clock_break); $i++){
    		$clock_break[$i] = $date." ".$clock_break[$i];
		}

		return $clock_break;
	}

}
// ====================================== [E] Get Clock Records ====================================== 


// ====================================== [S] Get User Default ====================================== 
function getBasicSalary_fromRecord($path, $date){
  require_once($path."getData.php");

  //SELECT `cr_baseSalary` FROM `clockrecord` WHERE `cr_Date` = '2020-01-14' AND `cr_Type` = '上班'
  $salary_basic = floatval(explode("@br@",getData_String("cr_baseSalary", "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", ""))[0]);


  return $salary_basic;
} 


function getSpecialRate($path, $date, $type){
  require_once($path."getData.php");

  if($type == "OFFDAY"){
  	$command_isSpeicalRate = "cr_isPay_off";
  	$command_specialRate = "休息日加班率";
  }elseif($type == "HOLIDAY"){
  	$command_isSpeicalRate = "cr_isPay_holiday";
  	$command_specialRate = "國定假日加班率";
  }elseif($type == "MIDNIGHT"){
  	$command_isSpeicalRate = "";
  	$command_specialRate = "早夜津貼率";
  }else{
  	return 0;
  }
  

  $isSpecialDay = intval(explode("@br@",getData_String($command_isSpeicalRate, "clockrecord", "(cr_Date = '$date' AND cr_Type = '上班')", ""))[0]);

  if($isSpecialDay == 1 || $command_isSpeicalRate == ""){
    $specialRate = floatval(explode("@br@",getData_String("ud_value", "userdefault", "(ud_title = '$command_specialRate')", ""))[0]);
    return $specialRate;
  }

  return 0;

}

function getSalary_specialDay($path, $date, $originalSalary){
	$specialRate_offDay = getSpecialRate($path, $date, "OFFDAY");
	$specialRate_holiday = getSpecialRate($path, $date, "HOLIDAY");
  

  if($specialRate_offDay > 0){
    $originalSalary *= $specialRate_offDay;
  }

  if($specialRate_holiday > 0){
    $originalSalary *= $specialRate_holiday;
  }

  return $originalSalary;
}

// ====================================== [E] Get User Default ====================================== 



// ====================================== [S] Get Basic Work Array ====================================== 


function getFigureArray_work($work){
	 $figureArray = array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

	 for($j = 0; $j < count($work); $j++){
	 	$thisTimeWork = explode("~", explode(" ", $work[$j])[1]);
	 	if(strrpos($thisTimeWork[1], ":") != 2){
	 		date_default_timezone_set("Asia/Taipei");
			$thisTimeWork[1] = date("H:i", time());
	 	}

	 	$startTime_array = explode(":", $thisTimeWork[0]);
	 	$endTime_array = explode(":", $thisTimeWork[1]);

	 	for($i = intval($startTime_array[0]); $i <= intval($endTime_array[0]); $i++){
		 	if(intval($startTime_array[0]) == $i){
		 		if($i == intval($endTime_array[0])){
		 			$figureArray[$i] += intval($endTime_array[1]) - intval($startTime_array[1]);
		 		}else{
		 			$figureArray[$i] += 60 - intval($startTime_array[1]);
		 		}
		 	}elseif(intval($endTime_array[0]) == $i){
		 		$figureArray[$i] += intval($endTime_array[1]);
		 	}else{
		 		$figureArray[$i] += 60;
		 	}
		 }


	 }
	 
	 

	 return  $figureArray;
}

function getFigureArray_break($break){
	 $figureArray = array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

	 for($j = 0; $j < count($break); $j++){
	 	$thisTimeBreak = explode("~", explode(" ", $break[$j])[1]);

	 	if(strrpos($thisTimeBreak[0], ":") != 2){
	 		continue;
	 	}


	 	if(strrpos($thisTimeBreak[1], ":") != 2){
	 		date_default_timezone_set("Asia/Taipei");
	 		$start = "2014-06-01 ".$thisTimeBreak[0].":00";
			$thisTimeBreak[1] =  date("H:i",strtotime("+30 minutes",strtotime($start)));
	 	}

	 	$startTime_array = explode(":", $thisTimeBreak[0]);
	 	$endTime_array = explode(":", $thisTimeBreak[1]);

	 	//echo "--> ".$thisTimeBreak[0]."/".$thisTimeBreak[1]."<br>";

	 	for($i = intval($startTime_array[0]); $i <= intval($endTime_array[0]); $i++){

		 	if(intval($startTime_array[0]) == $i){
		 		if($i == intval($endTime_array[0])){
		 			$figureArray[$i] += intval($endTime_array[1]) - intval($startTime_array[1]);
		 		}else{
		 			$figureArray[$i] += 60 - intval($startTime_array[1]);
		 		}
		 	}elseif(intval($endTime_array[0]) == $i){
		 		$figureArray[$i] += intval($endTime_array[1]);
		 	}else{
		 		$figureArray[$i] += 60;
		 	}
		 }

	 }

	 return  $figureArray;
}

function getFigureArray_remix($workFigureArray, $breakFigureArray){
	for($i = 0; $i <= 23; $i++){
		if($workFigureArray[$i] == 0){
	 		continue;
	 	}

		$workFigureArray[$i] -= $breakFigureArray[$i];
	}

	return $workFigureArray;
}
// ====================================== [E] Get Basic Work Array ====================================== 

// ====================================== [S] Get Work Time Length ======================================

function getWorkTimeLength_normal($remixFigureArray, $timeRange_midnight){
	$timeRange_midnight = explode("~", $timeRange_midnight);
	$startTime = explode(":", $timeRange_midnight[1]);
	$endTime = explode(":", $timeRange_midnight[0]);

	//ex. 23~06
	$totalTimeLength_minute = 0;
	for($i = intval($startTime[0]); $i < intval($endTime[0]); $i++){
		$totalTimeLength_minute += $remixFigureArray[$i];
	}


	return $totalTimeLength_minute;
} 

function getWorkTimeLength_midnight($remixFigureArray, $timeRange_midnight){
	$timeRange_midnight = explode("~", $timeRange_midnight);
	$startTime = explode(":", $timeRange_midnight[0]);
	$endTime = explode(":", $timeRange_midnight[1]);

	//ex. 23~06
	$totalTimeLength_minute = 0;

	$i= intval($startTime[0]);
	do{
		$totalTimeLength_minute += $remixFigureArray[$i];

		if($i == (intval($endTime[0])-1)){
			break;
		}elseif($i == 23){
			$i = 0;
		}else{
			$i++;
		}
	} while (1);


	return $totalTimeLength_minute;
} 

// ====================================== [E] Get Work Time Length ======================================


// ====================================== [S] Calculate Salary ======================================

// ====================================== [E] Calculate Salary ======================================
 

?>