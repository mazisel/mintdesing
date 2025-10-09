<?php 


#Fatura oluştur Start
	if(isset($_POST['oder_insert'])) {
		if (!isset($_POST['date1']) OR empty($_POST['date1'])) {
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>"Lütfen fatura tarihi seçiniz",
				'subtitle' =>"",				
				'btn'=>$W97_Text39,
				'message_err'=>"tarih boş"
			]; echo json_encode($result);die(); 
		}
	
	
		#Sipariş ürünlerini kontrol et =================== {
			$BASKET=json_decode($_POST['BASKET'],true);
			if($BASKET === null && json_last_error() !== JSON_ERROR_NONE){
				$result=[
					"sonuc" => 'error','icon' => 'warning',
					'title' =>$W97_Text33,
					'subtitle' =>$W97_Text34,				
					'btn'=>$W97_Text35,
					'message_err'=>$sonuc
				]; echo json_encode($result);die(); 
			}	
			foreach ($BASKET as $key => $value) {
				if($BASKET[$key]['ID'] && $BASKET[$key]['Name'] && $BASKET[$key]['Fiyat'] && $BASKET[$key]['Miktar'] && $BASKET[$key]['Toplam']){
					$BASKET[$key]['ID']=htmlentities($BASKET[$key]['ID']);
					$BASKET[$key]['Name']=htmlentities($BASKET[$key]['Name']);
					$BASKET[$key]['Fiyat']=htmlentities($BASKET[$key]['Fiyat']);
					$BASKET[$key]['Miktar']=htmlentities($BASKET[$key]['Miktar']);
					$BASKET[$key]['Toplam']=htmlentities($BASKET[$key]['Toplam']);
				}else{
					$result=[
						"sonuc" => 'error','icon' => 'warning',
						'title' =>$W97_Text33,
						'subtitle' =>$W97_Text34,				
						'btn'=>$W97_Text35,					
						'message_err'=>$sonuc
					]; echo json_encode($result);die();
				}
			}
			$s_urunler=json_encode($BASKET);
		#Sipariş ürünlerini kontrol et =================== }

		#Cari gel
		$CariID=intval($_POST['cari']);
		$where=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
		$cariRow=$where->fetch(PDO::FETCH_ASSOC);
		if(empty($cariRow['CariName'])){
			$CariName=$cariRow['CariName'].' '.$cariRow['CariSurname'];
		}else{$CariName=$cariRow['CariUnvan']; }
		#Banka gel
		$BankaID=intval($_POST['banka']);
		$where=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
		$bankaRow=$where->fetch(PDO::FETCH_ASSOC);

		
		$date1=strtotime($_POST['date1']);
		$OrderDate=date('Y-m-d',$date1);
		$OrderUnix=$date1;
		if (isset($_POST['date2']) && !empty($_POST['date2'])) {
			$date2=strtotime($_POST['date2']);
			$OrderDateEnd=date('Y-m-d',$date2);
			$OrderDateEndUnix=$date2;
		}else{
			$OrderDateEnd=date('Y-m-d',$date1);
			$OrderDateEndUnix=$date1;
		}

		$Data=[
			"FirmaID"=>$Firma['FirmaID'],
			"FirmaDetay"=>0,
			"OrderKayitTarihi"=>date("Y-m-d H:i:s"),
			"OrderIP"=>$IP,
			"CariID"=>$CariID,
			"CariCode"=>$cariRow['CariCode'],
			"CariDetay"=>json_encode($cariRow),
			"CariTel"=>$cariRow['CariTel'],
			"CariEmail"=>$cariRow['CariEmail'],
			"CariPostaKodu"=>$cariRow['CariPostakodu'],
			"CariName"=>$CariName,
			"BankaID"=>$BankaID,
			"BankaDetay"=>json_encode($bankaRow),
			"OrderUrun"=>$s_urunler,
			"Tutar"=>$_POST['GenelToplam'],
			"IndirimTuru"=>0,
			"IndirimOran"=>0,
			"IndirimTutar"=>0,
			"NetTutar"=>$_POST['NetToplam'],
			"KdvTutar"=>$_POST['KDVToplam'],
			"ToplamTutar"=>$_POST['GenelToplam'],
			"OrderNot"=>htmlspecialchars($_POST['order_not']),
			"OrderHazirlayanAdi"=>0,
			"OrderDate"=>$OrderDate,
			"OrderUnix"=>$OrderUnix,
			"OrderDateEnd"=>$OrderDateEnd,
			"OrderDateEndUnix"=>$OrderDateEndUnix,
			"Status"=>intval($_POST['status'])
		];
		$sonuc=$DNCrud->insert("siparisler",$Data);
		if($sonuc['status']){
			$OrderID =$sonuc['LastID'];
			$OrderCode=$OrderID.rand(99,999);
			$DNCrud->update("siparisler",["OrderID"=>$OrderID, "OrderCode"=>$OrderCode ],["colomns" => "OrderID"]);
				//Mail gönder
			$result=[
				"sonuc" => 'success',
				'title' =>$W97_Text36,
				'subtitle' =>"",
				'icon' => 'success',
				'btn'=>$W97_Text37,
				'git'=>SITE_URL.'order_list'
			]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error',
				'title' =>$W97_Text38,
				'subtitle' =>"",
				'icon' => 'warning',
				'btn'=>$W97_Text39,
				'message_err'=>$sonuc
			]; echo json_encode($result);die(); 
		}
	}
