<?php 
/**
 * @author DEVNanotek
 * @copyright 2020
 */
 
#Seviye Adı ==== {
    function seviyeadi_lang($value)
    {
        global $BP_Variable52;
        global $BP_Variable53;
        global $BP_Variable54;
        global $BP_Variable55;
        global $BP_Variable61;
        global $BP_Variable65;
        global $BP_Variable116;
        switch ($value) {
            case 1: $r= $BP_Variable52;  break;
            case 2: $r= $BP_Variable53;  break;
            case 3: $r= $BP_Variable54;  break;
            case 4: $r= $BP_Variable55;  break;                 
            case 5: $r= $BP_Variable61;  break;                 
            case 6: $r= $BP_Variable65;  break;                 
            case 7: $r= $BP_Variable116;  break;                
            case 8: $r= "Kurye";  break;                
            case 9: $r= "Customize";  break;                
            default: $r= $BP_Variable52; break;
        } return $r;
    }
#Seviye Adı ==== }

#BolumGoster ==== {
  function BolumGoster($MasaCode)
  {   global $DNCrud,$AktifLangID,$FirmaLangID,$PP_Variable9;
       $query2=$DNCrud->ReadData("firma_masalar",["sql"=>"WHERE MasaCode='".$MasaCode."'"]);
       if($query2->rowCount()) {
       $MasaRow=$query2->fetch(PDO::FETCH_ASSOC);
        $where=$DNCrud->ReadData("firma_bolum",["colomns_name"=>"Sira","colomns_sort"=>"ASC","sql"=>"WHERE BolumID=".$MasaRow['BolumID']]);
        $Bolumler=$where->fetch(PDO::FETCH_ASSOC); 
         $sql1=$DNCrud->ReadAData("firma_bolum_lang","BolumID",$Bolumler['BolumID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("firma_bolum_lang","BolumID",$Bolumler['BolumID'],["ikincikosul"=>"AND LangID=".$FirmaLangID]);
          }
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("firma_bolum_lang","BolumID",$Bolumler['BolumID']);
          }
          $BolumlerLang=$sql1->fetch(PDO::FETCH_ASSOC); 
         return $BolumlerLang['Name'];
       }else{
           return $PP_Variable9;
       }
  }
#BolumGoster ==== }

#MAsa oturum kapat
  function masaoturumkapat($Name,$Token,$MasaCode,$FirmaCookie)
  {
    $cookie= [$Name,$Token,$MasaCode];    
    setcookie($FirmaCookie."Client",json_encode($cookie),time() - 28800,"/");
    $_SESSION[$FirmaCookie.'Name']=NULL;
    $_SESSION[$FirmaCookie.'MasaCodeIlk']=NULL;
    $_SESSION[$FirmaCookie.'MasaCode']=NULL;
    $_SESSION[$FirmaCookie.'GelenUrl']=NULL;
    $_SESSION[$FirmaCookie.'Token']=NULL;
    $_SESSION[$FirmaCookie.'PIN']=NULL;
    $_SESSION[$FirmaCookie.'OkutulanQr']=NULL;

    unset($_SESSION[$FirmaCookie.'Name']);
    unset($_SESSION[$FirmaCookie.'MasaCodeIlk']);
    unset($_SESSION[$FirmaCookie.'MasaCode']);
    unset($_SESSION[$FirmaCookie.'GelenUrl']);    
    unset($_SESSION[$FirmaCookie.'Token']); 
    unset($_SESSION[$FirmaCookie.'PIN']); 
    unset($_SESSION[$FirmaCookie.'OkutulanQr']); 
  }
#/MAsa oturum kapat

#Ödeme Yöntemi Adı
  function YontemNe($value)
  {
    global $BP_Variable25;
    global $BP_Variable26;
    global $BP_Variable27;
    global $PP_Variable19;
    switch ($value) {
      case 1: $y=$BP_Variable25; break;
      case 2: $y=$BP_Variable26; break;
      case 3: $y=$BP_Variable27; break;
      case 4: $y=$PP_Variable19; break;    
    }
    return $y;
  }
#/Ödeme Yöntemi Adı

#Bakiye hesapla
  function yenibakiye_fnk($SiparisID)
  { global $DNCrud,$FirmaID;
      $SiparisToplam=0;
      $query=$DNCrud->ReadAData("firma_siparisleri","SiparisID",$SiparisID);           
        $Siparis=$query->fetch(PDO::FETCH_ASSOC); 
        $SiparisDetay=unserialize($Siparis["Siparis"]);       
        for ($s=0; $s < @count($SiparisDetay); $s++) { 
            if($SiparisDetay[$s]['Status']=="old" AND $SiparisDetay[$s]['Ikram']==0){
              $EskiVar="var";
              $ToplamFiyat = $SiparisDetay[$s]['ToplamFiyat'];
              $Ikram = $SiparisDetay[$s]['Ikram'];
              if($Ikram==0){ $SiparisToplam+=$ToplamFiyat; }
            }
        }     
        $indirimler=$Siparis["Iskonto"]+$Siparis["Indirim"];
        if($indirimler!=0){
            $indirilenfiyat2=($SiparisToplam*$Siparis["Iskonto"]/100)+$Siparis["Indirim"];
            $yenifiyat=$SiparisToplam-$indirilenfiyat2;
            if($yenifiyat){
              return $yenifiyat;
            }else{
              return 0;
            }
        }else{
          return $SiparisToplam;
        }
  } 
#/Bakiye hesapla

#Room
   function Room($value)
  {
    $FirmaCode="C".str_replace("C","",$value);
    return $FirmaCode;
  }



#Ürün Cache Sil =================== {
  function UrunCacheSil($FirmaLink)
  {
    $cache_klasor = './cache/';
    $dosya_isim = md5($FirmaLink).'_urun.json';
    $dosya_yolu = $cache_klasor.$dosya_isim;
    $cache_suresi = 4 * 60 * 60; // cache süresi 3 saat
    if (file_exists($dosya_yolu)){ //cache dosyası var ise
        unlink($dosya_yolu); //dosyayı, cache sil    
    }
  }  
#Ürün Cache Sil =================== }
#Dil Cache Sil =================== {
  function DilCacheSil($FirmaLink)
  {
    $cache_klasor = './cache/';
    $dosya_isim = md5($FirmaLink).'_dil.json';
    $dosya_yolu = $cache_klasor.$dosya_isim;
    $cache_suresi = 4 * 60 * 60; // cache süresi 3 saat
    if (file_exists($dosya_yolu)){ //cache dosyası var ise
        unlink($dosya_yolu); //dosyayı, cache sil    
    }
  }  
#Dil Cache Sil =================== }