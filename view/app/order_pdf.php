<?php 


  $OrderCode=intval($_GET['id']);
    // Preserve raw GET id (may contain non-numeric parts like hyphens) for QR fallback
    $OrderCodeRaw = isset($_GET['id']) ? (string)$_GET['id'] : '';
    if (trim($OrderCodeRaw) === '') {
      header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
      echo 'Bad Request';
      exit;
    }
    $OrderCodeEscaped = str_replace("'", "\\'", $OrderCodeRaw);
    $Where=$DNCrud->ReadData("siparisler",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND OrderCode='{$OrderCodeEscaped}'"]);
  $OrderRow=$Where->fetch(PDO::FETCH_ASSOC);
  if (!$Where->rowCount()) {
   header('Location: '.SITE_URL.$URLFirmaAccount);exit;
  }
  $OrderUrun=json_decode($OrderRow['OrderUrun'],true);
  //echo "<pre>"; print_r($OrderUrun);die();

  $sorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND CariID={$OrderRow['CariID']}"]);
  if($sorgu->rowCount()) {
    $cariRow=$sorgu->fetch(PDO::FETCH_ASSOC);
  }else{
    $cariRow=json_decode($OrderRow['CariDetay'],true);
  }
  
  $sorgu=$DNCrud->ReadData("banka",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND BankaID={$OrderRow['BankaID']}"]);
  if($sorgu->rowCount()) {
    $bankaRow=$sorgu->fetch(PDO::FETCH_ASSOC);
  }else{
    $bankaRow=json_decode($OrderRow['BankaDetay'],true);
  }
  
  //qrkodu oluştur (hata olması durumunda log yazmak için try/catch)
  $pdfDebugLog = __DIR__ . '/taslak/pdf_debug.log';
  @mkdir(dirname($pdfDebugLog), 0755, true);
  function pdf_log($msg) {
    global $pdfDebugLog;
    $time = date('Y-m-d H:i:s');
    @file_put_contents($pdfDebugLog, "[$time] $msg\n", FILE_APPEND);
  }
  // Log fetched rows to help debug missing OrderCode/reference in QR payload
  try {
    pdf_log('OrderRow: ' . var_export($OrderRow, true));
    pdf_log('cariRow: ' . var_export($cariRow, true));
    pdf_log('bankaRow: ' . var_export($bankaRow, true));
  } catch (\Throwable $e) {
    // Non-fatal logging failure
    @file_put_contents(__DIR__ . '/taslak/pdf_debug.log', "[".date('Y-m-d H:i:s')."] Failed to var_export rows: " . $e->getMessage() . "\n", FILE_APPEND);
  }
  try {
    include("order_qrcode.php");
    pdf_log('order_qrcode.php included successfully');
  } catch (\Throwable $e) {
    pdf_log('Exception including order_qrcode.php: ' . $e->getMessage());
    pdf_log($e->getTraceAsString());
    // Short-circuit to avoid further errors
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo 'Internal Server Error';
    exit;
  }

  if($Firma['ProfilFoto']){
    $Logo=BASE_URL."view/images/user/".$Firma['ProfilFoto'];
  }else{
    $Logo=BASE_URL.'view/images/'.$SiteAyarSabit['Logo2'];
  }  
  

  $htmltaslak = 'taslak/fatura_html_taslak.php';
  $qrkod_taslak = 'taslak/fatura_qrkod_taslak.php';
  if(ob_get_contents()){ob_end_clean();} ob_start();
  include($htmltaslak);
  $taslak_html = ob_get_contents();
  ob_end_clean();

  if(ob_get_contents()){ob_end_clean();} ob_start();
  include($qrkod_taslak);
  $qrkod_taslak = ob_get_contents();
  ob_end_clean();
if (isset($_GET['taslak'])) {
    echo $taslak_html;die;
  } 
  
  try {
    $mpdf = new \Mpdf\Mpdf(['margin_top' => 14, 'margin_bottom' => 14,'margin_left' => 13, 'margin_right' => 13, 'mode' => 'utf-8', 'A4-L']);     
    $mpdf->WriteHTML($taslak_html);
    $mpdf->AddPage();
    $mpdf->WriteHTML($qrkod_taslak);
    pdf_log('mPDF created and HTML written');
  } catch (\Throwable $e) {
    pdf_log('Exception creating/writing mPDF: ' . $e->getMessage());
    pdf_log($e->getTraceAsString());
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo 'Internal Server Error';
    exit;
  }

  
  if(isset($_GET['mailgonder'])) {
    #Mail Gonder ======================= {   
    $sql=$DNCrud->ReadData("firma_smtp_taslak",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND TaslakKate=1"]); 
    $taslakRow=$sql->fetch(PDO::FETCH_ASSOC);           
    $baslik=$taslakRow['TaslakTitle'];
    $MsgContent=$taslakRow['TaslakContent'];
    //Mail gönder        
    if($taslakRow['Status']==1){ 
      #Pdf kaydet
      $mpdf->Output('view/pdf/archive/'.seo($Firma['FirmaAd'],['delimiter'=>'_']).'_Rechnung_'.$OrderRow['OrderCode'].'.pdf');

      $Gonderilecekler[]=dirname(__DIR__)."/pdf/archive/".seo($Firma['FirmaAd'],['delimiter'=>'_']).'_Rechnung_'.$OrderRow['OrderCode'].'.pdf';
    
      $DateInvoice=date('d.m.Y', strtotime($OrderRow['OrderDate']));
      $ToplamTutar=mony($OrderRow['ToplamTutar'],$Currency);
      $CustomerName=$cariRow['CariName'].' '.$cariRow['CariSurname'];

      $MsgContent=str_replace("{BillNumber}",$OrderCode,$MsgContent);
      $MsgContent=str_replace("{DateInvoice}",$DateInvoice,$MsgContent);
      $MsgContent=str_replace("{BillAmount}",$ToplamTutar,$MsgContent);
      $MsgContent=str_replace("{CustomerName}",$CustomerName,$MsgContent);
      $MailSonuc=mailSend([
        'SmtpID'=>$taslakRow['SmtpID'],
        'title'=>$baslik,
        'content'=>$MsgContent,
        'eMails'=>[$OrderRow['CariEmail']],
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
          'btn'=>'OK'
        ]; echo json_encode($Result);die;
      }
      die;
    }  
    #Mail Gonder ======================= }
  }else{
    // PDF'yi doğrudan tarayıcıya gönder
    $mpdf->Output(seo($Firma['FirmaAd'],['delimiter'=>'_']).'_Rechnung_'.$OrderRow['OrderCode'].'.pdf', 'I');
  }

  
