<?php
session_start();
ob_start();
session_register("email");
session_register("sifre");
#fonksiyonlar
@include("bilgi/baglan.php");
@include("bilgi/function.php");

$email	=	$_SESSION['email'];
$sifre	=	$_SESSION['sifre'];

$sorgu	=	mysql_query("SELECT * FROM uyeler WHERE email='$email'");
$bak	=	mysql_fetch_array($sorgu);

	if(empty($_SESSION['email']) or empty($_SESSION['sifre'])){

	$pemail	=	post('email');
	$psifre	=	post('sifre');
	//526641bd710f0e083d38ed9a216391c3 pass to 12345
	$psifre	=	md5(sha1(md5($psifre)));
	
	$sorguu	=	mysql_query("SELECT * FROM uyeler WHERE email='$pemail'");
	$bakk	=	mysql_fetch_array($sorguu);
	
	if($bakk['email']!=$pemail){
	echo "Böyle Bir Email Kayıtlı Değil!";
	}elseif($bakk['sifre']!=$psifre){
	echo "Şifre Doğru Değil!";
	}elseif($bakk['durum']>=1){
	$time	=	time();
	@mysql_query("UPDATE uyeler SET time='$time' WHERE email='$pemail'");
	$_SESSION['email']=$pemail;
	$_SESSION['sifre']=$psifre;
	echo '<a href="index.php" class="resimlink">Yönlendiriliyorsunuz...</a>';
	echo '<meta HTTP-EQUIV=Refresh CONTENT="0; URL=index.php">';
	}else{
	echo '<h3>Sistemden Banlısınız!</h3>';}
	}
ob_end_flush();
?>