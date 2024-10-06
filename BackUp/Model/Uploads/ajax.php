<?php
require_once '../../connection.php';

session_start(); 

$userid=$_SESSION["userid"];

$data = array();



if( isset( $_POST['image_upload'] ) && !empty( $_FILES['images'] )){
	
	$image = $_FILES['images'];
	$allowedExts = array("gif", "jpeg", "jpg", "png","pdf","doc","docx","xls","xlsx","ppt","pptx");
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	

	$productid=$_POST['productid'];
	
	$code= $_POST['code'];
	$productname= $_POST['name'];
	$productname=str_replace("'","\'",$productname);
	
	$categoryid= $_POST['category'];
	$model= $_POST['model'];
	$selfno= $_POST['selfno'];
	
	//create directory if not exists
	if (!file_exists('images')) {
		mkdir('images', 0777, true);
	}
	$image_name = $image['name'];
	//get image extension
	$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
	//assign unique name to image
	$name = time().'.'.$ext;
	//$name = $image_name;
	//image size calcuation in KB
	$image_size = $image["size"] / 1024;
	$image_flag = true;
	//max image size
	$max_size = 10240;
	if( in_array($ext, $allowedExts) && $image_size < $max_size ){
		$image_flag = true;
	} else {
		$image_flag = false;
		$data['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
	} 
	
	if( $image["error"] > 0 ){
		$image_flag = false;
		$data['error'] = '';
		$data['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$image["error"];
	}

     

	date_default_timezone_set("Asia/Dhaka");

    $dt=date("d-m-Y h:i:sa");
	
	if($image_flag){
		move_uploaded_file($image["tmp_name"], "images/".$name);
		$src = "images/".$name;
		$dist = "images/thumbnail_".$name;
		$data['success'] = $thumbnail = 'thumbnail_'.$name;
		//thumbnail($src, $dist, 200);
		
        if($productid==0){
		$sql="insert into product (`userid`, `code`, `name`, `image`, `categoryid`,model,self)
		VALUES ($userid,'$code', '$productname', '$name',$categoryid,'$model','$selfno')";
		}
		else
		{
			$sql="update product set `code`='$code',`name`='$productname',`image`='$name',`categoryid`=$categoryid,model='$model',self='$selfno' where id=$productid";
		}
		
		//if (!mysqli_query($con,$sql)) {
		//	die('Error: ' . mysqli_error($con));
		//} 
		
if ($conn->query($sql) === TRUE) {
    
	echo "<script> alert('Data Successfully Saved ! !'); window.location.href='../../home.php?content=product'; </script>";
	
} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}
		
		
	}
	
	mysqli_close($conn);
	echo json_encode($data);
	
} else {
	$data[] = 'No Image Selected..';
}



function thumbnail($src, $dist, $dis_width = 100 ){

	$img = '';
	$extension = strtolower(strrchr($src, '.'));
	switch($extension)
	{
		case '.jpg':
		case '.jpeg':
			$img = @imagecreatefromjpeg($src);
			break;
		case '.gif':
			$img = @imagecreatefromgif($src);
			break;
		case '.png':
			$img = @imagecreatefrompng($src);
			break;
	}
	$width = imagesx($img);
	$height = imagesy($img);




	$dis_height = $dis_width * ($height / $width);

	$new_image = imagecreatetruecolor($dis_width, $dis_height);
	imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);


	$imageQuality = 100;

	switch($extension)
	{
		case '.jpg':
		case '.jpeg':
			if (imagetypes() & IMG_JPG) {
				imagejpeg($new_image, $dist, $imageQuality);
			}
			break;

		case '.gif':
			if (imagetypes() & IMG_GIF) {
				imagegif($new_image, $dist);
			}
			break;

		case '.png':
			$scaleQuality = round(($imageQuality/100) * 9);
			$invertScaleQuality = 9 - $scaleQuality;

			if (imagetypes() & IMG_PNG) {
				imagepng($new_image, $dist, $invertScaleQuality);
			}
			break;
	}
	imagedestroy($new_image);
}