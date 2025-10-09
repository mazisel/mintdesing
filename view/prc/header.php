  <header>
    <nav class="header_nav">
      <div class="container-xxl mb-3">
        <div class="header_cont">
          <a href="<?=SITE_URL?>panel" class="logo"><img src="<?=BASE_URL.SitePath?>images/<?=$SiteAyarSabit['Logo1']?>" alt="etiket"/></a>
          <ul class="ul_sifirla d-flex align-items-center">
            <li><a class="home_btn push" href="<?=SITE_URL?>panel"><i class="fa-solid fa-house"></i></a></li>
            <li>
          <!-- hidden menu btn -->
          <svg class="ham ham6" viewBox="0 0 100 100">
            <path class="line top" d="m 30,33 h 40 c 13.100415,0 14.380204,31.80258 6.899646,33.421777 -24.612039,5.327373 9.016154,-52.337577 -12.75751,-30.563913 l -28.284272,28.284272"></path> <path class="line middle" d="m 70,50 c 0,0 -32.213436,0 -40,0 -7.786564,0 -6.428571,-4.640244 -6.428571,-8.571429 0,-5.895471 6.073743,-11.783399 12.286435,-5.570707 6.212692,6.212692 28.284272,28.284272 28.284272,28.284272"></path> <path class="line bottom" d="m 69.575405,67.073826 h -40 c -13.100415,0 -14.380204,-31.80258 -6.899646,-33.421777 24.612039,-5.327373 -9.016154,52.337577 12.75751,30.563913 l 28.284272,-28.284272"></path> 
          </svg>
            </li>
          </ul>
   
        </div>
      </div>
      
      <div class="hidden_menu_body">
        <div class="hidden_menu_header mb-1">
          <a href="<?=SITE_URL?>profile" class="profil_badge"><span class="ico"><i class="fa-regular fa-user"></i></span> <span class="name satir_1"><?=$Firma['FirmaAd']?></span></a>
          <!-- hidden menu btn -->
          <svg class="ham ham6" viewBox="0 0 100 100">
            <path class="line top" d="m 30,33 h 40 c 13.100415,0 14.380204,31.80258 6.899646,33.421777 -24.612039,5.327373 9.016154,-52.337577 -12.75751,-30.563913 l -28.284272,28.284272"></path> <path class="line middle" d="m 70,50 c 0,0 -32.213436,0 -40,0 -7.786564,0 -6.428571,-4.640244 -6.428571,-8.571429 0,-5.895471 6.073743,-11.783399 12.286435,-5.570707 6.212692,6.212692 28.284272,28.284272 28.284272,28.284272"></path> <path class="line bottom" d="m 69.575405,67.073826 h -40 c -13.100415,0 -14.380204,-31.80258 -6.899646,-33.421777 24.612039,-5.327373 -9.016154,52.337577 12.75751,30.563913 l 28.284272,-28.284272"></path> 
          </svg>
        </div>
        <ul class="ul_sifirla sidebar_ul">
          <li> <a href="<?=SITE_URL?>panel"><span class="ico"><i class="fa-solid fa-house"></i></span> <span class="name"><?=$W91_HeaderMenu1?></span></a> </li>
          <li> <a href="<?=SITE_URL?>order">
            <span class="ico">
              <img src="<?=BASE_URL.$FolderPath?>images/icon/invoice.png" alt="<?=$W76_Text1?>"/>
            </span>

            <!-- <span class="ico"><i class="fa-solid fa-plus"></i></span>  -->
            <span class="name"><?=$W91_HeaderMenu2?></span></a>
          </li>
          <li> <a href="<?=SITE_URL.$URLInvoce?>"><span class="ico"><i class="fa-regular fa-file-lines"></i></span> <span class="name"><?=$W91_HeaderMenu3?></span></a> </li>
          <li> <a href="<?=SITE_URL?>product"><span class="ico"><i class="fa-solid fa-tags"></i></span> <span class="name"><?=$W91_HeaderMenu4?></span></a> </li>
          <li> <a href="<?=SITE_URL?>customer"><span class="ico"><i class="fa-solid fa-user-tie"></i></span> <span class="name"><?=$W91_HeaderMenu5?></span></a> </li>
          <li> <a href="<?=SITE_URL.$URL_Personnel?>"><span class="ico"><i class="fa-solid fa-user"></i></span> <span class="name"><?=$W91_HeaderMenu6?></span></a> </li>
          <li> <a href="<?=SITE_URL?>expense"><span class="ico"><i class="fa-solid fa-wallet"></i></span> <span class="name"><?=$W91_HeaderMenu7?></span></a> </li>
          <li> <a href="<?=SITE_URL?>settings"><span class="ico"><i class="fa-solid fa-gear"></i></span> <span class="name"><?=$W91_HeaderMenu8?></span></a> </li>
          <li> <a href="<?=SITE_URL?>panel?safe-exit"><span class="ico"><i class="fa-solid fa-right-from-bracket"></i></span> <span class="name"><?=$W91_HeaderMenu9?></span></a> </li>
        </ul>
      </div>
      <div class="hidden_menu_overly"></div>
    </nav>
  </header>