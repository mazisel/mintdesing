<?php 
			function replaceSpace1($string)
			{
				$string = preg_replace("/\s+/", " ", $string);
				$string = trim($string);
				return $string;
			}

			/*$olusandizi="";$Hazir="";
			$sabit_degiskenler= str_replace("={{","=",$DilStuns['SiteDegiskenleri']);
			$sabit_degiskenler= str_replace("}}","",$sabit_degiskenler);
			$dizi = explode(PHP_EOL, $sabit_degiskenler);
			foreach ($dizi as $key){ 			
				if(replaceSpace1($key)){
					$Hazir=explode("=",$key);	
					${$Hazir[0]}=replaceSpace1(rtrim("$Hazir[1]"));
				}else{ } 
			}*/
			$SiteDegiskenleri = unserialize($DilStuns['SiteDegiskenleri']); 
			foreach ($SiteDegiskenleri as $key => $deger){ 
				${$key}=replaceSpace1(rtrim($deger));
			}

			/*$olusandizi="";$Hazir="";
			$sabit_degiskenler= str_replace("={{","=",$DilStuns['AdminDegiskenleri']);
			$sabit_degiskenler= str_replace("}}","",$sabit_degiskenler);
			$dizi = explode(PHP_EOL, $sabit_degiskenler);
			foreach ($dizi as $key){ 			
				if(replaceSpace1($key)){
					$Hazir=explode("=",$key);	
					${$Hazir[0]}=rtrim("$Hazir[1]");
				}else{ } 
			}*/
			$AdminDegiskenleri = unserialize($DilStuns['AdminDegiskenleri']);
			foreach ($AdminDegiskenleri as $key => $deger){ 
				${$key}=replaceSpace1(rtrim($deger));
			}