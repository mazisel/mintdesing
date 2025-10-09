<?php 
include(__DIR__."/app/kontrol.php");
include("app/smtp_ekle.php");
$PageTitle=$W95_PageTtitle;
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
  <?php include __DIR__.'/prc/header.php';?>
  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5">
      <div class="row mb-2">
        <div class="col-lg-6 col-6"><a class="btn btn-dark btnsm" href="<?=$SiteUrl?>smtp_taslak"><i class="fa-solid fa-angle-left"></i></a></div>
        <div class="col-lg-6 col-6"></div>
      </div>

      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100">
          <span class="pe-3"><?=$W95_Text1?></span> 
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W95_Text2?></button>
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W95_Text3?></th>
              <th><?=$W95_Text4?></th>
              <th><?=$W95_Text32?></th>
              <th width="10%"><?=$W95_Text5?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="<?=$DataList[$key]["SmtpID"]?>">
                <td> <?=$DataList[$key]["SmtpGondericiAd"] ?> </td>
                <td> <?=$DataList[$key]["SmtpEmail"] ?> </td>
                <td><?php if ($DataList[$key]["Status"]==1) {echo '<span class="table_badge green">'.$W95_Text30.'</span>'; }else{echo '<span class="table_badge red">'.$W95_Text31.'</span>'; }?></td>
                <td>
                 <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["SmtpID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W95_Text6?></button>
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["SmtpID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W95_Text7?></button>
               </td>
             </tr>
           <?php }  ?>
         </tbody>
       </table>
     </div>
   </div>



   <!-- EKLE MODAL -->
   <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W95_Text8?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit" class="w-100 form_send" action="" method="post">
           <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="gondericiadi" placeholder="<?=$W95_Text9?>" name="gondericiadi">
              <label for="gondericiadi"><?=$W95_Text9?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="sunucu" placeholder="<?=$W95_Text25?>" name="sunucu">
            <label for="sunucu"><?=$W95_Text25?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
         <div class="form-floating">
          <input type="email" class="form-control" id="email" placeholder="<?=$W95_Text26?>" name="email">
          <label for="email"><?=$W95_Text26?></label>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
       <div class="form-floating">
        <input type="text" class="form-control" id="pass" placeholder="<?=$W95_Text27?>" name="pass">
        <label for="pass"><?=$W95_Text27?></label>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
     <div class="form-floating">
      <input type="text" class="form-control" id="port" placeholder="<?=$W95_Text28?>" name="port">
      <label for="port"><?=$W95_Text28?></label>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
    <div class="form-floating">
      <textarea class="form-control textarea100" placeholder="<?=$W95_Text29?>" id="alicilar" name="alicilar"></textarea>
      <label for="alicilar"><?=$W95_Text29?></label>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
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
      <span class="ok"><?=$W95_Text30?></span>
      <span class="no"><?=$W95_Text31?></span>
    </label>
  </div>

  <input type="hidden" name="form_add">
</form>
</div>
<div class="modal-footer">
  <div class="btn_col"><button form="edit" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W95_Text11?></button> </div>
</div>
</div>
</div>
</div>

<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W95_Text12?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="guncelleme" class="w-100 form_send" action="" method="post">
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="gondericiadi" placeholder="<?=$W95_Text9?>" name="gondericiadi">
            <label for="gondericiadi"><?=$W95_Text9?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="sunucu" placeholder="<?=$W95_Text25?>" name="sunucu">
          <label for="sunucu"><?=$W95_Text25?></label>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
       <div class="form-floating">
        <input type="email" class="form-control" id="email" placeholder="<?=$W95_Text26?>" name="email">
        <label for="email"><?=$W95_Text26?></label>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
     <div class="form-floating">
      <input type="text" class="form-control" id="pass" placeholder="<?=$W95_Text27?>" name="pass">
      <label for="pass"><?=$W95_Text27?></label>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
   <div class="form-floating">
    <input type="text" class="form-control" id="port" placeholder="<?=$W95_Text28?>" name="port">
    <label for="port"><?=$W95_Text28?></label>
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
  <div class="form-floating">
    <textarea class="form-control textarea100" placeholder="<?=$W95_Text29?>" id="alicilar" name="alicilar"></textarea>
    <label for="alicilar"><?=$W95_Text29?></label>
  </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 mb-3">
  <label class="nnt_input_box" for="durum2">
    <input type="checkbox" class="nnt_input" id="durum2" name="durum" value="1"/>
    <span class="nnt_track">
      <span class="nnt_indicator">
        <span class="checkMark">
          <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
            <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
          </svg>
        </span>
      </span>
    </span>
    <span class="ok"><?=$W95_Text30?></span>
    <span class="no"><?=$W95_Text31?></span>
  </label>
</div>
<input type="hidden" name="form_edit">
<input type="hidden" name="JsID" class="JsID">
</form>
</div>
<div class="modal-footer">
  <div class="btn_col"><button form="guncelleme" type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W95_Text13?></button> </div>
</div>
</div>
</div>
</div>
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
      data: {'smtp_info':1, 'JsID':id}
    }).done (function(result){             
            //console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.id);                          
      $('#guncelleme input[name="gondericiadi"]').val(obj.gondericiadi);                           
      $('#guncelleme input[name="sunucu"]').val(obj.sunucu);                           
      $('#guncelleme input[name="email"]').val(obj.email);                           
      $('#guncelleme input[name="pass"]').val(obj.pass);                           
      $('#guncelleme input[name="port"]').val(obj.port);
      $('#guncelleme textarea[name="alicilar"]').val(obj.alicilar);  
      if (obj.durum){$('#guncelleme input:checkbox[name="durum"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="durum"]').attr('checked', false);}                          
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W95_Text14?>",
      icon: "warning",
      buttons: ["<?=$W95_Text15?>", "<?=$W95_Text16?>"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {              

        $.ajax({
          type: "POST",
          url: "",
          data: {'JsDel':1, 'JsID':id}
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
</body>
</html>