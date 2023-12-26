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
require_once('../../include/common.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/config.php');
require_once('../../include/db_functions.php');
require_once('../../include/sessionchecker.php');
require_once('../../include/fileutil.php');

$op = "";
if (isset($_REQUEST['op']))
	$op=$_REQUEST['op'];

if ($op == "bzux834hx8x7x934983xihxf084")
{
	OpenDb();
	
	$sql = "DELETE FROM jbsvcr.beritasekolah WHERE replid='".$_REQUEST['replid']."'";
	$result = QueryDb($sql);
	
	CloseDb();
}

$bulan="";
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
$tahun="";
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
$idpengirim=SI_USER_ID();
$varbaris=10;
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../script/tables.js"></script>
<script language="javascript" src="../../script/tools.js"></script>
<script language="javascript">
function bacaberita(replid){
	//parent.frametop.buletin();
	newWindow('bacaberitasekolah.php?replid='+replid,'BacaBeritanya',738,525,'resizable=1,scrollbars=1,status=0,toolbar=0');
	
}
function fill_month_and_year(){
	var bulan=parent.beritasekolah_header.document.getElementById("bulan").value;
	var tahun=parent.beritasekolah_header.document.getElementById("tahun").value;
	//alert ('Resend');
	document.location.href="beritasekolah_footer.php?bulan="+bulan+"&tahun="+tahun;
}
function chg_page(){
	var page=document.getElementById("page").value;
	var bulan=parent.beritasekolah_header.document.getElementById("bulan").value;
	var tahun=parent.beritasekolah_header.document.getElementById("tahun").value;
	//var tahun=parent.beritaguru_header.document.getElementById("tahun").value;
	//alert ('Resend');
	document.location.href="beritasekolah_footer.php?bulan="+bulan+"&tahun="+tahun+"&page="+page;
}
function ubah(replid,page){
	var bulan=parent.beritasekolah_header.document.getElementById("bulan").value;
	var tahun=parent.beritasekolah_header.document.getElementById("tahun").value;
	//alert (bulan+tahun+page+replid);
	document.location.href="beritasekolah_edit.php?replid="+replid+"&bulan="+bulan+"&tahun="+tahun+"&page="+page;
}
function hapus(replid){
	var page=document.getElementById("page").value;
	var bulan=parent.beritasekolah_header.document.getElementById("bulan").value;
	var tahun=parent.beritasekolah_header.document.getElementById("tahun").value;
	if (confirm('Anda yakin akan menghapus berita ini ?')){ 
		document.location.href="beritasekolah_footer.php?op=bzux834hx8x7x934983xihxf084&replid="+replid+"&bulan="+bulan+"&tahun="+tahun+"&page="+page;
	}
}
function change_page(page) {
	var bulan=parent.beritasekolah_header.document.getElementById("bulan").value;
	var tahun=parent.beritasekolah_header.document.getElementById("tahun").value;
	//var tahun=parent.beritaguru_header.document.getElementById("tahun").value;
	//alert ('Resend');
	document.location.href="beritasekolah_footer.php?bulan="+bulan+"&tahun="+tahun+"&page="+page;
}
function chg_title_color(id,stat){
	if (stat=="1")
		document.getElementById(id).style.color='red';
	else
		document.getElementById(id).style.color='';	
}
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
	color: #000000;
}
-->
</style>
</head>
<body <?php //if($bulan=="" && $tahun=="") { ?> <?php //} ?>><!--onload="fill_month_and_year();"-->
<input type="hidden" name="bulan" id="bulan" value="<?=$bulan?>" />
<input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>" />
<table width="100%" border="0" cellspacing="0">
  <tr>
  <?php OpenDb();
  $sql_tot="SELECT b.replid as replid, b.judul as judul, DATE_FORMAT(b.tanggal, '%e %b %Y') as tanggal, TIME_FORMAT(b.tanggal, '%H:%i') as waktu, ".
  		"b.abstrak as abstrak, b.isi as isi FROM jbsvcr.beritasekolah b ".
		"WHERE MONTH(b.tanggal)='$bulan' AND YEAR(b.tanggal)='$tahun' ORDER BY replid DESC";
  //echo $sql1;
  $result_tot=QueryDb($sql_tot);
  $total = ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
  CloseDb();
	?>
	<td scope="row" align="left">
	<?php
	if ($total!=0){
		if ($page==0){ 
		$disback="style='visibility:hidden;position:absolute;'";
		$disnext="style='visibility:visible;position:inherit;'";
		}
		if ($page<$total && $page>0){
		$disback="style='visibility:visible;position:inherit;'";
		$disnext="style='visibility:visible;position:inherit;'";
		}
		if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;position:inherit;'";
		$disnext="style='visibility:hidden;position:absolute;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;position:absolute;'";
		$disnext="style='visibility:hidden;position:absolute;'";
		}
	
	?>
    Halaman : 
	<input <?=$disback?> type="button" class="but" title="Sebelumnya" name="back" value="<" onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Sebelumnya', this, event, '75px')">
	<select name="page" id="page" onchange="chg_page()">
	<?php for ($p=1;$p<=$total;$p++){ ?>
		<option value="<?=$p-1?>" <?=StringIsSelected($page,$p-1)?>><?=$p;?></option>
	<?php } ?>
	</select>   
    <input <?=$disnext?> type="button" class="but" name="next" title="Selanjutnya" value=">" onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Berikutnya', this, event, '75px')">&nbsp;dari&nbsp;<?=$total?> 
	<?php } ?><br><br>
	<table width="80%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align='center' valign='top'>
          <?php
		  OpenDb();
		  $sql1="SELECT b.replid as replid, b.judul as judul, DATE_FORMAT(b.tanggal, '%e %b %Y') as tanggal, TIME_FORMAT(b.tanggal, '%H:%i') as waktu, ".
				"IF(b.jenisberita=1,'Darurat','Umum') as berita, b.abstrak as abstrak, b.isi as isi, b.idpengirim as idpengirim FROM jbsvcr.beritasekolah b ".
				"WHERE MONTH(b.tanggal)='$bulan' AND YEAR(b.tanggal)='$tahun' ORDER BY replid DESC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
		  //echo $sql1;
		  $result1=QueryDb($sql1);
		  if (@mysqli_num_rows($result1)>0){
		  $i=1;
		  if ($page==0){
		  $cnt=1;
		  } else {
		  $cnt=(int)$page*(int)$varbaris+1;
		  }
		  while ($row1=@mysqli_fetch_array($result1)){
		  if ($i==1 || $i%3==1){
		  	?>
            <tr>
          	<?php
		  }
			?>
        		<td align="center" valign='top'>
            <?php
		  ?>
			<?php if (@mysqli_num_rows($result1)==1) { ?>
            <div style="margin-left:100px" align="left">
			<?php } ?>
            <table width="300" border="0" cellspacing="0" cellpadding="0" style="cursor:pointer;" align="left" >
              <tr onclick="bacaberita('<?=$row1['replid']?>')" onmouseover="chg_title_color('title<?=$row1['replid']?>','1')" onmouseout="chg_title_color('title<?=$row1['replid']?>','0')">
                <td align="left"><img src="../../images/ico/arr1.gif" />&nbsp;<em><span style="font-size: 9px; color:#990000"><?=$row1['tanggal']?>&nbsp;<?=$row1['waktu']?></span></em></td>
                <td align="right"></td>
              </tr>
              <tr onclick="bacaberita('<?=$row1['replid']?>')" onmouseover="chg_title_color('title<?=$row1['replid']?>','1')" onmouseout="chg_title_color('title<?=$row1['replid']?>','0')">
                <td colspan="2" align="left">
				<span id="title<?=$row1['replid']?>" class="style1"><?=$row1['judul']?></span>
                <br />
                <em>
					<?php
                    if ($row1['idpengirim']=="adminsiswa"){
                        echo "Administrator Siswa";
                    } elseif ($row1['idpengirim']=="landlord") {
                            echo "Administrator JIBAS InfoSiswa";
                    } else {
                    $rs=QueryDb("SELECT nama FROM jbssdm.pegawai WHERE nip='$row1[idpengirim]'");
                    if (@mysqli_num_rows($rs)>0){
                    $rp=@mysqli_fetch_array($rs);
                    $nm=$rp[nama];
                    } else {
                    $rsi=QueryDb("SELECT nama FROM jbsakad.siswa WHERE nis='$row1[idpengirim]'");
                    $rsis=@mysqli_fetch_array($rsi);
                    $nm=$rsis[nama];
                    }
                    echo $row1['idpengirim']."-".$nm;
                    }
                    ?>
                </em>
                </td>
              </tr>
              <tr onclick="bacaberita('<?=$row1['replid']?>')" onmouseover="chg_title_color('title<?=$row1['replid']?>','1')" onmouseout="chg_title_color('title<?=$row1['replid']?>','0')">
                <td colspan="2" align="left">
					<?=$row1[abstrak];?>
                </td>
              </tr>
              <tr>
              	<td colspan="2" align="right">
              		<?php if ($row1[idpengirim]==SI_USER_ID()){ ?>
                        <img src="../../images/ico/ubah.png" border="0" onclick="ubah('<?=$row1['replid']?>','<?=$page?>')" style="cursor:pointer;" title="Ubah Berita ini !" />&nbsp;<img src="../../images/ico/hapus.png" border="0" onclick="hapus('<?=$row1['replid']?>')" style="cursor:pointer;" title="Hapus Berita ini !" />
	                <?php } ?>              	</td>
              </tr>
            </table>
			<?php if (@mysqli_num_rows($result1)==1) { ?>
            </div>
			<?php } ?>
			<br />
		<?="</td>";
		if ($i%3==0)
			echo "</tr>";
		$i++;
		}
		} else {
		?>
        <div align="center" class="divNotif">Tidak ada berita Sekolah</div>
        <?php
		}
		?>
        </td>
      </tr>
    </table>


		<script language='JavaScript'>
			//Tables('table', 1, 0);
		</script>

	</td>
  </tr>
</table>

</body>
</html>