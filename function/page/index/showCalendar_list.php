<?php
function showFrame_Header($weekNumber_this, $YEAR){
	echo "<table style=\"\">
        <tr>
          <td style=\"padding: 0px;\">
            <table class=\"tableTitle-backgroundColor\">
              <tr>
                <td>
                  <a href=\"".getWeekNumberFirstDay($weekNumber_this-2, $YEAR)."\">
                    <span class=\"statisticsTitle_middle\">".($weekNumber_this-2)."<span style=\"font-size: 30%;\"> 周</span></span>
                    <br>
                    <span class=\"statisticsContent_mini\">".getWeekNumberRange($weekNumber_this-2, $YEAR)."</span>
                  </a>
                </td>

                <td>
                  <a href=\"".getWeekNumberFirstDay($weekNumber_this-1, $YEAR)."\">
                    <span class=\"statisticsTitle_middle\">".($weekNumber_this-1)."<span style=\"font-size: 30%;\"> 周</span></span>
                    <br>
                    <span class=\"statisticsContent_mini\">".getWeekNumberRange($weekNumber_this-1, $YEAR)."</span>
                  </a>
                </td>

                <td class=\"tableTitle-backgroundColor_selected\">
                  <span class=\"statisticsTitle_middle\">".$weekNumber_this."<span style=\"font-size: 30%;\"> 周</span></span>
                  <br>
                  <span class=\"statisticsContent_mini\">".getWeekNumberRange($weekNumber_this, $YEAR)."</span>
                </td>

                <td>
                  <a href=\"".getWeekNumberFirstDay($weekNumber_this+1, $YEAR)."\">
                    <span class=\"statisticsTitle_middle\">".($weekNumber_this+1)."<span style=\"font-size: 30%;\"> 周</span></span>
                    <br>
                    <span class=\"statisticsContent_mini\">".getWeekNumberRange($weekNumber_this+1, $YEAR)."</span>
                  </a>
                </td>

                <td>
                  <a href=\"".getWeekNumberFirstDay($weekNumber_this+2, $YEAR)."\">
                    <span class=\"statisticsTitle_middle\">".($weekNumber_this+2)."<span style=\"font-size: 30%;\"> 周</span></span>
                    <br>
                    <span class=\"statisticsContent_mini\">".getWeekNumberRange($weekNumber_this+2, $YEAR)."</span>
                  </a>
                </td>
              </tr>
            </table>
          </td>
          
          <td id=\"datepickerDIV\" class=\"tableTitle-backgroundColor\" style=\"border-left: 1.5px solid #FFF; padding: 0px; margin: 0px; text-align: center;\"><i class=\"fas fa-calendar-alt\"></i><input class=\"tableTitleButton-input\" type=\"text\" id=\"datepicker\" readonly=\"true\"></td>
        </tr>
      </table>
      ";
}

