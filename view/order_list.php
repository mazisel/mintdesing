<?php 
include(__DIR__."/app/kontrol.php");

if($_GET['q'] && !empty($_GET['q'])){
  $q=$_GET['q'];
  if($q=='today'){ $filtre='today'; }
  if($q=='week'){ $filtre='week';  }
  if($q=='month'){ $filtre='month';  }
  if($q=='offen'){ $filtre='offen';  }
  if($q=='erledigt'){ $filtre='erledigt';  }
  if($q=='filter'){$filtre='filter'; }
}else{$filtre='offen'; }

include(__DIR__."/app/order.php");
if (isset($_GET['qrcode'])) {include(__DIR__."/app/order_qrcode.php");die(); }
if (isset($_GET['pdf'])) {include(__DIR__."/app/order_pdf.php");die(); }


switch ($filtre) {
  case 'offen': $Title1=$W97_Text48; break;
  case 'erledigt': $Title1=$W97_Text48; break;
  case 'today': $Title1=$W97_Text48; break;
  case 'week': $Title1=$W97_Text48; break;
  case 'month': $Title1=$W97_Text48; break;
  case 'filter': if ($tarihler=='var') {$Title1=date('d.m.Y',$StartDateUnix).' - '.date('d.m.Y',$EndDateUnix); }else{$Title1=$W97_Text48; } break;
  default:$Title1=$W97_Text48; break;
}

