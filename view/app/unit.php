<?php 
#unit dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",81);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#unit dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	$ekle=[
		"UnitName"=>htmlspecialchars($_POST['name']),
		"FirmaID"=>$Firma['FirmaID'],
		"UnitIP"=>$IP,
		"UnitDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("unit",$ekle);
	if($sonuc['status']){
		$UnitID=$sonuc['LastID'];
		$UnitCode=$UnitID.rand(99,999);
		$DNCrud->update("unit",["UnitID"=>$UnitID, "UnitCode"=>$UnitCode ],["colomns" => "UnitID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W81_Text16,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W81_Text17,
			'git'=>SITE_URL.'unit',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W81_Text18,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W81_Text19
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	$editdata=[
		"UnitName"=>htmlspecialchars($_POST['name']),	
		"UnitID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("unit",$editdata,[
		"colomns" => "UnitID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W81_Text20,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W81_Text21,
			'git'=>SITE_URL.'unit'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W81_Text22,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W81_Text23
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['unit_info'])) {
	$UnitID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("unit",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND UnitID={$UnitID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['UnitID'],
		"name"=>$DATAROW['UnitName']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$UnitID=$_POST['JsID'];

	$sonuc=$DNCrud->delete("unit",$UnitID,["colomns" => "UnitID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("unit",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UnitID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
