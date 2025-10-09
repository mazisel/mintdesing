<?php 
    $PdfTaslakID=2;
    $sql=$DNCrud->ReadAData("firma_fatura_taslak","FirmaID",$FirmaID); 
    $pdfTaslakRow=$sql->fetch(PDO::FETCH_ASSOC);
    $PdfTaslakID=$pdfTaslakRow['PdfTaslakID'];  

    $ImageCount=1;
    $Images=json_decode($pdfTaslakRow['Images'],true);  
    $TaslakText = json_decode($pdfTaslakRow['TaslakText'],true);
    if ($Images[0]) {
      $Logo=BASE_URL.SitePath.'images/pdf/'.$Images[0];
    }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=seo($Firma['FirmaAd'],['delimiter'=>'_'])?>_Rechnung_<?=$OrderRow['OrderCode']?></title>
    <style>
      .clearfix:after {content: ""; display: table; clear: both; } 
      a {color: #000; text-decoration: underline; } 
      body {position: relative; width: 21cm; height: 29.7cm; margin: 0 auto; color: #000000; background: #FFFFFF; font-family: Arial, sans-serif; font-size: 13px; } 
      header {padding: 10px 0; margin-bottom: 30px; } 
      footer {
        display: block;
        color: #5D6975;
        width: 100%;
        height: 30px; 
        position: absolute; 
        bottom: 0; 
        left: 0;
        border-top: 1px solid #C1CED9; padding: 8px 0; text-align: center; }
      .logo {margin-bottom: 10px;  } 
      .logo img {    height: 50px; }
      p{margin: 0px;font-family: Arial, sans-serif;}
      h1 {color: #000; font-size: 2.4em; line-height: 1.4em; font-weight: normal; margin: 0 0 20px 0; background: url(dimension.png); } 

 
      #project {float: right; width: 50%;} 
      #project_div1 {width: 90%;  float: right; text-align: right;}
      #project_div1 div {white-space: nowrap; width: 100%;  }  
      #project_div1 span{float: left; display: inline-block; color: #5D6975; margin-right: 10px; width: 60px;  font-size: 0.8em;  }

      #company {float: left; text-align: left;width: 50%;} 
      #company div {white-space: nowrap; } 
      .product_table {width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 20px; } 
      .product_table tr {  } 
      .product_table tr:nth-child(2n-1) td {/*background: #F5F5F5;*/ } 
      .product_table td {border-bottom: 1px solid #c3c3c3 !important;}
      .product_table th {padding: 5px 10px; color: #0a0a0a; border-bottom: 1px solid #000; white-space: nowrap; font-weight: 600; }
      .product_table .service, .product_table .desc {text-align: left; }
      .product_table td {padding: 5px 10px; } 
      .product_table td.service, .product_table td.desc {vertical-align: top; } 
      .product_table td.unit, .product_table td.qty, .product_table td.total{font-size: 1.1em; }
      .product_table td.grand {/*border-top: 1px solid #5D6975;*/ } 
      .product_table td.totalr {text-align: right; } 
      #notices .notice {color: #5D6975; font-size: 1.2em;  margin-bottom: 15px;} 
      .fw300{font-weight: 300;}
      .fw400{font-weight: 400;}
      .fw500{font-weight: 500;}
      .fw600{font-weight: 600;}
      .row{float: left;width: 100%; }
      .col-3{width: 30%;float: left; }
      .col-7{width: 70%;float: left; }
      .col-6{width: 59%;float: left; }
      .col-5{width: 50%;float: left; }
      .col-4{width: 40%;float: left; }
      
      
      .txr{text-align: right !important;}
      .txl{text-align: left;}
      .txc{text-align: center;}

      .totals{}
      .totals td{padding: 5px 10px; font-weight: bold; text-align: right;border-bottom: 0px solid gray !important;}
      .row_bottom{
        width: 100%;
        position: absolute; 
        bottom: 0; 
        left: 0;
       }
    </style>
  </head>
  <body>

    

    <div class="row row_bottom" style="border-top: 1px dotted #000;">
      <div class="col-3">
        <div style="padding: 5px;  padding-left: 15px">
          <b>Empfangsschein</b><br><br>
          <b style="font-size: 9px;">Konto / Zahlbar an</b><br>
          <?=$bankaRow['BankaIBAN']?> <br>
          <?=nl2br($Firma['FirmaAd'])?><br>
          <?=nl2br($Firma['FirmaAdres'])?><br><br>
         
          <b style="font-size: 9px;">Referenz</b><br>
          RF<?=$OrderRow['OrderCode']?> <?=$cariRow['CariCode']?><br><br>

          <b style="font-size: 9px;">Zahlbar durch</b><br>
          <?=$cariRow['CariName']?> <?=$cariRow['CariSurname']?>, <?=$cariRow['CariUnvan']?><br>
          <?=nl2br($cariRow['CariAdres'])?> <?=$cariRow['CariAdres2']?>
          <?php if (!empty($cariRow['CariPostakodu']) || !empty($cariRow['CariCity'])) {?>               
            <br><?=$cariRow['CariPostakodu']?> <?=$cariRow['CariCity']?>
          <?php } ?>
    
        </div>
        <div class="row" style="padding:5px;  padding-left: 15px">
          <div class="col-3">
           <b> Wahrung</b><br><?=$Currency?>
          </div>
          <div class="col-3" style="margin-bottom: 20px;">
            <b>Betrag</b><br><?=mony($OrderRow['ToplamTutar'])?>
          </div>
        </div> 
      </div>
      <div class="col-7" style="width: 69%;    border-left: 1px dotted #000;">
        <div class="row">
          <div class="col-4">
            <div style="padding: 10px; width:100%; font-size:15px"><b>Zahlteil</b></div>
            <div style="padding: 10px"><img style="width: 200px" src="<?=BASE_URL.SitePath.'app/taslak/qrcode.png'?>"/></div>
          </div>
          <div class="col-6">
            <div style="padding: 5px">
              <b>Empfangsschein</b><br><br>

              <b style="font-size: 10px;">Konto / Zahlbar an</b><br>
              <?=$bankaRow['BankaIBAN']?> <br>
              <?=nl2br($Firma['FirmaAd'])?><br>
              <?=nl2br($Firma['FirmaAdres'])?><br><br>
             
              <b style="font-size: 10px;">Referenz</b><br>
              RF<?=$OrderRow['OrderCode']?> <?=$cariRow['CariCode']?><br><br>

              <b style="font-size: 10px;">Zahlbar durch</b><br>
              <?=$cariRow['CariName']?> <?=$cariRow['CariSurname']?><br><?=$cariRow['CariUnvan']?><br>
              <?=nl2br($cariRow['CariAdres'])?> <?=$cariRow['CariAdres2']?>
              <?php if (!empty($cariRow['CariPostakodu']) || !empty($cariRow['CariCity'])) {?>               
                <br><?=$cariRow['CariPostakodu']?> <?=$cariRow['CariCity']?>
              <?php } ?> 
            </div>
          </div>
        </div> 
        <div class="row" style="padding:10px; padding-bottom: 20px;">
          <div class="col-3">
           <b> Wahrung</b><br><?=$Currency?>
          </div>
          <div class="col-3" style="">
            <b>Betrag</b><br><?=mony($OrderRow['ToplamTutar'])?>
          </div>
        </div>     
      </div>
    </div>


     <!-- <footer><?=$TaslakText[17]?></footer> -->
  </body>
</html>