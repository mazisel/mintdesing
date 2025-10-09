<?php
$Lifetime = 720000;
$separator = (strstr(strtoupper(substr(PHP_OS, 0, 3)), "WIN")) ? "\\" : "/";
$DirectoryPath = dirname(__FILE__) . "{$separator}SessionData";
if(!file_exists($DirectoryPath)) {$olustur = mkdir($DirectoryPath); }
//in Wamp for Windows the result for $DirectoryPath
//would be C:\wamp\www\your_site\SessionData
is_dir($DirectoryPath) or mkdir($DirectoryPath, 0777);
if (ini_get("session.use_trans_sid") == true) {
    ini_set("url_rewriter.tags", "");
    ini_set("session.use_trans_sid", false);
}

/**
* @author DEVNANOTEK
* @copyright 2020
* 16.06.2021
* V5.3
*/

class DNCrud
{
#Class DnCrud ====================================================================================================== { 
	Public $FileNameEk;
	private $db;
	private $DBHOST=DBHOST;
	private $DBNAME=DBNAME;
	private $DBCHARSET=DBCHARSET;
	private $DBUSER=DBUSER;
	private $DBPSWRD=DBPSWRD;	
	
	function __construct(){
		try {
			$this->db=new PDO('mysql:host='.$this->DBHOST.';dbname='.$this->DBNAME.';charset='.$this->DBCHARSET,$this->DBUSER,$this->DBPSWRD);
			/*$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$db->exec("SET NAMES ".$charset);*/
		} catch(PDOException $e){
			echo "<b>Veritabanı Bağlantısı Hatalı!</b> <br> <b>Hata Kodu: </b>";
		    echo $e->getMessage();
		    die();
		}
	}

