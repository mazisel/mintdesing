<?php 
include(__DIR__."/app/kontrol.php");
include(__DIR__."/app/vergi_turu.php");
$PageTitle=$W93_PageTitle;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W93_Text1?></span> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa-solid fa-plus pe-1"></i><?=$W93_Text2?></button></h4>
        <hr>
        <table id="devnanotek_table" class="table table-striped display responsive nowrap pt-2">
          <thead>
            <tr>
              <th><?=$W93_Text3?></th>
              <th>Kategori</th>
              <th><?=$W93_Text4?></th>
              <th>Türü</th>
              <th><?=$W93_Text25?></th>
              <th width="10%"><?=$W93_Text5?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($DataList as $key => $value) {?>
             
              <tr id="<?=$DataList[$key]["VergiID"]?>">
                <td><?=$DataList[$key]["VergiKod"] ?> </td>
                <td><?=ArryaSearch($KateList,'KateID',$DataList[$key]["KateID"])[0]['KateName']?></td>
                <td><?=$DataList[$key]["VergiName"] ?> </td>
                <td>
                  <?php 
                    if ($DataList[$key]["VergiTuru"]=='yuzde') {
                      echo '<span class="table_badge">'.$W93_Text32.'</span>'; 
                    }else{
                      echo '<span class="table_badge" style="background-color: blue; ">'.$W93_Text33.'</span>';
                    }
                  ?>                    
                </td>
                <td>
                  <?php 
                    if ($DataList[$key]["VergiArtiEksi"]=='eksi') {
                      echo '<span class="table_badge red">'.$W93_Text26.'</span>'; 
                    }else{
                      echo '<span class="table_badge green">'.$W93_Text27.'</span>'; 
                    }
                  ?>                    
                </td>
                <td>
                 <button type="button" class="btn btn-primary btn-sm me-1 row_info" data-id='<?=$DataList[$key]["VergiID"]?>' data-bs-toggle="modal" data-bs-target="#editmodal"><i class="fa-regular fa-pen-to-square"></i> <?=$W93_Text6?></button>
                 <button type="button" class="btn btn-danger btn-sm sil"  data-id='<?=$DataList[$key]["VergiID"]?>'><i class="fa-regular fa-trash-can"></i> <?=$W93_Text7?></button>
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
          <h1 class="modal-title fs-5" id="addmodalLabel"><?=$W93_Text8?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit" class="w-100 form_send row m-0 p-0" action="" method="post">
            <!-- Bodro türü -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <div class="form-floating">
                <select class="form-select" id="kate" aria-label="<?=$W93_Text30?>" name="kate">
                  <option value="0"><?=$W93_Text30?></option>
                  <?php foreach ($KateList as $key => $value) {?>
                    <option value="<?=$KateList[$key]["KateID"]?>">
                      <b><?=$KateList[$key]["KateName"]?></b>
                    </option>
                  <?php } ?>
                </select>
                <label for="kate"><?=$W93_Text30?></label>
              </div>
            </div>
            <!-- Kesinti(vergi) Adı -->
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="name" placeholder="<?=$W93_Text9?>" name="name">
                <label for="name"><?=$W93_Text9?></label>
              </div>
            </div>
            <!-- Tutar -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="tutar" placeholder="<?=$W93_Text28?>" name="tutar">
                <label for="tutar"><?=$W93_Text28?></label>
              </div>
            </div>
            <!-- kod -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 col-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="kod" placeholder="<?=$W93_Text29?>" name="kod">
                <label for="kod"><?=$W93_Text29?></label>
              </div>
            </div>      
            <!-- Yüzdelik/Normal Değer -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <label class="nnt_input_box" for="vergituru">
                <input type="hidden" name="vergituru" value="sayi"/>
                <input type="checkbox" class="nnt_input" id="vergituru" name="vergituru" value="yuzde" checked />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok checcolor"><?=$W93_Text32?></span>
                <span class="no checcolor"><?=$W93_Text33?></span>
              </label>
            </div>
            <!-- Eksi/Artı -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <label class="nnt_input_box" for="artieksi">
                <input type="hidden" name="artieksi" value="arti"/>
                <input type="checkbox" class="nnt_input" id="artieksi" name="artieksi" value="eksi" checked />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok checcolor"><?=$W93_Text34?></span>
                <span class="no checcolor"><?=$W93_Text35?></span>
              </label>
            </div>
            <!-- Açıklama -->
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <div class="form-floating">
                <textarea class="form-control textarea100" placeholder="<?=$W93_Text36?>" id="desc" name="desc"></textarea>
                <label for="desc"><?=$W93_Text36?></label>
              </div>
            </div>
            <!-- Status -->
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
                <span class="ok"><?=$W93_Text37?></span>
                <span class="no"><?=$W93_Text38?></span>
              </label>
            </div>

            <input type="hidden" name="form_add">
          </form>
        </div>
        <div class="modal-footer">
          <div class="btn_col"><button form="edit" type="submit" class="btn_style1"><i class="fa-solid fa-plus">&nbsp;</i><?=$W93_Text10?></button> </div>
        </div>
      </div>
    </div>
  </div>

<!-- GUNCELLE MODAL -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel"><?=$W93_Text11?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="guncelleme" class="w-100 form_send row m-0 p-0 " action="" method="post">
          <!-- Bodro türü -->
          <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
            <div class="form-floating">
              <select class="form-select" id="kate" aria-label="<?=$W93_Text30?>" name="kate">
                <option value="0"><?=$W93_Text30?></option>
                <?php foreach ($KateList as $key => $value) {?>
                  <option value="<?=$KateList[$key]["KateID"]?>">
                    <b><?=$KateList[$key]["KateName"]?></b>
                  </option>
                <?php } ?>
              </select>
              <label for="kate"><?=$W93_Text30?></label>
            </div>
          </div>
          <!-- Kesinti(vergi) Adı -->
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="name" placeholder="<?=$W93_Text9?>" name="name">
              <label for="name"><?=$W93_Text9?></label>
            </div>
          </div>
          <!-- Tutar -->
          <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="tutar" placeholder="<?=$W93_Text28?>" name="tutar">
              <label for="tutar"><?=$W93_Text28?></label>
            </div>
          </div>
          <!-- kod -->
          <div class="col-lg-6 col-md-6 col-sm-6 col-6 col-6 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="kod" placeholder="<?=$W93_Text29?>" name="kod">
              <label for="kod"><?=$W93_Text29?></label>
            </div>
          </div>      
          <!-- Yüzdelik/Normal Değer -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <label class="nnt_input_box" for="vergituru1">
                <input type="hidden" name="vergituru" value="sayi"/>
                <input type="checkbox" class="nnt_input" id="vergituru1" name="vergituru" value="yuzde" checked />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok checcolor"><?=$W93_Text32?></span>
                <span class="no checcolor"><?=$W93_Text33?></span>
              </label>
            </div>
            <!-- Eksi/Artı -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
              <label class="nnt_input_box" for="artieksi1">
                <input type="hidden" name="artieksi" value="arti"/>
                <input type="checkbox" class="nnt_input" id="artieksi1" name="artieksi" value="eksi" checked />
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok checcolor"><?=$W93_Text34?></span>
                <span class="no checcolor"><?=$W93_Text35?></span>
              </label>
            </div>
          <!-- Açıklama -->
          <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="form-floating">
              <textarea class="form-control textarea100" placeholder="<?=$W93_Text36?>" id="desc" name="desc"></textarea>
              <label for="desc"><?=$W93_Text36?></label>
            </div>
          </div>
          <!-- Status -->
          <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
            <label class="nnt_input_box" for="durum1">
              <input type="checkbox" class="nnt_input" id="durum1" name="durum" value="1" checked />
              <span class="nnt_track">
                <span class="nnt_indicator">
                  <span class="checkMark">
                    <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                      <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                    </svg>
                  </span>
                </span>
              </span>
              <span class="ok"><?=$W93_Text37?></span>
              <span class="no"><?=$W93_Text38?></span>
            </label>
          </div>

          <input type="hidden" name="form_edit">
          <input type="hidden" name="JsID" class="JsID">
        </form>
      </div>
      <div class="modal-footer">
        <div class="btn_col"><button form="guncelleme" type="submit" class="btn_style1"><i class="fa-solid fa-rotate">&nbsp;</i><?=$W93_Text12?></button> </div>
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
      data: {'vergi_info':1, 'JsID':id}
    }).done (function(result){             
      console.log(result);
      var obj = JSON.parse(result);
      console.log(obj);
      $('#guncelleme input[name="JsID"]').val(obj.id);                          
      $('#guncelleme input[name="name"]').val(obj.name);                           
      $('#guncelleme textarea[name="desc"]').val(obj.desc);                            
      $('#guncelleme input[name="tutar"]').val(obj.tutar);                         
      $('#guncelleme input[name="kod"]').val(obj.kod);                           
      $('#guncelleme select[name="kate"]').val(obj.kate);                                                     
      if (obj.vergituru=='yuzde'){$('#guncelleme input:checkbox[name="vergituru"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="vergituru"]').attr('checked', false); }

      if (obj.artieksi=='eksi'){$('#guncelleme input:checkbox[name="artieksi"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="artieksi"]').attr('checked', false); }

      if (obj.durum){$('#guncelleme input:checkbox[name="durum"]').attr('checked', true); }
      else{$('#guncelleme input:checkbox[name="durum"]').attr('checked', false); }
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

/*DELETE*/
  $("body").on("click",".sil",function(e){ 
    var id= $(this).attr("data-id");  
    swal({
      title: "<?=$W93_Text13?>",
      icon: "warning",
      buttons: ["<?=$W93_Text14?>", "<?=$W93_Text15?>"],
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