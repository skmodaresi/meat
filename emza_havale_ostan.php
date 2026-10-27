<?php
session_start();
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
 $q1="SELECT * From havale WHERE havale.code_ostan='".$_SESSION["mt_code_ostan"]."'";
 $all = mysql_query($q1);
 while($row1=mysql_fetch_assoc($all))
 {
   $signiture_havale ="select sign_id from mt_typesign where activate=1 and type_id=2 and code_ostan=".$row1['code_ostan']." and code_anbar=".$row1['code_anbar']." ORDER BY turn";
   $allsigniture_havale = $db->query($signiture_havale);
   $separatesigniture_havale='';
   while($row_sign1=$db->fetch_assoc($allsigniture_havale)) $separatesigniture_havale = $separatesigniture_havale . $row_sign1['sign_id'].';' ;
   $separatesigniture_havale=rtrim($separatesigniture_havale, ";");
   $signiture_khorooj ="select sign_id from mt_typesign where activate=1 and type_id=4 and code_ostan=".$row1['code_ostan']." and code_anbar=".$row1['code_anbar']." ORDER BY turn";
   $allsigniture_khorooj = $db->query($signiture_khorooj);
   $separatesigniture_khorooj='';
   while($row_sign2=$db->fetch_assoc($allsigniture_khorooj)) $separatesigniture_khorooj = $separatesigniture_khorooj . $row_sign2['sign_id'].';' ;
   $separatesigniture_khorooj=rtrim($separatesigniture_khorooj, ";");
   mysql_query("UPDATE havale set signiture_havale='$separatesigniture_havale',signiture_khorooj='$separatesigniture_khorooj'	where code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
 }
 echo "change all havale signiture ".$_SESSION['mt_name_ostan']."!";           
?>