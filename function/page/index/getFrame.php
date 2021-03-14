<?php
function getDisplayMode($path){
	require_once($path."getData.php");

	$schedulingStation_string = explode("@br@",getData_String("ud_value", "userdefault", "ud_title = '完整月曆顯示'", ""))[0];

	return floatval($schedulingStation_string);
}
?>