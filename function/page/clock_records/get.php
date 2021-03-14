<?php

function getClockRecord_Day($date){
	require_once("function/getData.php");

	$strData = getData_String("*", "clockrecord", "cr_Date = '$date'", "ORDER BY cr_Time");

	$arrDataRow=explode('@br@',$strData);

	$str = "";
	if(mb_strlen($strData,"utf-8" ) > 0 && strrpos($strData,"/") > -1){
		$str = "";
		$str .= "      <table class=\"timeline\">
";

		for($i = 0; $i < count($arrDataRow); $i++) {
			$column = explode('/', $arrDataRow[$i]);


			$columnStyle = "middle";
			if($column[3] == "上班"){
				$columnStyle = "start";

				if($i > 0){
					$str .= "        <tr>
          <td style='padding-top:90px;'></td>
          <td></td>
        </tr>
";
				}
				
			}elseif($column[3] == "下班"){
				$columnStyle = "end";
			}



			if(strlen($arrDataRow[$i])>0){
				$str .= "        <tr>
";
				$str .= "          <td class=\"record_time $columnStyle\"><i class=\"line\"></i><div>".$column[2]."</div></td>
          <td class=\"record_text\">".$column[3]."</td>
          <td><a href='clock_records_edit.php?id=".$column[0]."' style='color: #FFF;'>編輯</a></td>
";

				
				
				$str .= "        </tr>
";
			}
			
		}


		$str .= "      </table>";


		return $str;
	}else{
		return "<div style='width:100%; text-align: center; font-size: 30pt; font-width: bolder; margin-top: 200px;'>今天尚未建立打卡資料</div>";
	}

}

function getLostClock_outline(){
	require_once("function/getData.php");
	//SELECT COUNT(`cr_ID`) FROM `clockrecord` WHERE `cr_Type` = "下班"
	$clockTime_start = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '上班')", ""))[0]);
	$clockTime_breakStart = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '休息開始')", ""))[0]);
	$clockTime_breakEnd = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '休息結束')", ""))[0]);
	$clockTime_end = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '下班')", ""))[0]);

	$str = "";
	if($clockTime_start != $clockTime_end){
		if($clockTime_start > $clockTime_end){
			$str .= "✘ ".$valueDate."缺少下班卡".($clockTime_start - $clockTime_end)."次<br>";
		}else{
			$str .= "✘ ".$valueDate."缺少上班卡".($clockTime_end - $clockTime_start)."次<br>";
		}
	}
		
	if($clockTime_breakStart != $clockTime_breakEnd){
		if($clockTime_breakStart > $clockTime_breakEnd){
			$str .= "✘ ".$valueDate."缺少返回卡".($clockTime_breakStart - $clockTime_breakEnd)."次<br>";
		}else{
			$str .= "✘ ".$valueDate."缺少休息卡".($clockTime_breakEnd - $clockTime_breakStart)."次<br>";
		}
	}

	if( mb_strlen( $str, "utf-8") > 1){
		$queryString = "?detail=true";
		if(mb_strlen($_SERVER['QUERY_STRING'], "utf-8") > 1){
			$queryString = "?".$_SERVER['QUERY_STRING']."&detail=true";
		}

		$str = "		<hr style=\"margin-top: 50px; margin-bottom: 20px;\">
		<div style='width:100%; padding-left:20px; text-align:left; font-size:35px; font-weight: bold;'>紀錄缺漏：</div>
		".$str."
		<div  style='width:100%; text-align:center; margin-top: 25px;'><a href='clock_records.php$queryString' style=' color:#FFF;'>檢視詳細資訊<span style='font-size:15px;'>  (會增加載入時間)</span></a></div>
		<hr style=\"margin-top: 50px; margin-bottom: 50px;\">";
	}

	return $str;
}

function getLostClock_detail(){
	require_once("function/getData.php");
	$str="";

	$clockTime_start = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '上班')", ""))[0]);
	$clockTime_breakStart = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '休息開始')", ""))[0]);
	$clockTime_breakEnd = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '休息結束')", ""))[0]);
	$clockTime_end = intval(explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Type = '下班')", ""))[0]);

	$loseTime_StartEnd = $clockTime_start - $clockTime_end; //+n= 少下班卡   -n= 少上班
	$loseTime_BreakReturn = $clockTime_breakStart - $clockTime_breakEnd; //+n= 少返回卡   -n= 少休息

	
	$strData = explode("@br@",getData_String("DISTINCT cr_Date", "clockrecord", "1", "ORDER BY cr_Date DESC"));
	//SELECT DISTINCT cr_Date FROM ClockRecord WHERE $where ORDER BY cr_Date
	foreach ($strData as $valueDate){
		
		$time_start = countClock($valueDate,"上班");
		$time_break = countClock($valueDate,"休息開始");
		$time_back = countClock($valueDate,"休息結束");
		$time_end = countClock($valueDate,"下班");

		
		if($time_start != $time_end){
			if($time_start > $time_end){
				$loseTime_StartEnd--;
				$str .= "✘ ".$valueDate."缺少下班卡".($time_start - $time_end)."次<br>";
			}else{
				$loseTime_StartEnd++;
				$str .= "✘ ".$valueDate."缺少上班卡".($time_end - $time_start)."次<br>";
			}
		}
		
		if($time_break != $time_back){
			if($time_break > $time_back){
				$loseTime_BreakReturn--;
				$str .= "✘ ".$valueDate."缺少返回卡".($time_break - $time_back)."次<br>";
			}else{
				$loseTime_BreakReturn++;
				$str .= "✘ ".$valueDate."缺少休息卡".($time_back - $time_break)."次<br>";
			}
		}
	
		if($loseTime_StartEnd == 0 && $loseTime_BreakReturn == 0){
			break;
		}

	}

	if( mb_strlen( $str, "utf-8") > 1){
		$queryString = $_SERVER['QUERY_STRING'];
		$queryString = str_replace("?detail=true", "", $queryString);
		$queryString = str_replace("&detail=true", "", $queryString);
		$queryString = str_replace("detail=true&", "", $queryString);
		if(mb_strlen($queryString, "utf-8") > 1){
			$queryString = "?".$queryString;
		}

		$str = "		<hr style=\"margin-top: 50px; margin-bottom: 20px;\">
		<div style='width:100%; padding-left:20px; text-align:left; font-size:35px; font-weight: bold;'>紀錄缺漏：</div>
		".$str."
		<div  style='width:100%; text-align:center; margin-top: 25px;'><a href='clock_records.php$queryString' style=' color:#FFF;'>檢視總覽資訊<span style='font-size:15px;'>  (能減少載入時間)</span></a></div>
		<hr style=\"margin-top: 50px; margin-bottom: 50px;\">";
	}
	
	return $str;
}

function countClock($date,$type) {
	require_once("function/getData.php");
	//SELECT count(cr_ID) FROM ClockRecord WHERE (cr_Date = '$date' and cr_Type = '$type')
	$strData = explode("@br@",getData_String("count(cr_ID)", "clockrecord", "(cr_Date = '$date' and cr_Type = '$type')", ""));

	return intval($strData[0]);
}

?>