<?php 

  $PayCode=$_GET['id'];
  $Where=$DNCrud->ReadData("personal_pay",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PayCode={$PayCode}"]);
  $PersonalPayRow=$Where->fetch(PDO::FETCH_ASSOC);

  $sql=$DNCrud->ReadData("vergi_kate",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$PersonalPayRow['KateID']}"]);
  if($sql->rowCount()) {
    $VergiKateRow=$sql->fetch(PDO::FETCH_ASSOC);
  }

  $sql=$DNCrud->ReadData("vergi_turu",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND KateID={$PersonalPayRow['KateID']}"]);
  if($sql->rowCount()) {
    $Vergiler=$sql->fetchAll(PDO::FETCH_ASSOC);  
  }
    $VergiEklentiler=json_decode($PersonalPayRow['VergiEklentiler'],true);
 
//echo "<pre>"; print_r($VergiEklentiler);die;
  $sorgu=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalPayRow['PersonalID']}"]);
  if($sorgu->rowCount()) {
    $PesonelDetay=$sorgu->fetch(PDO::FETCH_ASSOC);
  }else{
    $PesonelDetay=json_decode($PersonalPayRow['PesonelDetay'],true);
  }


  if($Firma['ProfilFoto']){
    $Logo=BASE_URL."view/images/user/".$Firma['ProfilFoto'];
  }else{
    $Logo=BASE_URL.'view/images/'.$SiteAyarSabit['Logo2'];
  }  
  $Logo=BASE_URL.'view/images/'.$SiteAyarSabit['Logo2'];
  $htmltaslak = 'taslak/payroll_taslak.php';
  if(ob_get_contents()){ob_end_clean();}
  ob_start();
  include($htmltaslak);
  $taslak_html = ob_get_contents();
  ob_end_clean();
  if (isset($_GET['taslak'])) {
    echo $taslak_html;die;
  } 
  $mpdf = new \Mpdf\Mpdf(['margin_top' => 14, 'margin_bottom' => 14,'margin_left' => 13, 'margin_right' => 13, 'mode' => 'utf-8', 'A4-L']);     
  $mpdf->WriteHTML($taslak_html);

  
  if(isset($_GET['mailgonder'])) {
    #Mail Gonder ======================= {   
    $sql=$DNCrud->ReadData("firma_smtp_taslak",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND TaslakKate=2"]); 
    $taslakRow=$sql->fetch(PDO::FETCH_ASSOC);           
    $baslik=$taslakRow['TaslakTitle'];
    $MsgContent=$taslakRow['TaslakContent'];
    //Mail gönder        
    if($taslakRow['Status']==1){ 
      #Pdf kaydet
      $fileName='Lohnabrechung_'.seo($PesonelDetay['PersonalName']).'_'.seo($PesonelDetay['PersonalSurname']).'_'.$PersonalPayRow['PayCode'];
      $mpdf->Output('view/pdf/payroll/'.$fileName.'.pdf');

      $Gonderilecekler[]=dirname(__DIR__)."/pdf/payroll/".$fileName.'.pdf';
    
      $WorkerName=$PesonelDetay['PersonalName'];
      $WorkerSurname=$PesonelDetay['PersonalSurname'];
      $SalaryDate=date('d.m.Y',strtotime($PersonalPayRow['IsGirisTarih']));

      $MsgContent=str_replace("{WorkerName}",$WorkerName,$MsgContent);
      $MsgContent=str_replace("{WorkerSurname}",$WorkerSurname,$MsgContent);
      $MsgContent=str_replace("{SalaryDate}",$SalaryDate,$MsgContent);
      $MailSonuc=mailSend([
        'SmtpID'=>$taslakRow['SmtpID'],
        'title'=>$baslik,
        'content'=>$MsgContent,
        'eMails'=>[$PersonalPayRow['Mail']],
        'adminSend'=>1,
        'Files'=>$Gonderilecekler
      ]); 
      if($MailSonuc) {
        $Result=[
          'result'=>'success','icon'=>'success',
          'title'=>'E-Mail gesendet',/*Mail gönderildi*/
          'subtitle'=>"",
          'btn'=>'OK'
        ]; echo json_encode($Result);die;
      }else{
        $Result=[
          'result'=>'fail','icon'=>'warning',
          'title'=>'E-Mail konnte nicht gesendet werden',/*Mail gönderilemedi*/
          'subtitle'=>"",
          'btn'=>'OK', 'MessageError'=>$MailSonuc
        ]; echo json_encode($Result);die;
      }
      die;
    }  
    #Mail Gonder ======================= }
  }else{
    // PDF'yi doğrudan tarayıcıya gönder
    $mpdf->Output('Lohnabrechung '.$PesonelDetay['PersonalName'].' '.$PesonelDetay['PersonalSurname'].' '.$PersonalPayRow['PayCode'].'.pdf', 'I');
  }

  