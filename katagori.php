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
<head>
<script type="text/javascript" src="qu/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		$('#bekleyin').hide();
		});
		
function ekle(){
var katkutu = document.getElementById('katkutu').value;
$("#bekleyin").show();
$.post("islem.php?is=ekle",{katkutu:katkutu},function(donenDeger){
           $('#icerik').html(donenDeger);
$("#bekleyin").hide();		   
        });
}
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
<!-- panel div -->';
	echo '<table width="900" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="450" valign="top">';
$kul_id	=	$bak['id'];
$sorguu	=	mysql_query("SELECT * FROM katagori WHERE kullanici_id='$kul_id'");
$say	=	mysql_num_rows($sorguu);
echo "Toplam Katagori ( <b>$say</b> )<br>";
$numara	=	0;
echo '<table width="450" cellpadding="0" cellspacing="5">';
		while($bakk=mysql_fetch_array($sorguu)){
		$numara+=1;
		$katagori		=	$bakk['katagori'];
		$katagori_id	=	$bakk['id'];
		echo '<tr align="left" id="rsmlr"><td width="15">'.$numara.'.</td><td width="400">'.$katagori." <b>( ";
$resimler	=	mysql_query("SELECT * FROM resimler WHERE katagori_id='$katagori_id' and kullanici_id='$kul_id'");
echo mysql_num_rows($resimler);
echo ' )</b></td><td width="35"><a href="islem.php?is=sil&katkutu='.$katagori_id.'" class="resimlink">&nbsp;<b>Sil</b></a></td></tr>';
}


echo '
	</table>
	</td>
    <td width="450" valign="top">
	<b>Katagori Ekle</b>
	<form action="" method="post" onsubmit="return false;"><input type="text" id="katkutu" class="giris" style="width:150px;"><input type="submit" value="Ekle" onclick="ekle()" class="girisbuton">
	</form>
	<div id="bekleyin" align="center"><img src="rsm/bekle.gif"><br><b>Yükleniyor...</b></div>
	<div id="icerik"></div></td>
    	</tr>
		</table>
		';
echo '<!-- panel div -->
</div>';}
?>
<div id="copright" align="center">&copy; Mert Çolak | 2012-2013</div>
</body>
</html>
<?php ob_end_flush(); ?>