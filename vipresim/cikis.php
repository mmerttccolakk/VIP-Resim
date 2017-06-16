<?php 
ob_start();
session_start();
session_register("email");
session_register("sifre");
$_SESSION['email']="";
$_SESSION['sifre']="";
echo '<meta HTTP-EQUIV=Refresh CONTENT="0; URL=index.php">';
echo 'Bsşarı İle Çıkış Yaptınız!';
ob_end_flush();
?>