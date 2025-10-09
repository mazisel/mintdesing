<?php 

function KacGunOldu($Unix)
{
  $Today = strtotime(date("d.m.Y"));  
  if ($Today!=$Unix) {
     $olan_gun =$Today-$Unix;
     $olan_gun = $olan_gun/86400;
     return number_format($olan_gun);
  }else{
    $olan_gun=0;
    return $olan_gun;
  }
}



function tarihEkle($baslangicTarihi, $eklemeMiktari, $eklemeTur) {
    $tarih = new DateTime($baslangicTarihi);

    if ($eklemeTur === 'month') {
        $tarih->modify("+$eklemeMiktari month");
    } elseif ($eklemeTur === 'week') {
        $tarih->modify("+$eklemeMiktari week");
    } elseif ($eklemeTur === 'day') {
        $tarih->modify("+$eklemeMiktari day");
    } else {
        return false; // Geçersiz ekleme türü
    }

    return $tarih->format('Y-m-d H:i:s'); // Sonucu biçimlendirerek döndür
}

function haftatespit()
    {
        $dt_min = new DateTime("last sunday"); // Geçen Pazar
        $dt_min->modify('+1 day'); // Hafta Başını Buluyoruz.
        $dt_max = clone($dt_min);
        $dt_max->modify('+6 days'); // Hafta Sonunu Buluyoruz.
        $haftabasi = $dt_min->format('d.m.Y');
        $haftasonu = $dt_max->format('d.m.Y');
        // SQL Sorgusu için yazılan kod
        $dt_min = new DateTime("last sunday"); // Geçen Pazar
        $dt_min->modify('+1 day'); // Hafta Başını Buluyoruz.
        $dt_max = clone($dt_min);
        $dt_max->modify('+6 days'); // Hafta Sonunu Buluyoruz.
        $haftabasi = $dt_min->format('d.m.Y');
        $haftasonu = $dt_max->format('d.m.Y');
        return $r=[$haftabasi,$haftasonu];
    }