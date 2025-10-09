<?php

$Today=date('Y-m-d H:i:s');
$sql=$DNCrud->ReadData("site_resimleri"); 
$SiteResimleri=$sql->fetch(PDO::FETCH_ASSOC);

#Çerez politikasını kabul ediyorum ===================== {
  #Sozlesme yazısı============ {
       $sql_soz=$DNCrud->ReadAData("page","PageID",9);
       $soz_row=$sql_soz->fetch(PDO::FETCH_ASSOC);
       $sql1=$DNCrud->ReadAData("page_lang","PageID",$soz_row['PageID'],["ikincikosul"=>"AND LangID={$AktifLangID}"]);
       if(!$sql1->rowCount()){
        $sql1=$DNCrud->ReadAData("page_lang", "PageID",$soz_row['PageID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("page_lang","PageID",$soz_row['PageID']);
        } 
       }   
      $pagesabit_row=$sql1->fetch(PDO::FETCH_ASSOC);
      $dgr1='<a target="_blank" href="'.SITE_URL.'page/'.seo($pagesabit_row["Title"]).'-'.$soz_row["PageKodu"].'">'.$pagesabit_row["Title"].'</a>';
      $SozlesmeText=str_replace("{CookiePolicy}",$dgr1,$Variable69);
  #Sozlesme yazısı============ }
  if (isset($_POST['cokie_sozlesme'])) {
    $_SESSION['CookieOnay']=1;
  }
#Çerez politikasını kabul ediyorum ===================== }



#Site Hit İşlem ===================== {
  function Hitkaydet($url)
  {
    global $db;
    $Gun = strtotime(date('d.m.Y')); 
    $Zaman = strtotime(date('d.m.Y H:i:s'));
    $Zaman2 = strtotime(date('d.m.Y H:i'));
    //$Zaman5dEkle=strtotime(date('d.m.Y H:i:s', time() + 300));
    $Ip    = gercekip();
    $query=$db->prepare("SELECT * FROM hit_info WHERE IP=? AND Gun=?");
    $query->execute([$Ip,$Gun]);
    if($query->rowCount()){
      $HitInfoRow=$query->fetch(PDO::FETCH_ASSOC);    
      $VarolanHitInfo=json_decode($HitInfoRow['HitInfo']);
      $VarolanHitInfo = (array) $VarolanHitInfo;

      $AyniUrl=ArryaSearch($VarolanHitInfo,0,$url);
      $AyniUrlEnd=end($AyniUrl);
      if($Zaman-$AyniUrlEnd[1]>=300){//5dk fark varsa
        $VarolanHitInfo[]=[$url,$Zaman,1,array_key_last ($VarolanHitInfo)+1];
      }else{
        $VarolanHitInfo[$AyniUrlEnd[3]][2]+=1;        
      }
      


      $JsonHitInfo=json_encode($VarolanHitInfo);


      $sql="UPDATE hit_info SET HitInfo=?, Tiklanma = Tiklanma +1 WHERE HitID=?";
      $db->prepare($sql)->execute([$JsonHitInfo,$HitInfoRow['HitID']]);
    }else{
      $HitInfo=[];
      //$HitInfo[]=[Link,ZamanUnix,Tıklanma,Birüstİndis];
      $HitInfo[]=[$url,$Zaman,1,0];
      $HitInfo=json_encode($HitInfo);
      $Tiklanma=1;
      $sql="INSERT INTO hit_info SET IP=?, Gun=?, Zaman=?, HitInfo=?, Tiklanma=?";
      $db->prepare($sql)->execute([$Ip,$Gun,$Zaman,$HitInfo,$Tiklanma]);
    }
    
  }
#Site Hit İşlem ===================== }


#Diller gel ========== {
  $Diller=[];
  $where=$DNCrud->qSql("SELECT langs.LangID, langs.LangKateID, langs.Sira, lang_category.Lang, lang_category.LangSeo, lang_category.LangName, lang_category.LangGosterimAdi, lang_category.Resim FROM langs INNER JOIN lang_category ON langs.LangKateID = lang_category.LangKateID WHERE Status=1 ORDER BY langs.Sira ASC");
  while($row=$where->fetch(PDO::FETCH_ASSOC)){ 

      if($row['Resim']) {
        $Resimlinki=BASE_URL.SitePath."images/flags/".$row['Resim'];
      }else{
        $Resimlinki=BASE_URL.SitePath."images/noimage.png";
      }
      $Link=BASE_URL.$row['LangSeo'];
      $row+=["Resimlinki"=>$Resimlinki,"Link"=>$Link];
   
         
    $Diller[]=$row;
  }
#Diller gel ========== }


#Menü Listeleme işlemi için ========== {
    $Menuler=[]; 
    $where=$DNCrud->ReadData("menu",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>" WHERE UstMenuID=0 AND Durum=1"]);
    while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
        $sql1=$DNCrud->ReadAData("menu_lang","MenuID",$row['MenuID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("menu_lang","MenuID",$row['MenuID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("menu_lang","MenuID",$row['MenuID']);
          }
        }
        $row1=$sql1->fetch(PDO::FETCH_ASSOC); 

        $where2=$DNCrud->ReadData("menu",["sql"=>" WHERE UstMenuID=".$row['MenuID']]);
        $AltVarmi=$where2->rowCount();
        if($AltVarmi){$AltVarmi=1;}else{$AltVarmi=0;}

        $Name=$row1['Name'];
        $ID=$row1['MenuID'];
        $Link=SmartUrl($row1['Link']);
        $UrunSayisi=0;

        $Menuler[]=["Name"=>$Name, "Icon"=>$row['Icon'], "ID"=>$ID,"Link"=>$Link,"AltVarmi"=>$AltVarmi,"UrunSayisi"=>$UrunSayisi,"AltMenuler"=>[]];
        $where12=$DNCrud->ReadData("menu",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>" WHERE Durum=1 AND UstMenuID=".$row['MenuID']]);

        while($ust_row=$where12->fetch(PDO::FETCH_ASSOC)){
          $ust_sql1=$DNCrud->ReadAData("menu_lang","MenuID",$ust_row['MenuID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$ust_sql1->rowCount()) {
            $ust_sql1=$DNCrud->ReadAData("menu_lang","MenuID",$ust_row['MenuID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$ust_sql1->rowCount()){ $ust_sql1=$DNCrud->ReadAData("menu_lang","MenuID",$ust_row['MenuID']); }
          }
          $altmenu_lang=$ust_sql1->fetch(PDO::FETCH_ASSOC);              
          $Name=$altmenu_lang['Name'];
          $ID=$altmenu_lang['MenuID'];    
          $Link=SmartUrl($altmenu_lang['Link']);
          $Menuler[array_key_last($Menuler)]["AltMenuler"][]=["Name"=>$Name,"ID"=>$ID,"Link"=>$Link,"UrunSayisi"=>$UrunSayisi];            
        }
    } 
#Menü Listeleme işlemi için ========== }


      
#Social ======================= {
  $sql=$DNCrud->ReadAData("social_lang","LangID",$AktifLangID); 
  if(!$sql->rowCount()) {
    $sql=$DNCrud->ReadAData("social_lang","LangID",$DefaultLangID);
    if(!$sql->rowCount()) {
      $sql=$DNCrud->ReadData("social_lang");
    }
  }
  $SocialRow=$sql->fetch(PDO::FETCH_ASSOC);
#Social ======================= }




#SEO
$PageUrl=SITE_URL;
$PageTitle=$SiteAyarGel['Title'];
$PageKeywords=$SiteAyarGel['Keywords'];
$PageDescription=$SiteAyarGel['Description'];
$PageCanonial=$PageUrl;
$HeaderMeta=$SiteAyarGel['Metalar'];
$FooterMeta=$SiteAyarGel['Metalar2'];
$PageSocialImages=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG2'];
$PageBanner=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG1'];
$NoImg=BASE_URL.SitePath."images/bg/".$SiteResimleri['BG3'];