<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/banka.php");
$PageTitle=$W87_PageTitle;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W87_Text1?></span> 
          <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W87_Text2?></button> -->
          <a href="<?=$SiteUrl?>banka_form" class="btn btn-success openWindow" modal="modal-lg" h="90vh"><i class="fa-solid fa-plus pe-1"></i><?=$W87_Text2?></a>
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W87_Text3?></th>
              <th><?=$W87_Text4?></th>
              <th><?=$W87_Text5?></th>
              <th><?=$W87_Text6?></th>
              <th><?=$W87_Text7?></th>
              <th><?=$W87_Text8?></th>
              <th width="10%"><?=$W87_Text9?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="<?=$DataList[$key]["BankaID"]?>">
                <td> <?=$DataList[$key]["BankaCode"] ?> </td>
                <td> <?=$DataList[$key]["BankaName"] ?> </td>
                <td> <?=$DataList[$key]["BankaUser"] ?> </td>
                <td> <?=$DataList[$key]["BankaParaBirimi"] ?> </td>
                <td> <?=$DataList[$key]["BankaIBAN"] ?> </td>
                <td>
                  <span class="table_badge green <?php if($DataList[$key]["BankaStatus"]==0){ echo 'hide';}?>"><?=$W87_Text10?></span>
                  <span class="table_badge red <?php if($DataList[$key]["BankaStatus"]==1){ echo 'hide';}?>"><?=$W87_Text11?></span>
                </td>
                <td class="w-10">
                  <a href="<?=$SiteUrl?>banka_form?id=<?=$DataList[$key]["BankaID"]?>" class="btn btn-primary btn-sm me-1 openWindow" modal="yok" h="90vh"><i class="fa-regular fa-pen-to-square"></i> <?=$W87_Text12?></a>

                 <!-- <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["BankaID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W87_Text12?></button> -->
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["BankaID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W87_Text13?></button>
               </td>
             </tr>
           <?php }  ?>
         </tbody>
       </table>
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
<?php include __DIR__.'/prc/modal.php';?>
<script>const iframeModal = new bootstrap.Modal('#iframeModal')</script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script>
/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W87_Text31?>",
      icon: "warning",
      buttons: ["<?=$W87_Text32?>", "<?=$W87_Text33?>"],
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

<script>
  window.addEventListener("message", function(event) {
    var receivedData = event.data;
    
    if(receivedData){
      if(receivedData.sonuc=='success'){      
        let modalToggle = document.getElementById('iframeModal'); iframeModal.hide(modalToggle)
      }
      TabloUpdate(receivedData);
    }
    
  });

  /*TABLO İşlem yap*/
  function TabloUpdate(receivedData) {
    let data=receivedData.Data
    console.log(data);
  
    let statu1="";
    if (data.BankaStatus==1){
      statu1='<span class="table_badge green"><?=$W87_Text10?></span>';
    }else{
      statu1='<span class="table_badge red"><?=$W87_Text11?></span>';
    }
    
    let tableTd=`
      <td>${data.BankaCode}</td>
      <td>${data.BankaName}</td>
      <td>${data.BankaUser}</td>
      <td>${data.BankaParaBirimi}</td>
      <td>${data.BankaIBAN}</td>
      <td>${statu1} </td>
      <td>
        <a href="<?=$SiteUrl?>banka_form?id=${data.BankaID}" class="btn btn-primary btn-sm me-1 openWindow" modal="yok" h="90vh"><i class="fa-regular fa-pen-to-square"></i> <?=$W87_Text12?></a>
        <button class="btn btn-danger btn-sm sil" data-id='${data.BankaID}'><i class="fa-regular fa-trash-can"></i> <?=$W87_Text13?></button>
      </td>`;
    let tableTr=` <tr id="${data.BankaID}">${tableTd}</tr>`;
    if(data.Tablo=='ekle'){
      $('#devnanotek_table tbody').prepend(tableTr); // Tablo kimliğinizi uygun şekilde değiştirin
    }

    if(data.Tablo=='guncelle'){
      let tr = $('#'+data.BankaID);
      tr.html(tableTd);    
    }   
  }
</script>
</body>
</html>