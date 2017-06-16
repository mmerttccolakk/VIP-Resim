<?php
################################################
$sunucu    = "localhost"; //mysql sunucu       #
$kullanici = "root";      //mysql kullanıcıadı #
$sifre     = "sifre";  //mysql şifre        #
$veritabani= "rupload";	  //veritabanı adı     #
################################################

#############################################-baglantı#######################################################################################################################
@mysql_connect($sunucu,$kullanici,$sifre) or die ('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><center><h1>Mysql Baglanılamadı!!!</h1></center>'); #
@mysql_select_db($veritabani) or die ('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><center><h1>Mysql Veritabanına Bağlanılamadi!!!</h1></center>');#
#############################################################################################################################################################################


$ip		=	$_SERVER["REMOTE_ADDR"];
$sorgu	=	mysql_query("select * from hack where ip='$ip'");
$say	=	mysql_num_rows($sorgu);

if($say>=5){
echo '<div id="uyar" align="center" style="	background-color: #E8E8E8;
	height: 70px;
	width: 800px;
	margin-right: auto;
	margin-left: auto;
	border: thin solid #666;
	position:relative;">';
echo '<b>'.$ip.'</b> İp Adresiniz İle 5 Ten Fazla Hack Girişimi Yaptığınızı Tespit Ettik.Eğer Bu Durum"u Devam Ettirirseniz Yasal İşlemler Başlatılacaktır! <br>Toplam Hack Girişimi:<b>'.$say.'</b>';
echo '</div>';
}

###############################
mysql_query("SET NAMES UTF8");#
###############################
?>