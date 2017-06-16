<?php 
ob_start();
session_start();
session_register("email");
session_register("sifre");
@include("../../bilgi/baglan.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>No Hacking</title>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<head><body><br><br>
<div id="uyar" align="center" style="	background-color: #E8E8E8;
	height: 130px;
	width: 800px;
	margin-right: auto;
	margin-left: auto;
	border: thin solid #666;
	position:relative;">
<table border="0" cellpadding="0" cellspacing="5" align="center">
<tr><td>İp</td><td>:</td><td><?php echo $_SERVER["REMOTE_ADDR"]; ?></td></tr>
<tr><td>Tarih</td><td>:</td><td><?php echo date('d / m / Y'); ?></td></tr>
<tr><td>Saat</td><td>:</td><td><?php echo date('H:i:s') ?></td></tr>
</table>
<?php

$ip			=	$_SERVER["REMOTE_ADDR"];
$tarih		=	date('d / m / Y');
$saat		=	date('H:i:s');

$islem	=	mysql_query("INSERT INTO `hack` (
`id` ,
`ip` ,
`tarih` ,
`saat` 
)
VALUES (
NULL , '$ip', '$tarih', '$saat'
);");
if($islem){
echo '<h3 align="center">Hack Girişimiz Kaydedildi!</h3>';
}else{
echo '<h3 align="center">Mysql Hatası!</h3></div>';}


?>
</div><br>
</body>
</html>
<?php ob_end_flush(); ?>