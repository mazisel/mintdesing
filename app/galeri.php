<?php
$PageUrl=SITE_URL.$W_URLGallery;$SeoID=105;
#Sayfa Seo ======{
    if(isset($SeoID) AND $SeoID){
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

#Galeri gel ========== {

  
  $Gallerys=[];
  $sql=$DNCrud->ReadData("gallery",["sql"=>" ORDER BY Sira ASC"]); 
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
  }
#Galeri gel ========== }