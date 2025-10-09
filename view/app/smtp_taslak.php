<?php 
#SMTP TASLAK gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",96);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#SMTP TASLAK dil gel ======}

/* GUNCELLE */
if (isset($_POST['guncelle'])) {
if (isset($_POST['durum']) && $_POST['durum']==1) {$durum=1; }else{$durum=0;}
	$FixedData=[
		"SmtpID"=>htmlspecialchars($_POST['smtp']),	
		"TaslakTitle"=>htmlspecialchars($_POST['title']),	
		"TaslakContent"=>htmlspecialchars($_POST['content']),	
		"TaslakKate"=>htmlspecialchars($_POST['kate']),	
		"Status"=>$durum,	
		"TaslakIP"=>$IP,
		"TaslakDate"=>date('Y-m-d H:i:s'),
		"FirmaID"=>$Firma['FirmaID']
	];
	$kate=$_POST['kate'];

	$sorgu=$DNCrud->ReadData("firma_smtp_taslak",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND TaslakKate={$kate}"]);
	if($sorgu->rowCount()) {
		$taslakRow=$sorgu->fetch(PDO::FETCH_ASSOC);
		$FixedData['TaslakID']=$taslakRow['TaslakID'];
		$sonuc=$DNCrud->update("firma_smtp_taslak",$FixedData,["colomns" => "TaslakID"]); 
	}else{
		$sonuc=$DNCrud->insert("firma_smtp_taslak",$FixedData);
	}
	
	if($sonuc['status']){
		$result=[
			"sonuc" => 'success',
			'title' =>$W96_Text20,
			'subtitle' =>"",
			'icon' => 'success',
			'btn'=>$W96_Text21
		]; echo json_encode($result);die();
	}else{
		$result=[
			"sonuc" => 'error',
			'title' =>$W96_Text22,
			'subtitle' =>"",
			'icon' => 'warning',
			'btn'=>$W96_Text23
		]; echo json_encode($result);die(); 
	} 

}

$sorgu=$DNCrud->ReadData("firma_smtp_taslak",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND TaslakKate=1"]);
$FaturaTaslakRow=$sorgu->fetch(PDO::FETCH_ASSOC);
$sorgu=$DNCrud->ReadData("firma_smtp_taslak",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND TaslakKate=2"]);
$MaasTaslakRow=$sorgu->fetch(PDO::FETCH_ASSOC);

/* SMTP VERI CEKME VE LISTELEME */
$SMTP=$DNCrud->ReadData("firma_smtp",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} ORDER BY SmtpID DESC"]);
$SMTPlist=$SMTP->fetchAll(PDO::FETCH_ASSOC);