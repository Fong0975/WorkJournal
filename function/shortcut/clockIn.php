<?php

	$type = "";
	if($_GET['type'] == "上班" or $_GET['type'] == "下班" || $_GET['type'] == "休息開始"  || $_GET['type'] == "休息結束" ){
		$type = $_GET['type'];

		//require_once('checkDataFormat.php');
		//require_once('setClock.php');

		date_default_timezone_set('Asia/Taipei');
		$date = date('Y-m-d');
		$time = date("H:i");

		setClock($date,$time,$type);

		header("Location: ../../qr_identification.php?goback=true" );
		exit;
	}

	function setClock($clock_date,$clock_time,$clock_type) {
		require "../link_database_info.php";
		require "../getData.php";

		$strData = getData_String("ud_value", "userdefault", "ud_title = '基本薪資'", "");
		$arrDataRow=explode('@br@',$strData);
		$basicSalary = floatval ($arrDataRow[0]);

		if($clock_type == "上班"){
			$sql_command = "INSERT INTO clockrecord (cr_Date, cr_Time, cr_Type, cr_baseSalary) VALUES ('$clock_date','$clock_time','$clock_type', $basicSalary)";
		}else{
			$sql_command = "INSERT INTO clockrecord (cr_Date, cr_Time, cr_Type) VALUES ('$clock_date','$clock_time','$clock_type')";
		}
		
		echo $sql_command;

		$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
		mysqli_set_charset($sql_connect, "utf8");
		$query = mysqli_query($sql_connect,$sql_command );
		return $query;
	}
?>