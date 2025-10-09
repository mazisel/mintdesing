<style>
  .modal_close{position: absolute; width: 33px; height: 33px; display: flex; justify-content: center; align-items: center; 
    right: -10px; top: -10px; border-radius: 5px; background-color: #ffffff; box-shadow: 1px 0px 5px 2px #4b4b4b; color: #000; z-index: 1055; }
  .modal-iframe{width: 100%;height: 100%;border-radius: 5px;}
</style>
<!-- Iframe MODAL -->
<div class="modal fade" id="iframeModal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered iframeModal">
    <div class="modal-content modal-content-iframe">
      <a href="javascript:;" class="modal_close" data-bs-dismiss="modal" aria-label="Close"> <i class="fa-solid fa-xmark"></i></a> 
      <iframe src="about:blank" frameborder="0" allowpaymentrequest="true" onmousewheel="" class="modal-iframe"></iframe>     
    </div>
  </div>
</div>