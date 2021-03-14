<?php

if(!isset($_GET['y']) or !isset($_GET['m']) or !isset($_GET['d']) ){
    $YEAR = date("Y");
    $MONTH = date("m");
    $DAY = date("d");
  }else{
    $YEAR = intval($_GET['y']);
    $MONTH = intval($_GET['m']);
    $DAY = intval($_GET['d']);
  }

  if( $MONTH < 10 ){ $MONTH = "0".$MONTH; }
  if( $DAY < 10 ){ $DAY = "0".$DAY; }

$filename = "MOS_Working_Calendar-$YEAR$MONTH$DAY.csv";
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Disposition: attachment;filename="' . $filename . '";');
header('Content-Type: application/csv; charset=UTF-8');
$csv_arr[] = array("Subject","Start Date","Start Time","End Date","End Time","Description");

require_once("function/page/scheduling/get.php");
$array = getWeekScheduling_csv("function/page/index/",$YEAR,$MONTH,$DAY);
for($i = 0; $i < count($array); $i++){
  $csv_arr[] = array("MOS上班",$array[$i][1],$array[$i][2],$array[$i][3],$array[$i][4],$array[$i][5]);
}

for ($j = 0; $j < count($csv_arr); $j++) {
    if ($j == 0) {
        //輸出 BOM 避免 Excel 讀取時會亂碼
        echo "\xEF\xBB\xBF";
    }
    echo join(',', $csv_arr[$j]) . PHP_EOL;
} 


// echo "<div style=\"margin-top: 30px; text-align: center;\"><button class=\"mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent transparent back_white\" type=\"button\" onclick=\"location.href = 'index_showDetail_weekScheduling.php?y=".$YEAR."&m=".$MONTH."&d=".$DAY.">返回</button></div>";
?>