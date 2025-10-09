<?php
require("config/vendor/autoload.php"); 
$IlkDeger=memory_get_usage(); $MicroTimeStart = microtime(true);#çalişma süresi
$DirectoryPath ='config/SessionData';
$Lifetime = 72000;
ini_set("session.gc_maxlifetime", $Lifetime);
ini_set('session.save_path', $DirectoryPath);
ini_get("session.use_trans_sid");
ini_set("session.gc_divisor", "1");#eski dosyaları siler
ini_set("session.gc_probability", "1");#eski dosyaları siler
require_once ('config/url.php');
ob_start(); session_start();

$DebugMode=0;
if($DebugMode || (isset($_SESSION['Admins']) && !empty($_SESSION['Admins']) && isset($_GET['debug']))){
	error_reporting(1);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	ini_set('log_errors', 1);
	ini_set('error_log', 'error.log');
}else{
	error_reporting(0);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

// Global error/exception handlers: log details to file and show a generic 500 when not debugging
// This prevents raw PHP errors from appearing on public pages (/panel etc.)
set_exception_handler(function($e) use ($DebugMode) {
	$msg = "Uncaught Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString();
	@file_put_contents(__DIR__ . '/error.log', "[".date('c')."] " . $msg . "\n", FILE_APPEND);
	if ($DebugMode) {
		echo nl2br(htmlentities($msg));
	} else {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		echo 'Internal Server Error';
	}
	exit;
});

set_error_handler(function($severity, $message, $file, $line) {
	// Convert errors to ErrorException so exception handler will handle them
	throw new ErrorException($message, 0, $severity, $file, $line);
});

register_shutdown_function(function() use ($DebugMode) {
	$err = error_get_last();
	if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
		$msg = "Fatal error: {$err['message']} in {$err['file']} on line {$err['line']}";
		@file_put_contents(__DIR__ . '/error.log', "[".date('c')."] SHUTDOWN: " . $msg . "\n", FILE_APPEND);
		if (!$DebugMode) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			echo 'Internal Server Error';
		} else {
			echo nl2br(htmlentities($msg));
		}
	}
});



require_once('config/config.php');
require_once('config/fonksiyon.php');

define( 'BASE_URL', $SiteBase);
define( 'AdminPathUrl', $AdminBase1."/");
if($DomainName=="localhost"){ define( 'ASSETS_PATH', "http://localhost/cdn/"); }else{ define( 'ASSETS_PATH', BASE_URL."assets/"); }
define( 'AdminPath', "adminn/");
define( 'SitePath', "view/");
define( 'MobilPath', "view_mobil/");
define( 'BASE_ADMIN_PATH', BASE_URL.AdminPath);

//https://erbamarine.com/demov2/#

$DNCrud = new DnCrud;
$DNCrud->FileNameEk=null;
$UPDATE_VERSION="?v=0.0.3";
$SiteUrlPath=BASE_URL.SitePath;
$CurrencyView=1;
$WebSiteLink="http://localhost/";

$SistemVersiyon=2;
/*
1 => Genel sistem (global)
2 => Kişisel (tekil)
*/
#Genel Ayar Gel {
	$sql=$DNCrud->ReadData("genel_ayarlar"); 
    $GenelAyar=$sql->fetch(PDO::FETCH_ASSOC);
    $AllSetting=json_decode($GenelAyar['AllSetting'],true);
    $Currency=$AllSetting['Currency'];
    $DefaultLangID=$GenelAyar['DefaultLangID'];
    $sql=$DNCrud->ReadData("siteayar"); 
	$AnaSiteAyarSabit=$sql->fetch(PDO::FETCH_ASSOC);
	$sql=$DNCrud->ReadData("site_resimleri"); 
  	$SiteResimleri=$sql->fetch(PDO::FETCH_ASSOC);
#Genel Ayar Gel }
$IP=gercekip();



