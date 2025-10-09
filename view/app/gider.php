<?php 
#gider dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",88);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#gider dil gel ======}

/* EKLEME */
if (isset($_POST['form_ekle'])) {
	if (isset($_POST['kdvdurum']) && $_POST['kdvdurum']==1) {$kdvdurum=1; }else{$kdvdurum=0;}
	if (isset($_POST['gelirgider']) && $_POST['gelirgider']==1) {$gelirgider=1; }else{$gelirgider=0;}
	$ekle=[
		"CariID"=>htmlspecialchars($_POST['cari']),
		"GiderTarihi"=>htmlspecialchars($_POST['date']),
		"GiderName"=>htmlspecialchars($_POST['title']),
		"GiderTutar"=>htmlspecialchars($_POST['tutar']),
		"GiderEvrak"=>htmlspecialchars($_POST['evrakadi']),
		"GiderEvrakNo"=>htmlspecialchars($_POST['evrakno']),
		"GiderDesc"=>htmlspecialchars($_POST['not']),
		"GiderKdv"=>htmlspecialchars($_POST['kdv']),
		"GiderKdvDurum"=>$kdvdurum,
		"GiderStatus"=>$gelirgider,
		"FirmaID"=>$Firma['FirmaID'],
		"GiderIP"=>$IP,
		"GiderDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("gider",$ekle);
	if($sonuc['status']){
		$GiderID =$sonuc['LastID'];
		$GiderCode=$GiderID.rand(99,999);
		$DNCrud->update("gider",["GiderID"=>$GiderID, "GiderCode"=>$GiderCode ],["colomns" => "GiderID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W88_Text36,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W88_Text37,
			'git'=>SITE_URL.'expense',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W88_Text38,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W88_Text39,
			'message_err'=>$sonuc
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['kdvdurum']) && $_POST['kdvdurum']==1) {$kdvdurum=1; }else{$kdvdurum=0;}
	if (isset($_POST['gelirgider']) && $_POST['gelirgider']==1) {$gelirgider=1; }else{$gelirgider=0;}
	$editdata=[
		"CariID"=>htmlspecialchars($_POST['cari']),
		"GiderTarihi"=>htmlspecialchars($_POST['date']),
		"GiderName"=>htmlspecialchars($_POST['title']),
		"GiderTutar"=>htmlspecialchars($_POST['tutar']),
		"GiderEvrak"=>htmlspecialchars($_POST['evrakadi']),
		"GiderEvrakNo"=>htmlspecialchars($_POST['evrakno']),
		"GiderDesc"=>htmlspecialchars($_POST['not']),
		"GiderKdv"=>htmlspecialchars($_POST['kdv']),
		"GiderKdvDurum"=>$kdvdurum,
		"GiderStatus"=>$gelirgider,
		"GiderID"=>htmlspecialchars($_POST['jsid'])
	];
	$sonuc=$DNCrud->update("gider",$editdata,[
		"colomns" => "GiderID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W88_Text40,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W88_Text41,
			'git'=>SITE_URL.'expense'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W88_Text42,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W88_Text43
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['info_gider'])) {
	$GiderID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("gider",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND GiderID={$GiderID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['GiderID'],
		"cari"=>$DATAROW['CariID'],
		"date"=>strtotime($DATAROW['GiderTarihi']),
		"title"=>$DATAROW['GiderName'],
		"tutar"=>$DATAROW['GiderTutar'],
		"evrakadi"=>$DATAROW['GiderEvrak'],
		"evrakno"=>$DATAROW['GiderEvrakNo'],
		"not"=>$DATAROW['GiderDesc'],
		"kdv"=>$DATAROW['GiderKdv'],
		"kdvdurum"=>$DATAROW['GiderKdvDurum'],
		"gelirgider"=>$DATAROW['GiderStatus']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['delete'])) {
	$GiderID=$_POST['JsID'];

	$sonuc=$DNCrud->delete("gider",$GiderID,["colomns" => "GiderID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$sorgu=$DNCrud->ReadData("gider",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY GiderID DESC"]);
$listele=$sorgu->fetchAll(PDO::FETCH_ASSOC);
/* CARI VERI CEKME VE LISTELEME */
$cariler=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY CariID DESC"]);
$carilist=$cariler->fetchAll(PDO::FETCH_ASSOC);