#Fatura oluştur End
#Fatura UPDATE Start
	if(isset($_POST['oder_update'])) {
		#Sipariş ürünlerini kontrol et =================== {
			$BASKET=json_decode($_POST['BASKET'],true);
			if($BASKET === null && json_last_error() !== JSON_ERROR_NONE){
				$result=[
					"sonuc" => 'error',
					'title' =>$W97_Text40,
					'subtitle' =>$W97_Text41,
					'icon' => 'warning',
					'btn'=>$W97_Text42,
					'message_err'=>$sonuc
				]; echo json_encode($result);die(); 
			}	
			foreach ($BASKET as $key => $value) {
				if($BASKET[$key]['ID'] && $BASKET[$key]['Name'] && $BASKET[$key]['Fiyat'] && $BASKET[$key]['Miktar'] && $BASKET[$key]['Toplam']){
					$BASKET[$key]['ID']=htmlentities($BASKET[$key]['ID']);
					$BASKET[$key]['Name']=htmlentities($BASKET[$key]['Name']);
					$BASKET[$key]['Fiyat']=htmlentities($BASKET[$key]['Fiyat']);
					$BASKET[$key]['Miktar']=htmlentities($BASKET[$key]['Miktar']);
					$BASKET[$key]['Toplam']=htmlentities($BASKET[$key]['Toplam']);
				}else{
					$result=["sonuc" => 'error', 'title' =>$W97_Text40, 'subtitle' =>$W97_Text41, 'icon' => 'warning', 'btn'=>$W97_Text42, 'message_err'=>$sonuc ]; echo json_encode($result);die();
				}
			}
			$s_urunler=json_encode($BASKET);
		#Sipariş ürünlerini kontrol et =================== }
		#Cari gel
			$CariID=intval($_POST['cari']);
			$where=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
			$cariRow=$where->fetch(PDO::FETCH_ASSOC);
			if(empty($cariRow['CariUnvan'])){
				$CariName=$cariRow['CariName'].' '.$cariRow['CariSurname'];
			}else{ $CariName=$cariRow['CariUnvan']; }
		#Banka gel
		$BankaID=intval($_POST['banka']);
		$where=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
		$bankaRow=$where->fetch(PDO::FETCH_ASSOC);

		$date1=strtotime($_POST['date1']);
		$OrderDate=date('Y-m-d',$date1);
		$OrderUnix=$date1;
		if (isset($_POST['date2']) && !empty($_POST['date2'])) {
			$date2=strtotime($_POST['date2']);
			$OrderDateEnd=date('Y-m-d',$date2);
			$OrderDateEndUnix=$date2;
		}else{
			$OrderDateEnd=date('Y-m-d',$date1);
			$OrderDateEndUnix=$date1;
		}

		$Data=[
			"OrderID"=>$_POST['id'],
			"FirmaID"=>$Firma['FirmaID'],
			"FirmaDetay"=>0,
			"OrderKayitTarihi"=>date("Y-m-d H:i:s"),
			"OrderIP"=>$IP,
			"CariID"=>$CariID,
			"CariCode"=>$cariRow['CariCode'],
			"CariDetay"=>json_encode($cariRow),
			"CariTel"=>$cariRow['CariTel'],
			"CariEmail"=>$cariRow['CariEmail'],
			"CariPostaKodu"=>$cariRow['CariPostakodu'],
			"CariName"=>$CariName,
			"BankaID"=>$BankaID,
			"BankaDetay"=>json_encode($bankaRow),
			"OrderUrun"=>$s_urunler,
			"Tutar"=>$_POST['GenelToplam'],
			"IndirimTuru"=>0,
			"IndirimOran"=>0,
			"IndirimTutar"=>0,
			"NetTutar"=>$_POST['NetToplam'],
			"KdvTutar"=>$_POST['KDVToplam'],
			"ToplamTutar"=>$_POST['GenelToplam'],
			"OrderNot"=>htmlspecialchars($_POST['order_not']),
			"OrderHazirlayanAdi"=>0,
			"OrderDate"=>$OrderDate,
			"OrderUnix"=>$OrderUnix,
			"OrderDateEnd"=>$OrderDateEnd,
			"OrderDateEndUnix"=>$OrderDateEndUnix,
			"Status"=>intval($_POST['status'])
		];
		$sonuc=$DNCrud->update("siparisler",$Data,["colomns" => "OrderID"]);
		if($sonuc['status']){
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W97_Text43,
				'subtitle' =>"",				
				'btn'=>$W97_Text44,
				'git'=>SITE_URL.'order_list'
			]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W97_Text45,
				'subtitle' =>"",				
				'btn'=>$W97_Text46,
				'message_err'=>$sonuc
			]; echo json_encode($result);die(); 
		}
	}
