<?php 


if(isset($_GET['id'])) {
  $PersonalID=intval($_GET['id']);
  $DataSorgu=$DNCrud->ReadData("personal",["sql"=>"WHERE FirmaID={$Firma['FirmaID']} AND PersonalID={$PersonalID}"]);
  $personelRow=$DataSorgu->fetch(PDO::FETCH_ASSOC);

  $Title=$W79_Text48;
}else{
  $Title=$W79_Text12;
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
          <?php if(!$IframeGeldi){ ?><a class="btn btn-dark btnsm" href="<?=$SiteUrl.$URL_Personnel?>"><i class="fa-solid fa-angle-left"></i></a><?php } ?>
        </h4>
        <hr>

        <form id="edit" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
          <div class="container-xxl p-0">
            <div class="row m-0 p-0">
              <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                 <div class="form-floating">
                  <input type="text" class="form-control" id="name" placeholder="<?=$W79_Text13?>" name="name" value="<?=$personelRow['PersonalName']?>">
                  <label for="name"><?=$W79_Text13?></label>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="surname" placeholder="<?=$W79_Text14?>" name="surname" value="<?=$personelRow['PersonalSurname']?>">
                  <label for="surname"><?=$W79_Text14?></label>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="cinsiyet" placeholder="ANREDE" name="cinsiyet" value="<?=$personelRow['Cinsiyet']?>">
                  <label for="cinsiyet">ANREDE</label>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="kimlik" placeholder="<?=$W79_Text32?>" name="kimlik" value="<?=$personelRow['PersonalKimlik']?>">
                  <label for="kimlik"><?=$W79_Text32?></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                 <div class="form-floating">
                  <input type="text" class="form-control" id="unvan" placeholder="<?=$W79_Text15?>" name="unvan" value="<?=$personelRow['PersonalUnvan']?>">
                  <label for="unvan"><?=$W79_Text15?></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
               <div class="form-floating">
                  <input type="text" class="form-control" id="isbirim" placeholder="<?=$W79_Text16?>" name="isbirim" value="<?=$personelRow['PersonalBirim']?>">
                  <label for="isbirim"><?=$W79_Text16?></label>
                </div>
              </div>

            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="gsm" placeholder="<?=$W79_Text17?>" name="gsm" value="<?=$personelRow['PersonalGsm']?>">
                <label for="gsm"><?=$W79_Text17?></label>
              </div>
            </div>
            <!-- Tel -->
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="tel" placeholder="<?=$W79_Text18?>" name="tel">
                <label for="tel"><?=$W79_Text18?></label>
              </div>
            </div> -->
            <!-- Mail -->
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="email" class="form-control" id="email" placeholder="<?=$W79_Text19?>" name="email" value="<?=$personelRow['Email']?>">
                <label for="email"><?=$W79_Text19?></label>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="bolge" placeholder="<?=$W79_Text20?>" name="bolge">
                <label for="bolge"><?=$W79_Text20?></label>
              </div>
            </div> -->

            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <select class="form-select" id="ulke" aria-label="<?=$W79_Text21?>" name="ulke">
                  <option value="0"><?=$W79_Text21?></option>
                  <?php foreach ($UlkeList as $key => $value) {?>
                    <option value="<?=$UlkeList[$key]["UlkeID"]?>">
                      <?=$UlkeList[$key]["UlkeName"]?>
                    </option>
                  <?php } ?>
                </select>
                <label for="ulke"><?=$W79_Text21?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <select class="form-select" id="sehir" aria-label="<?=$W79_Text22?>" name="sehir">
                  <option value="0"><?=$W79_Text22?></option>
                  <?php foreach ($CityList as $key => $value) {?>
                    <option value="<?=$CityList[$key]["CityID"]?>">
                      <?=$CityList[$key]["CityName"]?>
                    </option>
                  <?php } ?>
                </select>
                <label for="sehir"><?=$W79_Text22?></label>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="ilce" placeholder="<?=$W79_Text23?>" name="ilce">
                <label for="ilce"><?=$W79_Text23?></label>
              </div>
            </div> -->
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="cadde" placeholder="<?=$W79_Text24?>" name="cadde">
                <label for="cadde"><?=$W79_Text24?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="sokak" placeholder="<?=$W79_Text25?>" name="sokak">
                <label for="sokak"><?=$W79_Text25?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="bina" placeholder="<?=$W79_Text26?>" name="bina">
                <label for="bina"><?=$W79_Text26?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="apt" placeholder="<?=$W79_Text27?>" name="apt">
                <label for="apt"><?=$W79_Text27?></label>
              </div>
            </div> -->
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="daireno" placeholder="<?=$W79_Text28?>" name="daireno" value="<?=$personelRow['PersonalDaireNo']?>">
                <label for="daireno"><?=$W79_Text28?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="postakodu" placeholder="<?=$W79_Text29?>" name="postakodu" value="<?=$personelRow['PersonalPostaKodu']?>">
                <label for="postakodu"><?=$W79_Text29?></label>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
             <div class="form-floating">
                <input type="text" class="form-control" id="konum" placeholder="<?=$W79_Text30?>" name="konum">
                <label for="konum"><?=$W79_Text30?></label>
              </div>
            </div> -->
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <textarea class="form-control textarea100" placeholder="<?=$W79_Text31?>" id="adres" name="adres"><?=$personelRow['PersonalAdres']?></textarea>
                <label for="adres"><?=$W79_Text31?></label>
              </div>
            </div>

            <!-- datepciker -->
            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
              <div class="form-floating">
                <input type="text" class="form-control date" autocomplete="off" id="isbasi" placeholder="<?=$W79_Text34?>" name="isbasi" value="<?=$personelRow['PersonelIsbasi']?>">
                <label for="isbasi"><?=$W79_Text34?></label>
              </div>
            </div>
            <!-- datepciker -->
            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
              <div class="form-floating">
                <input type="text" class="form-control date" autocomplete="off" id="iscikis" placeholder="iscikis<?=$W79_Text35?>" name="iscikis" value="<?=$personelRow['PersonelCikis']?>">
                <label for="iscikis"><?=$W79_Text35?></label>
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <textarea class="form-control textarea100" placeholder="desc<?=$W79_Text36?>" id="desc" name="desc"><?=$personelRow['PersonalDesc']?></textarea>
                <label for="desc"><?=$W79_Text36?></label>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="bankaadi" placeholder="bankaadi<?=$W79_Text37?>" name="bankaadi">
                <label for="bankaadi"><?=$W79_Text37?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="bankaadsoyad" placeholder="bankaadsoyad<?=$W79_Text38?>" name="bankaadsoyad">
                <label for="bankaadsoyad"><?=$W79_Text38?></label>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="bankaiban" placeholder="bankaiban<?=$W79_Text39?>" name="bankaiban">
                <label for="bankaiban"><?=$W79_Text39?></label>
              </div>
            </div> -->

             <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="sigortano" placeholder="sigortano<?=$W79_Text40?>" name="sigortano" value="<?=$personelRow['PersonelSigortano']?>">
                <label for="sigortano"><?=$W79_Text40?></label>
              </div>
            </div>
            <!--<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="resim" name="resim">
                <label class="input-group-text" for="resim"><?=$W79_Text41?></label>
              </div>
            </div> -->

            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
              <label class="nnt_input_box" for="durum">
                <input type="checkbox" class="nnt_input" id="durum" name="durum" value="1" checked />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok"><?=$W79_Text44?></span>
                <span class="no"><?=$W79_Text45?></span>
              </label>
            </div>

              <?php if($IframeGeldi){ ?>
                <input type="hidden" name="iframeModal" value="1">
              <?php } ?>
            </div>

              <div class="<?php if($IframeGeldi){ echo 'form_footer'; }?>">
                <?php if (isset($_GET['id'])) { ?>
                  <input type="hidden" name="PersonalID" value="<?=$personelRow['PersonalID']?>">
                  <input type="hidden" name="form_edit" value="1">
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W79_Text49?></button></div>
                  </div>                  
                <?php }else{ ?>
                  <input type="hidden" name="form_add" value="1">           
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button  type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W79_Text47?></button> </div>
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