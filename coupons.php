<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>電子禮券 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/coupons.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <style type="text/css">
      .mainContent .session{
        background-color: transparent;
      }
    </style>
  </head>

 <body>
  <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left;  padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">電子禮券 Coupons</div>
    </div>
    

    <?php
      require_once("function/page/coupons/get.php");
      $qr = getQR_Array();
      getAll();
    ?>

   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_COUPONS); ?>
   </div>

   <div id="dialog" title="使用優惠券" style="text-align: center;">
    
  </div>

  <a id="newCoupon" href="coupons_insert.php" class="float">
    <i class="fa fa-plus my-float"></i>
  </a>

   <script src="script/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="script/jquery.qrcode.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="script/jquery.cookie.js"></script>
  <script>
    jQuery(function(){
      <?php
        for($i = 0; $i < count($qr); $i++){
          echo "jQuery('#qr_$i').qrcode({
            text: '".$qr[$i]."',
            width: 150,
            height: 150
          });
          ";
        }
        
      ?>
    })
  </script>
  <script>
    $(document).ready(function() {

        var i;
        for (i = 0; i < <?php echo count($qr);?>; i++) {
          if($('#used_'+i).css('display') == 'none'){ 

            $('#qr_'+i).click(function() {
              $.cookie('couponSerial', $(this).attr("data_serial"), { expires: 1 });
              jQuery('#dialog').html("");
              jQuery('#dialog').qrcode({
                text: $.cookie('couponSerial'),
                width: 450,
                height: 450
              });

              $( "#dialog" ).dialog({
                title: $.cookie('couponSerial'),
                resizable: true,
                draggable: false,
                width: "auto",
                modal: true,
                buttons: {
                  "使用" : function() {
                    window.location.href = "function/page/coupons/set_used.php?serial=" + $.cookie('couponSerial');
                  }
                }
              });

            });
          } 
        }
    });
  </script>
  <script type="text/javascript">
    function deleteCoupon(deleteSerial){
      if (window.confirm("確定刪除此'" + deleteSerial + "'筆優惠券序號嗎？")) {
        location.href= "function/page/coupons/delete.php?serial=" + deleteSerial;
      }
    }
  </script>
 </body>
</html>