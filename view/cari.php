<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/cari.php");
$PageTitle=$W78_Text1;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W78_Text2?></span> 
          <a href="<?=$SiteUrl?>cari_form" class="btn btn-success openWindow" modal="modal-xl" h="90vh"><i class="fa-solid fa-plus pe-1"></i><?=$W78_Text3?></a>
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
         <thead>
          <tr>
            <th width="5%"><?=$W78_Text4?></th>
            <th><?=$W78_Text5?></th>
            <th><?=$W78_Text6?></th>
            <th><?=$W78_Text7?></th>
            <th width="12%"><?=$W78_Text8?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($DataList as $key => $value) {?>
            <tr id="<?=$DataList[$key]["CariID"]?>">
              <td> <?=$DataList[$key]["CariCode"] ?> </td>
              <td> 
                <b class="d-flex w-100" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?=$W78_Text9?>"><?=$DataList[$key]["CariUnvan"] ?></b> 
                <ul class="ul_sifirla d-flex" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?=$W78_Text10?>">
                  <li class="pe-2"><?=$DataList[$key]["CariName"]?></li>
                  <li class="pe-2"><?=$DataList[$key]["CariSurname"]?></li>
                </ul>
              </td>
              <td>
                <?php if ($DataList[$key]["CariMusteri"]) {echo '<span class="table_badge green">'.$W78_Text11.'</span>'; } ?>
                <?php if ($DataList[$key]["CariTedarikci"]) {echo '<span class="table_badge">'.$W78_Text12.'</span>'; } ?>
              </td>
              <td>
                <?php if ($DataList[$key]["CariDurum"]==1) {echo '<span class="table_badge green">'.$W78_Text13.'</span>'; }else{echo '<span class="table_badge red">'.$W78_Text14.'</span>'; }  ?>
              </td>
              <td>
                <a href="<?=$SiteUrl?>cari_form?id=<?=$DataList[$key]["CariID"]?>" class="btn btn-primary btn-sm me-1 openWindow" modal="modal-xl" h="90vh"><i class="fa-regular fa-pen-to-square"></i> <?=$W78_Text15?></a>
                <button class="btn btn-danger btn-sm sil" data-id='<?=$DataList[$key]["CariID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W78_Text16?></button>
              </td>
            </tr>
       <?php }  ?>
     </tbody>
   </table>
 </div>
</div>


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
<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<?php include __DIR__.'/prc/modal.php';?>
<script>const iframeModal = new bootstrap.Modal('#iframeModal')</script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script>
/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W78_Text50?>",
      icon: "warning",
      buttons: ["<?=$W78_Text51?>", "<?=$W78_Text52?>"],
      dangerMode: true,
    }).then((willDelete) => {
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
<script>
  window.addEventListener("message", function(event) {
    var receivedData = event.data;
    
    if(receivedData){
      if(receivedData.sonuc=='success'){      
        let modalToggle = document.getElementById('iframeModal'); 
        iframeModal.hide(modalToggle)
      }
      TabloUpdate(receivedData);
    }
    
  });

  /*TABLO İşlem yap*/
  function TabloUpdate(receivedData) {
    let data=receivedData.Data
    console.log(data);
    badge="";
    if (data.CariMusteri==1){
      badge+='<span class="table_badge green"><?=$W78_Text11?></span>';
    }
    if (data.CariTedarikci){
      badge+='<span class="table_badge"><?=$W78_Text12?></span>';
    }
    let statu1="";
    if (data.CariDurum==1){
      statu1='<span class="table_badge green"><?=$W78_Text13?></span>';
    }else{
      statu1='<span class="table_badge red"><?=$W78_Text14?></span>';
    }
    
    let tableTd=`<td>${data.CariCode}</td>
      <td> 
        <b class="d-flex w-100" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?=$W78_Text9?>">${data.CariUnvan}</b> 
        <ul class="ul_sifirla d-flex" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?=$W78_Text10?>">
         <li class="pe-2"> ${data.CariName} </li>
         <li class="pe-2"> ${data.CariSurname} </li>
        </ul>
      </td>
      <td>${badge} </td>
      <td>${statu1} </td>
      <td>
        <a href="<?=$SiteUrl?>cari_form?id=${data.CariID}" class="btn btn-primary btn-sm me-1 openWindow" modal="modal-xl" h="90vh"><i class="fa-regular fa-pen-to-square"></i> <?=$W78_Text15?></a>
        <button class="btn btn-danger btn-sm sil" data-id='${data.CariID}'><i class="fa-regular fa-trash-can"></i> <?=$W78_Text16?></button>
      </td>`;
    let tableTr=` <tr id="${data.CariID}">${tableTd}</tr>`;
    if(data.Tablo=='ekle'){
      $('#devnanotek_table tbody').prepend(tableTr); // Tablo kimliğinizi uygun şekilde değiştirin
    }

    if(data.Tablo=='guncelle'){
      let tr = $('#'+data.CariID);
      tr.html(tableTd);    
    }   
  }
</script>
</body>
</html>