<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/order.php");
$PageTitle=$W97_PageTitle;
include("prc/top.php");
?>
<!-- datatables -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/responsive.dataTables.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.css">
<!-- select2 -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/select2/select2.min.css">
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/style.css<?=$UPDATE_VERSION?>">
<!-- air datepicker -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.css">
<style>
  /* -webkit-user-select: none; /* Safari */*
* {
  -webkit-touch-callout: none; /* iOS Safari */       
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
} 

.nnt_input_box {align-items: center; border-radius: 100px; display: flex; font-weight: 500; margin-bottom: 16px;cursor:pointer;width: 100%;}
.nnt_input_box:last-of-type {margin: 0; } 
.nnt_input {clip: rect(0 0 0 0); clip-path: inset(50%); height: 1px; overflow: hidden; position: absolute; white-space: nowrap; width: 1px; } 
.nnt_input:not([disabled]):active + .nnt_track, .nnt_input:not([disabled]):focus + .nnt_track {border: 1px solid transparent; box-shadow: 0px 0px 0px 2px #121943; }
.nnt_input:disabled + .nnt_track {cursor: not-allowed; opacity: 0.7; } 
.nnt_track {background: #e5efe9; border: 1px solid #5a72b5; border-radius: 100px; cursor: pointer; display: flex; height: 25px; margin-right: 5px; position: relative; width: 50px; } 
.nnt_indicator {align-items: center; background: #121943; border-radius: 20px; bottom: 2px; display: flex; height: 20px; justify-content: center; left: 2px; outline: solid 2px transparent; position: absolute; transition: 0.25s; width: 20px; }
.checkMark {position: relative;top: -2px; fill: #fff; height: 18px; width: 18px; opacity: 0; transition: opacity 0.25s ease-in-out; }
.nnt_input:checked + .nnt_track .nnt_indicator {background: #121943; transform: translateX(30px); left: -4px; } 
.nnt_input:checked + .nnt_track .nnt_indicator .checkMark {opacity: 1; transition: opacity 0.25s ease-in-out; }
@media screen and (-ms-high-contrast: active) {.nnt_track {border-radius: 0; } }
.nnt_input_box .ok{display: none; transition: var(--t03); font-size: 0.8rem;}
.nnt_input_box .no{display: block;color: red; transition: var(--t03); font-size: 0.8rem;}
.nnt_input_box input.nnt_input:checked ~ .ok {display: block;color: green; transition: var(--t03);}
.nnt_input_box input.nnt_input:checked ~ .no {display: none; transition: var(--t03);}
.nnt_input_box .checcolor{color: var(--black) !important;}

</style>
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>


<!-- CONTENT -->
<section>
  <div class="container-xxl mb-5">
    <div class="row mb-2">
      <div class="col-lg-6 col-6"><a class="btn btn-dark btnsm" href="<?=$SiteUrl?>order_list"><i class="fa-solid fa-angle-left"></i></a></div>
      <div class="col-lg-6 col-6"></div>
    </div>

    <div class="accordion" id="accordionPanelsStayOpenExample">
      <!-- Firma ve banka seçim -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_one" aria-expanded="true" aria-controls="accordion_one">
           <?=$W97_Text1?>
          </button>
        </h2>
        <div id="accordion_one" class="accordion-collapse collapse show">
          <div class="accordion-body p-0 m-0 py-4">
            <form id="order_form" class="w-100 form_send2" enctype="multipart/form-data" action="" method="post">
              <div class="row m-0 p-0">
                <div class="col-lg-5 col-md-5 col-sm-6 col-12">
                  <div class="form-floating mb-3">
                    <select class="form-select select2 cari_secim" required id="cari" aria-label="cari" data-placeholder="<?=$W97_Text2?>*" name="cari">
                      <option hidden=""></option>
                      <?php foreach ($CariList as $key => $value) {?>
                        <option value="<?=$CariList[$key]["CariID"]?>" <?php if($OrderRow['CariID']==$CariList[$key]["CariID"]){ echo 'selected';} ?> >
                          <?=$CariList[$key]["CariUnvan"]?> (<?=$CariList[$key]["CariName"]?>)
                        </option>
                      <?php } ?>
                    </select>
                    <label for="cari"><?=$W97_Text2?>*</label>
                  </div>                  
                  <div class="accordion hide" id="musteri_accordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button bilgi_title collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#musterinfo" aria-expanded="false" aria-controls="musterinfo">
                          <?=$W97_Text3?>
                        </button>
                      </h2>
                      <div id="musterinfo" class="accordion-collapse collapse" data-bs-parent="#musteri_accordion">
                        <div class="accordion-body py-0">
                          <ul class="ul_sifirla bilgi_ul muster_uljs mb-2">
                            <li class="title"><b><?=$W97_Text4?> </b> <span class="text unvan"></span></li>                           
                            <li class="title"><b><?=$W97_Text5?> </b> <span class="name"></span> <span class="surname"></span></li>                          
                            <li class="title"><b><?=$W97_Text6?> </b> <span class="text kimlik"></span></li>                  
                            <li class="title"><b><?=$W97_Text7?> </b> <span class="text vergidairesi"></span></li>
                            <li class="title"><b><?=$W97_Text8?> </b> <span class="text postakodu"></span></li>
                            <li class="title"><b><?=$W97_Text9?></b> <span class="text vergino"></span></li>                       
                            <li class="title"><b><?=$W97_Text10?></b> <span class="text tel"></span></li>
                            <li class="title"><b><?=$W97_Text11?></b> <span class="text gsm"></span></li>
                            <li class="title"><b><?=$W97_Text12?></b> <span class="text email"></span></li>                          
                            <li class="title"><b><?=$W97_Text13?></b> <span class="text adres"></span></li>                                          
                            <li class="text mt-1"><a class="btn btn-primary cari-edit-js openWindow" modal="modal-xl" h="90vh" href="" href2="<?=$SiteUrl?>cari_form"><?=$W97_Text14?></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-12">
                  <!-- banka sec -->
                  <div class="form-floating mb-3">
                    <select class="form-select select2 banka_secim" required id="banka" aria-label="banka" data-placeholder="<?=$W97_Text15?>*" name="banka">
                      <option hidden=""></option>
                      <?php foreach ($BankaList as $key => $value) {?>
                        <option value="<?=$BankaList[$key]["BankaID"]?>" <?php if($OrderRow['BankaID']==$BankaList[$key]["BankaID"]){ echo 'selected';} ?> >
                          <?=$BankaList[$key]["BankaTitle"]?> (<?=$BankaList[$key]["BankaName"]?>)
                        </option>
                      <?php } ?>
                    </select>
                    <label for="banka"><?=$W97_Text15?>*</label>
                  </div>
                  <div class="accordion hide" id="banka_accordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button bilgi_title collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bankainfo" aria-expanded="false" aria-controls="bankainfo">
                         <?=$W97_Text16?>
                        </button>
                      </h2>
                      <div id="bankainfo" class="accordion-collapse collapse" data-bs-parent="#banka_accordion">
                        <div class="accordion-body py-0">
                          <ul class="ul_sifirla bilgi_ul banka_uljs mb-2">
                            <li class="title"><b><?=$W97_Text17?></b> <span class="text bankatitle">...</span></li>
                            <li class="title"><b><?=$W97_Text18?></b> <span class="text name">...</span></li>
                            <li class="title"><b><?=$W97_Text19?></b> <span class="text iban">...</span></li>
                            <li class="title"><b><?=$W97_Text20?></b> <span class="text para">...</span></li>
                            <li class="title"><b><?=$W97_Text21?></b> <span class="text adres">...</span></li>
                            <li class="text mt-1"><a class="btn btn-primary banka-edit-js openWindow" modal="modal-xl" h="90vh" href="" href2="<?=$SiteUrl?>banka_form"><?=$W97_Text22?></a></li>
                          </ul>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>  
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Ürünler -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_two" aria-expanded="false" aria-controls="accordion_two">
            <?=$W97_Text23?>
          </button>
        </h2>
        <div id="accordion_two" class="accordion-collapse collapse show">
          <div class="accordion-body p-0 m-0 py-4">

            <div class="row m-0 p-0">
              <div class="col-lg-4 col-md-4 col-sm-4 col-9">
                <div class="form-floating">
                  <select class="form-select select2 urun-select-js" id="urun" aria-label="urun" data-placeholder="<?=$W97_Text24?>" name="urun">
                    <option hidden></option>
                    <?php foreach ($ProductList as $key => $value) {?>
                      <option value="<?=$ProductList[$key]["ProductID"]?>">
                        <?php if (!empty($ProductList[$key]["ProductBarkod"])) { ?><?=$ProductList[$key]["ProductBarkod"]?> | <?php } ?><?=htmlspecialchars_decode($ProductList[$key]["ProductName"])?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="urun"><?=$W97_Text25?></label>
                </div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-3">
                <a class="btn btn-success btnsm openWindow" modal="modal-lg" h="90vh" href="<?=$SiteUrl?>product_form"><i class="fa-solid fa-plus pe-1"></i> <span class="smhide"><?=$W80_Text2?></span></a>
              </div>
              <!-- 
                <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="ara" placeholder="ara" name="ara">
                    <label for="ara">Ürün Ara</label>
                  </div>
                </div> 
              -->
            </div>
            <!-- Ürünler -->
            <div class="col-lg-12 col-md-12 col-sm-12 px-2 mt-2 urunler_box"> <!-- Eklenen ürünle buraya geliyor --> </div>

            <div class="col-lg-12 col-md-12 col-sm-12 px-2 mt-2">
              <div class="row m-0 justify-content-end">
                <div class="col-md-4 col-6 ftr-tpl-box" align="right"><b><?=$W97_Text26?></b></div>
                <div class="col-md-3 col-6 ftr-tpl-box" align="right"><span class="net-toplam-js"><?=mony(0,$Currency)?></span></div>
              </div>
              <div class="row m-0 justify-content-end toplamkdv_box">
                <div class="col-md-4 col-6 ftr-tpl-box" align="right"><b><?=$W97_Text27?></b></div>
                <div class="col-md-3 col-6 ftr-tpl-box" align="right"><span class="kdv-toplam-js"><?=mony(0,$Currency)?></span></div>
              </div>
              <div class="row m-0 justify-content-end">
                <div class="col-md-4 col-6 ftr-tpl-box" align="right"><b><?=$W97_Text28?></b></div>
                <div class="col-md-3 col-6 ftr-tpl-box" align="right"><span class="genel-toplam-js"><?=mony(0,$Currency)?></span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Açıklama -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_three" aria-expanded="false" aria-controls="accordion_three">
            <?=$W97_Text29?>
          </button>
        </h2>
        <div id="accordion_three" class="accordion-collapse collapse show">
          <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <div class="accordion-body p-0 m-0 py-4">
              <div class="form-floating mb-3">
                <textarea form="order_form" class="form-control" placeholder="<?=$W97_Text30?>" id="not" name="order_not" style="height: 100px"><?=$OrderRow['OrderNot']?></textarea>
                <label for="not"><?=$W97_Text30?></label>
              </div>


              <div class="row">
              <!-- Date1 -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                  <div class="form-floating">
                    <input form="order_form" type="text" class="form-control date" id="date" required readonly autocomplete="off" placeholder="Rechnungsdatum*" name="date1">
                    <label for="date">Rechnungsdatum*</label>
                  </div>
                </div>
                <!-- Date2 -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                  <div class="form-floating">
                    <input form="order_form" type="text" class="form-control date2" id="date2" readonly autocomplete="off" placeholder="Zahlbar bis" name="date2">
                    <label for="date2">Zahlbar bis</label>
                  </div>
                </div>
                <!-- Fatura durumu -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                  <div class="form-floating mb-3">
                    <select form="order_form" class="form-select" required id="status" aria-label="status" data-placeholder="Status*" name="status">
                      <option <?php if($OrderRow['Status']==2){ echo 'selected';}?> value="2"><?=$W97_Text67?></option> <!-- Beklemede -->
                      <option <?php if($OrderRow['Status']==1){ echo 'selected';}?> value="1"><?=$W97_Text66?></option> <!-- Ödendi -->
                      
                      <!-- <option <?php if($OrderRow['Status']==3){ echo 'selected';}?> value="3"><?=$W97_Text68?></option>
                      <option <?php if($OrderRow['Status']==4){ echo 'selected';}?> value="4"><?=$W97_Text69?></option>
                      <option <?php if($OrderRow['Status']==5){ echo 'selected';}?> value="5"><?=$W97_Text70?></option> -->
                      <option <?php if($OrderRow['Status']==6){ echo 'selected';}?> value="6"><?=$W97_Text71?></option><!-- İptal Edildi -->
                    </select>
                    <label for="status">Status*</label>
                  </div> 
                </div>
              </div>
              <?php if(isset($_GET['id'])){ ?>
                <input form="order_form" type="hidden" name="id" value="<?=$OrderRow['OrderID']?>">
                <input form="order_form" type="hidden" name="oder_update">
                <button form="order_form" type="submit" class="btn_style1"><i class="fa-solid fa-floppy-disk">&nbsp;</i> &nbsp; <?=$W97_Text31?></button>
              <?php }else{ ?>
                <input form="order_form" type="hidden" name="oder_insert">
                <button form="order_form" type="submit" class="btn_style1"><i class="fa-solid fa-floppy-disk">&nbsp;</i> &nbsp; <?=$W97_Text32?></button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<br> <br> <br> <br>

<!-- FOOTER -->
<?php include __DIR__.'/prc/footer.php';?>
<?php include __DIR__.'/prc/footer_meta.php';?>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<!-- datatables -->
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/datatables.js"></script>
<?php include __DIR__.'/prc/modal.php';?>
<script>const iframeModal = new bootstrap.Modal('#iframeModal')</script>
<!-- select2 -->
<script src="<?=BASE_URL.$FolderPath?>assets/select2/select2.min.js"></script>
<script> $('.select2').select2(); </script>
<!-- air datepicker -->
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/lang-<?=$LangSeo?>.js"></script>
<script>
  let dpMin, dpMax;
  <?php if(isset($_GET['id'])){ ?>
    var Date1 = new Date(<?=$OrderRow['OrderUnix']?>*1000);
    var Date2 = new Date(<?=intval($OrderRow['OrderDateEndUnix'])?>*1000);
  <?php } ?>

  dpMin = new AirDatepicker('.date', {
    onSelect({date}) {
      dpMax.update({
        minDate: date       
      })
      dpMin.hide();
    },
    timepicker: false,
    locale: mylang,
    <?php if(isset($_GET['id'])){ ?>selectedDates: [Date1] <?php } ?>
  })

  dpMax = new AirDatepicker('.date2', {
    onSelect({date}) {
      dpMin.update({
        maxDate: date
      })
      dpMax.hide();
    },
    timepicker: false,
    locale: mylang,
    <?php if(isset($_GET['id'])){ ?>selectedDates: [Date2] <?php } ?>
  })
</script>

<script src="<?=ASSETS_PATH?>input-mask/jquery.inputmask.bundle.js"></script>
<script src="<?=ASSETS_PATH?>input-mask/jquery.mask.min.js"></script>
<script>
  $(".currency").inputmask('currency',{
    alias: 'decimal',
    prefix: '',
    rightAlign: false, groupSeparator: '.', clearMaskOnLostFocus: true, radixPoint: '.', autoGroup: true
  });
  $(".kdv").inputmask('currency',{
    alias: 'numeric',
    prefix: '%',
    rightAlign: false, groupSeparator: '.', clearMaskOnLostFocus: true, radixPoint: '.', autoGroup: true
  });
</script>

<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/numeral.min.js"></script>
<script>
  $("body").on("change",".cari_secim",function() {
    let cari_id=$(this).val();
    if(cari_id>0){
      $.ajax({
        type: "POST",
        url: "",
        data: {'cari_info':1, 'jsid':cari_id}
      }).done (function(result){
        console.log(result);
        var obj = JSON.parse(result);
        console.log(obj);
        $('#musteri_accordion').removeClass('hide')
        $('.muster_uljs .unvan').text(obj.CariUnvan); 
        $('.muster_uljs .name').text(obj.CariName); 
        $('.muster_uljs .surname').text(obj.CariSurname); 
        $('.muster_uljs .gsm').text(obj.CariGsm); 
        $('.muster_uljs .tel').text(obj.CariTel); 
        $('.muster_uljs .email').text(obj.CariEmail); 
        $('.muster_uljs .postakodu').text(obj.CariPostakodu); 
        $('.muster_uljs .kimlik').text(obj.CariKimlik); 
        $('.muster_uljs .vergidairesi').text(obj.CariVergiDairesi); 
        $('.muster_uljs .vergino').text(obj.CariVergiNo); 
        $('.muster_uljs .adres').text(obj.CariAdres); 
        let href=$('.cari-edit-js').attr('href2');
        $('.cari-edit-js').attr('href',href+"?id="+cari_id);
      }).fail(function() { console.log( "error" );}).always(function() {});
    }
  });
</script>
<script>
  $("body").on("change",".banka_secim",function() {
    let Bankaid=$(this).val();
    if(Bankaid>0){
      $.ajax({
        type: "POST",
        url: "",
        data: {'banka_info':1, 'JsID':Bankaid}
      }).done (function(result){
        console.log(result);
        var obj = JSON.parse(result);
        console.log(obj);
        $('#banka_accordion').removeClass('hide')
        $('.banka_uljs .bankatitle').text(obj.BankaName); 
        $('.banka_uljs .name').text(obj.BankaUser); 
        $('.banka_uljs .iban').text(obj.BankaIBAN); 
        $('.banka_uljs .hesapno').text(obj.BankaHesapNo); 
        $('.banka_uljs .para').text(obj.BankaParaBirimi); 
        $('.banka_uljs .subekod').text(obj.BankaSubeKodu); 
        $('.banka_uljs .subead').text(obj.BankaSubeAd); 
        $('.banka_uljs .kimlik').text(obj.BankaKimlik); 
        $('.banka_uljs .adres').text(obj.BankaAdres);
        let href=$('.banka-edit-js').attr('href2');
        $('.banka-edit-js').attr('href',href+"?id="+Bankaid);
      }).fail(function() { console.log( "error" );}).always(function() {});
    }
  });
</script>
<script>
  let BASKET=[];
  let NetToplam=0;
  let ToplamKDV=0;
  let GenelToplam=0;
  let urunSirasi=0;
  <?php if($OrderRow['OrderUrun']){ ?>
    BASKET = JSON.parse('<?=$OrderRow['OrderUrun']?>');
    console.log(BASKET);
    SepetiGoster();
  <?php } ?>
  $("body").on("change",".urun-select-js",function() {
    let id=$(this).val();
    if (id>0){
       UrunSecildi(id,function() {$('.urun-select-js').val(null).trigger('change'); })
    }
  });

  $("body").on("input",'input[name="fiyat"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });
  $("body").on("input",'input[name="kdv"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });
  $("body").on("input",'input[name="kdvdurum"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });
  $("body").on("input",'input[name="miktar"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });  

  
  $("body").on("click",'.sil-btn-js',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    //$('#urun-'+id+'-'+sira).remove();
    BASKET.splice(sira,1);  
    SepetiGoster();
    console.log(BASKET);
  });

  function UrunSecildi(UrunID,callback){
      $.ajax({
        type: "POST",
        url: "",
        data: {'urun_info':1, 'jsid':UrunID}
      }).done (function(result){
        let SecilenUrun={};
        var obj = JSON.parse(result);
        if(obj.result=='success'){
          let ProductKDV=0;
          if(parseFloat(obj.ProductKDV)>0){ ProductKDV=parseFloat(obj.ProductKDV); }
          SecilenUrun['ID']=obj.ProductID;
          SecilenUrun['Name']=obj.ProductName;
          SecilenUrun['Fiyat']=parseFloat(obj.ProductFiyat);
          SecilenUrun['KDV']=ProductKDV;
          SecilenUrun['KDVDurum']=obj.ProductKdvDurum;
          SecilenUrun['Miktar']=1;
          SecilenUrun['Toplam']=kdvHesapla(parseFloat(obj.ProductFiyat),ProductKDV,parseFloat(obj.ProductKdvDurum),1);
          //SecilenUrun['Toplam']=parseFloat(obj.ProductFiyat);
          BASKET.push(SecilenUrun);  
          //$('.urun-select-js').val();
        }
        console.log(BASKET);
        SepetiGoster();
      }).fail(function(){ console.log( "error" );}).always(function(){
        // UrunSecildi fonksiyonunun işlemleri tamamlandıktan sonra callback fonksiyonunu çağır
        if(typeof callback === 'function') {
            callback();
        }
      });
  }

  //Formu gönder
  $('.form_send2').on("submit", function (e){
    e.preventDefault(); 
    $('.form_loader').css('display', 'flex'); 
    var form = $(this);
    var url = form.attr('action');
    let formData = new FormData(this); // Mevcut FormData nesnesini oluşturun
    formData.append('BASKET', JSON.stringify(BASKET));
    formData.append('NetToplam', NetToplam);
    formData.append('ToplamKDV', ToplamKDV);
    formData.append('GenelToplam', GenelToplam);

    $.ajax({
      type: "POST",
      url: url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData
    }).done (function(result){
      $('.form_loader').css('display', 'none');    
      console.log(result);
      let obj = JSON.parse(result);

      swal({title: obj.title,text: obj.subtitle, icon: obj.icon,button:obj.btn});
      if (obj.sonuc=="success" && obj.git) {
        window.location.href = obj.git;  
      } 
      if (obj.sonuc=="success") {
        let modal_kapat=$('input[name="modal_kapat"]').val();
        if (modal_kapat){
          console.log(modal_kapat);
          let myModal = new bootstrap.Modal('#'+modal_kapat)
          myModal.hide()
        }
      }
      if(obj.yap=="reset") {
        console.log("#"+obj.formid);
        $("#"+obj.formid).trigger("reset");
      }                                 
    }).fail(function(){ 
      console.log( "error" );$('.form_loader').css('display', 'none'); 
    }).always(function(){
      $('.form_loader').css('display', 'none');
    });
  });
</script>
<script>
  window.addEventListener("message", function(event) {
    var receivedData = event.data;    
    if(receivedData){
      if(receivedData.sonuc=='success'){      
        let modalToggle = document.getElementById('iframeModal'); 
        iframeModal.hide(modalToggle)
      }
      console.log(receivedData);
      if(receivedData.Data.ProductID){
        UrunSecildi(receivedData.Data.ProductID)      
          var newOptions = [
            { id: receivedData.Data.ProductID, text: receivedData.Data.ProductName }
          ];
          // Select2'ye yeni seçenekleri ekle
          $('.urun-select-js').select2({
              data: newOptions,
              tags: true // Eğer etiketlere izin vermek istiyorsanız
          });
      }
    }    
  });
</script>

</body>
</html>