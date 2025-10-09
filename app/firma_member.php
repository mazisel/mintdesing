<?php 

$SeoID=1;
#Sayfa Seo ======{
  if(isset($SeoID) AND $SeoID){
      $sql=$DNCrud->ReadAData("seo_ayar","SeoID",$SeoID); $SeoAyar=$sql->fetch(PDO::FETCH_ASSOC);
      $sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_lang","SeoID",$SeoID); }
       }
      $SeoLang=$sql->fetch(PDO::FETCH_ASSOC);
    #Page Veriables =========== {
      $sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
      if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData("seo_ayar_page_lang","SeoID",$SeoID); }
      }
      $SeoPageLang=$sql->fetch(PDO::FETCH_ASSOC);
      $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
      $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
      include __DIR__.'/dil.php';
    #Page Veriables =========== }
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

#Uye Giriş Yapmışsa ================================== {   
  if (isset($_SESSION["FirmaLogin"])) {
    $firma_email=$_SESSION["FirmaLogin"]['firma_email'];
    $data_uye=$db->prepare("SELECT * FROM firmalar WHERE firma_email=? AND silinmis=0");
    $data_uye->execute([$firma_email]);
    $FirmaVar=$data_uye->rowCount();    
    if ($FirmaVar) {
      $Firma=$data_uye->fetch(PDO::FETCH_ASSOC);
      $firma_id=$Firma['firma_id'];
    }else{$FirmaVar=0; $firma_id=false; }
  }elseif(isset($_COOKIE['FirmaLogin'])){    
    #Cooki ile giirş yap START
      $Login=json_decode($_COOKIE['FirmaLogin']);
      $data_uye=$db->prepare("SELECT * FROM firmalar WHERE firma_email=? AND UyeSifre=? AND silinmis=0");
      $data_uye->execute([$Login->firma_email,md5(openssl_decrypt($Login->UyeSifre, "AES-128-ECB", "Sifreyi_coz"))]);
      $FirmaVar=$data_uye->rowCount();
      if ($FirmaVar) {
        $Firma=$data_uye->fetch(PDO::FETCH_ASSOC);
        $_SESSION['FirmaLogin']=[
          'firma_id'=>$Firma['firma_id'],
          'firma_email'=>$Firma['firma_email'],
          'firma_adi'=>$Firma['firma_adi']
        ];
        $firma_id=$Firma['firma_id']; 
      }else{$FirmaVar=0; $firma_id=false; }
    #Cooki ile giirş yap END
  }else{  $FirmaVar=0; $firma_id=false;   }
#Uye Giriş Yapmışsa ================================== }

