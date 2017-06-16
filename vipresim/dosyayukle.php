<?php 
ob_start();
session_start();
session_register("email");
session_register("sifre");
#fonksiyonlar
@include("bilgi/baglan.php");
@include("bilgi/function.php");
require_once 'eklenti/ThumbLib.inc.php'; 

//ayarlar
$enfazla	=	6;
$uzantiler	=	array('JPG','PNG','GIF','BSP','JPEG');
$format		=	array('image/jpeg','image/png','image/gif','image/bsp');
$boyut		=	2;//2Mb


$email	=	$_SESSION['email'];
$sifre	=	$_SESSION['sifre'];

$sorgu	=	mysql_query("SELECT * FROM uyeler WHERE email='$email'");
$bak	=	mysql_fetch_array($sorgu);

$sinir	=	1024*1024*$boyut;
$toplam =	count($_FILES["dosya"]["name"]);

	if($toplam>$enfazla){
echo "En Fazla $enfazla Yüklüyebilirsiniz!";
	}else{
	$sayyy 	=	0;
	echo '<table border="0" cellpadding="0" cellspacing="0">';
for ($i = 0; $i < $toplam; $i++){
$resim['ad']		=	temizle($_FILES["dosya"]["name"][$i]);
$resim['uzanti']	=	strtoupper(substr($resim['ad'],-3));
$resim['tur']		=	$_FILES["dosya"]["type"][$i];
$resim['boyut']		=	$_FILES["dosya"]["size"][$i];
		if(empty($resim['ad'])){
		echo "Boş Dosya Gönderemessiniz!<br>";
		}elseif(!in_array($resim['uzanti'], $uzantiler)){
		echo 'Resim Uzantı Hatası!<br>';
		}elseif(!in_array($resim['tur'], $format)){
		echo "Resim Bozuk Format Hatası<br>";
		}elseif($resim['boyut']>$sinir){
		echo "En Fazla $boyut Mb Yüklüyebilirsiniz!<br>";
		}else{	
		
				//kullanici id ile klasör oluşturuluyor
				$id	=	$bak['id'];
				if (!file_exists("dosya/".$id)) { 
				mkdir("dosya/".$id, 0777);
				}
				//resim varmı
				if (file_exists("dosya/".$id."/".$resim['ad'])){
				$rand	=	rand(0,99999);
				$resim['bol']	=	explode(".",$resim['ad']);
				$resim['ad']	= 	$resim['bol'][0].$rand.".".$resim['uzanti'];
				}
		$yukleme = "dosya/".$bak['id']."/".$resim['ad'];
		if (move_uploaded_file($_FILES["dosya"]["tmp_name"][$i], $yukleme)){

									$kato_id	=	post('select');
									$sor		=	mysql_query("select * from katagori where id='$kato_id' and kullanici_id='$id'");
									$varmi		=	mysql_num_rows($sor);
									if($varmi>0){
														$add	=	$resim['ad'];
														$boyutt	=	$resim['boyut'];
														$islem	=	mysql_query("INSERT INTO `resimler` (
`id` ,
`katagori_id` ,
`boyut` ,
`kullanici_id` ,
`rsm_adi`
)
VALUES (
NULL ,  '$kato_id',  '$boyutt',  '$id',  '$add'
);
");														
														if($islem){
														$sayyy+=1;
														echo '<tr><td>'.$sayyy.'.</td><td align="left"><a href="'.'dosya/'.$id.'/'.$resim['ad'].'" class="resimlink">'.$resim['ad'].'</a></td></tr>';														
					$onay = post('onay');
					$x = post('x');
					$y = post('y');
				if($onay==1){
				$thumb = PhpThumbFactory::create($yukleme);  
				$thumb->adaptiveResize($x, $y)->save($yukleme);
				}
													
														
														}else{
														echo "Mysql Hatası!";
														echo unlink($yukleme)?"":"Dosya Silininemedi!";
														}
									}else{
									echo "Sizin Böyle Bir Katagoriniz Yok!<br>";
									echo unlink($yukleme)?"":"Dosya Silininemedi!";
									}
							
		}else{
		echo "Dosya Yüklemesi Başarısız!";
		}
		
		}

}//for fnish
echo '</table>';
		}//toplam if elsesi
ob_end_flush();
?>