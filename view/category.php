<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/category.php");
$PageTitle=$W85_PageTitle;
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
      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W85_Text1?></span> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W85_Text2?></button></h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W85_Text3?></th>
              <th><?=$W85_Text4?></th>
              <th><?=$W85_Text5?></th>
              <th width="10%"><?=$W85_Text6?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="<?=$DataList[$key]["KateID"]?>">
                <td> <?=$DataList[$key]["KateCode"] ?> </td>
                <td> <?=$DataList[$key]["KateName"] ?> </td>
                <td><?php if ($DataList[$key]["KateStatus"]==1) {echo '<span class="table_badge green">'.$W85_Text7.'</span>'; }else{echo '<span class="table_badge red">'.$W85_Text8.'</span>'; }?></td>
                <td>
                 <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["KateID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W85_Text9?></button>
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["KateID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W85_Text10?></button>
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
          <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W85_Text11?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit" class="w-100 form_send" action="" method="post">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <select class="form-select" id="anakate" aria-label="<?=$W85_Text12?>" name="anakate">
                  <option value="0"><?=$W85_Text12?></option>
                  <?php foreach ($DataList as $key => $value) {?>
                    <option value="<?=$DataList[$key]["KateID"]?>">
                      <?=$DataList[$key]["KateName"]?>
                    </option>
                  <?php } ?>
                </select>
                <label for="anakate"><?=$W85_Text13?></label>
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="name" placeholder="<?=$W85_Text14?>" name="name">
              <label for="name"><?=$W85_Text14?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="form-floating">
              <textarea class="form-control textarea100" placeholder="<?=$W85_Text15?>" id="desc" name="desc"></textarea>
              <label for="desc"><?=$W85_Text15?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="input-group mb-3">
              <input type="file" class="form-control" id="icon" name="icon">
              <label class="input-group-text" for="icon"><?=$W85_Text16?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="input-group mb-3">
              <input type="file" class="form-control" id="resim" name="resim">
              <label class="input-group-text" for="resim"><?=$W85_Text17?></label>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
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
              <span class="ok"><?=$W85_Text18?></span>
              <span class="no"><?=$W85_Text19?></span>
            </label>
          </div>
          <input type="hidden" name="form_add">
        </form>
      </div>
      <div class="modal-footer">
       <div class="btn_col"><button form="edit" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W85_Text20?></button> </div>
     </div>
   </div>
 </div>
</div>

<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W85_Text21?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="guncelleme" class="w-100 form_send" action="" method="post">
         <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
          <div class="form-floating">
            <select class="form-select" id="anakate" aria-label="<?=$W85_Text12?>" name="anakate">
              <option value="0"><?=$W85_Text12?></option>
              <?php foreach ($DataList as $key => $value) {?>
                <option value="<?=$DataList[$key]["KateID"]?>">
                  <?=$DataList[$key]["KateName"]?>
                </option>
              <?php } ?>
            </select>
            <label for="anakate"><?=$W85_Text13?></label>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="name" placeholder="<?=$W85_Text14?>" name="name">
          <label for="name"><?=$W85_Text14?></label>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
        <div class="form-floating">
          <textarea class="form-control textarea100" placeholder="<?=$W85_Text15?>" id="desc" name="desc"></textarea>
          <label for="desc"><?=$W85_Text15?></label>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
        <img class="form_resim icon mb-3" src="">
        <div class="input-group mb-3">
          <input type="file" class="form-control" id="icon" name="icon">
          <label class="input-group-text" for="icon"><?=$W85_Text16?></label>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
        <img class="form_resim resim mb-3" src="">
        <div class="input-group mb-3">
          <input type="file" class="form-control" id="resim" name="resim">
          <label class="input-group-text" for="resim"><?=$W85_Text17?></label>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
        <label class="nnt_input_box" for="durum1">
          <input type="checkbox" class="nnt_input" id="durum1" name="durum" value="1"/>
          <span class="nnt_track">
            <span class="nnt_indicator">
              <span class="checkMark">
                <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                  <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                </svg>
              </span>
            </span>
          </span>
          <span class="ok"><?=$W85_Text18?></span>
          <span class="no"><?=$W85_Text19?></span>
        </label>
      </div>
      <input type="hidden" name="form_edit">
      <input type="hidden" name="JsID" class="JsID">

    </form>
  </div>
  <div class="modal-footer">
   <div class="btn_col"><button form="guncelleme" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W85_Text22?></button> </div>
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
      data: {'kategori_info':1, 'JsID':id}
    }).done (function(result){             
            //console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.id);  
      $('#guncelleme select[name="anakate"]').val(obj.anakate);                         
      $('#guncelleme input[name="name"]').val(obj.name);     
      $('#guncelleme textarea[name="desc"]').val(obj.desc);    
      if (obj.durum){$('#guncelleme input:checkbox[name="durum"]').attr('checked', true);}
      else{$('#guncelleme input:checkbox[name="durum"]').attr('checked', false);}
      $('.icon').attr("src","<?=BASE_URL.$FolderPath?>images/kategory/"+obj.icon); 
      $('.resim').attr("src","<?=BASE_URL.$FolderPath?>images/kategory/"+obj.resim); 

    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W85_Text23?>",
      icon: "warning",
      buttons: ["<?=$W85_Text24?>", "<?=$W85_Text25?>"],
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