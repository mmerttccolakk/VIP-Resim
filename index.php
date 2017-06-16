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
<meta name="description" content="Vip Resim 'Mert Çolak' tarafından yazılan özel bir resim scriptidir.Çeşitli siteler için resim barındırır.Burda sitedeki resimler asla silinmez herzaman kullanıcıların kendi resimlerini yönetebildiği bir scripttir.,Her kullanıcı kendi resimlerini yönetir.">
<meta name="keywords" content="vip resim,vipresim,vip resim scripti,vipresim scipri indir,silinmeyen resim,silinen resim scripti,sınırsız dosya scripti">
<meta name="author" content="Mert Çolak">
<META NAME="robots" CONTENT="index,follow">
<head>
<script type="text/javascript" src="qu/jquery.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
$('#icerik').load('syf/anasayfa.php', function() {
$('#bekleyin').hide();
});
	});
function giris_yap(){

var email = document.getElementById('email').value;
var sifre = document.getElementById('sifre').value;
var say = 0;

if(email==""){
$('#ekran').html("Email Alanını Boş Bıraktınız.!");
}else{
if(sifre==""){
$('#ekran').html("Şire Alanını Boş Bıraktınız.!");
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
</table></form></div>';
	}else{
echo '<ul><li><a href="resimler.php" class="menu">Resimler</a></li><li><a href="rsmyukle.php" class="menu">Yükle</a></li><li><a href="katagori.php" class="menu">Katagori</a></li><li><a href="profil.php" class="menu">Profil</a></li><li><a href="cikis.php" class="menu">Çıkış</a></li></ul></div>';
	}
?>

</div>
<div id="panel">

<div id="bekleyin" align="center"><img src="rsm/bekle.gif"><br><b>Yükleniyor...</b></div>
<div id="icerik">İçerik Yüklenemedi!!!</div></div>
<div id="copright" align="center">&copy; Mert Çolak | 2012-2013</div>
</body>
</html>
<?php ob_end_flush(); ?>