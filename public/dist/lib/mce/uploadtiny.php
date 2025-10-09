<?php
$tempdir = "upload/";
if (!file_exists($tempdir))
    mkdir($tempdir);

reset($_FILES);
$temp = current($_FILES);
if(is_uploaded_file($temp['tmp_name'])){
    if(isset($_SERVER['HTTP_ORIGIN'])){
        if(in_array($_SERVER['HTTP_ORIGIN'])){
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        }else{
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }
  
    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }
  
    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "mp4"))){
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }
    
    $acak = rand(1111111, 9999999).".png";
    $filetowrite = $tempdir . $acak;
    move_uploaded_file($temp['tmp_name'], $filetowrite);
  
    echo json_encode(array('location' => $filetowrite));
} else {
    header("HTTP/1.1 500 Server Error");
}
?>