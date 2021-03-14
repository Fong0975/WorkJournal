<?php
	$editedTitle = $_GET['title'];
	$editedValue = $_GET['value'];

	echo $editedTitle."/".$editedValue."<br>";

	if(isRightFormat($editedTitle, $editedValue)){
		setNewValue($editedTitle, $editedValue);
	}else{
		echo "format error"."<br>";
	}

	header('Location: ../../../setting.php');
	exit;


	function setNewValue($mTitle, $mValue){
		require "../../link_database_info.php";

		$value_Formated = $mValue;
		if(getDefaultType($mTitle) == "Float"){
			$value_Formated = number_format((float)$mValue, 2, '.', ''); 
		}

		$sql_command = "UPDATE userdefault SET ud_value = '$value_Formated' WHERE ud_title = '$mTitle'";
		echo $sql_command;

		$sql_connect = mysqli_connect($db_Host,$db_Account,$db_Password)or die("連線失敗");
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record ) or die("資料庫選取失敗");
		mysqli_set_charset($sql_connect, "utf8");
		$query = mysqli_query($sql_connect,$sql_command );
		
		return !$query;
	}


	//================ identify ================
	function getDefaultType($mTitle){

		$strData = getData_String("ud_type", "userdefault", "ud_title = '$mTitle'", "");

		$arrDataRow=explode('@br@',$strData);
		$theFormat = $arrDataRow[0];

		return $theFormat;
	}

	function isRightFormat($mTitle, $mValue){

		if(mb_strlen($mTitle, "utf-8") <= 0){
			echo "[string lenght equal 0] ";
			return false;
		}

		$theFormat = getDefaultType($mTitle);
		echo $theFormat."<br>";

		if($theFormat == "Float"){
			if($mTitle != "完整月曆顯示"){
				return (floatval($mValue) > 1);
			}else{
				return (floatval($mValue) == 0 || floatval($mValue) == 1);
			}
		}elseif($theFormat == "String"){
			return (mb_strlen($mValue, "utf-8") > 0);
		}

		echo "[other] ";
		return false;
	}


	function getData_String($commandSelect, $commandTableName, $commandWhere, $commandOthers){
		require "../../link_database_info.php";

		//========================= Salary =========================
		$sql_connect = mysqli_connect( $db_Host, $db_Account, $db_Password );
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record );
		mysqli_set_charset($sql_connect, "utf8");
		$sql_command = "SELECT $commandSelect FROM $commandTableName WHERE $commandWhere $commandOthers";
		echo $sql_command."<br>";

		$query = mysqli_query($sql_connect,$sql_command );
		if ( !$query ) {
			return "";
		} else {
			$num = mysqli_num_rows( $query );
			if ( $num == 0 ) {
				return "";
			} else {
				$retrunStr = "";
				while ( $row = mysqli_fetch_array( $query ) ) {
					$str = $row[ 0 ];
					for ( $i = 1; $i < 20; $i++ ) {
						if( isset($row[ $i ])){
							$str .= "/" . $row[ $i ];
						}
					}
					$retrunStr .= $str."@br@";
				}
				
				return substr($retrunStr,0, strlen($retrunStr)-4 );
			}
		}
	}
?>