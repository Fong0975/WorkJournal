<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新增禮券 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/coupons_insert.css">
  </head>

 <body onload="getDateline()">
  <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">新增禮券 Add Coupons</div>
    </div>
    
    <div class="session card" style="margin-top: 300px; ">
      <form id='form1' name="form1" action="function/page/coupons/insert.php" method="post">
        <table>
          <tr>
            <td class="addCoupon_Title">禮卷名稱 Name</td>
            <td><input class="input_underline" id="couponName" name="couponName" type="text"  placeholder="好友分享券" require value="好友分享券"></td>
          </tr>
          <tr>
            <td class="addCoupon_Title">禮卷序號 Serial</td>
            <td><input class="input_underline" id="couponSerial" name="couponSerial" type="number"  placeholder="xxxxxxxxx" min="1" max="999999999" required></td>
          </tr>
          <tr>
            <td class="addCoupon_Title">禮卷期限 Dateline</td>
            <td><input class="input_underline" id="couponDateline" name="couponDateline" type="date"  placeholder="2018-07-22" maxlength="10" style="width: 100% !important;" required></td>
          </tr>
        </table>
        
        <div style="width: 100%; margin-top: 100px;">
          <button class="large" type="submit">新增</button>
        </div>
      </form>
    </div>
    

   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_COUPONS); ?>
   </div>

   <script type="text/javascript">
    function getDateline(){
      var today = new Date();
      var today_year = today.getFullYear();
      var today_month= today.getMonth() + 1;

      var date_threeMonthLater = new Date(today_year, today_month + 2,1);
      var dateline = new Date(date_threeMonthLater - 1);
      var dateline_year = dateline.getFullYear();
      var dateline_month= dateline.getMonth() + 1;
      if(dateline_month < 10){
        dateline_month = "0"+dateline_month;
      }
      var dateline_day = dateline.getDate();

      document.getElementById("couponDateline").value = dateline_year + "-" + dateline_month + "-" + dateline_day;
      document.getElementById("couponSerial").focus();
    }
   </script>
  
 </body>
</html>