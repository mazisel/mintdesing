<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/smtp_taslak.php");
$PageTitle=$W96_PageTitle;
include("prc/top.php");
?>
<!-- datatables -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.bootstrap5.min.css">
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/style.css<?=$UPDATE_VERSION?>">
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>

  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5">
      <div class="row mb-2">
        <div class="col-lg-6 col-6"></div>
        <div class="col-lg-6 col-6" align="right"><a class="btn btn-light btnsm" href="<?=$SiteUrl?>smtp_add"><i class="fa-solid fa-gear"></i> <?=$W77_Text13?></a></div>
      </div>
      <!-- Fatura Mail taslağı -->
      <div class="table_body_bg  mb-5">
        <h4 class="d-flex justify-content-between mb-2 w-100"><span class="pe-3"><?=$W96_Text1?></span></h4>
        <hr>
        <form class="w-100 form_send" action="" method="post">
          <div class="row m-0 p-0">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <select class="form-select" id="smtp" aria-label="<?=$W96_Text2?>" name="smtp">
                  <option  value="0"><?=$W96_Text2?></option>
                  <?php foreach ($SMTPlist as $key => $value) {?>
                    <option value="<?=$SMTPlist[$key]["SmtpID"]?>" <?php if ($FaturaTaslakRow['SmtpID']==$SMTPlist[$key]["SmtpID"]) {echo "selected";}?>>
                      <?=$SMTPlist[$key]["SmtpGondericiAd"]?> - <?=$SMTPlist[$key]["SmtpEmail"]?>
                    </option>
                  <?php } ?>
                </select>
                <label for="smtp"><?=$W96_Text2?></label>
              </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="title" placeholder="<?=$W96_Text3?>" value="<?=$FaturaTaslakRow['TaslakTitle']?>" name="title">
                <label for="title"><?=$W96_Text3?></label>
              </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              {BillNumber} {DateInvoice} {BillAmount} {CustomerName}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <textarea class="form-control textarea300" placeholder="<?=$W96_Text4?>" id="editor1" name="content"><?=$FaturaTaslakRow['TaslakContent']?></textarea>
                <label for="content"><?=$W96_Text4?></label>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
              <label class="nnt_input_box" for="durum">
                <input type="checkbox" class="nnt_input" id="durum" name="durum" value="1" <?php if($FaturaTaslakRow['Status']){ echo 'checked'; } ?>/>
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok"><?=$W96_Text21?></span>
                <span class="no"><?=$W96_Text22?></span>
              </label>
            </div>


            <input type="hidden" name="kate" value="1">
            <input type="hidden" name="guncelle">
            <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W96_Text5?></button> </div>
          </div>
        </form>
      </div>

      <!-- Personel Maaş Bodro Mail Taslağı -->
      <div class="table_body_bg mb-3">
        <h4 class="d-flex justify-content-between mb-2 w-100"><span class="pe-3"><?=$W96_Text6?></span></h4>
        <hr>
        <form class="w-100 form_send" action="" method="post">
          <div class="row m-0 p-0">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <select class="form-select" id="smtp" aria-label="<?=$W96_Text2?>" name="smtp">
                  <option  value="0"><?=$W96_Text2?></option>
                  <?php foreach ($SMTPlist as $key => $value) {?>
                    <option value="<?=$SMTPlist[$key]["SmtpID"]?>" <?php if ($MaasTaslakRow['SmtpID']==$SMTPlist[$key]["SmtpID"]) {echo "selected";}?>>
                      <?=$SMTPlist[$key]["SmtpGondericiAd"]?> - <?=$SMTPlist[$key]["SmtpEmail"]?>
                    </option>
                  <?php } ?>
                </select>
                <label for="smtp"><?=$W96_Text2?></label>
              </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="title" placeholder="<?=$W96_Text3?>" value="<?=$MaasTaslakRow['TaslakTitle']?>" name="title">
                <label for="title"><?=$W96_Text3?></label>
              </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              {WorkerName} {WorkerSurname} {SalaryDate}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <textarea class="form-control textarea300" placeholder="<?=$W96_Text4?>" id="editor2" name="content"><?=$MaasTaslakRow['TaslakContent']?></textarea>
                <label for="content"><?=$W96_Text4?></label>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
              <label class="nnt_input_box" for="durum2">
                <input type="checkbox" class="nnt_input" id="durum2" name="durum" value="1" <?php if($MaasTaslakRow['Status']){ echo 'checked'; } ?> />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok"><?=$W96_Text21?></span>
                <span class="no"><?=$W96_Text22?></span>
              </label>
            </div>

            <input type="hidden" name="kate" value="2">
            <input type="hidden" name="guncelle">
            <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W96_Text5?></button> </div>
          </div>
        </form>
      </div>

    </div>
  </section>


<!-- FOOTER -->
<?php include __DIR__.'/prc/footer.php';?>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/ckeditor/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'editor1', {
      customConfig: '<?=BASE_URL.$FolderPath?>assets/ckeditor/myconfig.js',
      language: '<?=$LangSeo?>'
  });
  CKEDITOR.replace( 'editor2', {
      customConfig: '<?=BASE_URL.$FolderPath?>assets/ckeditor/myconfig.js',
      language: '<?=$LangSeo?>'
  });
</script>

<script>
    function getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
    //Website için değişken oluştur
    var scntDiv = $('.buraya');
    $('.addScnt').on('click', function() {       
      Variable=$('.degisken').val();     
      $('<div id="'+Variable+'" class="row mb-1"> <div class="col-md-2 col-sm-4 col-xs-6">'+Variable+'</div> <div class="col-md-8 col-sm-8 col-xs-12"> <input type="text" required name="Variable['+Variable+']" value="" class="form-control col-md-7 col-xs-12"> </div> <div class="col-md-1 pt5"><a href="javascript:;" data-id="'+Variable+'" id="remScnt"><i class="fa-solid fa-trash"></i></a></div>').appendTo(scntDiv);
      $('.degisken').val("");               
    });

    $("body").on("click","#remScnt",function() {
      var id=$(this).attr('data-id');
      $("#"+id).remove();               
    });    
</script>
</body>
</html>