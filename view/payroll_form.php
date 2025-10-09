<?php 
include(__DIR__."/app/kontrol.php");  
include("app/cari.php");



if(isset($_GET['id'])) {

  $PayCode=intval($_GET['id']);
  $sql=$DNCrud->ReadData("personal_pay",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PayCode={$PayCode}"]);
  $PayrollRow=$sql->fetch(PDO::FETCH_ASSOC);

  $Title=$W78_Text48;
}else{
  $Title=$W94_Text12;
}
if(isset($_GET['screen']) && $_GET['screen']=='iframeWindow'){  
  $IframeGeldi=1;
}
include("prc/top.php");
?>
<!-- datatables -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/responsive.dataTables.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.css">
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/style.css<?=$UPDATE_VERSION?>">
<!-- air datepicker -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.css">
</head>
<body>
  <!-- HEADER -->
  <?php if(!$IframeGeldi){ include __DIR__.'/prc/header.php'; }?>
  <!-- CONTENT -->
  <section>

    <div class="container-xxl mb-5">
      <div class="table_body_bg mt-2 mb-2">
        
        <h4 class="d-flex justify-content-between w-100">          
          <span class="pe-3"><?=$Title?></span>
          <?php if(!$IframeGeldi){ ?><a class="btn btn-dark btnsm" href="<?=$SiteUrl.$URL_Payroll?>"><i class="fa-solid fa-angle-left"></i></a><?php } ?>
        </h4>
        <hr>

        <form id="edit" class="w-100 form_send" action="" method="post">
          <div class="container-xxl p-0">
            <div class="row m-0 p-0">
              <!-- Sol Start-->
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                
                  <!-- Bodro Seçim -->
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-floating">
                      <select class="form-select kate_secim" id="kate" aria-label="<?=$W94_Text22?>*" name="kate" required>
                        <option hidden="" value=""><?=$W94_Text22?></option>
                        <?php foreach ($KateList as $key => $value) {?>
                          <option <?php if($PayrollRow['KateID']==$KateList[$key]["KateID"]){ echo 'selected';} ?> value="<?=$KateList[$key]["KateID"]?>">
                            <?=$KateList[$key]["KateName"]?>
                          </option>
                        <?php } ?>
                      </select>
                      <label for="kate"><?=$W94_Text22?>*</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-floating">
                      <textarea class="form-control" placeholder="Açıklama" id="desc" name="desc"><?=$PayrollRow['PayDesc']?></textarea>
                      <label for="desc">Desc</label>
                    </div>
                  </div>
                  <!-- Personel Seç -->
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-floating">
                      <select class="form-select perso_secim" id="personel" aria-label="<?=$W94_Text14?>*" name="personel" required>
                        <option hidden="" value=""><?=$W94_Text14?></option>
                        <?php foreach ($PersoList as $key => $value) {?>
                          <option  <?php if($PayrollRow['PersonalID']==$PersoList[$key]["PersonalID"]){ echo 'selected';} ?> value="<?=$PersoList[$key]["PersonalID"]?>">
                            <?=$PersoList[$key]["PersonalName"]?>  <?=$PersoList[$key]["PersonalSurname"]?>
                          </option>
                        <?php } ?>
                      </select>
                      <label for="personel"><?=$W94_Text14?>*</label>
                    </div>
                  </div>
                  <!-- Peronel Name -->
                  <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                     <div class="form-floating">
                      <input type="text" class="form-control name-js" id="name" placeholder="<?=$W94_Text15?>" name="name" value="<?=$PayrollRow['PersonalName']?>">
                      <label for="name"><?=$W94_Text15?></label>
                    </div>
                  </div>
                  <!-- Personel Soyad -->
                  <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                     <div class="form-floating">
                      <input type="text" class="form-control surname-js" id="surname" placeholder="<?=$W94_Text16?>" name="surname" value="<?=$PayrollRow['PersonalSurname']?>">
                      <label for="surname"><?=$W94_Text16?></label>
                    </div>
                  </div>

                  <!-- Date1 -->
                  <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                    <div class="form-floating">
                      <input type="text" class="form-control date1" id="date" required readonly autocomplete="off" placeholder="<?=$W94_Text17?>*" name="date1">
                      <label for="date"><?=$W94_Text17?>*</label>
                    </div>
                  </div>
                  <!-- Date2 -->
                  <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                    <div class="form-floating">
                      <input type="text" class="form-control date2" id="date2"  readonly autocomplete="off" placeholder="<?=$W94_Text18?>" name="date2">
                      <label for="date2"><?=$W94_Text18?></label>
                    </div>
                  </div>
                  <!-- Total Saat -->
                  <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                     <div class="form-floating">
                      <input type="number" class="form-control" id="saat" placeholder="<?=$W94_Text19?>" name="saat"  step="0.01" value="<?=$PayrollRow['CalismaSaat']?>">
                      <label for="saat"><?=$W94_Text19?></label>
                    </div>
                  </div>
                  <!-- Fiyat -->
                  <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="fiyat" placeholder="<?=$W94_Text20?>*" name="fiyat"  step="0.01" required value="<?=$PayrollRow['Ucret']?>">
                      <label for="fiyat"><?=$W94_Text20?>*</label>
                    </div>
                  </div>
                  <!-- Hesapla -->
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="hesapla" placeholder="<?=$W94_Text21?>" name="hesapla" disabled value="<?=$PayrollRow['ToplamUcret']?>">
                      <label for="hesapla"><?=$W94_Text21?></label>
                    </div>
                  </div>
                
                </div>                
              </div>
              <!-- Sol End-->
              <!-- Sag Start-->
                <div class="col-lg-6 col-md-6 col-sm-6 align-content-start">
                  <div class="row">

                      <div class="vergiler_gel"><!-- Vergiler gel --> </div>
                

                    <!-- Bodro Kategori -->
                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                      <div class="form-floating">
                        <select class="form-select kate_secim" id="kate" aria-label="<?=$W94_Text22?>" name="kate">
                          <option value="0"><?=$W94_Text22?></option>
                          <?php foreach ($KateList as $key => $value) {?>
                            <option value="<?=$KateList[$key]["KateID"]?>">
                              <?=$KateList[$key]["KateName"]?>
                            </option>
                          <?php } ?>
                        </select>
                        <label for="kate"><?=$W94_Text22?></label>
                      </div>
                    </div> -->

                

                    <!-- <div class="">
                      <div class="pro_box" id='vergi-${vergi.ID}-${i}' data-fiyat="">
                        <b class="pro_name mb-2">
                        <span class="satir_1">${vergi.Name}</span>
                        </b>
                        <div class="form_row">
                          <div class="input_box">
                            <div class="form-floating input_box_2">
                              <input type="number" required class="form-control" id="kdv" data-sira="${i}" data-id="${vergi.ID}" placeholder="${TextKdv}" name="kdv" value="${vergi.KDV}">
                              <label for="kdv">${TextKdv}</label>
                            </div>
                          </div>
                          <div class="input_box">
                            <div class="form-floating input_box_2">
                              <input type="number" required class="form-control" id="mktr" data-sira="${i}" data-id="${vergi.ID}" placeholder="${TextMiktar}" name="miktar" value="${Miktar}">
                              <label for="mktr">${TextMiktar}</label>
                            </div>
                          </div>
                          <b class="toplam toplam-${vergi.ID}-${i}">${Toplam}</b>            
                        </div>
                      </div>
                    </div> -->


                  </div>
                </div>
              <!-- Sag End-->

                

       

              <?php if($IframeGeldi){ ?>
                <input type="hidden" name="iframeModal" value="1">
              <?php } ?>
              </div>

              <div class="<?php if($IframeGeldi){ echo 'form_footer'; }?>">
                <?php if (isset($_GET['id'])) { ?>
                  <input type="hidden" name="PayID" value="<?=$PayrollRow['PayID']?>">
                  <input type="hidden" name="form_update" value="maasbodro">
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-floppy-disk"></i> &nbsp; <?=$W94_Text27?></button></div>
                  </div>                  
                <?php }else{ ?>
                  <input type="hidden" name="form_insert" value="maasbodro">           
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button  type="submit" class="btn_style1"><i class="fa-solid fa-floppy-disk"></i> &nbsp; <?=$W94_Text25?></button> </div>
                  </div>  
                <?php } ?>
              </div>
              

            
          </div>
        </form>

      </div><br>
    </div>
  </section>







<!-- FOOTER -->
<?php if(!$IframeGeldi){ include __DIR__.'/prc/footer.php'; }?>
<?php include __DIR__.'/prc/footer_meta.php';?>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<!-- datatables -->
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/datatables.js"></script>
<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<!-- air datepicker -->
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/lang-<?=$LangSeo?>.js"></script>
<script>
  let dpMin, dpMax;
  <?php if(isset($_GET['id'])){ ?>
    var Date1 = new Date(<?=strtotime($PayrollRow['IsGirisTarih'])?>*1000);
    var Date2 = new Date(<?=intval(strtotime($PayrollRow['IsCikisTarih']))?>*1000);
  <?php } ?>
  dpMin = new AirDatepicker('.date1', {
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
<!-- Personel List -->
<script>
  $("body").on("change",".perso_secim",function() {
    let persoIDjs=$(this).val();
    if (persoIDjs>0){
      $.ajax({
        type: "POST",
        url: "",
        data: {'perso_info':1, 'persoIDjs':persoIDjs}
      }).done(function(result){
        console.log(result);
        let obj = JSON.parse(result);
        $('.name-js').val(obj.PersonalName)
        $('.surname-js').val(obj.PersonalSurname)

      }).fail(function() { console.log( "error" );}).always(function() {});
    }else{
      $('.name-js').val('')
      $('.surname-js').val('')
    }
  });
</script>
<!-- Saat ve fiyat alanlarındaki değerleri değiştiğinde hesaplama yap -->
<script>
  $("#saat, #fiyat").on("input", function() {
    // Saat ve fiyatı al
    var saat = parseFloat($("#saat").val()) || 1;
    var fiyat = parseFloat($("#fiyat").val()) || 0;
    // Hesaplama yap
    var toplamTutar = saat * fiyat;
    // Sonucu "Toplam Tutar" alanına yazdır
    $("#hesapla").val(toplamTutar.toFixed(2));

    let kate_id= $(".kate_secim").val();
    if (kate_id>0){
      VergileriHesapla(kate_id,saat,fiyat)
    }
  });
  $("#saat2, #fiyat2").on("input", function() {
    // Saat ve fiyatı al
    var saat = parseFloat($("#saat2").val()) || 1;
    var fiyat = parseFloat($("#fiyat2").val()) || 0;
    // Hesaplama yap
    var toplamTutar = saat * fiyat;
    // Sonucu "Toplam Tutar" alanına yazdır
    $("#hesapla2").val(toplamTutar.toFixed(2));
    let kate_id= $(".kate_secim").val();
    if (kate_id>0){
      VergileriHesapla(kate_id,saat,fiyat)
    }
  });
</script>

<!-- Vergi Turu seçildi -->
<script>
  $("body").on("change",".kate_secim",function() {
    let kate_id=$(this).val();
    var saat = parseFloat($("#saat").val()) || 0;
    var fiyat = parseFloat($("#fiyat").val()) || 0;    
    if (kate_id>0){
      VergileriHesapla(kate_id,saat,fiyat)
    }else{
      $('.vergiler_gel').html(' ');
    }
  });

  function VergileriHesapla(VergiKate,Saat,Fiyat){
    $.ajax({
      type: "POST",
      url: "",
      data: {'verhi_hesapla':1, 'kate_id':VergiKate, 'saat':Saat, 'ucret':Fiyat}
    }).done(function(result){
      console.log(result);
      let obj = JSON.parse(result);

      let vergiler=obj.Vergiler
      let vergiHtml='';
      for(var i=0; i<vergiler.length; i++){
       let vergi= vergiler[i];
       let simge='';
        if (vergi.VergiTuru=='yuzde'){
          simge='%';
        }
       vergiHtml+=`
              <div class="row" id='' data-fiyat="">
                <div class="col-6">${vergi.VergiName}</div>
                <div class="col-2">${vergi.VergiDeger}${simge}</div>
                <div class="col-2">${obj.ToplamUcret}</div>
                <div class="col-2" align="right">${vergi.Tutar}</div>                            
              </div>`;      
    }
    vergiHtml+=`
              <div class="row" id='' data-fiyat="">
                <div class="col-9"><b>TOTAL ABZÜGE</b></div>
                <div class="col-3" align="right">${obj.VergiliUcret}</div>                            
              </div>
              <div class="row" id='' data-fiyat="">
                <div class="col-9"><b>Rundungsdifferenz</b></div>
                <div class="col-3" align="right">${obj.YuvarlamaFarki}</div>                            
              </div>
              <div class="row" id='' data-fiyat="">
                <div class="col-9"><b>Nettolohn</b></div>
                <div class="col-3" align="right">${obj.YuvarlanmisUcret}</div>                            
              </div>
              `;  
    $('.vergiler_gel').html(vergiHtml);
                        

      console.log(obj)
    }).fail(function() { console.log( "error" );}).always(function() {});
  }


  <?php if(isset($_GET['id'])){ ?>
    $( document ).ready(function() {
    let kate_id= $(".kate_secim").val();
    var saat = parseFloat($("#saat").val()) || 1;
    var fiyat = parseFloat($("#fiyat").val()) || 0;
    VergileriHesapla(kate_id,saat,fiyat)
    });
  <?php } ?>
 </script>
</body>
</html>