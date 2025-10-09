<?php Hitkaydet($PageCanonial); ?>
<!DOCTYPE html>
<html lang="<?=$Lang?>">
<head>
<!-- META TAGS -->
<meta charset="utf-8">
<base href="<?=BASE_URL?>">
  <meta name="viewport" content=
  "widivh=device-widivh, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,shrink-to-fit=no">
<link rel="shortcut icon" href="<?=BASE_URL.SitePath?>images/<?=$SiteAyarSabit['Icon']?>" type="image/x-icon">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- Social: Twitter -->  
<meta name="twitter:card" content="summary_large_image">  
<meta name="twitter:site" content="<?=$SiteAyarGel['site']?>">  
<meta name="twitter:creator" content="<?=$SiteAyarGel['creator']?>">  
<meta name="twitter:title" content="<?=$PageTitle?>">  
<meta name="twitter:description" content="<?=$PageDescription?>">  
<meta name="twitter:image:src" content="<?=$PageSocialImages?>">  
<!-- Social: Facebook / Open Graph -->  
<meta property="fb:admins" content="<?=$SiteAyarGel['admins']?>">  
<meta property="fb:app_id" content="<?=$SiteAyarGel['app_id']?>">  
<meta property="og:url" content="<?=$PageCanonial?>">  
<meta property="og:type" content="article">  
<meta property="og:title" content="<?=$PageTitle?>">  
<meta property="og:image" content="<?=$PageSocialImages?>"/>  
<meta property="og:description" content="<?=$PageDescription?>">  
<meta property="og:site_name" content="<?=$PageTitle?>">  
<meta property="article:author" content="<?=$SiteAyarGel['author']?>">  
<meta property="article:publisher" content="<?=$SiteAyarGel['publisher']?>">
<!-- apple meta tags -->
<meta name="application-name" content="<?=$PageTitle?>"/>
<meta name="apple-mobile-web-app-title" content="<?=$PageTitle?>"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="mobile-web-app-capable" content="yes"/>
<meta name="format-detection" content="telephone=yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default"/>
<link rel="apple-touch-icon" href="<?=BASE_URL.SitePath?>images/<?=$SiteAyarSabit['Icon']?>"/>  
<!-- Social: Google+ / Schema.org  -->  
<meta itemprop="name" content="<?=$PageTitle?>">  
<meta itemprop="description" content="<?=$PageDescription?>">  
<meta itemprop="image" content="<?=$PageSocialImages?>"> 
<!-- FONT -->
<!-- baslik -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<!-- yazilar -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/bootstrap.css">
 <link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/all.min.css">
<?php 
if(!isset($Sef[2]) AND !isset($Sef[3]) AND isset($UrlRow['SeoUrlID']) AND $UrlRow['SeoUrlID']){
  $where=$DNCrud->ReadData("seo_url_lang",["sql"=>"WHERE SeoUrlID={$UrlRow['SeoUrlID']}"]);
  while($row=$where->fetch(PDO::FETCH_ASSOC)){
  $key=array_search($row['LangID'], array_column($Diller, 'LangID'));
?>
<link rel="alternate" hreflang="<?=$Diller[$key]["LangSeo"]?>" href="<?=BASE_URL.$Diller[$key]["LangSeo"]?>/<?=$row['Value']?>" />  
<?php } } ?>
<!-- seo tags -->
<meta name="author" content="GBMEDIA">  
<title><?=$PageTitle?></title>
<meta name="description" content="<?=$PageDescription?>">
<meta name="keywords" content="<?=$PageKeywords?>">
<?=$HeaderMeta?>
<link rel="canonical" href="<?=$PageCanonial?>">