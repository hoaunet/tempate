<?php
include('../inc_function.php');
$mysqli = new mysqli('localhost', 'root', '', 'opencart');
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	} 
	$result = $mysqli->query("SELECT * FROM `product` WHERE status=0 limit 1");
	$row = $result->fetch_assoc();
	//print_r($row);//exit;
	$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);

$result = load('https://shop.vnexpress.net'.$row['url'],$options);
	
$arrDetail = array();
$pos = strpos($result['body'], '<div class="text_info_sp width_common">'); 
$pos1 = strpos($result['body'], '<div class="option_sp_detail width_common">');
$Tempt =  trim(substr($result['body'], $pos , $pos1 - $pos-25));



$strUpdate = " UPDATE `product` SET `descriptiom` = '".str_replace("'",'"',trim($Tempt))."', `status` = '1' WHERE `product`.`product_id` = ".$row['product_id'];
echo $strUpdate;
$objRSU = $mysqli->query($strUpdate);
$mysqli->close();
?>
<script>

setTimeout(location.reload(), 5000);
</script>


