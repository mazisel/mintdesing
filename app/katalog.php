<?php

$page_url=SITE_URL.$W_URLKatalog;
#Sayfa Seo ======{
    $SeoID=107;
    $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
     }
    $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);
#Sayfa Seo ======}

#Katalog Gel ========== {
	$Katalogs=[];
	$sql=$DNCrud->ReadData("katalog",["sql"=>" ORDER BY Sira ASC"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("katalog_lang","KatalogID",$row['KatalogID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("katalog_lang","KatalogID",$row['KatalogID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("katalog_lang","KatalogID",$row['KatalogID']);
			}
		}
		$katalog_row=$sql1->fetch(PDO::FETCH_ASSOC); 
		if($row['Images']) {
			$Resimlinki=BASE_URL.SitePath."images/katalog/".$row['Images'];
		}else{
			$Resimlinki=$NoImg;
		}
		$row+=$katalog_row;
		$Url=BASE_URL."pdf/katalog/".$row['Pdf'];
		$row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];
		$Katalogs[]=$row;
	}
#Katalog Gel ========== }

#Sayfa Seo ======{
    $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
    $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
     }
    $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);
	$PageUrl=SITE_URL.$W_URLKatalog;
	$PageTitle=$SeoLang['Title'];
	$PageKeywords=$SeoLang['Keywords'];
	$PageDescription=$SeoLang['Description'];
	$PageCanonial=$PageUrl;
	$HeaderMeta=$SiteAyarGel['Metalar'].$SiteAyarGel['Metalar'];
	if ($SeoAyar['Images']) {
		$PageSocialImages=BASE_URL.SitePath."images/seo/".$SeoAyar['Images'];
	}else{
		$PageSocialImages=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG2'];
	}
	if ($SeoAyar['Banner']) {
		$PageBanner=BASE_URL.SitePath."images/seo/".$SeoAyar['Banner'];
	}else{
		$PageBanner=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG1'];
	}
#Sayfa Seo ======}