	public function Logins($table,$colomns,$values,$RememberMe){	
			$Where=$this->db->prepare("SELECT * FROM $table WHERE $colomns[0]=? AND $colomns[1]=? AND $colomns[2]=?");
			if (isset($_COOKIE['Logins'])) {
				$Login=json_decode($_COOKIE['Logins']);
				$Where->execute([$values[0],md5(openssl_decrypt($Login->KullaniciParolla, "AES-128-ECB", "Sifreyi_coz")),$values[2]]);
			}else{
				$Where->execute([$values[0],md5($values[1]),$values[2]]);
			}
			if(!$Where->rowCount())
			{
				$Where=$this->db->prepare("SELECT * FROM $table WHERE $colomns[0]=? AND $colomns[1]=? AND $colomns[2]=?");	
				$Where->execute([$values[0],md5($values[1]),$values[2]]);	
				if($Where->rowCount()) {setcookie("Logins",json_encode($cookie),strtotime("-45 day"),"/");}
			}

			$Where_row=$Where->fetch(PDO::FETCH_ASSOC);		
			if($Where->rowCount())
			{
			    $SonGiris=date('d.m.Y H:i');
				$sql= "UPDATE $table SET SonGiris=? WHERE KullaniciID=?";
			    $this->db->prepare($sql)->execute(array($SonGiris,$Where_row['KullaniciID']));
				if($Where_row['Durum']==1){

					$_SESSION[$colomns[3]] =[
										 "KullaniciID"=>$Where_row['KullaniciID'],
										 "$colomns[0]"=>$values[0],
										 "$colomns[1]"=>$values[1],
										 "$colomns[2]"=>$values[2]
										];	
					if (!empty($RememberMe) AND empty($_COOKIE['Logins'])){
							$cookie= [
								"KullaniciID"=>$Where_row['KullaniciID'],
								"$colomns[0]"=>$values[0],
								"$colomns[1]"=>openssl_encrypt($values[1], "AES-128-ECB", "Sifreyi_coz"),
								"$colomns[2]"=>$values[2]
							];
							setcookie("Logins",json_encode($cookie),strtotime("+45 day"),"/");
					}else if(empty($RememberMe)){
						@setcookie("Logins",json_encode($cookie),strtotime("-45 day"),"/");
					}						
					return ["status" => "TRUE"];
				}else{	return ["status" => "pasif"];	}			
			}else{	return ["status" => "no"]; }
	}
	public function AdminsLogin($AdminNick,$AdminParolla,$RememberMe){
			$Where=$this->db->prepare("SELECT * FROM admins WHERE AdminNick=? and AdminParolla=?");
			if (isset($_COOKIE['AdminLogin'])) {
				$Where->execute(array($AdminNick,md5(openssl_decrypt($AdminParolla, "AES-128-ECB", "Sifreyi_coz"))));
			}else{
				$Where->execute(array($AdminNick,md5($AdminParolla)));
			}

			if(!$Where->rowCount())
			{
				$Where=$this->db->prepare("SELECT * FROM admins WHERE AdminNick=? and AdminParolla=?");	
				$Where->execute(array($AdminNick,md5($AdminParolla)));	
				if($Where->rowCount()) {setcookie("AdminLogin",json_encode($cookie),strtotime("-45 day"),"/");}
			}
			
			$Where_row=$Where->fetch(PDO::FETCH_ASSOC);		
			if($Where->rowCount())
			{
			    $SonGiris=date('d.m.Y H:i');
				$sql= "UPDATE admins SET SonGiris=? WHERE AdminID=?";
			    $this->db->prepare($sql)->execute(array($SonGiris,$Where_row['AdminID']));
				if($Where_row['AdminDurum']==1){

					$_SESSION["Admins"] =[
										 "AdminID"=>$Where_row['AdminID'],
										 "AdminNick"=>$AdminNick
										];	
					if (!empty($RememberMe) AND empty($_COOKIE['AdminLogin'])){
							$Admin= [
								"AdminID"=>$Where_row['AdminID'],
								"AdminNick"=>$AdminNick,
								"AdminParolla"=>openssl_encrypt($AdminParolla, "AES-128-ECB", "Sifreyi_coz")
							];
							setcookie("AdminLogin",json_encode($Admin),strtotime("+45 day"),"/");
					}else if(empty($RememberMe)){
						setcookie("AdminLogin",json_encode($Admin),strtotime("-45 day"),"/");
					}						
					return ["status" => "TRUE"];
				}else{	return ["status" => "pasif"];	}			
			}else{	return ["status" => "no"]; }
	}
	public function AdminLogOut(){
		$_SESSION['Admins'] = NULL;
		unset($_SESSION['Admins']);
		unset($_COOKIE['AdminLogin']); 
    	setcookie('AdminLogin', null, -1, '/');
	}
	public function LogOut($veriable1,$veriable2=""){
		$_SESSION[$veriable1] = NULL;
		unset($_SESSION[$veriable1]);
		if(!empty($veriable2)){
			unset($_COOKIE[$veriable2]); 
	    	setcookie($veriable2, null, -1, '/');
	    }
	}
	public function ReadData($table,$options=[],$SColumns=NULL){
		try {
			if ($SColumns==NULL) {$SColumns="*";}
			$sql1="";$sql2="";$sql="";
			if (isset($options['colomns_name'])){ $sql1="ORDER BY ".$options['colomns_name']." ".$options['colomns_sort']; }
			if (isset($options['limit'])) { $sql2="LIMIT ".$options['limit']; }
			if (isset($options['sql'])) { $sql=$options['sql']; }
			// Build final SQL for debugging
			$fullSql = "SELECT $SColumns FROM $table " . $sql . " " . $sql1 . " " . $sql2;
			// Lightweight SQL debug log (do not expose in production without caution)
			@file_put_contents(__DIR__ . '/sql_debug.log', "[".date('c')."] ReadData SQL: " . trim(preg_replace('/\s+/', ' ', $fullSql)) . "\n", FILE_APPEND);
			$Where = $this->db->prepare($fullSql);
			$Where->execute();
			return $Where;
		} catch (Exception $e) {
			// Log exception and the SQL that caused it
			@file_put_contents(__DIR__ . '/sql_debug.log', "[".date('c')."] ReadData Exception: " . $e->getMessage() . "\n", FILE_APPEND);
			return false;
		}			
	}
	public function ReadAData($table,$colomns,$values,$options=[],$SColumns=NULL){
		try {
			if ($SColumns==NULL) {$SColumns="*";}
			if ($colomns=="komutyok") {
				$Where=$this->db->prepare("SELECT $SColumns FROM $table ".@$options["ikincikosul"]);
				$Where->execute([]);
			}else{
				$Where=$this->db->prepare("SELECT $SColumns FROM $table WHERE $colomns=? ".@$options["ikincikosul"]);
				$Where->execute([$values]);
			}
			
			return $Where;
		} catch (Exception $e) {
			return ['status' => FALSE , 'error' => $e->getMessage()];
		}			
	}
	public function AddValue($Arraydegistir){
		$values=implode(',', array_map(function($item){
			return $item.'=?';
		},array_keys($Arraydegistir)));
		return $values;
	}
	public function dosya_adi_degistir($isimm,$dosya){
        $Harf=array("A","B","C","D","F","E","G","M","N");                
        $rsm_adi_dizi=explode(".",$dosya);      
        $uzanti=".".end($rsm_adi_dizi);
        $sayi_tut=rand(1,10000);
        $sayi_tut2=rand(1,10000);
        $sayi_tut3=rand(10,10000);
        if($isimm=='no_name'){
        	//Kendi ismi kalsın
        	$dosya2=str_replace($uzanti, "", $dosya);
            $yeni_adi=seo($dosya2).$uzanti;
        }elseif($isimm=='degistir'){
        	//Sayı yap
        	if($this->FileNameEk){$ekisim=$this->FileNameEk."-";}else{$ekisim="";}
            $yeni_adi=$ekisim.$sayi_tut3.$Harf[rand(0,4)].$sayi_tut2.$Harf[rand(0,4)].$sayi_tut.$uzanti;
        }else{
        	//Gelen ismi kullan
        	$yeni_adi=seo($isimm).'_'.$Harf[rand(0,4)].$sayi_tut2.$uzanti;
        }
        return $yeni_adi;                
    }
    public function ext($file)
	{
	    $ext = pathinfo($file);
	    return $ext['extension'];
	}
    public function FileUpload($name,$size,$tmp_name,$dir,$izinli_uzantilar,$nasil_yuklensin,$fitToWidth,$fitToWidthBuyuk=Null,$SizeLimit=Null,$Addegistir=Null){
    		if ($SizeLimit==Null) {$SizeLimit=5; }
    		
			//$ext=strtolower(substr($name, strpos($name, ".")+1));
			$ext=$this->ext($name);

			if(in_array($ext, $izinli_uzantilar)===false){
				return ['status' => FALSE , 'neden' => "uzanti_yasak" ,'error' => "izinli uzantılar değil"];					
			}

			if ($size>(1024*1024*$SizeLimit)) {
				return ['status' => FALSE , 'neden' => "boyut_yuksek" , 'error' => "istenilen boyuttan daha büyük"];die();
			}
			if ($Addegistir==Null) {
				$addegis="degistir";
			}else{
				if ($Addegistir=='no_name'){
					$addegis="no_name";
				}else{
					$addegis=$Addegistir;
				}				
			}
			$FileName=$this->dosya_adi_degistir($addegis,$name);	
			$FileNameArray=explode(".",$FileName);
			if(end($FileNameArray)=="svg" OR end($FileNameArray)=="SVG"){
				if($nasil_yuklensin=="kucuk_haliile"){
					try {	        	
				    	$image2 = new \claviska\SimpleImage();
				    	$image2
					    ->fromFile($tmp_name)
					    ->autoOrient()
					    ->resize($fitToWidthBuyuk,null)
					    //->resolution($res_x, $res_y)
					    ->toFile(dirname(__DIR__)."/".$dir.$FileName);				   
					  $image = new \claviska\SimpleImage();
					  $image
					    ->fromFile($tmp_name)
					    ->autoOrient()
					    ->resize($fitToWidth,null)
					    //->resolution($res_x, $res_y)
					    ->toFile(dirname(__DIR__)."/".$dir."kucuk/$FileName");					   
					} catch(Exception $err) {
					  // Handle errors
					  return ['status' => FALSE , 'error' => $err->getMessage()];die();
					}
				}else{
					if(!@move_uploaded_file($tmp_name, dirname(__DIR__)."/".$dir.$FileName)){
						return ['status' => FALSE , 'error' => "Dosya yüklenemedi !"];die();
					}
				}
				return $FileName;
			}

			if($nasil_yuklensin=="oldugu_gibi"){
				if(!@move_uploaded_file($tmp_name, dirname(__DIR__)."/".$dir.$FileName)){
					return ['status' => FALSE , 'error' => "Dosya yüklenemedi !"];die();
				}
			}else if($nasil_yuklensin=="kucuk_haliile"){
				//copy($tmp_name,dirname(__DIR__)."/".$dir.$FileName);
            	try {
        
			    	$image2 = new \claviska\SimpleImage();
			    	$image2
				    ->fromFile($tmp_name)
				    ->autoOrient()
				    ->resize($fitToWidthBuyuk,null)
				    //->resolution($res_x, $res_y)
				    ->toFile(dirname(__DIR__)."/".$dir.$FileName);				    
			
				  $image = new \claviska\SimpleImage();
				  $image
				    ->fromFile($tmp_name)
				    ->autoOrient()
				    ->resize($fitToWidth,null)
				    //->resolution($res_x, $res_y)
				    ->toFile(dirname(__DIR__)."/".$dir."kucuk/$FileName");
				   
				} catch(Exception $err) {
				  // Handle errors
				  return ['status' => FALSE , 'error' => $err->getMessage()];die();
				}
			}else if($nasil_yuklensin=="sadeceolcu"){
				try {
				  $image = new \claviska\SimpleImage();
				  $image
				    ->fromFile($tmp_name)
				    ->autoOrient()
				    ->fitToWidth($fitToWidth)
				    ->toFile(dirname(__DIR__)."/".$dir.$FileName);
				} catch(Exception $err) {
				  // Handle errors
				  return ['status' => FALSE , 'error' => $err->getMessage()];die();
				}
			}
			return $FileName;
    }

