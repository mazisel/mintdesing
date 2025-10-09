<?php

#Sayfa Seo ======{
    $SeoID=11;
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

	$PageUrl=SITE_URL.$W_URLBlog;
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

#Blog Gel ========== {
	$Blogs=[];
	$sql=$DNCrud->ReadData("blog",["sql"=>"WHERE Durum=1 ORDER BY Tarih DESC"]); 
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		if(!$sql1->rowCount()) {
			$sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
			if(!$sql1->rowCount()) {
			  $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID']);
			}
		}
		$blog_row=$sql1->fetch(PDO::FETCH_ASSOC); 
		if($row['Resim']) {
			$Resimlinki=BASE_URL.SitePath."images/blog/".$row['Resim'];
		}else{
			$Resimlinki=$NoImg;
		}
		if($row['Category']){
	      $Category=explode(",", $row['Category']);
	      $BKategoriler=[];
	      foreach ($Category as $key => $value) {
	      	$where=$DNCrud->ReadData("blog_kategori",["sql"=>" WHERE BKategoriID={$value} AND Status=1 ORDER BY Sira ASC"]);
		      $katerow=$where->fetch(PDO::FETCH_ASSOC);
		      $sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
		      if(!$sql2->rowCount()) {
		        $sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
		        if(!$sql2->rowCount()) {$sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID']); }
		      }
		      $row1=$sql2->fetch(PDO::FETCH_ASSOC);
		      $BKategoriler[]=$row1["Name"];
	      }
	    }
	    $blog_row["Kategoriler"]=$BKategoriler;
	    $KeywordsHtml="";
	    if($blog_row['Keywords']){
	      $Keywords=explode(",", $blog_row['Keywords']);

	      if(is_array($Keywords)) {
	      	foreach ($Keywords as $key => $value){
	      		$KeywordsHtml.='<li>'.$value.'</li>';
	      	}
	      }
	  	}
	  	$blog_row['KeywordsHtml']=$KeywordsHtml;
		$row+=$blog_row;
		$BlogUrl=SITE_URL.$W_URLBlog."/".seo($blog_row['Baslik']).'-'.$row['BlogKodu'];
		$row+=["Resimlinki"=>$Resimlinki,"BlogUrl"=>$BlogUrl];
		$Blogs[]=$row;
	}
#Blog Gel ========== }

$DetayGeldi=0;
#Blog Detay Gel ========== {
	if(isset($Sef[2])){
	    $Row_Seo=$Sef[2];
	    $Row_Seo1=explode("-",$Row_Seo);
	    $BlogKodu=end($Row_Seo1);

	 	$DetayGeldi=1;
	    $sql=$DNCrud->ReadAData("blog","BlogKodu",$BlogKodu,["ikincikosul"=>"AND Durum=1"]); 
	    $BlogRow=$sql->fetch(PDO::FETCH_ASSOC);             
	    $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$BlogRow['BlogID'],["ikincikosul"=>"AND LangID=$AktifLangID"]);
	    if(!$sql1->rowCount()){
	      $sql1=$DNCrud->ReadAData("blog_lang", "BlogID",$BlogRow['BlogID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
	      if(!$sql1->rowCount()) {
	          $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$BlogRow['BlogID']);
	        }
	    }    
	    $blog_row_lang=$sql1->fetch(PDO::FETCH_ASSOC);

	    if($BlogRow['Resim']) {
	      $Resimlinki=BASE_URL.SitePath."images/blog/".$BlogRow['Resim'];
	    }else{
	      $Resimlinki=$NoImg;
	    }

	    $KeywordsHtml="";
	    if($blog_row_lang['Keywords']){
	      $Keywords=explode(",", $blog_row_lang['Keywords']);

	      if(is_array($Keywords)) {
	      	foreach ($Keywords as $key => $value){
	      		$KeywordsHtml.='<li>'.$value.'</li>';
	      	}
	      }
	  	}
	  	$blog_row_lang['KeywordsHtml']=$KeywordsHtml;
	  	
	    $BlogRow+=['Resimlinki'=>$Resimlinki];
	    $BlogRow+=$blog_row_lang;




	    $PageUrl=SITE_URL.$W_URLBlog;
		$PageTitle=$BlogRow['Title'];
		$PageKeywords=$BlogRow['Keywords'];
		$PageDescription=$BlogRow['Description'];
		$PageCanonial=$PageUrl;
		$HeaderMeta=$SiteAyarGel['Metalar'].$SiteAyarGel['Metalar'];
		if ($BlogRow['Resim']) {
			$PageSocialImages=BASE_URL.SitePath."images/blog/".$BlogRow['Resim'];
		}else{
			$PageSocialImages=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG2'];
		}
		
	    #Blog Gel ========== {
			$Blogs=[];
			$sql=$DNCrud->ReadData("blog",["sql"=>"WHERE Durum=1 ORDER BY Tarih DESC LIMIT 2"]); 
			while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				if($BlogKodu!=$row['BlogKodu']){
					$sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
					if(!$sql1->rowCount()) {
						$sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
						if(!$sql1->rowCount()) {
						  $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID']);
						}
					}
					$blog_row=$sql1->fetch(PDO::FETCH_ASSOC); 
					if($row['Resim']){
						$Resimlinki=BASE_URL.SitePath."images/blog/".$row['Resim'];
					}else{
						$Resimlinki=$NoImg;
					}
					if($row['Category']){
				      $Category=explode(",", $row['Category']);
				      $BKategoriler=[];
				      foreach ($Category as $key => $value) {
				      	$where=$DNCrud->ReadData("blog_kategori",["sql"=>" WHERE BKategoriID={$value} AND Status=1 ORDER BY Sira ASC"]);
					      $katerow=$where->fetch(PDO::FETCH_ASSOC);
					      $sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
					      if(!$sql2->rowCount()) {
					        $sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
					        if(!$sql2->rowCount()) {$sql2=$DNCrud->ReadAData("blog_kategori_lang","BKategoriID",$katerow['BKategoriID']); }
					      }
					      $row1=$sql2->fetch(PDO::FETCH_ASSOC);
					      $BKategoriler[]=$row1["Name"];
				      }
				    }
				    $blog_row["Kategoriler"]=$BKategoriler;
					$row+=$blog_row;
					$BlogUrl=SITE_URL.$W_URLBlog."/".seo($blog_row['Baslik']).'-'.$row['BlogKodu'];
					$row+=["Resimlinki"=>$Resimlinki,"BlogUrl"=>$BlogUrl];
					$Blogs[]=$row;
				}
			}
		#Blog Gel ========== }
	}
#Blog Detay Gel ========== }



