<?php
session_start();
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
 $q1="SELECT * From resid WHERE resid.code_ostan='".$_SESSION["mt_code_ostan"]."'";
 $all = mysql_query($q1);
 while($row1=mysql_fetch_assoc($all))
 {
		$signiture ="select sign_id from mt_typesign where activate=1 and type_id=1 and code_ostan=".$row1['code_ostan']." and code_anbar=".$row1['code_anbar']." ORDER BY turn";
	    $allsigniture  = $db->query($signiture);
	    $separatesigniture='';
	    while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
	    $separatesigniture=rtrim($separatesigniture, ";");
		mysql_query("UPDATE resid set signiture_resid='$separatesigniture' where code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
 }
 echo "change all resid signiture ".$_SESSION['mt_name_ostan']."!";
             
?>