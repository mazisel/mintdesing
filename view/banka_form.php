<?php 
include(__DIR__."/app/kontrol.php");  
include(__DIR__."/app/banka.php");

if(isset($_GET['id'])) {
  $Title=$W87_Text29;
}else{
  $Title=$W87_Text14;
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

              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="title" placeholder="<?=$W87_Text15?>" name="title" value="<?=$bankaRow['BankaTitle']?>">
                  <label for="title"><?=$W87_Text15?></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" placeholder="<?=$W87_Text16?>" name="name" value="<?=$bankaRow['BankaName']?>">
                  <label for="name"><?=$W87_Text16?><span style="color: red;">*</span></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="user" placeholder="<?=$W87_Text17?>" name="user" value="<?=$bankaRow['BankaUser']?>">
                  <label for="user"><?=$W87_Text17?><span style="color: red;">*</span></label>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="iban" placeholder="<?=$W87_Text18?>" name="iban" value="<?=$bankaRow['BankaIBAN']?>">
                  <label for="iban"><?=$W87_Text18?><span style="color: red;">*</span></label>
                </div>
              </div>
              <!-- <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="para" placeholder="<?=$W87_Text19?>" name="para" value="<?=$bankaRow['BankaParaBirimi']?>">
                  <label for="para"><?=$W87_Text19?></label>
                </div>
              </div> -->
              <!-- <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="ulke" placeholder="<?=$W87_Text20?>" name="ulke" value="<?=$bankaRow['BankaUlke']?>">
                  <label for="ulke"><?=$W87_Text20?></label>
                </div>
              </div> -->
              <!-- <hr>
              <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="subead" placeholder="<?=$W87_Text21?>" name="subead" value="<?=$bankaRow['BankaSubeAd']?>">
                  <label for="subead"><?=$W87_Text21?></label>
                </div>
              </div> -->
              <!-- <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="subekod" placeholder="<?=$W87_Text22?>" name="subekod" value="<?=$bankaRow['BankaSubeKodu']?>">
                  <label for="subekod"><?=$W87_Text22?></label>
                </div>
              </div> -->
              <!-- <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="hesapno" placeholder="<?=$W87_Text23?>" name="hesapno" value="<?=$bankaRow['BankaHesapNo']?>">
                  <label for="hesapno"><?=$W87_Text23?></label>
                </div>
              </div> -->
              <!-- <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="kimlik" placeholder="<?=$W87_Text24?>" name="kimlik" value="<?=$bankaRow['BankaKimlik']?>">
                  <label for="kimlik"><?=$W87_Text24?></label>
                </div>
              </div> -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="postakodu" placeholder="<?=$W87_Text42?>" name="postakodu" value="<?=$bankaRow['BankaPostaKodu']?>">
                  <label for="postakodu"><?=$W87_Text42?><span style="color: red;">*</span></label>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="city" placeholder="<?=$W87_Text43?>" name="city" value="<?=$bankaRow['BankaCity']?>">
                  <label for="city"><?=$W87_Text43?><span style="color: red;">*</span></label>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="adres" placeholder="<?=$W87_Text44?>" name="adres" value="<?=$bankaRow['BankaAdres']?>">
                  <label for="adres"><?=$W87_Text44?><span style="color: red;">*</span></label>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="adres2" placeholder="<?=$W87_Text45?>" name="adres2" value="<?=$bankaRow['BankaAdres2']?>">
                  <label for="adres2"><?=$W87_Text45?><span style="color: red;">*</span></label>
                </div>
              </div>

              <!-- Statu -->
              <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <label class="nnt_input_box" for="durum">
                  <input type="hidden" name="durum" value="0">
                  <input type="checkbox" class="nnt_input" id="durum" name="durum" value="1" <?php if($bankaRow['BankaStatus'] OR !isset($_GET['id'])){ echo 'checked'; } ?> />
                  <span class="nnt_track">
                    <span class="nnt_indicator">
                      <span class="checkMark">
                        <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                          <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                        </svg>
                      </span>
                    </span>
                  </span>
                  <span class="ok"><?=$W87_Text26?></span>
                  <span class="no"><?=$W87_Text27?></span>
                </label>
              </div>

              
            </div>
            <?php if($IframeGeldi){ ?>
              <input type="hidden" name="iframeModal" value="1">
            <?php } ?>
            <div class="<?php if($IframeGeldi){ echo 'form_footer'; }?>">
              <?php if (isset($_GET['id'])) { ?>
                <input type="hidden" name="form_update" value="1">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                  <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W87_Text30?></button></div>
                </div>
                <input type="hidden" name="banka_id" value="<?=$bankaRow['BankaID']?>">
              <?php }else{ ?>
                <input type="hidden" name="form_add" value="1">           
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                 <div class="btn_col"><button  type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W87_Text28?></button> </div>
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