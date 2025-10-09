<?php 
#payment_method dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",82);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#payment_method dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"PaymentName"=>htmlspecialchars($_POST['name']),
		"PaymentStatus"=>$durum,
		"FirmaID"=>$Firma['FirmaID'],
		"PaymentIP"=>$IP,
		"PaymentDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("payment",$ekle);
	if($sonuc['status']){
		$PaymentID=$sonuc['LastID'];
		$PaymentCode=$PaymentID.rand(99,999);
		$DNCrud->update("payment",["PaymentID"=>$PaymentID, "PaymentCode"=>$PaymentCode ],["colomns" => "PaymentID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W82_Text21,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W82_Text22,
			'git'=>SITE_URL.'payment',

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W82_Text23,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W82_Text24
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"PaymentName"=>htmlspecialchars($_POST['name']),
		"PaymentStatus"=>$durum,	
		"PaymentID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("payment",$editdata,[
		"colomns" => "PaymentID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W82_Text25,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W82_Text26,
			'git'=>SITE_URL.'payment'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W82_Text27,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W82_Text28
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['payment_info'])) {
	$PaymentID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("payment",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PaymentID={$PaymentID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['PaymentID'],
		"name"=>$DATAROW['PaymentName'],
		"durum"=>$DATAROW['PaymentStatus']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$PaymentID=$_POST['JsID'];

	$sonuc=$DNCrud->delete("payment",$PaymentID,["colomns" => "PaymentID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("payment",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY PaymentID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
