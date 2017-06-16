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
		$('#boyut').hide();
		// Yeni Dosya Ekle
		function ekle(){
			$("#yuklemeDosyalari").append('<span>Dosya Sec: <input type="file" name="dosya[]" /></span>');
		};
		
		// Dosya Yükle
		$("#form").bind("submit", function(){
			
			$("#sonuclar").empty();
			$(this).attr("target","gelenBilgi");
			$("<img />").attr("src","rsm/bekle.gif").appendTo($("#sonuclar"));
			
			$("#gelenBilgi").bind("load", function(){
				
				var deger = $("#gelenBilgi").contents().find("body").html();
				$("#sonuclar").html(deger);
			});
			
		});
	$('#bekleyin').hide();
	});
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
var sayi = 1;
function ekle(){
sayi = sayi+1;
if(sayi>6){
		alert("En Fazla 6 Kere Dosya Ekliyebilirsiniz!");
		}else{
		$('#yuklekutu').append('<span>Dosya Seçin:<input name="dosya[]" type="file"></span><br>');
		}
		};
		
		
	function boyutla(){
	$('#boyut').slideToggle('normal');
	var onay = document.getElementById('onay').value;
	if(onay==0){
	document.getElementById('onay').value = "1";	
	}else{
	document.getElementById('onay').value = "0";	
	}
	}
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
<form action="dosyayukle.php" method="post" enctype="multipart/form-data" id="form">
<table width="900" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="450" valign="top"><div id="yuklekutu"><span>Dosya Seçin:<input name="dosya[]" type="file"></span><br></div></td>
    	<td width="450" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="5">
			<tr>
					<td>
						<a href="javascript:void(0);" class="menu" onclick="ekle()">+Yeni Dosya Ekle</a>
					</td>
			</tr>
			<tr>
					<td>
						<select name="select" id="select" class="giris" style="width:120px;">
';
						
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
						echo '
						</select>
					</td>
			</tr>
			<tr>
					<td>
						<input id="yuklebuton" type="submit" value="Yükle">
					</td>
			</tr>
			<tr>
			<td width="100" align="center">
				
		<a href="javascript:void(0)" onclick="boyutla()" class="resimlink"><>Yeniden Boyutla</a><br>
		
		<div id="boyut">
		<table border="0" cellpadding="0" cellspacing="2">
		 <tr><td>X</td><td><input type="text" id="x" class="giris" size="1" name="x"></td><td>Y</td><td><input type="text" id="y" class="giris" size="1" name="y"></td></tr>
		</table>
		
		</div>
		<input type="hidden" value="0" name="onay" id="onay">
		</td>
			</tr>
		</table>
		</td>
  </tr>
  <tr>
		<td align="center" colspan="2">
		<iframe id="gelenBilgi" name="gelenBilgi" src="" style="display: none"></iframe>
		<div id="sonuclar"></div>
		</td>
  </tr>
</table>
</form>
<!-- panel div -->
</div>';}
?>
<div id="copright" align="center">&copy; Mert Çolak | 2012-2013</div>
</body>
</html>
<?php ob_end_flush(); ?>