<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_mojody_kala.php";
$TableName="mojavez_jabejae";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='مجوزهای جابه جایی';
require_once('head.html');
$radif=1;
$page=1;
$line=0;
$i=0;$cntr=0;
$MaxLines=25;
/***************************************** MAIN*****************************************/
$columns='	
    <tr class="print_table-title">
	 <td width="3%">رديف</td>
	 <td width="10%">شماره مجوز</td>
	 <td width="7%">تاریخ مجوز</td>
	 <td width="13%">نام کالا</td>
	 <td width="5%">واحد</td>
	 <td width="7%">استان مقصد</td>
	 <td width="13%">انبارمقصد</td>
	 <td width="12%">نام مشتری</td>
	 <td width="8%">مقدار مجوز</td>
	 <td width="8%">مقدار تحویلی</td>
	 <td width="6%">مقدار باطله</td>
	 <td width="8%">مقدار مانده</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$page;
 echo'   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>';
	   echo'
	   <tr><td class="print_title_2">';  
		 IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo $titr.' &nbsp&nbsp(صفحه : '.$page.')';
	     echo'
	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
	echo $columns;
}	
echo'
<div class="table2excel">
<body>
<br>';
 print_header();
 echo'
 <!--پايان هدر-->
 <!-- مرکز صفحه-->';
   if($_SESSION['mt_systemforush']==0)//سردخانه
   {	
	$q1="SELECT $TableName.*,kala.code_bastebandy,kala.name_kala,name_group_kala,ostan.name_ostan,list_sardkhane.name_anbar,moshtary.name_customer From $TableName
         LEFT JOIN moshtary ON $TableName.code_customer=moshtary.code_customer
         LEFT JOIN kala ON $TableName.code_kala=kala.code_kala
         LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
         LEFT JOIN ostan ON $TableName.code_ostan_maghsad_j=ostan.code_ostan
         LEFT JOIN list_sardkhane ON $TableName.code_ostan_maghsad_j=list_sardkhane.code_ostan AND $TableName.code_anbar_maghsad_j=list_sardkhane.code_anbar
		 LEFT JOIN group_kala ON group_kala.code_group_kala=kala.code_group_kala
		 WHERE 1=1 ".$_SESSION['mt_search_jabejae']." AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND deleted=0 order by tarikh_jabejae";
	}
   if($_SESSION['mt_systemforush']==1)//فروش
   {
	$q1="SELECT $TableName.*,kala.code_bastebandy,name_kala,name_group_kala,sharh_vahedkala,ostan.name_ostan,list_sardkhane.name_anbar,sell.dm_customer_asli.name_customer From $TableName
         LEFT JOIN sell.dm_customer_asli ON $TableName.code_customer=sell.dm_customer_asli.code_customer
         INNER JOIN kala ON $TableName.code_kala=kala.code_kala
         INNER JOIN vahed_kala ON vahed_kala.code_vahedkala=kala.code_vahedkala
         INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
		 LEFT JOIN ostan ON $TableName.code_ostan_maghsad_j=ostan.code_ostan
         LEFT JOIN list_sardkhane ON $TableName.code_ostan_maghsad_j=list_sardkhane.code_ostan AND $TableName.code_anbar_maghsad_j=list_sardkhane.code_anbar
		 LEFT JOIN group_kala ON group_kala.code_group_kala=kala.code_group_kala
		 WHERE 1=1 ".$_SESSION['mt_search_jabejae']." AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND deleted=0 ORDER BY tarikh_jabejae";
   
   }
   $alljabejae = mysql_query($q1);
   $cntr =mysql_num_rows($alljabejae);
   while($row1=mysql_fetch_assoc($alljabejae))
   {
	 //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	 $meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_bastebandy']);
     //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	 $maghadir_batele_j=batele_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);	 
	 $line++;
     if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$radif++.'</td>
	  <td >'.$row1['shomare_jabejae'].'</td>
      <td >'.$row1['tarikh_jabejae'].'</td>
      <td >'.$row1['name_kala'].'</td>
      <td >'.$row1['sharh_vahedkala'].'</td>
      <td >'.$row1['name_ostan'].'</td>
      <td >'.$row1['name_anbar'].'</td>
	  <td >'.$row1['name_customer'].'</td>
	  <td >'.round($row1['meghdar_jabejae'],3).'</td>
	  <td >'.round($meghdar_tahvily_j,3).'</td>
	  <td >'.round($maghadir_batele_j,3).'</td>
	  <td >'.round($row1['mande_az_jabejae'],3).'</td>
	 </tr>';
	  if ($line>=$MaxLines && $i <$cntr) 
	  {
		 $line=0;
         $page++;
	     echo'
		   </table>
		   <br class="pbreak">';
		   print_header();
	  }	
	}
echo'
<!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->';
  require_once('prt-footer.php');
 echo' 	 
</table>
</div>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>