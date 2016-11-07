<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    

<?php

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'titlebar'");
	$row = mysqli_fetch_assoc($result);
	$titlebar = $row['option_value'];
?>


    <title><?php echo $titlebar; ?></title>

<?php

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'favicon'");
	$row = mysqli_fetch_assoc($result);
	$favicon = $row['option_value'];
	
	if($favicon!=''){
    	echo '<link rel="icon" type="image/x-icon" href="'.$favicon.'" />';
		
	}
?>

    
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/banner.css" rel="stylesheet">
 	<link href="/css/blog.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/easing.css">
	<link rel="stylesheet" href="/css/blueimp-gallery.min.css">  
	<link rel="stylesheet" href="/css/bootstrap-image-gallery.min.css">  
	<link rel="stylesheet" href="/css/styles.css">  
	<link rel="stylesheet" href="/cache/theme.css">    
	<link rel="stylesheet" href="/js/froala/css/froala_page.css">  

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>
    <script src="/js/unslider.min.js"></script>
    <script src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script src="/js/jquery.blueimp-gallery.min.js"></script>
	<script src="/js/bootstrap-image-gallery.min.js"></script>


  </head>
  <body>
