<?php 
include 'app/login.php';
include("prc/top.php");

?>
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/login.css">
</head>
<body>
  <!-- HEADER -->
  <header>
    <nav class="login_nav">
      <div class="container-xxl mb-5">
        <div class="login_menu">
          <a href="<?=$SiteUrl?>" class="login_logo"><img src="<?=BASE_URL.SitePath?>images/<?=$SiteAyarSabit['Logo1']?>" alt="<?=$W75_Text19?>"/></a>
          <span class="header_vr"><span class="name"><?=$W75_Text19?></span><span class="ver"> <?=$W75_Text20?></span></span>
        </div>
      </div>
    </nav>
  </header>

  <!-- LOGIN -->
  <section>
    <div class="container-xxl mb-5">
      <h1 class="w-100 text-center"><?=$W75_Text53?></h1>
      <div class="login_body mb-5">
        <div class="login_box">
          <form class="w-100" method="post" action="" id="giris_yap_frm">
            <?php if ($SistemVersiyon==1) {?>
             <div class="form-floating mb-3">
                <input type="number" class="form-control" id="firmakodu" placeholder="<?=$W75_Text56?>" name="companycode">
                <label for="firmakodu"><?=$W75_Text56?></label>
              </div>
            <?php } ?>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="email" placeholder="<?=$W75_Text21?>" name="mail">
              <label for="email"><?=$W75_Text21?></label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="pass" placeholder="<?=$W75_Text22?>" name="pass">
              <label for="pass"><?=$W75_Text22?></label>
            </div>
            <input type="hidden" name="beni_hatirla" value="0">
            <input type="hidden" name="giris_yap" value="1">
            <div class="submit_cont"><button type="submit" class="login_btn"><?=$W75_Text23?></button> </div>
          </form>
        </div>
      </div>
      <?php if ($SistemVersiyon==1) {?>
        <div class="form_footer">
          <ul class="ul_sifirla form_ul">
            <li> <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#passmodal"><?=$W75_Text57?></a> </li>
            <li> <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#basvuruyapmodal"><?=$W75_Text58?></a> </li>
          </ul>
        </div>
      <?php } ?>
    </div>


    <!-- SIFREMI UNUTUM Modal -->
    <div class="modal fade" id="passmodal" tabindex="-1" aria-labelledby="passmodallabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="passmodallabel"><?=$W75_Text24?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning" role="alert">
              <?=$W75_Text25?>
            </div>
            <form class="w-100 mb-4">
             <div class="form-floating mb-3">
              <input type="text" class="form-control" id="emailunutum" placeholder="E-mail unutum">
              <label for="emailunutum"><?=$W75_Text26?></label>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <div class="submit_cont"><a href="javascript:;" class="login_btn"><?=$W75_Text27?></a> </div>
        </div>
      </div>
    </div>
  </div>



  <!-- BASVURU YAP Modal -->
<div class="modal fade" id="basvuruyapmodal" tabindex="-1" aria-labelledby="basvuruyapmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="basvuruyapmodalLabel"><?=$W75_Text28?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 py-4">

        <form class="w-100 kayitol" action="" method="post">
          <div class="row m-0 p-0">
           <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert-primary mb-3" role="alert">
              <?=$W75_Text29?>
            </div>
            <div class="alert alert-warning" role="alert">
             <?=$W75_Text30?>
           </div>
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="firmaadi" placeholder="<?=$W75_Text31?>" name="f_name">
            <label for="firmaadi"><?=$W75_Text31?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="firmaadi" placeholder="<?=$W75_Text32?>" name="ad_soyad">
            <label for="firmaadi"><?=$W75_Text32?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="number" class="form-control" id="GSM" placeholder="<?=$W75_Text33?>" name="gsm">
            <label for="GSM"><?=$W75_Text33?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="number" class="form-control" id="wphatti" placeholder="<?=$W75_Text34?>" name="wp_hat">
            <label for="wphatti"><?=$W75_Text34?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="number" class="form-control" id="TEL" placeholder="<?=$W75_Text35?>" name="tel">
            <label for="TEL"><?=$W75_Text35?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="<?=$W75_Text36?>" name="mail">
            <label for="floatingInput"><?=$W75_Text36?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="website" placeholder="<?=$W75_Text37?>" name="web">
            <label for="website"><?=$W75_Text37?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="il" placeholder="<?=$W75_Text38?>" name="il">
            <label for="il"><?=$W75_Text38?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="ilce" placeholder="<?=$W75_Text39?>" name="ilce">
            <label for="ilce"><?=$W75_Text39?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <textarea class="form-control textarea100" placeholder="<?=$W75_Text40?>" id="Adres" name="adres"></textarea>
            <label for="Adres"><?=$W75_Text40?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="vergidairesi" placeholder="<?=$W75_Text41?>" name="vdaire">
            <label for="vergidairesi"><?=$W75_Text41?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="vergino" placeholder="<?=$W75_Text42?>" name="vno">
            <label for="vergino"><?=$W75_Text42?></label>
          </div>
        </div>
        <hr>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="pass" placeholder="Kullanıcı Adı" name="nick">
            <label for="nick">Kullanıcı Adı</label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="pass" placeholder="<?=$W75_Text43?>" name="pass">
            <label for="pass"><?=$W75_Text43?></label>
          </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-check">
            <input type="hidden" name="ksoz" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="kullanicisozlesmesi" name="ksoz">
            <label class="form-check-label" for="kullanicisozlesmesi">
              <span><sup class="text-danger">*</sup> <?=$W75_Text44?></span> <a target="_blank" href="#"><?=$W75_Text45?></a>
            </label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-check">
            <input type="hidden" name="csoz" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="cerezpolitikasi" name="csoz">
            <label class="form-check-label" for="cerezpolitikasi">
              <span><sup class="text-danger">*</sup> <?=$W75_Text46?></span> <a target="_blank" href="#"><?=$W75_Text47?></a>
            </label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-check">
            <input type="hidden" name="iptaliade" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="iptaliade" name="iptaliade">
            <label class="form-check-label" for="iptaliade">
              <span><sup class="text-danger">*</sup> <?=$W75_Text48?></span> <a target="_blank" href="#"><?=$W75_Text49?></a>
            </label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-check">
            <input type="hidden" name="gizliplt" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="gizliliksozlesmesi" name="gizliplt">
            <label class="form-check-label" for="gizliliksozlesmesi">
              <span><sup class="text-danger">*</sup> <?=$W75_Text50?></span> <a target="_blank" href="#"><?=$W75_Text51?></a>
            </label>
          </div>
        </div>

        <input type="hidden" name="basvuru_yap" value="1">


      </div>
      <div class="submit_cont"><button type="submit" class="login_btn"><?=$W75_Text52?></button> </div>
    </form>
  </div>
  <div class="modal-footer">
  </div>
</div>
</div>
</div>
</section>




<!-- FOOTER -->
<?php include __DIR__.'/prc/footer.php';?>
<!-- particles -->
<div id="particles-js"> </div>
<div class="form_loader"><div class="loader_rolling"></div></div>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/particles/particles.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/particles/particles_start.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/member.js"></script>
</body>
</html>