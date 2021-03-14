<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>卡號二維碼 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">


    <style type="text/css">
      .buttonLarge{
        font-size: 50px;
        font-weight: bolder;
        font-family: inherit;

        border-radius: 15px;
        padding: 50px 90px;

        background-color: #c0392b;
        border:none;
        box-shadow: none;

        color: #dcdcdc;

      }

      .buttonLarge:hover, .buttonLarge:active, .buttonLarge:focus{
        background-color: #a52b1f;
      }
    </style>
  </head>

 <body>
  <?php
    require_once('function/page/qr_identification/get.php');
    if(isset($_GET['num'])){
      $IDENTIFICATION_NUMBER = getIdentificationNum_Contact($_GET['num']);
      $IDENTIFICATION_PASSWORD = getIdentificationPassword_Contact($_GET['num']);
    }else{
      $IDENTIFICATION_NUMBER = getIdentificationNum();
      $IDENTIFICATION_PASSWORD = getIdentificationPassword();
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
      <div class="subTitle">卡號二維碼 QR Idnetification</div>
    </div>

    
    <div id="accordion" style="margin: 150px  35px auto 35px !important; border:none; box-shadow: none;">
      <span style="font-size: 30pt !important; border:none; box-shadow: none;">[卡號] <?php echo $IDENTIFICATION_NUMBER; ?></span>
      <div id="qrIdentification_Account" style="text-align: center;">
        
      </div>
      <span style="font-size: 30pt !important; border:none; box-shadow: none;">[密碼] <?php echo $IDENTIFICATION_PASSWORD; ?></span>
      <div id="qrIdentification_Password" style="text-align: center;">

      </div>
    </div>

    <div style="margin-top: 40px; text-align: center;<?php if(!isset($_GET['goback'])){echo " display: none;";} if($_GET['goback'] != "true"){echo " display: none;";} ?>">
      <button class="huge" onclick="javascript:location.href='clock_records.php'">查看紀錄</button>
    </div>
    
    

   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_QR_IDENTIFICATION); ?>
   </div>
  <script src="script/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="script/jquery.qrcode.min.js"></script>
  <script>
    jQuery(function(){
      jQuery('#qrIdentification_Account').qrcode({
        text: "<?php echo $IDENTIFICATION_NUMBER; ?>",
        width: 550,
        height: 550
      });

      jQuery('#qrIdentification_Password').qrcode({
        text: "<?php echo $IDENTIFICATION_PASSWORD; ?>",
        width: 550,
        height: 550
      });
    })
  </script>
  <script>
  $( function() {
    $( "#accordion" ).accordion({
      heightStyle: "content",
      icons: false
    });
  } );
  </script>
 </body>
</html>