	public function insert($table,$values,$options=[]){
		try {
			#file insert =============== {
				#Yeni Upload =================== {
					if (isset($options['UploadFile'])) {
						$UploadFile=$options['UploadFile'];
						foreach ($UploadFile as $key => $value) {				
							if (!empty($_FILES[$UploadFile[$key]['file_name']]['name'])) {
								//Klasör Oluştur =============== {
					              $klasorYol = dirname(__DIR__)."/".$UploadFile[$key]['dir'];				             
					              if(!file_exists($klasorYol)) {$olustur = mkdir($klasorYol); }
					              if ($UploadFile[$key]['nasil_yuklensin']=="kucuk_haliile") {
					              	$klasorYolKucuk = dirname(__DIR__)."/".$UploadFile[$key]['dir']."/kucuk";
					              	if(!file_exists($klasorYolKucuk)) {$olustur = mkdir($klasorYolKucuk); }
					              }
					            //Klasör Oluştur =============== }
								$FileName=$this->FileUpload(
									$_FILES[$UploadFile[$key]['file_name']]['name'],
									$_FILES[$UploadFile[$key]['file_name']]['size'],
									$_FILES[$UploadFile[$key]['file_name']]["tmp_name"],
									$UploadFile[$key]['dir'],
									$UploadFile[$key]['izinli_uzantilar'],
									$UploadFile[$key]['nasil_yuklensin'],
									$UploadFile[$key]['fitToWidth'],
									$UploadFile[$key]['fitToWidthBuyuk'],$UploadFile[$key]['SizeLimit'],$UploadFile[$key]['Addegistir']);
				                $values+=[$UploadFile[$key]['file_name']=>$FileName];
				                if(is_array($FileName) AND $FileName['status']==FALSE) {
									return ['status' => FALSE, 'error'=>$UploadFile[$key]['file_name']." Boyut yüksek".$FileName['error']];
								}
							}
						}
					}
				#Yeni Upload =================== }

				if (@!empty($_FILES[$options['file_name']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name']]['name'],
						$_FILES[$options['file_name']]['size'],
						$_FILES[$options['file_name']]["tmp_name"],
						$options['dir'],
						$options['izinli_uzantilar'],
						$options['nasil_yuklensin'],
						$options['fitToWidth'],
						$options['fitToWidthBuyuk'],$options['SizeLimit'],$options['Addegistir']);
	                $values+=[$options['file_name']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
						return ['status' => FALSE, 'error'=>$options['file_name']." Boyut yüksek".$FileName['error']];
					}
				}
				if (@!empty($_FILES[$options['file_name2']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name2']]['name'],
						$_FILES[$options['file_name2']]['size'],
						$_FILES[$options['file_name2']]["tmp_name"],
						$options['dir2'],
						$options['izinli_uzantilar2'],
						$options['nasil_yuklensin2'],
						$options['fitToWidth2'],$options['fitToWidthBuyuk2'],$options['SizeLimit2'],$options['Addegistir2']);
	                $values+=[$options['file_name2']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
						return ['status' => FALSE, 'error'=>$options['file_name2']." Boyut yüksek".$FileName['error']];
					}
				}
				if (@!empty($_FILES[$options['file_name3']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name3']]['name'],
						$_FILES[$options['file_name3']]['size'],
						$_FILES[$options['file_name3']]["tmp_name"],
						$options['dir3'],
						$options['izinli_uzantilar3'],
						$options['nasil_yuklensin3'],
						$options['fitToWidth3'],$options['fitToWidthBuyuk3'],$options['SizeLimit3'],$options['Addegistir3']);
	                $values+=[$options['file_name3']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
						return ['status' => FALSE, 'error'=>$options['file_name3']." Boyut yüksek".$FileName['error']];
					}
				}
			#file insert =============== }

			#Posttan Eleman Sil
			if(isset($options['form_name'])){	unset($values[$options['form_name']]);	}
			if(isset($options['form_name2'])){	unset($values[$options['form_name2']]);	}
			if(isset($options['form_name3'])){	unset($values[$options['form_name3']]);	}	
		
			#Md5
			if(isset($options['sifrele'])){$values[$options['sifrele']]=md5($values[$options['sifrele']]); }

			$stmt=$this->db->prepare("INSERT INTO $table SET {$this->AddValue($values)}");
			$sonuc=$stmt->execute(array_values($values));
		
			$ID=$this->db->lastInsertId();
			if ($sonuc) {
				return ['status' => TRUE, "LastID" => $ID];
			}else{
				return ['status' => FALSE ,'error'=>"Basarisz"];
			}			
		} catch (Exception $e) {
			return ['status' => FALSE , 'error' => $e->getMessage()];
		}
	}

	public function update($table,$values,$options=[]){

		$sql=$this->ReadAData($table,$options['colomns'],$values[$options['colomns']]);
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		try {
			#Yeni Upload =================== {
				if (isset($options['UploadFile'])) {
					$UploadFile=$options['UploadFile'];
					foreach ($UploadFile as $key => $value) {				
						if (!empty($_FILES[$UploadFile[$key]['file_name']]['name'])) {
							//Klasör Oluştur =============== {
				              $klasorYol = dirname(__DIR__)."/".$UploadFile[$key]['dir'];				             
				              if(!file_exists($klasorYol)) {$olustur = mkdir($klasorYol); }
				              if ($UploadFile[$key]['nasil_yuklensin']=="kucuk_haliile") {
				              	$klasorYolKucuk = dirname(__DIR__)."/".$UploadFile[$key]['dir']."/kucuk";
				              	if(!file_exists($klasorYolKucuk)) {$olustur = mkdir($klasorYolKucuk); }
				              }
				            //Klasör Oluştur =============== }
							$FileName=$this->FileUpload(
								$_FILES[$UploadFile[$key]['file_name']]['name'],
								$_FILES[$UploadFile[$key]['file_name']]['size'],
								$_FILES[$UploadFile[$key]['file_name']]["tmp_name"],
								$UploadFile[$key]['dir'],
								$UploadFile[$key]['izinli_uzantilar'],
								$UploadFile[$key]['nasil_yuklensin'],
								$UploadFile[$key]['fitToWidth'],
								$UploadFile[$key]['fitToWidthBuyuk'],$UploadFile[$key]['SizeLimit'],$UploadFile[$key]['Addegistir']);
			                $values+=[$UploadFile[$key]['file_name']=>$FileName];
			                if(is_array($FileName) AND $FileName['status']==FALSE) {
								return ['status' => FALSE, 'error'=>$UploadFile[$key]['file_name']." Boyut yüksek".$FileName['error']];
							}else{
								if($row[$UploadFile[$key]['file_name']]!=$FileName){
									if($UploadFile[$key]['nasil_yuklensin']=="oldugu_gibi" OR $UploadFile[$key]['nasil_yuklensin']=="sadeceolcu"){
				              		$this->ImageDelete($UploadFile[$key]['dir'],$row[$UploadFile[$key]['file_name']]);
									}else if($UploadFile[$key]['nasil_yuklensin']=="kucuk_haliile"){
										$this->ImageDelete($UploadFile[$key]['dir'],$row[$UploadFile[$key]['file_name']]);
										$this->ImageDelete($UploadFile[$key]['dir']."kucuk/",$row[$UploadFile[$key]['file_name']]);
									} 
								}								
							}
						}
					}
				}
			#Yeni Upload =================== }
			if (isset($options['file_name'])) {
			#file insert =============== {
				if (!empty($_FILES[$options['file_name']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name']]['name'],
						$_FILES[$options['file_name']]['size'],
						$_FILES[$options['file_name']]["tmp_name"],
						$options['dir'],
						$options['izinli_uzantilar'],
						$options['nasil_yuklensin'],
						$options['fitToWidth'],
						$options['fitToWidthBuyuk'],$options['SizeLimit'],$options['Addegistir']
					);
	                $values+=[$options['file_name']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
	                	return [
	                		'status' => FALSE,
	                		'file_name'=>$options['file_name'],
	                		'neden'=>$FileName['neden'],
	                		'error'=>$FileName['error']
	                	];
					}
	              	if($options['nasil_yuklensin']=="oldugu_gibi"){
	              		$this->ImageDelete($options['dir'],$row[$options['file_name']]);
					}else if($options['nasil_yuklensin']=="sadeceolcu"){
						$this->ImageDelete($options['dir'],$row[$options['file_name']]);
					}else if($options['nasil_yuklensin']=="kucuk_haliile"){
						$this->ImageDelete($options['dir'],$row[$options['file_name']]);
						$this->ImageDelete($options['dir']."kucuk/",$row[$options['file_name']]);
					}  
				}
			#file insert =============== }
			}
			if (isset($options['file_name2'])) {
			#file insert =============== {
				if (!empty($_FILES[$options['file_name2']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name2']]['name'],
						$_FILES[$options['file_name2']]['size'],
						$_FILES[$options['file_name2']]["tmp_name"],
						$options['dir2'],
						$options['izinli_uzantilar2'],
						$options['nasil_yuklensin2'],
						$options['fitToWidth2'],$options['fitToWidthBuyuk2'],$options['SizeLimit2'],$options['Addegistir2']);
	                $values+=[$options['file_name2']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
						return [
	                		'status' => FALSE,
	                		'file_name'=>$options['file_name2'],
	                		'neden'=>$FileName['neden'],
	                		'error'=>$FileName['error']
	                	];
					}
	              	if($options['nasil_yuklensin2']=="oldugu_gibi"){
	              		$this->ImageDelete($options['dir2'],$row[$options['file_name2']]);
					}else if($options['nasil_yuklensin2']=="sadeceolcu"){
						$this->ImageDelete($options['dir2'],$row[$options['file_name2']]);
					}else if($options['nasil_yuklensin2']=="kucuk_haliile"){
						$this->ImageDelete($options['dir2'],$row[$options['file_name2']]);
						$this->ImageDelete($options['dir2']."kucuk/",$row[$options['file_name2']]);
					}  
				}
			#file insert =============== }
			}
			if (isset($options['file_name3'])) {
			#file insert =============== {
				if (!empty($_FILES[$options['file_name3']]['name'])) {
					$FileName=$this->FileUpload(
						$_FILES[$options['file_name3']]['name'],
						$_FILES[$options['file_name3']]['size'],
						$_FILES[$options['file_name3']]["tmp_name"],
						$options['dir3'],
						$options['izinli_uzantilar3'],
						$options['nasil_yuklensin3'],
						$options['fitToWidth3'],$options['fitToWidthBuyuk3'],$options['SizeLimit3'],$options['Addegistir3']);
	                $values+=[$options['file_name3']=>$FileName];
	                if(is_array($FileName) AND $FileName['status']==FALSE) {
						return [
	                		'status' => FALSE,
	                		'file_name'=>$options['file_name2'],
	                		'neden'=>$FileName['neden'],
	                		'error'=>$FileName['error']
	                	];
					}
	              	if($options['nasil_yuklensin3']=="oldugu_gibi"){
	              		$this->ImageDelete($options['dir3'],$row[$options['file_name3']]);
					}else if($options['nasil_yuklensin3']=="sadeceolcu"){
						$this->ImageDelete($options['dir3'],$row[$options['file_name3']]);
					}else if($options['nasil_yuklensin3']=="kucuk_haliile"){
						$this->ImageDelete($options['dir3'],$row[$options['file_name3']]);
						$this->ImageDelete($options['dir3']."kucuk/",$row[$options['file_name3']]);
					}  
				}
			#file insert =============== }
			}
			
			$colomnsID=$values[$options['colomns']];
			if(isset($options['colomns2'])){ $colomnsID2=$values[$options['colomns2']]; }
			#Posttan Eleman Sil
			if(isset($options['form_name'])){	unset($values[$options['form_name']]);	}
			if(isset($options['form_name2'])){	unset($values[$options['form_name2']]);	}
			if(isset($options['form_name3'])){	unset($values[$options['form_name3']]);	}
			if(isset($options['colomns'])){ 	unset($values[$options['colomns']]);	}
			if(isset($options['colomns2'])){ 	unset($values[$options['colomns2']]);	}
			$executevalues=$values;	
			$executevalues+=[$options['colomns']=>$colomnsID];
			#Md5
			if(isset($options['sifrele'])){$executevalues[$options['sifrele']]=md5($executevalues[$options['sifrele']]); }
			
			#Colomns2
			$sql="";
			if(isset($options['colomns2'])){ $sql="AND {$options['colomns2']}=?";$executevalues+=[$options['colomns2']=>$colomnsID2]; }
			$stmt=$this->db->prepare("UPDATE $table SET {$this->AddValue($values)} WHERE {$options['colomns']}=? ".$sql);
			$stmt->execute(array_values($executevalues));
			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => FALSE , 'error' => $e->getMessage()];
		}
	}

	public function delete($table,$values,$options=[]){		
		try {	
			$sql=$this->ReadAData($table,$options['colomns'],$values);
			if ($sql->rowCount()) {				
				$row=$sql->fetch(PDO::FETCH_ASSOC);		
				$stmt=$this->db->prepare("DELETE FROM $table WHERE {$options['colomns']}=?");
				$stmt->execute([$values]);	

				#Yeni File Delete =================== {
					if (isset($options['DeleteFile'])) {
						$DeleteFile=$options['DeleteFile'];
						foreach ($DeleteFile as $key => $value) {	
							$this->ImageDelete($DeleteFile[$key]['dir'],$row[$DeleteFile[$key]['file_name']]);
							$this->ImageDelete($DeleteFile[$key]['dir']."kucuk/",$row[$DeleteFile[$key]['file_name']]);							
						}
					}
				#Yeni File Delete =================== }

				if(isset($options['file_name'])){
					$this->ImageDelete($options['dir'],$row[$options['file_name']]);
					$this->ImageDelete($options['dir']."kucuk/",$row[$options['file_name']]);
				}
				if(isset($options['file_name2'])){
					$this->ImageDelete($options['dir2'],$row[$options['file_name2']]);
					$this->ImageDelete($options['dir2']."kucuk/",$row[$options['file_name2']]);
				}
				if(isset($options['file_name3'])){
					$this->ImageDelete($options['dir3'],$row[$options['file_name3']]);
					$this->ImageDelete($options['dir3']."kucuk/",$row[$options['file_name3']]);
				}
				if(isset($options['file_name4'])){
					$this->ImageDelete($options['dir4'],$row[$options['file_name4']]);
					$this->ImageDelete($options['dir4']."kucuk/",$row[$options['file_name4']]);
				}
				if(isset($options['file_name5'])){
					$this->ImageDelete($options['dir5'],$row[$options['file_name5']]);
					$this->ImageDelete($options['dir5']."kucuk/",$row[$options['file_name5']]);
				}
			}
			return ['status' => TRUE];	
		} catch (Exception $e) {
			return ['status' => FALSE , 'error' => $e->getMessage()];
		}
	}

	public function ImageDelete($yol,$DosyaAdi){
		$DosyaYol=dirname(__DIR__)."/".$yol.$DosyaAdi;		
		@unlink($DosyaYol);
	}	

	public function qSql($sql,$sql_karsiti=Null,$options=[]){
		if ($sql_karsiti==Null) {
			$sql_karsiti=[];
		}else{
			$sql_karsiti=[$sql_karsiti];
		}
		try {
			$stmt=$this->db->prepare($sql);
			$stmt->execute($sql_karsiti);
			return $stmt;		
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];		
		}
	}

	public function orderUpdate($table,$values,$columns,$orderId) {  
		try {
			foreach ($values as $key => $value) {  
				$stmt = $this->db->prepare("UPDATE $table SET $columns=? WHERE $orderId=?");
				$stmt->execute([$key,$value]);    
			} 
			return ['status' => TRUE]; 
		} catch(PDOException $e) {    
			echo $e->getMessage();
			return ['status' => FALSE,'error'=> $e->getMessage()]; 
		}
	}
	
#Class DnCrud ====================================================================================================== }
}