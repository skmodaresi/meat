<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$titr='جدول قراردادها';
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_gharardad.php";
$TableName="gharardad_kharid";
$radif=1;
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
else {$condition_ostan=' AND T.code_ostan='.$mt_gl_code_ostan.'';}
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(id_gh,sh_gh,akharin_gheymat,meghdar_gh,mazad_gh,meghdar_gharardad_nahayi,mablagh_kol,sum_tahvily_gharardad,mande_meghdar,mande_pardakht,mande_tahvily_gharardad)
{
 window.opener.document.myform.id_gharardad.value=id_gh;
 window.opener.document.myform.shomare_gharardad.value=sh_gh;
 window.opener.document.myform.akharin_gheymat.value=akharin_gheymat;
 window.opener.document.myform.meghdar_gharardad.value=meghdar_gh;
 window.opener.document.myform.mazad_gharardad.value=mazad_gh;
 window.opener.document.myform.meghdar_gharardad_nahayi.value=meghdar_gharardad_nahayi;
 window.opener.document.myform.mablagh_kol.value=mablagh_kol;
 window.opener.document.myform.sum_tahvily_gharardad.value=sum_tahvily_gharardad;
 window.opener.document.myform.mande_meghdar.value=mande_meghdar;
 window.opener.document.myform.mande_pardakht.value=mande_pardakht;
 window.opener.document.myform.mande_tahvily_gharardad.value=mande_tahvily_gharardad;
 window.opener.document.myform.shomare_gharardad.focus();
 window.close();
}
</script>
</head>";
/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_eblagh']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($shomare_eblagh)   $temp.=" AND shomare_eblagh LIKE '$shomare_eblagh%'";
	 if($mahmule_type)$temp.=" AND e_kh.mahmule_type='$mahmule_type'";
	 if($code_group_kala_top)$temp.=" AND e_kh.code_group_kala_top='$code_group_kala_top'";
	 if($code_ostan)$temp.=" AND T.code_ostan='$code_ostan'";
	 if($shomare_gharardad)   $temp.=" AND T.shomare_gharardad LIKE '%$shomare_gharardad%'";
	 if($temp) {$PageNo=1;$_SESSION['mt_search_help_eblagh']=$temp;} else $_SESSION['mt_search_help_eblagh']="";
    }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_gharardad.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <tr class="title title_search">
  <td align="center">&nbsp;
  شماره قرارداد :&nbsp;<input type="text" class="textboxme" name="shomare_gharardad" value="'.$shomare_gharardad.'"  style="width:50px"/>
  استان :&nbsp;'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'  
  ابلاغ :&nbsp;<input type="text" class="textboxme" name="shomare_eblagh" value="'.$shomare_eblagh.'"  style="width:50px"/>
  <br/>
  نوع محموله  :&nbsp;'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeArr",1,"class='text4'").'  
  گروه کالا :&nbsp;'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'  

  <button align="left" class="buttonme" type="submit" name="Search_x" id="sabt"> جستجو &nbsp;<span class="fa fa-search "></span></button>';
   if ($_SESSION['mt_search_help_eblagh']) echo'<button type="button" class="buttonme" onClick="window.location=\''.$FileName.'?parentFileName='.$parentFileName.'&open_filter=1\'">نمايش همه &nbsp;<span class="fa fa-clipboard"></span></button>';
   echo'
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=5%>رديف</td>
	 <td width=10%>شناسه قرارداد</td>
	 <td width=15%>شماره قرارداد</td>
	 <td width=15%>مقدار قرارداد</td>
	 <td width=15%>استان</td>
	 <td width=15%>شماره ابلاغ</td>
	 <td width=15%>نوع محموله</td>
	 <td width=10%>گروه کالا</td>
	</tr>';
	/*************END SEARCH ******/
   $Cntr=0;
   
   //IF(($parentFileName=='sanad_varede_kharid.php')OR($parentFileName=='pardakhti_list.php'))
   IF(($parentFileName=='sanad_varede_kharid.php'))
	  $condition=" AND T.termination!=1";
   ELSE//قراردادهایی که بازهستند
   	  $condition=" AND T.termination=1";

	$q1="SELECT T.*,kala.name_kala,kala.code_bastebandy,d_kh.shomare_dastorolamal,shomare_eblagh,e_kh.mahmule_type,
	     mt_skk.name_skk,ostan.name_ostan,e_kh.code_group_kala_top,name_group_kala_top
	     From meat.$TableName T 
		 INNER JOIN meat.sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
	     INNER JOIN meat.dastorolamal_kharid d_kh ON T.id_dastorolamal=d_kh.id_dastorolamal
	     INNER JOIN meat.eblagh_kharid e_kh ON d_kh.id_eblagh=e_kh.id_eblagh
		 INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		 INNER JOIN meat.mt_skk ON T.code_skk=mt_skk.code_skk
		 INNER JOIN meat.ostan ON T.code_ostan=ostan.code_ostan
		 LEFT JOIN meat.kala ON T.code_kala=kala.code_kala
		 WHERE 1=1 ".$_SESSION['mt_search_help_eblagh']." $condition_ostan $condition AND T.deleted=0 ORDER BY id_gharardad DESC";
   $all = $db->query($q1);
   while($row1=$db->fetch_assoc($all))
   {
	 $exist_elhaghie=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND gheymat_elhaghie>0 AND deleted=0 ");
     if($exist_elhaghie>0)//اگر الحاقیه دارد
     {
      $gheymat_elhaghie=$db->get_from_where("gheymat_elhaghie","meat.elhaghie_kharid","id_gharardad='".$row1['id_gharardad']."' AND gheymat_elhaghie>0 AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
      $akharin_gheymat=$gheymat_elhaghie;
     }
     else//اگر الحاقیه ندارد
     {
      $akharin_gheymat=$row1['gheymat_har_kilo'];
      IF($row1['gheymat_har_kilo']=='0') { $akharin_gheymat=$db->get_from_where("gheymat_kharid","meat.gheymat_kharid","id_dastorolamal='".$row1['id_dastorolamal']."' AND deleted=0 ");}
     }
     //محاسبه مانده مقدار جهت پرداخت
     $meghdar_gharardad=$row1['meghdar_gharardad'];	
     $mazad_gharardad=$row1['mazad_gharardad'];	
     $meghdar_gharardad_nahayi=$row1['meghdar_gharardad']+$row1['mazad_gharardad'];
     $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","meat.pardakht_gharardad","id_gharardad='".$row1['id_gharardad']."' AND deleted=0 AND pardakht_type=1");
     
     $mande_meghdar=$meghdar_gharardad_nahayi-$sum_meghdar_pardakhti;
     $mande_meghdar=round($mande_meghdar,3);
     //محاسبه مانده مبلغ جهت پرداخت
     //$mablagh_kol=$meghdar_gharardad_nahayi*$akharin_gheymat;
     $mablagh_kol_array=compute_ghardad_payment($row1['id_gharardad'],$db); 
     $mablagh_kol=($mablagh_kol_array[1] +($row1['meghdar_gharardad_avaliye']+$row1['mazad_gharardad']-$mablagh_kol_array[0])*$akharin_gheymat);
	 $sum_mablagh_pardakht=$db->get_from_where("SUM(mablagh_pardakht)","meat.pardakht_gharardad","id_gharardad='".$row1['id_gharardad']."' AND deleted=0 ");
	 $mande_pardakht=$mablagh_kol-$sum_mablagh_pardakht;
     //قوطی-کنسرو مرغ
     if($row1['code_group_kala_top']==6) $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6  AND r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0");
     //کارتن یا لاشه
     else $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row1['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND  r_k_d.code_ostan=".$row1['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0"); 
     $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
     //مانده قرارداد
     $mande_tahvily_gharardad=$row1['meghdar_gharardad']+$row1['mazad_gharardad']-round($sum_tahvily_gharardad,3);
     $mande_tahvily_gharardad=round($mande_tahvily_gharardad,3);	 

	 $editclick="onclick='substitute(\"".$row1['id_gharardad']."\" ,\"".$row1['shomare_gharardad']."\",\"".$akharin_gheymat."\",\"".$row1['meghdar_gharardad']."\",\"".$row1['mazad_gharardad']."\",\"".$meghdar_gharardad_nahayi."\",\"".virgul($mablagh_kol)."\",\"".$sum_tahvily_gharardad."\",\"".$mande_meghdar."\",\"".virgul($mande_pardakht)."\",\"".($mande_tahvily_gharardad)."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['id_gharardad'].'</td>
	  <td '.$editclick.'>'.$row1['shomare_gharardad'].'</td>
	  <td '.$editclick.'>'.($row1['meghdar_gharardad']).'</td>
	  <td '.$editclick.'>'.$row1['name_ostan'].'</td>
	  <td '.$editclick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$editclick.'>'.$mahmuletypeArr[$row1['mahmule_type']].'</td>
	  <td '.$editclick.'>'.$row1['name_group_kala_top'].'</td>

';
	 echo '
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</div>
</form>
</body>
</html>';	
?>