<?php
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 *
 * @version: 29.0 (Sept 20, 2023)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 *
 * Copyright (C) 2009 Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?php
require_once('../include/errorhandler.php');
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
require_once('../library/date.func.php');
require_once('common.func.php');
require_once('dailytrans.func.php');

OpenDb();

$petugas = $_REQUEST["petugas"];
if ($petugas == "@0#")
    $petugas = "(Semua Petugas)";
else
    $petugas = GetUserName($petugas);

$vendor = $_REQUEST["vendor"];
if ($vendor == "@0#")
    $vendor = "(Semua Vendor)";
else
    $vendor = GetVendorName($vendor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>JIBAS KEU [Riwayat Transaksi Harian]</title>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
    <td align="left" valign="top">

<?=     getHeader("yayasan") ?>

        <center><font size="4"><strong>RIWAYAT TRANSAKSI HARIAN</strong></font><br /> </center><br /><br />
        <table border="0">
        <tr>
            <td><strong>Tanggal </strong></td>
            <td><strong>: <?= LongDateInaFormat($_REQUEST["tahun"], $_REQUEST["bulan"], {$_REQUEST["tanggal"]}) ?></strong></td>
        </tr>
        <tr>
            <td><strong>Petugas </strong></td>
            <td><strong>: <?= $petugas ?></strong></td>
        </tr>
        <tr>
            <td><strong>Vendor </strong></td>
            <td><strong>: <?= $vendor ?></strong></td>
        </tr>
        </table>
        <br />

<?php
ShowDailyReport(false);
?>

    </td>
</tr></table>
</body>
</html>
<script language="javascript">window.print();</script>
<?php CloseDb(); ?>