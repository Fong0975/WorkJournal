<?php
	function getIdentificationNum(){
		require_once("function/getData.php");
		$strData = getData_String("ud_value", "userdefault", "ud_title = '員工編號'", "");
		$arrDataRow=explode('@br@',$strData);

		return $arrDataRow[0];
	}

	function getIdentificationNum_Contact($num){
		return $num;
	}

	function getIdentificationPassword(){
		require_once("function/getData.php");
		$strData = getData_String("ud_value", "userdefault", "ud_title = '員工編號'", "");
		$arrDataRow=explode('@br@',$strData);

		return substr($arrDataRow[0], -4);
	}

	function getIdentificationPassword_Contact($num){
		require_once("function/getData.php");
		$strData = getData_String("contact_password", "contact", "contact_number = '$num'", "");
		$arrDataRow=explode('@br@',$strData);

		return $arrDataRow[0];
	}


?>