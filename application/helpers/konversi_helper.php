<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// if (!function_exists('tgl_indo')) {
//     function tgl_indo($tgl)
//     {
//         $ubah = gmdate($tgl, time() + 60 * 60 * 8);
//         $pecah = explode("-", $ubah);
//         $tanggal = $pecah[2];
//         $bulan = bulan($pecah[1]);
//         $tahun = $pecah[0];
//         return $tanggal . ' ' . $bulan . ' ' . $tahun;
//     }
// }

// if (!function_exists('bulan')) {
//     function bulan($bln)
//     {
//         switch ($bln) {
//             case 1:
//                 return "Januari";
//                 break;
//             case 2:
//                 return "Februari";
//                 break;
//             case 3:
//                 return "Maret";
//                 break;
//             case 4:
//                 return "April";
//                 break;
//             case 5:
//                 return "Mei";
//                 break;
//             case 6:
//                 return "Juni";
//                 break;
//             case 7:
//                 return "Juli";
//                 break;
//             case 8:
//                 return "Agustus";
//                 break;
//             case 9:
//                 return "September";
//                 break;
//             case 10:
//                 return "Oktober";
//                 break;
//             case 11:
//                 return "November";
//                 break;
//             case 12:
//                 return "Desember";
//                 break;
//         }
//     }
// }

// if (!function_exists('nama_hari')) {
//     function nama_hari($tanggal)
//     {
//         $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
//         $pecah = explode("-", $ubah);
//         $tgl = $pecah[2];
//         $bln = $pecah[1];
//         $thn = $pecah[0];

//         $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
//         $nama_hari = "";
//         if ($nama == "Sunday") {
//             $nama_hari = "Minggu";
//         } else if ($nama == "Monday") {
//             $nama_hari = "Senin";
//         } else if ($nama == "Tuesday") {
//             $nama_hari = "Selasa";
//         } else if ($nama == "Wednesday") {
//             $nama_hari = "Rabu";
//         } else if ($nama == "Thursday") {
//             $nama_hari = "Kamis";
//         } else if ($nama == "Friday") {
//             $nama_hari = "Jumat";
//         } else if ($nama == "Saturday") {
//             $nama_hari = "Sabtu";
//         }
//         return $nama_hari;
//     }
// }

// if (!function_exists('hitung_mundur')) {
//     function hitung_mundur($wkt)
//     {
//         $waktu = array(
//             365 * 24 * 60 * 60  => "tahun",
//             30 * 24 * 60 * 60   => "bulan",
//             7 * 24 * 60 * 60    => "minggu",
//             24 * 60 * 60    => "hari",
//             60 * 60     => "jam",
//             60        => "menit",
//             1       => "detik"
//         );

//         $hitung = strtotime(gmdate("Y-m-d H:i:s", time() + 60 * 60 * 8)) - $wkt;
//         $hasil = array();
//         if ($hitung < 5) {
//             $hasil = 'kurang dari 5 detik yang lalu';
//         } else {
//             $stop = 0;
//             foreach ($waktu as $periode => $satuan) {
//                 if ($stop >= 6 || ($stop > 0 && $periode < 60)) break;
//                 $bagi = floor($hitung / $periode);
//                 if ($bagi > 0) {
//                     $hasil[] = $bagi . ' ' . $satuan;
//                     $hitung -= $bagi * $periode;
//                     $stop++;
//                 } else if ($stop > 0) $stop++;
//             }
//             $hasil = implode(' ', $hasil) . ' yang lalu';
//         }
//         return $hasil;
//     }
// }


// function penyebut($nilai)
// {
//     $nilai = abs($nilai);
//     $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
//     $temp = "";
//     if ($nilai < 12) {
//         $temp = " " . $huruf[$nilai];
//     } else if ($nilai < 20) {
//         $temp = penyebut($nilai - 10) . " belas";
//     } else if ($nilai < 100) {
//         $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
//     } else if ($nilai < 200) {
//         $temp = " seratus" . penyebut($nilai - 100);
//     } else if ($nilai < 1000) {
//         $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
//     } else if ($nilai < 2000) {
//         $temp = " seribu" . penyebut($nilai - 1000);
//     } else if ($nilai < 1000000) {
//         $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
//     } else if ($nilai < 1000000000) {
//         $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
//     } else if ($nilai < 1000000000000) {
//         $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
//     } else if ($nilai < 1000000000000000) {
//         $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
//     }
//     return $temp;
// }

// function terbilang($nilai) {
//   if($nilai<0) {
//      $hasil = "minus ". trim(penyebut($nilai));
//  } else {
//      $hasil = trim(penyebut($nilai));
//  }       
//  return $hasil;
// }

// function tgl_aja($tgl_a){
//  $tanggal = substr($tgl_a,8,2);
//  return $tanggal;  
// }

// function bln_aja($bulan_a){
//  $bulan = getBulan(substr($bulan_a,5,2));
//  return $bulan;  
// } 

// function thn_aja($thn){
//  $tahun = substr($thn,0,4);
//  return $tahun;  
// }

// function tgl_indo($tgl){
//  $tanggal = substr($tgl,8,2);
//  $bulan = getBulan(substr($tgl,5,2));
//  $tahun = substr($tgl,0,4);
//  return $tanggal.' '.$bulan.' '.$tahun;  
// } 

// function getBulan($bln){
//     switch ($bln){
//        case 1:
//        return "Januari";
//        break;
//        case 2:
//        return "Februari";
//        break;
//        case 3:
//        return "Maret";
//        break;
//        case 4:
//        return "April";
//        break;
//        case 5:
//        return "Mei";
//        break;
//        case 6:
//        return "Juni";
//        break;
//        case 7:
//        return "Juli";
//        break;
//        case 8:
//        return "Agustus";
//        break;
//        case 9:
//        return "September";
//        break;
//        case 10:
//        return "Oktober";
//        break;
//        case 11:
//        return "November";
//        break;
//        case 12:
//        return "Desember";
//        break;
//    }
// }
