<?php 
#fatura_taslak dil======{
$SeoPageLang=DilGel("seo_ayar_page_lang","MyID",98);
$SiteDegiskenleri=$SeoPageLang['SiteDegiskenleri'];
$AdminDegiskenleri=$SeoPageLang['AdminDegiskenleri'];
include 'app/dil.php';
#fatura_taslak gel ======}
include("app/firma_login_kayit.php");
include(__DIR__."/app/kontrol.php");
  
  #Form Update Code ==================== {
    if(isset($_POST['form_update'])) {
      $sql=$DNCrud->ReadAData("firma_fatura_taslak","FirmaID",$Firma['FirmaID']); 
      $pdfRowCount=$sql->rowCount();
      $pdfRow=$sql->fetch(PDO::FETCH_ASSOC);
      if ($pdfRowCount) {
        $Images=json_decode($pdfRow['Images'],true);
      }else{
        $Images=[];
      }

      $NewImages=[];
      $ImageCount=2;
      for($i=0; $i < $ImageCount; $i++) {
        if(!empty($_FILES['Images']['name'][$i])){
          //Klasör Oluştur
          $klasorYol = SitePath."/images/pdf"; if(!file_exists($klasorYol)) {$olustur = mkdir($klasorYol); }

          $options=["file_name"=>"Images", "izinli_uzantilar" => ['jpg','jpeg','png','ico','JPG','JPEG','PNG','webp','svg'], "dir" => SitePath."images/pdf/", "nasil_yuklensin" => "oldugu_gibi",/*oldugu_gibi,kucuk_haliile,sadeceolcu*/ "fitToWidth" => 345, "fitToWidthBuyuk" => Null, "SizeLimit" => Null, "Addegistir" => Null ];
          $FileName=$DNCrud->FileUpload(
          $_FILES[$options['file_name']]['name'][$i],
          $_FILES[$options['file_name']]['size'][$i],
          $_FILES[$options['file_name']]["tmp_name"][$i],
          $options['dir'],
          $options['izinli_uzantilar'],
          $options['nasil_yuklensin'],
          $options['fitToWidth'],
          $options['fitToWidthBuyuk'],$options['SizeLimit'],$options['Addegistir']);

          if($Images[$i]){ $DNCrud->ImageDelete(SitePath."images/pdf/",$Images[$i]); }
          
          $NewImages[]=$FileName;
          if(is_array($FileName) AND $FileName['status']==FALSE) {
            $sunuc = ['status' => FALSE, 'error'=>$options['file_name']." Boyut yüksek".$FileName['error']];
          }
        }else{
          $NewImages[]=$Images[$i];
        }
      }


      $dataFixed=[
        "FirmaID"=>$Firma['FirmaID'],
        "TaslakIcerik"=>$_POST['TaslakIcerik'],
        "TaslakText"=>json_encode($_POST['Variable'])     
      ]; 
      if (count($NewImages)){
       $dataFixed['Images']=json_encode($NewImages);
      }
     
      if ($pdfRowCount) {
        $sonuc=$DNCrud->update("firma_fatura_taslak",$dataFixed,["colomns" => "FirmaID"]);
      }else{
        $sonuc=$DNCrud->insert("firma_fatura_taslak",$dataFixed);
      }
      if($sonuc['status']){
        $result=[
          "sonuc" => 'success',
          'title' =>$W98_Text6,
          'subtitle' =>"",
          'icon' => 'success',
          'btn'=>$W98_Text7,
          'git'=>SITE_URL.'order_taslak',
        ]; echo json_encode($result);die();
      }else{
        $result=[
          "sonuc" => 'error',
          'title' =>$W98_Text8,
          'subtitle' =>"",
          'icon' => 'warning',
          'btn'=>$W98_Text9,
          'message_err'=>$sonuc
        ]; echo json_encode($result);die(); 
      }
    }
  #Form Update Code ==================== }

  $sql=$DNCrud->ReadAData("firma_fatura_taslak","FirmaID",$Firma['FirmaID']); 
  $pdfTaslakRow=$sql->fetch(PDO::FETCH_ASSOC);
  $FirmaID=$Firma['FirmaID'];  
  $TaslakText = json_decode($pdfTaslakRow['TaslakText'],true);
  $ImageCount=2;
  $Images=json_decode($pdfTaslakRow['Images'],true);  
  $DEV=0;

  $ImgNames=[
    0=> $W98_Text2,#'Logo'
    1=> 'Footer'
  ];

