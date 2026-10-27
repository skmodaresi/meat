<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_anbargardani_det.php";
$TableName="mt_anbargardani_detail";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$nameKala=$db->get_from_where("name_kala","kala","code_kala=$code_kala_");
$code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala=$code_kala_");
$titr='جزئیات انبارگردانی کالای '.$nameKala.' سال '.$mtActiveYear.'';
$radif=1;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
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
$columns='	
    <tr class="print_table-title2">
	 <td rowspan="2" width="4%">رديف</td>
	 <td rowspan="2" width="5%">زیرانبار</td>
	 <td rowspan="2" width="4%">کشور</td>
	 <td rowspan="2" width="10%">تولیدکننده</td>
	 <td colspan="3" width="13%">تاریخ تولید</td>
	 <td rowspan="2" width="5%">تاریخ ماندگاری</td>';
	 if($code_bastebandy==1)$columns.='<td rowspan="2" width="5%">وزن کارتن</td><td colspan="3" width="20%">موجودی سیستم</td><td colspan="4" width="20%">موجودی انبارگردانی</td><td colspan="3" width="10%">کسری</td><td colspan="3" width="10%">اضافه</td>';
	 else if($code_bastebandy==2)$columns.='<td rowspan="2" width="5%">وزن قوطی</td><td colspan="2" width="20%">موجودی سیستم</td><td colspan="2" width="20%">موجودی انبارگردانی</td><td colspan="2" width="7%">کسری</td><td colspan="2" width="7%">اضافه</td>';
	 else if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==7))//لاشه یا کیسه یا وکیوم
	 {
	   $columns.='
	   <td colspan="2" width="15%">موجودی سیستم</td>
	   <td colspan="2" width="15%">موجودی انبارگردانی</td>
	   <td colspan="2" width="7%">کسری</td>
	   <td colspan="2" width="7%">اضافه</td>
	   ';
	 }
	 else if(($code_bastebandy==5)or($code_bastebandy==6))//دست یا عدد
	 {
	   $columns.='
	   <td  width="15%">موجودی سیستم</td>
	   <td  width="15%">موجودی انبارگردانی</td>
	   <td  width="7%">کسری</td>
	   <td  width="7%">اضافه</td>
	   ';
	 }
	$columns.='</tr> 
    <tr class="print_table-title2">
	   <td width="%">سال</td>
	   <td width="%">ماه</td>
	   <td width="%">روز</td>
	   <td width="%">تعداد</td>';
	   if($code_bastebandy==1)$columns.='<td width="%">مقدار ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))$columns.='<td width="%">مقدار خالص</td>';
	   $columns.='<td width="%">تعداد</td>';
	   if($code_bastebandy==1)$columns.='<td>وزن کارتنها</td><td width="%">مقدار ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))$columns.='<td width="%">مقدار خالص</td>';
	   $columns.='<td width="%">تعداد</td>';
	   if($code_bastebandy==1)$columns.='<td width="%">ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))$columns.='<td width="%">خالص</td>';
	   $columns.='<td width="%">تعداد</td>';
	   if($code_bastebandy==1)$columns.='<td width="%">ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))$columns.='<td width="%">خالص</td>';
	   $columns.='
	</tr>';
/***************************************** MAIN*****************************************/
$vahed_kala=$db->get_from_where("sharh_vahedkala","vahed_kala INNER JOIN kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=$code_kala_");
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">'.$titr.' (کد کالا :'.$code_kala_.') &nbsp&nbsp(صفحه : 1)
	     <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
		 <span style="float:left;font-size:8pt">واحد کالا : '.$vahed_kala.'</span>
	   </td>
	</tr>
 </table>
