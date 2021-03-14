<?php

	function getData_String($commandSelect, $commandTableName, $commandWhere, $commandOthers){
		require "link_database_info.php";

		//========================= Salary =========================
		$sql_connect = mysqli_connect( $db_Host, $db_Account, $db_Password );
		$sql_db = mysqli_select_db($sql_connect,$db_Table_Record );
		mysqli_set_charset($sql_connect, "utf8");
		$sql_command = "SELECT $commandSelect FROM $commandTableName WHERE $commandWhere $commandOthers";
		// echo $sql_command."<br>";

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