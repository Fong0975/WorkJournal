<?php

function isScheduled($path, $date){
	require_once($path."get_scheduling.php");

	$schedulingTimeRange = getScheduling_workTime_string($date);
	if($schedulingTimeRange == "尚未排班"){
		return false;
	}else{
		return true;
	}
}

function getInformationContent_scheduling($path, $date){
	require_once($path."get_scheduling.php");

	$schedulingTimeRange = getScheduling_workTime_string($date);
	$workTimeSpan_nonBreak = getScheduling_workTimeSpan($date, "");
	$workTimeSpan_withBreak = getScheduling_workTimeSpan($date, "WITH_BREAKTIME");
	$schedulingStation = getScheduling_station($date);
	$scheduling_image_path = getScheduling_image_path($date);
	$scheduling_image_name = getScheduling_image_name($date);
	$scheduling_salary = getScheduling_salary($date);


	$str = "<table>
           <tr>
             <td class=\"content_title\"><i class=\"far fa-calendar-minus\"></i>預排期間</td>
             <td id=\"timer_time\" class=\"content_value\">". (($schedulingTimeRange == "X")? "休假":$schedulingTimeRange )."</td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-clock\"></i>預排時間</td>
             <td class=\"content_value\"><span id=\"timer_schedulingTime\">$workTimeSpan_nonBreak</span> <span style=\"margin-left: 10px;\">$workTimeSpan_withBreak</span></td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-utensils\"></i>預排崗位</td>
             <td class=\"content_value\">$schedulingStation</td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-image\"></i>預排班表</td>
             <td class=\"content_value\"><a href=\"$scheduling_image_path\">$scheduling_image_name</a></td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-chart-bar\"></i>預估薪資</td>
             <td class=\"content_value\">NT. $scheduling_salary</td>
           </tr>
         </table>";


	return $str;
}

function getInformationContent_clock($path, $date){
  require_once($path."get_clock.php");

  $path = str_replace("page/index/", "", $path);
  require_once($path."getSalary_money.php");

  $clock_work = getClockRecordCombo($path, $date, "ON/OFF");
  $clock_break = getClockRecordCombo($path, $date, "BREAK");

  $workTimeArray = explode("~",explode(" ", $clock_work[0])[1]);
  $workTime_start = $workTimeArray[0];
  $workTime_end = $workTimeArray[1];

  $figureArray_work = getFigureArray_work($clock_work);
  $figureArray_break = getFigureArray_break($clock_break);
  $figureArray = getFigureArray_remix($figureArray_work, $figureArray_break);


  //session1. WorkTime - string and length
  $workTime_string = "$workTime_start ～ $workTime_end";
  $workTime_length = array_sum($figureArray_work);
  $workTime_length_string = getWorkTimeLength_string($path, $date, $workTime_length);

  //session2. BreakTime - actual
  $breakTimeString_actual = getClock_time_break($path, $date);
  

  $breakTimeLength_actual = array_sum($figureArray_break);
  $breakTimeLengthString_actual = "";
  if($breakTimeLength_actual > 0){
    $breakTimeLengthString_actual = "($breakTimeLength_actual 分鐘)";
  }else{
    $breakTimeString_actual = "無";
  }


  //session3. WorkTime - Midnight
  $timeRange_midnight = getMidnightTime($path);
  $workTime_midnight_length = getWorkTimeLength_midnight($figureArray, $timeRange_midnight);

  //session4. WorkTime - Normal
  $workTime_normal_length = getWorkTimeLength_normal($figureArray, $timeRange_midnight);

  //session5. WorkTime - Final
  $workTimeLength_final = $workTime_length - $breakTimeLength_actual;

  //session8. Salary - Final
  $workTime_midnight_length_caculated =  $workTime_midnight_length * getSpecialRate($path, $date, "MIDNIGHT");
  $salary = ($workTime_normal_length + $workTime_midnight_length_caculated) / 60 * getBasicSalary_fromRecord($path, $date);
  $salary = getSalary_specialDay($path, $date, $salary);


  $str = "<table style=\"margin-top: -20px;\">
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-clock\"></i>工作時段</td>
             <td class=\"content_value\">".$workTime_string."<span style=\"margin-left:20px; color: #999999; font-size: 12pt;\">$workTime_length_string</span></td>
           </tr>
           <tr><td class=\"\" colspan=\"2\" style=\"font-size: 12pt; text-align: left; padding-left: 20px; padding-bottom: 20px;\"><i class=\"fas fa-exclamation\"></i>若尚未下班，系統會自動計算到當下時間。</td></tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-hourglass-half\"></i>休息時間<span style=\"margin-left:5px; color: #666666; font-size: 14pt;\">(實際)</span></td>
             <td class=\"content_value\">".$breakTimeString_actual."<span style=\"margin-left:20px; color: #999999; font-size: 12pt;\">$breakTimeLengthString_actual</span></td>
           </tr>
           <tr><td class=\"infomationPart_bottom\" colspan=\"2\" style=\"font-size: 12pt; text-align: left; padding-left: 20px; padding-bottom: 20px;\"><i class=\"fas fa-exclamation\"></i>若返回打卡紀錄有缺漏，系統會自動計算到30分鐘後。</td></tr>
           <tr><td class=\"infomationPart_title\" colspan=\"2\">薪資試算</tr>
           <tr>
             <td class=\"content_title\" style=\"padding-bottom: 15px;\"><i class=\"fas fa-stopwatch\"></i>實際工時</td>
             <td class=\"content_value\" style=\"padding-bottom: 15px;\">".getFormatTimeString_minute($workTimeLength_final)."</td>
           </tr>
           <tr>
             <td class=\"content_title\" style=\"font-size: 14pt; padding-left: 30px; padding-bottom: 10px; padding-top: 0px; color: #9c9c9c;\"><i class=\"fas fa-cloud-moon\"></i>工作時間(早夜)</td>
             <td class=\"content_value\" style=\"padding-top: 0px; padding-bottom: 10px; font-size: 14pt; padding-left: 30px; color: #9c9c9c;\">".getFormatTimeString_minute($workTime_midnight_length)."</td>
           </tr>
           <tr>
             <td class=\"content_title\" style=\"font-size: 14pt; padding-left: 30px; padding-top: 0px; color: #9c9c9c;\"><i class=\"fas fa-sun\"></i>工作時間(正常)</td>
             <td class=\"content_value\" style=\"padding-top: 0px; font-size: 14pt; padding-left: 30px; color: #9c9c9c;\">".getFormatTimeString_minute($workTime_normal_length)."</td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-money-bill-wave\"></i>薪資試算</td>
             <td class=\"content_value\">NT. ".round($salary,2)."</td>
           </tr>
         </table>";


  return $str;
}

