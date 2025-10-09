<?php 
#personel gider dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",94);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#personel gider gel ======}

#Vergi Eklentiler HEsapla =============== {
	if (isset($_POST['verhi_hesapla'])){
		$KateID=$_POST['kate_id'];
		$Saat=$_POST['saat'];
		$Ucret=$_POST['ucret'];
		if(!$Saat){$Saat=1; }
		$ToplamUcret=$Saat*$Ucret;
		$VergiliUcret=$ToplamUcret;

		$sql=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
		$VergiKateRow=$sql->fetch(PDO::FETCH_ASSOC);

		$DataSorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
		$VergilerRow=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
		$Eklentiler=[];
		foreach($VergilerRow as $key => $value) {
			$Vergi=$VergilerRow[$key];
			if ($Vergi['Status']) {
				if ($Vergi['VergiTuru']=='yuzde'){
					//Yüzdelik
					//KDV($tutar,$oran,$status,$goster=null)
					$Vergi['Tutar']=($ToplamUcret*$Vergi['VergiDeger'])/100;
				}else{
					//Direkt sayı
					$Vergi['Tutar']=$Vergi['VergiDeger'];
				}	

				if ($Vergi['VergiArtiEksi']=='eksi'){
					$VergiliUcret=$VergiliUcret-$Vergi['Tutar'];
				}else{
					//Direkt sayı
					$VergiliUcret=$VergiliUcret+$Vergi['Tutar'];
				}
				$Eklentiler[]=[
					'VergiID' => $Vergi['VergiID'],
					'VergiKod' => $Vergi['VergiKod'],
					'VergiName' => $Vergi['VergiName'],
					'VergiDesc' => $Vergi['VergiDesc'],
					'VergiTuru' => $Vergi['VergiTuru'],
					'VergiArtiEksi' => $Vergi['VergiArtiEksi'],
					'VergiDeger' => $Vergi['VergiDeger'],
					'Tutar' => number_format($Vergi['Tutar'],2)
				];
			}
		}
		// Sayıyı 2 ondalık basamağa yuvarla
		$YuvarlanmisUcret = round($VergiliUcret,1);
		// Yuvarlama farkını hesapla
		$YuvarlamaFarki = $YuvarlanmisUcret-round($VergiliUcret,2);
		$Data=[
			'Vergiler'=>$Eklentiler,
			'ToplamUcret'=>number_format($ToplamUcret,2),
			'VergiliUcret'=>number_format($VergiliUcret,2),
			'YuvarlamaFarki'=>number_format($YuvarlamaFarki,2),
			'YuvarlanmisUcret'=>number_format($YuvarlanmisUcret,2)
		];
		echo json_encode($Data);die;
	}
#Vergi Eklentiler HEsapla =============== }

