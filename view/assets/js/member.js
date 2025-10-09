//kayıt ol script  ========================== {
    $("body").on("submit",".kayitol",function(e){
        e.preventDefault(); 
        var recapvarmi=$('.grecaptcha').val();
        var form = $(this);
        var url = form.attr('action');
        var maill=$('#signup-email').val();
  
        $('.form_loader').css('display', 'flex'); 
        var form = $(this);
        var url = form.attr('action');
          $.ajax({
           type: "POST",
           url: url,
           data: form.serialize()
          }).done (function(cevapp){ 
            console.log(cevapp);
            $('.form_loader').css('display', 'none');
            var obj = JSON.parse(cevapp);
            if (obj.sonuc=="success")
            {       
              
              $('.mail-js').val(maill);


              //document.getElementById("kayit_ol_frm").reset();
              //$('html, body').animate({scrollTop: '0px'},1000);
              
                                       
              /*$('.register-modal').removeClass("modal-800");
              $('.register-modal').addClass("modal-400");  
              $('.tab-pane').removeClass("active");
              $('#login').addClass("active");*/                    
              swal({title: obj.title, icon: "success",button:obj.btn}).then(function(){                
                window.location.href = obj.url;
              }); 
            }
            if (obj.sonuc=="error")
            {         
              swal({title: obj.title,text:obj.subtitle, icon: "warning",button:obj.btn});
            }
            if(recapvarmi==1){
               grecaptcha.ready(function() {
                grecaptcha.execute(reCAPTCHASiteKey, {action: 'submit'}).then(function(token) {
                  let gelentoken=document.getElementById("recaptcha-cevap");                  
                  gelentoken.value=token;
                });
              });
            }  
        }).fail(function() {   console.log( "error" );     }).always(function() {});        
    });
//kayıt ol script  ========================== }

//Giriş Yap ===================================== {
    $('#giris_yap_frm').on("submit", function (e) {    
      e.preventDefault(); 
      $('.form_loader').css('display', 'flex'); 
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
           type: "POST",
           url: url,
           data: form.serialize()
          }).done (function(cevapp){ 
            console.log(cevapp);
            $('.form_loader').css('display', 'none');
            var obj = JSON.parse(cevapp);
            if (obj.sonuc=="success")
            {  
              swal({title: obj.title, icon: obj.icon ,button:obj.btn}); 
              window.location = obj.url;   
            }
            if (obj.sonuc=="error")
            {         
              swal({title: obj.title,text:obj.subtitle, icon: obj.icon ,button:obj.btn});
            }     
        }).fail(function() {   console.log( "error" );     }).always(function() {});
    }); 
//Giriş Yap ===================================== }

//Şifremi Unuttum ======================================================= {
  $('#sifre_al_form').on("submit", function (e) {
      e.preventDefault();      
      $('.form_loader').css('display', 'flex'); 
      var form = $(this);
      var url = form.attr('action');
      $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(),
        }).done (function(giriscevap){ 
          $('.form_loader').css('display', 'none'); 
          console.log(giriscevap);    
          var obj = JSON.parse(giriscevap);
          document.getElementById("sifre_al_form").reset();
                
          swal({title: obj.title,text:obj.subtitle, icon: obj.icon,button:obj.btn});
                  
        }).fail(function() {}).always(function() {});
  });
//Şifremi Unuttum ======================================================= }



//GIRIS KAYIT OL =============================================== {
  jQuery(document).ready(function($){
          var $form_modal = $('.user-modal'),
          $form_login = $form_modal.find('#login'),
          $form_signup = $form_modal.find('#signup'),
          $form_forgot_password = $form_modal.find('#reset-password'),
          $form_modal_tab = $('.switcher'),
          $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
          $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
          $forgot_password_link = $form_login.find('.form-bottom-message a'),
          $back_to_login_link = $form_forgot_password.find('.form-bottom-message a'),
          $main_nav = $('.main-nav');

    //open modal
    $main_nav.on('click', function(event){

      if( $(event.target).is($main_nav) ) {
        // on mobile open the submenu
        $(this).children('ul').toggleClass('is-visible');
      } else {
        // on mobile close submenu
        $main_nav.children('ul').removeClass('is-visible');
        //show modal layer
        $form_modal.addClass('is-visible'); 
        //show the selected form
        ( $(event.target).is('.signup') ) ? signup_selected() : login_selected();
      }

    });

    //close modal
    $('.user-modal').on('click', function(event){
      if( $(event.target).is($form_modal) || $(event.target).is('.close-form') ) {
        $form_modal.removeClass('is-visible');
      } 
    });
    //close modal when clicking the esc keyboard button
    $(document).keyup(function(event){
      if(event.which=='27'){
        $form_modal.removeClass('is-visible');
      }
    });

    //switch from a tab to another
    $form_modal_tab.on('click', function(event) {
      event.preventDefault();
      ( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
    });

    //hide or show password
    $('.hide-password').on('click', function(){
      var $this= $(this),
      $password_field = $this.prev('input');
      if($password_field.attr('type')=='password'){
        $password_field.attr('type', 'text');
        $this.html('<i class="far fa-eye"></i>')
      }else{
        $password_field.attr('type', 'password');
        $this.html('<i class="fas fa-eye-slash"></i>');
      }

      /*( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
      ( 'Zeigen' == $this.text() ) ? $this.html('<i class="far fa-eye"></i>') : $this.html('<i class="fas fa-eye-slash"></i>');*/
      //focus and move cursor to the end of input field
      $password_field.putCursorAtEnd();
    });

    //show forgot-password form 
    $forgot_password_link.on('click', function(event){
      event.preventDefault();
      forgot_password_selected();
    });

    //back to login from the forgot-password form
    $back_to_login_link.on('click', function(event){
      event.preventDefault();
      login_selected();
    });

    function login_selected(){
      $form_login.addClass('is-selected');
      $form_signup.removeClass('is-selected');
      $form_forgot_password.removeClass('is-selected');
      $tab_login.addClass('selected');
      $tab_signup.removeClass('selected');
    }

    function signup_selected(){
      $form_login.removeClass('is-selected');
      $form_signup.addClass('is-selected');
      $form_forgot_password.removeClass('is-selected');
      $tab_login.removeClass('selected');
      $tab_signup.addClass('selected');
    }

    function forgot_password_selected(){
      $form_login.removeClass('is-selected');
      $form_signup.removeClass('is-selected');
      $form_forgot_password.addClass('is-selected');
    }

  });
//GIRIS KAYIT OL =============================================== }


