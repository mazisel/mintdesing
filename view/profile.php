<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/profile.php");
$PageTitle=$W90_PageTitle;
include("prc/top.php");
?>
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/style.css<?=$UPDATE_VERSION?>">
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>

  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5">
      <h1 class="w-100 text-center mb-2"><?=$W90_Text1?></h1>
      <div class="content_body">
        <form class="w-100 form_send" action="" method="post">
          <div class="row m-0 p-0">
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="unvan" placeholder="<?=$W90_Text2?>" value="<?=$Firma['FirmaAd']?>" name="unvan">
              <label for="unvan"><?=$W90_Text2?></label>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="yetkili" placeholder="<?=$W90_Text3?>" value="<?=$Firma['FirmaYetkili']?>" name="yetkili">
            <label for="yetkili"><?=$W90_Text3?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="website" placeholder="<?=$W90_Text4?>" value="<?=$Firma['FirmaWeb']?>" name="website">
            <label for="website"><?=$W90_Text4?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="tel" placeholder="<?=$W90_Text5?>" value="<?=$Firma['FirmaTel']?>" name="tel">
            <label for="tel"><?=$W90_Text5?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="tel2" placeholder="<?=$W90_Text6?>" value="<?=$Firma['FirmaTel2']?>" name="tel2">
            <label for="tel2"><?=$W90_Text6?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="gsm" placeholder="<?=$W90_Text7?>" value="<?=$Firma['FirmaGsm']?>" name="gsm">
            <label for="gsm"><?=$W90_Text7?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="wp" placeholder="<?=$W90_Text8?>" value="<?=$Firma['FirmaWp']?>" name="wp">
            <label for="wp"><?=$W90_Text8?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="il" placeholder="<?=$W90_Text9?>" value="<?=$Firma['FirmaSehir']?>" name="il">
            <label for="il"><?=$W90_Text9?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="ilce" placeholder="<?=$W90_Text10?>" value="<?=$Firma['FirmaIlce']?>" name="ilce">
            <label for="ilce"><?=$W90_Text10?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="vdairesi" placeholder="<?=$W90_Text11?>" value="<?=$Firma['FirmaVergiDairesi']?>" name="vdairesi">
            <label for="vdairesi"><?=$W90_Text11?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="vno" placeholder="<?=$W90_Text12?>" value="<?=$Firma['FirmaVergiNo']?>" name="vno">
            <label for="vno"><?=$W90_Text12?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="email" class="form-control" id="mailadres" placeholder="<?=$W90_Text13?>" value="<?=$Firma['FirmaEmail']?>" name="email">
            <label for="mailadres"><?=$W90_Text13?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <textarea class="form-control textarea100" placeholder="<?=$W90_Text14?>" id="Adres" name="adres"><?=$Firma['FirmaAdres']?></textarea>
            <label for="Adres"><?=$W90_Text14?></label>
          </div>
        </div>
        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="ftitle" placeholder="<?=$W90_Text15?>" value="<?=$Firma['FirmaTitle']?>" name="ftitle">
            <label for="ftitle"><?=$W90_Text15?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="fdesc" placeholder="<?=$W90_Text16?>" value="<?=$Firma['FirmaDesc']?>" name="fdesc">
            <label for="fdesc"><?=$W90_Text16?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="fkeyw" placeholder="<?=$W90_Text17?>" value="<?=$Firma['FirmaKeyw']?>" name="fkeyw">
            <label for="fkeyw"><?=$W90_Text17?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <textarea class="form-control textarea100" placeholder="<?=$W90_Text18?>" id="Hakkinda" name="hakkinda"><?=$Firma['FirmaHakkinda']?></textarea>
            <label for="Hakkinda"><?=$W90_Text18?></label>
          </div>
        </div>

        <input type="hidden" name="profil_guncelle">
        <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W90_Text19?></button> </div>
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

</body>
</html>