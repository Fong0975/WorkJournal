<?php

$serial = $_GET['serial'];
deleteCoupon($serial);
header('Location: ../../../coupons.php');
exit;


function deleteCoupon($serial){
	require "../../link_database_info.php";

	$sql_command = "DELETE FROM qrcode WHERE qr_code = '$serial'";
	

	$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
	$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
	mysqli_set_charset($sql_connect, "utf8");
	$query = mysqli_query($sql_connect,$sql_command );
		
	return !$query;
	
}

?>