$PageTitle=$W98_PageTitle;
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
        <h4 class="d-flex justify-content-between w-100"><span class="pe-3"><?=$W98_Text1?></span></h4>
        <hr>
        


        <form id="edit" class="w-100 form_send" enctype="multipart/form-data" action="" method="post">
          <div class="container-xxl p-0">
            <div class="row m-0 p-0">

            <div class="row mb-3">
              <?php for ($i=0; $i < $ImageCount; $i++) { ?>
                <div class="col-md-4 mb10 p0 pl5">
                  <div style="border: 1px solid #ccc; padding: 15px; border-radius: 10px;">
                    <div class="row">
                      <div class="col-sm-3 control-label"><?=$ImgNames[$i]?></div>
                      <div class="col-md-8 col-sm-8 col-xs-12">     
                        <div style="background: #fbfbfb; padding: 2px;">
                          <img style="max-height: 120px; max-width: 200px;" src="<?=BASE_URL.SitePath?>images/pdf/<?=$Images[$i]?>"> 
                        </div>   
                      </div>
                    </div>
                    <div class="row">
                      <div class="control-label col-md-3 col-sm-4 col-xs-12"> <?=$W98_Text3?></div>
                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="file-loading">
                          <input class="file file-inpt-select" type="file" name="Images[]"  data-max-file-count='1' accept="image/*">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
              <textarea class="" id="editor1" name="TaslakIcerik"><?=$pdfTaslakRow['TaslakIcerik']?></textarea>      
            </div>

              <?php $say=0;if(is_array($TaslakText)) {
              foreach ($TaslakText as $key => $deger){ $say++; ?> <?php  if (isset($TaslakText[$key])) { $deger=$TaslakText[$key]; }  ?>
               <div class="row mb-1" id="<?=$key?>">
                  <?php if($DEV){ $Label=$key; }else{ $Label="Text".$say; } ?>
                  <div class="col-md-2 col-sm-4 col-xs-6"><?=$Label?></div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" name="Variable[<?=$key?>]" value="<?=$deger?>" class="form-control col-md-7 col-xs-12">
                  </div>
                  <?php if($DEV){ ?><div class="col-md-1 pt5"><a href="javascript:;" data-id="<?=$key?>" id="remScnt"><i class="fa-solid fa-trash"></i></a></div><?php } ?>
              </div>  
              <?php }} ?> 
              <?php if($DEV){ ?>
                <div class="buraya"></div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <input type="text" class="form-control col-md-3 col-xs-6 degisken">                          
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                    <a class="btn btn-primary addScnt"><i class="fal fa-plus"></i></a>
                  </div>
                </div> 
              <?php } ?>  


           
              <input type="hidden" name="form_update">
              <div class="col-lg-12 col-md-12 col-sm-12 mb-3 mt-2">
                <button form="edit" type="submit" class="btn_style1"><i class="fa-solid fa-floppy-disk">&nbsp;</i> &nbsp;<?=$W98_Text5?></button>
              </div>
           </div>
          </div>
        </form>


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
<script src="<?=BASE_URL.$FolderPath?>assets/ckeditor/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'editor1', {
      customConfig: '<?=BASE_URL.$FolderPath?>assets/ckeditor/myconfig.js',
      language: '<?=$LangSeo?>'
  });
</script>

<script>
    function getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
    //Website için değişken oluştur
    var scntDiv = $('.buraya');
    $('.addScnt').on('click', function() {       
      Variable=$('.degisken').val();     
      $('<div id="'+Variable+'" class="row mb-1"> <div class="col-md-2 col-sm-4 col-xs-6">'+Variable+'</div> <div class="col-md-8 col-sm-8 col-xs-12"> <input type="text" required name="Variable['+Variable+']" value="" class="form-control col-md-7 col-xs-12"> </div> <div class="col-md-1 pt5"><a href="javascript:;" data-id="'+Variable+'" id="remScnt"><i class="fa-solid fa-trash"></i></a></div>').appendTo(scntDiv);
      $('.degisken').val("");               
    });

    $("body").on("click","#remScnt",function() {
      var id=$(this).attr('data-id');
      $("#"+id).remove();               
    });    
</script>


<link rel="stylesheet" href="<?=BASE_URL.$FolderPath?>assets/file_upload/fileinput.css">
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/fileinput.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/<?=$LangSeo?>.js"></script>
<script src="<?=BASE_URL.$FolderPath?>assets/file_upload/theme_file.js"></script>
<style>.kv-file-upload{display: none !important;}</style>
<script>
   $(".file-inpt-select").fileinput({
        language: '<?=$LangSeo?>',
        theme: 'fa',    
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'PNG', 'GIF', 'JPEG'],
        overwriteInitial: false,
        maxFileSize: 5000,
        maxFilesNum: 50,
        showUpload: false,
        dropZoneEnabled: false        
    });
</script>
</body>
</html>