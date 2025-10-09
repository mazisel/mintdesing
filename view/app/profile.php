<?php 
#profil dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",90);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#profil dil gel ======}

/* GUNCELLE */
if (isset($_POST['profil_guncelle'])) {
	$FixedData=[
		"FirmaAd"=>htmlspecialchars($_POST['unvan']),	
		"FirmaYetkili"=>htmlspecialchars($_POST['yetkili']),	
		"FirmaWeb"=>htmlspecialchars($_POST['website']),	
		"FirmaTel"=>htmlspecialchars($_POST['tel']),	
		"FirmaTel2"=>htmlspecialchars($_POST['tel2']),	
		"FirmaGsm"=>htmlspecialchars($_POST['gsm']),	
		"FirmaWp"=>htmlspecialchars($_POST['wp']),	
		"FirmaSehir"=>htmlspecialchars($_POST['il']),	
		"FirmaIlce"=>htmlspecialchars($_POST['ilce']),	
		"FirmaVergiDairesi"=>htmlspecialchars($_POST['vdairesi']),	
		"FirmaVergiNo"=>htmlspecialchars($_POST['vno']),	
		"FirmaEmail"=>htmlspecialchars($_POST['email']),	
		"FirmaAdres"=>htmlspecialchars($_POST['adres']),	
		"FirmaTitle"=>htmlspecialchars($_POST['ftitle']),	
		"FirmaDesc"=>htmlspecialchars($_POST['fdesc']),	
		"FirmaKeyw"=>htmlspecialchars($_POST['fkeyw']),	
		"FirmaHakkinda"=>htmlspecialchars($_POST['hakkinda']),	
		"FirmaID"=>$Firma['FirmaID']
	];

	$sonuc=$DNCrud->update("firmalar",$FixedData,[
		"colomns" => "FirmaID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W90_Text20,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W90_Text21
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W90_Text22,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W90_Text23
		]; echo json_encode($result);die(); 
	} 

}