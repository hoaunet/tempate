<?php
include('../inc_function.php');
  $mysqli = new mysqli('localhost', 'root', '', 'import_data');
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	} 
	$result = $mysqli->query("SELECT * FROM `m_quangcao360` WHERE a_import_flag=0  limit 1");
	$row = $result->fetch_assoc();
	echo $row['a_id'];
    if(!isset($row['a_id'])) exit;    
$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);
$result = load($row['a_free1'],$options);
$pos = strpos($result['body'], '<div class="post_main_left_contact">'); 
$pos1 = strpos($result['body'], '<div class="post_main_left_content_details">'); 
$tempt = substr($result['body'], $pos , $pos1 - $pos );
$pieces = explode('<div class="post_main_left_contact_line">',$tempt);
if(count($pieces) >0){
	foreach($pieces as $val){
      if(strpos($val, 'Liên hệ') !==false){
      	 $str = explode('</div>',$val);  
      	 $pos = strpos($str[0], '<span class="contact_right">'); 
		  $arrData['name'] = strip_tags(trim(substr($str[0], $pos  , strlen($str[0])- $pos)));
          $pos = strpos($str[1], 'src="http://quangcao360.net/themes/img/ico-phone.png">');
          $strtempt = strip_tags(trim(substr($str[1], $pos +strlen('src="http://quangcao360.net/themes/img/ico-phone.png">') , strlen($str[1])- $pos)));
          $arrData['tel'] =$strtempt;          
      }elseif(strpos($val, 'contact_mail') !==false){
         $str = explode('<div class="post_main_left_text">',$val);
         $pos = strpos($str[0], '<span class="contact_right">'); 
         $arrData['email'] = strip_tags(trim(substr($str[0], $pos  , strlen($str[0])- $pos)));
         $arrData['content'] =  trim($str[1]);
         
      }
	}
}
if(count($arrData) >0){	
	$strUpdate = "UPDATE `m_quangcao360` set a_description='".str_replace("'","''",$arrData['content'])."',	a_short_desc='".str_replace("'","''",$arrData['name'])."',
						a_free2='".str_replace("'","''",$arrData['tel'])."',a_free3='".str_replace("'","''",$arrData['email'])."',a_import_flag=1 where a_id=".$row['a_id']." ;"	;	
	
	$objRSU = $mysqli->query($strUpdate);	
    	
}
$mysqli->close();
?>
<script>
setTimeout(myFunction, 1000);
function myFunction() {	
   location.href = "detail.php";
}
</script>