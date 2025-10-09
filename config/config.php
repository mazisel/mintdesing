<?php
ini_set('upload_max_filesize', '500M');
ini_set('post_max_size', '500M');
ini_set('max_input_vars', 3000);
set_time_limit(0);
require_once('db.php');

if ($pass==" ") {	$pass="";}
if ($www==1 && $ssl==0) { $ht_ww="http://www.";}
if ($www==0 && $ssl==1) { $ht_ww="https://";}
if ($www==1 && $ssl==1) { $ht_ww="https://www.";}
if ($www==0 && $ssl==0) { $ht_ww="http://";}

#==========================================={
$sub = explode ('.',$_SERVER['HTTP_HOST']);
$sub_say=count($sub);
if ($DomainName=="localhost") {$subsaysorgu=2; }else{ $subsaysorgu=3; }
if($sub_say==$subsaysorgu){ if ($sub[0]!="www" && $sub[0]!="ftp" && $sub[0]!="mail") { $subdomain = $sub[0];} }
else if($sub_say>$subsaysorgu){    if ($sub[0]!="www" && $sub[0]!="ftp" && $sub[0]!="mail") {  $subdomain = $sub[1];} }
#===========================================}
if(isset($subdomain)) {
	if ($ssl==1) { $ht_ww="https://";}else{$ht_ww="http://";}
    $SiteBase = $ht_ww.$subdomain.".".$DomainName.$SiteBase1."/";
}else{
   $SiteBase = $ht_ww.$DomainName.$SiteBase1."/";
   $AdminBase = $ht_ww.$DomainName.$SiteBase1.$AdminBase1."/"; 
}


try {
    $dbConnectionQuery = "mysql:host=".$host.";dbname=".$dbn.";charset=".$charset;
    $db = new PDO($dbConnectionQuery, $user, $pass);

    // Diğer veritabanı işlemlerinizi buraya ekleyebilirsiniz

} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();die();
    // İsterseniz loglama veya başka bir işlem yapabilirsiniz
}

/*$dbConnectionQuery = "mysql:host=".$host.";dbname=".$dbn.";charset=".$charset;
$db = new PDO($dbConnectionQuery, $user, $pass);
*/
require_once('SimpleImage.php');
require_once('class.crud.php');



?>
