<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/personal_pay.php");

if (isset($_GET['pdf'])) {include(__DIR__."/app/personal_pay_pdf.php");die(); }
if (isset($Sef[2]) && $Sef[2]=='create'){ include(__DIR__."/payroll_form.php");die; }
if (isset($Sef[2]) && $Sef[2]=='update'){ include(__DIR__."/payroll_form.php");die; }

$PageTitle=$W94_PageTitle;
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
<style>
  .dropdown-toggle::after{display: none;}
  .action-btn{background-color: #efefef; border-radius: 5px; padding: 2px 10px; }
  .action-dots{display: contents; }
</style>
</head>
<body>
  <!-- HEADER -->
  <?php include __DIR__.'/prc/header.php';?>
  <!-- CONTENT -->
  <section>
    <div class="container-xxl mb-5">
      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W94_Text1?></span> 

          <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W94_Text2?></button> -->
          <a class="btn btn-success" href="<?=$SiteUrl.$URL_Payroll?>/create"><i class="fa-solid fa-plus pe-1"></i><?=$W94_Text2?></a>
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W94_Text3?></th>
              <th><?=$W94_Text4?></th>
              <th><?=$W94_Text5?></th>
              <!-- <th><?=$W94_Text6?></th> -->
              <th><?=$W94_Text7?></th>
              <th width="10%"><?=$W94_Text8?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
              <tr id="pay<?=$DataList[$key]["PayID"]?>">
                <td> <?=$DataList[$key]["PayCode"] ?> </td>
                <td> <?=$DataList[$key]["PersonalName"]?> <?=$DataList[$key]["PersonalSurname"]?> </td>
                <td> <?=$DataList[$key]["PayTitle"] ?> </td>
                <!--    <td>
                  <?php
                  // switch ($DataList[$key]["PayDurum"]) {
                  //   case 1: echo "<span style='color:green'>Ödendi</span>"; break;
                  //   case 2: echo "<span style='color:orange'>Beklemede</span>"; break;
                  //}
                  ?>
                </td>  -->
                <td> <?=mony($DataList[$key]["ToplamUcret"],$Currency)?> </td>

                <td align="center">
                  <div class="action-dots">
                    <button class="action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                      <!-- <i class="fa-solid fa-ellipsis"></i>  -->
                      <i class="fa-solid fa-sliders"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <!-- Pfd Görüntüle -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl.$URL_Payroll?>?id=<?=$DataList[$key]["PayCode"]?>&pdf" target="_blank"><i class="fa-regular fa-eye"></i> <?=$W94_Text9?></a></li>
                      <!-- Pdf İndir -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl.$URL_Payroll?>?id=<?=$DataList[$key]["PayCode"]?>&pdf" target="_blank" download="<?=$DataList[$key]["PayCode"]?>.pdf"><i class="fa-solid fa-download"></i> <?=$W76_Text27?></a></li>
                      <!-- Mail Gönder -->
                      <li><a class="dropdown-item payroll_mail_gonder" href="javascript:;" data-href="<?=$SiteUrl.$URL_Payroll?>?id=<?=$DataList[$key]["PayCode"]?>&pdf&mailgonder"><i class="fa-solid fa-paper-plane"></i> Mail Send</a></li>
                      <!-- Düzenle -->
                      <li><a class="dropdown-item" href="<?=$SiteUrl.$URL_Payroll?>/update?id=<?=$DataList[$key]["PayCode"]?>"><i class="fa-regular fa-pen-to-square"></i> <?=$W94_Text10?></a></li>
                      <!-- Sil -->
                      <li><a class="dropdown-item payroll-sil-js" data-id='<?=$DataList[$key]["PayID"]?>' href="javascript:;"><i style="color:red" class="fa-regular fa-trash-can"></i> <?=$W94_Text11?></a></li>
                    </ul>
                  </div>
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
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>

<script>
  //Maaş bodro mail gönder
  $("body").on("click",".payroll_mail_gonder",function(e){
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
  //maaş Sil
  $("body").on("click",".payroll-sil-js",function(e){
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
          data: {'delete':'payroll', 'ID':id}
        }).done (function(result){             
          //console.log(result);
          let obj = JSON.parse(result);
          console.log(obj);
          if (obj.sonuc=='success'){
            $('#pay'+id).hide(400);  
          }
        }).fail(function() { console.log( "error" );}).always(function() {});
      }
    });
  });
</script>
</body>
</html>