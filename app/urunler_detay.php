<?php
//Ürün Detay

$UrunUrl=$Sef[3];    
if($UrunUrl){
    $DetayGeldi=1;
    $UrunUrlAry=explode("-",$UrunUrl);
    $ProductID=end($UrunUrlAry);
    $sql=$DNCrud->ReadAData("products","ProductID",$ProductID); 
    if(!$sql->rowCount()){ header('Location: '.SITE_URL.$W_URLShop);exit; }
    $GelenProduct=$sql->fetch(PDO::FETCH_ASSOC);
    $ProductID=$GelenProduct['ProductID'];
    if ($GelenProduct['Category']){
      $Category=explode(",", $GelenProduct['Category']);
      if (isset($Category[0])){ $Kate1ID=$Category[0]; } if(!$Kate1ID){ $Kate1ID=0; }
      if (isset($Category[1])){ $Kate2ID=$Category[1]; } 
    }else{
      $KategoriID=0;$Kate1ID=0;
    }
    $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
    if(!$sql->rowCount()) {
      $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql->rowCount()) {
        $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID);
      }
    }
    $product_lang=$sql->fetch(PDO::FETCH_ASSOC);
    $GelenProduct+=$product_lang;

   

    $UrunKodlari=json_decode($GelenProduct['UrunKodlari']);
    $UrunKodlari = (array) $UrunKodlari;
    if (is_array($UrunKodlari)) {$UrunKodlariSay=Count($UrunKodlari); }else{$UrunKodlariSay=0; }

    $GelenProduct['UrunKodlariSay']=$UrunKodlariSay;
    $GelenProduct['UrunKodlari']=$UrunKodlari;
    #Ürün Resimleri =============== {
      $UrunResimleri=[];
      $resimler=$DNCrud->ReadData("products_foto",["colomns_name"=>"Sira","colomns_sort"=>"ASC", "sql"=>" WHERE ProductID={$ProductID}"]);
      while($resimler_gel=$resimler->fetch(PDO::FETCH_ASSOC)){
        if ($resimler_gel['Resim']) {
          $ResimLink=BASE_URL.SitePath."images/products/".$resimler_gel['Resim'];
          $KucukResimLink=BASE_URL.SitePath."images/products/kucuk/".$resimler_gel['Resim'];
        }else{
          $ResimLink=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG3'];
          $KucukResimLink=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG3'];
        }
        $UrunResimleri[]=["ResimLink"=>$ResimLink,"KucukResimLink"=>$KucukResimLink];
      }
    #Ürün Resimleri =============== }
    
  $UrunLang=[];
  $where=$DNCrud->ReadData("products_lang",["sql"=>"WHERE ProductID={$ProductID}"]);
  while($row=$where->fetch(PDO::FETCH_ASSOC)){$UrunLang[]=$row; }

  $UrunLinki=SITE_URL.$W_URLShop."/d/".seo($GelenProduct['Name'])."-".$GelenProduct['ProductID'];
  $GelenProduct['UrunLinki']=$UrunLinki;
  $Ozellik=json_decode($GelenProduct['Ozellik']);
  $Ozellik =(array)$Ozellik;

  $PageTitle=$GelenProduct['Name'];

  $UrunAdi=explode(" ", $GelenProduct['Name']);
  $ilkkelime ='<span>'.$UrunAdi[0].'</span>';
  $GelenProduct['NameHtml']=str_replace($UrunAdi[0], $ilkkelime, $GelenProduct['Name']);

  #Kategoriler Listeleme işlemi için ========== {
    $Kategoriler=[]; 
    $where=$DNCrud->ReadData("kategori",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>" WHERE UstKategoriID=0 AND Status=1"]);
    while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
       $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$row['KategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$row['KategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$row['KategoriID']);
          }
        }
        $row1=$sql1->fetch(PDO::FETCH_ASSOC); 
        $KategoriID=$row['KategoriID'];
        $where2=$DNCrud->ReadData("kategori",["sql"=>" WHERE Status=1 AND UstKategoriID=".$KategoriID]);
        $AltVarmi=$where2->rowCount();
        if($AltVarmi){$AltVarmi=1;}else{$AltVarmi=0;}
        if($row['Resim']){  $Resim=$row['Resim']; }else{ $Resim="cate-thumb.jpg"; }
        $Name=$row1['Name'];
        $ID=$row1['KategoriID'];
        $urun_where=$DNCrud->ReadData("products",["sql"=>" WHERE UstKategoriID={$KategoriID} AND Status=1"]);
        $UrunSayisi=$urun_where->rowCount();
        $Kategoriler[]=["Name"=>$Name,"Resim"=>$Resim,"ID"=>$ID,"AltVarmi"=>$AltVarmi,"UrunSayisi"=>$UrunSayisi,"AltKateler"=>array()];
        
        #Gelen kategori al
        if (isset($anakateid)) {
          if ($anakateid==$ID) {
            $Kategoriname=["Name"=>$Name,"Resim"=>$Resim,"ID"=>$ID,"AltVarmi"=>$AltVarmi,"UrunSayisi"=>$UrunSayisi];
          }
        }
      
        $where12=$DNCrud->ReadData("kategori",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>" WHERE Status=1 AND UstKategoriID={$KategoriID}"]);
        while($alt_row=$where12->fetch(PDO::FETCH_ASSOC)){
          $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$alt_row['KategoriID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$alt_sql1->rowCount()) {
            $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$alt_row['KategoriID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$alt_sql1->rowCount()) {
            $alt_sql1=$DNCrud->ReadAData("kategori_lang","KategoriID",$alt_row['KategoriID']);
            }
          }
          $altkate_row=$alt_sql1->fetch(PDO::FETCH_ASSOC); 
          if($alt_row['Resim']){  $AResim=$alt_row['Resim']; }else{ $AResim="cate-thumb.jpg"; }         
          $Name=$altkate_row['Name'];
          $ID=$altkate_row['KategoriID'];      

          $Kategoriler[array_key_last($Kategoriler)]["AltKateler"][]=[
            "Name"=>$Name,
            "ID"=>$ID,
            "UrunSayisi"=>0,
            "Resim"=>$AResim
          ];  
          #Gelen aktegori al
          if (isset($subkateid)) {
            if ($subkateid==$ID) {
              $SubKategoriname=["Name"=>$Name,"Resim"=>$Resim,"ID"=>$ID,"UrunSayisi"=>$UrunSayisi];
            }   
          }                     
        }
    } 
  #Kategoriler Listeleme işlemi için ========== }
  #Benzer ürünler Listele ===================== {  
    $urun_sorgu="WHERE FIND_IN_SET(({$Kate1ID}), Category) AND Status=1 ORDER BY Sira ASC LIMIT 8";
    $Urunler=[];
    $where=$DNCrud->ReadData("products",["sql"=>$urun_sorgu]);                                
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
        }else{$Resim=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG3']; }                                         
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
  #Benzer ürünler Listele ===================== }

}