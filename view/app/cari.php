<?php
#Cari dil======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",78);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#Cari gel ======}

#EKLE Start
	if(isset($_POST['form_add'])) {
		if (isset($_POST['musteri']) && $_POST['musteri']==1) {$musteri=1; }else{$musteri=0;}
		if (isset($_POST['tedarikci']) && $_POST['tedarikci']==1) {$tedarikci=1; }else{$tedarikci=0;}
		if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
		$ekle=[
			"CariUnvan"=>htmlspecialchars(trim($_POST['unvan'])),
			"CariName"=>htmlspecialchars(trim($_POST['name'])),
			"CariSurname"=>htmlspecialchars(trim($_POST['surname'])),
			"CariGsm"=>htmlspecialchars(trim($_POST['gsm'])),
			"CariTel"=>htmlspecialchars(trim($_POST['tel'])),
			"CariEmail"=>htmlspecialchars(trim($_POST['email'])),
			"UlkeID"=>htmlspecialchars(trim($_POST['ulke'])),
			"CariBolge"=>htmlspecialchars(trim($_POST['bolge'])),
			"CariCity"=>htmlspecialchars(trim($_POST['sehir'])),
			"CariIlce"=>htmlspecialchars(trim($_POST['ilce'])),
			"CariCadde"=>htmlspecialchars(trim($_POST['cadde'])),
			"CariSokak"=>htmlspecialchars(trim($_POST['sokak'])),
			"CariBina"=>htmlspecialchars(trim($_POST['bina'])),
			"CariApt"=>htmlspecialchars(trim($_POST['apt'])),
			"CariDaireno"=>htmlspecialchars(trim($_POST['daireno'])),
			"CariPostakodu"=>htmlspecialchars(trim($_POST['postakodu'])),
			"CariKonum"=>htmlspecialchars(trim($_POST['konum'])),
			"CariAdres"=>htmlspecialchars(trim($_POST['adres'])),
			"CariAdres2"=>htmlspecialchars(trim($_POST['adres2'])),
			"CariKimlik"=>htmlspecialchars(trim($_POST['kimlik'])),
			"CariVergiDairesi"=>htmlspecialchars(trim($_POST['vergidairesi'])),
			"CariVergiNo"=>htmlspecialchars(trim($_POST['vergino'])),
			"CariDesc"=>htmlspecialchars(trim($_POST['desc'])),
			"CariBankaAd"=>htmlspecialchars(trim($_POST['bankaadi'])),
			"CariBankaAdSoyad"=>htmlspecialchars(trim($_POST['bankaadsoyad'])),
			"CariBankaIban"=>htmlspecialchars(trim($_POST['bankaiban'])),
			"CariMusteri"=>$musteri,
			"CariTedarikci"=>$tedarikci,
			"CariDurum"=>$durum,
			"FirmaID"=>$Firma['FirmaID'],
			"CariIP"=>$IP,
			"CariDate"=>date('Y-m-d H:i:s')
		];
		$_FILES['CariLogo']=$_FILES['resim'];
		$sonuc=$DNCrud->insert("cari",$ekle,[
			"UploadFile"=>
			[
				[ "file_name" => "CariLogo", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/cari/", 
				"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
				"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
				]
			]
		]);
		if($sonuc['status']){
			$CariID=$sonuc['LastID'];
			$CariCode=$CariID.rand(0,9).rand(0,9);
			$DNCrud->update("cari",["CariID"=>$CariID, "CariCode"=>$CariCode ],["colomns" => "CariID"]);

			$where=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
			$cariRow=$where->fetch(PDO::FETCH_ASSOC);
			$cariRow['Tablo']='ekle';
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W78_Text53,
				'subtitle' =>"",				
				'btn'=>$W78_Text54,
				'Data'=>$cariRow
			]; echo json_encode($result);die();

		}else{
			$result=[
				"sonuc" => 'error',
				'title' =>$W78_Text55,
				'subtitle' =>"",
				'icon' => 'warning',
				'btn'=>$W78_Text56
			]; echo json_encode($result);die(); 
		}
	}
#EKLE End