$PageTitle=$W97_Text47;
include("prc/top.php");
?>
<!-- datatables -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/responsive.dataTables.min.css">
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.css">
<!-- air datepicker -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.css">
<!-- tema style -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/css/style.css<?=$UPDATE_VERSION?>">
<!-- select2 -->
<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/select2/select2.min.css">
<style>
  .dropdown-toggle::after{display: none;}
  .action-btn{background-color: #efefef; border-radius: 5px; padding: 2px 10px; }
  .action-dots{display: contents; }
  .badge.success{background-color: green; color: #fff; }
  .badge.warning{background-color: orange; color: #fff; }
  .badge.danger1{background-color: #e98713; color: #fff; }
  .badge.danger2{background-color: #e95613; color: #fff; }
  .badge.danger3{background-color: #cd0000; color: #fff; }
  .badge.danger4{background-color: #2d2d2d; color: #fff; }
</style>
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>
  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5">
      <div class="row mb-2">
        <div class="col-lg-8 col-8 pe-0">
          <div class="row m-0">
            <a class="order_btn mb-1 me-1 <?php if($filtre=='offen'){ echo 'active'; } ?>" href="<?=$SiteUrl.$URLInvoce?>?q=offen"> <span class="name">Offen</span> </a>
            <a class="order_btn mb-1 me-1 <?php if($filtre=='erledigt'){ echo 'active'; } ?>" href="<?=$SiteUrl.$URLInvoce?>?q=erledigt"> <span class="name">Erledigt</span> </a>
           <!--  
            <a class="order_btn mb-1 me-1 <?php if($filtre=='today'){ echo 'active'; } ?>" href="<?=$SiteUrl.$URLInvoce?>?q=today"> <span class="name"><?=$W97_Text61?></span> </a>
            <a class="order_btn mb-1 me-1 <?php if($filtre=='week'){ echo 'active'; } ?>" href="<?=$SiteUrl.$URLInvoce?>?q=week"> <span class="name"><?=$W97_Text62?></span> </a>
            <a class="order_btn mb-1 me-1 <?php if($filtre=='month'){ echo 'active'; } ?>" href="<?=$SiteUrl.$URLInvoce?>?q=month"> <span class="name"><?=$W97_Text63?></span> </a> -->
          </div>
          

        </div>
        <div class="col-lg-4 col-4" align="right">
          <a href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#filtre" aria-controls="filtre" class="order_btn">
            <span class="ico"><img src="<?=BASE_URL.$FolderPath?>images/icon/filter.png" alt="Filtern"></span><span class="name"><?=$W97_Text64?></span>
          </a>
        </div>
      </div>

      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$Title1?></span>
          <a href="<?=SITE_URL?>order" class="btn btn-success">
            <span class="my_ico"> <img src="<?=BASE_URL.$FolderPath?>images/icon/invoice.png"/></span> <span class="smhide"><?=$W97_Text49?></span></a>
        </h4>
        <hr>

        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th width="10%"><?=$W76_Text6?></th>
              <th width="40%"><?=$W76_Text7?></th>
              <th><?=$W76_Text8?></th>
              <th><?=$W97_Text65?></th>
              <th><?=$W76_Text9?></th>
              <th width="8%"><?=$W76_Text10?></th>
            </tr>
          </thead>
          <tbody>            
            <?php foreach ($OrderList as $key => $value) {?>
              <tr id="ftr<?=$OrderList[$key]["OrderID"]?>">
                <td><?=$OrderList[$key]["OrderCode"]?></td>
                <td><?=$OrderList[$key]["CariName"]?></td>
                <td><?=date('d.m.Y',strtotime($OrderList[$key]["OrderDate"]))?></td>
                <td>
                  <?php switch ($OrderList[$key]["Status"]) {
                    case 1: echo "<span class='badge success'>{$W97_Text66}</span>"; break;
                    case 2: echo "<span class='badge warning'>{$W97_Text67}</span>"; break;
                    case 3: echo "<span class='badge danger1'>{$W97_Text68}</span>"; break;
                    case 4: echo "<span class='badge danger2'>{$W97_Text69}</span>"; break;
                    case 5: echo "<span class='badge danger3'>{$W97_Text70}</span>"; break;
                    case 6: echo "<span class='badge danger4'>{$W97_Text71}</span>"; break;
                  } ?>
                </td>
                <td><?=mony($OrderList[$key]["ToplamTutar"],$Currency)?></td>
                <td align="center">
                  <div class="action-dots">
                    <button class="action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                      <!-- <i class="fa-solid fa-ellipsis"></i>  -->
                      <i class="fa-solid fa-sliders"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <!-- Pfd Görüntüle -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl?>order_list?id=<?=$OrderList[$key]["OrderCode"]?>&pdf" target="_blank"><i class="fa-regular fa-eye"></i> <?=$W76_Text26?></a></li>
                      <!-- Pdf İndir -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl?>order_list?id=<?=$OrderList[$key]["OrderCode"]?>&pdf" target="_blank" download="<?=$OrderList[$key]["OrderCode"]?>.pdf"><i class="fa-solid fa-download"></i> <?=$W76_Text27?></a></li>
                      <!-- Mail Gönder -->
                      <li><a class="dropdown-item fatura_mail_gonder" href="javascript:;" data-href="<?=$SiteUrl?>order_list?id=<?=$OrderList[$key]["OrderCode"]?>&pdf&mailgonder"><i class="fa-solid fa-paper-plane"></i> Mail Send</a></li>
                      <!-- Düzenle -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl?>order?id=<?=$OrderList[$key]["OrderCode"]?>"><i class="fa-regular fa-pen-to-square"></i> <?=$W76_Text28?></a></li>
                      <!-- Sil -->
                      <li><a class="dropdown-item ftr-sil-js" data-id='<?=$OrderList[$key]["OrderID"]?>' href="javascript:;"><i style="color:red" class="fa-regular fa-trash-can"></i> <?=$W76_Text29?></a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </section>



<!-- FILTER -->
<section>
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="filtre" aria-labelledby="filtrelabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="filtrelabel"><?=$W91_FilterTitle?></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <form class="w-100" method="get" action="<?=$SiteUrl.$URLInvoce?>">
        <input type="hidden" name="q" value="filter">
        <!-- Date1 -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control date" id="date" autocomplete="off" placeholder="<?=$W91_FilterText1?>" name="date1">
            <label for="date"><?=$W91_FilterText1?></label>
          </div>
        </div>
        <!-- Date2 -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control date2" id="date2" autocomplete="off" placeholder="<?=$W91_FilterText2?>" name="date2">
            <label for="date2"><?=$W91_FilterText2?></label>
          </div>
        </div>
        <!-- Client -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating mb-3">
            <select class="form-select select2" id="cari" aria-label="cari" data-placeholder="<?=$W91_FilterText3?>" name="cari">
              <option hidden=""></option>
              <?php foreach ($CariList as $key => $value) {?>
                <option value="<?=$CariList[$key]["CariCode"]?>" <?php if($OrderRow['CariID']==$CariList[$key]["CariID"]){ echo 'selected';} ?> >
                  <?=$CariList[$key]["CariUnvan"]?> (<?=$CariList[$key]["CariName"]?>)
                </option>
              <?php } ?>
            </select>
            <label for="cari"><?=$W91_FilterText3?></label>
          </div>
        </div>
        <!-- Submit -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <button class="filtre_btn" type="submit"><span class="name"><?=$W91_FilterText4?></span></button>
        </div>
      </form>
    </div>
  </div>
</section>



<!-- FOOTER -->
<?php include __DIR__.'/prc/footer.php';?>
<?php include __DIR__.'/prc/footer_meta.php';?>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<!-- datatables -->
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/datatables.js"></script>
<!-- select2 -->
<script src="<?=BASE_URL.$FolderPath?>assets/select2/select2.min.js"></script>
<script> $('.select2').select2(); </script>

<!-- air datepicker -->
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/lang-<?=$LangSeo?>.js"></script>
<script>
  let dpMin, dpMax;
  dpMin = new AirDatepicker('.date', {
    onSelect({date}) {
      dpMax.update({
        minDate: date       
      })
      dpMin.hide();
    },
    timepicker: false,
    locale: mylang
  })

  dpMax = new AirDatepicker('.date2', {
    onSelect({date}) {
      dpMin.update({
        maxDate: date
      })
      dpMax.hide();
    },
    timepicker: false,
    locale: mylang
  })
</script>

<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>

<script>
  //Fatura mail gönder
  $("body").on("click",".fatura_mail_gonder",function(e){
    e.preventDefault(); 
    $('.form_loader').css('display', 'flex'); 
    let url = $(this).attr("data-href");  
    $.ajax({
      type: "POST",
      url: url,
    }).done(function(result){
      $('.form_loader').css('display', 'none');
      console.log(result);
      let obj = JSON.parse(result);
      swal({title: obj.title,text: obj.subtitle, icon: obj.icon,button:obj.btn});
    }).fail(function(){ 
      console.log( "error" );
      swal({icon:"error",title: "Erorr!"});
    }).always(function() {});
  });
  //Fatura Sil
  $("body").on("click",".ftr-sil-js",function(e){
    let id= $(this).attr("data-id");  
    swal({
      title: "<?=$W97_Text58?>",
      icon: "warning",
      buttons: ["<?=$W97_Text59?>", "<?=$W97_Text60?>"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {              

        $.ajax({
          type: "POST",
          url: "",
          data: {'delete':1, 'ID':id}
        }).done (function(result){             
          //console.log(result);
          let obj = JSON.parse(result);
          console.log(obj);
          if (obj.sonuc=='success'){
            $('#ftr'+id).hide(400);  
          }
        }).fail(function() { console.log( "error" );}).always(function() {});
      }
    });
  });
</script>
</body>
</html>