<!--پايان هدر-->
<!-- مرکز صفحه-->	
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  '.$columns.'';
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=25;
      $q1="SELECT $TableName.*,kala.name_kala,l_s_d.name_ziranbar,keshvar.name_keshvar,tolidkonande.name_tolidkonande FROM $TableName
		 INNER JOIN kala ON $TableName.code_kala=kala.code_kala 
         INNER JOIN list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
		 INNER JOIN keshvar ON keshvar.code_keshvar=$TableName.code_keshvar  
         INNER JOIN tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
         WHERE $TableName.code_kala='$code_kala_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' order by $TableName.sal_tolid_shamsi,$TableName.mah_tolid_shamsi,$TableName.rouz_tolid_shamsi asc"; 
   
   $q1="SELECT $TableName.id_anbargardani,id_anbargardani_det,id_mojody,$TableName.vazn_karton_this,tedad_anbargardani,sum_karton_anbargardani,nakhales_anbargardani,khales_anbargardani,mojody_kala.*,
         kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,sharh_mandegari 
          From mojody_kala   
          LEFT JOIN  $TableName ON mojody_kala.id=$TableName.id_mojody
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      INNER JOIN tarikh_mandegari ON tarikh_mandegari.code_mandegari=mojody_kala.code_mandegari    
		  WHERE mojody_kala.code_kala='$code_kala_' AND mojody_kala.code_ostan='$mt_gl_code_ostan' AND mojody_kala.code_anbar='$mt_gl_code_anbar' AND mojody_kala.year='$mtActiveYear'
		  order by mojody_kala.sal_tolid_shamsi,mojody_kala.mah_tolid_shamsi,mojody_kala.rouz_tolid_shamsi asc";
   //echo $q1;
   $allMojody = $db->query($q1);
   $cntr =mysql_num_rows($allMojody);
   while($row=$db->fetch_assoc($allMojody))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     //با استفاده از تابع
	 $tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $diffrence_tedad=0;$diffrence_t_kasry=0;$diffrence_t_ezafe=0;
	 $diffrence_nakhales=0;$diffrence_na_kasry=0;$diffrence_na_ezafe=0;
	 $diffrence_khales=0;$diffrence_kh_kasry=0;$diffrence_kh_ezafe=0;
	 IF($row['id_anbargardani_det']) 
	 {$diffrence_tedad=$tedad_karton-$row['tedad_anbargardani'];
	    IF($diffrence_tedad>0)$diffrence_t_kasry=($diffrence_tedad);
	    ELSE IF($diffrence_tedad<0)$diffrence_t_ezafe=abs($diffrence_tedad);
		
		$diffrence_nakhales=$mojody_nakhales-$row['nakhales_anbargardani'];
	    IF($diffrence_nakhales>0)$diffrence_na_kasry=($diffrence_nakhales);
	    ELSE IF($diffrence_nakhales<0)$diffrence_na_ezafe=abs($diffrence_nakhales);
		
		$diffrence_khales=$mojody_khales-$row['khales_anbargardani'];
	    IF($diffrence_khales>0)$diffrence_kh_kasry=($diffrence_khales);
	    ELSE IF($diffrence_khales<0)$diffrence_kh_ezafe=abs($diffrence_khales);
	 }
	 echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row['name_ziranbar'].'</td>
	  <td>'.$row['name_keshvar'].'</td>
	  <td>'.$row['name_tolidkonande'].'</td>
	  <td>'.$row['sal_tolid_shamsi'].'</td>
	  <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	  <td>'.$row['rouz_tolid_shamsi'].'</td>
	  <td>'.$row['sharh_mandegari'].'</td>';
	  if(($code_bastebandy==1)OR($code_bastebandy==2))//کارتن یا قوطی
      echo'<td>'.$row['vazn_karton_this'].'</td>';
	  echo'
	  <td>'.$tedad_karton.'</td>';
	  if($code_bastebandy==1)echo'<td>'.round($mojody_nakhales,3).'</td>';
	  if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($mojody_khales,3).'</td>';
	  echo'<td>'.$row['tedad_anbargardani'].'</td>';
	  if($code_bastebandy==1) echo'<td>'.round($row['sum_karton_anbargardani'],3).'</td><td>'.round($row['nakhales_anbargardani'],3).'</td>';	 
	  if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($row['khales_anbargardani'],3).'</td>';
	  echo'<td>'.$diffrence_t_kasry.'</td>';
	  if($code_bastebandy==1)echo'<td >'.round($diffrence_na_kasry,3).'</td>';
      if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >'.round($diffrence_kh_kasry,3).'</td>';
	  echo'<td >'.$diffrence_t_ezafe.'</td>';
	  if($code_bastebandy==1)echo'<td >'.round($diffrence_na_ezafe,3).'</td>';
	  if(($code_bastebandy!=5)AND($code_bastebandy!=6)) echo'<td >'.round($diffrence_kh_ezafe,3).'</td>
	
	</tr>';
	if($line>=$MaxLines && $i <$cntr) 
	{
	 $line=0;
     $page++;
	 echo'
 </table>
	 <br class="pbreak">
     <br/>
	 <table width="99%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
      <tr><td class="print_title_2">'.$titr.' (کد کالا :'.$code_kala_.') &nbsp&nbsp(صفحه : '.$page.')
	    	</td>
	  </tr>
     </table>
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
     '.$columns.'';
	 }
	 IF($row['id_anbargardani'])$signiture_anbargardani=$db->get_from_where("signiture_anbargardani","mt_anbargardani","id_anbargardani=".$row['id_anbargardani']."");
     $sum_tedad_karton+=$tedad_karton;
     $sum_mojody_nakhales+=$mojody_nakhales;
     $sum_mojody_khales+=$mojody_khales;
	 $sum_tedad_anbargardani+=$row['tedad_anbargardani'];
	 $sum_nakhales_anbargardani+=$row['nakhales_anbargardani'];
	 $sum_mojmo_karton+=$row['sum_karton_anbargardani'];
	 $sum_khales_anbargardani+=$row['khales_anbargardani'];
	 $sum_diffrence_t_kasry+=$diffrence_t_kasry;
	 $sum_diffrence_na_kasry+=$diffrence_na_kasry;
	 $sum_diffrence_kh_kasry+=$diffrence_kh_kasry;
	 $sum_diffrence_t_ezafe+=$diffrence_t_ezafe;
	 $sum_diffrence_na_ezafe+=$diffrence_na_ezafe;
	 $sum_diffrence_kh_ezafe+=$diffrence_kh_ezafe;
	}//END while
   echo'
   	  <tr class="print_table-even sum-row-white-b">';
	   IF(($code_bastebandy==1)or($code_bastebandy==2)) echo'<td id="sum_row" colspan="9">جمع مقادیر</td>';
	   ELSE echo'<td id="sum_row" colspan="8">جمع مقادیر</td>';
	   echo'
	   <td>'.virgul($sum_tedad_karton).'</td>';
	   if($code_bastebandy==1) echo'<td>'.round($sum_mojody_nakhales,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($sum_mojody_khales,3).'</td>';
	   echo'<td>'.virgul($sum_tedad_anbargardani).'</td>';
	   if($code_bastebandy==1) echo'<td>'.round($sum_mojmo_karton,3).'</td><td>'.round($sum_nakhales_anbargardani,3).'</td>';
       if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($sum_khales_anbargardani,3).'</td>';
       echo'<td>'.virgul($sum_diffrence_t_kasry).'</td>';	   
       if($code_bastebandy==1)echo'<td>'.round($sum_diffrence_na_kasry,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($sum_diffrence_kh_kasry,3).'</td>';
       echo'
	   <td>'.virgul($sum_diffrence_t_ezafe).'</td>';
	   if($code_bastebandy==1)echo'<td>'.round($sum_diffrence_na_ezafe,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($sum_diffrence_kh_ezafe,3).'</td>';	   
	  echo'
	  </tr>
	  <tr class="print_footer">
	   <td align="left" colspan="22">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      </tr>
 </table>
<!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
 <tr class="print_footer" style="font-size:8pt;line-height:60px">
    <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.'</td>
  ';
	 if($signiture_anbargardani!='')
	 {
       $signarray =explode(';',$signiture_anbargardani);
	   foreach($signarray as $signID)
	   {
	    $sql_q ="select mt_typesign.manager,mt_dpt.dpt_name from mt_typesign INNER JOIN mt_dpt ON mt_typesign.dpt_id=mt_dpt.dpt_id AND mt_typesign.code_ostan=mt_dpt.code_ostan AND mt_typesign.code_anbar=mt_dpt.code_anbar where sign_id=$signID order by turn";
	    $sql_res=mysql_query($sql_q);
	    $row_n=mysql_fetch_assoc($sql_res);
	    echo '<td>'.$row_n['dpt_name'].' :&nbsp;&nbsp;'.$row_n['manager'].'</td>';
	   }
	 }
  echo'
 </tr>
</table>
</body>
</html>';	
?>