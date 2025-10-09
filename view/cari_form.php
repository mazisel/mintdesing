<?php 
include(__DIR__."/app/kontrol.php");  
include("app/cari.php");

if(isset($_GET['id'])) {
  $Title=$W78_Text48;
}else{
  $Title=$W78_Text17;
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
          <?php if(!$IframeGeldi){ ?><a class="btn btn-dark btnsm" href="<?=$SiteUrl?>customer"><i class="fa-solid fa-angle-left"></i></a><?php } ?>
        </h4>
        <hr>

        <form id="edit" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
          <div class="container-xxl p-0">
            <div class="row m-0 p-0">
              <!-- unvan -->
              <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="unvan" placeholder="<?=$W78_Text18?>" name="unvan" value="<?=$cariRow['CariUnvan']?>">
                  <label for="unvan"><?=$W78_Text18?></label>
                </div>
              </div>
              <!-- Ad -->
              <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" placeholder="<?=$W78_Text19?>" name="name" value="<?=$cariRow['CariName']?>">
                  <label for="name"><?=$W78_Text19?></label>
                </div>
              </div>
              <!-- Soyad -->
              <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="surname" placeholder="<?=$W78_Text20?>" name="surname" value="<?=$cariRow['CariSurname']?>">
                  <label for="surname"><?=$W78_Text20?></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="email" class="form-control" id="email" placeholder="<?=$W78_Text23?>" name="email" value="<?=$cariRow['CariEmail']?>">
                  <label for="email"><?=$W78_Text23?></label>
                </div>
              </div>
              <!-- Gsm -->
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="gsm" placeholder="<?=$W78_Text21?>" name="gsm" value="<?=$cariRow['CariGsm']?>">
                  <label for="gsm"><?=$W78_Text21?></label>
                </div>
              </div>
              <!-- Tel -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="tel" placeholder="<?=$W78_Text22?>" name="tel" value="<?=$cariRow['CariTel']?>">
                  <label for="tel"><?=$W78_Text22?></label>
                </div>
              </div> -->
              <!-- EMail -->
              
              
              
              <!-- Adres satır1 -->
              <div class="col-lg-10 col-md-10 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="adres" placeholder="<?=$W78_Text33?>" name="adres" value="<?=$cariRow['CariAdres']?>" >
                  <label for="adres"><?=$W78_Text33?></label>
                </div>
              </div>
              <!-- Adres satır2 -->
              <div class="col-lg-2 col-md-2 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="adres2" placeholder="<?=$W78_Text34?>" name="adres2" value="<?=$cariRow['CariAdres2']?>" >
                  <label for="adres2"><?=$W78_Text34?></label>
                </div>
              </div>
              <!-- Posta kodu -->
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="postakodu" placeholder="<?=$W78_Text32?>" name="postakodu" value="<?=$cariRow['CariPostakodu']?>" >
                  <label for="postakodu"><?=$W78_Text32?></label>
                </div>
              </div>
              <!-- Sehir -->
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="sehir" placeholder="<?=$W78_Text24?>" name="sehir" value="<?=$cariRow['CariCity']?>" >
                  <label for="sehir"><?=$W78_Text24?></label>
                </div>
              </div>
              <!-- Adres -->
              <!--
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="form-floating">
                    <textarea class="form-control textarea100" placeholder="<?=$W78_Text34?>" id="adres3" name="adres3"><?=$cariRow['CariAdres3']?></textarea>
                    <label for="adres3"><?=$W78_Text34?></label>
                  </div>
                </div>
              -->
            <!-- Ülke -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <select class="form-select" id="ulke" aria-label="<?=$W78_Text25?>" name="ulke">
                    <option><?=$W78_Text25?></option>
                    <?php foreach ($UlkeList as $key => $value) {?>
                      <option value="<?=$UlkeList[$key]["UlkeID"]?>">
                        <?=$UlkeList[$key]["UlkeName"]?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="ulke"><?=$W78_Text25?></label>
                </div>
              </div> -->
              <!-- Şehir -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <select class="form-select" id="sehir" aria-label="<?=$W78_Text26?>" name="sehir">
                    <option><?=$W78_Text26?></option>
                    <?php foreach ($CityList as $key => $value) {?>
                      <option value="<?=$CityList[$key]["CityID"]?>">
                        <?=$CityList[$key]["CityName"]?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="sehir"><?=$W78_Text26?></label>
                </div>
              </div> -->
              <!-- Cadde -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="cadde" placeholder="<?=$W78_Text27?>" name="cadde" value="<?=$cariRow['CariCadde']?>">
                  <label for="cadde"><?=$W78_Text27?></label>
                </div>
              </div> -->
              <!-- Sokak -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="sokak" placeholder="<?=$W78_Text28?>" name="sokak" value="<?=$cariRow['CariSokak']?>">
                  <label for="sokak"><?=$W78_Text28?></label>
                </div>
              </div> -->
              <!-- Bina -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="bina" placeholder="<?=$W78_Text29?>" name="bina" value="<?=$cariRow['CariBina']?>">
                  <label for="bina"><?=$W78_Text29?></label>
                </div>
              </div> -->

              <!-- Daireno -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="daireno" placeholder="<?=$W78_Text31?>" name="daireno" value="<?=$cariRow['CariDaireno']?>">
                  <label for="daireno"><?=$W78_Text31?></label>
                </div>
              </div> -->

              <!-- Konum -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="konum" placeholder="<?=$W78_Text33?>" name="konum" value="<?=$cariRow['CariKonum']?>">
                  <label for="konum"><?=$W78_Text33?></label>
                </div>
              </div> -->

              <!-- Kimlik -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                 <div class="form-floating">
                  <input type="text" class="form-control" id="kimlik" placeholder="<?=$W78_Text35?>" name="kimlik" value="<?=$cariRow['CariKimlik']?>">
                  <label for="kimlik"><?=$W78_Text35?></label>
                </div>
              </div> -->
              <!-- Vergi Dairesi -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="vergidairesi" placeholder="<?=$W78_Text36?>" name="vergidairesi" value="<?=$cariRow['CariVergiDairesi']?>">
                  <label for="vergidairesi"><?=$W78_Text36?></label>
                </div>
              </div> -->
              <!-- Vergi no -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="vergino" placeholder="<?=$W78_Text37?>" name="vergino" value="<?=$cariRow['CariVergiNo']?>">
                  <label for="vergino"><?=$W78_Text37?></label>
                </div>
              </div> -->
              <!-- Açıkla -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <textarea class="form-control textarea100" placeholder="<?=$W78_Text38?>" id="desc" name="desc"><?=$cariRow['CariDesc']?></textarea>
                  <label for="desc"><?=$W78_Text38?></label>
                </div>
              </div>
              <!-- Banka Adı -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="bankaadi" placeholder="bankaadi<?=$W78_Text39?>" name="bankaadi" value="<?=$cariRow['CariBankaAd']?>">
                  <label for="bankaadi"><?=$W78_Text39?></label>
                </div>
              </div> -->
              <!-- Banka ad soyad -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="bankaadsoyad" placeholder="<?=$W78_Text40?>" name="bankaadsoyad" value="<?=$cariRow['CariBankaAdSoyad']?>">
                  <label for="bankaadsoyad"><?=$W78_Text40?></label>
                </div>
              </div> -->
              <!-- Banka iban -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="bankaiban" placeholder="<?=$W78_Text41?>" name="bankaiban" value="<?=$cariRow['CariBankaIban']?>">
                  <label for="bankaiban"><?=$W78_Text41?></label>
                </div>
              </div> -->
              <!-- Resim -->
              <!-- <div class="col-md-6 mb10 p0 pl5">
                <?php if($cariRow['CariLogo']){ ?>
                <div class="row">
                  <div class="col-md-4 control-label"></div>
                  <div class="col-md-8 col-sm-8 col-xs-12">     
                    <div style="background: #fbfbfb; padding: 2px;">
                      <img style="max-height: 120px; max-width: 200px;" src="<?=BASE_URL.$FolderPath?>images/cari/<?=$cariRow['CariLogo']?>"> 
                    </div>   
                  </div>
                </div>
                <?php } ?>
                <div class="row">
                  <div class="control-label col-md-4 col-sm-4 col-xs-12"> <?=$W78_Text42?></div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="file-loading">
                      <input class="file file-inpt-select" type="file" name="resim"  data-max-file-count='1' accept="image/*">
                    </div>
                  </div>
                </div>                 
              </div> -->
              <!-- Musteri -->
              <!-- <div class="col-lg-12 col-md-12 col-sm-12 d-flex mb-2">
                <div class="form-check pe-3">
                  <input class="form-check-input" type="checkbox" value="1" id="musteri" name="musteri" <?php if($cariRow['CariMusteri']==1){ echo 'checked'; } ?>>
                  <label class="form-check-label" for="musteri"> <?=$W78_Text43?> </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="tedarikci" name="tedarikci" <?php if($cariRow['CariTedarikci']==1){ echo 'checked'; } ?>>
                  <label class="form-check-label" for="tedarikci"> <?=$W78_Text44?> </label>
               </div>
             </div> -->
             <input type="hidden" value="1" name="musteri">
             <!-- Statu -->
             <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
              <label class="nnt_input_box" for="durum">
                <input type="hidden" name="durum" value="0">
                <input type="checkbox" class="nnt_input" id="durum" name="durum" value="1" <?php if($cariRow['CariDurum'] OR !isset($_GET['id'])){ echo 'checked'; } ?> />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok"><?=$W78_Text45?></span>
                <span class="no"><?=$W78_Text46?></span>
              </label>
            </div>

            <?php if($IframeGeldi){ ?>
              <input type="hidden" name="iframeModal" value="1">
            <?php } ?>
          </div>

          <div class="<?php if($IframeGeldi){ echo 'form_footer'; }?>">
            <?php if (isset($_GET['id'])) { ?>
              <input type="hidden" name="cari_id" value="<?=$cariRow['CariID']?>">
              <input type="hidden" name="form_update" value="1">
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W78_Text49?></button></div>
              </div>                  
            <?php }else{ ?>
              <input type="hidden" name="form_add" value="1">           
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                <div class="btn_col"><button  type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W78_Text47?></button> </div>
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


<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/file_upload/fileinput.css">
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/fileinput.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/<?=$LangSeo?>.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/theme_file.js"></script>
<style>.kv-file-upload{display: none !important;}</style>
<script>
  $(".file-inpt-select").fileinput({
    language: '<?=$LangSeo?>',
    theme: 'fa',    
    allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'PNG', 'GIF', 'JPEG'],
    overwriteInitial: false,
    maxFileSize: 5000,
    maxFilesNum: 50,
    showUpload: false,
    dropZoneEnabled: false        
  });
</script>


</body>
</html>