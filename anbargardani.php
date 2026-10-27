<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="anbargardani.php";
$TableName="mt_anbargardani";
$right_ins=0;$right_edt=0;$right_del=0;
//$right_prt=0;$right_ebtal=0;
if (right(200))  $right_ins=1;
if (right(201))  $right_edt=1;
//if (right(195))
if(SuperUser())	$right_del=1; 
// if (right(196)) $right_prt=1; 
// if (right(197)) $right_ebtal=1; 
//$logtime=date('H:i:s');
$titr='شمارش انبارگردانی';
$IssuedDate=AsLDate($yymmdd);
$q2="SELECT shomare_anbargardani FROM $TableName where code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' 
     order by shomare_anbargardani DESC LIMIT 0,1";
$res2=$db->query($q2);
$row2=$db->fetch_assoc($res2);
$w=$row2['shomare_anbargardani'];
if($w) {$shomare_anbargardani=$w; $shomare_anbargardani++;}
else $shomare_anbargardani=1;
$shomare_anbargardani=make_pattern($shomare_anbargardani,5);
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
 });
  <!--tooltip  -->
  $(document).ready(function(){
   $(function(){
   $(document).tooltip();
   });
  });
</script>
<script type="text/javascript">
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getDetailKala3(code_kala)<!--اطلاعات کالا-->
{ 
  $("#loading").fadeIn("fast");
  $.ajax({
  type: "POST",
  url: "ajax.php",
  data: {codeKALA3:code_kala},
  success: function(data) {
  			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#img_mojody").html(splKala[1]);
			  //$("[name=code_bastebandy]").val(splKala[2]);		  		  
  },
 });
  $("#loading").fadeOut("fast");
}
function sumkarton()<!--محاسبه مجموع وزن کارتن ها-->
{
 var sum_k;
 sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.karton_anbargardani.value)).toFixed(3);
 document.myform.sum_karton_anbargardani.value=sum_k;
}
function vazn_khales()<!--محاسبه وزن خالص-->
{
 var natije_vazn;
 natije_vazn=parseFloat((document.myform.nakhales_anbargardani.value)-(document.myform.sum_karton_anbargardani.value)).toFixed(3);                                      
 if(natije_vazn<0) natije_vazn=0;
 document.myform.khales_anbargardani.value=natije_vazn;
}
function sumghooti()<!--محاسبه وزن قوطی ها یا همان موجودی خالص-->
{
 var sum_k2;
 sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.karton_anbargardani.value)).toFixed(3);
 document.myform.khales_anbargardani.value=sum_k2;
}
<!--چک کردن کدبسته بندی کالا و نوع بسته بندی انتخاب شده--> 
function validateCodeKala(code_kala,code_bastebandy)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_validate.php",
        type: "post",
        data:{codekalaForValidate:code_kala,bastebandyForValidate:code_bastebandy},
        success: function(data){$("#codekalaError").html(data);}
    });
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_dakheli']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($shomare_anbargardani_sch) $temp.=" and T.shomare_anbargardani LIKE '%$shomare_anbargardani_sch%'";
 if($tarikh_anbargardani)      $temp.=" and T.tarikh_anbargardani LIKE '%$tarikh_anbargardani%'";
 if($shomaresh)                $temp.=" and T.shomaresh LIKE '$shomaresh'";
 if($nazer_aval_name)          $temp.=" and T.nazer_aval_name LIKE '%$nazer_aval_name%'";
 if($nazer_aval_lastname)      $temp.=" and T.nazer_aval_lastname LIKE '%$nazer_aval_lastname%'";
 if($nazer_dovom_name)         $temp.=" and T.nazer_dovom_name LIKE '%$nazer_dovom_name%'";
 if($nazer_dovom_lastname)     $temp.=" and T.nazer_dovom_lastname LIKE '%$nazer_dovom_lastname%'";
 if($nazer_sevom_name)         $temp.=" and T.nazer_sevom_name LIKE '%$nazer_sevom_name%'";
 if($nazer_sevom_lastname)     $temp.=" and T.nazer_sevom_lastname LIKE '%$nazer_sevom_lastname%'";
 if($code_kala)                $temp.=" and T.code_kala LIKE '$code_kala'";
 if($noe_ziranbar)             $temp.=" and l_s_d.noe_ziranbar LIKE '$noe_ziranbar'";
 if($code_ziranbar)            $temp.=" and T.code_ziranbar LIKE '$code_ziranbar'";
 if($code_keshvar)             $temp.=" and T.code_keshvar LIKE '$code_keshvar'";
 if($code_tolidkonande)        $temp.=" and T.code_tolidkonande LIKE '$code_tolidkonande'";
 if($sal_tolid_shamsi)         $temp.=" and T.sal_tolid_shamsi LIKE '$sal_tolid_shamsi'";
 if($mah_tolid_shamsi)         $temp.=" and T.mah_tolid_shamsi LIKE '$mah_tolid_shamsi'";
 if($rouz_tolid_shamsi)        $temp.=" and T.rouz_tolid_shamsi LIKE '$rouz_tolid_shamsi'";
 if($code_karton)              $temp.=" and T.code_karton LIKE '$code_karton'";
 if($karton_anbargardani)      $temp.=" and T.karton_anbargardani LIKE '%$karton_anbargardani%'";
 if($nakhales_anbargardani)    $temp.=" and T.nakhales_anbargardani LIKE '%$nakhales_anbargardani%'";
 if($khales_anbargardani)      $temp.=" and T.khales_anbargardani LIKE '%$khales_anbargardani%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_dakheli']=$temp;} else $_SESSION['mt_search_dakheli']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName T INNER JOIN kala ON T.code_kala=kala.code_kala  	  
		  WHERE 1=1 ".$_SESSION['mt_search_dakheli']." AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1; //$PageNo=$MaxPage;  
