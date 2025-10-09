<?php 
#vergi_kate dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",92);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#vergi_kate dil gel ======}

/* EKLE */
if (isset($_POST['form_add'])) {
	$ekle=[
		"KateName"=>htmlspecialchars($_POST['name']),
		"KateDesc"=>htmlspecialchars($_POST['desc']),
		"FirmaID"=>$Firma['FirmaID'],
		"KateIP"=>$IP,
		"KateDate"=>date('Y-m-d H:i:s')
	];
	$sonuc=$DNCrud->insert("vergi_kate",$ekle);
	if($sonuc['status']){
		$KateID=$sonuc['LastID'];
		$KateCode=$KateID.rand(99,999);
		$DNCrud->update("vergi_kate",["KateID"=>$KateID, "KateCode"=>$KateCode ],["colomns" => "KateID"]);
		$result=[
			"sonuc" => 'success',
			'title' =>$W92_Text16,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W92_Text17,
			'git'=>SITE_URL.'added',

		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W92_Text18,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W92_Text19
		]; echo json_encode($result);die(); 
	} 

}


/*GUNCELLEME*/
if (isset($_POST['form_edit'])) {
	$editdata=[
		"KateName"=>htmlspecialchars($_POST['name']),	
		"KateDesc"=>htmlspecialchars($_POST['desc']),
		"KateID"=>htmlspecialchars($_POST['JsID'])
	];
	$sonuc=$DNCrud->update("vergi_kate",$editdata,[
		"colomns" => "KateID"
	]);
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W92_Text20,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W92_Text21,
			'git'=>SITE_URL.'added'
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W92_Text22,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W92_Text23
		]; echo json_encode($result);die(); 
	} 

}
/*EDIT*/
if (isset($_POST['kate_info'])) {
	$KateID=$_POST['JsID'];
	$sorgu=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$KateID}"]);
	$DATAROW=$sorgu->fetch(PDO::FETCH_ASSOC);
	$Data=[
		"id"=>$DATAROW['KateID'],
		"desc"=>$DATAROW['KateDesc'],
		"name"=>$DATAROW['KateName']
	];
	echo json_encode($Data);die;

}

/*DELETE*/
if (isset($_POST['JsDel'])) {
	$KateID=$_POST['JsID'];

	$sonuc=$DNCrud->delete("vergi_kate",$KateID,["colomns" => "KateID"]);
	if($sonuc['status']){
		$array=["sonuc" => 'success']; echo json_encode($array);die();
	}else{
		$array=["sonuc" => 'error',"neden" => $sonuc['error']]; echo json_encode($array);die();
	} 

}


/* VERI CEKME VE LISTELEME */
$DataSorgu=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY KateID DESC"]);
$DataList=$DataSorgu->fetchAll(PDO::FETCH_ASSOC);
