<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>打卡記錄 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/clock_records.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  </head>

<?php
  $selectedDate = "";

  if(isset($_GET['y']) && isset($_GET['m']) && isset($_GET['d'])){
    require_once('function/dateFormat.php');

    $selectedDate = getFormatedDate($_GET['y'], $_GET['m'], $_GET['d']);
    $y = $_GET['y'];
    $m = $_GET['m'];
    $d = $_GET['d'];
  }

  if(mb_strlen($selectedDate, "utf-8") != 10){
    date_default_timezone_set('Asia/Taipei'); 
    $selectedDate = date("Y-m-d");
    $y = date("Y");
    $m = date("m");
    $d = date("d");
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
      <div class="subTitle">打卡記錄 Records</div>
    </div>

    <div style="color: #FFF; text-align: center; font-size: 30px;">
      <?
        require_once('function/page/clock_records/get.php');
        if($_GET['detail'] == "true"){
          echo getLostClock_detail();
        }else{
          echo getLostClock_outline();
        } 
      ?>
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

    <div style="color: #FFF;">
      <?php
        require_once('function/page/clock_records/get.php');
        echo getClockRecord_Day($selectedDate);
      ?>
    </div>


    <div style="width: 100%; margin-top: 100px;">
      <button class="large fontColor_white" type="button" onclick="javascript:location.href='index_showDetail.php?y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>'">當日資訊</button>
    </div>

<!--     <div>
      <table class="timeline">
        <tr>
          <td class="record_time start"><i class="line"></i><div>08:00</div></td>
          <td class="record_text">上班</td>
        </tr>
        <tr>
          <td class="record_time middle"><i class="line"></i><div>13:00</div></td>
          <td class="record_text">休息開始</td>
        </tr>
        <tr>
          <td class="record_time middle"><i class="line"></i><div>13:25</div></td>
          <td class="record_text">休息結束</td>
        </tr>
        <tr>
          <td class="record_time end"><i class="line"></i><div>15:00</div></td>
          <td class="record_text">下班</td>
        </tr>
      </table>
    </div>
     -->
   
   <div class="tabBar">
      <?php echo printTabbar(""); ?>
   </div>

   <div id="dialog" class="clockOptionPanel" title="使用優惠券" style="text-align: center; display: none;">
      <button class="btDarkRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=上班'">上班</button>
      <button class="btLightRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=休息開始'">休息</button>
      <button class="btLightRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=休息結束'">返回</button>
      <button class="btDarkRed" onclick="javascript:location.href='function/shortcut/clockIn.php?type=下班'">下班</button>
      <button id="btCancel" class="btCancel">取消</button>
    </div>

    <a id="newCoupon" href="#" class="float">
      <i class="my-float fas fa-bell"></i>
    </a>

     <script src="script/jquery-1.12.4.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <script>
      $( "#newCoupon" ).click(function() {
        $( "#dialog" ).dialog({
                  title: "上班打卡",
                  resizable: true,
                  draggable: false,
                  width: "650px",
                  modal: true
                });
      });

      $( "#btCancel" ).click(function() {
        $( "#dialog" ).dialog( "close" );
      });
    </script>

   <script type="text/javascript">
     function loadDate(){
      document.getElementById("dateFilter").value = "<?php echo $selectedDate; ?>";
     }

     function redirectDate(){
      $splitDate = document.getElementById("dateFilter").value.split("-");

      window.location.href = "clock_records.php?y="+$splitDate[0]+"&m="+$splitDate[1]+"&d="+$splitDate[2];
     }
   </script>
 </body>
</html>