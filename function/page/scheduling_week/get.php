<?php

function isExistScheduling_byDate($path, $date){
	require_once($path."getData.php");

	// SELECT COUNT(`sr_ID`) FROM `schedulingrecord` WHERE `sr_Date` = "2020-02-22"
	$result = 0;

	for($i = 0; $i < 7; $i++){
		$testingDate = date('Y-m-d', strtotime($date . ' +'.$i.' day'));
		$scedulingRecord = intval(explode("@br@",getData_String("COUNT(sr_ID)", "schedulingrecord", "sr_Date = '$testingDate'", ""))[0]);

		if($scedulingRecord == 1){
			$result = 1;
		}
	}
	

	return $result;
}

function showStation($index){
	echo "          <div class=\"weekScheduling_station_button\" id=\"weekScheduling_station_button_".($index + 1)."\">▼顯示預排崗位</div>
          <div id=\"weekScheduling_station_area_".($index + 1)."\" style=\"display: none;\">
            <table>
              <tr id=\"row_station\">
                <td class=\"addForm_Title\">預排崗位<br>Station</td>
                <td class=\"\" style=\"text-align: left; padding-left: 20px;\">
                  <div class=\"groupTitle\" style=\"margin-top: 5px;\"><i class=\"fas fa-crown\"></i>值班</div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."1.1\" name=\"schedulingStation_".$index."[]\" value=\"早值\"/> <label for=\"schedulingStation_".$index."1.1\"><span></span>早值</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."1.2\" name=\"schedulingStation_".$index."[]\" value=\"晚值\"/>
                    <label for=\"schedulingStation_".$index."1.2\"><span></span>晚值</label>
                  </div>

                  <div class=\"groupTitle\"><i class=\"fas fa-concierge-bell\"></i>外場</div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."2.1\" name=\"schedulingStation_".$index."[]\" value=\"收銀\"/>
                    <label for=\"schedulingStation_".$index."2.1\"><span></span>收銀</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."2.2\" name=\"schedulingStation_".$index."[]\" value=\"控\"/>
                    <label for=\"schedulingStation_".$index."2.2\"><span></span>控</label>
                  </div>

                  <div class=\"groupTitle\"><i class=\"fas fa-utensils\"></i>內場</div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."3.1\" name=\"schedulingStation_".$index."[]\" value=\"油炸\"/>
                    <label for=\"schedulingStation_".$index."3.1\"><span></span>油炸</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."3.2\" name=\"schedulingStation_".$index."[]\" value=\"燒\"/>
                    <label for=\"schedulingStation_".$index."3.2\"><span></span>燒</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."3.3\" name=\"schedulingStation_".$index."[]\" value=\"製\"/>
                    <label for=\"schedulingStation_".$index."3.3\"><span></span>製</label>
                  </div>

                  <div class=\"groupTitle\"><i class=\"fas fa-broom\"></i>準備/打烊</div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."4.1\" name=\"schedulingStation_".$index."[]\" value=\"Open\"/>
                    <label for=\"schedulingStation_".$index."4.1\"><span></span>Open</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."4.2\" name=\"schedulingStation_".$index."[]\" value=\"前Close\"/>
                    <label for=\"schedulingStation_".$index."4.2\"><span></span>前Close</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."4.3\" name=\"schedulingStation_".$index."[]\" value=\"中Close\"/>
                    <label for=\"schedulingStation_".$index."4.3\"><span></span>中Close</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."4.4\" name=\"schedulingStation_".$index."[]\" value=\"後Close\"/>
                    <label for=\"schedulingStation_".$index."4.4\"><span></span>後Close</label>
                  </div>

                  <div class=\"groupTitle\"><i class=\"fas fa-user-tag\"></i>特殊</div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."5.1\" name=\"schedulingStation_".$index."[]\" value=\"支援\"/>
                    <label for=\"schedulingStation_".$index."5.1\"><span></span>支援</label>
                  </div>
                  <div class=\"div_checkOption\">
                    <input type=\"checkbox\" id=\"schedulingStation_".$index."5.2\" name=\"schedulingStation_".$index."[]\" value=\"上課\"/>
                    <label for=\"schedulingStation_".$index."5.2\"><span></span>上課</label>
                  </div>
                </td>
              </tr>
            </table>
          </div>";
}

?>