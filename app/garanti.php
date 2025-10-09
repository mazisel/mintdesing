<?php
#Sayfa Seo ======{
$PageUrl=SITE_URL.$W_URLGarantiler;$SeoID=4;
  
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

$DetayGeldi=0;
#Girantiler Detay Gel ========== {
	if(isset($Sef[2])){
		$prc=explode("-",$Sef[2]);
        $eleman_say=count($prc);
        $son_id=$eleman_say-1;
        $GarantiID=end($prc);


	 	$DetayGeldi=1;
	    $sql=$DNCrud->ReadAData("garantiler","GarantiID",$GarantiID,["ikincikosul"=>"AND Status=1"]); 
	    $GarantiRow=$sql->fetch(PDO::FETCH_ASSOC);             
	    $sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$GarantiRow['GarantiID'],["ikincikosul"=>"AND LangID=$AktifLangID"]);
	    if(!$sql1->rowCount()){
	      $sql1=$DNCrud->ReadAData("garantiler_lang", "GarantiID",$GarantiRow['GarantiID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
	      if(!$sql1->rowCount()) {
	          $sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$GarantiRow['GarantiID']);
	        }
	    }    
	    $garanti_row_lang=$sql1->fetch(PDO::FETCH_ASSOC);

	    if($GarantiRow['Image']) {
	      $Resimlinki=BASE_URL.SitePath."images/garanti/".$GarantiRow['Image'];
	    }else{
	      $Resimlinki=BASE_URL.SitePath."images/noimage.png";
	    }
	    $GarantiRow+=['Resimlinki'=>$Resimlinki];
	    $GarantiRow+=$garanti_row_lang;
	    #Blog Gel ========== {
		$Garantiler=[];
		$sql=$DNCrud->ReadData("garantiler",["sql"=>" ORDER BY Sira ASC"]); 
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			if($GarantiID!=$row['GarantiID']){
				$sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
				if(!$sql1->rowCount()) {
					$sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
					if(!$sql1->rowCount()) {
					  $sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID']);
					}
				}
				$garanti_row=$sql1->fetch(PDO::FETCH_ASSOC); 
				if($row['Image']){
					$Resimlinki=BASE_URL.SitePath."images/garanti/".$row['Image'];
				}else{
					$Resimlinki=BASE_URL.SitePath."images/noimage.png";
				}
				$row+=$garanti_row;
				$Url=SITE_URL.$W_URLGarantiler."/".seo($garanti_row['Name']).'-'.$row['GarantiID'];
				$row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];
				$Garantiler[]=$row;
			}
		}
	#Girantiler Gel ========== }

	}else{ 
#Girantiler Detay Gel ========== }

#Girantiler Gel ========== {
	$Garantiler=[];
	$sql=$DNCrud->ReadData("garantiler",["sql"=>" ORDER BY Sira ASC"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("garantiler_lang","GarantiID",$row['GarantiID']);
			}
		}
		$garanti_row=$sql1->fetch(PDO::FETCH_ASSOC); 
		if($row['Image']) {
			$Resimlinki=BASE_URL.SitePath."images/garanti/".$row['Image'];
		}else{
			$Resimlinki=BASE_URL.SitePath."images/noimage.png";
		}
		$row+=$garanti_row;
		$Url=SITE_URL.$W_URLGarantiler."/".seo($garanti_row['Name']).'-'.$row['GarantiID'];
		$row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];
		$Garantiler[]=$row;
	}
#Girantiler Gel ========== }
}

