<?php 
#Vergi Turu dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",93);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#Vergi Turu gel ======}
/* EKLE */
if(isset($_POST['form_add'])){
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"KateID"=>htmlspecialchars($_POST['kate']),
		"VergiName"=>htmlspecialchars($_POST['name']),
		"VergiDesc"=>htmlspecialchars($_POST['desc']),
		"VergiKod"=>htmlspecialchars($_POST['kod']),		
		"VergiDeger"=>$_POST['tutar'],
		"VergiTuru"=>$_POST['vergituru'],
		"VergiArtiEksi"=>$_POST['artieksi'],
		"Status"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"VergiIP"=>$IP,
		"VergiDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("vergi_turu",$ekle);
	if($sonuc['status']){
		$VergiID=$sonuc['LastID'];
		$VergiCode=$VergiID.rand(99,999);
		$DNCrud->update("vergi_turu",["VergiID"=>$VergiID, "VergiCode"=>$VergiCode ],["colomns" => "VergiID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W93_Text16,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W93_Text17,
			'git'=>SITE_URL.'added_type',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W93_Text18,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W93_Text19
		]; echo json_encode($result);die(); 
	}
}

/*GUNCELLEME*/
if(isset($_POST['form_edit'])){
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"VergiName"=>htmlspecialchars($_POST['name']),
		"VergiDesc"=>htmlspecialchars($_POST['desc']),
		"VergiKod"=>htmlspecialchars($_POST['kod']),
		"KateID"=>htmlspecialchars($_POST['kate']),
		"VergiDeger"=>$_POST['tutar'],
		"VergiTuru"=>$_POST['vergituru'],
		"VergiArtiEksi"=>$_POST['artieksi'],
		"Status"=>$durum,
		"VergiID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("vergi_turu",$editdata,[
		"colomns" => "VergiID"
	]);
	
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W93_Text20,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W93_Text21,
			'git'=>SITE_URL.'added_type'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W93_Text22,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W93_Text23
		]; echo json_encode($result);die(); 
	}
}

/*EDIT*/
if (isset($_POST['vergi_info'])) {
	$VergiID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND VergiID={$VergiID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['VergiID'],
		"name"=>$DATAROW['VergiName'],
		"desc"=>$DATAROW['VergiDesc'],
		"tutar"=>$DATAROW['VergiDeger'],
		"vergituru"=>$DATAROW['VergiTuru'],
		"artieksi"=>$DATAROW['VergiArtiEksi'],	
		"kod"=>$DATAROW['VergiKod'],
		"kate"=>$DATAROW['KateID'],		
		"durum"=>$DATAROW['Status']
	];
	echo json_encode($Data);die;
}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$VergiID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("vergi_turu",$VergiID,["colomns" => "VergiID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 
}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY VergiID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
/* VERGI KATE VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY KateID DESC"]);
$KateList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);

