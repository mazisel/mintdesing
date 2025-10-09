<?php 
#category dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",85);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#category dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"UstKateID"=>htmlspecialchars($_POST['anakate']),
		"KateName"=>htmlspecialchars($_POST['name']),
		"KateDesc"=>htmlspecialchars($_POST['desc']),
		"KateStatus"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"KateIP"=>$IP,
		"KateDate"=>date('Y-m-d H:i:s')
	];
	$_FILES['KateIco']=$_FILES['icon'];
	$_FILES['KateImg']=$_FILES['resim'];
	$sonuc=$DNCrud->insert("kategori",$ekle,
		[
			"UploadFile"=>
			[
				[ "file_name" => "KateIco", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/kategory/", 
				"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
				"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
			],
			[ "file_name" => "KateImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/kategory/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]
]
);
	if($sonuc['status']){
		$KateID=$sonuc['LastID'];
		$KateCode=$KateID.rand(99,999);
		$DNCrud->update("kategori",["KateID"=>$KateID, "KateCode"=>$KateCode ],["colomns" => "KateID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W85_Text26,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W85_Text27,
			'git'=>SITE_URL.'category',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W85_Text28,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W85_Text29
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"KateID"=>htmlspecialchars($_POST['JsID']),
		"UstKateID"=>htmlspecialchars($_POST['anakate']),
		"KateName"=>htmlspecialchars($_POST['name']),
		"KateDesc"=>htmlspecialchars($_POST['desc']),
		"KateStatus"=>$durum	
	];
	if (isset($_FILES['icon'])) {$_FILES['KateIco']=$_FILES['icon']; }
	if (isset($_FILES['resim'])) {$_FILES['KateImg']=$_FILES['resim']; }
	$sonuc=$DNCrud->update("kategori",$editdata,
	[
		"colomns" => "KateID",
			"UploadFile"=>
		[
				[ "file_name" => "KateIco", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/kategory/", 
				"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
				"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
			],
			[ "file_name" => "KateImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/kategory/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
			]
		]
	]
);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W85_Text30,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W85_Text31,
			'git'=>SITE_URL.'category'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W85_Text32,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W85_Text33
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['kategori_info'])) {
	$KateID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("kategori",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['KateID'],
		"anakate"=>$DATAROW['UstKateID'],
		"name"=>$DATAROW['KateName'],
		"desc"=>$DATAROW['KateDesc'],
		"durum"=>$DATAROW['KateStatus'],
		"icon"=>$DATAROW['KateIco'],
		"resim"=>$DATAROW['KateImg']
	];
	echo json_encode($Data);die;

}


/*DELETE*/
if (isset($_POST['JsDel'])) {
	$KateID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("kategori",$KateID,["colomns" => "KateID", 
		"file_name" => "KateIco", "dir" => SitePath."images/kategory/",
		"file_name2" => "KateImg", "dir2" => SitePath."images/kategory/"
	]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("kategori",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY KateID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
