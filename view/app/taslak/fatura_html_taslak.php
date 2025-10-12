<?php 
    $PdfTaslakID=2;
    $sql=$DNCrud->ReadAData("firma_fatura_taslak","FirmaID",$FirmaID); 
    $pdfTaslakRow=$sql->fetch(PDO::FETCH_ASSOC);
    $PdfTaslakID=$pdfTaslakRow['PdfTaslakID'];  

    $ImageCount=1;
    $Images=json_decode($pdfTaslakRow['Images'],true);  
    $TaslakText = json_decode($pdfTaslakRow['TaslakText'],true);
    $HeaderLogo = $Logo;
    if (!empty($Firma['ProfilFoto'])) {
      $HeaderLogo = BASE_URL."view/images/user/".$Firma['ProfilFoto'];
    }
    if ($Images[1]) {
      $FooterImg=BASE_URL.SitePath.'images/pdf/'.$Images[1];
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
        .page_footer {width: 100%;  position: absolute; bottom: 0; left: 0;  padding: 0x; margin: 0px; text-align: center; }
        .page_footer img{width: 100%; margin: 0px; padding: 0px; }
      .logo {margin-bottom: 10px; text-align: center; } 
      .logo img {max-height: 40px; max-width: 140px; width: auto; height: auto; display: inline-block; }
      .logo-header {text-align: center; margin-bottom: 30px;}
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
    </style>
  </head>
  <body>
      <header class="clearfix logo-header">
        <div class="logo">
          <img src="<?=$HeaderLogo?>" alt="Logo">
        </div>
      </header>

      <header class="clearfix">
        <div id="company" class="clearfix">
          <div>
            <table>
              <tr>
                <td class="fw600">Rechnungsnummer</td>
                <td class="txl"><?=$OrderRow['OrderCode']?></td>
              </tr>
              <tr>
                <td class="fw600">Kundennummer</td>
                <td class="txl"><?=$cariRow['CariCode']?></td>
              </tr>
              <tr>
                <td class="fw600">Rechnungsdatum</td>
                <td class="txl"><?=date('d.m.Y', strtotime($OrderRow['OrderDate']))?></td>
              </tr>
              <tr>
                <td class="fw600">Zahlbar bis</td>
                <td class="txl"><?=date('d.m.Y', strtotime($OrderRow['OrderDateEnd']))?></td>
              </tr>
            </table>
          </div>
        </div>
        <div id="project">
          <div id="project_div1">
            <table style="float: right;">
              <tr>
                <td colspan="2" class="txl" style="text-decoration: underline;font-size: 11px;color: #575757;"><?=$Firma['FirmaAd']?> <?=$Firma['FirmaAdres']?></td>
              </tr>
              <!-- <tr>
                <td class="fw600"><?=$TaslakText[2]?></td>
                <td class="txl"><?=date('d.m.Y H:i', strtotime($OrderRow['OrderDate']))?></td>
              </tr> -->
              <tr>
                <?php if($TaslakText[3]){ ?>
                  <td class="fw600"><?=$TaslakText[3]?></td>
                <?php } ?>
                <td <?php if(empty($TaslakText[3])){ echo "colspan='2'"; } ?> class="txl"><?=$cariRow['CariName']?> <?=$cariRow['CariSurname']?><br> <?=$cariRow['CariUnvan']?></td>
              </tr>
              <tr>
                <?php if($TaslakText[4]){ ?>
                  <td class="fw600"><?=$TaslakText[4]?></td>
                <?php } ?>
                <td <?php if(empty($TaslakText[4])){ echo "colspan='2'"; } ?>  class="txl"><?=$cariRow['CariAdres']?> <?=$cariRow['CariAdres2']?></td>
              </tr>
              <?php if (!empty($cariRow['CariPostakodu']) || !empty($cariRow['CariCity'])) {?>
                <tr>
                <td <?php if(empty($TaslakText[4])){ echo "colspan='2'"; } ?>  class="txl"><?=$cariRow['CariPostakodu']?> <?=$cariRow['CariCity']?></td>
                </tr>
              <?php } ?>              
              <?php if (!empty($cariRow['CariGsm'])) {?>
              <tr>                
                <td <?php if(empty($TaslakText[4])){ echo "colspan='2'"; } ?>  class="txl"><?=$cariRow['CariGsm']?></td>                
              </tr>
              <?php } ?>
              <!-- <tr>
                <td class="fw600"><?=$TaslakText[5]?></td>
                <td class="txl"><?=$cariRow['CariEmail']?></td>
              </tr>
              <tr>
                <td class="fw600"><?=$TaslakText[6]?></td>
                <td class="txl"><?=$cariRow['CariAdres']?></td>
              </tr> -->
            </table>
          </div>
        </div>      
      </header>
      <div> <h1>RECHNUNG</h1></div>
    <main>
      <table class="product_table">
        <thead>
          <tr>
            <th class="service"><?=$TaslakText[7]?></th>
            <th class="desc" width="40%"><?=$TaslakText[8]?></th>
            <th class="txr"><?=$TaslakText[10]?></th>
            <th class="txr"><?=$TaslakText[9]?></th>
            <th class="txr"><?=$TaslakText[11]?></th>           
            <th class="txr"><?=$TaslakText[12]?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($OrderUrun as $key => $value) {?>
            <tr>
              <td class="service"><?=$key+1?></td>
              <td class="desc"><?=$OrderUrun[$key]['Name']?></td>
              <td class="qty txr"><?=$OrderUrun[$key]['Miktar']?></td>
              <td class="unit txr"><?=mony($OrderUrun[$key]['Fiyat'])?></td>
              <td class="qty txr"><?php if($OrderUrun[$key]['KDV']){ echo $OrderUrun[$key]['KDV']; }?></td>              
              <td class="total txr"><?=mony($OrderUrun[$key]['Toplam'])?></td>
            </tr>
          <?php } ?>
         
          <tr class="totals">
            <td colspan="5" style="padding-top: 15px;" class="txr totalr"><?=$TaslakText[13]?></td>
            <td class="total" style="padding-top: 15px;"><?=mony($OrderRow['NetTutar'],$Currency)?></td>
          </tr>
          <?php if($OrderRow['KdvTutar']>0){ ?>
            <tr class="totals" style="border: none;">
              <td colspan="5" class="txr totalr"><?=$TaslakText[14]?></td>
              <td class="total"><?=mony($OrderRow['KdvTutar'],$Currency)?></td>
            </tr>
          <?php } ?>
          <tr class="totals" style="border: none;">
            <td colspan="5" class="grand total totalr"><?=$TaslakText[15]?></td>
            <td class="grand total"><?=mony($OrderRow['ToplamTutar'],$Currency)?></td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div><?=$TaslakText[16]?></div>
        <div class="notice"><?=nl2br($OrderRow['OrderNot'])?></div>
      </div>
    </main>
    
   
    <!-- <footer> <?=$TaslakText[17]?> </footer> -->
    <?php if ($Images[1]) { ?>
      <div class="page_footer">
       <img src="<?=$FooterImg?>">
      </div>
    <?php } ?>
  </body>
</html>
