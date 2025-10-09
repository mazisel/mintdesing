<?php
/**
 * @author DevNanotek
 * @copyright Ajax İşlem 13.04.2022
 */

      $title1=$W7_Veriable12;/*"reCAPTCHA hatalı";*/
      $title1_1="";
      $title2=$W7_Veriable13;//"Teklif isteğini başarıyla aldık";
      $title2_1=$W7_Veriable14;/*"Size en yakın zamanda geri dönüş yapacaz";*/
      $title3=$W7_Veriable15;/*"Teklif İsteği Alınamadı";*/
      $title3_1=$W7_Veriable16;/*"Tekrar Deneyiniz";*/
      $title4=$W7_Veriable17;//"Teklif İsteği Alınamadı";
      $title4_1=$W7_Veriable16;/*"Tekrar Deneyiniz";*/
      $title5=$W7_Veriable18;//"Geçerli bir E-posta yazınız";
      $title5_1="";
      $btn=$W7_Veriable19;//"Tamam";  

 if (isset($_POST['teklif_formu'])) {

    $AdSoyad=htmlspecialchars($_POST['name']);
    //if (isset($_POST['ad_soyad2'])) {$AdSoyad.=" ".htmlspecialchars($_POST['ad_soyad2']); }
    //$FirmaAdi=htmlspecialchars($_POST['firma_adi']);
    $Konu=htmlspecialchars($_POST['konu']);
    $Tel=htmlspecialchars($_POST['phone']);       
    $Tel=str_replace(str_split('()-)+ '),'',$Tel);
    $Email=htmlspecialchars($_POST['mail']);
    $Mesaj=htmlspecialchars($_POST['message']);
    $Birim=htmlspecialchars($_POST['birim']);



    if(!empty($AdSoyad) && !empty($Email) && !empty($Tel)) {

      #Kontroller ==================== {
          if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $array =  ['sonuc' => "warning", 'neden' => "mailvar", 'title' =>$title5, 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($array);die();
          }

          if($SiteAyarSabit['reCAPTCHA']==1){
            $r=$_POST['recaptcha-cevap'];
            $url="https://www.google.com/recaptcha/api/siteverify"; 
            $s_key=$SiteAyarSabit['reCAPTCHASecretKey']; 
            $ip=gercekip();
            $gidecek_adres=$url."?secret=".$s_key."&response=".$r."&remoteip=".$ip;
            $res=file_get_contents($gidecek_adres);
            $res=json_decode($res,true);
            if($res['success']){ /*googleden bana onay gelirse*/ }else{ 
                $array =  [
                'sonuc' => "warning",
                'neden' => "mailvar",
                'title' =>$title1,//"Ben robot değilim işaretleyiniz!",
                'btn' =>$btn,
                'icon'=>"warning"
              ];echo $json=json_encode($array);die();
            }
          }
      #Kontroller ==================== }

      $Ip    = gercekip();     
      $_POST1=["AdSoyad"=>$AdSoyad, "Konu"=>$Konu, "Tel"=>$Tel, "Email"=>$Email, "Mesaj"=>$Mesaj, "Birim"=>$Birim, "IP"=>$Ip, "Tarih"=>date("Y-m-d H:i:s")];

      $sonuc=$DNCrud->insert("teklif_form",$_POST1);
      if($sonuc['status']){

        $sql=$DNCrud->ReadAData("products","ProductID",$ProductID); 
        $product_row=$sql->fetch(PDO::FETCH_ASSOC);
        $ProductID=$product_row['ProductID'];   
        $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID,["ikincikosul"=>"AND LangID=".$DefaultLangID]); 
        if(!$sql->rowCount()) {
          $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID,["ikincikosul"=>"AND LangID=".$AktifLangID]);
          if(!$sql->rowCount()) {
            $sql=$DNCrud->ReadAData("products_lang","ProductID",$ProductID);
          }
        }
        $product_lang=$sql->fetch(PDO::FETCH_ASSOC);
        $UrunLinki=SITE_URL.$W_URLShop."/d/".seo($product_lang['Name'])."-".$product_row['ProductID'];

        #Iletisim Formu ================== {
          //Taslak Değişkenleri
          $TText0=$W7_Veriable20;//"Teklif İsteği";
          $TText1=$W7_Veriable21;//"Ad Soyad";
          $TText2=$W7_Veriable22;/*"Telefon";*/
          $TText3=$W7_Veriable23;//"E-Mail";
          $TText4=$W7_Veriable24;//"Konu";
          $TText5=$W7_Veriable25;//"Post Code";
          $TText6=$W7_Veriable26;//"Gönderi Tarihi";
          $TText7=$W7_Veriable27;//"Gönderen IP";
          $TText8=$W7_Veriable28;//"Mesajı";
          $TText9=$W7_Veriable29;//"Urun Linki";

     
          include 'config/mail.send.php';
          $url = 'mailtaslaklar/teklif_formu.php';
          ob_end_clean();
          ob_start();
          include($url);
          $taslak_html = ob_get_contents();
          ob_end_clean();

          $smtp_ayar=$db->prepare("SELECT * FROM smtp_ayar WHERE SmtpID =?");
          $smtp_ayar->execute([1]);
          $smtp_cek=$smtp_ayar->fetch(PDO::FETCH_ASSOC);
          $baslik =$TText0;//"Teklif İsteği";
          $MailSonuc=mail_gonder($baslik,$taslak_html,0,1);      
        #Iletisim Formu ================== }
        $result =  ['sonuc' => "success", 'title' =>$title2, 'subtitle' =>"", 'btn' =>$btn, 'Git'=>$git, 'icon'=>"success"];echo json_encode($result);die();          
      }else{
        $result =  ['sonuc' => "failure", 'title' =>$title3, 'subtitle' =>"", 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($result);die();
      }
  
    }else{
      $result =  ['sonuc' => "failure", 'title' =>$title4, 'subtitle' =>$title4_1, 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($result);die();
    }

}

