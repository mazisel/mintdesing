<?php 
function ApiUrlRequest($ApiUrl,$Apikey)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ApiUrl."?apikey=".$Apikey);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $Result = curl_exec($ch);
    return $Result;
}

function ApiRequest($ApiUrl,$Apikey,$Data=null)
{
    $ch = curl_init($ApiUrl."?apikey=".$Apikey);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $Data);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $Result = curl_exec($ch);
    return $Result;
}$uzanti[0]='com';
function ApiRequest2($ApiUrl,$Data=null)
{
    if (isset($Data['Apikey'])){
        $Apikey=$Data['Apikey'];
    }else{
        $Apikey='';
    }
    $ch = curl_init($ApiUrl."?apikey=".$Apikey);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Data));                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $Result = curl_exec($ch);
    return $Result;
}