#GUNCELLEME Start
	if (isset($_POST['form_update'])) {
		if (isset($_POST['musteri']) && $_POST['musteri']==1) {$musteri=1; }else{$musteri=0;}
		if (isset($_POST['tedarikci']) && $_POST['tedarikci']==1) {$tedarikci=1; }else{$tedarikci=0;}
		if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
		$editdata=[
			"CariID"=>htmlspecialchars(trim($_POST['cari_id'])),
			"CariUnvan"=>htmlspecialchars(trim($_POST['unvan'])),
			"CariName"=>htmlspecialchars(trim($_POST['name'])),
			"CariSurname"=>htmlspecialchars(trim($_POST['surname'])),
			"CariGsm"=>htmlspecialchars(trim($_POST['gsm'])),
			"CariTel"=>htmlspecialchars(trim($_POST['tel'])),
			"CariEmail"=>htmlspecialchars(trim($_POST['email'])),
			"UlkeID"=>htmlspecialchars(trim($_POST['ulke'])),
			"CariBolge"=>htmlspecialchars(trim($_POST['bolge'])),
			"CariCity"=>htmlspecialchars(trim($_POST['sehir'])),
			"CariIlce"=>htmlspecialchars(trim($_POST['ilce'])),
			"CariCadde"=>htmlspecialchars(trim($_POST['cadde'])),
			"CariSokak"=>htmlspecialchars(trim($_POST['sokak'])),
			"CariBina"=>htmlspecialchars(trim($_POST['bina'])),
			"CariApt"=>htmlspecialchars(trim($_POST['apt'])),
			"CariDaireno"=>htmlspecialchars(trim($_POST['daireno'])),
			"CariPostakodu"=>htmlspecialchars(trim($_POST['postakodu'])),
			"CariKonum"=>htmlspecialchars(trim($_POST['konum'])),
			"CariAdres"=>htmlspecialchars(trim($_POST['adres'])),
			"CariAdres2"=>htmlspecialchars(trim($_POST['adres2'])),
			"CariKimlik"=>htmlspecialchars(trim($_POST['kimlik'])),
			"CariVergiDairesi"=>htmlspecialchars(trim($_POST['vergidairesi'])),
			"CariVergiNo"=>htmlspecialchars(trim($_POST['vergino'])),
			"CariDesc"=>htmlspecialchars(trim($_POST['desc'])),
			"CariBankaAd"=>htmlspecialchars(trim($_POST['bankaadi'])),
			"CariBankaAdSoyad"=>htmlspecialchars(trim($_POST['bankaadsoyad'])),
			"CariBankaIban"=>htmlspecialchars(trim($_POST['bankaiban'])),
			"CariMusteri"=>$musteri,
			"CariTedarikci"=>$tedarikci,
			"CariDurum"=>$durum
		];
		if(isset($_FILES['resim'])) {
			$_FILES['CariLogo']=$_FILES['resim'];
		}
		$sonuc=$DNCrud->update("cari",$editdata,[ 
			"colomns" => "CariID",
			"UploadFile"=>
			[
				[ "file_name" => "CariLogo", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/cari/", 
					"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
					"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
				]
			]
		]);
		if($sonuc['status']){
			$where=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$editdata['CariID']}"]);
			$cariRow=$where->fetch(PDO::FETCH_ASSOC);
			$cariRow['Tablo']='guncelle';
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W78_Text57,
				'subtitle' =>"",				
				'btn'=>$W78_Text58,
				'Data'=>$cariRow
			]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W78_Text59,
				'subtitle' =>"",				
				'btn'=>$W78_Text60
			]; echo json_encode($result);die(); 
		}
	}
#GUNCELLEME End

#Cari Info Start
	if(isset($_POST['cari_info'])) {
		$CariID=$_POST['JsID'];
		$sorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
		$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
		$Data=[
			"JsID"=>$DATAROW['CariID'],
			"unvan"=>$DATAROW['CariUnvan'],
			"name"=>$DATAROW['CariName'],
			"surname"=>$DATAROW['CariSurname'],
			"gsm"=>$DATAROW['CariGsm'],
			"tel"=>$DATAROW['CariTel'],
			"email"=>$DATAROW['CariEmail'],
			"ulke"=>$DATAROW['UlkeID'],
			"bolge"=>$DATAROW['CariBolge'],
			"sehir"=>$DATAROW['CariCity'],
			"ilce"=>$DATAROW['CariIlce'],
			"cadde"=>$DATAROW['CariCadde'],
			"sokak"=>$DATAROW['CariSokak'],
			"bina"=>$DATAROW['CariBina'],
			"apt"=>$DATAROW['CariApt'],
			"daireno"=>$DATAROW['CariDaireno'],
			"postakodu"=>$DATAROW['CariPostakodu'],
			"konum"=>$DATAROW['CariKonum'],
			"adres"=>$DATAROW['CariAdres'],
			"adres2"=>$DATAROW['CariAdres2'],
			"kimlik"=>$DATAROW['CariKimlik'],
			"vergidairesi"=>$DATAROW['CariVergiDairesi'],
			"vergino"=>$DATAROW['CariVergiNo'],
			"desc"=>$DATAROW['CariDesc'],
			"bankaadi"=>$DATAROW['CariBankaAd'],
			"bankaadsoyad"=>$DATAROW['CariBankaAdSoyad'],
			"bankaiban"=>$DATAROW['CariBankaIban'],
			"durum"=>$DATAROW['CariDurum'],
			"musteri"=>$DATAROW['CariMusteri'],
			"tedarikci"=>$DATAROW['CariTedarikci']	,
			"resim"=>$DATAROW['CariLogo']

		];
		echo json_encode($Data);die;
	}
#Cari Info end

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$CariID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("cari",$CariID,["colomns" => "CariID", "file_name" => "CariLogo", "dir" => SitePath."images/cari/"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	}
}


/* VERI CEKME VE LISTELEME */
if (isset($_GET['id'])) {
	$CariID=intval($_GET['id']);
	$DataSorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
	$cariRow=$DataSorgu->fetch(PDO::FETCH_ASSOC);
}else{
	$DataSorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY CariID DESC"]);
	$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
}
/* ULKE VERI CEKME VE LISTELEME */
$UlkeSorgu=$DNCrud->ReadData("ulke",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UlkeID DESC"]);
$UlkeList=$UlkeSorgu->fetchAll(PDO::FETCH_ASSOC);
/* CITY VERI CEKME VE LISTELEME */
$CitySorgu=$DNCrud->ReadData("city",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY CityID DESC"]);
$CityList=$CitySorgu->fetchAll(PDO::FETCH_ASSOC);
