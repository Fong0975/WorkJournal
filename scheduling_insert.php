 <?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/scheduling/get.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新增排班 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/scheduling.css">
  </head>

 <body>
  <?php
    if(!isset($_GET['date'])){
      header('Location: index.php');
      exit;
    }else{
      $schedulingDate = $_GET['date'];
      $schedulingDate_array = explode("-", $schedulingDate);
      if(!checkdate ($schedulingDate_array[1], $schedulingDate_array[2], $schedulingDate_array[0])){
        header('Location: index.php');
        exit;
      }

      if(isExistScheduling($schedulingDate)){
        header('Location: index.php');
        exit;
      }
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
      <div class="subTitle">新增排班 Add Scheduling</div>
    </div>
    
    <div class="session transparent" style="margin-top: 100px; ">
      <form id='form1' name="form1" action="function/page/scheduling/insert.php" method="post" enctype="multipart/form-data">
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
            <td><input class="dark" id="schedulingTime_start" name="schedulingTime_start" type="time" pattern="[0-12]{2}:[0-12]{2}" value="<?php echo getSchedulingTime_start("function/"); ?>" style="width: 100% !important;" required></td>
          </tr>
          <tr id="row_endWork">
            <td class="addForm_Title">下班時間<br>End-Working</td>
            <td><input class="dark" id="schedulingTime_end" name="schedulingTime_end" type="time" pattern="[0-12]{2}:[0-12]{2}" value="<?php echo getSchedulingTime_end("function/"); ?>" style="width: 100% !important;" required></td>
          </tr>
          <tr id="row_station">
            <td class="addForm_Title">預排崗位<br>Station</td>
            <td class="" style="text-align: left; padding-left: 20px;">
              <div class="groupTitle" style="margin-top: 5px;"><i class="fas fa-crown"></i>值班</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_1.1" name="schedulingStation[]" value="早值"/>
                <label for="schedulingStation_1.1"><span></span>早值</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_1.2" name="schedulingStation[]" value="晚值"/>
                <label for="schedulingStation_1.2"><span></span>晚值</label>
              </div>

              <div class="groupTitle"><i class="fas fa-concierge-bell"></i>外場</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_2.1" name="schedulingStation[]" value="收銀"/>
                <label for="schedulingStation_2.1"><span></span>收銀</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_2.2" name="schedulingStation[]" value="控"/>
                <label for="schedulingStation_2.2"><span></span>控</label>
              </div>

              <div class="groupTitle"><i class="fas fa-utensils"></i>內場</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.1" name="schedulingStation[]" value="油炸"/>
                <label for="schedulingStation_3.1"><span></span>油炸</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.2" name="schedulingStation[]" value="燒"/>
                <label for="schedulingStation_3.2"><span></span>燒</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_3.3" name="schedulingStation[]" value="製"/>
                <label for="schedulingStation_3.3"><span></span>製</label>
              </div>

              <div class="groupTitle"><i class="fas fa-broom"></i>準備/打烊</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.1" name="schedulingStation[]" value="Open"/>
                <label for="schedulingStation_4.1"><span></span>Open</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.2" name="schedulingStation[]" value="前Close"/>
                <label for="schedulingStation_4.2"><span></span>前Close</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.3" name="schedulingStation[]" value="中Close"/>
                <label for="schedulingStation_4.3"><span></span>中Close</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_4.4" name="schedulingStation[]" value="後Close"/>
                <label for="schedulingStation_4.4"><span></span>後Close</label>
              </div>

              <div class="groupTitle"><i class="fas fa-user-tag"></i>特殊</div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_5.1" name="schedulingStation[]" value="支援"/>
                <label for="schedulingStation_5.1"><span></span>支援</label>
              </div>
              <div class="div_checkOption">
                <input type="checkbox" id="schedulingStation_5.2" name="schedulingStation[]" value="上課"/>
                <label for="schedulingStation_5.2"><span></span>上課</label>
              </div>
            </td>
          </tr>
          <tr>
            <td class="addForm_Title">預排班表<br>Picture</td>
            <td><input name="schedulingFile" type="file" style="border-bottom: none;"></td>
          </tr>
        </table>
        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large fontColor_white" type="submit">新增</button>
        </div>
        <div style="width: 100%; margin-top: 20px;">
          <button class="large cancel fontColor_white" type="button" onclick="javascript:location.href='index.php'">返回</button>
        </div>
      </form>
    </div>
    

   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>

   <script type="text/javascript">
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