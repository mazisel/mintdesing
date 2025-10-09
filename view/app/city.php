<?php 
#city dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",84);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#city dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	$ekle=[
		"CityPostaKodu"=>htmlspecialchars($_POST['alankodu']),
		"CityName"=>htmlspecialchars($_POST['name']),
		"FirmaID"=>$Firma['FirmaID'],
		"CityIP"=>$IP,
		"CityDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("city",$ekle);
	if($sonuc['status']){
		$CityID=$sonuc['LastID'];
		$CityCode=$CityID.rand(99,999);
		$DNCrud->update("city",["CityID"=>$CityID, "CityCode"=>$CityCode ],["colomns" => "CityID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W84_Text17,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W84_Text18,
			'git'=>SITE_URL.'city',

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W84_Text19,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W84_Text20,
			'message' => $sonuc
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	$editdata=[
		"CityPostaKodu"=>htmlspecialchars($_POST['alankodu']),
		"CityName"=>htmlspecialchars($_POST['name']),	
		"CityID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("city",$editdata,[
		"colomns" => "CityID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W84_Text21,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W84_Text22,
			'git'=>SITE_URL.'city'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W84_Text23,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W84_Text24
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['city_info'])) {
	$CityID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("city",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CityID={$CityID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['CityID'],
		"alankodu"=>$DATAROW['CityPostaKodu'],
		"name"=>$DATAROW['CityName']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$CityID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("city",$CityID,["colomns" => "CityID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("city",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY CityID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
