
<?php

$PageUrl=SITE_URL.$W_URLBolge;$SeoID=12;
#Sayfa Seo ======{
    if(isset($SeoID) AND $SeoID){
      $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
      $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
       }
      $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);
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
    }
#Sayfa Seo ======}

$DetayGeldi=0;
if(isset($Sef[2])){
    $Row_Seo=$Sef[2];
    $Row_Seo1=explode("-",$Row_Seo);
    $BolgeID=end($Row_Seo1);


    $sql=$DNCrud->ReadAData("bolge","BolgeID",$BolgeID,["ikincikosul"=>"AND Status=1"]); 
    $BolgeRow=$sql->fetch(PDO::FETCH_ASSOC);             
    $sql1=$DNCrud->ReadAData("bolge_lang","BolgeID",$BolgeRow['BolgeID'],["ikincikosul"=>"AND LangID={$AktifLangID}"]);
    if(!$sql1->rowCount()){
      $sql1=$DNCrud->ReadAData("bolge_lang", "BolgeID",$BolgeRow['BolgeID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("bolge_lang","BolgeID",$BolgeRow['BolgeID']);
        }
    }    
    $row_lang=$sql1->fetch(PDO::FETCH_ASSOC);

    $BolgeRow+=$row_lang;   



    $DetayGeldi=1;
}else{
#Bölge gel ========== {
	$Bolgeler=[];
	$sql=$DNCrud->ReadData("bolge",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("bolge_lang","BolgeID",$row['BolgeID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("bolge_lang","BolgeID",$row['BolgeID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("bolge_lang","BolgeID",$row['BolgeID']);
			}
		}
		$row_lang=$sql1->fetch(PDO::FETCH_ASSOC);
		
		$row+=$row_lang;
		$Url=SITE_URL.$W_URLBolge."/".seo($row_lang['Name']).'-'.$row['BolgeID'];
		$row+=["Url"=>$Url];
		$Bolgeler[]=$row;
	}

#Bölge gel ========== }

}

#SSS gel ========== {
	$SSS=[];
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
	}
#SSS gel ========== }








?>