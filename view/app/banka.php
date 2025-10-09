<?php 
#Banka dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",87);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#Banka dil gel ======}
/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"BankaTitle"=>htmlspecialchars(trim($_POST['title'])),
		"BankaName"=>htmlspecialchars(trim($_POST['name'])),
		"BankaUser"=>htmlspecialchars(trim($_POST['user'])),
		"BankaIBAN"=>htmlspecialchars(trim($_POST['iban'])),
		"BankaHesapNo"=>htmlspecialchars(trim($_POST['hesapno'])),
		"BankaParaBirimi"=>htmlspecialchars(trim($_POST['para'])),
		"BankaUlke"=>htmlspecialchars(trim($_POST['ulke'])),
		"BankaSubeKodu"=>htmlspecialchars(trim($_POST['subekod'])),
		"BankaSubeAd"=>htmlspecialchars(trim($_POST['subead'])),
		"BankaKimlik"=>htmlspecialchars(trim($_POST['kimlik'])),
		"BankaPostaKodu"=>htmlspecialchars(trim($_POST['postakodu'])),
		"BankaCity"=>htmlspecialchars(trim($_POST['city'])),
		"BankaAdres"=>htmlspecialchars(trim($_POST['adres'])),
		"BankaAdres2"=>htmlspecialchars(trim($_POST['adres2'])),
		"BankaStatus"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"BankaIP"=>$IP,
		"BankaDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("banka",$ekle);
	if($sonuc['status']){
		$BankaID=$sonuc['LastID'];
		$BankaCode=$BankaID.rand(99,999);
		$DNCrud->update("banka",["BankaID"=>$BankaID, "BankaCode"=>$BankaCode ],["colomns" => "BankaID"]);

		$where=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
		$bankaRow=$where->fetch(PDO::FETCH_ASSOC);
		$bankaRow['Tablo']='ekle';
		$result=[
			"sonuc" => 'success',
			'title' =>$W87_Text34,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W87_Text35,
			'Data'=>$bankaRow
		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W87_Text36,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W87_Text37,
			'message' => $sonuc
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_update'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"BankaTitle"=>htmlspecialchars(trim($_POST['title'])),
		"BankaName"=>htmlspecialchars(trim($_POST['name'])),
		"BankaUser"=>htmlspecialchars(trim($_POST['user'])),
		"BankaIBAN"=>htmlspecialchars(trim($_POST['iban'])),
		"BankaHesapNo"=>htmlspecialchars(trim($_POST['hesapno'])),
		"BankaParaBirimi"=>htmlspecialchars(trim($_POST['para'])),
		"BankaUlke"=>htmlspecialchars(trim($_POST['ulke'])),
		"BankaSubeKodu"=>htmlspecialchars(trim($_POST['subekod'])),
		"BankaSubeAd"=>htmlspecialchars(trim($_POST['subead'])),
		"BankaKimlik"=>htmlspecialchars(trim($_POST['kimlik'])),
		"BankaPostaKodu"=>htmlspecialchars(trim($_POST['postakodu'])),
		"BankaCity"=>htmlspecialchars(trim($_POST['city'])),
		"BankaAdres"=>htmlspecialchars(trim($_POST['adres'])),
		"BankaAdres2"=>htmlspecialchars(trim($_POST['adres2'])),
		"BankaStatus"=>$durum,	
		"BankaID"=>htmlspecialchars(trim($_POST['banka_id']))
	];
	$sonuc=$DNCrud->update("banka",$editdata,["colomns" => "BankaID"]);
	if($sonuc['status']){
		$where=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$editdata['BankaID']}"]);
		$bankaRow=$where->fetch(PDO::FETCH_ASSOC);
		$bankaRow['Tablo']='guncelle';
		$result=[
			"sonuc" => 'success',
			'title' =>$W87_Text38,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W87_Text39,
			'Data'=>$bankaRow
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W87_Text40,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W87_Text41
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['banka_info'])) {
	$BankaID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['BankaID'],
		"title"=>$DATAROW['BankaTitle'],
		"name"=>$DATAROW['BankaName'],
		"user"=>$DATAROW['BankaUser'],
		"iban"=>$DATAROW['BankaIBAN'],
		"hesapno"=>$DATAROW['BankaHesapNo'],
		"para"=>$DATAROW['BankaParaBirimi'],
		"ulke"=>$DATAROW['BankaUlke'],
		"subekod"=>$DATAROW['BankaSubeKodu'],
		"subead"=>$DATAROW['BankaSubeAd'],
		"kimlik"=>$DATAROW['BankaKimlik'],
		"postakodu"=>$DATAROW['BankaPostaKodu'],
		"city"=>$DATAROW['BankaCity'],
		"adres"=>$DATAROW['BankaAdres'],
		"adres2"=>$DATAROW['BankaAdres2'],
		"durum"=>$DATAROW['BankaStatus']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if(isset($_POST['JsDel'])){
	$BankaID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("banka",$BankaID,["colomns" => "BankaID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	}
}


/* VERI CEKME VE LISTELEME */
if (isset($_GET['id'])) {
	$BankaID=intval($_GET['id']);
	$where=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
	$bankaRow=$where->fetch(PDO::FETCH_ASSOC);
}else{
	$DataSorgu=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY BankaID DESC"]);
	$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
}