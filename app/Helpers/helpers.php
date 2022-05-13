<?php
function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function rupiah($angka){
    $hasil_rupiah = "" . number_format($angka,0,',','.');
    return $hasil_rupiah;
}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function pembulatan($uang)
{
    $puluhan = substr($uang, -2);
    if($puluhan<50)
    $akhir = $uang + (100-$puluhan);
    else
    $akhir = $uang + (100-$puluhan);
    // return number_format($akhir, 2, ',', '.');;
    return $akhir;
}
// $uang = 133500;
// pembulatan($uang); // hasilnya adalah 134.000,00

//kalau tanpa pembulatan
// echo number_format($uang, 2, ',', '.');; // hasilnya 133.500,00
?>
