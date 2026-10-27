<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
 //$count_havale_in_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","havale.code_ostan=$mt_gl_code_ostan AND havale.code_anbar=$mt_gl_code_anbar AND havale.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND year=$mtActiveYear AND code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
 $count_havale_in_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","havale.code_ostan=$mt_gl_code_ostan AND havale.code_anbar=$mt_gl_code_anbar AND havale.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.id NOT IN(SELECT id_havale FROM resid WHERE code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND shomare_havale_anbar=havale.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
 if($count_havale_in_this>0)		
 {  
  $res_ostan=mysql_query("SELECT distinct name_ostan,name_anbar FROM havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year INNER JOIN ostan ON mojavez_jabejae.code_ostan_maghsad_j=ostan.code_ostan INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND list_sardkhane.code_anbar=mojavez_jabejae.code_anbar_maghsad_j where havale.code_ostan=$mt_gl_code_ostan AND havale.code_anbar=$mt_gl_code_anbar AND havale.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND year=$mtActiveYear AND code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
  while($row=mysql_fetch_assoc($res_ostan)){$havale_info.=$row['name_ostan'].' '.$row['name_anbar'].'،';}
  echo'
    <div style="position:fixed;top:10px;right:15px;">
     <span class="simptip-position-left simptip-multiline simptip-fade simptip-info" data-tooltip="شما تعدادی حواله به '.$havale_info.' دارید که هنوز در مقصد ثبت نشده است">
         <img class="help blinkelement" border="0" src="images/info2.png" style="cursor:pointer"/>
     </span>
  </div>';
 }	
?>	