<?php 
#ulke dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",83);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#ulke dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	$ekle=[
		"UlkeAlanKodu"=>htmlspecialchars($_POST['alankodu']),
		"UlkeName"=>htmlspecialchars($_POST['name']),
		"FirmaID"=>$Firma['FirmaID'],
		"UlkeIP"=>$IP,
		"UlkeDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("ulke",$ekle);
	if($sonuc['status']){
		$UlkeID=$sonuc['LastID'];
		$UlkeCode=$UlkeID.rand(99,999);
		$DNCrud->update("ulke",["UlkeID"=>$UlkeID, "UlkeCode"=>$UlkeCode ],["colomns" => "UlkeID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W83_Text17,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W83_Text18,
			'git'=>SITE_URL.'land',

		]; echo json_encode($result);die();

	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W83_Text19,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W83_Text20,
			'message' => $sonuc
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	$editdata=[
		"UlkeAlanKodu"=>htmlspecialchars($_POST['alankodu']),
		"UlkeName"=>htmlspecialchars($_POST['name']),	
		"UlkeID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("ulke",$editdata,[
		"colomns" => "UlkeID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W83_Text21,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W83_Text22,
			'git'=>SITE_URL.'land'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W83_Text23,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W83_Text24
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['ulke_info'])) {
	$UlkeID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("ulke",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND UlkeID={$UlkeID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['UlkeID'],
		"alankodu"=>$DATAROW['UlkeAlanKodu'],
		"name"=>$DATAROW['UlkeName']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$UlkeID=$_POST['JsID'];
	$sonuc=$DNCrud->delete("ulke",$UlkeID,["colomns" => "UlkeID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("ulke",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY UlkeID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
