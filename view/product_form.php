<?php 
include(__DIR__."/app/kontrol.php");  
include(__DIR__."/app/product.php");


$hatali_para='5,622.46';
$duzeltilmis_para = str_replace(",", "", $hatali_para);
$duzeltilmis_para = str_replace(".", ",", $duzeltilmis_para);
//echo $duzeltilmis_para.'p';die();

if(isset($_GET['id'])) {
  $Title=$W80_Text33;
}else{
  $Title=$W80_Text14;
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
          <?php if(!$IframeGeldi){ ?><a class="btn btn-dark btnsm" href="<?=$SiteUrl?>product"><i class="fa-solid fa-angle-left"></i></a><?php } ?>
        </h4>
        <hr>

        <form id="edit" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
          <div class="container-xxl p-0">
            <div class="row m-0 p-0">
              <!-- Ürün Adı -->
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" required placeholder="<?=$W80_Text15?>" name="name" value="<?=$productRow['ProductName']?>">
                  <label for="name"><?=$W80_Text15?>*</label>
                </div>
              </div>
              <!-- Kategori -->
              <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <select class="form-select" id="ulke" aria-label="<?=$W80_Text18?>" name="kate">
                    <option><?=$W80_Text48?></option>
                    <?php foreach ($KateList as $key => $value) {?>
                      <option value="<?=$KateList[$key]["KateID"]?>" <?php if($KateList[$key]["KateID"]==$productRow['KateID']){ echo "selected";}?>><?=$KateList[$key]["KateName"]?> </option>
                    <?php } ?>
                  </select>
                  <label for="kate"><?=$W80_Text48?></label>
                </div>
              </div>              
              <!-- Fiyat -->
              <div class="col-lg-4 col-md-4 col-sm-4 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control currency" id="fiyat" required placeholder="<?=$W80_Text16?>" name="fiyat" value="<?=$productRow['ProductFiyat']?>">
                  <label for="fiyat"><?=$W80_Text16?></label>
                </div>
              </div>
              <!-- KDV -->
              <div class="col-lg-4 col-md-4 col-sm-4 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control kdv" id="kdvtutar" placeholder="<?=$W80_Text17?>" name="kdvtutar" value="<?=$productRow['ProductKDV']?>">
                  <label for="kdvtutar"><?=$W80_Text17?></label>
                </div>
              </div>
              <!-- KDV Status -->
              <div class="col-lg-4 col-md-4 col-sm-4 mb-3">
                <label class="nnt_input_box" for="kdv1">
                  <input type="checkbox" class="nnt_input" id="kdv1" name="kdv" value="1" <?php if ($productRow['ProductKdvDurum'] || !isset($_GET['id'])){ echo 'checked';  } ?> />
                  <span class="nnt_track">
                    <span class="nnt_indicator">
                      <span class="checkMark">
                        <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                          <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                        </svg>
                      </span>
                    </span>
                  </span>
                  <span class="ok"><?=$W80_Text28?></span>
                  <span class="no"><?=$W80_Text29?></span>
                </label>
              </div>
              <!-- Para Birimi -->
              <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <select class="form-select" id="para" aria-label="<?=$W80_Text18?>" name="para">
                    <option><?=$W80_Text18?></option>
                    <?php foreach ($ParaList as $key => $value) {?>
                      <option value="<?=$ParaList[$key]["ParaID"]?>" <?php if($ParaList[$key]["ParaID"]==$productRow['ParaID']){ echo "selected";}?>>
                        <?=$ParaList[$key]["ParaShort"]?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="para"><?=$W80_Text18?></label>
                </div>
              </div>              
              <!-- Birimi -->
              <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <select class="form-select" id="birim" aria-label="<?=$W80_Text25?>" name="birim">
                    <option><?=$W80_Text25?></option>
                    <?php foreach ($UnitList as $key => $value) {?>
                      <option value="<?=$UnitList[$key]["UnitID"]?>" <?php if($UnitList[$key]["UnitID"]==$productRow['UnitID']){ echo "selected";}?>> <?=$UnitList[$key]["UnitName"]?> </option>
                    <?php } ?>
                  </select>
                  <label for="birim"><?=$W80_Text25?></label>
                </div>
              </div>
              <!-- Stok kodu -->
              <!-- <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="stokkodu" placeholder="<?=$W80_Text20?>" name="stokkodu" value="<?=$productRow['ProductStokKod']?>">
                  <label for="stokkodu"><?=$W80_Text20?></label>
                </div>
              </div> -->
              <!-- Barkod kodu -->
              <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="barkodkodu" placeholder="<?=$W80_Text21?>" name="barkodkodu" value="<?=$productRow['ProductBarkod']?>">
                  <label for="barkodkodu"><?=$W80_Text21?></label>
                </div>
              </div>
              
              <?php if($productRow['ProductImg']){ ?>
                <div class="row">
                  <div class="col-md-4 control-label"></div>
                  <div class="col-md-8 col-sm-8 col-xs-12">     
                    <div style="background: #fbfbfb; padding: 2px;">
                      <img style="max-height: 120px; max-width: 200px;" src="<?=BASE_URL.$FolderPath?>images/cari/<?=$productRow['ProductImg']?>"> 
                    </div>   
                  </div>
                </div>
              <?php } ?>
              <!-- Resim -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="input-group mb-3">
                  <input type="file" class="form-control" id="resim" name="resim">
                  <label class="input-group-text" for="resim"><?=$W80_Text26?></label>
                </div>
              </div>
              <!-- Açıklama -->
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="form-floating">
                  <textarea class="form-control textarea100" placeholder="<?=$W80_Text27?>" id="desc" name="desc"><?=$productRow['ProductDesc']?></textarea>
                  <label for="desc"><?=$W80_Text27?></label>
                </div>
              </div>
              <!-- Product Status -->
              <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <label class="nnt_input_box" for="durum">
                  <input type="checkbox" class="nnt_input" id="durum" name="durum" value="1" <?php if ($productRow['ProductStatus'] || !isset($_GET['id'])){ echo 'checked';  } ?> />
                  <span class="nnt_track">
                    <span class="nnt_indicator">
                      <span class="checkMark">
                        <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                          <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                        </svg>
                      </span>
                    </span>
                  </span>
                  <span class="ok"><?=$W80_Text30?></span>
                  <span class="no"><?=$W80_Text31?></span>
                </label>
              </div>

              <?php if($IframeGeldi){ ?>
                <input type="hidden" name="iframeModal" value="1">
                <input type="hidden" name="modal_kapat" value="iframeModal">
              <?php } ?>
              </div>

              <div class="<?php if($IframeGeldi){ echo 'form_footer'; }?>">
                <?php if (isset($_GET['id'])) { ?>
                  <input type="hidden" name="product_id" value="<?=$productRow['ProductID']?>">
                  <input type="hidden" name="form_update" value="urun">
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W80_Text34?></button></div>
                  </div>                  
                <?php }else{ ?>
                  <input type="hidden" name="form_insert" value="urun">           
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                    <div class="btn_col"><button  type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W80_Text32?></button> </div>
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
</body>
</html>