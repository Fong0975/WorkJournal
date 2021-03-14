<?php
	$couponName = $_POST['couponName'];
	$couponSerial = $_POST['couponSerial'];
	$couponDateline = $_POST['couponDateline'];

	if(mb_strlen( $couponName, "utf-8") > 0 && mb_strlen( $couponSerial, "utf-8") > 0 && mb_strlen( $couponDateline, "utf-8") > 0){
		insertQR($couponName, $couponSerial, $couponDateline);
	}
	header('Location: ../../../coupons.php');
	exit;

function insertQR($cName, $cSerial, $cDateline){
	require "../../link_database_info.php";

	$sql_command = "INSERT INTO qrcode (qr_title, qr_code, qr_date) VALUES ('$cName', '$cSerial', '$cDateline')";
	

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
	
	return !$query;
}

?>