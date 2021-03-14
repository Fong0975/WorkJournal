<?php

$TABITEM_OUTLINE = "outline";
$TABITEM_COUPONS = "coupons";
$TABITEM_CONTACTS = "contacts";
$TABITEM_QR_IDENTIFICATION = "qrIdentification";
$TABITEM_SETTING = "setting";

function printTabbar($currentItem){
	global $TABITEM_OUTLINE, $TABITEM_COUPONS, $TABITEM_CONTACTS, $TABITEM_QR_IDENTIFICATION, $TABITEM_SETTING;

	$str = "
  
<div class='barItem";

	if($currentItem == $TABITEM_OUTLINE){
		$str .= " actived";
	}

	$str .= "'>
  <a href=\"index.php\"><img src='images/assets/icon_home.png'></a>
</div>
<div class='barItem";

	if($currentItem == $TABITEM_COUPONS){
		$str .= " actived";
	}

	$str .= "'>
  <a href=\"coupons.php\"><img src='images/assets/icon_coupon.png'></a>
</div>
<div class='barItem";

	if($currentItem == $TABITEM_CONTACTS){
		$str .= " actived";
	}

	$str .= "'>
  <a href=\"contact.php\"><img src='images/assets/icon_contact.png'></a>
</div>
<div class='barItem";

	if($currentItem == $TABITEM_QR_IDENTIFICATION){
		$str .= " actived";
	}

	$str .= "'>
  <a href=\"qr_identification.php\"><img src='images/assets/icon_qrIdentification.png'></a>
</div>
<div class='barItem";

	if($currentItem == $TABITEM_SETTING){
		$str .= " actived";
	}

	$str .= "'>
  <a href=\"setting.php\"><img src='images/assets/icon_setting.png'></a>
</div>
 
";

	return $str;

}

	
?>