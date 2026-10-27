<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_khorooj.php";
$TableName="havale";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='چاپ برگه خروج';
if((isset($clk_p_kh))and(!(SuperUser())))
{
 $prt_khorooj_count=$db->get_from_where("prt_khorooj_count","$TableName","id=$id_");     
 $prt_khorooj_count++;
 $edit_print=("UPDATE $TableName SET prt_khorooj_count='$prt_khorooj_count' WHERE id='$id_';");
 $print_res=mysql_query($edit_print);
 if($print_res) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','چاپ برگه خروج',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/}
}
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
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
//برای هر دو سیستم انبار و فروش
  $q1=("SELECT $TableName.*,kala.code_kala,kala.name_kala FROM $TableName INNER JOIN kala ON $TableName.code_kala=kala.code_kala WHERE $TableName.id='$id_'");	
  $res1=$db->query($q1);
  $row1=$db->fetch_assoc($res1);
  if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
  else $code_a=$row1['code_ostan'];
  if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6))//اگر نوع تحویل بار جابه جایی 
  {
    $q_jabejae=("SELECT m_j.*,ostan.name_ostan,list_sardkhane.name_anbar,mt_skk.code_skk,mt_skk.name_skk FROM mojavez_jabejae m_j
                  LEFT JOIN ostan ON ostan.code_ostan=m_j.code_ostan_maghsad_j           
                  LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=m_j.code_anbar_maghsad_j AND list_sardkhane.code_ostan=m_j.code_ostan_maghsad_j 
				  LEFT JOIN mt_skk ON mt_skk.code_skk=m_j.code_skk           
				  WHERE m_j.shomare_jabejae='".$row1['shomare_jabejae']."' AND m_j.code_ostan='".$row1['code_ostan']."' AND m_j.code_anbar='".$row1['code_anbar']."' AND m_j.year='".$row1['year']."' AND m_j.deleted=0");	
    $res_jabejae=$db->query($q_jabejae);
    $row_jabejae=$db->fetch_assoc($res_jabejae);
    $code_customer=$row_jabejae['code_customer'];
  }
  else
  {
   //اگر سیستم سردخانه
   if($_SESSION['mt_systemforush']==0)
   { 
    //بدست آوردن تاریخ ومقدار حواله فروش
     $q_havale_forush="SELECT h_reg_date,code_customer FROM havale_forush WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
     $res_havale_forush=mysql_query($q_havale_forush);
     $row_havale_forush=mysql_fetch_array($res_havale_forush);
     $tarikh_forush=$row_havale_forush['h_reg_date'];
     $code_customer=$row_havale_forush['code_customer'];
    }
    //اگر سیستم فروش  
    else
   {  
     mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
     // //پیدا کردن آی دی کد استان مربوط به سیتم فروش
      // $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
      // $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
     // //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
      // $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
      // $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
     // //پیدا کردن آی دی سال مربوط به سیستم فروش
      // $sellYearCode=substr($mtActiveYear,2);
      // $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
      // $sellYearId=mysql_result($res_sal, 0, 'year_id');
      //بدست آوردن تاریخ ومقدار حواله فروش
      $q_havale_forush="SELECT h_reg_date,h_customer_code FROM dm_havale WHERE h_code='".$row1['h_code']."'  AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
      $res_havale_forush=mysql_query($q_havale_forush);
      $row_havale_forush=mysql_fetch_array($res_havale_forush);
     //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row_havale_forush['h_reg_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
       $code_customer=$row_havale_forush['h_customer_code']; 
    }
  }
  //بدست آوردن نام مشتری
  $name_customer=customer($code_customer);//تابع
echo'
<body>';
//for($i=1;$i<=3;$i++)//سه نسخه برای چاپ
//{
echo'	
<br/>
<table width="95%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">برگه خروج کالا نسخه ی : '.$mt_gl_name_anbar.' &nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'
	     <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	    </td>
	</tr>
   </table>
  </td>
 </tr> 	 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="print_tr1" style="line-height:30px;">
	 <td>
      <table border="0" width=100%>
	   <tr>
        <td align="right"> شماره برگه خروج : '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].'</td>   
        <td align="right"> شماره حواله سردخانه : '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].'</td>';  
         //اگر نوع تحویل  بار جابه جایی باشد
	     if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6))
		 {echo'	   
	      <td align="right"> شماره مجوز جابه جایی : '.$row1['shomare_jabejae'].'</td>';
         }
         else
         {echo'<td align="right"> شماره حواله فروش : '.$row1['h_code'].'</td>';}		 
	   echo'
	   </tr>
	   <tr>
	   	<td align="right"> تاریخ خروج : '.$today.' </td>
	   	<td align="right"> ساعت خروج :  '.$logtime.'</td>
	    <td align="right"> پلاک خودرو : <sup>ایران</sup> '.$row1['plak1'].'-'.$row1['plak2'].''.$row1['plak3'].''.$row1['plak4'].'';if($row1['shomare_kamiyon_h'])   echo' /'.$row1['shomare_kamiyon_h'].'';echo'</td>
	   </tr>
	   <tr>
	    <td align="right">نام کالا : '.$row1['name_kala'].'</td>
	    <td align="right"> تعداد : '.virgul($row1['tedad_karton_h']).'</td>
	    <td align="right"> وزن خالص : '.round($row1['vazn_khales_h'],3).'</td>
	   </tr>
	   <tr>';
	   if($row1['noe_tahvil_bar']==4)
	   {echo'
	      <td align="right"> نام استان مقصد : '.$row_jabejae['name_ostan'].'</td>
		  <td align="right"> نام سردخانه مقصد : '.$row_jabejae['name_anbar'].'</td>';
	   }
	   else if($row1['noe_tahvil_bar']==6)
	   {echo'
	      <td align="right">کد کشتی / فروشنده : '.$row_jabejae['code_skk'].'</td>
		  <td align="right">نام کشتی / فروشنده : '.$row_jabejae['name_skk'].'</td>';
	   }
	   else
	   {echo'<td align="right">نام مشتری : '.$name_customer.'</td>';}
	   echo'
	   </tr>
	  </table>
	 </td>
	</tr>
 <!--پايان مرکز صفحه -->
 </table>
</div>
</td>
</tr>
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>	
<!-- چاپ زیرنویس-->
<tr>
 <td>
  <table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
   <tr class="print_footer">
    <td>نام کاربر :&nbsp;'.$mtuserNAME.'</td>';
	 $db->selectDb($mydatabase);
	 // $dc=$db->query("SELECT dpt_id FROM mt_typesign WHERE type_id='4' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."' order by turn");	
     // while ($dr=$db->fetch_array($dc))
     // {
	 // $vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
     // echo '<td>'.$vahed[0].' :&nbsp;'.$vahed[1].'</td>';
     // }
	 if($row1['signiture_khorooj']!='')
	 {
       $signarray =explode(';',$row1['signiture_khorooj']);
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
   $tozihCount=$db->get_from_where("count(*)","mt_typetozih","type_id='4' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
   if($tozihCount>0)
   {
	   echo'
	   <tr class="print_footer">';
	   $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='4' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."'");	
       while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
       echo'</tr>';
   } 
   echo'
  </table>
 </td>
</tr>
</table>';
//}
echo'
</body>
</html>';	
?>