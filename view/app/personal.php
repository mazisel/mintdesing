<?php 
/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	if ($_POST['isbasi']) {$isbasi = date('Y-m-d H:i:s',strtotime($_POST['isbasi']));}else{$isbasi =null;}
	if ($_POST['iscikis']) {$iscikis = date('Y-m-d H:i:s',strtotime($_POST['iscikis']));}else{$iscikis =null;}
	$ekle=[	
		"PersonalName"=>htmlspecialchars($_POST['name']),
		"PersonalSurname"=>htmlspecialchars($_POST['surname']),
		"PersonalUnvan"=>htmlspecialchars($_POST['unvan']),
		"PersonalBirim"=>htmlspecialchars($_POST['isbirim']),
		"PersonalGsm"=>htmlspecialchars($_POST['gsm']),
		"PersonalTel"=>htmlspecialchars($_POST['tel']),
		"Email"=>htmlspecialchars($_POST['email']),
		"UlkeID"=>htmlspecialchars($_POST['ulke']),
		"PersonalBolge"=>htmlspecialchars($_POST['bolge']),
		"CityID"=>htmlspecialchars($_POST['sehir']),
		"PersonalIlce"=>htmlspecialchars($_POST['ilce']),
		"PersonalCadde"=>htmlspecialchars($_POST['cadde']),
		"PersonalSokak"=>htmlspecialchars($_POST['sokak']),
		"PersonalBina"=>htmlspecialchars($_POST['bina']),
		"PersonalApt"=>htmlspecialchars($_POST['apt']),
		"PersonalDaireNo"=>htmlspecialchars($_POST['daireno']),
		"PersonalPostaKodu"=>htmlspecialchars($_POST['postakodu']),
		"PersonalKonum"=>htmlspecialchars($_POST['konum']),
		"PersonalAdres"=>htmlspecialchars($_POST['adres']),
		"PersonalKimlik"=>htmlspecialchars($_POST['kimlik']),
		"PersonalDesc"=>htmlspecialchars($_POST['desc']),
		"PersonalBankaAd"=>htmlspecialchars($_POST['bankaadi']),
		"PersonalBankaAdSoyad"=>htmlspecialchars($_POST['bankaadsoyad']),
		"PersonalBankaIban"=>htmlspecialchars($_POST['bankaiban']),
		"PersonelIsbasi"=>$isbasi,
		"PersonelCikis"=>$iscikis,
		"PersonelSigortano"=>htmlspecialchars($_POST['sigortano']),
		"Cinsiyet"=>htmlspecialchars($_POST['cinsiyet']),
		// "PersonelNick"=>htmlspecialchars($_POST['nick']),
		// "PersonelPass"=>htmlspecialchars($_POST['pass']),
		"PersonalDurum"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"PersonalIP"=>$IP,
		"PersonalDate"=>date('Y-m-d H:i:s')
	];
	$_FILES['PersonalImg']=$_FILES['resim'];
	$sonuc=$DNCrud->insert("personal",$ekle,[
		"UploadFile"=>
		[
			[ "file_name" => "PersonalImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/personel/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]]
);
	if($sonuc['status']){
		$PersonalID=$sonuc['LastID'];
		$PersonalCode=$PersonalID.rand(99,999);
		$DNCrud->update("personal",["PersonalID"=>$PersonalID, "PersonalCode"=>$PersonalCode ],["colomns" => "PersonalID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W79_Text53,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W79_Text54,
			'yap'=>'reset',
			'Data'=>[
				'Tablo'=>'ekle',
				'JsID' => $PersonalID,
				'code' => $PersonalCode,
				'name' => $_POST['name'],
				'surname' => $_POST['surname'],
				'durum' => $durum
			]

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W79_Text55,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W79_Text56
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	if ($_POST['isbasi']) {$isbasi = date('Y-m-d H:i:s',strtotime($_POST['isbasi']));}else{$isbasi =null;}
	if ($_POST['iscikis']) {$iscikis = date('Y-m-d H:i:s',strtotime($_POST['iscikis']));}else{$iscikis =null;}
	$editdata=[
		"PersonalID"=>htmlspecialchars($_POST['PersonalID']),
		"PersonalName"=>htmlspecialchars($_POST['name']),
		"PersonalSurname"=>htmlspecialchars($_POST['surname']),
		"PersonalUnvan"=>htmlspecialchars($_POST['unvan']),
		"PersonalBirim"=>htmlspecialchars($_POST['isbirim']),
		"PersonalGsm"=>htmlspecialchars($_POST['gsm']),
		"PersonalTel"=>htmlspecialchars($_POST['tel']),
		"Email"=>htmlspecialchars($_POST['email']),
		"UlkeID"=>htmlspecialchars($_POST['ulke']),
		"PersonalBolge"=>htmlspecialchars($_POST['bolge']),
		"CityID"=>htmlspecialchars($_POST['sehir']),
		"PersonalIlce"=>htmlspecialchars($_POST['ilce']),
		"PersonalCadde"=>htmlspecialchars($_POST['cadde']),
		"PersonalSokak"=>htmlspecialchars($_POST['sokak']),
		"PersonalBina"=>htmlspecialchars($_POST['bina']),
		"PersonalApt"=>htmlspecialchars($_POST['apt']),
		"PersonalDaireNo"=>htmlspecialchars($_POST['daireno']),
		"PersonalPostaKodu"=>htmlspecialchars($_POST['postakodu']),
		"PersonalKonum"=>htmlspecialchars($_POST['konum']),
		"PersonalAdres"=>htmlspecialchars($_POST['adres']),
		"PersonalKimlik"=>htmlspecialchars($_POST['kimlik']),
		"PersonalDesc"=>htmlspecialchars($_POST['desc']),
		"PersonalBankaAd"=>htmlspecialchars($_POST['bankaadi']),
		"PersonalBankaAdSoyad"=>htmlspecialchars($_POST['bankaadsoyad']),
		"PersonalBankaIban"=>htmlspecialchars($_POST['bankaiban']),
		"Cinsiyet"=>htmlspecialchars($_POST['cinsiyet']),
		"PersonelIsbasi"=>$isbasi,
		"PersonelCikis"=>$iscikis,
		"PersonelSigortano"=>htmlspecialchars($_POST['sigortano']),
		// "PersonelNick"=>htmlspecialchars($_POST['nick']),
		// "PersonelPass"=>htmlspecialchars($_POST['pass']),
		"PersonalDurum"=>$durum
	];
	if (isset($_FILES['resim'])) {
		$_FILES['PersonalImg']=$_FILES['resim'];
	}
	$sonuc=$DNCrud->update("personal",$editdata,[ 
		"colomns" => "PersonalID",
		"UploadFile"=>
		[
			[ "file_name" => "PersonalImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/personel/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]
]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W79_Text57,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W79_Text58,
			'Data'=>[
				'Tablo'=>'guncelle',
				'JsID' => $_POST['JsID'],
				'name' => $_POST['name'],
				'surname' => $_POST['surname'],
				'durum' => $durum
			]
			//'git'=>SITE_URL.'personal'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W79_Text59,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W79_Text60
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['personal_info'])) {
	$PersonalID=$_POST['JsID'];

	$sorgu=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"JsID"=>$DATAROW['PersonalID'],
		"name"=>$DATAROW['PersonalName'],
		"surname"=>$DATAROW['PersonalSurname'],
		"unvan"=>$DATAROW['PersonalUnvan'],
		"isbirim"=>$DATAROW['PersonalBirim'],
		"gsm"=>$DATAROW['PersonalGsm'],
		"tel"=>$DATAROW['PersonalTel'],
		"email"=>$DATAROW['Email'],
		"ulke"=>$DATAROW['UlkeID'],
		"bolge"=>$DATAROW['PersonalBolge'],
		"sehir"=>$DATAROW['CityID'],
		"ilce"=>$DATAROW['PersonalIlce'],
		"cadde"=>$DATAROW['PersonalCadde'],
		"sokak"=>$DATAROW['PersonalSokak'],
		"bina"=>$DATAROW['PersonalBina'],
		"apt"=>$DATAROW['PersonalApt'],
		"daireno"=>$DATAROW['PersonalDaireNo'],
		"postakodu"=>$DATAROW['PersonalPostaKodu'],
		"konum"=>$DATAROW['PersonalKonum'],
		"adres"=>$DATAROW['PersonalAdres'],
		"kimlik"=>$DATAROW['PersonalKimlik'],
		"desc"=>$DATAROW['PersonalDesc'],
		"bankaadi"=>$DATAROW['PersonalBankaAd'],
		"bankaadsoyad"=>$DATAROW['PersonalBankaAdSoyad'],
		"bankaiban"=>$DATAROW['PersonalBankaIban'],
		"isbasi"=>strtotime($DATAROW['PersonelIsbasi']),
		"iscikis"=>strtotime($DATAROW['PersonelCikis']),
		"sigortano"=>$DATAROW['PersonelSigortano'],
		// "nick"=>$DATAROW['PersonelNick'],
		// "pass"=>$DATAROW['PersonelPass'],
		"durum"=>$DATAROW['PersonalDurum'],
		"resim"=>$DATAROW['PersonalImg']

	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$PersonalID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("personal",$PersonalID,["colomns" => "PersonalID", "file_name" => "PersonalImg", "dir" => SitePath."images/personel/"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY PersonalID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
/* ULKE VERI CEKME VE LISTELEME */
$UlkeSorgu=$DNCrud->ReadData("ulke",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UlkeID DESC"]);
$UlkeList=$UlkeSorgu->fetchAll(PDO::FETCH_ASSOC);
/* CITY VERI CEKME VE LISTELEME */
$CitySorgu=$DNCrud->ReadData("city",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY CityID DESC"]);
$CityList=$CitySorgu->fetchAll(PDO::FETCH_ASSOC);
