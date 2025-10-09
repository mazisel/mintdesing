<?php 
#Product dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",80);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#Product dil gel ======}
#Veri ekleme ===================== {
	if (isset($_POST['form_insert']) && $_POST['form_insert']=='urun') {
		if(isset($_POST['kdv']) && $_POST['kdv']==1){ $kdv=1; }else{ $kdv=0; }
		if(isset($_POST['durum']) && $_POST['durum']==1){ $durum=1; }else{ $durum=0; }
		
		$kdvtutar=str_replace("%", "", $_POST['kdvtutar']);
		$kdvtutar=str_replace(",", "", $kdvtutar);
		$Data=[
			"ProductName"=>htmlspecialchars($_POST['name']),
			"ProductFiyat"=>str_replace(",", "", $_POST['fiyat']),
			"ProductKDV"=>$kdvtutar,
			"UnitID"=>htmlspecialchars($_POST['birim']),
			"ParaID"=>htmlspecialchars($_POST['para']),
			"ProductKdvDurum"=>$kdv,
			"ProductStatus"=>$durum,
			"ProductStokKod"=>htmlspecialchars($_POST['stokkodu']),
			"ProductBarkod"=>htmlspecialchars($_POST['barkodkodu']),
			"ProductDesc"=>htmlspecialchars($_POST['desc']),
			"KateID"=>htmlspecialchars($_POST['kate']),
			"FirmaID"=>$Firma['FirmaID'],
			"ProductIP"=>$IP,
			"ProductDate"=>date('Y-m-d H:i:s')
		];
		$_FILES['ProductImg']=$_FILES['resim'];
		$sonuc=$DNCrud->insert("product",$Data,[
			"UploadFile"=>
			[
				[ "file_name" => "ProductImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/product/", 
				"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
				"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
				]
			]
		]);
		if($sonuc['status']){
			$ProductID=$sonuc['LastID'];
			$ProductCode=$ProductID.rand(99,999);
			$Data['ProductID']=$ProductID;
			$DNCrud->update("product",["ProductID"=>$ProductID, "ProductCode"=>$ProductCode ],["colomns" => "ProductID"]);
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W80_Text38,
				'subtitle' =>"",			
				'btn'=>$W80_Text39,
				'git'=>SITE_URL.'product',
				'Data'=>$Data
			]; echo json_encode($result);die();

		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W80_Text40,
				'subtitle' =>"",			
				'btn'=>$W80_Text41,
				'Errormessage'=>$sonuc
			]; echo json_encode($result);die(); 
		} 

	}
#Veri ekleme ===================== }
#Veri Güncelle ===================== {
	if (isset($_POST['form_update']) && $_POST['form_update']=='urun') {
		if (isset($_POST['kdv']) && $_POST['kdv']==1) {$kdv=1; }else{$kdv=0;}
		if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
		
		$kdvtutar=str_replace("%", "", $_POST['kdvtutar']);
		$kdvtutar=str_replace(",", "", $kdvtutar);

		$Data=[
			"ProductID"=>htmlspecialchars($_POST['product_id']),
			"ProductName"=>htmlspecialchars($_POST['name']),
			"ProductFiyat"=>str_replace(",", "", $_POST['fiyat']),
			"ProductKDV"=>$kdvtutar,
			"UnitID"=>htmlspecialchars($_POST['birim']),
			"ParaID"=>htmlspecialchars($_POST['para']),
			"ProductKdvDurum"=>$kdv,
			"ProductStatus"=>$durum,
			"ProductStokKod"=>htmlspecialchars($_POST['stokkodu']),
			"ProductBarkod"=>htmlspecialchars($_POST['barkodkodu']),
			"ProductDesc"=>htmlspecialchars($_POST['desc']),
			"KateID"=>htmlspecialchars($_POST['kate']),
			"FirmaID"=>$Firma['FirmaID'],
			"ProductIP"=>$IP,
			"ProductDate"=>date('Y-m-d H:i:s')
		];
		//print_r($Data);die;
		$_FILES['ProductImg']=$_FILES['resim'];
		$sonuc=$DNCrud->update("product",$Data,[
			"UploadFile"=>
			[
				[ "file_name" => "ProductImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/product/", 
				"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
				"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
				]
			],
			"colomns" => "ProductID"
		]);
		if($sonuc['status']){
			$result=[
				"sonuc" => 'success','icon' => 'success',
				'title' =>$W80_Text38,
				'subtitle' =>"",			
				'btn'=>$W80_Text39,
				'git'=>SITE_URL.'product',
				'Data'=>$Data
			]; echo json_encode($result);die();
		}else{
			$result=[
				"sonuc" => 'error','icon' => 'warning',
				'title' =>$W80_Text40,
				'subtitle' =>"",			
				'btn'=>$W80_Text41,
				'Errormessage'=>$sonuc
			]; echo json_encode($result);die(); 
		} 

	}
#Veri Güncelle ===================== }

