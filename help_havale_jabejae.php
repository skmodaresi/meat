<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_havale_jabejae.php";
$radif=1;
$titr='لیست حواله های مرتبط';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
//هر کدام از فیلدها در مقصد نباشد درست کار نمیکند
function substitute(id,cd_os,nm_os,cd_an,nm_an,sh_h,ost_anb,sh_j,sh_bar,date_bar,pl1,pl2,pl3,pl4,cd_k,vazn,n_kh,kh,nerkh_bas,year)
{
 window.opener.document.myform.id_havale.value=id;
 window.opener.document.myform.code_ostan_mabda.value=cd_os;
 window.opener.document.myform.name_ostan_mabda.value=nm_os;
 window.opener.document.myform.code_anbar_mabda.value=cd_an;
 window.opener.document.myform.name_anbar_mabda.value=nm_an;
 window.opener.document.myform.shomare_havale_anbar.value=sh_h;
 window.opener.document.myform.ostan_anbar_mabda.value=ost_anb;
 window.opener.document.myform.shomare_jabejae.value=sh_j;
 window.opener.document.myform.barname_no.value=sh_bar;
 window.opener.document.myform.barname_tarikh.value=date_bar;
 window.opener.document.myform.plak1.value=pl1;
 window.opener.document.myform.plak2.value=pl2;
 window.opener.document.myform.plak3.value=pl3;
 window.opener.document.myform.plak4.value=pl4;
 //window.opener.document.myform.code_kala.value=cd_k;
 //window.opener.document.myform.vazn_mabda.value=vazn;
 window.opener.document.myform.noe_khodro.value=n_kh;
 window.opener.document.myform.khodro.value=kh;
 window.opener.document.myform.havale_year.value=year;
 //window.opener.document.myform.nerkh_baskul_this.value=nerkh_bas;
 //window.opener.document.myform.mablagh_baskul.value=nerkh_bas;
 //برای اینکه تابع روی کد کالا کار کند فوکوس رو روی کد کالا میگذارم
 //window.opener.document.myform.code_kala.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_ostan.focus();">
<form method="post" name="myform">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">'; 
 if(!$Search_x)
 {
   if($mt_gl_code_anbar==301) $Condition='AND code_ostan='.$mt_gl_code_ostan.'';//anbar movaghat only my ostan
   $code_ostan=$mt_gl_code_ostan;//default my ostan
   echo'
	<tr> 
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="4" align="center">جستجوی لیست حواله ها</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr><td align="left" width="50%"> استان مبدأ :&nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 $Condition  ORDER BY name_ostan ASC","class='text4'","").'</td></tr>
	   <tr><td align="left" width="50%"> سال حواله :&nbsp;</td><td align="right">'.listbox("havale_yr",$mtActiveYear,"year","year","mt_docs","status=0 ORDER BY year","class='text4'","").'</td></tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="4" align="center" class="title">
		 <input class="buttonme" type="submit" id="sabt" name="Search_x" value="جستجو" >
        </td>
       </tr>
	  </table>
	 </td>
    </tr>';
  }
else
{
  	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_havale_jabejae']="";
    } 
    if(isset($Search_x))
    {
        $Mode="";
        $Search_x="";
        $temp="";
        if($code_ostan)  $temp.=" and havale.code_ostan LIKE '$code_ostan'";
        if($temp) {$PageNo=1;$_SESSION['mt_search_havale_jabejae']=$temp;} else $_SESSION['mt_search_havale_jabejae']="";
     
    }
	/*************END SEARCH ******/
	 $i=0;
	 $query_find = $db->query("set session group_concat_max_len=250000");
	 //not in:اگر رسیدی وجود ندارد 
	 $count_resid_jabejae=$db->get_from_where("COUNT(*)","resid","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)");
	 IF($count_resid_jabejae>0)
	 {
	   $q1="SELECT havale.id,havale.code_ostan,havale.code_anbar,havale.year,havale.shomare_havale_anbar,havale.tarikh_havale_anbar,havale.shomare_jabejae,havale.code_kala,havale.shomare_barname_h,havale.tarikh_barname_h,havale.plak1,havale.plak2,havale.plak3,havale.plak4,havale.noe_khodro,havale.vazn_khales_h,havale.tedad_karton_h,mojavez_jabejae.meghdar_jabejae,mojavez_jabejae.mande_az_jabejae,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar
        FROM mojavez_jabejae
        INNER JOIN havale ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year
        INNER JOIN kala ON havale.code_kala = kala.code_kala
        INNER JOIN ostan ON havale.code_ostan = ostan.code_ostan
        INNER JOIN list_sardkhane ON havale.code_anbar = list_sardkhane.code_anbar AND havale.code_ostan=list_sardkhane.code_ostan 
		WHERE 1=1 ".$_SESSION['mt_search_havale_jabejae']." AND kala.code_bastebandy=".$code_bastebandy." AND code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$havale_yr AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1
		AND not find_in_set(havale.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year>=$havale_yr AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))ORDER BY havale.tarikh_havale_anbar,havale.shomare_havale_anbar";	 
	 }
     ELSE
     {
	  $q1="SELECT havale.id,havale.code_ostan,havale.code_anbar,havale.year,havale.shomare_havale_anbar,havale.tarikh_havale_anbar,havale.shomare_jabejae,havale.code_kala,havale.shomare_barname_h,havale.tarikh_barname_h,havale.plak1,havale.plak2,havale.plak3,havale.plak4,havale.noe_khodro,havale.vazn_khales_h,havale.tedad_karton_h,mojavez_jabejae.meghdar_jabejae,mojavez_jabejae.mande_az_jabejae,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar
        FROM mojavez_jabejae
        INNER JOIN havale ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year
        INNER JOIN kala ON havale.code_kala = kala.code_kala
        INNER JOIN ostan ON havale.code_ostan = ostan.code_ostan
        INNER JOIN list_sardkhane ON havale.code_anbar = list_sardkhane.code_anbar AND havale.code_ostan=list_sardkhane.code_ostan 
		WHERE 1=1 ".$_SESSION['mt_search_havale_jabejae']." AND kala.code_bastebandy=".$code_bastebandy." AND code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$havale_yr AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='1395/03/01' 
		AND(havale.id NOT IN(SELECT id_havale FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year>=$havale_yr AND code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))ORDER BY havale.tarikh_havale_anbar,havale.shomare_havale_anbar";
	 }
     // else
     // {$q1="SELECT havale.id,havale.code_ostan,havale.code_anbar,havale.shomare_havale_anbar,havale.tarikh_havale_anbar,havale.shomare_jabejae,havale.code_kala,havale.shomare_barname_h,havale.tarikh_barname_h,havale.plak1,havale.plak2,havale.plak3,havale.plak4,havale.noe_khodro,havale.vazn_khales_h,mojavez_jabejae.meghdar_jabejae,mojavez_jabejae.mande_az_jabejae,kala.name_kala,ostan.name_ostan,list_sardkhane.name_anbar
        // FROM mojavez_jabejae
        // INNER JOIN havale ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year
        // INNER JOIN kala ON havale.code_kala = kala.code_kala
        // INNER JOIN ostan ON havale.code_ostan = ostan.code_ostan
        // INNER JOIN list_sardkhane ON havale.code_anbar = list_sardkhane.code_anbar AND havale.code_ostan=list_sardkhane.code_ostan 
		// WHERE 1=1 ".$_SESSION['mt_search_havale_jabejae']." AND kala.code_bastebandy=".$code_bastebandy." AND code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar between '1395/10/01' AND '1395/12/30'  
		// AND(havale.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))ORDER BY havale.tarikh_havale_anbar,havale.shomare_havale_anbar";
     // }
	 $all= $db->query($q1);	 
	 if(mysql_num_rows($all)>0)
	 {
	  echo'	
      <tr><td class="title">لیست حواله های مرتبط</td></tr>
	  <tr><td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search&code_bastebandy='.$code_bastebandy.'\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td></tr>
	  <tr>
       <td height="100%">
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	     <tr class=table-title>
	      <td rowspan="2" width=3%>رديف</td>
	      <td rowspan="2" width=5%>شماره حواله</td>
	      <td rowspan="2" width=5%>تاریخ</td>
	      <td rowspan="2" width=8%>استان مبدأ</td>
	      <td rowspan="2" width=8%>انبار مبدأ</td>
	      <td rowspan="2" width=7%>کالا</td>
	      <td rowspan="2" width=7%>مقدار حواله</td>
	      <td rowspan="2" width=7%>شماره مجوز</td>
	      <td rowspan="2" width=7%>مقدار مجوز</td>
	      <td rowspan="2" width=8%>پلاک خودرو</td>
	      <td rowspan="2" width=5%>سال</td>
	      <td colspan="7" width=30%>جزئیات کالا</td>
	     </tr>
	     <tr class=table-title>
	   	  <td width="">کشور</td>
	   	  <td width="">تولیدکننده</td>
	   	  <td width="">سال</td>
	   	  <td width="">ماه</td>
	   	  <td width="">روز</td>
	   	  <td width="">تاریخ ماندگاری</td>
	   	  <td width="">وزن کارتن</td>
	     </tr>';
         while($row=$db->fetch_assoc($all))
         {
	       $tedaddetail=$db->get_from_where("count(code_kala)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND shomare_havale_anbar='".$row['shomare_havale_anbar']."'");//تعداد      
	       if($tedaddetail>0)$rowdetail=$tedaddetail;
	       else $rowdetail=1;//detail empty
	       $t=$rowdetail;
	 
	 
	       //نرخ باسکول با انتخاب خودرو
           $res1_1=$db->query("SELECT sh_jadval_baskul FROM hazine_baskul WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_baskul DESC LIMIT 0,1");//شماره آخرین جدول هزینه باسکول
           if(mysql_num_rows($res1_1)>0)
           {
            $row1_1=$db->fetch_assoc($res1_1);
            $res_bas=mysql_query("SELECT nerkh_baskul FROM hazine_baskul_detail WHERE sh_jadval_baskul=".$row1_1['sh_jadval_baskul']." AND noe_khodro=".$row['noe_khodro']." AND code_ostan='$mt_gl_code_ostan'");
            $row_bas=mysql_fetch_assoc($res_bas);
           }
	       if(strlen($row['code_ostan'])==1) $code_os_m=make_pattern($row['code_ostan'],2);
	       $ostan_anbar=$code_os_m.$row['code_anbar'];
	       //بسته بندی :دست
	       IF($code_bastebandy==5)$meghdar_havale=$row['tedad_karton_h'];
	       ELSE $meghdar_havale=$row['vazn_khales_h'];
	       $editclick="onclick='substitute(\"".$row['id']."\",\"".$row['code_ostan']."\",\"".$row['name_ostan']."\",\"".$row['code_anbar']."\",\"".$row['name_anbar']."\",\"".$row['shomare_havale_anbar']."\",\"".$ostan_anbar."\",\"".$row['shomare_jabejae']."\",\"".$row['shomare_barname_h']."\",\"".$row['tarikh_barname_h']."\",\"".$row['plak1']."\",\"".$row['plak2']."\",\"".$row['plak3']."\",\"".$row['plak4']."\",\"".$row['code_kala']."\",\"".$meghdar_havale."\",\"".$row['noe_khodro']."\",\"".$khodroArr[$row['noe_khodro']]."\",\"".$row_bas['nerkh_baskul']."\",\"".$row['year']."\")'";
	       if($i++%2) echo'<tr class="table-odd"/>';
           else echo '<tr class="table-even" />';
           if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
           else $code_a=$row['code_ostan'];
	       echo'
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$radif++.'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$code_a.$row['code_anbar'].$row['shomare_havale_anbar'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['tarikh_havale_anbar'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['name_ostan'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['name_anbar'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['name_kala'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$meghdar_havale.'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['shomare_jabejae'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['meghdar_jabejae'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'><sup>ایران</sup> '.$row['plak1'].'-'.$row['plak2'].''.$row['plak3'].''.$row['plak4'].'</td>
	       <td rowspan="'.$rowdetail.'" '.$editclick.'>'.$row['year'].'</td>';
	      /**///حلقه روی جزئیات حواله
	       $q2="SELECT *
			   FROM havale_detail h_d 
			   INNER JOIN $mydatabase.keshvar ON h_d.code_keshvar=keshvar.code_keshvar    
			   INNER JOIN $mydatabase.tolidkonande ON h_d.code_tolidkonande=tolidkonande.code_tolidkonande    
			   INNER JOIN $mydatabase.tarikh_mandegari ON h_d.code_mandegari=tarikh_mandegari.code_mandegari
			   LEFT  JOIN $mydatabase.karton ON h_d.code_karton=karton.code_karton
			   WHERE h_d.code_ostan=".$row['code_ostan']." AND h_d.code_anbar=".$row['code_anbar']." AND h_d.year=".$row['year']." AND h_d.shomare_havale_anbar='".$row['shomare_havale_anbar']."'";
	       $res2=$db->query($q2);
	       if(mysql_num_rows($res2)>0)
	      { 
	       while($row2=$db->fetch_assoc($res2))
		   {	   
			$j=$i+1;
			 echo'
	         <td '.$editclick.'>'.$row2['name_keshvar'].'</td>
	         <td '.$editclick.'>'.$row2['name_tolidkonande'].'</td>
	         <td '.$editclick.'>'.$row2['sal_tolid_shamsi'].'</td>
	         <td '.$editclick.'>'.$mahshamsiArr[$row2['mah_tolid_shamsi']].'</td>
	         <td '.$editclick.'>'.$row2['rouz_tolid_shamsi'].'</td>
	         <td '.$editclick.'>'.$row2['sharh_mandegari'].'</td>
	         <td '.$editclick.'>'.$row2['vazn_karton_this'].'</td>';

			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2) echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			  }
		    }//END haval_detail while
	       }
	 echo '
	 </tr>';
	}
   echo'
   </table>
  </td>
 </tr>'; 
}
else{echo '<div class="title"><div style="float:right;">اطلاعاتی یافت نشد</div>
           <div onClick="window.location=\'help_havale_jabejae.php?parent_page=resid_new.php&code_bastebandy='.$code_bastebandy.'\'" id="btn-back" style="float:left;"  title="بازگشت"><a href="#"></a></div>
           <!--<div onClick="window.location=\''.$FileName.'&code_bastebandy='.$code_bastebandy.'\'" id="btn-back" style="float:left;"  title="بازگشت"><a href="#"></a></div>-->
</div>';}	
}
echo' 
</table>
</form>
</body>
</html>';	
?>