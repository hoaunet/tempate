<?php
include('inc_function.php');
  $mysqli = new mysqli('localhost', 'root', '', 'import_data');
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	} 
	$result = $mysqli->query("SELECT * FROM `m_articles` WHERE a_import_flag=0 limit 1");
	$row = $result->fetch_assoc();
	echo 	$row['a_id'];
    if(!isset($row['a_id'])) exit;    
$options = array(
	'return_info'	=> true,
	'method'		=> 'post'
);


$result = load('http://duhoctms.edu.vn/'.$row['a_free1'],$options);
$pos = strpos($result['body'], '<div class="newscontent">'); 
$pos1 = strpos($result['body'], '<div class="newscontact">'); 
$tempt = substr($result['body'], $pos , $pos1 - $pos );
$pos = strpos($tempt, '<div class="view">');
$strContent =substr($tempt, 0 ,$pos);

$pieces = explode('<img data-src',$strContent);
$arrPhoto = array();
if(count($pieces) >0){//has image
	foreach($pieces as $val){
		if(strpos($val, 'alt="">') !==false){
			$pos = strpos($val, 'width=');
			$arrPhoto[] = trim(substr($val, 2 , $pos -4));
		}		
	}
	if(count($arrPhoto) >0){
		foreach($arrPhoto as $v){
			$arrImage = explode('/', $v);
			copy($v, 'images/vieclam/'.$arrImage[count($arrImage)-1]);
			$arrTempt[$v] = $arrImage[count($arrImage)-1];
		}
		foreach($arrTempt as $k=>$v1){
			$strContent = str_replace($k,$v1,$strContent);	
		}
	}	
	
}

if(!empty($strContent)){	
	$strUpdate = "UPDATE `m_articles` set a_description='".str_replace("'","''",$strContent)."',a_import_flag=1 where a_id=".$row['a_id']." ;"	;	
	
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