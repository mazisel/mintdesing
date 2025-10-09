<?php
#Sayfa Seo ======{
  $MyID=75;
  $sql=$DNCrud->ReadAData("seo_ayar","MyID",$MyID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);$SeoID=$SeoAyar['SeoID'];
  $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
  if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); } }
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




#KAYIT Ol ============================ {
  if(isset($_POST['basvuru_yap'])){   
    $firma_adi=htmlspecialchars($_POST['f_name']);
    $firma_yetkili=htmlspecialchars($_POST['ad_soyad']);
    $firma_gsm=htmlspecialchars($_POST['gsm']);
    $firma_wp=htmlspecialchars($_POST['wp_hat']);
    $firma_tel=htmlspecialchars($_POST['tel']);
    $FirmaEmail=htmlspecialchars($_POST['mail']);
    $firma_web_site=htmlspecialchars($_POST['web']);
    $firma_il=htmlspecialchars($_POST['il']);
    $firma_ilce=htmlspecialchars($_POST['ilce']);
    $firma_adres=htmlspecialchars($_POST['adres']);
    $firma_vergi_dairesi=htmlspecialchars($_POST['vdaire']);
    $firma_vergi_no=htmlspecialchars($_POST['vno']);
    $firma_nick=htmlspecialchars($_POST['nick']);
    $firma_pass=htmlspecialchars($_POST['pass']);
    $k_soz=htmlspecialchars($_POST['ksoz']);
    $cerez_p=htmlspecialchars($_POST['csoz']);
    $iptal_soz=htmlspecialchars($_POST['iptaliade']);
    $gizlilik_p=htmlspecialchars($_POST['gizliplt']);


    if(empty($firma_adi) || empty($firma_yetkili) || empty($firma_gsm) || empty($FirmaEmail) || empty($firma_il) || empty($firma_ilce) || empty($firma_adres) || empty($firma_pass) || $k_soz==0 || $cerez_p==0 || $iptal_soz==0 || $gizlilik_p==0 ){
      $result =  [
      'sonuc' => "error",
      'title' =>$W75_Text3,
      'subtitle' =>$W75_Text10,
      'btn' =>$W75_Text2,
      "neden"=>'bilinmiyor',
      "yap"=>""];
      echo json_encode($result);die();
    }
      $UyeType=1;

    #Form Verilerini Kontrol et ======================== {      

        #Kontroller ==================== {
          //Mail kontrol
            if(!filter_var($FirmaEmail, FILTER_VALIDATE_EMAIL)){
              $result =  [
                'sonuc' => "error",
                'icon' => "warning",                    
                'title' =>$W75_Text3,
                'subtitle' =>$W75_Text11,
                'btn' =>$W75_Text2,
                'icon'=>"warning",
                'neden' => "maildegil"
              ];echo json_encode($result);die();
            }
 
          #Üye Varmı yok mu =============== {
            $data_where=$db->prepare("SELECT * FROM firmalar WHERE FirmaEmail=?");
            $data_where->execute(array($FirmaEmail));
            $mail_say=$data_where->rowCount();
            if($mail_say>0) { 
               $result =  [
                'sonuc' => "error",
                'title' =>$W75_Text3,
                'subtitle' =>$W75_Text5,
                'btn' =>$W75_Text2,
                "neden"=>'mailvar',
                "yap"=>""];
                echo json_encode($result);die();
            }
          #Üye Varmı yok mu =============== }
          #Şifreler Aynımı 6 karekterden büyükmü ================ {
           
            if(strlen($firma_pass)<6){
              $array =  [
                'sonuc' => "error",
                'title' =>$W75_Text3,
                'subtitle' =>$W75_Text7,
                'btn' =>$W75_Text2,
                "neden"=>'paskucuk',
                "yap"=>""];
                echo $json=json_encode($array);die();
            }
          #Şifreler Aynımı 6 karekterden büyükmü ================ }
       
        #Kontroller ==================== }
          $KayitTarihi = date('Y-m-d H:i:s');
          $UyeIP       = gercekip();
          $DATA=[
            "FirmaAd"=>$firma_adi,
            "FirmaYetkili"=>$firma_yetkili,
            "FirmaGsm"=>$firma_gsm,
            "FirmaWp"=>$firma_wp,
            "FirmaTel"=>$firma_tel,
            "FirmaEmail"=>$FirmaEmail,
            "FirmaWeb"=>$firma_web_site,
            "FirmaSehir"=>$firma_il,
            "FirmaIlce"=>$firma_ilce,
            "FirmaAdres"=>$firma_adres,
            "FirmaVergiDairesi"=>$firma_vergi_dairesi,
            "FirmaVergiNo"=>$firma_vergi_no,
            "Ksoz"=>$k_soz,
            "Cerezp"=>$cerez_p,
            "Iptalp"=>$iptal_soz,
            "Gizlilikp"=>$gizlilik_p,
            "FirmaKayitTarihi"=>$KayitTarihi,
            "FirmaIP"=>$UyeIP,
            "Status"=>0 #onay bekliyor
          ];
          $sonuc=$DNCrud->insert("firmalar",$DATA);
          if($sonuc['status']){            
            $FirmaID =$sonuc['LastID'];
            $FirmaCode=$FirmaID.rand(0,9).rand(0,9);
            #$FirmaEmailOnayKod='O'.$FirmaID.rand(1,10000).$FirmaID;
            $DNCrud->update("firmalar",["FirmaID"=>$FirmaID, "FirmaCode"=>$FirmaCode ],["colomns" => "FirmaID"]);

            //User oluşturulacak
            $DATAUser=[
              'FirmaID'=>$FirmaID,
              'UserNick'=>$firma_nick,
              'UserName'=>$firma_yetkili,
              'UserEmail'=>$FirmaEmail,
              'UserPass'=>$firma_pass,
              'UserTel'=>$firma_tel,
              'UserIP'=>$UyeIP,
              'UserDate'=>$KayitTarihi,
              'UserIP'=>$UyeIP,
              'Status'=>1
            ];
            $sonuc=$DNCrud->insert("firma_user",$DATAUser,["sifrele" => "UserPass"]);
            
            //üye mail gonder
            $Baslik='Başvurunuz Alındı';
            $MesajIcerik="
              Sayin {$firma_yetkili} <br>
              Başvurunuzu aldık <br>
              Firma Kodunuz: {$FirmaCode} <br>
              Hesabınızı onayladığımızda başvuruda girdiğiniz kullanıcı adı ve şifrenizle giriş yapabilirisiniz
            ";       
            $MailSonuc=mailSend(['title'=>$Baslik, 'content'=>$MesajIcerik, 'eMails'=>[$FirmaEmail], 'adminSend'=>1]);


            /*
            #Oturum aç
            $_SESSION['FirmaLogin']=[
              'FirmaID'=>$FirmaID,
              'FirmaCode'=>$FirmaCode,
              'UserNick'=>$firma_nick,
              'UserEmail'=>$FirmaEmail
            ];*/
            $result = ['sonuc' => "success", 
            'title' =>$W75_Text12, 
            'btn' =>$W75_Text2, "url"=>SITE_URL.$URLFirmaAccount];
            echo json_encode($result);die();
          }else{
            $result =  [
              'sonuc' => "error",
              'title' =>$W75_Text3,
              'subtitle' =>$W75_Text9,
              'btn' =>$W75_Text2,
              "neden"=>$sonuc,
              "yap"=>""];
            echo json_encode($result);die();
          }    
    die();
  }
