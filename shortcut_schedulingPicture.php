<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>今日班表 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/clock_records.css">
    <style type="text/css">
      .imgBox{
        width: 100%;
        margin: 0px;
        text-align: center;
      }

      img{
        max-width: 90%;
        max-height: 100%;
        margin: auto;
        display: block;
      }
    </style>
  </head>

<?php
  $selectedDate = "";

  if(isset($_GET['y']) && isset($_GET['m']) && isset($_GET['d'])){
    require_once('function/dateFormat.php');

    $selectedDate = getFormatedDate($_GET['y'], $_GET['m'], $_GET['d']);
  }

  if(mb_strlen($selectedDate, "utf-8") != 10){
    date_default_timezone_set('Asia/Taipei'); 
    $selectedDate = date("Y-m-d");
  }
?>

 <body onload="loadDate();">
   <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">今日班表 Scheduling Picture</div>
    </div>    
    
    
    <div class="session transparent">
      <table>
        <tr>
          <td style="width: 150px; font-weight: bolder;">查詢日期</td>
          <td style="padding: 0px 20px;"><input id="dateFilter" type="date"></td>
          <td style="width: 150px;"><button onclick="redirectDate();">查詢</button></td>
        </tr>
      </table>
    </div>

    <div class="imgBox">
      <?php
        require_once('function/page/index/get_scheduling.php');
        $pictureName = getScheduling_image_name($selectedDate);

        if(mb_strlen($pictureName, "utf-8") > 1) {
          echo "<a href=\"images/scheduling/$pictureName\" target=\"_self\"><img src=\"images/scheduling/$pictureName\" /></a>";
        }
      ?>
    </div>


   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>

   <script type="text/javascript">
     function loadDate(){
      document.getElementById("dateFilter").value = "<?php echo $selectedDate; ?>";
     }

     function redirectDate(){
      $splitDate = document.getElementById("dateFilter").value.split("-");

      window.location.href = "shortcut_schedulingPicture.php?y="+$splitDate[0]+"&m="+$splitDate[1]+"&d="+$splitDate[2];
     }
   </script>
 </body>
</html>