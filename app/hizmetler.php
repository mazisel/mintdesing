<?php
$PageUrl=SITE_URL.$W_URLHizmetler;$SeoID=3;

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

$DetayGeldi=0;
if(isset($Sef[1]) && isset($Sef[2])){
  #Hizmet detay gel ========== {
    $GelenSef=$Sef[2];
    $GelenSef=explode("-", $GelenSef);
    $Code=end($GelenSef);
 
    $sql=$DNCrud->ReadAData("hizmetler","Code",$Code,["ikincikosul"=>"AND Status=1"]); 
    $HizmetRow=$sql->fetch(PDO::FETCH_ASSOC);             
    $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$HizmetRow['HizmetID'],["ikincikosul"=>"AND LangID={$AktifLangID}"]);
    if(!$sql1->rowCount()){
      $sql1=$DNCrud->ReadAData("hizmetler_lang", "HizmetID",$HizmetRow['HizmetID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql1->rowCount()) {
        $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$HizmetRow['HizmetID']);
      }
    }    
    $row_lang=$sql1->fetch(PDO::FETCH_ASSOC);    
    $HizmetRow+=$row_lang;

    $Galleri=[];
    $resimler=$DNCrud->ReadData("hizmetler_foto",["colomns_name"=>"Sira","colomns_sort"=>"ASC", "sql"=>" WHERE HizmetID=".$HizmetRow['HizmetID']]);
    while($resimler_gel=$resimler->fetch(PDO::FETCH_ASSOC)){ 
      $ResimlinkiKucuk=BASE_URL.SitePath."images/services/kucuk/".$resimler_gel['Resim'];
      $Resimlinki=BASE_URL.SitePath."images/services/".$resimler_gel['Resim'];
      $Galleri[]=["ResimlinkiKucuk"=>$ResimlinkiKucuk,"Resimlinki"=>$Resimlinki];
    }
    if(!count($Galleri)){
      $Galleri[]=["ResimlinkiKucuk"=>$NoImg,"Resimlinki"=>$NoImg]; 
    }    
    #Sayfa Seo ======{
      if(isset($SeoID) AND $SeoID){
        $PageTitle=$HizmetRow['Title'];
        $PageKeywords=$HizmetRow['Keywords'];
        $PageDescription=$HizmetRow['Description'];
        $PageCanonial=SITE_URL.$W_URLHizmetler."/".seo($HizmetRow['Baslik']).'/'.$HizmetRow['Code'];;
        $HeaderMeta=$SiteAyarGel['Metalar'].$SiteAyarGel['Metalar'];
        if ($HizmetRow['Images']) {
          $PageSocialImages=$Resimlinki;
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
    #Hizmetler gel ========== {
      $Hizmetler=[];
      $where=$DNCrud->ReadData("hizmetler",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]);
      while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
        $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID']);
          }
        }
        if($sql1->rowCount()) {
          $row1=$sql1->fetch(PDO::FETCH_ASSOC); 
          $row+=$row1;
        }  
        $Url=SITE_URL.$W_URLHizmetler."/".seo($row1['Baslik']).'/'.$row['Code'];
        $row+=["Url"=>$Url];
        $Hizmetler[]=$row;
      }  
    #Hizmetler gel ========== }

    $DetayGeldi=1;
  #Hizmet detay gel ========== }
}else{
  #Hizmetler gel ========== {
    $Hizmetler=[];
    $where=$DNCrud->ReadData("hizmetler",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]);
    while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
         $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID']);
            }
          }
          if($sql1->rowCount()) {
            $row1=$sql1->fetch(PDO::FETCH_ASSOC); 
            $row+=$row1;
      }
      
      $resimler=$DNCrud->ReadData("hizmetler_foto",["colomns_name"=>"Sira","colomns_sort"=>"ASC", "sql"=>" WHERE HizmetID=".$row['HizmetID']]);
      $resimler_gel=$resimler->fetch(PDO::FETCH_ASSOC);
      
      if($resimler_gel['Resim']) {
        $Resimlinki=BASE_URL.SitePath."images/services/".$resimler_gel['Resim'];
      }else{
        $Resimlinki=$NoImg;
      }
   
      $Url=SITE_URL.$W_URLHizmetler."/".seo($row1['Baslik']).'-'.$row['Code'];
      $row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];   

      $Hizmetler[]=$row;
    }  
  #Hizmetler gel ========== }
  #Badge Listele ================ {
    $Badges=[];
    $where=$DNCrud->ReadData("badge",["sql"=>"WHERE Status=1","colomns_name"=>"Sira","colomns_sort"=>"ASC"]);
    while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
      $sql1=$DNCrud->ReadAData("badge_lang","BadgeID",$row['BadgeID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
      if(!$sql1->rowCount()) {
        $sql1=$DNCrud->ReadAData("badge_lang","BadgeID",$row['BadgeID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("badge_lang","BadgeID",$row['BadgeID']);
        }
      }
      $LangRow=$sql1->fetch(PDO::FETCH_ASSOC);
      if($row['Image']) {
        $LangRow['ResimLink']=BASE_URL.SitePath."images/badge/".$row['Image'];
      }else{
        $LangRow['ResimLink']=$NoImg;
      }
      $row+=$LangRow;
      $Badges[]=$row;
    }
  #Badge Listele ================ }
}