function showFrame_JS($YEAR, $MONTH, $DAY){
	echo "<script>
     $(function () {
        $(\"#datepicker\").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: \"mm/dd\",
            onSelect: function(dateText) { 
                var date = $(this).datepicker('getDate'),
                    day  = date.getDate(),  
                    month = date.getMonth() + 1,              
                    year =  date.getFullYear();
                window.location.href = \"?y=\"+year+\"&m=\"+month+\"&d=\"+day;
            }
        }).datepicker(\"setDate\", new Date(\"$YEAR-$MONTH-$DAY\"));

        $('#datepickerDIV').click(function () {
            //alert('clicked');
            $('#datepicker').datepicker('show');
        });

    });


    $(document).ready(function(){
      var element = $(\"#$YEAR-$MONTH-$DAY\");
      element.css('outline', 'none !important')
       .attr(\"tabindex\", -1)
       .focus();
    })
    
  </script>
  <script type=\"text/javascript\">

    function showInformationBox(redY, redM, redD){
      window.location.href=\"index_showDetail.php?y=\"+ redY + \"&m=\" + redM + \"&d=\" + redD;
    }

  </script>
  <script type=\"text/javascript\">
    // document.getElementsByTagName('td').innerHTML
    var monthStatistics_salary = parseFloat(".getStatistics_salary($YEAR,$MONTH).");

    var monthStatistics_salary_withScheduling = sumFutureWorkTime() + parseFloat(monthStatistics_salary);
    monthStatistics_salary_withScheduling = Math.round(monthStatistics_salary_withScheduling * 100) / 100;

    

    document.getElementById(\"monthStatistics_salary\").innerHTML = toCurrency(monthStatistics_salary) + \" / \" + toCurrency(monthStatistics_salary_withScheduling);
    document.getElementById(\"monthStatistics_workTime\").innerHTML = toCurrency(getTotalWorkTime_month())+\" 小時\";
    document.getElementById(\"monthStatistics_workDay\").innerHTML = ".getStatistics_dayNumber_realWork($YEAR,$MONTH)." +\" / \"+ ".getStatistics_dayNumber_schedulingWork($YEAR,$MONTH)." +\" 天\";
    document.getElementById(\"monthStatistics_breakDay\").innerHTML = (getMonthLastDay()  - ".getStatistics_dayNumber_schedulingWork($YEAR,$MONTH).") +\" 天\";

    formatFutureWorkTime();


    function sumFutureWorkTime(){
      var basicSalary = parseFloat(document.getElementById(\"userDefault_basicSalary\").innerHTML);

      var totalTime = ".getStatistics_schedulingWorkTimeMinute($YEAR,$MONTH).";

      return Math.round((totalTime * basicSalary / 60) * 100) / 100;

      
    }

    function getTotalWorkTime_month(){
      totalTime = ".getStatistics_workTimeMinute($YEAR,$MONTH).";
      totalTime = totalTime / 60;

      return Math.round(totalTime * 100) / 100;
    }

    function getMonthLastDay(){
      //var date = new Date();
      var y = ".$YEAR.";//date.getFullYear();
      var m = ".(intval($MONTH)-1).";//date.getMonth();
      var lastDay = new Date(y, m + 1, 0).getDate();

      return lastDay;
    }

    function toCurrency(num){
      var parts = num.toString().split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return parts.join('.');
    }

    function formatFutureWorkTime(){
      var elems = document.getElementsByClassName(\"workTime\");

      var totalTime = 0;
      for (i = 0; i < elems.length; i++) { 
        if(elems[i].textContent == \"\" || elems[i].textContent == \" \"){
          continue;
        }

        var one = parseInt(elems[i].textContent);
        var hr = Math.floor(one / 60);
        var min = Math.floor(one % 60);

        var str = min + \" 分鐘\";
        if(hr > 0){
          str = \"\" + hr + \" 小時\" + str;
        }else{
          str = \"\" + str;
        }

        elems[i].innerHTML = str;
      }
    }
  
  </script>";
}

function showCanendar($YEAR,$MONTH,$DAY){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	
	$today_weekday = date('w', strtotime("$YEAR/$MONTH/$DAY"));
	if($today_weekday == 0){ $today_weekday += 7;}
	$firstDay_date = date('Y/m/d', strtotime("$YEAR/$MONTH/$DAY" . ' -'.($today_weekday-1).' day'));
	
	$str="";
	
	$index = 1;
	for($i = 1; $i <= 7 ; $i++){
		$thisDay_date = date('Y-m-d', strtotime($firstDay_date . ' +'.($i - 1).' day'));
		$thisDay_date_chinese = date('Y年m月d日', strtotime($firstDay_date . ' +'.($i - 1).' day'));
		$thisDay_partY = date('Y', strtotime($thisDay_date));
		$thisDay_partM = date('m', strtotime($thisDay_date));
		$thisDay_partD = date('d', strtotime($thisDay_date));

		if($thisDay_date != date('Y-m-d', strtotime("$YEAR/$MONTH/$DAY"))){
			$css_table = "";
			$css_tableTitle_weekday = "tableTitle_weekday";
			$css_tableTitle_date = "tableTitle_date";
			$css_tableTitle_salary = "tableTitle_salary";
			$css_tableSubHeader = "tableSubHeader";
			$css_tableSubTitle = "tableSubTitle";
			$css_tableContent = "tableContent";
		}else{
			$css_table = "tableReversed";
			$css_tableTitle_weekday = "tableTitle_weekday textReversed_titleWeekday";
			$css_tableTitle_date = "tableTitle_date textReversed_titleDate";
			$css_tableTitle_salary = "tableTitle_salary textReversed_titleSalary";
			$css_tableSubHeader = "tableSubHeader textReversed_subHeader";
			$css_tableSubTitle = "tableSubTitle textReversed_subTitle";
			$css_tableContent = "tableContent textReversed_content";
		}

		$str.= "<table class=\"$css_table\" id=\"$thisDay_date\" style=\"outline: none !important;\">
        <tr>
          <td class=\"$css_tableTitle_weekday\">星期".['日', '一', '二', '三', '四', '五', '六'][$i%7]."<br><span style=\"font-size: 80%;\">".['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$i%7]."</span></td>
          <td>
            <table>
              <tr>
                <td class=\"$css_tableTitle_date\" colspan=\"4\"><a href=\"index_showDetail.php?y=$thisDay_partY&m=$thisDay_partM&d=$thisDay_partD\">$thisDay_date_chinese</a></td>
                <td class=\"$css_tableTitle_salary\" colspan=\"2\">".getSalary("function/", "$thisDay_date")."</td>
              </tr>
              ";

        $schedulingTime = getScheduling_workTime_string("$thisDay_date");

		if($schedulingTime == "尚未排班" || $schedulingTime == "X"){
			$showScheduling_time = $schedulingTime;
			$showScheduling_length = "";
			$showScheduling_station = "";
		}else{
			if(mb_strlen($schedulingTime, "utf-8") == 11){
				$workStart = substr($schedulingTime, 0, 5);
				$workEnd = substr($schedulingTime, -5);
				$schedulingWorkTime_minute = getWorkTime_range_minute_withBreak($workStart, $workEnd);			
			}

			$showScheduling_time = $schedulingTime;
			$showScheduling_length = $schedulingWorkTime_minute;
			$showScheduling_station = getScheduling_station("$thisDay_date");;
		}

        $str .= "<tr><td class=\"$css_tableSubHeader\">排班</td></tr>
              <tr>
                <td class=\"$css_tableSubTitle\" style=\"padding-left: 30px;\">時間</td>
                <td class=\"$css_tableContent\">$showScheduling_time</td>
                <td class=\"$css_tableSubTitle\">工時</td>
                <td class=\"workTime $css_tableContent\">$showScheduling_length</td>
                <td class=\"$css_tableSubTitle\">崗位</td>
                <td class=\"$css_tableContent\">$showScheduling_station</td>
              </tr>
              ";



		$clockTime_start = getClock_time("function/", "$thisDay_date", "上班");
		$clockTime_end = getClock_time("function/", "$thisDay_date", "下班");
		if(mb_strlen($clockTime_start,"utf-8") == 5 || mb_strlen($clockTime_end,"utf-8") == 5){
			if( mb_strlen($clockTime_end,"utf-8") == 0){
				date_default_timezone_set("Asia/Taipei");
				$clockTime_end = date("H:i", time()); 
			}

			$showReal_time = "$clockTime_start ～ $clockTime_end";
			$showReal_length = getWorkTime_range_minute_withBreak($clockTime_start, $clockTime_end);
		}else{
			$showReal_time = "";
			$showReal_length = "";
		}


        $str .= "<tr><td class=\"$css_tableSubHeader\">實際</td></tr>
              <tr>
                <td class=\"$css_tableSubTitle\" style=\"padding-left: 30px;\">時間</td>
                <td class=\"$css_tableContent\">$showReal_time</td>
                <td class=\"$css_tableSubTitle\">工時</td>
                <td class=\"workTime $css_tableContent\">$showReal_length </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>";

      if($i <= 6){
      	$str .= "

      <hr style=\"margin: 20px 20px; opacity: 0.3;\">

      ";
	  }

      
	}
	
	return $str;
}

function getWeekNumber($date){
	// $date = "2012-10-18";
	$duedt = explode("-", $date);
	$date1  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
	$week  = (int)date('W', $date1);
	
	return $week;
}

function getWeekNumberRange($week, $year) {
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$start = $dto->format('m/d');
	$dto->modify('+6 days');
	$end = $dto->format('m/d');
	return $start."～".$end;
}

function getWeekNumberFirstDay($week, $year){
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$y = $dto->format('Y');
	$m = $dto->format('m');
	$d = $dto->format('d');

	return "?y=$y&m=$m&d=$d";
}


function getStatistics_salary($YEAR, $MONTH){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	$totalSalary_real = 0;

	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	for($i = 1; $i <= $endOfTheMonth ; $i++){
		if($i < 10){
			$DAY = "0".$i;
		}else{
			$DAY = $i;
		}
		
		$salary = getSalary_num("function/", "$YEAR-$MONTH-$DAY");
		// echo "$YEAR-$MONTH-$DAY=>".$salary." / ";
		$totalSalary_real+= $salary;
	}

	return $totalSalary_real;
}


function getStatistics_schedulingWorkTimeMinute($YEAR, $MONTH){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	$totalWorkTimeMinute_scheduling = 0;
	

	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	for($i = 1; $i <= $endOfTheMonth ; $i++){
		if($i < 10){
			$DAY = "0".$i;
		}else{
			$DAY = $i;
		}
		
		$clockTime_start = getClock_time("function/", "$YEAR-$MONTH-$DAY", "上班");
		if(mb_strlen($clockTime_start ,"utf-8") != 5){
			$schedulingTime = getScheduling_workTime_string("$YEAR-$MONTH-$DAY");
			if($schedulingTime != "尚未排班" && $schedulingTime != "X"){
				// echo "$YEAR-$MONTH-$DAY=>".$schedulingTime."<BR>";

				$workStart = substr($schedulingTime, 0, 5);
				$workEnd = substr($schedulingTime, -5);
				$totalWorkTimeMinute_scheduling += intval(getWorkTime_range_minute_withBreak($workStart, $workEnd));
			}
		}
	}

	return $totalWorkTimeMinute_scheduling;
}

function getStatistics_workTimeMinute($YEAR, $MONTH){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	$totalWorkTimeMinute_real = 0;

	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	for($i = 1; $i <= $endOfTheMonth ; $i++){
		if($i < 10){
			$DAY = "0".$i;
		}else{
			$DAY = $i;
		}
		
		$clockTime_start = getClock_time("function/", "$YEAR-$MONTH-$DAY", "上班");
		$clockTime_end = getClock_time("function/", "$YEAR-$MONTH-$DAY", "下班");
		if(mb_strlen($clockTime_start,"utf-8") == 5 || mb_strlen($clockTime_end,"utf-8") == 5){
			if( mb_strlen($clockTime_end,"utf-8") == 0){
				date_default_timezone_set("Asia/Taipei");
				$clockTime_end = date("H:i", time()); 
			}

			// echo getWorkTime_range_minute_withBreak($clockTime_start, $clockTime_end)."/";
			
			$totalWorkTimeMinute_real += intval(getWorkTime_range_minute_withBreak($clockTime_start, $clockTime_end));
		}
	}

	return $totalWorkTimeMinute_real;
}

function getStatistics_dayNumber_realWork($YEAR, $MONTH){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	$totalWorkDayNumber_real = 0;

	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	for($i = 1; $i <= $endOfTheMonth ; $i++){
		if($i < 10){
			$DAY = "0".$i;
		}else{
			$DAY = $i;
		}
		
		$clockTime_start = getClock_time("function/", "$YEAR-$MONTH-$DAY", "上班");
		if(mb_strlen($clockTime_start,"utf-8") == 5 ){
			$totalWorkDayNumber_real++;
		}
	}

	return $totalWorkDayNumber_real;
}


function getStatistics_dayNumber_schedulingWork($YEAR, $MONTH){
	require_once("get_scheduling.php");
	require_once("get_clock.php");
	require_once("function/getWorkTime.php");
	require_once("function/getSalary_money.php");
	$totalWorkDayNumber_scheduling = 0;

	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	for($i = 1; $i <= $endOfTheMonth ; $i++){
		if($i < 10){
			$DAY = "0".$i;
		}else{
			$DAY = $i;
		}
		
		$schedulingTime = getScheduling_workTime_string("$YEAR-$MONTH-$DAY");
		if($schedulingTime != "尚未排班" && $schedulingTime != "X"){
			$totalWorkDayNumber_scheduling++;
		}
	}

	return $totalWorkDayNumber_scheduling;
}

?>