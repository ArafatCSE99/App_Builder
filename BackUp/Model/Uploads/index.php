<?php require_once 'config.php';?>
<!DOCTYPE html> 
<html>
<head>
	<title>Ajax Image Upload Using jQuery, PHP and MySQL</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" >	
	<meta name="description" content="ajax image upload php, ajax image upload jquery php, upload image ajax jquery php mysql, ajax image upload jquery php example, Ajax Image Upload Using jQuery, PHP and MySQL, image upload using ajax in php, Ajax Image Upload and Resize with jQuery and PHP, PHP AJAX Image Upload, image upload using ajax jquery">
	<meta name="keywords" content="ajax image upload php, ajax image upload jquery php, upload image ajax jquery php mysql, ajax image upload jquery php example, Ajax Image Upload Using jQuery, PHP and MySQL, image upload using ajax in php, Ajax Image Upload and Resize with jQuery and PHP, PHP AJAX Image Upload, image upload using ajax jquery">
	
</head>
<body>
	<div class="container">
		<h1 class="page-title" >Ajax Image Upload Using jQuery, PHP and MySQL</h1>
		<div class="form-container">
			<form enctype="multipart/form-data" name='imageform' role="form" id="imageform" method="post" action="ajax.php">
				<div class="form-group">
					<p>Please Choose Image: </p>
					<input class='file' type="file" class="form-control" name="images" id="images" placeholder="Please choose your image">
					<span class="help-block"></span>
				</div>
				<div id="loader" style="display: none;">
					Please wait image uploading to server....
				</div>
				<input type="submit" value="Upload" name="image_upload" id="image_upload" class="btn"/>
			</form>
		</div>
		<div class="clearfix"></div>
		<div id="uploaded_images" class="uploaded-images">
			<div id="error_div">
			</div>
			<div id="success_div">
			</div>
		</div>
	</div>
	<input type="hidden" id='base_path' value="<?php echo BASE_PATH; ?>">
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.form.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>