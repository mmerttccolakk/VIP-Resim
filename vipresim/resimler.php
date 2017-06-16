<?php 
ob_start();
session_start();
session_register("email");
session_register("sifre");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resim Yönetim</title>
<link href="css/genel.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/lightbox.css" media="screen" />
<head>
<script type="text/javascript" src="qu/jquery.js"></script>
<script type="text/javascript" src="qu/lightbox.js"></script>
<script type="text/javascript">
function giris_yap(){

var email = document.getElementById('email').value;
var sifre = document.getElementById('sifre').value;
var say = 0;

if(email==""){
alert("Email Alanını Boş Bıraktınız.!");
}else{
if(sifre==""){
alert("Şire Alanını Boş Bıraktınız.!");
}else{
say = say+1;
}}

if(say==1){
document.getElementById('buton').value = "Bekleyiniz...";
$.post("kontrol.php",{email:email,sifre:sifre},function(donenDeger){
           $('#ekran').html(donenDeger);
			document.getElementById('buton').value = "Giriş";		   
        });
}}
$(function() {
	$('#gallery a').lightBox();
});
</script>
</head>
<body>
<div id="banner"><img src="rsm/banner.png"></div>
<div id="giris">
<?php
#fonksiyonlar
@include("bilgi/baglan.php");
echo "<!--";
@include("bilgi/function.php");
@$email	=	$_SESSION['email'];
@$sifre	=	$_SESSION['sifre'];
echo "-->";

$email	=	$_SESSION['email'];
$sifre	=	$_SESSION['sifre'];

$sorgu	=	mysql_query("SELECT * FROM uyeler WHERE email='$email'");
$bak	=	mysql_fetch_array($sorgu);

	if(empty($_SESSION['email']) or empty($_SESSION['sifre'])){
echo '<div id="ekran"><b>Giriş Yap</b></div><form action="kontrol.php" method="post" onsubmit="return false;"><table border="0"><tr><td>Email</td><td>:</td><td><input class="giris" type="text" name="email" id="email"/></td><td>Şifre</td><td>:</td><td><input class="giris" type="password" name="sifre" id="sifre"/></td><td><input class="girisbuton" type="submit" value="Giriş" id="buton" onclick="giris_yap()" /></td></tr>
</table></form></div>
<div id="panel">
<!-- panel div -->
Lütfen Giriş Yapın!
<!-- panel div -->
</div>';
	}else{
echo '<ul><li><a href="resimler.php" class="menu">Resimler</a></li><li><a href="rsmyukle.php" class="menu">Yükle</a></li><li><a href="katagori.php" class="menu">Katagori</a></li><li><a href="profil.php" class="menu">Profil</a></li><li><a href="cikis.php" class="menu">Çıkış</a></li></ul></div>';
echo '<div id="panel">
<!-- panel div -->
<table width="900" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="450" valign="top">';
			$katagori_id	=	get('select');
			if(empty($katagori_id)){
			echo 'Katagoriyi Seçip Git Deyin!';
			}else{
			$uye_id	=	$bak['id'];
			$sorguu	=	mysql_query("select * from resimler where katagori_id='$katagori_id' and kullanici_id='$uye_id'");
			$saybakim	=	mysql_num_rows($sorguu);
			echo 'Toplam Resim ( <b>'.$saybakim.'</b> ) ';
			$sayi=0;
			echo '<table width="450" cellpadding="0" cellspacing="5">';
			while($bakk=mysql_fetch_array($sorguu)){
			$sayi+=1;
			
			echo '<tr id="rsmlr" align="left" ><td width="15">'.$sayi.'.</td><td width="400"><div id="gallery"><a href="dosya/'.$uye_id.'/'.$bakk['rsm_adi'].'" title="'.$bakk['rsm_adi'].'"class="resimlink">';
			echo kisalt($bakk['rsm_adi']);
			echo '</a></div></td><td width="35"><a href="islem.php?is=resil&id='.$bakk['id'].'" class="resimlink"><b>Sil</b></a></td></tr>';
			
			}
			if($saybakim==0){
			echo '<tr><td colspan="3">Bu Katagoride Hiç Resim Yok!</td></tr>';}
			echo '</table>';
			}
			
	echo'</td>
		<td width="450" valign="top"><b>Katagoriler</b><br>
		<form action="resimler.php" method="get"><select name="select" id="select" class="giris" style="width:150px;">';
		$email	=	$_SESSION['email'];
$sorgu	=	mysql_query("SELECT * FROM uyeler WHERE email='$email'");
$bak	=	mysql_fetch_array($sorgu);

$kul_id	=	$bak['id'];
$sorguu	=	mysql_query("SELECT * FROM katagori WHERE kullanici_id='$kul_id'");
while($bakk=mysql_fetch_array($sorguu)){
		$katagori	=	$bakk['katagori'];
		echo '<option value="'.$bakk['id'].'">'.$katagori." ( ";
		$gecici	=	$bakk['id'];
		$resimler	=	mysql_query("SELECT * FROM resimler WHERE katagori_id='$gecici' and kullanici_id='$kul_id'");
		echo mysql_num_rows($resimler);
		echo ' ) </option>';
		}
		
		echo '</select><input type="submit" value="Git" class="girisbuton"></form>
		</td>
	</tr>
	</table>
<!-- panel div -->
</div>';}
?>
<div id="copright" align="center">&copy; Mert Çolak | 2012-2013</div>
</body>
</html>
<?php ob_end_flush(); ?>