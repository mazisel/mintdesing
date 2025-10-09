<?php
/**
 * @author DevNanotek
 * @copyright Ajax İşlem 13.04.2022
 */



$title1=$W2_Variable12;//"Recap hatalı";
$title1_1=$W2_Variable13;//"Ben robot değilim işaretleyiniz!";
$title2=$W2_Variable14;//"Mesajınız Başarıyla aldık";
$title2_1=$W2_Variable15;//"Size en yakın zamanda geri dönüş yapacaz";
$title3=$W2_Variable16;//"Mesajınız Alınamadı";
$title3_1=$W2_Variable17;//"Tekrar Deneyiniz";
$title4=$W2_Variable16;//"Mesajınız Alınamadı";
$title4_1=$W2_Variable17;//"Tekrar Deneyiniz";
$title5=$W2_Variable18;//"Geçerli bir E-posta yazınız";
$title5_1="";
$btn=$W2_Variable19;//"Tamam";
if(isset($_POST['iletisim_formu'])) {


  $AdSoyad=htmlspecialchars($_POST['name']);
  $FirmaAdi=htmlspecialchars($_POST['firma_adi']);
  $Konu=htmlspecialchars($_POST['konu']);
  $Tel=htmlspecialchars($_POST['phone']);       
  $Tel=str_replace(str_split('()-)+ '),'',$Tel);
  $Email=htmlspecialchars($_POST['mail']);
  $Mesaj=htmlspecialchars($_POST['mesaj']);
  $Birim=htmlspecialchars($_POST['birim']);



  if(!empty($AdSoyad) && !empty($Email) && !empty($Tel)) {

    #Kontroller ==================== {
      if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $result =  ['sonuc' => "warning", 'neden' => "mailvar", 'title' =>$title5, 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($result);die();
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
                'title' =>$title1_1,//"Ben robot değilim işaretleyiniz!",
                'btn' =>$btn,
                'icon'=>"warning"
              ];echo $json=json_encode($array);die();
            }
          }

   
    #Kontroller ==================== }

          $Ip    = gercekip();     
          $_POST1=["AdSoyad"=>$AdSoyad, "FirmaAdi"=>$FirmaAdi, "Konu"=>$Konu, "Tel"=>$Tel, "Email"=>$Email, "Mesaj"=>$Mesaj, "Birim"=>$Birim, "IP"=>$Ip, "Tarih"=>date("Y-m-d H:i:s") ];

          $sonuc=$DNCrud->insert("iletisim_form",$_POST1);
          if($sonuc['status']){
          #Iletisim Formu ================== {
            include 'config/mail.send.php';
            $url = 'mailtaslaklar/iletisim_formu.php';
            ob_end_clean();
            ob_start();
            include($url);
            $taslak_html = ob_get_contents();
            ob_end_clean();

            $smtp_ayar=$db->prepare("SELECT * FROM smtp_ayar WHERE SmtpID =?");
            $smtp_ayar->execute([1]);
            $smtp_cek=$smtp_ayar->fetch(PDO::FETCH_ASSOC);
            $baslik =$smtp_cek["Konu1"];
            $MailSonuc=mail_gonder($baslik,$taslak_html,0,1);      
          #Iletisim Formu ================== }
            $result =  ['sonuc' => "success", 'title' =>$title2, 'subtitle' =>"", 'btn' =>$btn, 'Git'=>$git, 'icon'=>"success"];echo json_encode($result);die();          
          }else{
            $result =  ['sonuc' => "failure", 'title' =>$title3, 'subtitle' =>"", 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($result);die();
          }
          
        }else{
          $result =  ['sonuc' => "failure", 'title' =>$title4, 'subtitle' =>$title4_1, 'btn' =>$btn, 'icon'=>"warning"];echo json_encode($result);die();
        }
        die();

}