#KAYIT Ol ============================ {
  if (isset($_POST['kayit_ol'])) {
    $btn="Tamam";
    $title1=  "Kayıt Ol Başarızı!";
    $subtitle1="Lütfen 'Ben robot değilim' işaretleyiniz.";
    $subtitle2="Bu E-mail Kullanılıyor";
    $subtitle3="Şifre tekrarı aynı değil!";
    $subtitle4="Şifreniz 6 karekterden kısa olamaz!";
    $subtitle5="Lütfen Üyelik Sözleşmesini Kabul Ediniz.";
    $subtitle6="Lütfen Tekrar Deneyiniz.";
    $subtitle7="Lütfen formu eksiksiz doldurunuz.";
    $subtitle8="Lütfen doğru bir mail giriniz.";
    $title2="Kayıt Ol Başarılı.";
    $title3="İşlem Başarısız";
   
    $firma_adi=htmlspecialchars($_POST['f_name']);
    $firma_yetkili=htmlspecialchars($_POST['ad_soyad']);
    $firma_gsm=htmlspecialchars($_POST['gsm']);
    $firma_wp=htmlspecialchars($_POST['wp_hat']);
    $firma_tel=htmlspecialchars($_POST['tel']);
    $firma_email=htmlspecialchars($_POST['mail']);
    $firma_web_site=htmlspecialchars($_POST['web']);
    $firma_il=htmlspecialchars($_POST['il']);
    $firma_ilce=htmlspecialchars($_POST['ilce']);
    $firma_adres=htmlspecialchars($_POST['adres']);
    $firma_vergi_dairesi=htmlspecialchars($_POST['vdaire']);
    $firma_vergi_no=htmlspecialchars($_POST['vno']);
    $firma_pass=htmlspecialchars($_POST['sifre']);
    $k_soz=htmlspecialchars($_POST['ksoz']);
    $cerez_p=htmlspecialchars($_POST['csoz']);
    $iptal_soz=htmlspecialchars($_POST['iptaliade']);
    $gizlilik_p=htmlspecialchars($_POST['gizliplt']);


    if(empty($firma_adi) || empty($firma_yetkili) || empty($firma_gsm) || empty($firma_email) || empty($firma_il) || empty($firma_ilce) || empty($firma_adres) || empty($firma_pass) || $k_soz==0 || $cerez_p==0 || $iptal_soz==0 || $gizlilik_p==0 ){
      $result =  [
      'sonuc' => "error",
      'title' =>$title1,
      'subtitle' =>$subtitle7,
      'btn' =>$btn,
      "neden"=>'bilinmiyor',
      "yap"=>""];
      echo json_encode($result);die();
    }
      $UyeType=1;

    #Form Verilerini Kontrol et ======================== {      

        #Kontroller ==================== {
          //Mail kontrol
            if(!filter_var($firma_email, FILTER_VALIDATE_EMAIL)){
              $result =  [
                'sonuc' => "error",
                'icon' => "warning",                    
                'title' =>$title1,
                'subtitle' =>$subtitle8,
                'btn' =>$btn,
                'icon'=>"warning",
                'neden' => "maildegil"
              ];echo json_encode($result);die();
            }
          //reCAPTCHA kontrol
            // if($SiteAyarSabit['reCAPTCHA']==1){
            //   $r=$_POST['recaptcha-cevap'];
            //   $url="https://www.google.com/recaptcha/api/siteverify"; 
            //   $s_key=$SiteAyarSabit['reCAPTCHASecretKey']; 
            //   $ip=gercekip();
            //   $gidecek_adres=$url."?secret=".$s_key."&response=".$r."&remoteip=".$ip;
            //   $res=file_get_contents($gidecek_adres);
            //   $res=json_decode($res,true);
            //   if($res['success']){  }else{ 
            //       $result =  [
            //       'sonuc' => "error",
            //       'icon' => "warning",                    
            //       'title' =>$title1,
            //       'subtitle' =>$subtitle1,
            //       'btn' =>$btn,
            //       'icon'=>"warning",
            //       'neden' => "robot"
            //     ];echo json_encode($result);die();
            //   }
            // }
          #Üye Varmı yok mu =============== {
            $data_where=$db->prepare("SELECT * FROM firmalar WHERE firma_email=?");
            $data_where->execute(array($firma_email));
            $mail_say=$data_where->rowCount();
            if($mail_say>0) { 
               $result =  [
                'sonuc' => "error",
                'title' =>$title1,
                'subtitle' =>$subtitle2,
                'btn' =>$btn,
                "neden"=>'mailvar',
                "yap"=>""];
                echo json_encode($result);die();
            }
          #Üye Varmı yok mu =============== }
          #Şifreler Aynımı 6 karekterden büyükmü ================ {
           
            if(strlen($firma_pass)<6){
              $array =  [
                'sonuc' => "error",
                'title' =>$title1,
                'subtitle' =>$subtitle4,
                'btn' =>$btn,
                "neden"=>'paskucuk',
                "yap"=>""];
                echo $json=json_encode($array);die();
            }
          #Şifreler Aynımı 6 karekterden büyükmü ================ }
       
        #Kontroller ==================== }
          $KayitTarihi = date('Y-m-d H:i:s');
          $UyeIP       = gercekip();
          $DATA=[
            "firma_adi"=>$firma_adi,
            "firma_yetkili"=>$firma_yetkili,
            "firma_gsm"=>$firma_gsm,
            "firma_wp"=>$firma_wp,
            "firma_tel"=>$firma_tel,
            "firma_email"=>$firma_email,
            "firma_web_site"=>$firma_web_site,
            "firma_il"=>$firma_il,
            "firma_ilce"=>$firma_ilce,
            "firma_adres"=>$firma_adres,
            "firma_vergi_dairesi"=>$firma_vergi_dairesi,
            "firma_vergi_no"=>$firma_vergi_no,
            "firma_pass"=>$firma_pass,
            "k_soz"=>$k_soz,
            "cerez_p"=>$cerez_p,
            "iptal_soz"=>$iptal_soz,
            "gizlilik_p"=>$gizlilik_p,
            "firma_date"=>$KayitTarihi,
            "firma_ip"=>$UyeIP,
            "status"=>1#onayli
          ];
          $sonuc=$DNCrud->insert("firmalar",$DATA,["sifrele" => "firma_pass"]);
          if($sonuc['status']){
            $firma_id =$sonuc['LastID'];
            $firma_kod=$firma_id.rand(99,999);
            #$firma_emailOnayKod='O'.$firma_id.rand(1,10000).$firma_id;
            $DNCrud->update("firmalar",["firma_id"=>$firma_id, "firma_kod"=>$firma_kod ],["colomns" => "firma_id"]);
      
            $_SESSION['FirmaLogin']=[
              'firma_id'=>$firma_id,
              'firma_email'=>$firma_email,
              'firma_adi'=>$firma_adi
            ];
            $result = ['sonuc' => "success", 'title' =>$title2, 'btn' =>$btn, "url"=>SITE_URL.$URLFirmaAccount];
            echo json_encode($result);die();
          }else{
            $result =  [
              'sonuc' => "error",
              'title' =>$title1,
              'subtitle' =>$subtitle6,
              'btn' =>$btn,
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

    $firma_email=htmlspecialchars($_POST["mail"]);
    $password=htmlspecialchars($_POST["sifre"]);
    $RememberMe=htmlspecialchars($_POST["beni_hatirla"]);
    $goback=htmlspecialchars($_POST["goback"]);
  
    if($firma_email && $password)
    {
    //Form Dolu Geldiyse Start
      $data_where=$db->prepare("SELECT * FROM firmalar WHERE firma_email=? AND firma_pass=? AND silinmis=0");    
      $data_where->execute([$firma_email,md5($password)]);             
      $uye_say=$data_where->rowCount();
      if($uye_say>0)
      {
        #Kullanıcı adı şifre doğru START 
          $firma_row=$data_where->fetch(PDO::FETCH_ASSOC);
          if($firma_row['status']==1){
            #Beni Hatırla ============ {
              if (!empty($RememberMe) && $RememberMe==1){
                  $cookie= [
                    "firma_id"=>$firma_row['firma_id'],
                    "firma_email"=>$firma_row['firma_email'],
                    "UyeSifre"=>openssl_encrypt($password, "AES-128-ECB", "Sifreyi_coz")
                  ];
                  setcookie("FirmaLogin",json_encode($cookie),strtotime("+45 day"),"/");
              }
            #Beni Hatırla ============ }
            $son_giris_tarih=date('Y-m-d H:i:s');
            $sql= "UPDATE firmalar SET son_giris_tarih=?,firma_ip=? WHERE firma_id=? AND silinmis=0";
            $db->prepare($sql)->execute([$son_giris_tarih,$IP,$firma_row['firma_id']]);
            $_SESSION['FirmaLogin']=[
              'firma_id'=>$firma_row['firma_id'],
              'firma_email'=>$firma_row['firma_email'],
              'firma_adi'=>$firma_row['firma_adi']
            ];
   
            if(isset($goback) AND !empty($goback)){$URL=$goback; }else{$URL=SITE_URL.$URLFirmaAccount;}
             $result =  [
              'sonuc' => "success",
              'icon' =>'success',
              'title' =>"Giriş Başarılı",            
              'btn' =>"Tamam",
              "url"=>$URL];
            echo json_encode($result);die();
          }else{
            $array =  [
              'sonuc' => "error",
              'icon' =>'warning',
              'title' =>"Giriş Yapılamadı",
              'subtitle' =>"Yasaklı Hesap!",
              'btn' =>"Tamam",
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
            'title' =>"Giriş Başarısız!",
            'subtitle' =>"Kullanıcı Adı veya Şifre yanlış",
            'btn' =>"Tamam",
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
            'title' =>$W1_Variable28,
            'subtitle' =>$W1_Variable31,
            'btn' =>$W1_Variable26,
            'neden' =>"bosveri",
            "url"=>""];
          echo json_encode($result);die();
    //Form Dolu DEil Mail Şifre END
    } 
    die();
  }
#Giriş Yap =========================== }

#Güvenli Cıkış ==================== {
  if (isset($_GET['safe-exit'])) {
    $_SESSION['FirmaLogin'] = NULL;
    unset($_SESSION['FirmaLogin']);
    #Beni Hatırla varsa
    if (isset($_COOKIE['FirmaLogin'])) {
      setcookie("FirmaLogin",$_COOKIE['FirmaLogin'],strtotime("-45 day"),"/");
    }  
    header('Location: '.SITE_URL.$W_URLHome);exit;
  }
#Güvenli Cıkış ==================== }  

#Şifre Sıfırla Linkyolla ===================== {
  if(isset($_POST['sifre_unuttum'])){
      $eposta=htmlspecialchars($_POST['unutulan_mail']);
      $sql=$DNCrud->ReadAData("firmalar", "komutyok",0, ["ikincikosul"=>"WHERE firma_email='{$eposta}' AND silinmis=0"]);
      if ($sql->rowCount()) {
        #Girilen E-Posta varsa ====== {
          $firma_row=$sql->fetch(PDO::FETCH_ASSOC);
          $firma_id=$firma_row['firma_id'];
          $firma_email=$firma_row['firma_email'];        
          $Name=$firma_row['UyeAdi'];        
          $PassCode=md5(uniqid(mt_rand(), true));          
          $result=$DNCrud->update("firmalar",["firma_id"=>$firma_id, "PassCode"=>$PassCode,"PassCodeKullanim"=>0],["colomns" => "firma_id"]);
          if ($result["status"]) {
            #Mail Gönder ================== {
              //include 'config/mail.send.php';
              $sql=$DNCrud->ReadAData("taslaklar","TaslakID",15); 
              $row=$sql->fetch(PDO::FETCH_ASSOC);
              $sql1=$DNCrud->ReadAData("taslaklar_lang","TaslakID",$row['TaslakID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
              if(!$sql1->rowCount()){
                $sql1=$DNCrud->ReadAData("taslaklar_lang","TaslakID",$row['TaslakID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
                if(!$sql1->rowCount()){$sql1=$DNCrud->ReadAData("taslaklar_lang","TaslakID",$row['TaslakID']); }
              }
              $taslak_lang_row=$sql1->fetch(PDO::FETCH_ASSOC);
              $baslik=$taslak_lang_row['TaslakAdi'];
              $taslak_html =$taslak_lang_row["TaslakIcerigi"];
              $NewPasLink=SITE_URL.$URLFirmaLogin."?newpas&scode=".$PassCode;
              $HtmlTaslak=str_replace("{NewPasLink}",$NewPasLink,$taslak_html);
              $HtmlTaslak=str_replace("{firma_email}",$firma_email,$HtmlTaslak);
              $HtmlTaslak=str_replace("{Name}",$Name,$HtmlTaslak);
              if($row['SendDurum']==1){ $MailSonuc=mail_gonder($baslik,$HtmlTaslak,$firma_email,0); }
            #Mail Gönder ================== }
            $result = ['sonuc' => "success", 'icon'=>"success",
            'title' =>$W1_Variable43,//"İşlem Başarılı.",
            'subtitle' =>$W1_Variable44,//"E-Posta adresinize şifre sıfırlama linki gönderdik.",
            'btn' =>$W1_Variable26];echo json_encode($result);die();
          }else{
              $array =  [
                'sonuc' => "error",'icon'=>"warning",
                'title' =>$W1_Variable45,//"İşlem Başarısız!",//$W1_Variable65,//"İşlem Başarısız!",
                'subtitle' =>$W1_Variable46,//"Şifre sıfırlama yapılırken bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz",
                'btn' =>$W1_Variable26,
                "neden"=>'update yapılamadı',
                "yap"=>""];
                echo $json=json_encode($array);die();            
          }
        #Girilen E-Posta varsa ====== }
      }else{
            $array =  [
              'sonuc' => "error",'icon'=>"warning",
              'title' =>$W1_Variable45,//"İşlem Başarısız!",
              'subtitle' =>$W1_Variable47,//"Girilen E-Posta ile kayıt bulunamadı",
              'btn' =>$W1_Variable26,
              "neden"=>'epostayok',
              "yap"=>""];
              echo $json=json_encode($array);die();
            
      }  
  }
#Şifre Sıfırla Linkyolla ===================== }

#Şifre Sıfırlama linki geldi =============== {
  if (isset($_GET['newpas'])) {
    $PassCode=htmlspecialchars($_GET['scode']);
    $sql=$DNCrud->ReadAData("firmalar","PassCode",$PassCode,["ikincikosul"=> " AND silinmis=0"]);
    if ($sql->rowCount()) {
       #Bu Şifre sıfırlama kodu var =============== {
         $GelenUye=$sql->fetch(PDO::FETCH_ASSOC);
         $GelenFirmaVar=1;
       #Bu Şifre sıfırlama kodu var =============== }
     }else{
       #Bu Şifre sıfırlama kodu yok =============== {
        $GelenFirmaVar=0;
       #Bu Şifre sıfırlama kodu yok =============== }
     }    
  }
#Şifre Sıfırlama linki geldi =============== }

#New Şifre Sıfırla ===================== {
  if(isset($_POST['yeni_sifre_belirle'])){

      $password1=htmlspecialchars($_POST['password1']);
      $password2=htmlspecialchars($_POST['password2']);
      $firma_email=htmlspecialchars($_POST['firma_email']);
      $PassCode=htmlspecialchars($_POST['pastoken']);

      if($password1!=$password2){
        $array =  [
          'sonuc' => "error",'icon'=>"warning",
          'title' =>$W1_Variable54,//"Şifre Sıfırlama Başarısız!",
          'subtitle' =>$W1_Variable55,//"Şifre tekrarı yanlış",
          'btn' =>$W1_Variable26,
          "neden"=>'pas2no',
          "yap"=>""];
          echo $json=json_encode($array);die();
      }
      if(strlen($password1)<6){
        $array =  [
          'sonuc' => "error",'icon'=>"warning",
          'title' =>$W1_Variable54,//"Şifre Sıfırlama Başarısız!",
          'subtitle' =>$W1_Variable56,//"Şifre 6 karakterden kısa olamaz",
          'btn' =>$W1_Variable26,
          "neden"=>'paskucuk',
          "yap"=>""];
          echo $json=json_encode($array);die();
      }else{
        $UyeSifre=$password1;
      }
   
      $sql=$DNCrud->ReadData("firmalar",["sql"=>"WHERE firma_email='{$firma_email}' AND PassCode='{$PassCode}' AND silinmis=0"]);
      if ($sql->rowCount()){

        $_POST2=["firma_email"=>$firma_email, "UyeSifre"=>$UyeSifre, "PassCodeKullanim"=>1];
        $result=$DNCrud->update("firmalar",$_POST2,["colomns"=>"firma_email","sifrele" => "UyeSifre"]);
        if ($result["status"]) {
            $result =  [
            'sonuc' => "success", 'icon'=>"success",
            'title' =>$W1_Variable57,//"Şifre Sıfırlama İşlemi Başarılı",
            'subtitle' =>$W1_Variable58,//"Artık yeni şifrenizle giriş yapabilirisiniz.",
            'btn' =>$W1_Variable26];
            echo json_encode($result);die();
        }else{
            $result =  [
            'sonuc' => "error",
            'title' =>$W1_Variable54,//"Şifre Sıfırlama Başarısız!",
            'subtitle' =>$W1_Variable59,//"Lütfen tekrar deneyiniz",
            'btn' =>$W1_Variable26,
            "neden"=>'',
            "yap"=>""];
            echo json_encode($result);die();
        }
       
      }else{
           $result =  [
            'sonuc' => "error",
            'title' =>$W1_Variable54,//"Şifre Sıfırlama Başarısız!",
            'subtitle' =>$W1_Variable59,//"Lütfen tekrar deneyiniz",
            'btn' =>$W1_Variable26,
            "neden"=>'',
            "yap"=>""];
            echo json_encode($result);die();
      }


        
  }
#New Şifre Sıfırla ===================== }
