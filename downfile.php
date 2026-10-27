<?php
session_start();
error_reporting(0);
include 'config.php';
// var_dump($_POST);
// die();
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
// var_dump($bz_gl_code_ostan);
// var_dump($bz_gl_code_anbar);
// var_dump($status);
// die();
set_sanad($mt_gl_code_ostan, $mt_gl_code_anbar, $status);
?>