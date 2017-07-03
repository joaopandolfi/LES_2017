<?php

$folder = '/home/u284261513/public_html/les/assets/imgs/';
$url = "http://restfull.hol.es/les/assets/imgs/";
$post_data = array();
//parse_str(file_get_contents('php://input'),$post_data);

//$base = $post_data["data"];

$base = file_get_contents('php://input');
$binary = base64_decode($base);

header('Content-Type: bitmap; charset=utf-8');
$im_name = uniqid().".jpg";
$file = fopen($folder.$im_name, 'wb');
fwrite($file, $binary);
fclose($file);
echo '{"success":1, "data":"'.$url.$im_name.'"}';

?>