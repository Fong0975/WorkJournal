<?php

function showCanendar($YEAR,$MONTH,$DAY){
	
	$endOfTheMonth = intval(cal_days_in_month(CAL_GREGORIAN,$MONTH,$YEAR));
	$space_Start = date('w', strtotime("$YEAR-$MONTH-01"));
	$space_End = (7- (($endOfTheMonth + $space_Start) % 7)) % 7;
	$countWeek = ceil(($endOfTheMonth + $space_Start) / 7);
	
	
	$str="";
	
	$str.= "<table class='calendar'>";

	$index = 1;
	for($i = 1- $space_Start; $i <= ($endOfTheMonth + $space_End) ; $i++){
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
			
			$str.="<a href='index.php?y=$YEAR&m=$MONTH&d=$i'>$i</a>";
			
			$str.="
				<div class='session'>
					<div class='title'>排班</div>
					<div class='content'>07:00～15:00<br>燒/製</div>
				</div>
			";

			$str.="
				<div class='session'>
					<div class='title'>實際</div>
					<div class='content'>14:55～23:00<br>(07:05)</div>
				</div>
			";
			
			$str.="<div class='money'>1085.5</div>";
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