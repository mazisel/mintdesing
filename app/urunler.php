<?php
  #Sayfa Seo ====== {
      $SeoID=7;
      $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
      $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
       }
      $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);

    $PageUrl=SITE_URL.$W_URLShop;
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
  #Sayfa Seo ====== }
  $DetayGeldi=0;
  if ($Sef[2]=="d") {
    include 'app/urunler_detay.php';    
  }else{
 
    #Kategori Geldiyse =============================== {
      $Kate1=$Sef[2];
      $Kate2=$Sef[3];
      if($Kate1 && $Kate2) {
        //İkinci Kategori geldiyse ================= {
          $Kate1Ary=explode("-",$Kate1);
          $Kate1ID=end($Kate1Ary);        

          $Katesor=$DNCrud->ReadAData("kategori","KategoriID",$Kate1ID);
          $Kate1Say=$Katesor->rowCount();if(!$Kate1Say){$Kate1=0;}else{
            $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
              if(!$sql1->rowCount()) {
                $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID);
              }
            }
            $KateLangRow=$sql1->fetch(PDO::FETCH_ASSOC);
          }

          $Kate2Ary=explode("-",$Kate2);
          $Kate2ID=end($Kate2Ary);

          $Katesor=$DNCrud->ReadAData("kategori","KategoriID",$Kate2ID);
          $Kate2Say=$Katesor->rowCount();if(!$Kate2Say){$Kate2=0;}else{
            $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate2ID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
            if(!$alt_sql1->rowCount()){
              $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate2ID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
              if(!$alt_sql1->rowCount()){$alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate2ID); }
            }
            $AltKateLangRow=$alt_sql1->fetch(PDO::FETCH_ASSOC);
            $PageTitle=$AltKateLangRow['Name'];
            $PageKeywords=$SeoLang['Keywords'].','.$AltKateLangRow['Name'];
          }

          
        //İkinci Kategori geldiyse ================= }
      }else if($Kate1){
        $Kate1Ary=explode("-",$Kate1);
        $Kate1ID=end($Kate1Ary);
        $Katesor=$DNCrud->ReadAData("kategori","KategoriID",$Kate1ID);
        $Kate1Say=$Katesor->rowCount();if(!$Kate1Say){$Kate1=0;}else{
          $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$Kate1ID);
            }
          }
          $KateLangRow=$sql1->fetch(PDO::FETCH_ASSOC);

          $PageTitle=$KateLangRow['Name'];
          $PageKeywords=$SeoLang['Keywords'].','.$AltKateLangRow['Name'];
        }

        
      }
    #Kategori Geldiyse ================ }

    $Kategoriler=[];
    if(!$Kate2) {
      #Kategoriler Listeleme işlemi için ========== {        
        if($Kate1) {
          $where=$DNCrud->ReadData("kategori",["sql"=>"WHERE KategoriID={$Kate1ID} AND Status=1 ORDER BY Sira ASC"]);
        }else{
          $where=$DNCrud->ReadData("kategori",["sql"=>"WHERE UstKategoriID=0 AND Status=1 ORDER BY Sira ASC"]);
        }      
        while($KateRow=$where->fetch(PDO::FETCH_ASSOC)){ 
           $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$KateRow['KategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$KateRow['KategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
              if(!$sql1->rowCount()) {
                $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$KateRow['KategoriID']);
              }
            }
            $KateLangRow=$sql1->fetch(PDO::FETCH_ASSOC); 

            $where2=$DNCrud->ReadData("kategori",["sql"=>" WHERE Status=1 AND UstKategoriID=".$KateRow['KategoriID']]);
            $AltVarmi=$where2->rowCount();
            if($AltVarmi){$AltVarmi=1;}else{$AltVarmi=0;}

            if($KateRow['Image']){$Resim=BASE_URL.SitePath."images/categori/".$KateRow['Image']; }else{$Resim=$NoImg; }
            $Name=$KateLangRow['Name'];
            $ID=$KateRow['KategoriID'];
            $Url=SITE_URL.$W_URLShop.'/'.seo($Name)."-".$ID;
            $urun_where=$DNCrud->ReadData("products",["sql"=>" WHERE FIND_IN_SET(({$ID}), Category) AND Status=1"]);
            $UrunSayisi=$urun_where->rowCount();
            if(!$Kate1){
              $Kategoriler[]=["Name"=>$Name, 'Url'=>$Url,"Resim"=>$Resim,"ID"=>$ID,"AltVarmi"=>$AltVarmi,"UrunSayisi"=>$UrunSayisi,"AltKateler"=>[]];
            }
            #Gelen aktegori al
            if($anakateid==$ID) {
              $Kategoriname=["Name"=>$Name,"Resim"=>$Resim,"ID"=>$ID,"AltVarmi"=>$AltVarmi,"UrunSayisi"=>$UrunSayisi];
            }

            #Alt kategoriler =============== {          
              $where12=$DNCrud->ReadData("kategori",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>" WHERE Status=1 AND UstKategoriID=".$KateRow['KategoriID']]);
              while($AltKateRow=$where12->fetch(PDO::FETCH_ASSOC)){
                $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$AltKateRow['KategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
                if(!$alt_sql1->rowCount()){
                  $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$AltKateRow['KategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
                  if(!$alt_sql1->rowCount()){$alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$AltKateRow['KategoriID']); }
                }
                $AltKateLangRow=$alt_sql1->fetch(PDO::FETCH_ASSOC);

                if($Kate1){
                  if($AltKateRow['Image']){$Resim=BASE_URL.SitePath."images/categori/".$AltKateRow['Image']; }else{$Resim=$NoImg; }
                  $Name=$AltKateLangRow['Name'];
                  $ID=$AltKateRow['KategoriID'];
                  $Url=SITE_URL.$W_URLShop.'/'.seo($KateLangRow['Name']).'-'.$KateRow['KategoriID'].'/'.seo($Name)."-".$ID;
                  $urun_where=$DNCrud->ReadData("products",["sql"=>" WHERE FIND_IN_SET(({$ID}), Category) AND Status=1"]);
                  $UrunSayisi=$urun_where->rowCount();
                  $Kategoriler[]=["Name"=>$Name, 'Url'=>$Url,"Resim"=>$Resim,"ID"=>$ID,"UrunSayisi"=>$UrunSayisi];
                }else{
                  $Kategoriler[array_key_last($Kategoriler)]["AltKateler"][]=
                  [
                    'Name'=>$Name,
                    'ID'=>$ID,
                    'UrunSayisi'=>$UrunSayisi,
                    "Resim"=>$AResim
                  ];  
                }
              }
            #Alt kategoriler =============== }
        }
      #Kategoriler Listeleme işlemi için ========== }
    }

    #Ürün Listele ====== {
        if($Kate1 && $Kate2){
          $sayfaurlim=$Kate1."/".$Kate2;
          $urun_sorgu="WHERE FIND_IN_SET(({$Kate2ID}), Category) AND Status=1";
        }else if($Kate1) {
          $sayfaurlim=$Kate1."/";
          $urun_sorgu="WHERE FIND_IN_SET(({$Kate1ID}), Category) AND Status=1";
          $ustkateid=$array[$son_eleman];
        }else{
          $urun_sorgu=" WHERE Status=1";
        }

        $pri_min=htmlspecialchars($_GET['min']);
        $pri_max=htmlspecialchars($_GET['max']);
        if (isset($_GET['min']) AND isset($_GET['max'])) {
            if($pri_min AND ($pri_min>=0)){
              $urun_sorgu.=" AND products.MainPrice >= $pri_min";
            }
            if($pri_max AND ($pri_max>0)){
              $urun_sorgu.=" AND products.MainPrice <= $pri_max";
            }
            if (isset($_GET['brnd']) AND !empty($_GET['brnd'])) {
              $brnd=htmlentities($_GET['brnd']);
              $markasor=$DNCrud->ReadAData("brands","BrandName",$brnd);
              $markarow=$markasor->fetch(PDO::FETCH_ASSOC);
              $BrandID=$markarow['BrandID'];   
              $urun_sorgu.=" AND BrandID = {$BrandID}"; 
            }

        }elseif (isset($_GET['brnd']) AND !empty($_GET['brnd'])) {
          $brnd=htmlentities($_GET['brnd']);
          $markasor=$DNCrud->ReadAData("brands","BrandName",$brnd);
          $markarow=$markasor->fetch(PDO::FETCH_ASSOC);
          $BrandID=$markarow['BrandID'];   
          $urun_sorgu.=" AND BrandID = {$BrandID}";  
          $urun_sorgu.=" ORDER BY Sira ASC"; 
        }else{
         if (!isset($_GET['str'])) {$urun_sorgu.=" ORDER BY Sira ASC";} 
        }

        $price_orderby=$_GET['str'];/*akilli- asc- desc*/
        if ($price_orderby=='asc') { 
          $urun_sorgu.=" ORDER BY MainPrice ASC";
        }else if ($price_orderby=='desc') {
          $urun_sorgu.=" ORDER BY MainPrice DESC";
        }
        #Arama yap ========================================= {
          if(isset($_GET['search'])) {        
            $search=htmlspecialchars($_GET['search']);
            $AktifLangAranan=$DNCrud->ReadAData("products_lang","FirmaID",1,["ikincikosul"=>" AND Name LIKE '%$search%' GROUP BY ProductID"]);     

            if($AktifLangAranan->rowCount()){
              $urun_sorgu=str_replace("WHERE"," AND",$urun_sorgu);
              while($AktifLangAranan_row=$AktifLangAranan->fetch(PDO::FETCH_ASSOC)){
                $say=0;
                $where=$DNCrud->ReadData("products",["sql"=>"WHERE ProductID=".$AktifLangAranan_row['ProductID'].$urun_sorgu]);
              }
            }else{
              $where=$DNCrud->ReadAData("products","FirmaID",1,["ikincikosul"=>" AND UrunKodlari LIKE '%$search%'"]);
            }
          }
        #Arama yap ========================================= }

        ##sayfalama
          if(!isset($_GET['search'])) {
            $sayfa_where=$DNCrud->ReadData("products",["sql"=>$urun_sorgu]);     
            $Sayfa       = @intval($_GET['p']); if(!$Sayfa){ $Sayfa = 1; }
            $ToplamVeri  = $sayfa_where->rowCount();
            $Limit       = @intval($_GET['x']); if(!$Limit){ $Limit = 100; };
            $Sayfa_Sayisi= ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){ $Sayfa=1; }
            $Goster      = $Sayfa * $Limit - $Limit;
            $Gorunen_sayfa= 5;   
            if (isset($_GET['str'])) {        
              $linke_git=SITE_URL.$W_URLShop."/".$sayfaurlim."?str=".$_GET['str']."&p=";
            }else{
              $linke_git=SITE_URL.$W_URLShop."/".$sayfaurlim."?p=";
            }          
            $urun_sorgu.=" LIMIT $Goster,$Limit";
          }else{
              $linke_git=SITE_URL.$W_URLShop."/";
          }
        ##Sayfalama

        $Urunler=[];
        if(!isset($_GET['search'])) {$where=$DNCrud->ReadData("products",["sql"=>$urun_sorgu]);  }                       
        while($row=$where->fetch(PDO::FETCH_ASSOC)){  $say++;        
           $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
              if(!$sql1->rowCount()) {
                $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID']);
              }
            }
            $row1=$sql1->fetch(PDO::FETCH_ASSOC);                                  
            $resimler=$DNCrud->ReadData("products_foto",["colomns_name"=>"Sira","colomns_sort"=>"ASC", "sql"=>" WHERE ProductID=".$row['ProductID']]);
            $resimler_gel=$resimler->fetch(PDO::FETCH_ASSOC);
            if ($resimler_gel['Resim']) {
              $Resim=BASE_URL.SitePath."images/products/".$resimler_gel['Resim'];
            }else{$Resim=$NoImg; }                                         
            $UrunLinki=SITE_URL.$W_URLShop."/d/".seo($row1['Name'])."-".$row['ProductID'];

            $UrunKodlari=json_decode($row['UrunKodlari']);
            $UrunKodlari = (array) $UrunKodlari;
            if (is_array($UrunKodlari)) {$UrunKodlariSay=Count($UrunKodlari); }else{$UrunKodlariSay=0; }

            $row['UrunKodlariSay']=$UrunKodlariSay;
            $row['UrunKodlari']=$UrunKodlari;
            
            $row+=["Resimlinki"=>$Resim,"UrunLinki"=>$UrunLinki];
            $row+=$row1;
            $Urunler[]=$row;
        } 
    #Ürün Listele ====== }

  }

//echo "<PRE>"; print_r($Urunler);die;