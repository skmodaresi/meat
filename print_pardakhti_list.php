<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_pardakhti_list.php";
$ExcelFileName=str_replace('.php','',$FileName);
$TableName="pardakht_gharardad";
$titr='درخواست پرداخت وجه قرارداد';
require_once('head.html');
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$condition_ostan='';}
else {$condition_ostan=' AND gh_kh.code_ostan='.$mt_gl_code_ostan.'';}
$columns='
   <tr class="print_table-title2">
	 <td width="4%">رديف</td>
	 <td width="4%">شناسه</td>
	 <td width="6%">شماره نامه</td>
	 <td width="6%">تاریخ</td>
	 <td width="10%" >نوع پرداخت</td>
	 <td width="10%" >شماره قرارداد</td>
	 <td width="10%" >استان</td>
	 <td width="10%" >گروه کالا</td>
	 <td width="10%" >شماره ابلاغ</td>
	 <td width="10%" >مقدار تحویلی جهت پرداخت</td>
	 <td width="10%" >قیمت پرداخت</td>
	 <td width="10%" >مبلغ پرداختی</td>
	</tr>';
/***************************************** MAIN*****************************************/
echo'
<div class="table2excel"> 
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
  <br/>
  <table class="noExl" width="99%" border="1" align="center">
    <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr class="noExl"><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : 1)
	 <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
	 <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>
	</td>
	</tr>
  </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   echo $columns;
   $q1="SELECT T.*,shomare_gharardad,shomare_eblagh,name_ostan,name_group_kala_top,ostan.code_ostan From meat.$TableName T
	     INNER JOIN meat.gharardad_kharid gh_kh USING(id_gharardad)
	     INNER JOIN meat.sahmiebandy_kharid s_kh ON gh_kh.id_sahmiebandy=s_kh.id_sahmiebandy
	     INNER JOIN meat.eblagh_kharid e_kh ON s_kh.id_eblagh=e_kh.id_eblagh
		 INNER JOIN meat.ostan ON gh_kh.code_ostan=ostan.code_ostan
		 INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=e_kh.code_group_kala_top
		 WHERE 1=1 ".$_SESSION['mt_search_pardakhti_li']." $condition_ostan AND T.deleted=0 order by id_pardakht";
	
   $radif=1;
   $all = $db->query($q1);
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=20;
   $cntr =mysql_num_rows($all);
   $jame_meghdar_tahviljari=0;
   $jame_mablagh_tahviljari=0;
   $jame_meghdar_mabetafavot=0;
   $jame_mablagh_mabetafavot=0;
   while($row1=$db->fetch_assoc($all))
   {
     $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 echo'
	  <td>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['id_pardakht'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_nameh'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_nameh'].'</td>
	  <td '.$edtClick.'>'.$pardakhtGrArr[$row1['pardakht_type']].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_gharardad'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ostan'].'</td>
	  <td '.$edtClick.'>'.$row1['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_eblagh'].'</td>
	  <td '.$edtClick.'>'.round($row1['meghdar'],3).'</td>
	  <td '.$edtClick.'>'.virgul($row1['gheymat_pardakht']).'</td>
	  <td '.$edtClick.'>'.virgul($row1['mablagh_pardakht']).'</td>
	</tr>';
	 if ($line>=$MaxLines && $i <$cntr) 
	 {
	    $line=0;
        $page++;
	    echo'
		  </table>
		  <br class="pbreak">
		  <table class="noExl" width="99%" border="1" align="center">
           <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
           <tr class="noExl"><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : '.$page.')
	       	</td>
	       </tr>
          </table>
		  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
          echo $columns;		  
	 }
	 IF($row1['pardakht_type']==1)
	 {
		 $jame_meghdar_tahviljari+=$row1['meghdar'];
		 $jame_mablagh_tahviljari+=$row1['mablagh_pardakht'];
     }
	 ELSE IF($row1['pardakht_type']==2)
	 {
		 $jame_meghdar_mabetafavot+=$row1['meghdar'];
		 $jame_mablagh_mabetafavot+=$row1['mablagh_pardakht'];
	 }
	}//END WHILE
	echo'
	<tr class="print_table-even sum-row-white-b">
     <td colspan="9">مجموع (نوع پرداخت : بابت تحویل جاری کالا)</td>
	  <td>'.round($jame_meghdar_tahviljari,3).'</td>
	  <td>-</td>
	  <td>'.virgul($jame_mablagh_tahviljari).'</td>
    </tr>
	<tr class="print_table-even sum-row-white-b">
     <td colspan="9">مجموع (نوع پرداخت : مابه التفاوت)</td>
	  <td>'.round($jame_meghdar_mabetafavot,3).'</td>
	  <td>-</td>
	  <td>'.virgul($jame_mablagh_mabetafavot).'</td>
    </tr>
   </table>
   </div>
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
  <tr class="print_footer">
   <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$dsuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>	
 </table>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>