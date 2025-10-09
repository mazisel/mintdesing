<?php 
#URL Algıla
	$Sef=null;
	if(isset($_GET['url'])){
		$Url=$_GET['url'];
		$Url=rtrim($Url,"/");//sondaki / sil
		if(strstr($Url, "?")) {
			$Url=explode("?", $Url);
			if(strstr($Url[0], "/")){$Sef=explode("/", $Url); }else{$Sef[0]=$Url;}
		}else{
			if(strstr($Url, "/")){$Sef=explode("/", $Url); }else{$Sef[0]=$Url;}
		}
	}
#URL Algıla END