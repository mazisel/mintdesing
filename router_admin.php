<?php

	if(isset($Sef[2])){
		$Page=$Sef[2]; 
	}else{
		$Page="home"; 
	}


	include AdminPath.'app/admin_standart.php';
	if(isset($_SESSION['Admins']) || isset($_COOKIE['AdminLogin'])){
	include AdminPath.'app/admin_setting.php';
	}
	switch ($Page) {
	  case "lag_indir":       		include AdminPath.'laglar/islem.php';die(); break;	   
	  case "lag_sil":       		include AdminPath.'laglar/islem.php';die(); break;
	  case "krintilari_sil":    	include 'config/krintilari_sil.php';die(); break;   
	  case "froala_upload_image":   include 'config/froala_upload_image.php';die(); break;   
	  case "froala_delete_image":   include 'config/froala_delete_image.php';die(); break;   
	  case "login":   		include AdminPath.'login/index.php';die(); break;  
	}

	if ($KulaniciSay>0) {
		if(is_file( AdminPath . $Page . '.php' ) ){
			include AdminPath . $Page . '.php';die();
		}elseif(is_file( AdminPath."sabit_sayfalar/" . $Page . '.php' ) ){
			include AdminPath."sabit_sayfalar/". $Page . '.php';die();
		}elseif(is_file( AdminPath."ilan/" . $Page . '.php' ) ){
			include AdminPath."ilan/". $Page . '.php';die();
		}elseif(is_file( AdminPath."form_islem/" . $Page . '.php' ) ){
			include AdminPath."form_islem/". $Page . '.php';die();
		}else{
			include AdminPath."sabit_sayfalar/".'404.php';die();
		}
	}else{
		include AdminPath.'login/index.php';die();
	}