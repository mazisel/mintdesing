<?php 
#Dizi içerisinde deki value bulma in_array($arama_degeri, $dizi)
/*function ArraySearchVal($array,$value) {
    foreach ($array as $key => $val) {                  
        if($val == $value){return $key; }
    }
}  
*/

function ArryaSearch($array, $key, $value)
{
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, ArryaSearch($subarray, $key, $value));
        }
    }
    return $results;
}


/*
Bilgi: Çok boyutlu dizilerde sıralama işlemi yapmak array_sort_by_column fonksiyonu buna yardımcı oluyor. once sıralama yapacağımız dizideki keyi veriyoruz fonksyonumuza. daha sonra ilk foreachmiz yeni sort_col adında dizi oluşturuyor keyleri aynı oalcka şekilde  daha sonra array_multisort fonksiyonuyla ana dizimizi sıracalayacağımız keylerine göre sılarılyıro tabi burada buyük küçük harf sııontısı doğdu onuda SORT_NATURAL | SORT_FLAG_CASE ile yoksay dedik.
*/
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }                            
    //sort($sort_col,SORT_NATURAL | SORT_FLAG_CASE);
    //sort($arr,SORT_NATURAL | SORT_FLAG_CASE);                     
    array_multisort($sort_col, $dir, SORT_NATURAL | SORT_FLAG_CASE, $arr);
}


function ArryaSearchIndis($array, $key, $value)
{
    $indis=false;
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $indis=array_keys($array[$key]);
        }
        foreach ($array as $key1 => $val) {
             foreach ($val as $key2 => $value2) {
               if ($val[$key2] === $value) { $indis=$key1; }
             }
        }
    }
    return $indis;
}
#Dizi içerisinde deki aranın idsini bulma
function ArraySearchForId($id, $array) {
  foreach ($array as $key => $val) {
        if (is_array($val)) {
            for ($i=0; $i < count($val); $i++) { 
              if ($val[$i] == $id) {return $key; }
            }   
        }else{
           return null; 
        }      
    }
}  

//Detaylı Arama
function ArryaSearch2($array, $key, $value)
{
  $results = array();
  search_r($array, $key, $value, $results);
  return $results;
}
function search_r($array, $key, $value, &$results)
{
  if(!is_array($array)){return; }
  if(isset($array[$key]) && $array[$key] == $value){$results[] = $array; }
  foreach($array as $subarray){search_r($subarray, $key, $value, $results); }
}