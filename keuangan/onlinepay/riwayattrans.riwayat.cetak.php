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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../library/departemen.php');
require_once('../include/errorhandler.php');
require_once('../include/getheader.php');

OpenDb();

$departemen = $_REQUEST["departemen"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Riwayat Transaksi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <link rel="stylesheet" type="text/css" href="../script/themes/ui-lightness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="onlinepay.style.css">
    <script language="javascript" src="../script/jquery-1.9.0.js"></script>
    <script language="javascript" src="../script/ui/jquery-ui.custom.js"></script>
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/dateutil.js"></script>
    <script language="javascript" src="../script/stringutil.js"></script>
    <script language="javascript" src="appserver.js?r=<?=filemtime('appserver.js')?>"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            var content = window.opener.getRiwayatTableContent();
            $("#dvCetak").html(content);

            var tabReport = $('#tabReport');

            // Iterate through each row (excluding the header row)
            tabReport.find('tr').each(function() {
                $(this).find('td#thrincian').remove();
                $(this).find('td.rincian').remove();
            });

            $("#spTanggal").html(": " + window.opener.getTanggal());
            $("#spMetode").html(": " + window.opener.getMetodeText());

            var pembayaran = window.opener.getPembayaranVal();
            if (pembayaran === "ALL")
            {
                $("#spPembayaran").html(": " + window.opener.getPembayaranText());
            }
            else
            {
                var namaPembayaran = window.opener.getPembayaranText();
                var namaIuran = window.opener.getIdPembayaranText();
                if (namaIuran !== "-") namaPembayaran = namaPembayaran + " - " + namaIuran;
                $("#spPembayaran").html(": " + namaPembayaran);
            }

            var siswa = window.opener.getSiswaVal();
            if (siswa === "ALL")
            {
                $("#spSiswa").html(": " + window.opener.getSiswaText());
            }
            else
            {
                $("#spSiswa").html(": " + window.opener.getNamaSiswa());
            }

            $("#spBank").html(": " + window.opener.getBank());
            $("#spPetugas").html(": " + window.opener.getPetugas());
        });
    </script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
    <td align="left" valign="top">

<?php
        getHeader($departemen)
?>

        <center><font size="4"><strong>RIWAYAT TRANSAKSI</strong></font><br /> </center><br /><br />
        <table border="0">
        <tr>
            <td width="49%" align="left" valign="top">
                <table border="0">
                <tr>
                    <td><strong>Departemen</strong></td>
                    <td><strong>: <?= $departemen ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td><span id="spTanggal" style="font-weight: bold;"></span></td>
                </tr>
                <tr>
                    <td><strong>Metode</strong></td>
                    <td><span id="spMetode" style="font-weight: bold;"></span></td>
                </tr>
                <tr>
                    <td><strong>Pembayaran</strong></td>
                    <td><span id="spPembayaran" style="font-weight: bold;"></span></td>
                </tr>
                </table>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="49%" align="left" valign="top">
                <table border="0">
                <tr>
                    <td><strong>Siswa</strong></td>
                    <td><span id="spSiswa" style="font-weight: bold;"></span></td>
                </tr>
                <tr>
                    <td><strong>Bank</strong></td>
                    <td><span id="spBank" style="font-weight: bold;"></span></td>
                </tr>
                <tr>
                    <td><strong>Petugas</strong></td>
                    <td><span id="spPetugas" style="font-weight: bold;"></span></td>
                </tr>
                </table>
            </td>
        </tr>
        </table>


        <br />
    </td>
</tr>
<tr>
    <td align="left" valign="top">
        <div id="dvCetak">

        </div>
    </td>
</tr>
</table>

</body>
</html>
<?php
CloseDb();
?>