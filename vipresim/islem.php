<?php 
ob_start();
session_start();
session_register("email");
session_register("sifre");
#fonksiyonlar
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
@include("bilgi/baglan.php");
@include("bilgi/function.php");

@$email	=	$_SESSION['email'];
@$sifre	=	$_SESSION['sifre'];
$sorgu	=	mysql_query("SELECT * FROM uyeler WHERE email='$email'");
$bak	=	mysql_fetch_array($sorgu);
$katkutu	=	temizle(post('katkutu'));
$katkutu_get=	temizle(get('katkutu'));
$kul_id		=	$bak['id'];
$kul_sifre	=	$bak['sifre'];
$id	=	get('id');	
$url	=	get('is');	

switch ($url){
case "ekle";
if(empty($katkutu)){
echo 'Lütfen Katagori İsmi Beliryelin!';}else{
$islem	=	mysql_query("INSERT INTO `katagori` (
`id` ,
`katagori` ,
`kullanici_id`
)
VALUES (
NULL ,  '$katkutu',  '$kul_id'
);");
if($islem){
echo 'Katagori Eklendi!<meta HTTP-EQUIV=Refresh CONTENT="0; URL=katagori.php">';
}else{
echo 'Mysql Hatası!';
}}
break;
case "sil";
if(empty($katkutu_get)){
echo 'Lütfen Katagori İçin İd Beliryelin!';}else{
$sorgu	=	mysql_query("SELECT * FROM resimler WHERE katagori_id='$katkutu_get' and kullanici_id='$kul_id'");
$sorgu_sayi	=	mysql_num_rows($sorgu);
if($sorgu_sayi<=0){
$islem	=	mysql_query("DELETE FROM katagori WHERE id='$katkutu_get' and kullanici_id='$kul_id'");
if($islem){
echo 'Katagori Silindi!<meta HTTP-EQUIV=Refresh CONTENT="0; URL=katagori.php">';
}else{
echo 'Mysql Hatası!<meta HTTP-EQUIV=Refresh CONTENT="1; URL=katagori.php">';
}}else{echo 'Katagori İçinde Resim Var Silinemez!<meta HTTP-EQUIV=Refresh CONTENT="1; URL=katagori.php">';}}
break;
case "resil";
$rsm_sorgu	=	mysql_query("select * from resimler where id='$id' and kullanici_id='$kul_id'");
$rsmbak	=	mysql_fetch_array($rsm_sorgu);
$yol	=	'dosya/'.$kul_id.'/'.$rsmbak['rsm_adi'];

if(unlink($yol)){
$islem	=	mysql_query("delete from resimler where id='$id' and kullanici_id='$kul_id'");
if($islem){echo 'Resim Silindi<meta HTTP-EQUIV=Refresh CONTENT="0; URL=resimler.php?select='.$rsmbak['katagori_id'].'">';}else{echo 'Mysql Hatası!<meta HTTP-EQUIV=Refresh CONTENT="1; URL=resimler.php">';}
}else{
echo 'Resim Silinmedi!<meta HTTP-EQUIV=Refresh CONTENT="1; URL=resimler.php">';
}
break;
case 'sifredegis';
$eskipass	=	md5(sha1(md5(post('eskisifre'))));
$yenipass	=	md5(sha1(md5(post('yenisifre'))));
$yenipasst	=	md5(sha1(md5(post('yenisifretekrar'))));
if(empty($eskipass)){
echo 'Eski Şifreyi Boş Bırakmayın!';
}elseif(empty($yenipass) or empty($yenipasst)){
echo 'Yeni Şifreyi Boş Bırakmayın!';
}elseif($yenipass!=$yenipasst){
echo 'Yeni Şifreler Uyuşmıyor!';
}elseif(strlen($yenipass)<=3){
echo 'Yeni Şifre En Az 4 Karakter Olmalıdır!';
}elseif($eskipass!=$kul_sifre){
echo 'Eski Şifreniz Doğru Değil!';
}else{
$islem	=	mysql_query("UPDATE uyeler SET sifre='$yenipass' WHERE id='$kul_id';");
if($islem){
echo 'Şifreniz Başarı İle Değişti!';
}else{
echo 'Şifreniz Değiştirilemedi!';
}
}
break;
}

ob_end_flush();
?>