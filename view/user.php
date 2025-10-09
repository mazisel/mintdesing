<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/user.php");
$PageTitle=$W89_Title;
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
    <div class="container-xxl mb-5">
      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W89_Text1?></span> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W89_Text2?></button></h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
         <thead>
          <tr>
            <th><?=$W89_Text3?></th>
            <th><?=$W89_Text4?></th>
            <th><?=$W89_Text5?></th>
            <th><?=$W89_Text6?></th>
            <th width="10%"><?=$W89_Text7?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($DataList as $key => $value) {?>
            <tr id="<?=$DataList[$key]["UserID"]?>">
              <td><?=$DataList[$key]["UserCode"]?></td>
              <td><?=$DataList[$key]["UserName"]?></td>
              <td><?=$DataList[$key]["UserSurname"]?></td>
              <td>
                <span class="table_badge green <?php if($DataList[$key]["Status"]==0){ echo 'hide';}?>"><?=$W89_Text8?></span>
                <span class="table_badge red <?php if($DataList[$key]["Status"]==1){ echo 'hide';}?>"><?=$W89_Text9?></span>
              </td>
              <td>
               <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["UserID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W89_Text10?></button>
               <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["UserID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W89_Text11?></button>
             </td>
           </tr>
         <?php }  ?>
       </tbody>
     </table>
   </div>
 </div>



 <!-- EKLE MODAL -->
 <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W89_Text12?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form id="add" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
         <div class="row m-0 p-0">
          <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="nick" placeholder="<?=$W89_Text15?>" name="nick">
            <label for="nick"><?=$W89_Text15?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="name" placeholder="<?=$W89_Text13?>" name="name">
          <label for="name"><?=$W89_Text13?></label>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
       <div class="form-floating">
        <input type="text" class="form-control" id="surname" placeholder="<?=$W89_Text14?>" name="surname">
        <label for="surname"><?=$W89_Text14?></label>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
     <div class="form-floating">
      <input type="text" class="form-control" id="pass" placeholder="<?=$W89_Text16?>" name="pass">
      <label for="pass"><?=$W89_Text16?></label>
    </div>
  </div>
  
  <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
   <div class="form-floating">
    <input type="text" class="form-control" id="tel" placeholder="<?=$W89_Text18?>" name="tel">
    <label for="tel"><?=$W89_Text18?></label>
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
 <div class="form-floating">
  <input type="email" class="form-control" id="email" placeholder="<?=$W89_Text19?>" name="email">
  <label for="email"><?=$W89_Text19?></label>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
  <div class="form-floating">
    <textarea class="form-control textarea100" placeholder="desc<?=$W89_Text36?>" id="desc" name="desc"></textarea>
    <label for="desc"><?=$W89_Text36?></label>
  </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
  <div class="input-group mb-3">
    <input type="file" class="form-control" id="resim" name="resim">
    <label class="input-group-text" for="resim"><?=$W89_Text41?></label>
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
    <span class="ok"><?=$W89_Text44?></span>
    <span class="no"><?=$W89_Text45?></span>
  </label>
</div>

</div>
<input type="hidden" name="form_add">
<input type="hidden" name="modal_kapat" value="addmodal">
</form>
</div> 
<div class="modal-footer">
  <div class="btn_col"><button form="add" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W89_Text47?></button> </div>
</div>
</div>
</div>
</div>


<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W89_Text48?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form id="guncelleme" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
        <div class="row m-0 p-0">
          <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
           <div class="form-floating">
            <input type="text" class="form-control" id="nick" placeholder="<?=$W89_Text15?>" name="nick">
            <label for="nick"><?=$W89_Text15?></label>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
         <div class="form-floating">
          <input type="text" class="form-control" id="name" placeholder="<?=$W89_Text13?>" name="name">
          <label for="name"><?=$W89_Text13?></label>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
       <div class="form-floating">
        <input type="text" class="form-control" id="surname" placeholder="<?=$W89_Text14?>" name="surname">
        <label for="surname"><?=$W89_Text14?></label>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
     <div class="form-floating">
      <input type="text" class="form-control" id="pass" placeholder="<?=$W89_Text16?>" name="pass">
      <label for="pass"><?=$W89_Text16?></label>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
   <div class="form-floating">
    <input type="text" class="form-control" id="tel" placeholder="<?=$W89_Text18?>" name="tel">
    <label for="tel"><?=$W89_Text18?></label>
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
 <div class="form-floating">
  <input type="email" class="form-control" id="email" placeholder="<?=$W89_Text19?>" name="email">
  <label for="email"><?=$W89_Text19?></label>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
  <div class="form-floating">
    <textarea class="form-control textarea100" placeholder="desc<?=$W89_Text36?>" id="desc" name="desc"></textarea>
    <label for="desc"><?=$W89_Text36?></label>
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
  <img class="form_resim resim mb-3" src="">
  <div class="input-group mb-3">
    <input type="file" class="form-control" id="resim" name="resim">
    <label class="input-group-text" for="resim"><?=$W89_Text41?></label>
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
    <span class="ok"><?=$W89_Text44?></span>
    <span class="no"><?=$W89_Text45?></span>
  </label>
</div>

</div>

<input type="hidden" name="modal_kapat" value="editmodal">
<input type="hidden" name="form_edit">
<input type="hidden" name="JsID">
</form>
</div> 
<div class="modal-footer">
  <div class="btn_col">
    <button form="guncelleme" type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W89_Text49?></button>
  </div> 
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
      data: {'user_info':1, 'JsID':id}
    }).done (function(result){             
      console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.JsID); 
      $('#guncelleme input[name="nick"]').val(obj.nick);                          
      $('#guncelleme input[name="name"]').val(obj.name);                          
      $('#guncelleme input[name="surname"]').val(obj.surname);                                                              
      $('#guncelleme input[name="pass"]').val(obj.pass);                                                              
      $('#guncelleme input[name="tel"]').val(obj.tel);                          
      $('#guncelleme input[name="email"]').val(obj.email);                                           
      $('#guncelleme textarea[name="desc"]').val(obj.desc);                         
      if (obj.durum){$('#guncelleme input:checkbox[name="durum"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="durum"]').attr('checked', false); }
      $('.resim').attr("src","<?=BASE_URL.$FolderPath?>images/user/"+obj.resim);    
      
    }).fail(function() { console.log( "error" );}).always(function() {});
  });


