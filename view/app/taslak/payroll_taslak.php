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
    


$aylar = ['Januar','Februar','März','April','Mai', 'Juni', 'Juli','August','September', 'Oktober', 'November', 'Dezember'];
// Verilen tarihi al
$tarih = strtotime($PersonalPayRow['IsGirisTarih']);// Ay ve yılı al
$ay = date('n', $tarih); // n, ayı 1-12 arasında temsil eder
// Tarihi istediğiniz formatta biçimlendirin
$formatliTarih1 = $aylar[$ay] . ' ' . date('Y', $tarih);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=' Lohnabrechung '.$PesonelDetay['PersonalName'].' '.$PesonelDetay['PersonalSurname'].' '.$PersonalPayRow['PayCode']?></title>
    <style>
      .clearfix:after {content: ""; display: table; clear: both; } 
      a {color: #000; text-decoration: underline; } 
      body {position: relative; width: 21cm; height: 29.7cm; margin: 0 auto; color: #000000; background: #FFFFFF; font-family: Arial, sans-serif; font-size: 13px; } 
      header {padding: 10px 0; } 
      footer {display: block; color: #5D6975; width: 100%; height: 30px; position: absolute; bottom: 0; left: 0; border-top: 1px solid #C1CED9; padding: 8px 0; text-align: center; }
      .logo {margin-bottom: 10px; } 
      .logo img{  height: 50px; }
      p{margin: 0px;font-family: Arial, sans-serif;}
      h1 {color: #000; font-size: 1.3em; line-height: 1.4em; font-weight: bold; margin: 0 0 5px 0; background: url(dimension.png); } 

 
      #project {float: right; width: 50%;} 
      #project_div1 {width: 70%;  float: right; text-align: left;}
      #project_div1 div {white-space: nowrap; width: 100%;  }  
      #project_div1 span{float: left; display: inline-block; color: #5D6975; margin-right: 10px; width: 60px;  font-size: 0.8em;  }

      #company {float: left; text-align: left;width: 50%;} 
      #company div {white-space: nowrap; } 
      .product_table {width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 20px; } 
      .product_table tr {  } 
      .product_table tr:nth-child(2n-1) td {/*background: #F5F5F5;*/ } 
      .product_table td {/*border-bottom: 1px solid #c3c3c3 !important;*/}
      .product_table th {padding: 2px 10px; color: #0a0a0a; border-bottom: 2px solid #000;border-top: 2px solid #000; white-space: nowrap; font-weight: 600; }
      .product_table .service, .product_table .desc {text-align: left; }
      .product_table td {padding: 2px 10px; } 
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
      .col-6{width: 60%;float: left; }
      .col-5{width: 50%;float: left; }
      .col-4{width: 40%;float: left; }
      
      
      .txr{text-align: right !important;}
      .txl{text-align: left;}
      .txc{text-align: center;}

      .totals{}
      .totals td{padding: 5px 10px; font-weight: bold; text-align: right;border-bottom: 0px solid gray !important;}
    </style>
  </head>
  <body>
   
    <div class="row" style="border-bottom: 2px solid #000; margin-bottom: 20px;">
      <div class="col-4" style="text-align: center;"><h1><?=$Firma['FirmaAd']?></h1> </div>
      <div class="col-6" style="text-align: center;"><h1><?=$Firma['FirmaAdres']?></h1> </div>
    </div>

    <header class="clearfix"> 
      <div id="company" class="clearfix">
        <div> </div>
      </div>
      <div id="project">
        <div id="project_div1">
            <table>
              <tr>
                <td colspan="2"><?=$PesonelDetay['Cinsiyet']?></td>
              </tr>
              <tr>
                <td colspan="2"><?=$PesonelDetay['PersonalName'].' '.$PesonelDetay['PersonalSurname']?> </td>
              </tr>
              <tr>
                <td colspan="2" class="fw600">
                  <?=nl2br($PesonelDetay['PersonalAdres'])?>
                </td>
              </tr>
            </table>
        </div>
      </div>  
    </header>

    <header class="clearfix"> 
      <div id="company" class="clearfix">
        <div> </div>
      </div>
      <div id="project">
        <div id="project_div1">
            <table>
              <tr>
                <td>AHV-Nr.:</td>
                <td><?=$PesonelDetay['PersonalKimlik']?></td>
              </tr>
            </table>
        </div>
      </div>  
    </header>

    <header class="clearfix">
      <div id="company" class="clearfix">
        <div>
          <table width="100%">
            <tr>
              <td class="fw600">Lohnabrechnung per</td>
              <td class="txl"><b><?=$formatliTarih1?></b></td>
            </tr>
            <tr>
              <td class="fw600">Datum</td>
              <td class="txl"><?=date('d.m.Y',strtotime($PersonalPayRow['IsGirisTarih']))?></td>
            </tr>
          </table>
        </div>
      </div>
      <div id="project">
        <div id="project_div1"> </div>
      </div>      
    </header>
 
    <main>
      <table class="product_table">
        <thead>
          <tr>
            <th class="desc" width="40%">Lohnart</th>
            <th class="txr">Anzahl</th>
            <th class="txr">Basis CHF</th>
            <th class="txr">Betrag CHF </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="desc" colspan="3">
              <?=$PersonalPayRow['PayTitle']?> <br> <?=$PersonalPayRow['PayDesc']?>
            </td>           
            <td  class="total txr"><?=mony($PersonalPayRow['ToplamUcret'])?></td>
          </tr>
          <tr>
            <td class="desc" colspan="3" style="font-size:1rem; padding-bottom: 15px;padding-top: 15px;">
              <b> Total Bruttolohn</b>
            </td>           
            <td  class="total txr"><?=mony($PersonalPayRow['ToplamUcret'])?></td>
          </tr>
          <?php $kesintitoplam=0; foreach ($VergiEklentiler as $key => $value){ $Vergi=$VergiEklentiler[$key]; $kesintitoplam+=$Vergi['Tutar'];?>
            <tr>
              <td class="desc"><?=$Vergi['VergiName']?></td>
              <td class="qty txr"><?=$Vergi['VergiDeger']?></td>
              <td class="unit txr"><?=mony($PersonalPayRow['ToplamUcret'])?></td>           
              <td class="total txr"><?=mony($Vergi['Tutar'])?></td>
            </tr>
          <?php } ?>
          <tr>
            <td class="desc" colspan="3" style="font-size:1rem; padding-bottom: 15px;padding-top: 15px;">
              <b>TOTAL ABZÜGE</b>
            </td>           
            <td class="total txr"><b><?=mony($kesintitoplam)?></b></td>
          </tr>
          <tr>
            <td class="desc" colspan="3" style="font-size:1rem; padding-bottom: 15px;padding-top: 15px;">
              <b> TOTAL ABZÜGE</b>
            </td>           
            <td class="total txr"><b><?=mony(0)?></b></td>
          </tr>
          <tr class="totals">
            <td colspan="3" style="padding-top: 15px;" class="txr totalr">Rundungsdifferenz</td>
            <td class="total" style="padding-top: 15px;"><?=mony($PersonalPayRow['YuvarlamaFarki'])?></td>
          </tr>
          <tr class="totals">
            <td colspan="3" style="padding-top: 15px;" class="txr totalr">Nettolohn</td>
            <td class="total" style="padding-top: 15px;"><?=mony($PersonalPayRow['YuvarlanmisUcret'])?></td>
          </tr> 
          <tr class="totals">
            <td colspan="3" style="padding-top: 15px;" class="txr totalr">Auszahlung</td>
            <td class="total" style="padding-top: 15px;"><?=mony($PersonalPayRow['YuvarlanmisUcret'])?></td>
          </tr>       
        </tbody>
      </table>    
    </main>
    
    <style>.row_bottom{width: 100%; position: absolute; bottom: 0; left: 0;}</style>
    <div class="row row_bottom">
      <div class="col-7">    
        <div class="row" style="padding:5px;  padding-left: 15px">
          <div class="col-7">
           <span>Betrag in bar erhalten: </span>
          </div>
        </div> 
      </div>
    </div>

     <!-- <footer><?=$TaslakText[17]?></footer> -->
  </body>
</html>