<?php 
include(__DIR__."/app/kontrol.php");
$PageTitle=$W77_Text1;
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
      <div class="row m-0 p-0">
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>customer"><span class="ico"><i class="fa-solid fa-user-tie"></i></span><span class="name"><?=$W77_Text2?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL.$URL_Personnel?>"><span class="ico"><i class="fa-solid fa-user"></i></span><span class="name"><?=$W77_Text3?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>product"><span class="ico"><i class="fa-solid fa-tags"></i></span><span class="name"><?=$W77_Text4?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>unit"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text5?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>payment"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text6?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>land"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text7?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>city"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text8?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>category"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text9?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>money"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text10?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>bank"><span class="ico"><i class="fa-solid fa-plus"></i></span><span class="name"><?=$W77_Text11?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>order_taslak"><span class="ico"><i class="fa-solid fa-gear"></i></span><span class="name"><?=$W77_Text12?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>smtp_add"><span class="ico"><i class="fa-solid fa-envelopes-bulk"></i></span><span class="name"><?=$W77_Text13?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>user"><span class="ico"><i class="fa-solid fa-user-lock"></i></span><span class="name"><?=$W77_Text14?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>added"><span class="ico"><i class="fa-solid fa-list"></i></span><span class="name"></span><?=$W77_Text15?></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>added_type"><span class="ico"><i class="fa-solid fa-file-circle-plus"></i></span><span class="name"><?=$W77_Text16?></span></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-3">
          <a class="box1_a" href="<?=SITE_URL?>smtp_taslak"><span class="ico"><i class="fa-solid fa-envelopes-bulk"></i></span><span class="name"><?=$W77_Text17?></span></a>
        </div>
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
</body>
</html>