<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_list_sardkhane.php";
$ExcelFileName=str_replace('.php','',$FileName);
$TableName="list_sardkhane";
$titr='سردخانه های شرکت پشتیبانی';
require_once('head.html');
$radif=1;
IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition="";
ELSE  $Condition="AND code_ostan='$mt_gl_code_ostan'";

$columns='
   <tr class="print_table-title2">
	 <td width="3%">رديف</td>
	 <td width="4%">کد سردخانه</td>
	 <td width="5%">کد حسابداری</td>
	 <td width="8%">شناسه یکتا دامپزشکی</td>
	 <td width="4%">شناسه ملی سردخانه</td>
	 <td width="10%">نام سردخانه</td>
	 <td width="5%">استان سردخانه</td>
	 <td width="5%">نوع مالکیت</td>
	 <td width="5%">ظرفیت اسمی</td>
	 <td width="5%">ظرفیت قرادادی</td>
	 <td width="4%">وضعیت پیمانکار</td>
	 <td width="4%">شناسه پیمانکار</td>
	 <td width="4%">نام پیمانکار</td>
	 <td width="4%">وضعیت</td>
	 <td width="4%">اتصال به فروش</td>
	 <td width="6%">کدپستی</td>
	 <!--<td width="20%">آدرس ثبت شده در اداره پست</td>-->
	 <td width="20%">آدرس</td>
	 <td width="10%">آیدی واحد</td>
	</tr>
';
/***************************************** MAIN*****************************************/
echo'
<div class="table2excel"> 
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
  <br/>
  <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2">جدول سردخانه ها&nbsp&nbsp(صفحه : 1)
	 <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	 <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>
	</td>
	</tr>
  </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   echo $columns;
   $q1="SELECT *,(SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan) nameOstan From $TableName as T WHERE 1=1 ".$_SESSION['mt_search_li_anbar']." $Condition order by activate,id ASC";
   $allAnbar = $db->query($q1);
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=400;
   $cntr =mysql_num_rows($allAnbar);
   while($row1=$db->fetch_assoc($allAnbar))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     if($row1['chkforush'] == 1) $checked ='بلی';
     else $checked ='خیر';
	 echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['code_anbar'].'</td>
	  <td>'.$row1['code_acc'].'</td>
	  <td>'.$row1['shenase_yekta'].''; IF($row1['partid_error_code']==0) echo'<span class="fa fa-check" ></span>'; echo'</td>
	  <td>'.$row1['shenase_meli_anbar'].'</td>
	  <td>'.$row1['name_anbar'].'</td>
	  <td>'.$row1['nameOstan'].'</td>
	  <td>'.$noe_malekiyatArr[$row1['noe_malekiyat']].'</td>
	  <td>'.virgul($row1['zarfiyat']).'</td>
	  <td>'.virgul($row1['zarfiyat_gharardadi']).'</td>
	  <td>'.$status_peymankarArr[$row1['status_peymankar']].'</td>
	  <td>'.$row1['shenase_peymankar'].'</td>
	  <td>'.$row1['name_peymankar'].'</td>
	  <td>'.$activateArr[$row1['activate']].'</td>
	  <td>'.$checked.'</td>
	  <td>'.$row1['postal_code'].'</td>
	  <!--<td>'.$row1['postal_code'].''; IF($row1['post_error_code']==0) echo'<span class="fa fa-check" ></span>';echo'</td>-->
	  <!--<td>'.$row1['province'].'-'.$row1['township'].'-'.$row1['zone'].'-'.$row1['village'].'-'.$row1['localitytype'].'-'.$row1['localitycode'].'-'.$row1['sublocality'].'-'.$row1['street'].'-'.$row1['street2'].'-'.$row1['housenumber'].'-'.$row1['floor'].' '.$row1['sidefloor'].' '.$row1['buildingname'].' '.$row1['description'].'</td>-->';
	echo '
	  <td>'.$row1['full_address'].'</td>
	  <td>'.$row1['warehouse_id'].'</td>
	</tr>';
	 if ($line>=$MaxLines && $i <$cntr) 
	 {
	    $line=0;
        $page++;
	    echo'
		  </table>
		  <br class="pbreak">
          <br/>
		  <table width="99%" border="1" align="center">
           <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
           <tr><td class="print_title_2">جدول سردخانه ها&nbsp&nbsp(صفحه : '.$page.')
	       	</td>
	       </tr>
          </table>
		  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
          echo $columns;		  
	 }
	}
	echo'
   </table>
 </div>
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
  <tr class="print_footer">
   <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>	
 </table>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>