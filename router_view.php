<?php
$URLFirmaAccount="panel";

$URLInvoce="order_list";
$URL_Payroll="payroll_list";
$URL_Personnel="personnel_list";




$FolderPath="view/";
include 'app/site_config.php';

function PageControl($Path,$FileName) {if(is_file($Path.$FileName)){ $FileName;}else{ $FileName='404.php';} return $Path.$FileName; }

switch ($Page) {
	case $W_URLHome: include PageControl($FolderPath,'login.php');die;	 break;
	case $URLFirmaAccount: include PageControl($FolderPath,'home.php');die; 	 break;
	case "profile": include PageControl($FolderPath,'profile.php');die;  break;
	case "product": include PageControl($FolderPath,'product.php');die;  break;
	//cari
	case "customer": include PageControl($FolderPath,'cari.php');die; break;
	
	case "user": include PageControl($FolderPath,'user.php');die; break;
	// birim
	case "unit": include PageControl($FolderPath,'unit.php');die; break;
	// odeme yontemi
	case "payment": include PageControl($FolderPath,'payment_method.php');die;  break;
	// gider
	case "expense": include PageControl($FolderPath,'gider.php');die;  break;
	case "city": include PageControl($FolderPath,'city.php');die;  break;
	case "settings": include PageControl($FolderPath,'settings.php');die; break;
	//fatura
	case "order": include PageControl($FolderPath,'order.php');die;  break;
	case $URLInvoce: include PageControl($FolderPath,'order_list.php');die; break;
	case "order_taslak": include PageControl($FolderPath,'fatura_taslak.php');die; break;

	case "land": include PageControl($FolderPath,'ulke.php');die; break;	
	case "category": include PageControl($FolderPath,'category.php');die;  break;
	case "money": include PageControl($FolderPath,'money.php');die;  break;
	case "bank": include PageControl($FolderPath,'banka.php');die;  break;

	// personel gider
	case $URL_Personnel:	include PageControl($FolderPath,'personal_list.php');die;	 	break;
	case $URL_Payroll: 		include PageControl($FolderPath,'payroll_list.php');die; 		break;
	case "added": include PageControl($FolderPath,'vergi_kate.php');die;	 break;
	case "added_type":include PageControl($FolderPath,'vergi_turu.php');die;	 break;
	case "smtp_add": include PageControl($FolderPath,'smtp_ekle.php');die; 		break;
	case "smtp_taslak": include PageControl($FolderPath,'smtp_taslak.php');die;		break;

	
	case "sitemap.xml":         include 'sitemap.php';die();       			break;
}

if(is_file( SitePath . $Page . '.php' )){
	include SitePath . $Page . '.php';die();
}else{
	include SitePath.'404.php';die();
}