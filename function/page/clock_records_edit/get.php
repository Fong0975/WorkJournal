<?php

function getRecord($id){
	require_once("function/getData.php");

	$strData = getData_String("*", "clockrecord", "cr_ID = '$id'", "");
	$arrDataRow=explode('@br@',$strData);


	return $arrDataRow[0];
}

?>