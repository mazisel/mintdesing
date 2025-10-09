<?php


#Galeri Listele ========== {
	/*$Gallerys=[];
	$sql=$DNCrud->ReadData("gallery",["sql"=>" ORDER BY Sira ASC LIMIT 6"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("gallery_lang","GalleryID",$row['GalleryID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("gallery_lang","GalleryID",$row['GalleryID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("gallery_lang","GalleryID",$row['GalleryID']);
			}
		}
		$galeri_row=$sql1->fetch(PDO::FETCH_ASSOC); 
		if($row['Resim']) {
		    $ResimlinkiKucuk=BASE_URL.SitePath."images/gallery/kucuk/".$row['Resim'];
		    $Resimlinki=BASE_URL.SitePath."images/gallery/".$row['Resim'];
		}else{
		    $Resimlinki=BASE_URL.SitePath."images/noimage.png";
		}
		$row+=$galeri_row;	
		$row+=["Resimlinki"=>$Resimlinki,"ResimlinkiKucuk"=>$ResimlinkiKucuk];
		$Gallerys[]=$row;
	}*/
#Galeri Listele ========== }



#SSS gel ========== {
	/*$SSS=[];
	$sql=$DNCrud->ReadData("sss",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("sss_lang","SSSID",$row['SSSID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("sss_lang","SSSID",$row['SSSID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("sss_lang","SSSID",$row['SSSID']);
			}
		}
		$row_lang=$sql1->fetch(PDO::FETCH_ASSOC);
		
		$row+=$row_lang;
		$Url=SITE_URL.$W_URLSSS."/".seo($row_lang['Baslik']).'-'.$row['SSSID'];
		$row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];
		$SSS[]=$row;
	}*/
#SSS gel ========== }



#SEO
$PageUrl=SITE_URL;
$PageTitle=$SiteAyarGel['Title'];
$PageKeywords=$SiteAyarGel['Keywords'];
$PageDescription=$SiteAyarGel['Description'];
$PageCanonial=$PageUrl;
$HeaderMeta=$SiteAyarGel['Metalar'];
$PageSocialImages=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG2'];
$PageBanner=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG1'];