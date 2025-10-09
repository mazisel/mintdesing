<?php 
#SMTP dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",95);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#SMTP dil gel ======}
/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"SmtpGondericiAd"=>htmlspecialchars($_POST['gondericiadi']),
		"SmtpSunucu"=>htmlspecialchars($_POST['sunucu']),
		"SmtpEmail"=>htmlspecialchars($_POST['email']),
		"SmtpPass"=>htmlspecialchars($_POST['pass']),
		"SmtpProt"=>htmlspecialchars($_POST['port']),
		"SmtpAlicilar"=>htmlspecialchars($_POST['alicilar']),
		"Status"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"SmtpIP"=>$IP,
		"SmtpDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("firma_smtp",$ekle);
	if($sonuc['status']){
		$SmtpID=$sonuc['LastID'];
		$SmtpCode=$SmtpID.rand(99,999);
		$DNCrud->update("firma_smtp",["SmtpID"=>$SmtpID, "SmtpCode"=>$SmtpCode ],["colomns" => "SmtpID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W95_Text17,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W95_Text18,
			'git'=>SITE_URL.'smtp_add',

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W95_Text19,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W95_Text20,
			'message' => $sonuc
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"SmtpGondericiAd"=>htmlspecialchars($_POST['gondericiadi']),
		"SmtpSunucu"=>htmlspecialchars($_POST['sunucu']),
		"SmtpEmail"=>htmlspecialchars($_POST['email']),
		"SmtpPass"=>htmlspecialchars($_POST['pass']),
		"SmtpProt"=>htmlspecialchars($_POST['port']),
		"SmtpAlicilar"=>htmlspecialchars($_POST['alicilar']),
		"Status"=>$durum,	
		"SmtpID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("firma_smtp",$editdata,[
		"colomns" => "SmtpID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W95_Text21,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W95_Text22,
			'git'=>SITE_URL.'smtp_add'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W95_Text23,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W95_Text24
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['smtp_info'])) {
	$SmtpID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("firma_smtp",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND SmtpID={$SmtpID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['SmtpID'],
		"gondericiadi"=>$DATAROW['SmtpGondericiAd'],
		"sunucu"=>$DATAROW['SmtpSunucu'],
		"email"=>$DATAROW['SmtpEmail'],
		"pass"=>$DATAROW['SmtpPass'],
		"port"=>$DATAROW['SmtpProt'],
		"durum"=>$DATAROW['Status'],
		"alicilar"=>$DATAROW['SmtpAlicilar']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$SmtpID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("firma_smtp",$SmtpID,["colomns" => "SmtpID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("firma_smtp",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY SmtpID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
