<?php
function showFrame_Header($previousY, $previousM, $YEAR, $MONTH, $nextY, $nextM){
	echo "<table style=\"background-color: #FFF; padding: 20px 0px;\">
        <tr>
          <td style=\"text-align: left; width: 33%;\"><a href=\"?y=$previousY&m=$previousM&d=01\"> < 前一月 Previous </a></td>
          <td style=\"text-align: center; width: 34%;\"><div class=\"title\">$YEAR/$MONTH</div></td>
          <td style=\"text-align: right; width: 33%;\"><a href=\"?y=$nextY&m=$nextM&d=01\"> 下一月 Next > </a></td>
        </tr>
      </table>
      
      <table style=\"background-color: #4c4c4c; color: #FFF;\">
        <tr>
          <td>日</td>
          <td>一</td>
          <td>二</td>
          <td>三</td>
          <td>四</td>
          <td>五</td>
          <td>六</td>
        </tr>
      </table>
      ";
}

function showFrame_JS($YEAR, $MONTH){
	echo "<script type=\"text/javascript\">

    //index.php?y=$YEAR&m=$MONTH&d=$i#show
    function showInformationBox(redY, redM, redD){
      window.location.href=\"index_showDetail.php?y=\"+ redY + \"&m=\" + redM + \"&d=\" + redD;
    }
  </script>
  <script type=\"text/javascript\">
    // document.getElementsByTagName('td').innerHTML
    var monthStatistics_salary = parseFloat(getTotalSalary_month());
    var monthStatistics_salary_withScheduling = sumFutureWorkTime() + parseFloat(monthStatistics_salary);
    monthStatistics_salary_withScheduling = Math.round(monthStatistics_salary_withScheduling * 100) / 100
    document.getElementById(\"monthStatistics_salary\").innerHTML = toCurrency(monthStatistics_salary) + \" / \" + toCurrency(monthStatistics_salary_withScheduling);
    document.getElementById(\"monthStatistics_workTime\").innerHTML = toCurrency(getTotalWorkTime_month())+\" 小時\";
    document.getElementById(\"monthStatistics_workDay\").innerHTML = getTotalWorkDayCount()+\" / \"+getTotalWorkDayCount_withScheduling()+\" 天\";
    document.getElementById(\"monthStatistics_breakDay\").innerHTML = (getMonthLastDay()  - getTotalWorkDayCount_withScheduling()) +\" 天\";

    formatFutureWorkTime();


    function getTotalSalary_month(){
      var elems = document.getElementsByClassName(\"salaryText\");

      var totalSalary = 0;
      for (i = 0; i < elems.length; i++) { 
        var one = parseFloat(elems[i].textContent);
        totalSalary += one;
      }

      return totalSalary.toFixed(2);
    }

    //work-actually
    function getTotalWorkDayCount(){
      var elems = document.getElementsByClassName(\"work-actually\");

      return elems.length;
    }

    //work-scheduling
    function getTotalWorkDayCount_withScheduling(){
      var elems = document.getElementsByClassName(\"work-scheduling\");

      return elems.length;
    }

    function getMonthLastDay(){
      //var date = new Date();
      var y = ".$YEAR.";//date.getFullYear();
      var m = ".(intval($MONTH)-1).";//date.getMonth();
      var lastDay = new Date(y, m + 1, 0).getDate();

      return lastDay;
    }

    function getTotalWorkTime_month(){
      var elems = document.getElementsByClassName(\"workTime_minute\");

      var totalTime = 0;
      for (i = 0; i < elems.length; i++) { 
        var one = parseInt(elems[i].textContent);
        totalTime += one;
      }

      totalTime = totalTime / 60;

      return Math.round(totalTime * 100) / 100;
    }

    function sumFutureWorkTime(){
      var elems = document.getElementsByClassName(\"schedulingWorkTime_minute\");
      var basicSalary = parseFloat(document.getElementById(\"userDefault_basicSalary\").innerHTML);

      var totalTime = 0;
      for (i = 0; i < elems.length; i++) { 
        var one = parseInt(elems[i].textContent);
        totalTime += one;
      }

      return Math.round((totalTime * basicSalary / 60) * 100) / 100;

      
    }

    function toCurrency(num){
      var parts = num.toString().split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return parts.join('.');
    }

    function formatFutureWorkTime(){
      var elems = document.getElementsByClassName(\"schedulingWorkTime\");

      var totalTime = 0;
      for (i = 0; i < elems.length; i++) { 
        var one = parseInt(elems[i].textContent);
        var hr = Math.floor(one / 60);
        var min = Math.floor(one % 60);

        var str = min + \" 分鐘)\";
        if(hr > 0){
          str = \"(\" + hr + \" 小時\" + str;
        }else{
          str = \"(\" + str;
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
	
	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	$space_Start = date('w', strtotime("$YEAR-$MONTH-01"));
	$space_End = (7- (($endOfTheMonth + $space_Start) % 7)) % 7;
	$countWeek = ceil(($endOfTheMonth + $space_Start) / 7);
	
	
	$str="";
	
	$str.= "<table class='calendar'>";

	$index = 1;
	for($i = 1- $space_Start; $i <= ($endOfTheMonth + $space_End) ; $i++){
		$day_formated = $i;
		if($day_formated < 10){
			$day_formated = "0".$i;
		}

		if($index % 7 == 1 ){
			$str.= "<tr style='height: 100px;'>";
		}
		
		
		
		if($i <= 0 or $i > $endOfTheMonth){
			$str.= "<td></td>";
		}else{

			if ($i == $DAY){
				$str.= "<td class='sDay'>";
			}else{
				$str.= "<td>";
			}
			
			$str.="<div class='calendar_date'><a href='#' onclick=\"showInformationBox($YEAR,$MONTH,$day_formated);\">$i</a></div>";

			
			$schedulingStation = getScheduling_workTime_string("$YEAR-$MONTH-$day_formated");
			$clockTime_start = getClock_time("function/", "$YEAR-$MONTH-$day_formated", "上班");
			$clockTime_end = getClock_time("function/", "$YEAR-$MONTH-$day_formated", "下班");


			if($schedulingStation != "尚未排班"){
				$str.="
					<div class='session";
				if($schedulingStation != "X"){$str .= " work-scheduling";}

				$str.="'>
						<div class='title'>排班</div>
						<div class='content'>".$schedulingStation;


				$workStation = getScheduling_station("$YEAR-$MONTH-$day_formated");
				if(mb_strlen($workStation, "utf-8") > 0){
					$str.="<br />$workStation";
				}

				if(mb_strlen($schedulingStation, "utf-8") == 11){
					$workStart = substr($schedulingStation, 0, 5);
					$workEnd = substr($schedulingStation, -5);
					$schedulingWorkTime_minute = getWorkTime_range_minute_withBreak($workStart, $workEnd);

					if(mb_strlen($clockTime_start ,"utf-8") == 5){
						$str.="<br /><span class=\"schedulingWorkTime\">$schedulingWorkTime_minute</span>";
					}else{
						$str.="<br /><span class=\"schedulingWorkTime schedulingWorkTime_minute\">$schedulingWorkTime_minute</span>";
					}
					
				}
				
				$str.="</div>
					</div>
				";
			}

			
			if(mb_strlen($clockTime_start,"utf-8") == 5 || mb_strlen($clockTime_end,"utf-8") == 5){
				if( mb_strlen($clockTime_end,"utf-8") == 0){
					date_default_timezone_set("Asia/Taipei");
					$clockTime_end = date("H:i", time()); 
				}

				$clockTime_work_string = "$clockTime_start ～ $clockTime_end";
				$clockTime_break = getWorkTime_range_minute_withBreak($clockTime_start, $clockTime_end);

				$str.="
				<div class='session work-actually'>
					<div class='title'>實際</div>
					<div class='content'>$clockTime_work_string<br>(".getFormatTimeString_minute($clockTime_break).")<span class=\"workTime_minute\" style=\"display: none;\">".$clockTime_break."</span></div>
				</div>
			";
			}

			
			
			$str.="<div class='money'>".getSalary("function/", "$YEAR-$MONTH-$day_formated")."</div>";
			$str.= "";	
			$str.= "</td>";
		}


		if($index % 7  == 0 ){
			$str.= "</tr>";
		}

		$index++;
	}

	$str.= "</table>";
	
	return $str;
}

?>