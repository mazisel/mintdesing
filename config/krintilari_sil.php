<?php
date_default_timezone_set('Europe/Istanbul');
/**
 * @author Nanotek Bilişim
 * @copyright 2018
 */


function searchAllDB($search){
    global $db;
    $out = "";
    $total = 0;
    $sql = "SHOW TABLES";
    $rs = $db->query($sql);
    if($rs->rowCount() > 0){
        while($r = $rs->fetch(PDO::FETCH_NUM)){
            $table = $r[0];
            $sql_search = "select * from ".$table." where ";
            $sql_search_fields = Array();
            $sql2 = "SHOW COLUMNS FROM ".$table;
            $rs2 = $db->query($sql2);
            if($rs2->rowCount() > 0){
                while($r2 = $rs2->fetch(PDO::FETCH_NUM)){
                    $colum = $r2[0];
                    $sql_search_fields[] = $colum." like('%".$search."%')";
                    if(strpos($colum,$search))
                    {
                        echo "FIELD NAME: ".$colum."\n";
                    }
                }
                //$rs2->close();
            }
            $sql_search .= implode(" OR ", $sql_search_fields);
            $rs3 = $db->query($sql_search);
            if($rs3 && $rs3->rowCount() > 0)
            {
                //$out .= $table.": ".$rs3->rowCount()."\n"; #tablonun adı ve kaç satır bulundu yazar
                $out .= $rs3->rowCount();
                if($rs3->rowCount() > 0){
                    $total += $rs3->rowCount();
                    //$out.= print_r($rs3->fetch(PDO::FETCH_NUM),1); #gelen row içeriği
                    //$rs3->close();
                }
            }
        }
        //$out .= "\n\nTotal results:".$total;
        //$rs->close();
    }
    return $out;
} 


$silinen=0;
$dosyalar = scandir(dirname(__DIR__)."/".SitePath."nbimages/resimler");//resimler klasörün içini listele				
foreach ($dosyalar as $dosya) {	
	if($dosya!="delete_image.php" && $dosya!="upload_image.php"){
		$sonuc=searchAllDB($dosya);
		if(!$sonuc){
			unlink(dirname(__DIR__)."/".SitePath."nbimages/resimler/".$dosya);
			$silinen++;
		}
	}								
}

$array=array("sonuc" => 'basarili',
			 "Silinen" =>$silinen ); 
echo $json=json_encode($array);die();


?>