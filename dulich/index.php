<?php
include('inc_function.php');	

$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);
$result = load('https://www.dulichvietnam.com.vn/danh-thang/57',$options);

$pos = strpos($result['body'], '<div class="dulichvietnam margintop10px">'); 
$pos1 = strpos($result['body'],'<div class="dtqc">');//'<div class="rightcol">');//
$tempt = substr($result['body'], $pos , $pos1 - $pos);
$pieces = explode('<div class="news">', $tempt);
//di sản -ky quan=1
if(count($pieces) >0){
	foreach($pieces as $val){
       if(strpos($val, '<p class="doctiep">')){	
          $arrData = getdata($val);
          $strInsert = "INSERT INTO `m_articles` (`a_title`,`a_category_id`,`a_type_id`, `a_description`, `a_short_desc`, `	a_short_url`, `a_images`,`a_import_flag`,`a_free1`, `last_date`, `last_kind`, `last_ipadrs`, `last_user`) VALUES
						('".trim($arrData['title'])."','1','1','".trim($arrData['short_desc'])."','".trim($arrData['short_desc'])."','".trim($arrData['short_link'])."','".trim($arrData['photo'])."','0','".trim($arrData['url'])."', '".date("Y-m-d H:i:s")."','0','127.0.0.1','1');"	;
		  echo 	$strInsert;			

			//$objRSU = $mysql->query($strInsert);		
       }
	}
}

function getdata($strData){
	$arrData = array();	
	$pos = strpos($strData, 'href=');
	$pos1 = strpos($strData, '<img src');
    $tempt = trim(substr($strData, $pos +6, $pos1 - $pos-11)); 
    $pos = strpos($tempt, 'title');       
    $arrData['url'] = trim(substr($tempt, 0, $pos-2));      
    $arrLink =  explode('.',$arrData['url']);
    $arrData['short_link'] = $arrLink[0];
    $pos = strpos($strData, '<img src');
	$pos1 = strpos($strData, 'width=');
    $tempt = trim(substr($strData, $pos +12 , $pos1 - $pos-14));    
    $image = trim(substr($tempt, 0, $pos-2));   
    if(!empty( $image)){
      $arrPhoto= explode('/', $image);      
      $arrExt = explode('.', $arrPhoto[count($arrPhoto)-1]);     
      if(is_dir('images/thang_canh/thumb')===false){
		mkdir('images/thang_canh/thumb', 0777, true);
		chmod('images/thang_canh/thumb', 0777);
	  }	  
	  copy( 'https://www.dulichvietnam.com.vn/'.$image,"images/thang_canh/thumb/".$arrData['short_link'].'.'.$arrExt[count($arrExt)-1] );
      $arrData['photo'] = $arrData['short_link'].'.'.$arrExt[count($arrExt)-1];
    }
    $pos = strpos($strData, '<h3>');
	$pos1 = strpos($strData, '</h3>');
	$arrData['title'] = trim(strip_tags(substr($strData, $pos +4, $pos1 -$pos - 4))); 
	$pos = strpos($strData, '<p class="mota">');
	$pos1 = strpos($strData, '</p>');
	$arrData['short_desc'] = trim(substr($strData, $pos +16, $pos1 -$pos - 16));
	
    return $arrData;
}
?>
<script>
//setTimeout(location.reload(), 5000);
</script>