<?php
function nama_hari($tanggal)
{
    $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
    $pecah = explode("-", $ubah);
    $tgl = $pecah[2];
    $bln = $pecah[1];
    $thn = $pecah[0];

    $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
    $nama_hari = "";
    if ($nama == "Sunday") {
        $nama_hari = "Minggu";
    } else if ($nama == "Monday") {
        $nama_hari = "Senin";
    } else if ($nama == "Tuesday") {
        $nama_hari = "Selasa";
    } else if ($nama == "Wednesday") {
        $nama_hari = "Rabu";
    } else if ($nama == "Thursday") {
        $nama_hari = "Kamis";
    } else if ($nama == "Friday") {
        $nama_hari = "Jumat";
    } else if ($nama == "Saturday") {
        $nama_hari = "Sabtu";
    }
    return $nama_hari;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}
?>
<title><?= $title ?></title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<style type="text/css">
    .wrapper {
        height: auto;
    }

    #container {
        display: table;
    }

    #row {
        display: table-row;
    }

    #left,
    #right,
    #middle {
        display: table-cell;
    }

    body {
        font-size: 11pt;
    }

    footer {
        position: fixed;
        bottom: -10px;
        right: 0px;
        height: 70px;
        width: 100%;
        text-align: left;
    }

    @page {
        footer: html_otherpagesfooter;
    }
</style>