#Form kaydet =============== {
	if (isset($_POST['form_insert']) && $_POST['form_insert']=='maasbodro'){
		$KateID=$_POST['kate'];
		$Saat=$_POST['saat'];
		$Ucret=$_POST['fiyat'];
		if (!$Saat) {$Saat=1; }
		$ToplamUcret=$Saat*$Ucret;
		$VergiliUcret=$ToplamUcret;
		$EklentiUcret=0;

		#Vergileri Hesapla
			$sql=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
			$VergiKateRow=$sql->fetch(PDO::FETCH_ASSOC);

			$DataSorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
			$VergilerRow=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
			$Eklentiler=[];
			foreach($VergilerRow as $key => $value) {
				$Vergi=$VergilerRow[$key];
				if ($Vergi['Status']) {
					if ($Vergi['VergiTuru']=='yuzde'){
						//Yüzdelik
						//KDV($tutar,$oran,$status,$goster=null)
						$Vergi['Tutar']=($ToplamUcret*$Vergi['VergiDeger'])/100;
					}else{
						//Direkt sayı
						$Vergi['Tutar']=$Vergi['VergiDeger'];
					}	

					if ($Vergi['VergiArtiEksi']=='eksi'){
						$VergiliUcret=$VergiliUcret-$Vergi['Tutar'];
					}else{
						//Direkt sayı
						$VergiliUcret=$VergiliUcret+$Vergi['Tutar'];
					}
					$Eklentiler[]=[
						'VergiID' => $Vergi['VergiID'],
						'VergiKod' => $Vergi['VergiKod'],
						'VergiName' => $Vergi['VergiName'],
						'VergiDesc' => $Vergi['VergiDesc'],
						'VergiTuru' => $Vergi['VergiTuru'],
						'VergiArtiEksi' => $Vergi['VergiArtiEksi'],
						'VergiDeger' => $Vergi['VergiDeger'],
						'Tutar' => number_format($Vergi['Tutar'],2)
					];
				}
			}
			// Sayıyı 2 ondalık basamağa yuvarla
			$YuvarlanmisUcret = round($VergiliUcret,1);
			// Yuvarlama farkını hesapla
			$YuvarlamaFarki = $YuvarlanmisUcret-round($VergiliUcret,2);
			$Data=[
				'VergiEklentiler'=>json_encode($Eklentiler),
				'ToplamUcret'=>$ToplamUcret,
				'VergiliUcret'=>$VergiliUcret,
				'EklentiUcret'=>$EklentiUcret,
				'YuvarlamaFarki'=>$YuvarlamaFarki,
				'YuvarlanmisUcret'=>$YuvarlanmisUcret
			];
		#Vergileri Hesapla End


		$date1=strtotime($_POST['date1']);
		$time=date('H:i:s');
		$IsGirisTarih=date('Y-m-d',$date1);
		if (isset($_POST['date2']) && !empty($_POST['date2'])) {
			$date2=strtotime($_POST['date2']);
			$IsCikisTarih=date('Y-m-d',$date2);
		}else{
			$IsCikisTarih=date('Y-m-d',$date1);
		}

		$PersonalID=intval($_POST['personel']);
		$sql=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalID}"]);
		$personelRow=$sql->fetch(PDO::FETCH_ASSOC);

		$Data+=[
			"KateID"=>$KateID,
			"PersonalID"=>$PersonalID,
			"PersonalName"=>htmlspecialchars($_POST['name']),
			"PersonalSurname"=>htmlspecialchars($_POST['surname']),
			"Mail"=>$personelRow['Email'],
			"CalismaSaat"=>$_POST['saat'],
			"Ucret"=>$_POST['fiyat'],
			"PayTitle"=>htmlspecialchars($VergiKateRow['KateDesc']),
			"PayDesc"=>htmlspecialchars($_POST['desc']),
			"PayTarih"=>date('Y-m-d H:i:s'),
			"FirmaID"=>$Firma['FirmaID'],
			"PayIP"=>$IP,
			"PayDate"=>date('Y-m-d H:i:s'),
			"IsGirisTarih"=>$IsGirisTarih.' 00:00:00',
			"IsCikisTarih"=>$IsCikisTarih.' '.$time,
			"PesonelDetay"=>json_encode($personelRow)
		];
		
		$sonuc=$DNCrud->insert("personal_pay",$Data);
		if($sonuc['status']){
			$PayID=$sonuc['LastID'];
			$PayCode=$PayID.rand(0,9).rand(0,9);
			$DNCrud->update("personal_pay",["PayID"=>$PayID, "PayCode"=>$PayCode],["colomns" => "PayID"]);
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W94_Text31,
				'subtitle' =>"",				
				'btn'=>$W94_Text32,
				'git'=>SITE_URL.$URL_Payroll]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W94_Text33,
				'subtitle' =>"",				
				'btn'=>$W94_Text34,
				'MessageError'=>$sonuc
			]; echo json_encode($result);die(); 
		}
	}
#Form kaydet =============== }

