 <?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/scheduling/get.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>編輯排班 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/scheduling.css">
  </head>

 <body onload="loadScheduling();">
  <?php
    if(!isset($_GET['date'])){
      header('Location: index.php?err=non_query_string');
      exit;
    }else{
      $schedulingDate = $_GET['date'];
      $schedulingDate_array = explode("-", $schedulingDate);
      if(!checkdate ($schedulingDate_array[1], $schedulingDate_array[2], $schedulingDate_array[0])){
        header('Location: index.php?err=not_right_date');
        exit;
      }

      if(!isExistScheduling($schedulingDate)){
        header('Location: index.php?err=this_scheduling_of_date_not_exist');
        exit;
      }
    }


    // load scheduling data
    $schedulingData = getScheduled("function/", $schedulingDate);
    // foreach($schedulingData as $i){
    //   echo "<div style='color:#FFF'>$i</div>";
    // }
    
    if($schedulingData[2] == "00:00" && $schedulingData[3] == "00:00"){
      $schedulingData_isHoliday = true;
    }else{
      $schedulingData_isHoliday = false;
    }

    $schedulingImage = isExistSchedulingImage("images/scheduling/", $schedulingDate);
    if(strlen($schedulingImage) == 0){
      $isExistSchedulingImage = false;
    }else{
      $isExistSchedulingImage = true;
    }
  ?>

  <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">編輯排班 Modify Scheduling</div>
    </div>
    
    <div class="session transparent" style="margin-top: 100px; ">
      <form id='form1' name="form1" action="function/page/scheduling/update.php" method="post" enctype="multipart/form-data">
        <table>
          <tr>
            <td class="addForm_Title">排班日期<br>Date</td>
            <td><input class="dark" id="schedulingDate" name="schedulingDate" type="date"  placeholder="2018-07-22" maxlength="10" style="width: 100% !important;" value="<?php echo $schedulingDate; ?>" required readonly></td>
          </tr>
          <tr>
            <td class="addForm_Title">預排休假<br>Holiday</td>
            <td style="text-align: left; padding-left: 20px; padding-bottom: 0px; ">
              <div style="border-bottom: 1px solid rgb(172, 172, 172); padding-bottom: 20px;">
                上班日
                <label class="switch">
                  <input id="schedulingHoliday" name="schedulingHoliday" type="checkbox" onclick="switchHoliday();">
                  <span class="slider"></span>
                </label>
                休假日
              </div>
              
            </td>
          </tr>
          <tr id="row_startWork">
            <td class="addForm_Title">上班時間<br>Start-Working</td>
            <td><input class="dark" id="schedulingTime_start" name="schedulingTime_start" type="time" pattern="[0-12]{2}:[0-12]{2}" style="width: 100% !important;" required></td>
          </tr>
          <tr id="row_endWork">
            <td class="addForm_Title">下班時間<br>End-Working</td>
            <td><input class="dark" id="schedulingTime_end" name="schedulingTime_end" type="time" pattern="[0-12]{2}:[0-12]{2}" value="<?php echo $schedulingData[3]; ?>" style="width: 100% !important;" required></td>
          </tr>
          <tr id="row_station">
            <td class="addForm_Title">預排崗位<br>Station</td>
            <td class="" style="text-align: left; padding-left: 20px;">
              <div class="groupTitle" style="margin-top: 5px;"><i class="fas fa-crown"></i>值班</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_1.1" name="schedulingStation[]" value="早值"<?php if(strpos($schedulingData[4],"早值") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_1.1"><span></span>早值</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_1.2" name="schedulingStation[]" value="晚值"<?php if(strpos($schedulingData[4],"晚值") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_1.2"><span></span>晚值</label>
              </div>

              <div class="groupTitle"><i class="fas fa-concierge-bell"></i>外場</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_2.1" name="schedulingStation[]" value="收銀"<?php if(strpos($schedulingData[4],"收銀") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_2.1"><span></span>收銀</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_2.2" name="schedulingStation[]" value="控"<?php if(strpos($schedulingData[4],"控") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_2.2"><span></span>控</label>
              </div>

              <div class="groupTitle"><i class="fas fa-utensils"></i>內場</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.1" name="schedulingStation[]" value="油炸"<?php if(strpos($schedulingData[4],"油炸") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_3.1"><span></span>油炸</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.2" name="schedulingStation[]" value="燒"<?php if(strpos($schedulingData[4],"燒") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_3.2"><span></span>燒</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.3" name="schedulingStation[]" value="製"<?php if(strpos($schedulingData[4],"製") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_3.3"><span></span>製</label>
              </div>

              <div class="groupTitle"><i class="fas fa-broom"></i>準備/打烊</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.1" name="schedulingStation[]" value="Open"<?php if(strpos($schedulingData[4],"Open") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_4.1"><span></span>Open</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.2" name="schedulingStation[]" value="前Close"<?php if(strpos($schedulingData[4],"前Close") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_4.2"><span></span>前Close</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.3" name="schedulingStation[]" value="中Close"<?php if(strpos($schedulingData[4],"中Close") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_4.3"><span></span>中Close</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.4" name="schedulingStation[]" value="後Close"<?php if(strpos($schedulingData[4],"後Close") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_4.4"><span></span>後Close</label>
              </div>

              <div class="groupTitle"><i class="fas fa-user-tag"></i>特殊</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_5.1" name="schedulingStation[]" value="支援"<?php if(strpos($schedulingData[4],"支援") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_5.1"><span></span>支援</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_5.2" name="schedulingStation[]" value="上課"<?php if(strpos($schedulingData[4],"上課") !== false){ echo " checked";} ?>/>
                <label for="schedulingStation_5.2"><span></span>上課</label>
              </div>
            </td>
          </tr>
          <tr>
            <td class="addForm_Title">預排班表<br>Picture</td>
            <td style="text-align: left;">
              <input name="schedulingFile" type="file" style="border-bottom: none;<?php if($isExistSchedulingImage){ echo " display:none;" ;} ?>">
              <a href="<?php echo $schedulingImage; ?>" target="_blank" style="color: #f0f0f0; padding: 5px 10px; <?php if(!$isExistSchedulingImage){ echo " display:none;" ;} ?>"><?php $schedulingImage_array = explode("/", $schedulingImage); echo $schedulingImage_array[count($schedulingImage_array)-1]; ?></a>
              <a href="function/page/scheduling/deleteSchedulingImage.php?date=<?php echo $schedulingDate;?>" style="color: #f0f0f0; border: 1px solid #9c9c9c; padding: 5px 10px; text-decoration:none;<?php if(!$isExistSchedulingImage){ echo " display:none;" ;} ?>">刪除圖像</a>
            </td>
          </tr>
        </table>
        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large fontColor_white" type="submit">修改</button>
        </div>
        <div style="width: 100%; margin-top: 20px;">
          <button class="large cancel fontColor_white" type="button" onclick="javascript:location.href='index_showDetail.php?y=<?php echo $schedulingDate_array[0]; ?>&m=<?php echo $schedulingDate_array[1]; ?>&d=<?php echo $schedulingDate_array[2]; ?>'">返回</button>
        </div>
      </form>
    </div>
    

   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>

   <script type="text/javascript">
    function loadScheduling(){
      <?php if($schedulingData_isHoliday){echo "document.getElementById(\"schedulingHoliday\").checked = true;";} ?>
      switchHoliday();

      document.getElementById("schedulingTime_start").value = "<?php echo $schedulingData[2]; ?>";
      
    }

     function switchHoliday(){
      var isHoliday = document.getElementById("schedulingHoliday").checked;
      if(isHoliday){
        document.getElementById("row_startWork").style.display = "none";
        document.getElementById("row_endWork").style.display = "none";
        document.getElementById("row_station").style.display = "none";
      }else{
        document.getElementById("row_startWork").style.display = "";
        document.getElementById("row_endWork").style.display = "";
        document.getElementById("row_station").style.display = "";
      }
     }
   </script>

  </body>
</html>