<?php
//post verilerinii güvenli bir şekilde çeker
function post($post){
$post	=	trim(strip_tags(mysql_real_escape_string($_POST[$post])));
return $post;
}
//post verilerinii güvenli bir şekilde çeker
function get($get){
$get	=	trim(strip_tags(mysql_real_escape_string($_GET[$get])));
return $get;
}
//verileri güvenli bir şekilde temizler
function temizle($post){
return preg_replace('/[^a-zA-Z0-9.,_-]/s', '', $post);
}
//boslukları silmek
function bosluk($post){

$geleni = array(" ","  ");
$takasi = array("","");

$sistemi = str_replace($geleni, $takasi, $post); 
return $sistemi;
}
//verileri güvenli bir şekilde temizler türkçe karakter silmez
function turkce_silme_temizle($post){
return  preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ ]/s', '', $post);
}
//Boyut Hesaplama
function boyut_hesapla($size){
if($size >= 1073741824){ 
$size=round($size/1073741824)."Gb"; 
} 
elseif($size >= 1048576){ 
$size=round($size/1048576)."Mb"; 
} 
elseif($size >= 1024){ 
$size=round($size/1024)."Kb"; 
} 
return $size; 
} 
function kisalt($metin){
$kisaltma['sayi']		=	strlen($metin);
	if($kisaltma['sayi']>=50){
	$kisaltma['kisaltma']	=	substr($metin,-23);
	$kisaltma['kisaltma_2']	=	substr($metin,0,23);
	return $kisaltma['kisaltma_2'].'....'.$kisaltma['kisaltma'];
	}else{
	return $metin;
	}
	}

?>