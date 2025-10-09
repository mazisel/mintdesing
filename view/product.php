<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/product.php");
$PageTitle=$W80_PageTitle;
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
        <div class="col-lg-6 col-6"></div>
        <div class="col-lg-6 col-6" align="right"><a class="btn btn-success btnsm" href="<?=$SiteUrl?>product_form"><i class="fa-solid fa-plus pe-1"></i> <?=$W80_Text2?></a></div>
      </div>

      <div class="table_body_bg">
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W80_Text1?></span> 

         <!--  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W80_Text2?></button> -->
        </h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W80_Text3?></th>
              <th><?=$W80_Text4?></th>
              <th><?=$W80_Text5?></th>
              <th><?=$W80_Text6?></th>
              <th><?=$W80_Text7?></th>
              <th><?=$W80_Text8?></th>
              <th width="10%"><?=$W80_Text9?></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($DataList as $key => $value){
              $indis = ArryaSearchIndis($UnitList,"UnitID",$DataList[$key]["UnitID"]);
            ?>
              <tr id="<?=$DataList[$key]["ProductID"]?>">
                <td> <?=$DataList[$key]["ProductBarkod"] ?> </td>
                <td> <?=$DataList[$key]["ProductName"] ?> </td>
                <td> <?=$UnitList[$indis]["UnitName"]?> </td>
                <td> <?=mony($DataList[$key]["ProductFiyat"])?> </td>
                <td><?php if ($DataList[$key]["ProductStatus"]==1) {echo '<span class="table_badge green">'.$W80_Text10.'</span>'; }else{echo '<span class="table_badge red">'.$W80_Text46.'</span>'; }?></td>
                <td><?php if ($DataList[$key]["ProductKdvDurum"]==1) {echo '<span class="table_badge green">'.$W80_Text11.'</span>'; }else{echo '<span class="table_badge red">'.$W80_Text47.'</span>'; }?></td>
                <td>
                  <a href="<?=$SiteUrl?>product_form?id=<?=$DataList[$key]["ProductID"]?>" class="btn btn-primary btn-sm me-1" ><i class="fa-regular fa-pen-to-square"></i> <?=$W80_Text12?></a>
                  <button type="button" class="btn btn-danger btn-sm sil" data-id='<?=$DataList[$key]["ProductID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W80_Text13?></button>
                 </td>
              </tr>
            <?php } ?>
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
<script src="<?=BASE_URL.$FolderPath?>assets/js/panel.js<?=$UPDATE_VERSION?>"></script>
<script>
/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W80_Text35?>",
      icon: "warning",
      buttons: ["<?=$W80_Text36?>", "<?=$W80_Text37?>"],
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