$NextPage=$PageNo+1;
$PrevPage=$PageNo-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage;
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q ="UPDATE $TableName set deleted=1 WHERE id_anbargardani=$id_anbargardani_";
 $del_res = mysql_query($del_q);
 if($del_res)$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_anbargardani_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ   
}//END DELETE
/************EBTAL BUTTON********/// ابطال 
// if (isset($ebtal_x))
// {
     // $ebtal_res=$db->query("UPDATE $TableName SET status=1 WHERE id_anbargardani=$id_anbargardani_");
     // /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_anbargardani_','ابطال برگه انبارگردانی',".($yymmdd).",'$logtime')");		
// }//END EBTAL 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_mojavez_tadil.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
	/********************sort field***********************/
if(!isset($order))      $order='T.id_anbargardani DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortname))   $sortname='1';
if(!isset($show_img))   $show_img='';
	if($sortcode=='1')
	{echo'<td width="7%"  title="مرتب سازی صعودی شماره برگه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_anbargardani ASC&sortcode=2&show_img=1\'"/> شماره برگه ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="7%"  title="مرتب سازی نزولی شماره برگه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_anbargardani DESC&sortcode=1&show_img=1\'"/> شماره برگه ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="7%"  title="مرتب سازی صعودی تاریخ برگه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_anbargardani ASC&sorttarikh=2&show_img=2\'"/> تاریخ برگه '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="7%"  title="مرتب سازی نزولی تاریخ برگه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_anbargardani DESC&sorttarikh=1&show_img=2\'"/> تاریخ برگه '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    echo'
	<td width="10%">ناظر اول</td>
	<td width="10%">ناظر دوم</td>
	<td width="10%">ناظر سوم</td>
	<td width="5%">شمارش</td>
	<td width="5%">کد کالا</td>';
	if($sortname=='1')
	{echo'<td width="18%"  title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala ASC&sortname=2&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="18%"  title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala DESC&sortname=1&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	 echo'<td width="8%">اطلاعات</td>';
	 //if($right_prt)echo'<td width="3%">چاپ</td>';
	 //if(($right_del)and($detailcount==0)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%" >حذف</td>';
	 echo'
	</tr>';
	$i=0;
	$q1="SELECT T.*,kala.name_kala From $TableName T INNER JOIN kala ON T.code_kala=kala.code_kala 
		 WHERE 1=1 ".$_SESSION['mt_search_dakheli']." AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 order by $order $Limit";
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     $detailcount=$db->get_from_where("count(*)","mt_anbargardani_detail","id_anbargardani=".$row1['id_anbargardani']."");
	 if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_anbargardani_='.$row1['id_anbargardani'].'&shomare_anbargardani_='.$row1['shomare_anbargardani'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
      if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
      else $code_a=$row1['code_ostan'];
	  echo'
	  <td '.$edtClick.'>'.$code_a.$row1['code_anbar'].$row1['shomare_anbargardani'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_anbargardani'].'</td>
	  <td '.$edtClick.'>'.$row1['nazer_aval_name'].' '.$row1['nazer_aval_lastname'].'</td>
	  <td '.$edtClick.'>'.$row1['nazer_dovom_name'].' '.$row1['nazer_dovom_lastname'].'</td>
	  <td '.$edtClick.'>'.$row1['nazer_sevom_name'].' '.$row1['nazer_sevom_lastname'].'</td>
	  <td '.$edtClick.'>'.$shomareshArr[$row1['shomaresh']].'</td>
	  <td '.$edtClick.'>'.$row1['code_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['name_kala'].'</td>';
	  echo'<td><input type="button" class="buttonme"  value="اطلاعات کالا ['.$detailcount.']" onClick="window.location=\'anbargardani_detail.php?id_anbargardani_='.$row1['id_anbargardani'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"></td>';

	  // echo'<td align="center">';
	  // if($right_prt){echo'<div onClick="window.open(\'print_anbargardani_one.php?id_anbargardani_='.$row1['id_anbargardani'].'\',\'_blank\',\'scrollbars=yes\')"';if($row1['status']==0) echo'id="printer_T"'; if($row1['status']==1) echo'id="printer_T_ebtal"'; echo'title="چاپ"><a href="#"></a></div>';}
      // echo'</td>'; 
	  // IF($right_del)
	  // {
		// //echo'<td>';
		// if(($detailcount==0)and($_SESSION['mtStatusYear']==0))
	    // {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       // onmouseOver="this.src=\'images/trash_hover.png\'" 
		   // onmouseOut="this.src=\'images/trash.png\'" 
		   // onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_anbargardani_='.$row1['id_anbargardani'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف برگه '.$code_a.$row1['code_anbar'].$row1['shomare_anbargardani'].' \')" /></td>';
	    // }
	   // // echo '</td>';
	  // }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo '
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  //IF($right_del)echo'<td>&nbsp;</td>';
      //if(($right_del)and($detailcount==0)and($_SESSION['mtStatusYear']==0))echo'<td>&nbsp;</td>';
	  echo'	  
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10px">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //if((($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]!=$yy)and($mt_gl_code_anbar!=301))OR((SuperUser())and($_SESSION["mtActiveYear"]!=$yy)and($mt_gl_code_anbar!=301)))
     if((($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1)and($_SESSION["mtActiveYear"]!='1405')and($mt_gl_code_anbar!=301))OR(($right_ins)and($_SESSION['mt_anbar_activate']==1)and($_SESSION["mtActiveYear"]=='1404')and($mt_gl_code_anbar!=301))OR((SuperUser())and($_SESSION["mtActiveYear"]!=$yy)and($mt_gl_code_anbar!=301)))
	 {echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	       <td width="10px">&nbsp;</td>';}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="40px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_dakheli']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>	  	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="10" align="center">ايجاد فرم جديد</td></tr>
       <tr><td>&nbsp;</td></tr>
	   <tr>
        <td>
         <table width="100%">
          <tr>		 
	   	   <td align="left"><span class="star">*</span> شماره برگه :</td>
		   <td align="right">
		   <input type="text" readonly class="textboxme" value="'.$shomare_anbargardani.'" name="shomare_anbargardani" style="width:50px;"/>&nbsp;/&nbsp;';
           if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		   else $code_a=$mt_gl_code_ostan;
		   echo'<input type="text" readonly class="textboxme" value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>';
		   if($_SESSION["mtActiveYear"]==$yy){echo'<td align="left"><span class="star">*</span> تاریخ برگه :</td><td align="right"><input class="textboxme2" type="text" maxlength="10" readonly name="tarikh_anbargardani" value="'.AsLDate($yymmdd).'"/></td>';}
		   else {echo'<td align="left"><span class="star">*</span> تاریخ برگه :</td><td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_anbargardani" readonly value="'.$mtEndDateSh.'"/></td>';}
		   echo'
		   <td align="left"><span class="star">*</span> شمارش :</td><td align="right">'.static_listbox("shomaresh","1","shomareshArr",1,"class='text4' readonly").'</td>
	       <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' onchange=myform.submit()","").'
		    <img border="0" src="images/Info1.png" title="در صورت تغییر مجدد بسته بندی دوباره درفیلد کد کالا کلیک نمایید و اطلاعات را دوباره انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		  </tr>
	     </table>
	    </td>
	   </tr>
       <tr>
	    <td valign="top">
	     <fieldset>
	      <legend>اطلاعات ناظرین</legend>
	       <table width="100%">
            <tr>
			 <td align="left"><span class="star">*</span><span> ناظر اول : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_name" id="nazer_aval_name" value="'.$nazer_aval_name.'"/></td>
			 <td align="left"><span class="star">*</span> نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_lastname" id="nazer_aval_lastname" value="'.$nazer_aval_lastname.'"/></td>
			 <td align="left"><span>ناظر دوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_name" id="nazer_dovom_name" value="'.$nazer_dovom_name.'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_lastname" id="nazer_dovom_lastname" value="'.$nazer_dovom_lastname.'"/></td>
			 <td align="left"><span>ناظر سوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_name" id="nazer_sevom_name" value="'.$nazer_sevom_name.'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_lastname" id="nazer_sevom_lastname" value="'.$nazer_sevom_lastname.'"/></td>
		    </tr>
		   </table>	
          </fieldset>
		 </td>
		</tr>';
       if(!$code_bastebandy)echo '<tr><td colspan="10" align="center" height="40px">برای مشاهده سایراطلاعات نوع بسته بندی راانتخاب نمایید</td></tr>';		
       else
	   {
	   echo'
	    <tr>
		 <td>
		  <table width="100%">
		   <tr>
		    <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala3(this.value);" onchange="getDetailKala3(this.value)" onblur="validateCodeKala(this.value,document.myform.code_bastebandy.value)" style="width:50px"/>&nbsp;';
		     $code_bastebandy_=$code_bastebandy;
		     include('img_helpkalabastebandy.php');
		     echo'
		      <span id="codekalaError">&nbsp;</span>
		     </td>';
		     //echo' <td width="130px" align="center"><span id="img_mojody"></span></td>';
		     //echo' <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>';
	        echo'
		   	<td align="left">نام کالا :&nbsp;</td><td align="right"><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$name_kala.'"/></td>
		    <td align="left">توضيحات :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_anbargardani" value="'.$tozihat_anbargardani.'"/></td>
		   </tr>
		  </table>
         </td>
		</tr>';
	   }//END code_bastebandy
	   echo'
	   <tr>
	    <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
		</td>	
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")//Edit Mode
    {
	 $q3="SELECT T.*,kala.name_kala,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy From $TableName T 
	      INNER JOIN kala ON T.code_kala=kala.code_kala 
		  INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
		  WHERE T.shomare_anbargardani='$shomare_anbargardani_' AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0";
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 $detailcount=$db->get_from_where("count(*)","mt_anbargardani_detail","id_anbargardani=".$row3['id_anbargardani']."");
	 //اگر کد استان یک رقمی بود
	 if(strlen($row3['code_ostan'])==1) $code_a=make_pattern($row3['code_ostan'],2);
     else $code_a=$row3['code_ostan'];
	 // //موجودی کالا با  تابع
	 // $tedad_karton=mojodyKarton($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton'],$row3['code_mandegari']);
	 // $mojody_nakhales=mojodyNakhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton'],$row3['code_mandegari']);
	 // $mojody_khales=mojodyKhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton'],$row3['code_mandegari']);
	 
	echo '
    <tr>
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">	
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="10" align="center"> ويرايش اطلاعات برگه '.$code_a.$row3['code_anbar'].$row3['shomare_anbargardani'].'</td></tr>
       <tr><td align="right">';if(SuperUser()) echo'id:'.$row3['id_anbargardani'].'';else echo '&nbsp;';echo'</td></tr>
	   <tr>
	    <td colspan="8" align="left">
		 <table>';
		 // echo'
		  // <tr>';
	      // //اگر اجازه ابطال داشته و این فرم هنوز ابطال نشده و سال فعال است
	      // if(($right_ebtal)and($row3['status']==0)and($_SESSION['mtStatusYear']==0))
	      // {
		   // echo'<td align="left"><input type="button" class="buttonme" name="ebtal_x" value="ابطال برگه" onClick="iconfirm(\''.$FileName.'?ebtal_x=1&id_anbargardani_='.$row3['id_anbargardani'].'&shomare_anbargardani_='.$row3['shomare_anbargardani'].'&code_kala_='.$row3['code_kala'].'&code_ziranbar_='.$row3['code_ziranbar'].'&meghdar_anbargardani_='.$row3['meghdar_anbargardani'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای ابطال برگه انبارگردانی  '.$code_a.$row3['code_anbar'].$row3['shomare_anbargardani'].' \')"/></td>      
		         // <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';}
		   // if($row3['status']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این فرم : ابطالی</td>';	
	      // echo'
	      // </tr>';
		  echo'
		 </table>
		</td>
	   </tr>
	   <tr>
        <td>
         <table width="100%">
          <tr>		 
	   	   <td align="left"><span class="star">*</span> شماره برگه :</td>
		   <td align="right">
		    <input type="text" readonly class="textboxme" value="'.$row3['shomare_anbargardani'].'" name="shomare_anbargardani" style="width:50px;"/>&nbsp;/&nbsp;
		    <input type="text" disabled class="textboxme" value="'.$row3['code_ostan'].$row3['code_anbar'].'" name="ostan_anbar" style="width:50px;"/></td>
		   <td align="left"><span class="star">*</span> تاریخ برگه :</td><td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_anbargardani" id="datepicker6" value="'.$row3['tarikh_anbargardani'].'"/></td>
	       <td align="left"><span class="star">*</span> شمارش :</td><td align="right">'.static_listbox("shomaresh",$row3['shomaresh'],"shomareshArr",1,"class='text4' disabled").'</td>
		   <input type="hidden" name="shomaresh" value="'.$row3['shomaresh'].'"/>
		   <input type="hidden" name="code_bastebandy" value="'.$row3['code_bastebandy'].'"/>
		  </tr>
	     </table>
	    </td>
	   </tr>
	   <tr>
	    <td valign="top" width="50%">
	     <fieldset>
	      <legend>اطلاعات ناظرین</legend>
	       <table width="100%">
            <tr>
			 <td align="left"><span class="star">*</span><span> ناظر اول : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_name" id="nazer_aval_name" value="'.$row3['nazer_aval_name'].'"/></td>
			 <td align="left"><span class="star">*</span> نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_lastname" id="nazer_aval_lastname" value="'.$row3['nazer_aval_lastname'].'"/></td>
			 <td align="left"><span>ناظر دوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_name" id="nazer_dovom_name" value="'.$row3['nazer_dovom_name'].'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_lastname" id="nazer_dovom_lastname" value="'.$row3['nazer_dovom_lastname'].'"/></td>
			 <td align="left"><span>ناظر سوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_name" id="nazer_sevom_name" value="'.$row3['nazer_sevom_name'].'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_lastname" id="nazer_sevom_lastname" value="'.$row3['nazer_sevom_lastname'].'"/></td>
		    </tr>
		   </table>	
          </fieldset>
		 </td>
		</tr>
	    <tr>
		 <td>
		  <table width="100%">
		   <tr>
		    <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" readonly  type="text" name="code_kala" value="'.$row3['code_kala'].'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala3(this.value);" onchange="getDetailKala3(this.value)" onblur="validateCodeKala(this.value,document.myform.code_bastebandy.value)" style="width:50px"/>&nbsp;';
		     $code_bastebandy_=$row3['code_bastebandy'];
		     IF($detailcount==0) include('img_helpkalabastebandy.php');
		     echo'
		      <span id="codekalaError">&nbsp;</span>
		     </td>
		   	<td align="left">نام کالا :&nbsp;</td><td align="right"><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$row3['name_kala'].'"/></td>
		    <td align="left">توضيحات :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_anbargardani" value="'.$row3['tozihat_anbargardani'].'"/></td>
		   </tr>
		  </table>
         </td>
		</tr>
	   
	   <tr>
        <td colspan="8" align="center" class="title">';
		if((($right_edt)and($_SESSION['mtStatusYear']==0))or(SuperUser()))
		echo'
		 <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">	
       <tr class="title"><td colspan="10" align="center">جستجوی فرم انبارگردانی</td></tr>
       <tr><td>&nbsp;</td></tr>	   
        <tr>
        <td colspan="2">
         <table width="100%">
          <tr>		 
	   	   <td align="left"> شماره برگه :</td>
		   <td align="right">
		   <input type="text" class="textboxme" name="shomare_anbargardani_sch" style="width:50px;"/>&nbsp;/&nbsp;';
           if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		   else $code_a=$mt_gl_code_ostan;
		   echo'<input type="text" readonly class="textboxme" value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
		   <td align="left"> تاریخ برگه :</td><td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_anbargardani" id="datepicker6"/></td>
		   <td align="left"> شمارش :</td><td align="right">'.static_listbox("shomaresh",$shomaresh,"shomareshArr",1,"class='text4'").'</td>
	      </tr>
	     </table>
	    </td>
	   </tr>
       <tr>
	    <td valign="top" width="60%">
	     <fieldset>
	      <legend>اطلاعات ناظرین</legend>
	       <table width="100%" height="90px">
            <tr>
			 <td align="left"><span> ناظر اول : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_name" id="nazer_aval_name" value="'.$nazer_aval_name.'"/></td>
			 <td align="left"> نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_aval_lastname" id="nazer_aval_lastname" value="'.$nazer_aval_lastname.'"/></td>
		    </tr>
            <tr>
			 <td align="left"><span>ناظر دوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_name" id="nazer_dovom_name" value="'.$nazer_dovom_name.'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2"  name="nazer_dovom_lastname" id="nazer_dovom_lastname" value="'.$nazer_dovom_lastname.'"/></td>
		    </tr>
            <tr>
			 <td align="left"><span>ناظر سوم : </span>نام :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_name" id="nazer_sevom_name" value="'.$nazer_sevom_name.'"/></td>
			 <td align="left">نام خانوادگی :</td><td align="right"><input type="text" class="textboxme2" name="nazer_sevom_lastname" id="nazer_sevom_lastname" value="'.$nazer_sevom_lastname.'"/></td>
		    </tr>
		   </table>	
          </fieldset>
		 </td>
		 <td valign="top" width="40%">
		  <fieldset>
	      <legend>اطلاعات کالا</legend>
	       <table width="100%" height="90px">
		    <tr>
			  <td align="left"> کد کالا :</td><td align="right"><input type="text"  class="textboxme2" name="code_kala" value="'.$code_kala.'"  onfocus="getDetailKala3(this.value);" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)"/>';
	          include("img_helpkala.php");
	          echo'
	          </td>
		    </tr>
			<!--<tr><td align="left"> نام کالا :</td><td align="right" ><input type="text" readonly class="textboxme2" name="name_kala" value="'.$name_kala.'" /></td></tr>-->
		  </table>
		 </fieldset>
		</td>
	   </tr>
	   <tr>
        <td colspan="8" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>';
/**********اجازه براي ثبت********/
function isPermitSave($sh_barge,$date_barge,$sh,$code_baste,$nazer_name,$nazer_lastname,$c_kala,$gl_c_o,$gl_c_a,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($sh_barge and $date_barge and $sh and $nazer_name and $nazer_lastname and $c_kala))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
    $q_kala="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
    $res_kala=mysql_query($q_kala);
    if(mysql_num_rows($res_kala)==0){
      echo"<script>alert('این کد کالا در جدول کالا ثبت نشده است!')</script>";
      $flag=false;
      return $flag;
   }
  else $flag=true;
  $q_baste="SELECT code_bastebandy FROM kala WHERE code_kala='$c_kala'";//بسته بندی
  $res_baste=mysql_query($q_baste);
  $row_baste=mysql_fetch_assoc($res_baste);
  if($row_baste['code_bastebandy']!=$code_baste)
  {
     echo"<script>alert('بسته بندی این کالا با نوع بسته بندی انتخاب شده مغایرت دارد \\n امکان انتخاب این کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  
  $q3="SELECT * FROM mt_anbargardani WHERE code_kala='$c_kala' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a AND year=$gl_year AND deleted=0";//
  $res3=mysql_query($q3);  
  if(mysql_num_rows($res3)>0){
   echo"<script>alert('اين کد کالا قبلا ثبت شده است !')</script>";
   $flag=false;
   return $flag;  
  }
  else $flag=true;
  $q4="SELECT code_kala FROM mojody_kala WHERE code_kala='$c_kala' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a AND year=$gl_year";
  $res4=mysql_query($q4);  
  if(mysql_num_rows($res4)==0){
   echo"<script>alert('این کد کالا درموجودی سردخانه شما وجود ندارد!')</script>";
   $flag=false;
   return $flag;  
  }
  else $flag=true;
 }
 else $flag=true;
 // if($sh and $c_kala and $code_zir_a)//شمارش وکالاوزیرانبار تکراری نباشد
 // {
   // $q_1="SELECT * FROM mt_anbargardani WHERE shomaresh='$sh' AND code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND deleted=0 AND status=0";
   // $res_1=mysql_query($q_1);
   // if(mysql_num_rows($res_1)>0)
   // {
	 // echo"<script>alert('این اطلاعات برای این شمارش قبلاً ثبت شده است!')</script>";
     // $flag=false;
     // return $flag;
   // }
   // else $flag=true;
   // //ترتیب شمارش
   // $q_2="SELECT * FROM mt_anbargardani WHERE code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND deleted=0 AND status=0";
   // $res_2=mysql_query($q_2);
   // $row_2=mysql_fetch_assoc($res_2);
   // if(((mysql_num_rows($res_2)==0)and($sh!='1'))or((mysql_num_rows($res_2)>0)and($sh!='2')))
   // {
     // echo"<script>alert('ترتیب شمارش رعایت نشده است!')</script>";
     // $flag=false;
     // return $flag;
   // }
   // else $flag=true;
   // //اگر نظیرش در موجودی نباشد
   // $q_3="SELECT * FROM mojody_kala WHERE code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND deleted=0";
   // $res_3=mysql_query($q_3);
   // if(mysql_num_rows($res_3)==0)
   // {
	 // echo"<script>alert('کالایی با این مشخصات در انبار ثبت نشده است!')</script>";
     // $flag=false;
     // return $flag;
   // }
   // else $flag=true;
 // }
 // else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($date_barge,$sh,$nazer_name,$nazer_lastname,$gl_c_o,$gl_c_a,$gl_year,$this_id)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($date_barge and $sh and $nazer_name and $nazer_lastname))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
    $q_kala="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
    $res_kala=mysql_query($q_kala);
    if(mysql_num_rows($res_kala)==0){
      echo"<script>alert('این کد کالا در جدول کالا ثبت نشده است!')</script>";
      $flag=false;
      return $flag;
   }
  else $flag=true;
  $q_baste="SELECT code_bastebandy FROM kala WHERE code_kala='$c_kala'";//بسته بندی
  $res_baste=mysql_query($q_baste);
  $row_baste=mysql_fetch_assoc($res_baste);
  if($row_baste['code_bastebandy']!=$code_baste)
  {
     echo"<script>alert('بسته بندی این کالا با نوع بسته بندی انتخاب شده مغایرت دارد \\n امکان انتخاب این کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  
  $q3="SELECT * FROM mt_anbargardani WHERE code_kala='$c_kala' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a AND year=$gl_year AND deleted=0 AND id_anbargardani!=$this_id";//
  $res3=mysql_query($q3);  
  if(mysql_num_rows($res3)>0){
   echo"<script>alert('اين کد کالا قبلا ثبت شده است !')</script>";
   $flag=false;
   return $flag;  
  }
  else $flag=true;
  $q4="SELECT code_kala FROM mojody_kala WHERE code_kala='$c_kala' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_a AND year=$gl_year";
  $res4=mysql_query($q4);  
  if(mysql_num_rows($res4)==0){
   echo"<script>alert('این کد کالا درموجودی سردخانه شما وجود ندارد!')</script>";
   $flag=false;
   return $flag;  
  }
  else $flag=true;
 }
 else $flag=true;
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($shomare_anbargardani,$tarikh_anbargardani,$shomaresh,$code_bastebandy,$nazer_aval_name,$nazer_aval_lastname,$code_kala,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {  
   $Mode='';
   $shomaresh=1;
   $IssuedTime = date('H:i');//زمان ثبت
   $signiture ="select sign_id from mt_typesign where activate=1 and type_id=5 and code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar'  and ((expire_date='')or(expire_date is NULL)or(expire_date!='' and expire_date>='$tarikh_anbargardani')) ORDER BY turn";
   $allsigniture  = $db->query($signiture);
   $separatesigniture='';
   while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
   $separatesigniture=rtrim($separatesigniture, ";");
   //محاسبات برای اطمینان
   // if($code_bastebandy==1)//کارتنی
   // {
	   // $sum_karton_this=round(floatval($vazn_karton_this*$karton_anbargardani),3);  
	   // $khales_anbargardani=round(floatval($nakhales_anbargardani-$sum_karton_this),3);
   // } 
   // if($code_bastebandy==2)//قوطی
   // {
     // $khales_anbargardani=round(floatval($vazn_karton_this*$karton_anbargardani),3);
   // }
   $insert_q=("INSERT INTO $TableName
             (code_ostan,code_anbar,shomare_anbargardani,year,tarikh_anbargardani,IssuedDate,IssuedTime,shomaresh,nazer_aval_name,nazer_aval_lastname,nazer_dovom_name,nazer_dovom_lastname,nazer_sevom_name,nazer_sevom_lastname,code_kala,tozihat_anbargardani,deleted,status,signiture_anbargardani)
              VALUES
	 		 ('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_anbargardani','$mtActiveYear','$tarikh_anbargardani','$IssuedDate','$IssuedTime','$shomaresh','$nazer_aval_name','$nazer_aval_lastname','$nazer_dovom_name','$nazer_dovom_lastname','$nazer_sevom_name','$nazer_sevom_lastname','$code_kala','$tozihat_anbargardani',0,0,'$separatesigniture')"); 		 
	$insert_res=mysql_query($insert_q);
    /*لاگ*/
    $max_id=$db->get_from_where("MAX(id_anbargardani)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
    if($insert_res and $log_i)
    {
	  echo '<script>window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
    }
    else  
    {
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";  
	}
 }//END isPermitSave
}//END INSERT
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($tarikh_anbargardani,$shomaresh,$nazer_aval_name,$nazer_aval_lastname,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_anbargardani_))
 {
   $Mode='';
   $signiture ="select sign_id from mt_typesign where activate=1 and type_id=5 and code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar'  and ((expire_date='')or(expire_date is NULL)or(expire_date!='' and expire_date>='$tarikh_anbargardani')) ORDER BY turn";
   $allsigniture  = $db->query($signiture);
   $separatesigniture='';
   while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
   $separatesigniture=rtrim($separatesigniture, ";");
   $edit_q=("UPDATE $TableName SET tarikh_anbargardani='$tarikh_anbargardani',shomaresh='$shomaresh',nazer_aval_name='$nazer_aval_name',nazer_aval_lastname='$nazer_aval_lastname',nazer_dovom_name='$nazer_dovom_name',nazer_dovom_lastname='$nazer_dovom_lastname',nazer_sevom_name='$nazer_sevom_name',nazer_sevom_lastname='$nazer_sevom_lastname',code_kala='$code_kala',tozihat_anbargardani='$tozihat_anbargardani',signiture_anbargardani='$separatesigniture' WHERE id_anbargardani='$id_anbargardani_';");         
   $edit_res=mysql_query($edit_q);
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_anbargardani_','ویرایش',".($yymmdd).",'$logtime')");  /*کوئری لاگ*/ 
   if(($edit_res) and ($log_e))
   { 
	echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   } 
   else 
   { 
    $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
   }
 }//END isPermitEdit
}//END Edit 
///////////////////////////////////////////////////////////////////
echo'
<br/><br/>
'.$message.'
</form>
</body>
</html>';	
?>