/* EKLE */
if(isset($_POST['form_add'])) {
	if (isset($_POST['kdv']) && $_POST['kdv']==1) {$kdv=1; }else{$kdv=0;}
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"ProductName"=>htmlspecialchars($_POST['name']),
		"ProductFiyat"=>htmlspecialchars($_POST['fiyat']),
		"ProductKDV"=>htmlspecialchars($_POST['kdvtutar']),
		"UnitID"=>htmlspecialchars($_POST['birim']),
		"ParaID"=>htmlspecialchars($_POST['para']),
		"ProductKdvDurum"=>$kdv,
		"ProductStatus"=>$durum,
		"ProductStokKod"=>htmlspecialchars($_POST['stokkodu']),
		"ProductBarkod"=>htmlspecialchars($_POST['barkodkodu']),
		"ProductDesc"=>htmlspecialchars($_POST['desc']),
		"KateID"=>htmlspecialchars($_POST['kate']),
		"FirmaID"=>$Firma['FirmaID'],
		"ProductIP"=>$IP,
		"ProductDate"=>date('Y-m-d H:i:s')
	];
	$_FILES['ProductImg']=$_FILES['resim'];
	$sonuc=$DNCrud->insert("product",$ekle,[
		"UploadFile"=>
		[
			[ "file_name" => "ProductImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/product/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]]
	);
	if($sonuc['status']){
		$ProductID=$sonuc['LastID'];
		$ProductCode=$ProductID.rand(99,999);
		$DNCrud->update("product",["ProductID"=>$ProductID, "ProductCode"=>$ProductCode ],["colomns" => "ProductID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W80_Text38,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W80_Text39,
			'git'=>SITE_URL.'product',

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W80_Text40,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W80_Text41
		]; echo json_encode($result);die(); 
	}
}
/*GUNCELLEME*/
if(isset($_POST['form_edit'])){
	if (isset($_POST['kdv']) && $_POST['kdv']==1) {$kdv=1; }else{$kdv=0;}
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$sorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ProductID={$_POST['JsID']}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$editdata=[
		"ProductID"=>htmlspecialchars($_POST['JsID']),
		"ProductName"=>htmlspecialchars($_POST['name']),
		"ProductFiyat"=>htmlspecialchars($_POST['fiyat']),
		"ProductKDV"=>htmlspecialchars($_POST['kdvtutar']),
		"UnitID"=>htmlspecialchars($_POST['birim']),
		"ParaID"=>htmlspecialchars($_POST['para']),
		"ProductKdvDurum"=>$kdv,
		"ProductStatus"=>$durum,
		"ProductStokKod"=>htmlspecialchars($_POST['stokkodu']),
		"ProductBarkod"=>htmlspecialchars($_POST['barkodkodu']),
		"KateID"=>htmlspecialchars($_POST['kate']),
		"ProductDesc"=>htmlspecialchars($_POST['desc']),

	];
	if (isset($_FILES['resim'])) {
		$_FILES['ProductImg']=$_FILES['resim'];
	}
	$sonuc=$DNCrud->update("product",$editdata,[ 
		"colomns" => "ProductID",
		"UploadFile"=>
		[
			[ "file_name" => "ProductImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/product/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W80_Text42,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W80_Text43,
			'git'=>SITE_URL.'product'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W80_Text44,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W80_Text45
		]; echo json_encode($result);die(); 
	}
}
/*EDIT*/
if(isset($_POST['product_info'])){
	$ProductID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ProductID={$ProductID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"JsID"=>$DATAROW['ProductID'],
		"name"=>$DATAROW['ProductName'],
		"fiyat"=>$DATAROW['ProductFiyat'],
		"kdvtutar"=>$DATAROW['ProductKDV'],
		"para"=>$DATAROW['ParaID'],
		"birim"=>$DATAROW['UnitID'],
		"kdv"=>$DATAROW['ProductKdvDurum'],
		"durum"=>$DATAROW['ProductStatus'],
		"stokkodu"=>$DATAROW['ProductStokKod'],
		"barkodkodu"=>$DATAROW['ProductBarkod'],
		"desc"=>$DATAROW['ProductDesc'],
		"kate"=>$DATAROW['KateID'],
		"resim"=>$DATAROW['ProductImg']
	];
	echo json_encode($Data);die;
}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$ProductID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("product",$ProductID,["colomns" => "ProductID", "file_name" => "ProductImg", "dir" => SitePath."images/product/"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	}
}


/* VERI CEKME VE LISTELEME */
if(isset($_GET['id'])){
	$ProductID=intval($_GET['id']);
	$DataSorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ProductID={$ProductID}"]);
	$productRow=$DataSorgu->fetch(PDO::FETCH_ASSOC);
	//echo "<pre>"; print_r($productRow);die;
}else{
	$DataSorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY ProductID DESC"]);
	$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
}
/* UNIT VERI CEKME VE LISTELEME */
$UnitSorgu=$DNCrud->ReadData("unit",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UnitID DESC"]);
$UnitList=$UnitSorgu->fetchAll(PDO::FETCH_ASSOC);
/* PARA VERI CEKME VE LISTELEME */
$ParaSorgu=$DNCrud->ReadData("para",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ParaStatus=1 ORDER BY ParaID DESC"]);
$ParaList=$ParaSorgu->fetchAll(PDO::FETCH_ASSOC);
/* KATE VERI CEKME VE LISTELEME */
$KateSorgu=$DNCrud->ReadData("kategori",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY KateID DESC"]);
$KateList=$KateSorgu->fetchAll(PDO::FETCH_ASSOC);
