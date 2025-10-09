/* BOOTSTRAP TOOLTIP */
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
/* OFFLINE WARNING */
const offlineuyari = document.getElementById('offline_uyari')
window.addEventListener('online', ()=>{offlineuyari.style.display='none'})
window.addEventListener('offline', ()=>{offlineuyari.style.display='block'})
/* YUKARI CIK BUTTONU */
$(document).ready(function(){
  $(window).scroll(function(){
        // scroll-up button show/hide script
    if(this.scrollY > 400){$('.scroll_up_btn_nnt').addClass("scroll_up_btn_nnt_show");
  }else{$('.scroll_up_btn_nnt').removeClass("scroll_up_btn_nnt_show"); }
});
    // slide-up script
  $('.scroll_up_btn_nnt').click(function(){
    $('html').animate({scrollTop: 0});
        // removing smooth scroll on slide-up button click
    $('html').css("scrollBehavior", "auto");
  });
});



/* SIDEBAR JS */
$(document).ready(function () {
    $('.ham').click(function () {
        $('body').toggleClass('body_no_scroll');
        $('.ham').toggleClass('active');
        $('.hidden_menu_overly').toggleClass('active');
        $('.hidden_menu_body').toggleClass('active');
    });
    $('.hidden_menu_overly').click(function () {
        $('body').removeClass('body_no_scroll');
        $('.ham').removeClass('active');
        $('.hidden_menu_overly').removeClass('active');
        $('.hidden_menu_body').removeClass('active');
    });
});