/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W89_Text50?>",
      icon: "warning",
      buttons: ["<?=$W89_Text51?>", "<?=$W89_Text52?>"],
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


 /*TABLO*/
  function TabloUpdate(data) {
    if (data.Tablo=='ekle'){
    // Yeni bir satır oluşturun
      var newRow = $('<tr id="'+data.JsID+'">');
    // Satırın içeriğini oluşturun
      var td1 = $('<td>').text(data.code);
      var td2 = $('<td>').text(data.name);
      var td3 = $('<td>').text(data.surname);
      var td4 = $('<td>');
      var badgeSpan = $('<span>').addClass('table_badge');
      if (data.durum == 1) {badgeSpan.addClass('green').text('<?=$W89_Text8?>'); }
      else {badgeSpan.addClass('red').text('<?=$W89_Text9?>'); }
      td4.append(badgeSpan);
      var td5 = $('<td>');
      var editButton = $('<button>').attr({
        'type': 'button',
        'class': 'btn btn-primary btn-sm me-1 row_info',
        'data-id': data.JsID,
        'data-bs-toggle': 'modal',
        'data-bs-target': '#editmodal'
      }).html('<i class="fa-regular fa-pen-to-square"></i> <?=$W89_Text10?>');
      var deleteButton = $('<button>').attr({
        'type': 'button',
        'class': 'btn btn-danger btn-sm sil',
        'data-id': data.JsID
      }).html('<i class="fa-regular fa-trash-can"></i> <?=$W89_Text11?>');
      td5.append(editButton, deleteButton);
      // Satırı tabloya ekleyin
      newRow.append(td1, td2, td3, td4, td5);
      $('#devnanotek_table').prepend(newRow); // Tablo kimliğinizi uygun şekilde değiştirin
    }
    if (data.Tablo=='guncelle'){
      let tr = $('#'+data.JsID);
      tr.find('td:eq(1)').html(data.name);
      tr.find('td:eq(2)').html(data.surname);
      if (data.durum==1){
        tr.find('td:eq(3) .red').addClass('hide');
        tr.find('td:eq(3) .green').removeClass('hide');
      }else{
        tr.find('td:eq(3) .red').removeClass('hide');
        tr.find('td:eq(3) .green').addClass('hide');
      }   
    }   
  }
</script>
</body>
</html>