<body>
    <htmlpagefooter name="otherpagesfooter" style="display:none">
        <div style="text-align:center;">
            <footer>
                <table cellpadding="1" cellspacing="1" style="margin-left: 420px;border: 1px solid;font-size: 8pt">
                    <tbody>
                        <tr>
                            <td style="border-right:1px solid;width: 100px">Pihak Pertama</td>
                            <td style="width: 100px"></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid" colspan="2"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px;border-right: 1px solid">Pihak Kedua</td>
                            <td style="width: 100px"></td>
                        </tr>
                    </tbody>
                </table>
            </footer>
        </div>

    </htmlpagefooter>

    <htmlpagefooter name="footer"></htmlpagefooter>

    <br>
    <div class="wrapper">
        <table width="100%">
            <tr>
                <td width="35%" style="vertical-align:middle;text-align: center;">
                    <img src="<?= ($draft_company[0]->draft_status == 'p1' ? $_SERVER["DOCUMENT_ROOT"] . '/bpu-backend/assets/uploads/base_setting/' . $base_setting[0]->bs_logo : $_SERVER["DOCUMENT_ROOT"] . '/bpu-backend/assets/uploads/lembaga/' . $draft_company[0]->id_cv . '/logo/' . $draft_company[0]->logo) ?>" style="max-width: 250px;max-height: 150px">
                </td>
                <td width="70%" style="vertical-align:middle;text-align: center;font-size: 15pt;font-weight: bold">
                    <p>
                        DRAFT KERJASAMA
                    </p>
                    <p><i>(MEMORANDUM OF UNDERSTANDING)</i></p>
                </td>
                <td width="35%" style="vertical-align:middle;text-align: center;">
                    <img src="<?= ($draft_company[0]->draft_status != 'p1' ? $_SERVER["DOCUMENT_ROOT"] . '/bpu-backend/assets/uploads/base_setting/' . $base_setting[0]->bs_logo : $_SERVER["DOCUMENT_ROOT"] . '/bpu-backend/assets/uploads/logo/' . $draft_company[0]->logo) ?>" style="max-width: 250px;max-height: 150px">
                </td>
            </tr>
        </table>
    </div>


    <div class="wrapper">
        <table width="100%" style="font-weight: bold;">
            <tr>
                <td width="100%" style="vertical-align:top;text-align:center">
                    <p>
                        ANTARA<br>
                        <?= ($draft_company[0]->draft_status == 'p1' ? $base_setting[0]->bs_nama : $draft_company[0]->nama_perusahaan) ?>
                        <br>
                        DENGAN<br>
                        <?= ($draft_company[0]->draft_status != 'p1' ? $base_setting[0]->bs_nama : $draft_company[0]->nama_perusahaan) ?>
                        <br><br>
                        TENTANG<br>
                        PENDIDIKAN, PENELITIAN, PENGABDIAN KEPADA MASYARAKAT DAN PENGEMBANGAN KELEMBAGAAN
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wrapper">
        <table width="100%" style="font-weight: bold;">
            <tr>
                <td width="45%" style="text-align: right"><br>NOMOR:</td>
                <td width="55%">
                    <p><br><?= ($draft_company[0]->draft_status == 'p1' ? $draft_company[0]->draft_nomorp1 : $draft_company[0]->draft_nomorp2) ?></p>
                </td>
            </tr>
            <tr>
                <td width="45%" style="text-align: right">NOMOR:</td>
                <td width="55%">
                    <p><?= ($draft_company[0]->draft_status != 'p1' ? $draft_company[0]->draft_nomorp1 : $draft_company[0]->draft_nomorp2) ?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wrapper">
        <table width="100%" style="margin-top: 10px">
            <tr>
                <td width="100%">
                    Pada hari ini <?= nama_hari($draft_company[0]->draft_tanggal_mulai) ?> tanggal <?= terbilang(date('d', strtotime($draft_company[0]->draft_tanggal_mulai))) ?> bulan <?= terbilang(date('m', strtotime($draft_company[0]->draft_tanggal_mulai))) ?> tahun <?= terbilang(date('Y', strtotime($draft_company[0]->draft_tanggal_mulai))) ?> (<?= date('d-m-Y', strtotime($draft_company[0]->draft_tanggal_mulai)) ?>) bertempat di <?= $draft_company[0]->draft_lokasi ?>, kami yang bertanda tangan dibawah ini:
                </td>
            </tr>
        </table>
    </div>

    <br>

    <div class="wrapper">
        <table width="100%">
            <tr>
                <td width="4%" style="font-weight: bold;vertical-align: top;">I.</td>
                <td width="47%" style="font-weight: bold;vertical-align: top;">
                    <?= ($draft_company[0]->draft_status == 'p1' ? $base_setting[0]->bs_rektor : $draft_company[0]->lembaga_pimpinan_nama) ?>
                </td>
                <td width="2%" style="vertical-align: top;">:</td>
                <td width="47%" style="text-align: justify;vertical-align: top">
                    <?= ($draft_company[0]->draft_status == 'p1' ? $base_setting[0]->bs_keterangan : $draft_company[0]->draft_keterangan) ?>
                    , selanjutnya disebut <b>PIHAK PERTAMA</b>, dan<br><br>
                </td>
            </tr>
            <tr>
                <td width="4%" style="font-weight: bold;vertical-align: top;">II.</td>
                <td width="47%" style="font-weight: bold;vertical-align: top;">
                    <?= ($draft_company[0]->draft_status != 'p1' ? $base_setting[0]->bs_rektor : $draft_company[0]->nama_pimpinan) ?>
                </td>
                <td width="2%" style="vertical-align: top;">:</td>
                <td width="47%" style="text-align: justify;vertical-align: top"><?= ($draft_company[0]->draft_status != 'p1' ? $base_setting[0]->bs_keterangan : $draft_company[0]->draft_keterangan) ?>. Selanjutnya disebut sebagai <b>PIHAK KEDUA.</b></td>
            </tr>
        </table>
    </div>

    <br>
    <span style="text-align: justify;">Untuk selanjutnya <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> secara bersama-sama disebut <b>PARA PIHAK,</b> terlebih dahulu menerangkan hal-hal sebagai berikut :</span>
    <br>
    <br>
    <div class="wrapper">
        <table width="100%" style="text-align: justify;">
            <tr>
                <td width="8%" style="vertical-align: top">
                    (1)
                </td>
                <td width="92%">
                    Bahwa <b>PIHAK PERTAMA</b> adalah <?= ($draft_company[0]->draft_status == 'p1' ? 'Perguruan Tinggi Negeri Badan Layanan Umum (PTN-BLU) yang menyelenggarakan  pendidikan, penelitian dan pengabdian kepada masyarakat di bidang sains, teknologi, sosial humaniora dan seni. ' : $draft_company[0]->draft_info) ?>
                </td>
            </tr>
            <tr>
                <td width="8%" style="vertical-align: top">
                    (2)
                </td>
                <td width="92%">
                    Bahwa <b>PIHAK KEDUA</b> adalah <?= ($draft_company[0]->draft_status != 'p1' ? 'Perguruan Tinggi Negeri Badan Layanan Umum (PTN-BLU) yang menyelenggarakan  pendidikan, penelitian dan pengabdian kepada masyarakat di bidang sains, teknologi, sosial humaniora dan seni. ' : $draft_company[0]->draft_info) ?>
                </td>
            </tr>
            <tr>
                <td width="8%" style="vertical-align: top">
                    (3)
                </td>
                <td width="92%">
                    Bahwa <b>PARA PIHAK</b> masing-masing memiliki kemampuan untuk memberikan dukungan dalam suatu pola kerjasama yang saling menguntungkan.
                </td>
            </tr>
        </table>
    </div>

    <br>
    <br>

    <div class="wrapper">
        <table width="100%" style="text-align: justify;">
            <tr>
                <td>Berdasarkan hal-hal tersebut di atas, <b>PARA PIHAK</b> memandang perlu untuk mengikatkan diri satu sama lain dalam sebuah Nota Kesepahaman Bersama dengan ketentuan sebagaimana diatur dalam pasal-pasal sebagai berikut:</td>
            </tr>
        </table>

    </div>
    <br>
    <br>

    <?php foreach ($pasal as $pp) :
        if ($pp->draft_id == $draft_company[0]->id) { ?>
            <div class="wrapper">
                <div id="container">
                    <div id="row">
                        <div id="right">
                            <br><?= $pp->pasal_isi ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    endforeach; ?>


    <div class="wrapper">
        <table width="100%">
            <tr>
                <td width="100%" style="text-align: justify;">
                    Demikian Nota Kesepahaman Bersama ini dibuat dan ditandatangani pada hari dan tanggal tersebut di atas dalam rangkap 2 (dua) bermeterai cukup, masing-masing mempunyai kekuatan hukum yang sama.
                </td>
            </tr>
        </table>
    </div>

    <div class="wrapper" style="margin-top: 50px;">

        <table style="text-align: center">
            <tbody>
                <tr>
                    <td width="40%">
                        <b>Pihak Pertama</b>
                    </td>
                    <td width="20%">
                        &nbsp;
                    </td>
                    <td width="40%">
                        <b>Pihak Kedua</b>
                    </td>
                </tr>
                <tr style="font-weight: bold;">
                    <td width="40%" style="vertical-align: top">
                        <b><?= ($draft_company[0]->draft_status == 'p1' ? $base_setting[0]->bs_nama : $draft_company[0]->nama_perusahaan) ?></b>
                    </td>
                    <td width="20%">
                        &nbsp;
                    </td>
                    <td width="40%" style="vertical-align: top">
                        <b><?= ($draft_company[0]->draft_status != 'p1' ? $base_setting[0]->bs_nama : $draft_company[0]->nama_perusahaan) ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" height="100"></td>
                </tr>
                <tr style="font-weight: bold;">
                    <td width="45%" style="vertical-align: bottom">
                        <br>
                        <b><?= ($draft_company[0]->draft_status == 'p1' ? $base_setting[0]->bs_rektor : $draft_company[0]->nama_pimpinan) ?></b>
                    </td>
                    <td width="10%">
                        &nbsp;
                    </td>
                    <td width="45%" style="vertical-align: bottom">
                        <b><?= ($draft_company[0]->draft_status != 'p1' ? $base_setting[0]->bs_rektor : $draft_company[0]->nama_pimpinan) ?></b>
                    </td>
                </tr>
                <tr>
                    <td width="45%" style="vertical-align: top">
                        <?php
                        if ($draft_company[0]->draft_status == 'p1') {
                            echo "Rektor";
                        } else {
                            foreach ($cps_grab as $cps) :
                                if ($draft_company[0]->cps_id == $cps->cps_id) {
                                    echo $cps->cps_nama;
                                }
                            endforeach;
                        }
                        ?>
                    </td>
                    <td width="10%">
                        &nbsp;
                    </td>
                    <td width="45%" style="vertical-align: top">
                        <?php
                        if ($draft_company[0]->draft_status != 'p1') {
                            echo "Rektor";
                        } else {
                            foreach ($cps_grab as $cps) :
                                if ($draft_company[0]->cps_id == $cps->cps_id) {
                                    echo $cps->cps_nama;
                                }
                            endforeach;
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <sethtmlpagefooter name="footer" />
</body>