#Çoklu Dil url yapısı ==================== {
	$where=$db->prepare("SELECT lang_category.LangSeo, langs.LangKateID, langs.LangID, lang_category.LangKateID FROM lang_category INNER JOIN langs ON lang_category.LangKateID = langs.LangKateID WHERE langs.LangID={$DefaultLangID}");
	$where->execute([]);
	$VarsayilanDil=$where->fetch(PDO::FETCH_ASSOC);

	if(isset($_GET['url'])){	
		$Url=$_GET['url'];
		if(substr($Url , -1)!="/"){$Url."/"; }
		$EkiBul=explode("/", $Url);
		if(DilOgren("lang_category",$EkiBul[0])) {
			$where=$db->prepare("SELECT * FROM lang_category INNER JOIN langs ON lang_category.LangKateID = langs.LangKateID WHERE lang_category.LangSeo=?");
		    $where->execute([$EkiBul[0]]);
		    $DilStuns=$where->fetch(PDO::FETCH_ASSOC);
		}else{
			$Url=str_replace($EkiBul[0],$VarsayilanDil["LangSeo"],$Url);		
			header('Location: '.BASE_URL.$Url);exit;
		}
		$Url=rtrim($Url,"/");
		if(strstr($Url, "?")){
			$Url=explode("?", $Url);
			if(strstr($Url[0], "/")) {$Sef=explode("/", $Url); $Page=$Sef[1]; }else{ $Page=$Url[0]; }
		}else{
			if (strstr($Url, "/")) {$Sef=explode("/", $Url); $Page=$Sef[1]; }else{	$Page="anasayfa";	}
		}
	}else{ 
		#Dil olmadan giriş yapılmışsa ip kontrol et ve ulke kodunu bul ona yonlendir	
		$ip=gercekip();
		$CountryCode=$AllSetting['SecilenDil'];
		header('Location: '.BASE_URL.$CountryCode."/");exit;
	}
	$LangSeo=$DilStuns['LangSeo'];
	$DilLang=$DilStuns['Lang'];
	$AktifLangID=$DilStuns['LangID'];
	define( 'BASE_ADMIN', BASE_URL.$LangSeo."/".AdminPathUrl);
	define( 'SITE_URL', BASE_URL.$LangSeo."/");
#Çoklu Dil url yapısı ==================== }
$SiteUrl=SITE_URL;
$SiteDegiskenleri=$DilStuns['SiteDegiskenleri'];
$AdminDegiskenleri=$DilStuns['AdminDegiskenleri'];
include 'app/dil.php';

#Seo Url tablosunda sayfayı ara =================== {
	$sql=$DNCrud->ReadData("seo_url"); 
	while($UrlRow1=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("seo_url_lang","SeoUrlID",$UrlRow1['SeoUrlID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("seo_url_lang","SeoUrlID",$UrlRow1['SeoUrlID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("seo_url_lang","SeoUrlID",$UrlRow1['SeoUrlID']);
			}
		}
		$UrlRow1Lang=$sql1->fetch(PDO::FETCH_ASSOC);
		${$UrlRow1['UrlVeriable']}=$UrlRow1Lang['Value'];
	}
	$sql=$DNCrud->qSql("SELECT * FROM seo_url INNER JOIN seo_url_lang ON seo_url.SeoUrlID = seo_url_lang.SeoUrlID WHERE  seo_url_lang.Value='{$Page}'");
	if($sql->rowCount()){
		$UrlRow=$sql->fetch(PDO::FETCH_ASSOC);
		if($UrlRow['LangID']!=$DilStuns['LangID'] AND $UrlRow['SeoUrlID']!=1){
			$where2=$DNCrud->ReadAData("seo_url_lang","SeoUrlID",$UrlRow['SeoUrlID'],["ikincikosul"=>"AND LangID={$DilStuns['LangID']}"]);
            if($where2->rowCount()){
            	$UrlRow2=$where2->fetch(PDO::FETCH_ASSOC);
            	if ($Page!=$UrlRow2['Value']) {
            		header('Location: '.SITE_URL.$UrlRow2['Value']);exit;
            	}            	
            }
		}
    	${$UrlRow['UrlVeriable']}=$UrlRow['Value'];
	}		
#Seo Url tablosunda sayfayı ara =================== }

#Site Ayar gel {
	$sql=$DNCrud->ReadData("siteayar"); 
    $SiteAyarSabit=$sql->fetch(PDO::FETCH_ASSOC);
   	$sql1=$DNCrud->ReadAData("siteayar_lang","LangID",$AktifLangID);
    if(!$sql1->rowCount()){
    	$sql1=$DNCrud->ReadAData("siteayar_lang", "LangID",$DefaultLangID);
    	if(!$sql1->rowCount()){$sql1=$DNCrud->ReadData("siteayar_lang"); }
    }
   	$SiteAyarGel=$sql1->fetch(PDO::FETCH_ASSOC);       	
#Site Ayar gel }



if($Page==$AdminBase1){
	include 'router_admin.php';
}else{
	#Yapım Aşaması
	if($AnaSiteAyarSabit['Yapim']){ include 'yapim/index.php';die(); }
	include 'router_view.php';
}
