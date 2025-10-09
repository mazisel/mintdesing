<?php 

function DilGel($tableName,$WhereColumnName,$WhereColumnVal=0){
  global $DNCrud,$LangSeo,$VarsayilanDil;
  if(empty($WhereColumnName)) {
    return null;
  }
  $sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal,["ikincikosul"=>"AND Lang='{$LangSeo}'"]); 
  if(!$sql->rowCount()) {
    $sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal,["ikincikosul"=>"AND Lang='{$VarsayilanDil["LangSeo"]}'"]);
    if(!$sql->rowCount()) {$sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal); }
  }
  $row=$sql->fetch(PDO::FETCH_ASSOC);
  return $row;
}
function DilGelLangID($tableName,$WhereColumnName,$WhereColumnVal=0){
  global $DNCrud,$AktifLangID,$DefaultLangID;
  if(empty($WhereColumnName)) {
    return null;
  }
  $sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal,["ikincikosul"=>"AND LangID=".$AktifLangID]); 
  if(!$sql->rowCount()) {
    $sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal,["ikincikosul"=>"AND LangID=".$DefaultLangID]);
    if(!$sql->rowCount()){
      $sql=$DNCrud->ReadAData($tableName,$WhereColumnName,$WhereColumnVal);
    }
  }
  return $row=$sql->fetch(PDO::FETCH_ASSOC);
}