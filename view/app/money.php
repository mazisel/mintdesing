<?php 
#money dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",86);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#money dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$ekle=[
		"ParaName"=>htmlspecialchars($_POST['name']),
		"ParaIco"=>htmlspecialchars($_POST['icon']),
		"ParaShort"=>htmlspecialchars($_POST['kisa']),
		"FirmaID"=>$Firma['FirmaID'],
		"ParaStatus"=>$durum,
		"ParaIP"=>$IP,
		"ParaDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("para",$ekle);
	if($sonuc['status']){
		$ParaID=$sonuc['LastID'];
		$ParaCode=$ParaID.rand(99,999);
		$DNCrud->update("para",["ParaID"=>$ParaID, "ParaCode"=>$ParaCode ],["colomns" => "ParaID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W86_Text25,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W86_Text26,
			'git'=>SITE_URL.'money',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W86_Text27,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W86_Text28
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$editdata=[
		"ParaName"=>htmlspecialchars($_POST['name']),
		"ParaIco"=>htmlspecialchars($_POST['icon']),
		"ParaShort"=>htmlspecialchars($_POST['kisa']),
		"ParaStatus"=>$durum,	
		"ParaID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("para",$editdata,[
		"colomns" => "ParaID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>"",
			'subtitle' =>$W86_Text29,
			'icon' => 'success',
			'btn'=>$W86_Text30,
			'git'=>SITE_URL.'money'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W86_Text31,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W86_Text32
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['money_info'])) {
	$ParaID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("para",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND ParaID={$ParaID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['ParaID'],
		"name"=>$DATAROW['ParaName'],
		"icon"=>$DATAROW['ParaIco'],
		"kisa"=>$DATAROW['ParaShort'],
		"durum"=>$DATAROW['ParaStatus']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$ParaID=$_POST['JsID'];

	$sonuc=$DNCrud->delete("para",$ParaID,["colomns" => "ParaID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("para",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY ParaID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
