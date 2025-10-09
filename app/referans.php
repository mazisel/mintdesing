<?php
#Sayfa Seo ======{
    $SeoID=106;
    $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
    $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
     }
    $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);

  $PageUrl=SITE_URL.$W_URLReferans;
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
#Sayfa Seo ======}
#referans Detay Gel ========== {
$DetayGeldi=0;
if(isset($Sef[2])){
    $Row_Seo=$Sef[2];
    $Row_Seo1=explode("-",$Row_Seo);
    $ID=end($Row_Seo1);
 
    $sql=$DNCrud->ReadAData("referans","ReferansID",$ID,["ikincikosul"=>"AND Status=1"]); 
    $ReferansRow=$sql->fetch(PDO::FETCH_ASSOC);             
    $sql1=$DNCrud->ReadAData("referans_lang","ReferansID",$ReferansRow['ReferansID'],["ikincikosul"=>"AND LangID=$AktifLangID"]);
    if(!$sql1->rowCount()){
      $sql1=$DNCrud->ReadAData("referans_lang", "ReferansID",$ReferansRow['ReferansID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("referans_lang","ReferansID",$ReferansRow['ReferansID']);
        }
    }    
    $row_lang=$sql1->fetch(PDO::FETCH_ASSOC);

    if($ReferansRow['Resim']) {
      $Resimlinki=BASE_URL.SitePath."images/referans/".$ReferansRow['Resim'];
    }else{
      $Resimlinki=BASE_URL.SitePath."images/noimage.png";
    }
    $ReferansRow+=['Resimlinki'=>$Resimlinki];
    $ReferansRow+=$row_lang;  

    $PageTitle=$ReferansRow['Name']; 
    $DetayGeldi=1;
}else{
#referans Detay Gel ========== }
#referans gel ========== {
  $Referans=[];
  $where=$DNCrud->ReadData("referans",["sql"=>"ORDER BY Sira ASC"]);
  while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
       $sql1=$DNCrud->ReadAData("referans_lang","ReferansID",$row['ReferansID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("referans_lang","ReferansID",$row['ReferansID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("referans_lang","ReferansID",$row['ReferansID']);
          }
        }
        if($sql1->rowCount()) {
          $row1=$sql1->fetch(PDO::FETCH_ASSOC); 
          $row+=$row1;
    }
    if($row['Resim']){
      $Resimlinki=BASE_URL.SitePath."images/referans/".$row['Resim'];
    }else{
      $Resimlinki=BASE_URL.SitePath."images/noimage.png";
    }
    if(!$row['Link']){
      $row['Link']=SITE_URL.$W_URLReference."/".seo($row1['Name']).'-'.$row['ReferansID'];
    }

    
    
    $row+=["Resimlinki"=>$Resimlinki];   

    $Referans[]=$row;
  }
#referans gel ========== }
  
}


