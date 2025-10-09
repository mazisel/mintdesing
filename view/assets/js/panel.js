//Form Gönder JS ==================================================================== {
  $("body").on("submit",".form_send",function(e){
    e.preventDefault(); 
    $('.form_loader').css('display', 'flex'); 
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: new FormData(this)// serializes the form's elements
    }).done(function(result){
        $('.form_loader').css('display', 'none');    
        console.log(result);       
        var obj = JSON.parse(result);
        swal({title: obj.title,text: obj.subtitle, icon: obj.icon,button:obj.btn});
        if(obj.sonuc=="success" && obj.git){
          window.location.href = obj.git;  
        } 
        if(obj.sonuc=="success"){
          let modal_kapat=form.find('input[name="modal_kapat"]').val();
          if(modal_kapat){
            console.log(modal_kapat);
            $("#"+modal_kapat+" .btn-close").click()
          }
          let iframeModalInpt=form.find('input[name="iframeModal"]').val();
          if(iframeModalInpt){
            window.parent.postMessage(obj, "*");
          }
        }
        if(obj.yap=="reset"){ form.trigger("reset"); }
    }).fail(function() {
      $('.form_loader').css('display', 'none');  
      console.log( "error" );
    }).always(function() {});
  });
//Form Gönder JS ==================================================================== }

  //Iframe modalını aç
  $("body").on("click",".openWindow",function(event) { 
      event.preventDefault();
      let href = $(this).attr('href'); 
      let modalTur = $(this).attr('modal'); 
      let height = $(this).attr('h'); 
      $('.iframeModal').addClass(modalTur)
      $('.modal-iframe').attr('src',href+'&screen=iframeWindow');
      $('.modal-content-iframe').height(height);    
      const modalToggle = document.getElementById('iframeModal'); iframeModal.show(modalToggle)
  });

  var tamURL = window.location.href;
  $('input[name="bocek_link"]').val(tamURL);

  function SepetiGoster(){
    let urunHtml='';
    for(var i=0; i<BASKET.length; i++){
      let urun= BASKET[i];let Miktar,Toplam,ProductKdvDurum;
      if (urun.Miktar==0){ Miktar=null; }else{ Miktar=urun.Miktar; }
      if (urun.Toplam==0){ Toplam=mony(0); }else{ Toplam=mony(urun.Toplam); }
      if (urun.KDVDurum==1){ ProductKdvDurum='checked';  }else{ ProductKdvDurum=''; }
       urunHtml+=`
        <div class="pro_box" id='urun-${urun.ID}-${i}' data-fiyat="">
          <b class="pro_name mb-2">
          <span class="satir_1">${urun.Name}</span>
          <button data-id="31" data-sira="${i}" class="delbtn sil-btn-js"><i class="fa-regular fa-trash-can"></i></button>
          </b>
          <div class="row">
          <div class="col-lg-2 col-md-2 col-4 mb-2">
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="text" required class="form-control currency" id="fiyat" data-sira="${i}" data-id="${urun.ID}" placeholder="${TextFiyat}" name="fiyat" value="${urun.Fiyat}">
                <label for="fiyat">${TextFiyat}</label>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-4 mb-2">
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="number" required class="form-control" id="mktr" data-sira="${i}" data-id="${urun.ID}" placeholder="${TextMiktar}" name="miktar" value="${Miktar}">
                <label for="mktr">${TextMiktar}</label>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-4 mb-2">
            <div class="input_box">
              <div class="form-floating input_box_2">
                <input type="number" required class="form-control" id="kdv" data-sira="${i}" data-id="${urun.ID}" placeholder="${TextKdv}" name="kdv" value="${urun.KDV}">
                <label for="kdv">${TextKdv}</label>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-7 ">
              <label class="nnt_input_box" for="kdvdurum${i}">
                <input type="checkbox" class="nnt_input" id="kdvdurum${i}" name="kdvdurum" value="1" ${ProductKdvDurum} data-sira="${i}" data-id="${urun.ID}"/>
                <span class="nnt_track">
                  <span class="nnt_indicator">
                    <span class="checkMark">
                      <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                        <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                      </svg>
                    </span>
                  </span>
                </span>
                <span class="ok">${W80_Text28}</span>
                <span class="no">${W80_Text29}</span>
              </label>
           </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-5">            
            <b class="toplam toplam-${urun.ID}-${i}">${Toplam}</b>
          </div>         
          </div>
        </div>`;      
    }
    $('.urunler_box').html(urunHtml);

     $(".currency").inputmask('currency',{
      alias: 'decimal',
      prefix: '',
      rightAlign: false, groupSeparator: '.', clearMaskOnLostFocus: true, radixPoint: '.', autoGroup: true
    });

    SepetToplam();
  }
  function hesaplamaYap(id,sira){
    let fiyat= $('#urun-'+id+'-'+sira+' input[name="fiyat"]').val();
    fiyat=numeral(fiyat).value();
    let miktar=$('#urun-'+id+'-'+sira+' input[name="miktar"]').val();
    miktar=numeral(miktar).value(); 
    let kdv=$('#urun-'+id+'-'+sira+' input[name="kdv"]').val(); 
    kdv=numeral(kdv).value(); 
    let kdvdurum=$('#urun-'+id+'-'+sira+' input[name="kdvdurum"]');
    if (kdvdurum.is(':checked')) {
      BASKET[sira]['KDVDurum']=1;
    } else {
      BASKET[sira]['KDVDurum']=0;
    }

    //kdvdurum=numeral(kdvdurum).value();

    BASKET[sira]['KDV']=kdv;
    
    let toplam=fiyat*miktar;
   
    toplam = kdvHesapla(toplam,BASKET[sira]['KDV'],parseFloat(BASKET[sira]['KDVDurum']),1)
    $('.toplam-'+id+'-'+sira).html(mony(toplam)); 
    
    BASKET[sira]['Fiyat']=fiyat;
    BASKET[sira]['Miktar']=miktar;
    BASKET[sira]['Toplam']=toplam;
    

    SepetToplam();
  }
  //console.log(kdvHesapla(25, 2.5, 1, 1))
  function kdvHesapla(fiyat, oran, dahilMi, eklensinMi){
    if (dahilMi === 0) { // Fiyat KDV dahil değilse     
      // Toplam fiyat hesaplanacaksa
      if(eklensinMi === 1) {
          // KDV eklenecekse
          return fiyat + fiyat * (oran / 100);
      }else if(eklensinMi === -1) {
          // KDV çıkarılacaksa
          if (oran>0){
            return fiyat * (oran / 100);
          }else{
           return 0;
          }
      }else{
        return fiyat;
      }
        
    }else if(dahilMi === 1){ // Fiyat KDV dahilse
      // Toplam fiyat hesaplanacaksa
      if(eklensinMi === 1) {
          // KDV eklenecekse
          return fiyat;
      }else if(eklensinMi === -1) {
        // KDV çıkarılacaksa          
        let kdv = fiyat / (1+ (oran / 100));      
        return fiyat - kdv;
      }        
    }
  }
  //fiyat istenilen şekle koy
  function mony(deger,Currency=null) {
    deger=numeral(deger).format('0,0.00');
    if(Currency!=null){
      if (CurrencyView==1){
        deger=deger+" "+Currency;
      }else{
        deger=Currency+""+deger;
      }
    }
    return deger;      
  }
  function SepetToplam() {
    NetToplam=0;
    GenelToplam=0;
    ToplamKDV=0;
    for(var i=0; i<BASKET.length; i++) {
       let urun= BASKET[i];
       let KDV22=0;
       if(parseFloat(urun.KDV)>0){ KDV22=parseFloat(urun.KDV); }
     
      ToplamKDV+=kdvHesapla(parseFloat(urun.Fiyat)*urun.Miktar,KDV22,parseFloat(urun.KDVDurum),-1);
      //NetToplam+=parseFloat(urun.Fiyat)*urun.Miktar;
      NetToplam+=parseFloat(urun.Toplam)-parseFloat(kdvHesapla(parseFloat(urun.Fiyat)*urun.Miktar,KDV22,parseFloat(urun.KDVDurum),-1));
      GenelToplam+=parseFloat(urun.Toplam);
    }
    console.log("NetToplam "+NetToplam)
    console.log("ToplamKDV "+ToplamKDV)
    console.log("GenelToplam "+GenelToplam)
    $('.net-toplam-js').html(mony(NetToplam,DefaultCurrency));
    if (ToplamKDV>1){
      $('.toplamkdv_box').show();
      $('.kdv-toplam-js').html(mony(ToplamKDV,DefaultCurrency));
    }else{
      $('.toplamkdv_box').hide();
    }
    
    $('.genel-toplam-js').html(mony(GenelToplam,DefaultCurrency));
  }