#KAYIT Ol ============================ }

#Giriş Yap =========================== {
  if(isset($_POST['giris_yap']))
  {

    if($SistemVersiyon==1){
      $FirmaCode=intval($_POST['companycode']);
    }
    if($SistemVersiyon==2){
      $FirmaCode=1347;
    }
    $UserEmail=htmlspecialchars($_POST["mail"]);
    $FirmaPass=htmlspecialchars($_POST["pass"]);
    $RememberMe=htmlspecialchars($_POST["beni_hatirla"]);
    $goback=htmlspecialchars($_POST["goback"]);

    $sorgu=$db->prepare("SELECT * FROM firmalar WHERE FirmaCode=? AND Status=1");    
    $sorgu->execute([$FirmaCode]);             
    if(!$sorgu->rowCount()){
      $result =  [
        'sonuc' => "error", 'icon' =>'warning',
        'title' =>$W75_Text54,            
        'subtitle' =>$W75_Text55,
        'btn' =>$W75_Text2
      ];
      echo json_encode($result);die();
    }
    $FirmaRow=$sorgu->fetch(PDO::FETCH_ASSOC);

    if($UserEmail && $FirmaPass)
    {
    //Form Dolu Geldiyse Start   
      $data_where=$db->prepare("SELECT * FROM firma_user WHERE UserEmail=? OR UserNick=? AND UserPass=? AND FirmaID=?");    
      $data_where->execute([$UserEmail,$UserEmail,md5($FirmaPass),$FirmaRow['FirmaID']]);             
      $uye_say=$data_where->rowCount();      
      if($uye_say>0)
      {
        #Kullanıcı adı şifre doğru START 
          $firma_row=$data_where->fetch(PDO::FETCH_ASSOC);
          if($firma_row['Status']==1){
            #Beni Hatırla ============ {
              if (!empty($RememberMe) && $RememberMe==1){
                  $cookie= [
                    "FirmaID"=>$firma_row['FirmaID'],
                    "UserEmail"=>$firma_row['UserEmail'],
                    "UyeSifre"=>openssl_encrypt($FirmaPass, "AES-128-ECB", "Sifreyi_coz")
                  ];
                  setcookie("FirmaLogin",json_encode($cookie),strtotime("+45 day"),"/");
              }
            #Beni Hatırla ============ }
            $SonGiris=date('Y-m-d H:i:s');          
            $sql= "UPDATE firma_user SET SonGiris=?,UserIP=? WHERE UserID=?";
            $db->prepare($sql)->execute([$SonGiris,$IP,$firma_row['UserID']]);
            $_SESSION['FirmaLogin']=[
              'FirmaID'=>$firma_row['FirmaID'],
              'UserEmail'=>$firma_row['UserEmail'],
              'UserNick'=>$firma_row['UserNick']
            ];
       
            
   
            if(isset($goback) AND !empty($goback)){$URL=$goback; }else{$URL=SITE_URL.$URLFirmaAccount;}
             $result =  [
              'sonuc' => "success",
              'icon' =>'success',
              'title' =>$W75_Text14,            
              'btn' =>$W75_Text2,
              "url"=>$URL];
            echo json_encode($result);die();
          }else{
            $array =  [
              'sonuc' => "error",
              'icon' =>'warning',
              'title' =>$W75_Text15,
              'subtitle' =>$W75_Text16,
              'btn' =>$W75_Text2,
              'neden' =>"yasakli",
              "url"=>""];
            echo $json=json_encode($array);die();
          }
        #Kullanıcı adı şifre doğru END     
      }else{ 
        #Kullanıcı adı şifre yanlış START
          $result =  [
            'sonuc' => "error",
            'icon' =>'warning',
            'title' =>$W75_Text17,
            'subtitle' =>$W75_Text18,
            'btn' =>$W75_Text2,
            'neden' =>"yanlisbilgiler",
            "url"=>""];
          echo json_encode($result);die();
        #Kullanıcı adı şifre yanlış START
      }
    //Form Dolu Geldiyse END
    }else{  
    //Form Dolu DEil Mail Şifre Start  
      $result =  [
            'sonuc' => "error",
            'icon' =>'warning',
            'title' =>$W75_Text9,
            'subtitle' =>$W75_Text10,
            'btn' =>$W75_Text2,
            'neden' =>"bosveri",
            "url"=>""];
          echo json_encode($result);die();
    //Form Dolu DEil Mail Şifre END
    } 
    die();
  }
#Giriş Yap =========================== }

