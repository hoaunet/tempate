<?php
include('../inc_function.php');
/*$mysql = new mysqli('localhost', 'root', '', 'import_data');
	if (!$mysql->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysql->error);
		exit();
	}*/
	

$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);
$result = load('http://quangcao360.net/bat-dong-san-cate1/page/2',$options);

$pos = strpos($result['body'], '<div class="block_dpl_library">'); 
$pos1 = strpos($result['body'],'<div class="paging-library">');//'<div class="rightcol">');//
$tempt = substr($result['body'], $pos , $pos1 - $pos);
//echo $tempt;die;
$pieces = explode('<div class="post_listing_main_block">', $tempt);
//echo "<pre>";print_r($pieces);echo "</pre>";die;
if(count($pieces) >0){
	foreach($pieces as $val){
       if(strpos($val, '<div class="post_listing_main_title">')){	
          $arrData = getdata($val);
          $strInsert = "INSERT INTO `m_quangcao360` (`a_title`,`a_category_id`,`a_type_id`, `a_description`, `a_short_desc`, `a_images`,`a_import_flag`,`a_free1`, `last_date`, `last_kind`, `last_ipadrs`, `last_user`) VALUES
						('".trim($arrData['title'])."','1','1','','','".trim($arrData['photo'])."','0','".trim($arrData['url'])."', '".date("Y-m-d H:i:s")."','0','127.0.0.1','1');"	;
		  echo 	$strInsert;			

			//$objRSU = $mysql->query($strInsert);		
       }
	}
}

//$mysql->close();
function getdata($strData){
	$arrData = array();	    
	$pos = strpos($strData, '<a href=');
	$pos1 = strpos($strData, 'alt=');
    $tempt = trim(substr($strData, $pos +9, $pos1 - $pos-11));        
    $arrData['url'] = $tempt;   
    $pos = strpos($strData, '<img src=');
	$pos1 = strpos($strData, 'ALT=');
    $image = trim(substr($strData, $pos +10, $pos1 - $pos-12));  
     
    if(!empty( $image)){
      $arrPhoto= explode('/', $image);
      if(is_dir('../images/quangcao360/thumb')===false){
		mkdir('../images/quangcao360/thumb', 0777, true);
		chmod('../images/quangcao360/thumb', 0777);
	  }	  
	  copy( $image,"../images/quangcao360/thumb/".$arrPhoto[count($arrPhoto)-1] );
      $arrData['photo'] = $arrPhoto[count($arrPhoto)-1];
    }
    $pos = strpos($strData, '<h2>');
	$pos1 = strpos($strData, '</h2>');
	$arrData['title'] = trim(strip_tags(substr($strData, $pos , $pos1 -$pos ))); 
	
    return $arrData;
}
?>
<script>
//setTimeout(location.reload(), 5000);
</script>