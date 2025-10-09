<?php
     // Get src.
    $src = $_POST["src"];   

    $url_bol=explode("/",$src);
		$url_bol_say=count($url_bol);
		$resimi_bul=$url_bol_say-1;
		$dosya_adi=$url_bol[$resimi_bul];//urdlden resimi ayırdık değişkene atdık	
    unlink(dirname(__DIR__)."/".SitePath."images/img/".$dosya_adi);  
?>