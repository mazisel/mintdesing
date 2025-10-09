<?php 
#user dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",89);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#user dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[	
		"UserNick"=>htmlspecialchars($_POST['nick']),
		"UserName"=>htmlspecialchars($_POST['name']),
		"UserSurname"=>htmlspecialchars($_POST['surname']),
		"UserEmail"=>htmlspecialchars($_POST['email']),
		"UserPass"=>md5($_POST['pass']),
		"UserTel"=>htmlspecialchars($_POST['tel']),
		"UserDesc"=>htmlspecialchars($_POST['desc']),
		"Status"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"UserIP"=>$IP,
		"UserDate"=>date('Y-m-d H:i:s')
	];
	$_FILES['UserImg']=$_FILES['resim'];
	$sonuc=$DNCrud->insert("firma_user",$ekle,[
		"UploadFile"=>
		[
			[ "file_name" => "UserImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/user/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]]
);
	if($sonuc['status']){
		$UserID=$sonuc['LastID'];
		$UserCode=$UserID.rand(99,999);
		$DNCrud->update("firma_user",["UserID"=>$UserID, "UserCode"=>$UserCode ],["colomns" => "UserID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W89_Text53,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W89_Text54,
			'yap'=>'reset',
			'Data'=>[
				'Tablo'=>'ekle',
				'JsID' => $UserID,
				'code' => $UserCode,
				'name' => $_POST['name'],
				'surname' => $_POST['surname'],
				'durum' => $durum
			]

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W89_Text55,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W89_Text56
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"UserID"=>htmlspecialchars($_POST['JsID']),
		"UserNick"=>htmlspecialchars($_POST['nick']),
		"UserName"=>htmlspecialchars($_POST['name']),
		"UserSurname"=>htmlspecialchars($_POST['surname']),
		"UserEmail"=>htmlspecialchars($_POST['email']),		
		"UserTel"=>htmlspecialchars($_POST['tel']),
		"UserDesc"=>htmlspecialchars($_POST['desc']),
		"Status"=>$durum
	];

	if (!empty($_POST['pass'])) {
		$editdata['UserPass']=md5($_POST['pass']);
	}


	if (isset($_FILES['resim'])) {
		$_FILES['UserImg']=$_FILES['resim'];
	}
	$sonuc=$DNCrud->update("firma_user",$editdata,[ 
		"colomns" => "UserID",
		"UploadFile"=>
		[
			[ "file_name" => "UserImg", "izinli_uzantilar" => ["jpg","jpeg","png","ico","JPG","JPEG","PNG","webp"], "dir" => SitePath."images/user/", 
			"nasil_yuklensin" => "oldugu_gibi",/*sadeceolcu,kucuk_haliile,sadeceolcu*/
			"fitToWidth" => "560", "fitToWidthBuyuk" => 600, "SizeLimit" => Null
		]
	]
]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W89_Text57,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W89_Text58,
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
			'title' =>$W89_Text59,
			'subtitle' =>"",
			'message' =>$sonuc,
			'icon' => 'warning',
			'btn'=>$W89_Text60
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['user_info'])) {
	$UserID=$_POST['JsID'];

	$sorgu=$DNCrud->ReadData("firma_user",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND UserID={$UserID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"JsID"=>$DATAROW['UserID'],
		"nick"=>$DATAROW['UserNick'],
		"name"=>$DATAROW['UserName'],
		"surname"=>$DATAROW['UserSurname'],
		"email"=>$DATAROW['UserEmail'],
		"tel"=>$DATAROW['UserTel'],
		"desc"=>$DATAROW['UserDesc'],
		"durum"=>$DATAROW['Status'],
		"resim"=>$DATAROW['UserImg']

	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$UserID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("firma_user",$UserID,["colomns" => "UserID", "file_name" => "UserImg", "dir" => SitePath."images/user/"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("firma_user",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UserID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);

