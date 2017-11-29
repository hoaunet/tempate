<?php

include('../inc_function.php');

  $mysqli = new mysqli('localhost', 'root', '', 'opencart');
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	} 
$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);
$page = isset($_REQUEST['p'])?$_REQUEST['p']:12;
if($page==0) exit;

///https://shop.vnexpress.net/du-lich/khach-san-resort/page/'.$page.'.html
//'https://shop.vnexpress.net/du-lich/tour-du-lich/page/'.$page.'.html'
$result = load('https://shop.vnexpress.net/dien-tu-cong-nghe/phu-kien-cong-nghe/page/'.$page.'.html',$options);
//$result = load('https://shop.vnexpress.net/dien-tu-cong-nghe/may-tinh-bang',$options);

$pos = strpos($result['body'], '<div class="width_common list_item_cate" id="list-folder">'); 
$pos1 = strpos($result['body'], '<div class="paging_folder width_common">'); 
//$pos1 = strpos($result['body'], '<div id="wrapper_footer" class="width_common">'); 

$tempt = substr($result['body'], $pos , $pos1 - $pos);
//echo  $tempt;exit;
$pieces = explode('<div class="item_cate">', $tempt);
//echo "<pre>";print_r($pieces);echo "</pre>";exit;
//echo $pieces[1];exit;
$timeStart = time();
$timeEnd =  time() + (365 * 24 * 60 * 60);
$i=1*$page;
$strInsert = '';
if(count($pieces)){
	$arrData = array();
	foreach($pieces as $val){
	  if(strpos($val, '<div class="name_sp">')){	
		$arrData = getdata($val);
        //echo "<pre>";print_r($arrData );echo "</pre>";exit; 
		
		$strInsert = "INSERT INTO `product` ( `name`, `url`, `descriptiom`, `category_id`, `short_url`, `model`, `sku`, `upc`, `ean`, `jan`, `isbn`, `mpn`, `location`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `points`, `tax_class_id`, `date_available`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `subtract`, `minimum`, `sort_order`, `status`, `viewed`, `date_added`, `date_modified`) VALUES ( '".str_replace("'",'"',trim($arrData['title']))."', '".str_replace("'",'"',trim($arrData['link']))."', '', '63', '".str_replace("'",'"',trim($arrData['short_url']))."', 'Linhkien0".$i."', '', '', '', '', '', '', '1', '5', '', '".str_replace("'",'"',trim($arrData['photo']))."', '', '1', '".str_replace("'",'"',trim($arrData['price']))."', '0', '', '2017-06-26', '0.00000000', '0', '0.00000000', '0.00000000', '0.00000000', '0', '1', '1', '".$i."', '0', '10', '2017-06-26 00:00:00', '2017-06-26 00:00:00');"	;
		
		/*$strInsert = "INSERT INTO `articles` (`title`, `body`, `short_desc`, `articles_image`, `category_id`, `created`, `modified`, `user_id`) VALUES
						('".trim($arrData['title'])."','".trim($arrData['title'])."','".trim($arrData['link'])."', '','12','".$timeStart."','".$timeStart."','1');"	;	*/
		$objRSU = $mysqli->query($strInsert);
		$i++;
		echo 	 "<br>".$strInsert;
		} 
		
	}
	
	
}
/*
mysql_close($link);

*/
function getdata($strData)
{
    //echo $strData;
	$arrData = array();	
	$pos = strpos($strData, '<div class="img_box width_common">');
	$pos1 = strpos($strData, '<div class="box_info_sp width_common">');
    $tempt = trim(substr($strData, $pos +6, $pos1 - $pos-8));
    $pos = strpos($tempt, 'href=');
	$pos1 = strpos($tempt, '<img');	
    $arrData['link'] = trim(substr($tempt, $pos +6, $pos1 - $pos-8)); 
    $pos = strpos($tempt, 'src=');
	$pos1 = strpos($tempt, 'alt=');
    $arrData['photo'] = trim(substr($tempt, $pos +5, $pos1 - $pos-7)); 
    //echo "<bR>".$arrData['photo'];

    $aTe = explode('/', $arrData['link']);
    $arrTempt = explode('.', $aTe[count($aTe)-1]);
    $arrData['short_url'] =$arrTempt[0];
     //echo "<pre>";print_r( $arrTempt);echo "</pre>";exit;

    if(!empty($arrData['photo'])){
        $aTe = explode('/', $arrData['photo']);
        $arrTempt = explode('.', $aTe[count($aTe)-1]); 
       // echo "<pre>";print_r( $arrTempt);echo "</pre>";
        $name_img = $arrData['short_url'].'_luatsutunhan.'.$arrTempt[count($arrTempt)-1];
    	if(is_dir('../images/catalog/du_lich')===false){
				mkdir('../images/catalog/dien_tu_cong_nghe', 0777, true);
				chmod('../images/catalog/dien_tu_cong_nghe', 0777);
		}
		copy( $arrData['photo'],"../images/catalog/dien_tu_cong_nghe/".$name_img );
		$arrData['photo'] = 'catalog/dien_tu_cong_nghe/'.$name_img ;
    }
    $pos = strpos($strData, '<div class="name_sp">');
	$pos1 = strpos($strData, '<p class="price">');
	$arrData['title'] = trim(strip_tags(substr($strData, $pos, $pos1 - $pos)));
	$pos = strpos($strData, '<p class="price">');
	$pos1 = strpos($strData, '<p class="price_true">');
	$price = str_replace("đ","",strip_tags(substr($strData, $pos, $pos1 - $pos)));
	$arrData['price'] = trim(str_replace(".","",$price ));

    //echo $tempt;
    //echo "<pre>";print_r($arrData);echo "</pre>";
    return $arrData;
}

?>
<script>

setTimeout(myFunction, 1000);
function myFunction() {
	
    location.href = "?p=<?php echo $page-1?>";
}
</script>
