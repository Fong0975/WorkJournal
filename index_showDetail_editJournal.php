<?php
  require_once('function/frame/showFrame.php');
  require_once('function/page/index/get_journal.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>編輯日誌 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style type="text/css">
      /* ----------- Add-Form  ----------- */
      td{
        padding-top: 20px;
        padding-bottom: 20px;
      }

      .addForm_Title{
        width: 20%;
      }

      ::placeholder {
        color: #7c7c7c;
      }
    </style>
  </head>

 <body>
  <?php
    if(!isset($_GET['date'])){
      header('Location: index.php?err=no_query_date');
      exit;
    }else{
      $schedulingDate = $_GET['date'];
      $schedulingDate_array = explode("-", $schedulingDate);
      if(!checkdate ($schedulingDate_array[1], $schedulingDate_array[2], $schedulingDate_array[0])){
        header('Location: index.php?err=date_has_wrong_format');
        exit;
      }

      if(isExistJournal($schedulingDate) == "false"){
        // echo "Not Exist";
        header('Location: index.php?err=clock_record_not_exist');
        exit;
      }

      $journalData = getJournal($schedulingDate);
      // foreach ($journalData as $i) {
      //   echo "<div style='color:#FFF;'>-->$i</div>";
      // }
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
      <div class="subTitle">編輯日誌 Modify Journal</div>
    </div>
    
    <div class="session transparent" style="margin-top: 100px; ">
      <form id='form1' name="form1" action="function/page/index/edit_journal.php" method="post">
        <input name="journalID" value="<?php echo $journalData[0]; ?>" style="display: none;">
        <table>
          <tr>
            <td class="addForm_Title">日誌日期<br>Date</td>
            <td><input class="dark" id="journalDate" name="journalDate" type="date" style="width: 100% !important;" value="<?php echo $schedulingDate; ?>" required readonly></td>
          </tr>
          <tr>
            <td class="addForm_Title">基本薪資<br>Basic Salary</td>
            <td><input class="dark" id="journalBasicSalary" name="journalBasicSalary" type="number" min="0" max="999" step="0.01" value="<?php echo number_format(floatval($journalData[2]),2); ?>" style="width: 100% !important;" required></td>
          </tr>
          <tr>
            <td class="addForm_Title">休假日上班<br>Off-Day</td>
            <td style="text-align: left; padding-left: 20px; padding-bottom: 0px; ">
              <div style="border-bottom: 1px solid rgb(172, 172, 172); padding-bottom: 20px;">
                否
                <label class="switch">
                  <input id="journalOffDay" name="journalOffDay" type="checkbox"<?php if(intval($journalData[3]) == 1){echo " checked";} ?>>
                  <span class="slider"></span>
                </label>
                是
              </div>
            </td>
          </tr>
          <tr>
            <td class="addForm_Title">國定假日上班<br>Holiday</td>
            <td style="text-align: left; padding-left: 20px; padding-bottom: 0px; ">
              <div style="border-bottom: 1px solid rgb(172, 172, 172); padding-bottom: 20px;">
                否
                <label class="switch">
                  <input id="journalHoliday" name="journalHoliday" type="checkbox"<?php if(intval($journalData[4]) == 1){echo " checked";} ?>>
                  <span class="slider"></span>
                </label>
                是
              </div>
            </td>
          </tr>
        </table>
        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large fontColor_white" type="submit">修改</button>
        </div>
        <div style="width: 100%; margin-top: 20px;">
          <button class="large cancel fontColor_white" type="button" onclick="javascript:location.href='index_showDetail.php?y=2019&m=12&d=16'">返回</button>
        </div>
      </form>
    </div>
    

   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>
  </body>
</html>