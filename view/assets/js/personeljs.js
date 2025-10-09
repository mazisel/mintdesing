  function SepetiGoster() {

    let urunHtml='';
    for(var i=0; i<BASKET.length; i++) {
       let urun= BASKET[i];let Miktar,Toplam;
       if (urun.Miktar==0){ Miktar=null; }else{ Miktar=urun.Miktar; }
       if (urun.Toplam==0){ Toplam=mony(0,'TL'); }else{ Toplam=mony(urun.Toplam,"TL"); }
        
       urunHtml+=`
        <div class="pro_box" id='urun-${urun.ID}-${i}' data-fiyat="">
          <b class="pro_name mb-2">
          <span class="satir_1">${urun.Name}</span>
          <button data-id="31" data-sira="${i}" class="delbtn sil-btn-js"><i class="fa-regular fa-trash-can"></i></button>
          </b>
          <div class="form_row">
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="text" class="form-control" id="fiyat" data-sira="${i}" data-id="${urun.ID}" placeholder="fiyat" name="fiyat" value="${mony(urun.Fiyat)}">
                <label for="fiyat">Fiyat</label>
              </div>
            </div>
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="number" class="form-control" id="kdv" data-sira="${i}" data-id="${urun.ID}" placeholder="kdvorani" name="kdv" value="${urun.KDV}">
                <label for="kdv">Kdv Oranı</label>
              </div>
            </div>
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="number" class="form-control" id="mktr" data-sira="${i}" data-id="${urun.ID}" placeholder="miktar" name="miktar" value="${Miktar}">
                <label for="mktr">Miktar</label>
              </div>
            </div>
            <b class="toplam toplam-${urun.ID}-${i}">${Toplam}</b>            
          </div>
        </div>`;      
    }
    $('.urunler_box').html(urunHtml);
    SepetToplam();
  }




    let BASKET=[];
  let NetToplam=0;
  let KDVToplam=0;
  let GenelToplam=0;
  let urunSirasi=0;
  <?php if($OrderRow['OrderUrun']){ ?>
    BASKET = JSON.parse('<?=$OrderRow['OrderUrun']?>');
    console.log(BASKET);
    SepetiGoster();
  <?php } ?>
  $("body").on("change",".urun-select-js",function() {
    let id=$(this).val();
    $.ajax({
      type: "POST",
      url: "",
      data: {'urun_info':1, 'jsid':id}
    }).done (function(result){
      let SecilenUrun={};
      var obj = JSON.parse(result);
      if(obj.result=='success'){
        SecilenUrun['ID']=obj.ProductID;
        SecilenUrun['Name']=obj.ProductName;
        SecilenUrun['Fiyat']=parseFloat(obj.ProductFiyat);
        SecilenUrun['KDV']=parseFloat(obj.ProductKDV);
        SecilenUrun['KDVDurum']=obj.ProductKdvDurum;
        SecilenUrun['Miktar']=1;
        SecilenUrun['Toplam']=parseFloat(obj.ProductFiyat);
        BASKET.push(SecilenUrun);  
        //$('.urun-select-js').val();
      }
      console.log(BASKET);
      SepetiGoster();
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

  $("body").on("input",'input[name="fiyat"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });
  $("body").on("input",'input[name="kdv"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });
  $("body").on("input",'input[name="miktar"]',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    hesaplamaYap(id,sira);
  });  
  $("body").on("click",'.sil-btn-js',function() {
    var id= $(this).attr("data-id");  
    var sira= $(this).attr("data-sira");  
    //$('#urun-'+id+'-'+sira).remove();
    BASKET.splice(sira,1);  
    SepetiGoster();
    console.log(BASKET);
  });


  //Formu gönder
  $('.form_send2').on("submit", function (e) {
    e.preventDefault(); 
    $('.form_loader').css('display', 'flex'); 
    var form = $(this);
    var url = form.attr('action');
    let formData = new FormData(this); // Mevcut FormData nesnesini oluşturun
    formData.append('BASKET', JSON.stringify(BASKET));
    formData.append('NetToplam', NetToplam);
    formData.append('KDVToplam', KDVToplam);
    formData.append('GenelToplam', GenelToplam);

    $.ajax({
      type: "POST",
      url: url,
      cache: false,
      contentType: false,
      processData: false,
      data: formData
    }).done (function(result){
      $('.form_loader').css('display', 'none');    
      console.log(result);
      let obj = JSON.parse(result);

      swal({title: obj.title,text: obj.subtitle, icon: obj.icon,button:obj.btn});
      if (obj.sonuc=="success" && obj.git) {
        window.location.href = obj.git;  
      } 
      if (obj.sonuc=="success") {
        let modal_kapat=$('input[name="modal_kapat"]').val();
        if (modal_kapat){
          console.log(modal_kapat);
          let myModal = new bootstrap.Modal('#'+modal_kapat)
          myModal.hide()
        }
      }
      if(obj.yap=="reset") {
        console.log("#"+obj.formid);
        $("#"+obj.formid).trigger("reset");
      }                                 
    }).fail(function() { console.log( "error" );}).always(function() {});
  });

