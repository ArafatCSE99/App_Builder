<?php

$file			=	$_FILES['file']['name'];
$file_image		=	'';
if($_FILES['file']['name']!=""){
    extract($_REQUEST);
	$infoExt        =   getimagesize($_FILES['file']['tmp_name']);
	if(strtolower($infoExt['mime']) == 'image/gif' || strtolower($infoExt['mime']) == 'image/jpeg' || strtolower($infoExt['mime']) == 'image/jpg' || strtolower($infoExt['mime']) == 'image/png'){
		$file	=	preg_replace('/\\s+/', '-', time()."_".$file);
		$path   =   '../uploads/'.$file;
		move_uploaded_file($_FILES['file']['tmp_name'],$path);

       echo $file;
		
	}else{
		

	}
}
?>
