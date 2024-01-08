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
require_once('../include/theme.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$orig_suku=$_REQUEST['orig_suku'];

$ERROR_MSG = "";
if (isset($_POST['simpan'])) {
	OpenDb();
	$sql_cek ="SELECT * from jbsumum.suku where suku='".CQ($_REQUEST['suku'])."' AND replid <>'$orig_suku'";
	$hasil=QueryDb($sql_cek);
	
	if (mysqli_num_rows($hasil)>0){
		CloseDb();
		$ERROR_MSG = "Suku $suku sudah digunakan!";
	} else {
		$sql = "UPDATE jbsumum.suku SET suku='".CQ($_REQUEST['suku'])."' WHERE replid ='$orig_suku'";
		$result = QueryDb($sql);
	
		if ($result) { ?>
		<script language="javascript">
            opener.refresh('<?=$_REQUEST['suku']?>');
            window.close();
        </script>
<?php 	}	
}
}
CloseDb();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language = "javascript" type = "text/javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	return  validateEmptyText('suku', 'Nama Suku'); 
			validateMaxText('suku', 20, 'Nama Suku');
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}
</script>
<title>JIBAS SIMAKA [Ubah Nama Suku]</title>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('suku').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Ubah Suku :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
<?php
$suku = $_GET['suku'];
$replid=$_REQUEST['replid'];

if (isset($_POST['orig_suku']))
	$orig_suku = $_POST['orig_suku'];
?>


    <form name="main" method="post" onSubmit="return validate();">    
    <table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
	<!-- TABLE CONTENT -->
    <tr>
        <td width="35%"><strong>Nama Suku</strong></td>
        <td>
        <input type="text" name="suku" id="suku" maxlength="20" size="30" value="<?=$suku?>" onKeyPress="return focusNext('Simpan', event)">
        <input type="hidden" name="orig_suku" value="<?=$replid?>">
        </td>
    </tr>  
    <tr>
        <td colspan="2" align="center">
        	<input class="but" type="submit" value="Simpan" id="Simpan" name="simpan">
            <input class="but" type="button" value="Tutup" onClick="window.close();">
        </td>
    </tr>
   </table>
    </form>
<!-- END OF CONTENT //--->
    </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
<!-- Tamplikan error jika ada -->
<?php if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<?php } ?>

</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("suku");
</script>