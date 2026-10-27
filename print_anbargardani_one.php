<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_anbargardani_one.php";
$TableName="mt_anbargardani";
$today=AsLDate($yymmdd);
$logtime=date('H:i:s');
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ انبارگردانی</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<br/>
<table width="850px" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
  <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">انبارگردانی
		    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	 </td>
	</tr>	
   </table>
  </td>
 </tr> 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="#747474">';
   $q1="SELECT T.*,kala.name_kala,l_a_d.noe_ziranbar,l_a_d.name_ziranbar,tolidkonande.name_tolidkonande,keshvar.name_keshvar From $TableName T 
        INNER JOIN kala ON T.code_kala=kala.code_kala
        INNER JOIN keshvar ON T.code_keshvar=keshvar.code_keshvar
	    INNER JOIN tolidkonande ON T.code_tolidkonande=tolidkonande.code_tolidkonande AND tolidkonande.code_ostan=T.code_ostan
           LEFT JOIN list_sardkhane_detail l_a_d ON T.code_ziranbar=l_a_d.code_ziranbar AND T.code_ostan=l_a_d.code_ostan AND T.code_anbar=l_a_d.code_anbar  	  
		  WHERE T.id='$id_' AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0";
	 
	$res1=$db->query($q1);
    $row1=$db->fetch_assoc($res1);
	//اگر کد استان یک رقمی بود
	if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
    else $code_a=$row1['code_ostan'];
    //موجودی کالا با  تابع
	 $tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 $mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton']);
	 
	echo'
	  <tr class="print_tr1">
	   <td colspan="2">
        <table border=0  width=100%>
	     <tr><td align="right"> شماره برگه : '.$code_a.$row1['code_anbar'].$row1['shomare_anbargardani'].'</td>
	         <td align="right"> تاريخ برگه : '.$row1['tarikh_anbargardani'].'</td>
	         <td align="right"> شمارش : '.$shomareshArr[$row1['shomaresh']].'</td>	 
		 </tr>
	    </table>
	   </td>
	  </tr>
	  <tr class="print_tr1">
	   <td colspan="" valign="top" width="50%">
         <fieldset class="print-fieldset">
	      <legend>اطلاعات کالا</legend>
	       <table width="100%" height="110px">
		    <tr>
			 <td align="right"> کد کالا : '.$row1['code_kala'].'</td>
	         <td align="right">نام کالا : '.$row1['name_kala'].'</td>
		    </tr>
	        <tr>
		     <td align="right"> نوع زیرانبار : '.$ziranbarArr[$row1['noe_ziranbar']].'</td>
		     <td align="right"> نام زیرانبار : '.$row1['name_ziranbar'].'</td>
		    </tr>
	        <tr>
		     <td align="right"> کشور : '.$row1['name_keshvar'].'</td>
		     <td align="right"> تولیدکننده : '.$row1['name_tolidkonande'].'</td>
		    </tr>
	        <tr>
			   <td align="right" colspan="2"> تاریخ تولید شمسی  :&nbsp;
	     	        سال : '.$row1['sal_tolid_shamsi'].'
					ماه : '.$mahshamsiArr[$row1['mah_tolid_shamsi']].'
	     	   	    روز : '.$row1['rouz_tolid_shamsi'].'
			   </td>
		    </tr>
		   </table>
		  </fieldset>
		  <fieldset class="print-fieldset">
	      <legend>مقادیر موجودی</legend>
	       <table width="100%" height="110px">
 			<tr><td align="right"> تعداد : '.virgul($tedad_karton).'</td></tr>
			<tr><td align="right"> وزن ناخالص : '.round($mojody_nakhales,3).'</td></tr>
			<tr><td align="right"> وزن خالص : '.round($mojody_khales,3).'</td></tr>
		   </table>	
          </fieldset>
       </td>
	   <td valign="top" width="50%">
	     <fieldset class="print-fieldset">
	      <legend>اطلاعات ناظرین</legend>
	       <table width="100%" height="110px">
            <tr>
			 <td align="right"><span> ناظر اول : </span>نام : '.$row1['nazer_aval_name'].'</td>
			 <td align="right"> نام خانوادگی : '.$row1['nazer_aval_lastname'].'</td>
		    </tr>
            <tr>
			 <td align="right"><span>ناظر دوم : </span>نام : '.$row1['nazer_dovom_name'].'</td>
			 <td align="right">نام خانوادگی : '.$row1['nazer_dovom_lastname'].'</td>
		    </tr>
            <tr>
			 <td align="right"><span>ناظر سوم : </span>نام : '.$row1['nazer_sevom_name'].'</td>
			 <td align="right">نام خانوادگی : '.$row1['nazer_sevom_lastname'].'</td>
		    </tr>
		   </table>	
          </fieldset>
		  <fieldset class="print-fieldset">
	      <legend>مقادیر انبارگردانی</legend>
	       <table width="100%" height="110px">
 			<tr><td align="right"> تعداد انبارگردانی : '.virgul($row1['karton_anbargardani']).'</td></tr>
			<tr><td align="right"> وزن ناخالص انبارگردانی : '.round($row1['nakhales_anbargardani'],3).'</td></tr>
			<tr><td align="right"> وزن خالص انبارگردانی : '.round($row1['khales_anbargardani'],3).'</td></tr>
	        <tr><td align="right"> توضيحات : '.$row1['tozihat_anbargardani'].'</td></tr>
		   </table>	
          </fieldset>
	   </td>
	  </tr>
   </table>
  </td>
 </tr>
 <!-- چاپ زیرنویس-->
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <tr>
  <td>
   <table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
    <tr class="print_footer">
     <td>نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>';
      if($row1['signiture_anbargardani']!='')
      {
           $signarray =explode(';',$row1['signiture_anbargardani']);
        foreach($signarray as $signID)
        {
         $sql_q ="select mt_typesign.manager,mt_dpt.dpt_name from mt_typesign INNER JOIN mt_dpt ON mt_typesign.dpt_id=mt_dpt.dpt_id AND mt_typesign.code_ostan=mt_dpt.code_ostan AND mt_typesign.code_anbar=mt_dpt.code_anbar where sign_id=$signID order by turn";
         $sql_res=mysql_query($sql_q);
         $row_n=mysql_fetch_assoc($sql_res);
         echo '<td>'.$row_n['dpt_name'].' :&nbsp;&nbsp;'.$row_n['manager'].'</td>';
        }
      }
      echo'
    </tr>';
    //تعداد توضیحات	
    $tozihCount=$db->get_from_where("count(*)","mt_typetozih","type_id='5' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
    if($tozihCount>0)
    {
  	    echo'
  	    <tr class="print_footer">';
  	    $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='5' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."'");	
          while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
          echo'</tr>';
    }  
    echo'
   </table>
  </td>
 </tr>
 </table>	
</body>
</html>';
?>