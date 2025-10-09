<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/ulke.php");
$PageTitle=$W83_PageTitle;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W83_Text1?></span> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W83_Text2?></button></h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W83_Text3?></th>
              <th><?=$W83_Text4?></th>
              <th width="10%"><?=$W83_Text5?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="<?=$DataList[$key]["UlkeID"]?>">
                <td>
                 <?=$DataList[$key]["UlkeAlanKodu"] ?>
               </td>
               <td>
                 <?=$DataList[$key]["UlkeName"] ?>
               </td>
               <td>
                 <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["UlkeID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W83_Text6?></button>
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["UlkeID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W83_Text7?></button>
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
          <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W83_Text8?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="w-100 form_send" action="" method="post">
           <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="alankodu" placeholder="<?=$W83_Text9?>" name="alankodu">
              <label for="alankodu"><?=$W83_Text9?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="name" placeholder="<?=$W83_Text10?>" name="name">
            <label for="name"><?=$W83_Text10?></label>
          </div>
        </div>
        <input type="hidden" name="form_add">
        <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W83_Text11?></button> </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W83_Text12?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="guncelleme" class="w-100 form_send" action="" method="post">
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
             <div class="form-floating">
              <input type="text" class="form-control" id="alankodu" placeholder="<?=$W83_Text9?>" name="alankodu">
              <label for="alankodu"><?=$W83_Text9?></label>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="name" placeholder="<?=$W83_Text10?>" name="name">
            <label for="name"><?=$W83_Text10?></label>
          </div>
        </div>
       <input type="hidden" name="form_edit">
       <input type="hidden" name="JsID" class="JsID">
       <div class="btn_col"><button type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W83_Text13?></button> </div>
     </form>
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
      data: {'ulke_info':1, 'JsID':id}
    }).done (function(result){             
            //console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.id);                          
      $('#guncelleme input[name="alankodu"]').val(obj.alankodu);                           
      $('#guncelleme input[name="name"]').val(obj.name);                           
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W83_Text14?>",
      icon: "warning",
      buttons: ["<?=$W83_Text15?>", "<?=$W83_Text16?>"],
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