#Fatura UPDATE End

#CARI Info
if(isset($_POST['cari_info'])) {
	$CariID=$_POST['jsid'];
	$sorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$CariID}"]);
	$dataRow=$sorgu->fetch(PDO::FETCH_ASSOC);	
	echo json_encode($dataRow);die;
}
#BANKA INFO
if(isset($_POST['banka_info'])) {
	$BankaID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$BankaID}"]);
	$dataRow=$sorgu->fetch(PDO::FETCH_ASSOC);
	
	echo json_encode($dataRow);die;
}
#URUN Info
if(isset($_POST['urun_info'])) {
	$ProductID=$_POST['jsid'];
	$sorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ProductID={$ProductID}"]);
	$dataRow=$sorgu->fetch(PDO::FETCH_ASSOC);
	$dataRow['result']="success";
	$dataRow['ProductName']=htmlspecialchars_decode($dataRow['ProductName']);
	echo json_encode($dataRow);die;
}
#DELETE
if(isset($_POST['delete'])){
	$OrderID=$_POST['ID'];
	$sonuc=$DNCrud->delete("siparisler",$OrderID,["colomns" => "OrderID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	}
}


/* CARI VERI CEKME VE LISTELEME */
$Cariler=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariDurum=1 ORDER BY CariID DESC"]);
$CariList=$Cariler->fetchAll(PDO::FETCH_ASSOC);
/* BANKA VERI CEKME VE LISTELEME */
$Bankalar=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY BankaID DESC"]);
$BankaList=$Bankalar->fetchAll(PDO::FETCH_ASSOC);
/* URUN VERI CEKME VE LISTELEME */
$Urunler=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY ProductID DESC"]);
$ProductList=$Urunler->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['id'])){
	// Preserve raw id (may contain non-numeric chars) and build a safe SQL clause
	$OrderCodeRaw = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
	if ($OrderCodeRaw === '') {
		// Invalid request
		header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
		echo 'Bad Request';
		exit;
	}
	// Escape single quotes for safe inline usage (better: parameterize queries, but keep minimal change)
	$OrderCodeEscaped = str_replace("'", "\\'", $OrderCodeRaw);
	$Where=$DNCrud->ReadData("siparisler",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND OrderCode='{$OrderCodeEscaped}'"]);
	$OrderRow=$Where->fetch(PDO::FETCH_ASSOC);
	$OrderUrun=json_decode($OrderRow['OrderUrun'],true);
	//echo "<pre>"; print_r($OrderUrun);die;
}else{
	/* URUN VERI CEKME VE LISTELEME */
	switch ($filtre) {
		case 'today':
			$todayStart=strtotime(date('d.m.Y'));
			$todayEnd=strtotime(date('d.m.Y 23:59:59'));
			$sqlWhere=" AND (OrderUnix>={$todayStart} AND OrderUnix<={$todayEnd})";
		break;

		case 'week':
			$Hafta=haftatespit();
	    	$HaftaStart=$Hafta[0];
	    	$HaftaEnd=$Hafta[1];
			$HaftaStartUnix=strtotime($HaftaStart.' 00:00:00');
	      	$HaftaEndUnix=strtotime($HaftaEnd.' 23:59:59');
	      	$sqlWhere=" AND (OrderUnix>={$HaftaStartUnix} AND OrderUnix<={$HaftaEndUnix}) ";
		break;
		case 'month':
			$todayStart=strtotime(date('Y-m-01'));
			$todayEnd=strtotime(date('Y-m-t 23:59:59'));
			$sqlWhere=" AND (OrderUnix>={$todayStart} AND OrderUnix<={$todayEnd}) ";
		break;

		case 'offen':
			#Açık olan & bekleyen faturalar
			$sqlWhere=" AND Status=2";
		break;

		case 'erledigt':
			#Tamamlanmış ve iptal edilmiş faturalar
			$sqlWhere=" AND (Status=1 OR Status=6)";
		break;

		case 'filter':
			$sqlWhere="";$tarihler='var';
			if (isset($_GET['date1']) && !empty($_GET['date1']) && isset($_GET['date2']) && !empty($_GET['date2'])) {
				$StartDateUnix=strtotime($_GET['date1']);
				$EndDateUnix=strtotime($_GET['date2'].' 23:59:59');
				$sqlWhere=" AND (OrderUnix>={$StartDateUnix} AND OrderUnix<={$EndDateUnix}) ";
			}elseif((isset($_GET['date1']) && !empty($_GET['date1'])) || (isset($_GET['date2']) && !empty($_GET['date2']))){			
				if (isset($_GET['date1']) && !empty($_GET['date1'])) {
					$GelenDate=$_GET['date1'];
				}else{
					$GelenDate=$_GET['date2'];
				}
				$Today=date('d.m.Y');
				if (strtotime($GelenDate)>strtotime($Today)) { #filitreden gelen tarih şuadndan büyük sie end tarihtir
					$EndDateUnix=strtotime($GelenDate.' 23:59:59');
					$StartDateUnix=strtotime($Today);
				}else{
					$EndDateUnix=strtotime($Today.' 23:59:59');
					$StartDateUnix=strtotime($GelenDate);
				}
				$sqlWhere=" AND (OrderUnix>={$StartDateUnix} AND OrderUnix<={$EndDateUnix}) ";
			}else{
				$tarihler='yok';
			}
			//Sadece cari
			if (isset($_GET['cari']) && !empty($_GET['cari'])) {
				$CariCode=intval($_GET['cari']);
				$Carisql=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariCode={$CariCode}"]);
				if($Carisql->rowCount()){
					$FlitreCariRow=$Carisql->fetch(PDO::FETCH_ASSOC);
				}

				$sqlWhere.=" AND CariCode={$CariCode}";
			}
		break;
		default:
			#Açık olan & bekleyen faturalar
			$sqlWhere=" AND Status=2";
		break;
	}
	$Where=$DNCrud->ReadData("siparisler",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} {$sqlWhere} ORDER BY OrderID DESC"]);
	$OrderList=$Where->fetchAll(PDO::FETCH_ASSOC);
}