<?php
$PageUrl=SITE_URL.$W_URLYorum;$SeoID=9;
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

#Yorumlar gel ================ {
  $Comments=[];
  $sql=$DNCrud->ReadData("comments",["sql"=>"ORDER BY CommentID DESC"]); 
  while($row=$sql->fetch(PDO::FETCH_ASSOC)){
    $Comments[]=$row;
  }
#Yorumlar gel ================ }