function getInformationContent_journal($path, $date){
  require_once($path."get_journal.php");

  $journalData = getJournal($date);


  $str = "<table>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-coins\"></i>基本薪資</td>
             <td class=\"content_value\">".floatval($journalData[2])." 元/時</td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-hand-holding-usd\"></i>休假日</td>
             <td class=\"content_value\">".(($journalData[3])? "是":"否")."</td>
           </tr>
           <tr>
             <td class=\"content_title\"><i class=\"fas fa-mug-hot\"></i>國定假日</td>
             <td class=\"content_value\">".(($journalData[4])? "是":"否")."</td>
           </tr>
         </table>";


  return $str;
}

// ================================ Get Information Variable ================================ 
function getWorkTimeLength($path, $date, $workTime_start, $workTime_end){
  require_once($path."getSalary.php");
  

  $totalWorkTime_minute = floatval(getWorkTime_range_minute($workTime_start, $workTime_end));

  return $totalWorkTime_minute;
}

function getWorkTimeLength_string($path, $date, $totalWorkTime_minute){
  require_once($path."getSalary.php");
  require_once($path."getWorkTime.php");

  if(isRightCount_on_off($path, $date) == "true"){
    return "(".getFormatTimeString_minute($totalWorkTime_minute).")";
  }else{
    return "(尚未開始上班)";
  }
}

function getSchedulingBreak($path, $workTime_start, $workTime_end){
  require_once($path."getWorkTime.php");

  $workTime_minute = floatval(getWorkTime_range_minute($workTime_start, $workTime_end));

  return getWorkTime_break_time($workTime_minute);
}

function getActualBreak_times($path, $date){
  require_once($path."getSalary.php");

  return getCount_break($path, $date);
}

function getBreakTimeLength($path, $date, $breakTime_string){
  require_once($path."getSalary.php");
  
  if(isRightCount_break($path, $date) == "true"){
    require_once($path."getWorkTime.php");

    $breakTime_array = explode("</span><span style='margin-right: 20px;'>", $breakTime_string);
    $totalBreakTime_minute = 0;
    for($i = 0; $i < count($breakTime_array); $i++){
      $breakTimeCombo = explode(" ～ ", $breakTime_array[$i]);
      $breakStart = substr($breakTimeCombo[0],-5);
      $breakEnd = substr($breakTimeCombo[1],0,5);
      // echo $breakStart."/".$breakEnd."=".getWorkTime_range_minute($breakStart, $breakEnd)."<br>";
      $totalBreakTime_minute += floatval(getWorkTime_range_minute($breakStart, $breakEnd));
    }


    return $totalBreakTime_minute;
  }else{
    return 0;
  }
}



?>