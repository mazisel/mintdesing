<?php

#Sayfa Seo ======{
  $SeoID=2;
  $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
  $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
   }
  $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);

  //Page Veriables =========== {
    $sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID); }
     }
    $SeoPageLang=$sql->fetch(PDO::FETCH_ASSOC);
    $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
    $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
    include 'app/dil.php';
  //Page Veriables =========== }
  $PageUrl=SITE_URL.$W_URLContact;
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

#Şubeler gel ========== {
  $Subeler=[];
  $sql=$DNCrud->ReadData("sube",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]); 
  while($row=$sql->fetch(PDO::FETCH_ASSOC)){
    $sql1=$DNCrud->ReadAData("sube_lang","SubeID",$row['SubeID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql1->rowCount()) {
      $sql1=$DNCrud->ReadAData("sube_lang","SubeID",$row['SubeID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql1->rowCount()) {
        $sql1=$DNCrud->ReadAData("sube_lang","SubeID",$row['SubeID']);
      }
    }
    $lang_row=$sql1->fetch(PDO::FETCH_ASSOC); 
    if($row['Resim']) {
        $Resimlinki=BASE_URL.SitePath."images/sube/".$row['Resim'];
    }else{
        $Resimlinki=BASE_URL.SitePath."images/noimage.png";
    }
    $row+=$lang_row;  
    $row+=["Resimlinki"=>$Resimlinki];
    $Subeler[]=$row;
  }
#Şubeler gel ========== }
