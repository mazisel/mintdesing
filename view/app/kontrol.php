<?php
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


#SESSION KONTROL ================================== {   
  if (isset($_SESSION["FirmaLogin"])) {
    $UserEmail=$_SESSION["FirmaLogin"]['UserEmail'];
    $data_uye=$db->prepare("SELECT * FROM firma_user WHERE UserEmail=?");
    $data_uye->execute([$UserEmail]);
    $FirmaUserVar=$data_uye->rowCount();    
    if ($FirmaUserVar) {
      $UyeRow=$data_uye->fetch(PDO::FETCH_ASSOC);

      $data_uye=$db->prepare("SELECT * FROM firmalar WHERE FirmaID=? AND FirmaDelete=0");
      $data_uye->execute([$UyeRow['FirmaID']]);
      $Firma=$data_uye->fetch(PDO::FETCH_ASSOC);
      $FirmaID=$Firma['FirmaID'];
    }else{$FirmaUserVar=0; $FirmaID=false; }
  }elseif(isset($_COOKIE['FirmaLogin'])){    
    #Cooki ile giirş yap START
      $Login=json_decode($_COOKIE['FirmaLogin']);
      $data_uye=$db->prepare("SELECT * FROM firma_user WHERE UserEmail=? AND UyeSifre=? AND FirmaDelete=0");
      $data_uye->execute([$Login->UserEmail,md5(openssl_decrypt($Login->UyeSifre, "AES-128-ECB", "Sifreyi_coz"))]);
      $FirmaUserVar=$data_uye->rowCount();
      if ($FirmaUserVar) {
        $UyeRow=$data_uye->fetch(PDO::FETCH_ASSOC);
        $data_uye=$db->prepare("SELECT * FROM firmalar WHERE FirmaID=? AND FirmaDelete=0");
        $data_uye->execute([$UyeRow['FirmaID']]);
        $Firma=$data_uye->fetch(PDO::FETCH_ASSOC);
        $FirmaID=$Firma['FirmaID'];
        $_SESSION['FirmaLogin']=[
          'FirmaID'=>$Firma['FirmaID'],
          'UserEmail'=>$UyeRow['UserEmail'],
          'UserNick'=>$UyeRow['UserNick']
        ];
        $FirmaID=$Firma['FirmaID']; 
      }else{$FirmaUserVar=0; $FirmaID=false; }
    #Cooki ile giirş yap END
  }else{  $FirmaUserVar=0; $FirmaID=false;   }
#SESSION KONTROL ================================== }
if(!isset($_SESSION['FirmaLogin']) || empty($_SESSION['FirmaLogin']) || !$Firma) {
  header('location: '.SITE_URL.$W_URLHome);die();
}



  $SeoPageLang=DilGel("seo_ayar_page_lang","MyID",91);
  $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
  $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
  include './app/dil.php';
#home dil gel ======{
  $SeoPageLang=DilGel("seo_ayar_page_lang","MyID",76);
  $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
  $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
  include 'app/dil.php';
#home dil gel ======};
#Settings dil gel ============ {
  $SeoPageLang=DilGel("seo_ayar_page_lang","MyID",77);
  $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
  $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
  include 'app/dil.php';
#Settings dil gel ============ }
#Product dil gel ====== {
  $SeoPageLang=DilGel("seo_ayar_page_lang","MyID",80);
  $SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
  $AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
  include 'app/dil.php';
#Product dil gel ====== }
#order dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",97);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#order dil gel ======}