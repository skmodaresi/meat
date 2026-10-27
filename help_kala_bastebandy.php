<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_kala_bastebandy.php";
$TableName="kala";
$radif=1;
if(!$inputName) $inputName='code_kala';
//echo "inputName:$inputName";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول کد کالا</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(code_val)
{
 window.opener.document.myform.".$inputName.".value=code_val;
 window.opener.document.myform.".$inputName.".focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول کد کالا</td>	 
 </tr>
 <!--<tr>
  <td class="title title_search"><div onClick="window.location=\''.$FileName.'?Mode=Search&parent_page='.$parent_page.'&c_k_e='.$c_k_e.'&c_baste_='.$c_baste_.'&n_t_b_='.$n_t_b_.'\'" id="btn-search" style="float:left;" title="جستجو"><a href="#"></a></div></td>
 </tr>-->
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class=table-title>
	 <td width=10%>رديف</td>
	 <td width=15%>کد کالا</td>
	 <td width=60%>نام کالا</td>
	 <td width=15%>نوع بسته بندی</td>
	</tr>';
	/*************SEARCH BUTTON******/// جستجوی اطلاعات
    if(isset($open_filter))
    { $open_filter="";
      $_SESSION['mt_search_help_kala_baste']="";
    } 
    if(isset($Search_x))
    {
     $Mode='';
     $Search_x=""; 
     $temp='';
     if($code_kala)     $temp.=" AND code_kala LIKE '%$code_kala%'";
     if($name_kala)     $temp.=" AND name_kala LIKE '%$name_kala%'";
     if($temp) {$PageNo=1;$_SESSION['mt_search_help_kala_baste']=$temp;} else $_SESSION['mt_search_help_kala_baste']="";
    }
	/*************END SEARCH ******/
   $Cntr=0;
   if($parent_page=="resid_detail.php")//صفحه جزئیات حواله
   {
	 if(($n_t_b_==4)or($n_t_b_==5)or($n_t_b_==6)or($n_t_b_==7)or($n_t_b_==9))//جابه جایی یا برگشت از فروش یا تخلیه در انبار امانی
	 {$q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_." order by $TableName.id asc";}
	 else //خرید
	 {
	   if($c_k_e==0)//اگر در قرارداد کد کالا نیامده یعنی وارداتی است
	   {
	     $id_safar=$db->get_from_where("id_safar","resid","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
         $shomare_safar=$db->get_from_where("shomare_safar","shomare_safar","id_safar=$id_safar");
         $exist_gharardad=$db->get_from_where("COUNT(*)","gharardad_kharid","shomare_gharardad='$shomare_safar'");
         $id_dastorolamal=$db->get_from_where("id_dastorolamal","gharardad_kharid","shomare_gharardad='$shomare_safar'");
		 if($exist_gharardad>0)//اگر قرارداد وجود دارد
         {   
           $exist_gheymat=$db->get_from_where("COUNT(*)","gheymat_kharid","id_dastorolamal=$id_dastorolamal  AND deleted=0");
		   IF($exist_gheymat>0)
		   {
		    $q_gheymat_kala="SELECT code_kala FROM gheymat_kharid WHERE id_dastorolamal=$id_dastorolamal AND deleted=0";
		    $allgheymat_kala=$db->query($q_gheymat_kala);
		    while($row1=$db->fetch_assoc($allgheymat_kala))$Condition_kala_temp.=" $TableName.code_kala=".$row1['code_kala']." OR";
            $lastSpacePosition = strrpos($Condition_kala_temp," ");
            $Condition_kala =substr($Condition_kala_temp,0,$lastSpacePosition);    
		    //foreach($allgheymat_kala as $key => $val) $Condition_kala.=" $TableName.code_kala='$val' OR";   
		    $q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_."  AND($Condition_kala)  AND activate_resid=1 order by $TableName.name_kala asc";
		   }
           ELSE echo'<tr><td class="table-even" colspan="4"><span>در دستورالعمل خرید قرارداد این فرم ، قیمت خریدی برای کالا ثبت نشده است</span></td></tr>';			   
          }
		  else if($exist_gharardad==0)//اگر قرارداد وجود ندارد
	      {$q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_." AND ($TableName.code_kala BETWEEN 205 AND 226)  AND activate_resid=1 order by $TableName.id asc";}  
	   }
	   //اگر در قرارداد کد کالا آمده یعنی داخلی است
       else	 $q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_."  AND $TableName.code_kala='$c_k_e' AND activate_resid=1 order by $TableName.name_kala asc";
	}
   }   
   else//سایر صفحات
   {
     //if(($n_t_b_==4)or($n_t_b_==5))
		  $q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_." order by $TableName.name_kala asc";
     //else $q1="SELECT * From $TableName INNER JOIN bastebandy ON bastebandy.code_bastebandy=$TableName.code_bastebandy  WHERE 1=1 ".$_SESSION['mt_search_help_kala_baste']." AND $TableName.code_bastebandy=".$c_baste_." AND activate_resid=1 order by $TableName.id asc";
   
   }
   //IF(SuperUser())echo $q1;
   $allKala = $db->query($q1);
   while($row1=$db->fetch_assoc($allKala))
   {
	$editclick="onclick='substitute(\"".$row1['code_kala']."\")'";   
	//$edtClick='onClick="window.location=\''.$FileName_.'?mysess_="'.$_SESSION['codeKala'].'"\'"';	
	//$edtClick='onClick="window.location=\''.$FileName_.'?&id_='.$row1['id'].'\'"';	
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even" />';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_kala'].'</td>
	  <td '.$editclick.'>'.$row1['name_kala'].'</td>
	  <td '.$editclick.'>'.$row1['sharh_bastebandy'].'</td>';
	 echo '
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 if ($_SESSION['mt_search_help_kala_baste']) 
 echo '
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">
    <tr>
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&c_k_e='.$c_k_e.'&c_baste_='.$c_baste_.'&n_t_b_='.$n_t_b_.'&open_filter=1\'"></td>
    </tr>
   </table>
  </td>
 </tr>';	  
 // if($Mode=="Search")
 // {
   // echo'
	// <tr> 
	 // <td> 	 
	  // <table border="0" bgcolor="#E9F7FD" align="center" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;top:150px;">
       // <tr class="title"><td colspan="4" align="center">جستجوی کالا</td></tr>
       // <tr><td>&nbsp;</td></tr>	   
	   // <tr>
	    // <td align="left">کد کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="code_kala" value="'.$code_kala.'"  onkeypress="return isNumber(event)" style="width:50px"/></td>
	    // <td align="left">نام کالا : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_kala" value="'.$name_kala.'"/></td>
	   // </tr>
	   // <tr><td>&nbsp;</td></tr>
	   // <tr>
        // <td colspan="4" align="center" class="title">
		 // <input class="buttonme" type="submit" name="Search_x" value="جستجو" >
         // <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?parent_page='.$parent_page.'&c_k_e='.$c_k_e.'&c_baste_='.$c_baste_.'&n_t_b_='.$n_t_b_.'\'">
        // </td>
       // </tr>
	  // </table>
	 // </td>
    // </tr>';
  // }
 echo' 
</table>
</div>
</form>
</body>
</html>';	
?>