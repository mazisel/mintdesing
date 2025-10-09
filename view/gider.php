<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/gider.php");
$PageTitle=$W88_PageTitle;
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
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>

  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5 p-0">
      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100">
          <span class="pe-3"><?=$W88_Text1?></span> 
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#eklemodal"><i class="fa-solid fa-plus pe-1"></i><?=$W88_Text2?></button>
        </h4>

        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W88_Text3?></th>
              <th><?=$W88_Text4?></th>
              <th><?=$W88_Text5?></th>
              <th><?=$W88_Text6?></th>
              <th width="10%"><?=$W88_Text7?></th>
            </tr>
          </thead>
          <tbody>
            <?php 

            $ToplamGelir=0;
            $ToplamGider=0;
            $Kalan=0;
              foreach ($listele as $key => $value) {

              ?>
              <tr id="<?=$listele[$key]["GiderID"]?>">
                <td> <?=$listele[$key]["GiderCode"] ?> </td>
                <td> <?=$listele[$key]["GiderName"] ?> </td>
                <td>
                  <?php if ($listele[$key]["GiderStatus"]==1) {
                    $ToplamGider+=$listele[$key]["GiderTutar"];
                    echo '<span class="table_badge red">'.$W88_Text8.'</span>'; }else{
                      $ToplamGelir+=$listele[$key]["GiderTutar"];
                      echo '<span class="table_badge green">'.$W88_Text9.'</span>'; }  ?>
                </td>
                <td> <b><?=$listele[$key]["GiderTutar"]?> <?=$W88_Text10?></b> </td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$listele[$key]["GiderID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W88_Text11?></button>
                  <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$listele[$key]["GiderID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W88_Text12?></button>
                </td>
              </tr>
            <?php } $Kalan=$ToplamGelir-$ToplamGider; ?>
          </tbody>
        </table>
        <div id="gelirToplam"><?=$W88_Text33?> <?=mony($ToplamGelir)?> <?=$W88_Text10?></div>
        <div id="giderToplam"><?=$W88_Text34?> <?=mony($ToplamGider)?> <?=$W88_Text10?></div>
        <div id="farkToplam"><?=$W88_Text35?> <?=mony($Kalan)?> <?=$W88_Text10?></div>
      </div>
    </div>


    <!-- EKLE MODAL -->
    <form class="w-100 form_send" action="" method="post">
      <div class="modal fade" id="eklemodal" tabindex="-1" aria-labelledby="eklemodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="eklemodalLabel"><?=$W88_Text13?></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
              <div class="col-lg-4 col-md-4 col-sm-6 mb-2">
                <div class="form-floating">
                  <select class="form-select" id="cari" aria-label="<?=$W88_Text14?>" name="cari">
                    <option value="0"><?=$W88_Text14?></option>
                    <?php foreach ($carilist as $key => $value) {?>
                      <option value="<?=$carilist[$key]["CariID"]?>">
                        <?php if ($carilist[$key]["CariID"]) {echo $carilist[$key]["CariName"];}else{echo $carilist[$key]["CariUnvan"];}?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="cari"><?=$W88_Text15?></label>
                </div>
              </div>
              <!-- datepciker -->
              <div class="col-lg-4 col-md-4 col-sm-6 mb-2">
                <div class="form-floating">
                  <input type="text" class="form-control date" autocomplete="off" id="date" placeholder="<?=$W88_Text16?>" name="date">
                  <label for="date"><?=$W88_Text16?></label>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 d-flex  mb-2">
                <div class="form-check pe-2">
                  <input class="form-check-input" type="radio" id="gelirgider2" value="1" name="gelirgider" checked>
                  <label class="form-check-label" for="gelirgider2">
                    <?=$W88_Text17?>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="gelirgider" value="0"  name="gelirgider">
                  <label class="form-check-label" for="gelirgider">
                    <?=$W88_Text18?>
                  </label>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
               <div class="form-floating">
                <input type="text" class="form-control" id="title" placeholder="title<?=$W88_Text19?>" name="title">
                <label for="title"><?=$W88_Text19?></label>
              </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
             <div class="form-floating">
              <input type="text" class="form-control" id="tutar" placeholder="tutar<?=$W88_Text20?>" name="tutar">
              <label for="tutar"><?=$W88_Text20?></label>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-2">
           <div class="form-floating">
            <input type="text" class="form-control" id="kdv" placeholder="kdv<?=$W88_Text21?>" name="kdv">
            <label for="kdv"><?=$W88_Text21?></label>
          </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-6 d-flex mb-2">
         <div class="form-check pe-2">
          <input class="form-check-input" type="radio" id="kdvdurum" value="1"  name="kdvdurum" checked>
          <label class="form-check-label" for="kdvdurum">
           <?=$W88_Text22?>
         </label>
       </div>
       <div class="form-check">
        <input class="form-check-input" type="radio" id="kdvdurum2" value="0" name="kdvdurum">
        <label class="form-check-label" for="kdvdurum2">
         <?=$W88_Text23?>
       </label>
     </div>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
    <div class="form-floating">
      <textarea class="form-control textarea100" placeholder="not<?=$W88_Text24?>" id="not" name="not"></textarea>
      <label for="not"><?=$W88_Text24?></label>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
   <div class="form-floating">
    <input type="text" class="form-control" id="evrakadi" placeholder="evrakadi<?=$W88_Text25?>" name="evrakadi">
    <label for="evrakadi"><?=$W88_Text25?></label>
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
 <div class="form-floating">
  <input type="text" class="form-control" id="evrakno" placeholder="evrakno<?=$W88_Text26?>" name="evrakno">
  <label for="evrakno"><?=$W88_Text26?></label>
</div>
</div>
<div><input type="hidden" name="form_ekle"></div>
</div>
<div class="modal-footer p-0">
  <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W88_Text27?></button> </div>
</div>
</div>
</div>
</div>
</form>

<!-- GUNCELLE MODAL -->
<form class="w-100 form_send" id="guncelleme" action="" method="post">
  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W88_Text28?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
         <div class="col-lg-4 col-md-4 col-sm-6 mb-2">
          <div class="form-floating">
            <select class="form-select" id="cari" aria-label="<?=$W88_Text14?>" name="cari">
              <option value="0"><?=$W88_Text14?></option>
              <?php foreach ($carilist as $key => $value) {?>
                <option value="<?=$carilist[$key]["CariID"]?>">
                  <?php if ($carilist[$key]["CariID"]) {echo $carilist[$key]["CariName"];}else{echo $carilist[$key]["CariUnvan"];}?>
                </option>
              <?php } ?>
            </select>
            <label for="cari"><?=$W88_Text15?></label>
          </div>
        </div>
        <!-- datepciker -->
        <div class="col-lg-4 col-md-4 col-sm-6 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control date2" autocomplete="off" id="date2" placeholder="<?=$W88_Text16?>" name="date2">
            <label for="date2"><?=$W88_Text16?></label>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 d-flex  mb-2">
          <div class="form-check pe-2">
            <input class="form-check-input" type="radio" id="gelirgider2" value="1" name="gelirgider" checked>
            <label class="form-check-label" for="gelirgider2">
              <?=$W88_Text17?>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" id="gelirgider" value="0"  name="gelirgider">
            <label class="form-check-label" for="gelirgider">
              <?=$W88_Text18?>
            </label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
         <div class="form-floating">
          <input type="text" class="form-control" id="title" placeholder="title<?=$W88_Text19?>" name="title">
          <label for="title"><?=$W88_Text19?></label>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
       <div class="form-floating">
        <input type="text" class="form-control" id="tutar" placeholder="tutar<?=$W88_Text20?>" name="tutar">
        <label for="tutar"><?=$W88_Text20?></label>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-2">
     <div class="form-floating">
      <input type="text" class="form-control" id="kdv" placeholder="kdv<?=$W88_Text21?>" name="kdv">
      <label for="kdv"><?=$W88_Text21?></label>
    </div>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-6 d-flex mb-2">
   <div class="form-check pe-2">
    <input class="form-check-input" type="radio" id="kdvdurum" value="1"  name="kdvdurum" checked>
    <label class="form-check-label" for="kdvdurum">
     <?=$W88_Text22?>
   </label>
 </div>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="kdvdurum2" value="0" name="kdvdurum">
  <label class="form-check-label" for="kdvdurum2">
   <?=$W88_Text23?>
 </label>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 mb-2">
  <div class="form-floating">
    <textarea class="form-control textarea100" placeholder="not<?=$W88_Text24?>" id="not" name="not"></textarea>
    <label for="not"><?=$W88_Text24?></label>
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
 <div class="form-floating">
  <input type="text" class="form-control" id="evrakadi" placeholder="evrakadi<?=$W88_Text25?>" name="evrakadi">
  <label for="evrakadi"><?=$W88_Text25?></label>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
 <div class="form-floating">
  <input type="text" class="form-control" id="evrakno" placeholder="evrakno<?=$W88_Text26?>" name="evrakno">
  <label for="evrakno"><?=$W88_Text26?></label>
</div>
</div>

<input type="hidden" name="JsID">
<input type="hidden" name="form_edit">
</div>
<div class="modal-footer p-0">
  <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W88_Text29?></button> </div>
</div>
</div>
</div>
</div>
</form>
</section>





<!-- FOOTER -->
<?php include __DIR__.'/prc/footer.php';?>
<!-- JS -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/jquery_3_7.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/bootstrap.bundle.min.js"></script>
<!-- datatables -->
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/dataTable/datatables.js"></script>
<!-- air datepicker -->
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/air-datepicker.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/datepicker3/lang-<?=$LangSeo?>.js"></script>
<script>
  $('.date').each(function() {
    new AirDatepicker(this, {
      timepicker: true,
      locale: mylang
    });
  });
</script>
<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script>
    /*EDIT*/
  $("body").on("click",".row_info",function() {
    let id = $(this).attr("data-id"); 
    $.ajax({
      type: "POST",
      url: "",
      data: {'info_gider':1, 'JsID':id}
    }).done (function(result){             
      console.log(result);
      var obj = JSON.parse(result);
      $('#guncelleme input[name="JsID"]').val(obj.id);                          
      $('#guncelleme select[name="cari"]').val(obj.cari);
      $('#guncelleme input[name="date"]').val(obj.date);                          
      $('#guncelleme input[name="title"]').val(obj.title);                          
      $('#guncelleme input[name="tutar"]').val(obj.tutar);                          
      $('#guncelleme input[name="evrakadi"]').val(obj.evrakadi);                          
      $('#guncelleme input[name="evrakno"]').val(obj.evrakno);                          
      $('#guncelleme input[name="kdv"]').val(obj.kdv);                          
      $('#guncelleme #not').val(obj.not);       
// datapickergunceullemede veri dolu iken secili gelmesini sagliyor
      var startDate2 = new Date(obj.date*1000);
      //let startDate2 = new Date(obj.date);
      new AirDatepicker('.date2', {
        timepicker: true,
        locale: mylang,
        selectedDates: [startDate2]
      });
      if (obj.kdvdurum){
        $('#guncelleme input:radio[name="kdvdurum"]').filter('[value="1"]').attr('checked', true);
      }else{
        $('#guncelleme input:radio[name="kdvdurum"]').filter('[value="0"]').attr('checked', true);
      }                     
      if (obj.gelirgider){
        $('#guncelleme input:radio[name="gelirgider"]').filter('[value="1"]').attr('checked', true);
      }else{
        $('#guncelleme input:radio[name="gelirgider"]').filter('[value="0"]').attr('checked', true);
      }                  

    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W88_Text30?>",
      icon: "warning",
      buttons: ["<?=$W88_Text31?>", "<?=$W88_Text32?>"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {              

        $.ajax({
          type: "POST",
          url: "",
          data: {'delete':1, 'JsID':id}
        }).done (function(result){             
                    //console.log(result);
          var obj = JSON.parse(result);
          console.log(obj);
          if (obj.sonuc=='success'){
            $('#'+id).hide(400);  
          }

        }).fail(function() { console.log( "error" );}).always(function() {});

      }
    });
  });
</script>




<script>
 /* $(document).ready(function() {
    var gelirToplam = 0;
    var giderToplam = 0;

    $("#devnanotek_table tbody tr").each(function() {
            var tutarStr = $(this).find("td:eq(3)").text(); // Tutar sütununun indeksi 3
            var tutar = parseFloat(tutarStr.replace('<?=$W88_Text10?>', '').trim()); // Türk Lirası işaretini kaldır ve boşlukları temizle

            var tur = $(this).find("td:eq(2)").text().trim(); // Tür sütununun indeksi 2

            if (!isNaN(tutar)) {
              if (tur === 'Gelir') {
                gelirToplam += tutar;
              } else if (tur === 'Gider') {
                giderToplam += tutar;
              }
            }
          });

        // Gelir ve gider toplamlarını ilgili div'lere yazdır
    $("#gelirToplam").text("<?=$W88_Text33?> " + gelirToplam.toFixed(2) + " <?=$W88_Text10?>");
    $("#giderToplam").text("<?=$W88_Text34?> " + giderToplam.toFixed(2) + " <?=$W88_Text10?>");

        // Farkı hesapla ve ilgili div'e yazdır
    var fark = gelirToplam - giderToplam;
    $("#farkToplam").text("<?=$W88_Text35?> " + fark.toFixed(2) + " <?=$W88_Text10?>");
  });*/
</script>




</body>
</html>