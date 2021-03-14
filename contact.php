<?php
  require_once('function/frame/showFrame.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>通訊錄 - MOS Journal</title>
    <link rel="shortcut icon" href="images/assets/logo.ico" type="image/x-icon" />
    <link href="css/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/contact.css">
  </head>

 <body>
  <div class="mainContent">
    <div class="pageHeader">
      <table style="margin-bottom: 20px;">
        <tr>
          <td style="width: 100px;"><img src="images/assets/logo(white).png" style="width: 100px;"></td>
          <td style="text-align: left; padding-left: 20px;"><div class="title">MOS Journal</div></td>
        </tr>
      </table>
      
      <!-- <div class="title">M O S</div> -->
      <div class="subTitle">通訊錄 Contact</div>
    </div>
    

    <?php
      require_once("function/page/contact/get.php");
      getAll();
    ?>

   
   <div class="tabBar">
      <?php echo printTabbar($TABITEM_CONTACTS); ?>
   </div>
 </body>

</html>