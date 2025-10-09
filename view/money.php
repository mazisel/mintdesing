<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/money.php");
$PageTitle=$W86_PageTitle;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W86_Text1?></span> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W86_Text2?></button></h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W86_Text3?></th>
              <th><?=$W86_Text4?></th>
              <th><?=$W86_Text5?></th>
              <th><?=$W86_Text6?></th>
              <th><?=$W86_Text7?></th>
              <th width="10%"><?=$W86_Text8?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="<?=$DataList[$key]["ParaID"]?>">
                <td> <?=$DataList[$key]["ParaCode"] ?> </td>
                <td> <?=$DataList[$key]["ParaName"] ?> </td> 
                <td> <?=$DataList[$key]["ParaShort"] ?> </td> 
                <td> <?=$DataList[$key]["ParaIco"] ?> </td> 
                <td><?php if ($DataList[$key]["ParaStatus"]==1) {echo '<span class="table_badge green">'.$W86_Text9.'</span>'; }else{echo '<span class="table_badge red">'.$W86_Text10.'</span>'; }?></td>
                <td>
                 <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["ParaID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W86_Text11?></button>
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["ParaID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W86_Text12?></button>
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
          <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W86_Text13?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit" class="w-100 row m-0 p-0 form_send" action="" method="post">
           <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="name" placeholder="<?=$W86_Text14?>" name="name">
              <label for="name"><?=$W86_Text14?></label>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="icon" placeholder="<?=$W86_Text15?>" name="icon">
            <label for="icon"><?=$W86_Text15?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="kisa" placeholder="<?=$W86_Text16?>" name="kisa">
          <label for="kisa"><?=$W86_Text16?></label>
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
          <span class="ok"><?=$W86_Text17?></span>
          <span class="no"><?=$W86_Text18?></span>
        </label>
      </div>
      <input type="hidden" name="form_add">
    </form>
  </div>
  <div class="modal-footer">
   <div class="btn_col"><button form="edit" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W86_Text19?></button> </div>
 </div>
</div>
</div>
</div>

<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W86_Text20?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="guncelleme" class="w-100 row m-0 p-0 form_send" action="" method="post">
         <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="name" placeholder="<?=$W86_Text14?>" name="name">
            <label for="name"><?=$W86_Text14?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="icon" placeholder="<?=$W86_Text15?>" name="icon">
          <label for="icon"><?=$W86_Text15?></label>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
       <div class="form-floating">
        <input type="text" class="form-control" id="kisa" placeholder="<?=$W86_Text16?>" name="kisa">
        <label for="kisa"><?=$W86_Text16?></label>
      </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
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
        <span class="ok"><?=$W86_Text17?></span>
        <span class="no"><?=$W86_Text18?></span>
      </label>
    </div>
    <input type="hidden" name="form_edit">
    <input type="hidden" name="JsID" class="JsID">
  </form>
</div>
<div class="modal-footer">
 <div class="btn_col"><button form="guncelleme" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W86_Text21?></button> </div>
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
      data: {'money_info':1, 'JsID':id}
    }).done (function(result){             
            //console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.id);                          
      $('#guncelleme input[name="name"]').val(obj.name);                           
      $('#guncelleme input[name="icon"]').val(obj.icon);                           
      $('#guncelleme input[name="kisa"]').val(obj.kisa);                           
      if (obj.durum){$('#guncelleme input:checkbox[name="durum"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="durum"]').attr('checked', false); }
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W86_Text22?>",
      icon: "warning",
      buttons: ["<?=$W86_Text23?>", "<?=$W86_Text24?>"],
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