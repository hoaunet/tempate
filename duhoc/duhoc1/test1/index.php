<?php
include('inc_function.php');
/*$mysql = new mysqli('localhost', 'root', '', 'import_data');
	if (!$mysql->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysql->error);
		exit();
	}*/
	

$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);
$result = load('http://duhoctms.edu.vn/cam-nang-du-hoc?p=2',$options);
$pos = strpos($result['body'], '<div class="listnews">'); 
$pos1 = strpos($result['body'], "<div class='paging'>"); 
$tempt = substr($result['body'], $pos , $pos1 - $pos);

$pieces = explode('<div class="item">', $tempt);
if(count($pieces) >0){
	foreach($pieces as $val){
       if(strpos($val, '<p class="desc">')){	
          $arrData = getdata($val);
          $strInsert = "INSERT INTO `m_articles` (`a_title`, `a_description`, `a_short_desc`, `a_images`,`a_import_flag`,`a_free1`, `last_date`, `last_kind`, `last_ipadrs`, `last_user`) VALUES
						('".trim($arrData['title'])."','".trim($arrData['short_desc'])."','".trim($arrData['short_desc'])."','".trim($arrData['photo'])."','0','".trim($arrData['url'])."', '".date("Y-m-d H:i:s")."','0','127.0.0.1','1');"	;
		  echo 	$strInsert;			

			//$objRSU = $mysql->query($strInsert);		
       }
	}
}

//$mysql->close();
function getdata($strData){
	$arrData = array();	
	$pos = strpos($strData, '<a href=');
	$pos1 = strpos($strData, 'class="cover cv1"');
    $tempt = trim(substr($strData, $pos +9, $pos1 - $pos-11));    
    $arrData['url'] = $tempt;
    $pos = strpos($strData, '<img data-src="');
	$pos1 = strpos($strData, 'class="title">');
    $tempt = trim(substr($strData, $pos +15, $pos1 - $pos-15));
    $pos = strpos($tempt, '>');
    $image = trim(substr($tempt, 0, $pos-2));   
    if(!empty( $image)){
      $arrPhoto= explode('/', $image);
      if(is_dir('images/camnang/thumb')===false){
		mkdir('images/camnang/thumb', 0777, true);
		chmod('images/camnang/thumb', 0777);
	  }	  
	  copy( $image,"images/camnang/thumb/".$arrPhoto[count($arrPhoto)-1] );
      $arrData['photo'] = $arrPhoto[count($arrPhoto)-1];
    }
    $pos = strpos($strData, '<h3>');
	$pos1 = strpos($strData, '</h3>');
	$arrData['title'] = trim(substr($strData, $pos +4, $pos1 -$pos - 4)); 
	$pos = strpos($strData, '<p class="desc">');
	$pos1 = strpos($strData, '</p>');
	$arrData['short_desc'] = trim(substr($strData, $pos +16, $pos1 -$pos - 16)); 
    return $arrData;
}
?>
<script>
//setTimeout(location.reload(), 5000);
</script>