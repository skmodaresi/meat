<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
//ورود کد کالا
if(isset($_POST['codeKALA_Error']))//در گزارش ها
{
 if(empty($_POST['codeKALA_Error']))
  echo 'لطفاً کد کالا را وارد کنید';
}
/*************************************************************/
//ورود کد کشور
if(isset($_POST['codeKESHVAR_Error']))//در گزارش ها
{
 if(empty($_POST['codeKESHVAR_Error']))
  echo 'لطفاً کد کشور را وارد کنید';
}
/*************************************************************/
//ورود سال و ماه تولید 
if((isset($_POST['SAL_Error']))or(isset($_POST['MAH_Error'])))//در گزارش ها
{
 if((empty($_POST['SAL_Error']))and(empty($_POST['MAH_Error'])))
  echo 'لطفاً سال و ماه تولید را وارد نمایید !';
 else if(empty($_POST['SAL_Error']))
  echo 'لطفاً سال تولید را وارد نمایید !';
 else if(empty($_POST['MAH_Error']))
  echo 'لطفاً ماه تولید را انتخاب نمایید !';
}
/*************************************************************/
//ورود کد مشتری
if(isset($_POST['codeMOSHTARY_Error']))//در گزارش ها
{
 if(empty($_POST['codeMOSHTARY_Error']))
  echo 'لطفاً کد مشتری را وارد کنید !';
}
?>