#Form Güncelle =============== {
	if(isset($_POST['form_update']) && $_POST['form_update']=='maasbodro'){
		$KateID=$_POST['kate'];
		$Saat=$_POST['saat'];
		$Ucret=$_POST['fiyat'];
		if (!$Saat) {$Saat=1; }
		$ToplamUcret=$Saat*$Ucret;
		$VergiliUcret=$ToplamUcret;
		$EklentiUcret=0;

		#Vergileri Hesapla
			$sql=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
			$VergiKateRow=$sql->fetch(PDO::FETCH_ASSOC);

			$DataSorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
			$VergilerRow=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
			$Eklentiler=[];
			foreach($VergilerRow as $key => $value) {
				$Vergi=$VergilerRow[$key];
				if ($Vergi['Status']) {
					if ($Vergi['VergiTuru']=='yuzde'){
						//Yüzdelik
						//KDV($tutar,$oran,$status,$goster=null)
						$Vergi['Tutar']=($ToplamUcret*$Vergi['VergiDeger'])/100;
					}else{
						//Direkt sayı
						$Vergi['Tutar']=$Vergi['VergiDeger'];
					}	

					if ($Vergi['VergiArtiEksi']=='eksi'){
						$VergiliUcret=$VergiliUcret-$Vergi['Tutar'];
					}else{
						//Direkt sayı
						$VergiliUcret=$VergiliUcret+$Vergi['Tutar'];
					}
					$Eklentiler[]=[
						'VergiID' => $Vergi['VergiID'],
						'VergiKod' => $Vergi['VergiKod'],
						'VergiName' => $Vergi['VergiName'],
						'VergiDesc' => $Vergi['VergiDesc'],
						'VergiTuru' => $Vergi['VergiTuru'],
						'VergiArtiEksi' => $Vergi['VergiArtiEksi'],
						'VergiDeger' => $Vergi['VergiDeger'],
						'Tutar' => number_format($Vergi['Tutar'],2)
					];
				}
			}
			// Sayıyı 2 ondalık basamağa yuvarla
			$YuvarlanmisUcret = round($VergiliUcret,1);
			// Yuvarlama farkını hesapla
			$YuvarlamaFarki = $YuvarlanmisUcret-round($VergiliUcret,2);
			$Data=[
				'VergiEklentiler'=>json_encode($Eklentiler),
				'ToplamUcret'=>number_format($ToplamUcret,2),
				'VergiliUcret'=>number_format($VergiliUcret,2),
				'EklentiUcret'=>number_format($EklentiUcret,2),
				'YuvarlamaFarki'=>number_format($YuvarlamaFarki,2),
				'YuvarlanmisUcret'=>number_format($YuvarlanmisUcret,2)
			];
		#Vergileri Hesapla End


		$date1=strtotime($_POST['date1']);
		$time=date('H:i:s');
		$IsGirisTarih=date('Y-m-d',$date1);
		if (isset($_POST['date2']) && !empty($_POST['date2'])) {
			$date2=strtotime($_POST['date2']);
			$IsCikisTarih=date('Y-m-d',$date2);
		}else{
			$IsCikisTarih=date('Y-m-d',$date1);
		}

		$PersonalID=intval($_POST['personel']);
		$sql=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalID}"]);
		$personelRow=$sql->fetch(PDO::FETCH_ASSOC);

		$Data+=[
			"PayID"=>intval($_POST['PayID']),
			"KateID"=>$KateID,
			"PersonalID"=>$PersonalID,
			"PersonalName"=>htmlspecialchars($_POST['name']),
			"PersonalSurname"=>htmlspecialchars($_POST['surname']),
			"Mail"=>$personelRow['Email'],
			"CalismaSaat"=>$_POST['saat'],
			"Ucret"=>$_POST['fiyat'],
			"PayTitle"=>htmlspecialchars($VergiKateRow['KateName']),
			"PayDesc"=>htmlspecialchars($_POST['desc']),
			"PayTarih"=>date('Y-m-d H:i:s'),
			"FirmaID"=>$Firma['FirmaID'],
			"PayIP"=>$IP,
			"PayDate"=>date('Y-m-d H:i:s'),
			"IsGirisTarih"=>$IsGirisTarih.' 00:00:00',
			"IsCikisTarih"=>$IsCikisTarih.' '.$time,
			"PesonelDetay"=>json_encode($personelRow)
		];
		
		$sonuc=$DNCrud->update("personal_pay",$Data,["colomns" => "PayID"]);
		if($sonuc['status']){
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W94_Text35,
				'subtitle' =>"",				
				'btn'=>$W94_Text32,
				'git'=>SITE_URL.$URL_Payroll]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W94_Text37,
				'subtitle' =>"",				
				'btn'=>$W94_Text32,
				'MessageError'=>$sonuc
			]; echo json_encode($result);die(); 
		}
 
	}
#Form Güncelle =============== }

#Personel info
if (isset($_POST['pay_info'])) {
	$PayID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("personal_pay",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PayID={$PayID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['PayID'],
		"personel"=>$DATAROW['PersonalID'],
		"name"=>$DATAROW['PersonalName'],
		"surname"=>$DATAROW['PersonalSurname'],
		"saat"=>$DATAROW['CalismaSaat'],
		"fiyat"=>$DATAROW['Ucret'],
		"hesapla"=>$DATAROW['ToplamUcret'],
		"title"=>$DATAROW['PayTitle'],
		"desc"=>$DATAROW['PayDesc'],
		"date"=>strtotime($DATAROW['PayTarih'])
		//"durum"=>$DATAROW['PayDurum']
	];
	echo json_encode($Data);die;
}

/*personel Info gel*/
if (isset($_POST['perso_info'])) {
	$PersonalID=$_POST['persoIDjs'];
	$sorgu=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	echo json_encode($DATAROW);die;
}


/*DELETE*/
if (isset($_POST['delete']) && $_POST['delete']=='payroll') {
	$PayID=$_POST['ID'];
	$sonuc=$DNCrud->delete("personal_pay",$PayID,["colomns" => "PayID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	}
}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("personal_pay",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY PayID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
/* PERSONEL VERI CEKME VE LISTELEME */
$sorgula=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY PersonalID DESC"]);
$PersoList=$sorgula->fetchAll(PDO::FETCH_ASSOC);
/* VERGI KATE */
$DataSorgu=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY KateID DESC"]);
$KateList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
/* VERGI TURU */
$DataSorgu=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY VergiID DESC"]);
$VergiTuruList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);

