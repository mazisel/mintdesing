<?php 

header("content-type: application/xml");
$site= $_SERVER["HTTP_HOST"];

$time = new DateTime;
$date=$time->format(DateTime::ATOM);
?>
	<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<url>
    <loc><?=SITE_URL?><?=$W_URLHome?></loc>
    <changefreq>daily</changefreq>
    <lastmod><?=$date?></lastmod>
    <priority>1</priority>
</url>
<url>
    <loc><?=SITE_URL?><?=$W_URLContact?></loc>
    <lastmod><?=$date?></lastmod>
    <priority>0.90</priority>
</url>
<url>
    <loc><?=SITE_URL?><?=$W_URLShop?></loc>
    <lastmod><?=$date?></lastmod>
    <priority>0.90</priority>
</url>
<url>
    <loc><?=SITE_URL?><?=$W_URLAboutus?></loc>
    <lastmod><?=$date?></lastmod>
    <priority>0.90</priority>
</url>
<url>
    <loc><?=SITE_URL?><?=$W_URLGallery?></loc>
    <lastmod><?=$date?></lastmod>
    <priority>0.90</priority>
</url>



<?php
    $sql=$DNCrud->ReadData("page",["sql"=>"WHERE Durum=1"]); $Say=0;
    while($row=$sql->fetch(PDO::FETCH_ASSOC)){ $Say++;
       $sql1=$DNCrud->ReadAData("page_lang","PageID",$row['PageID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("page_lang","PageID",$row['PageID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("page_lang","PageID",$row['PageID']);
          }
        }
        $page_cek=$sql1->fetch(PDO::FETCH_ASSOC); 

?>  
<url>
    <loc><?=SITE_URL.'page/'.seo($page_cek['PageBaslik']).'/'.$page_cek['PageKodu']?></loc>
    <lastmod><?=$date?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
</url>
<?php } ?>


<?php 

$Hizmetler=[];
  $where=$DNCrud->ReadData("hizmetler",["sql"=>"WHERE Status=1 ORDER BY Sira ASC"]);
  while($row=$where->fetch(PDO::FETCH_ASSOC)){ 
       $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
          $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("hizmetler_lang","HizmetID",$row['HizmetID']);
          }
        }
        if($sql1->rowCount()) {
          $row1=$sql1->fetch(PDO::FETCH_ASSOC); 
          $row+=$row1;
    }
    if($row['Images']){
      $Resimlinki=BASE_URL.SitePath."images/hizmetler/".$row['Images'];
    }else{
      $Resimlinki=BASE_URL.SitePath."images/noimage.png";
    }
    $Url=SITE_URL.$W_URLHizmetler."/".seo($row1['Baslik']).'/'.$row['Code'];
    $row+=["Resimlinki"=>$Resimlinki,"Url"=>$Url];   

    $Hizmetler[]=$row;
  }  
  
?>
 <?php foreach ($Hizmetler as $key => $value) {?> 
<url>
    <loc><?=$Hizmetler[$key]['Url']?></loc>
    <lastmod><?=$date?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
</url>
<?php } ?>


<?php 
$Blogs=[];
    $sql=$DNCrud->ReadData("blog",["sql"=>"WHERE Durum=1 ORDER BY Tarih DESC"]); 
    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
        $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
        if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("blog_lang","BlogID",$row['BlogID']);
            }
        }
        $blog_row=$sql1->fetch(PDO::FETCH_ASSOC); 
        if($row['Resim']) {
            $Resimlinki=BASE_URL.SitePath."images/blog/".$row['Resim'];
        }else{
            $Resimlinki=BASE_URL.SitePath."images/noimage.png";
        }
        $row+=$blog_row;
        $BlogUrl=SITE_URL.$W_URLBlog."/".seo($blog_row['Baslik']).'/'.$row['BlogKodu'];
        $row+=["Resimlinki"=>$Resimlinki,"BlogUrl"=>$BlogUrl];
        $Blogs[]=$row;
    }
 ?>
 <?php foreach ($Blogs as $key => $value) {?> 
<url>
    <loc><?=$Blogs[$key]['BlogUrl']?></loc>
    <lastmod><?=$date?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
</url>
<?php } ?>

<?php 
    #Ürün Listele ====== {      
        $urun_sorgu=" WHERE Durum=1";
        $Urunler=[];
        if(!isset($_GET['search'])) {$where=$DNCrud->ReadData("products",["sql"=>$urun_sorgu]);         }                       
        while($row=$where->fetch(PDO::FETCH_ASSOC)){  $say++;

         $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID'],["ikincikosul"=>"AND LangID=".$AktifLangID]); 
          if(!$sql1->rowCount()) {
            $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID'],["ikincikosul"=>"AND LangID=".$DefaultLangID]);
            if(!$sql1->rowCount()) {
              $sql1=$DNCrud->ReadAData("products_lang","ProductID",$row['ProductID']);
            }
          }
          $row1=$sql1->fetch(PDO::FETCH_ASSOC);                                  
                                         
          $UrunLinki=SITE_URL.$W_URLShop."/d/".seo($row1['Name'])."-".$row['ProductID'];

          $UrunKodlari=json_decode($row['UrunKodlari']);
          $UrunKodlari = (array) $UrunKodlari;
          if (is_array($UrunKodlari)) {$UrunKodlariSay=Count($UrunKodlari); }else{$UrunKodlariSay=0; }

          $row['UrunKodlariSay']=$UrunKodlariSay;
          $row['UrunKodlari']=$UrunKodlari;
          
          $row+=["UrunLinki"=>$UrunLinki];
          $row+=$row1;
          $Urunler[]=$row;
        } 
    #Ürün Listele ====== }
?>

<?php foreach ($Urunler as $key => $value) {?>
<url>
    <loc><?=$Urunler[$key]['UrunLinki']?></loc>
    <lastmod><?=$date?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.90</priority>
</url>

<?php } ?>
</urlset>