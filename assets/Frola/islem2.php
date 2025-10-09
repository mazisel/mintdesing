<?php 

include "SimpleImage.php";


$tmp_name=$_FILES['file']["tmp_name"];
$name=$_FILES['file']["name"];

$image= new SimpleImage();

$image->load($tmp_name);
$image->resizeToWidth(470);
$image->save($tmp_name);

$uploads_dir="img";

if (move_uploaded_file($tmp_name,"$uploads_dir/$name")) {
	$array=array(
					"name" => "$name",
					"src" 	=> "img/$name"
				);
	echo $json=json_encode($array);


} else {

	echo "hata";
}



 ?>