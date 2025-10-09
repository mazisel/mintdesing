<?php 
#Banka dil gel ======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",79);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#Banka dil gel ======}
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/personal.php");

if(isset($Sef[2]) && $Sef[2]=='form'){ include(__DIR__."/personal_form.php");die; }

$PageTitle=$W79_Title;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W79_Text1?></span> 
          <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W79_Text2?></button> -->
          <a href="<?=$SiteUrl.$URL_Personnel?>/form" class="btn btn-success openWindow" modal="modal-xl" h="90vh"><i class="fa-solid fa-plus pe-1"></i><?=$W79_Text2?></a>
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
         <thead>
          <tr>
            <th><?=$W79_Text3?></th>
            <th><?=$W79_Text4?></th>
            <th><?=$W79_Text5?></th>
            <th><?=$W79_Text6?></th>
            <th width="10%"><?=$W79_Text7?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($DataList as $key => $value) {?>
            <tr id="<?=$DataList[$key]["PersonalID"]?>">
              <td><?=$DataList[$key]["PersonalCode"]?></td>
              <td><?=$DataList[$key]["PersonalName"]?></td>
              <td><?=$DataList[$key]["PersonalSurname"]?></td>
              <td>
                <span class="table_badge green <?php if($DataList[$key]["PersonalDurum"]==0){ echo 'hide';}?>"><?=$W79_Text8?></span>
                <span class="table_badge red <?php if($DataList[$key]["PersonalDurum"]==1){ echo 'hide';}?>"><?=$W79_Text9?></span>
              </td>
              <td>
               <!-- <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["PersonalID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W79_Text10?></button> -->
               <a href="<?=$SiteUrl.$URL_Personnel?>/form?id=<?=$DataList[$key]["PersonalID"]?>" class="btn btn-primary btn-sm me-1 openWindow" modal="modal-xl" h="90vh" ><i class="fa-regular fa-pen-to-square"></i> <?=$W79_Text10?></a>
               <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["PersonalID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W79_Text11?></button>
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

<!-- style -->
<script src="<?=BASE_URL.$FolderPath?>assets/js/style.js<?=$UPDATE_VERSION?>"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/sweet-alert-min.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script>


/*DELETE*/
$("body").on("click",".sil",function(e){ 
  var id= $(this).attr("data-id");  
  swal({
    title: "<?=$W79_Text50?>",
    icon: "warning",
    buttons: ["<?=$W79_Text51?>", "<?=$W79_Text52?>"],
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
    if (data.durum == 1) {badgeSpan.addClass('green').text('<?=$W79_Text8?>'); }
    else {badgeSpan.addClass('red').text('<?=$W79_Text9?>'); }
    td4.append(badgeSpan);
    var td5 = $('<td>');
    var editButton = $('<button>').attr({
      'type': 'button',
      'class': 'btn btn-primary btn-sm me-1 row_info',
      'data-id': data.JsID,
      'data-bs-toggle': 'modal',
      'data-bs-target': '#editmodal'
    }).html('<i class="fa-regular fa-pen-to-square"></i> <?=$W79_Text10?>');
    var deleteButton = $('<button>').attr({
      'type': 'button',
      'class': 'btn btn-danger btn-sm sil',
      'data-id': data.JsID
    }).html('<i class="fa-regular fa-trash-can"></i> <?=$W79_Text11?>');
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
</script>
</body>
</html>