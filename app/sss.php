<?php 	
#Sayfa Seo ======{
  $PageUrl=SITE_URL.$W_URLSSS;$SeoID=8;
  
  $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
  $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
   }
  //Page Veriables =========== {
    $sql1=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql1->rowCount()) {$sql1=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql1->rowCount()) {$sql1=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID); }
     }
    $SeoPageLang=$sql1->fetch(PDO::FETCH_ASSOC);
    $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
    $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
    include 'app/dil.php';
  //Page Veriables =========== }
  $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);
  $PageUrl=$PageUrl;
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
