<?php
############ Configuration ##############
$config["generate_image_file"]			= true;
$config["generate_thumbnails"]			= true;
$config["image_max_size"] 				= 1000; //Maximum image size (height and width)
$config["thumbnail_size"]  				= 1000; //Thumbnails will be cropped to 200x200 pixels
$config["thumbnail_prefix"]				= "thumb_"; //Normal thumb Prefix
$config["destination_folder"]			= SRC.'assets/imgs/'; //upload directory ends with / (slash)
$config["thumbnail_destination_folder"]	= SRC.'assets/imgs/'; //upload directory ends with / (slash)
$config["upload_url"] 					= "http://restfull.hol.es/les/assets/imgs/"; 
$config["quality"] 						= 100; //jpeg quality
$config["random_file_name"]				= true; //randomize each file name


if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	exit;  //try detect AJAX request, simply exist if no Ajax
}


//specify uploaded file variable
$config["file_data"] = $_FILES["photos"]; 


//include sanwebe impage resize class
include(SRC."libs/resize.class.php"); 


//create class instance 
$im = new ImageResize($config); 


try{
	$responses = $im->resize(); //initiate image resize
	
	$imgIds = "";
	foreach($responses["images"] as $response){
		$imgsIds .= $response.";";
	}
	
	echo '{"success":1, "data":"'.$imgsIds.'"}';
	
}catch(Exception $e){
	echo '{"success":0,"error":"';
	echo $e->getMessage();
	echo '"}';
}	
?>