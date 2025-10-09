<?php 
//veritabanı bağlanma {
$host = "localhost";
$dbn = "sadeceme_muhsabe_eckpack";
$user = "sadeceme_muhasebe_admin";
$pass = "xoww!?yZ%He*";
$charset = "utf8mb4";
//veritabanı bağlanma }

//domain {
$DomainName = "eckpack.in";	
//domain }
//site base {
$SiteBase1 = "";
//site base }
//yonetimin basesi {
$AdminBase1 = "eppanel";
//yonetimin basesi }

#ssl{
$ssl = "1";
#ssl}

#ssl{
$www = "0";
#ssl}

define( 'DBHOST', $host);
define( 'DBUSER', $user);
define( 'DBPSWRD', $pass);
define( 'DBNAME', $dbn);
define( 'DBCHARSET', $charset);
?>