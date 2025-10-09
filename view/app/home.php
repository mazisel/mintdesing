<?php 

/* URUN VERI CEKME VE LISTELEME */
$Sorgu=$DNCrud->ReadData("product",["sql"=>"WHERE FirmaID={$Firma['FirmaID']}"],"FirmaID");
$ProductCount=$Sorgu->rowCount();
/* CARI VERI CEKME VE LISTELEME */
$Sorgu=$DNCrud->ReadData("cari",["sql"=>"WHERE FirmaID={$Firma['FirmaID']}"],"FirmaID");
$CariCount=$Sorgu->rowCount();

