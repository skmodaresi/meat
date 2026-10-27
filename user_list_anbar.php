<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="user_list_sardkhane.php";
$TableName="list_sardkhane";
$titr='تعیین دسترسی کاربر به سردخانه ها';
$nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$c_ostan_'");
if(isset($_POST['Insert_x']))
{
  //تعیین سردخانه پیش فرض
  IF($_POST['anbar_default'])
  {
   IF($befor_default)  $change_default=mysql_query("UPDATE user_ostan_anbar SET anbar_default='0' WHERE user_id='$u_id_' AND code_ostan='$c_ostan_' AND code_anbar='$befor_default' ");
   $change_default=mysql_query("UPDATE user_ostan_anbar SET anbar_default='1' WHERE user_id='$u_id_' AND code_ostan='$c_ostan_' AND code_anbar='$anbar_default' ");
  }
  foreach($_POST['chkcontact'] as $k=>$v)
  {
   if($v)
   {if(!$_POST['old_chkcontact'][$k])
    $change=mysql_query("insert into user_ostan_anbar (user_id,code_ostan,code_anbar) values ('$u_id_','$c_ostan_','$k')");
    //echo"<script>alert('تغییرات انجام شد')</script>";
    echo"
	<script>
     window.close();
	 window.opener.location='users.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	</script>"; 
	//echo "insert into group_contact (g_id,contact_id) values ('$groupID','$k')";
   }
  }
  if(isset($_POST['old_chkcontact']))
  {foreach($_POST['old_chkcontact'] as $m=>$n)
   {
   // echo 'old='.$m.'<br>';
    if(!$_POST['chkcontact'][$m])
    $change =mysql_query("delete from user_ostan_anbar where user_id='$u_id_' and code_ostan='$c_ostan_' and code_anbar='$m'");
    echo"
	<script>
     window.close();
	 window.opener.location='users.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	</script>"; 
	//echo"<script>alert('تغییرات انجام شد')</script>";
	// echo "delete from group_contact where g_id='$groupID' and contact_id='$m'";
   }
  }
}
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
</script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr> 
  <td class="title">تعیین دسترسی کاربر '.$u_id_.' به سردخانه های استان '.$nameOstan.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   	<tr class="table-title">
	 <td widht="10%"><input type="checkbox" value="on" onClick=\'if(this.value=="on") this.value=doNow("on"); else this.value=doNow("off");\'></td>
	 <td width="25%">کد سردخانه</td>
	 <td width="50%">نام سردخانه</td>
	 <td width="15%">وضعیت</td>
	</tr>'; 
   $i=0;
   //$q="SELECT * From list_sardkhane WHERE code_ostan=$c_ostan_";  	
   $all=mysql_query("SELECT *,
        (select code_anbar from user_ostan_anbar where code_anbar=c.code_anbar AND user_id='$u_id_' AND code_ostan=$c_ostan_) c_id
	    FROM list_sardkhane c where code_ostan=$c_ostan_ ORDER BY name_anbar");
		// $all=mysql_query("SELECT *,
        // (select code_anbar from user_ostan_anbar where code_anbar=c.code_anbar AND user_id='".$_SESSION['mt_user_id']."' AND code_ostan=$c_ostan_) c_id
	    // FROM list_sardkhane c where code_ostan=$c_ostan_"); 
	//while($row=$db->fetch_assoc($AnbarForOstan))
	while($row=$db->fetch_assoc($all))
	{
	  if($row['c_id']) 
	  {$checked="checked";$colorme='style="background:#FFFEDB;font-size:14px;"';	  
	    echo '<input type="hidden" name="old_chkcontact['.$row['c_id'].']" value="1"/>';
	   //echo '<td><input type="text" name="old_chkcontact['.$row['c_id'].']" value="1"/></td>';
	  } 
	  else {$checked="";$colorme='';}
     if($i++%2)
     echo'
     <tr class="table-odd" '.$colorme.'/>';
     else echo '
     <tr class="table-even" '.$colorme.'/>';
	  echo '
	  <td> 
	   <input type="checkbox" id="box1" name="chkcontact['.$row['code_anbar'].']" value="1" '.$checked .'/>
	  </td>
	  <td>'.$row['code_anbar'].'</td>
	  <td>'.$row['name_anbar'].'</td>
	  <td '; IF($row['activate']==1) echo 'class="active"'; IF($row['activate']==2) echo 'class="deactive"';  echo'>'.$activateArr[$row['activate']].'</td>
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>';
 $befor_default=$db->get_from_where("code_anbar","user_ostan_anbar","user_id='$u_id_' AND code_ostan='$c_ostan_' AND anbar_default=1");
 echo'
 <tr style="height:55px">
  <input type="hidden" name="befor_default" value='.$befor_default.' >
  <td class="table-title">انتخاب سردخانه پیش فرض : '.listbox("anbar_default",$befor_default,"list_sardkhane.code_anbar","list_sardkhane.name_anbar","list_sardkhane INNER JOIN user_ostan_anbar ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","user_id='$u_id_' AND list_sardkhane.code_ostan=$c_ostan_ ORDER BY list_sardkhane.name_anbar ASC","class='text2'").'</td>	 
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">	  			
	<tr align="center">
	 <td width="100%">
	  <input type="submit" class="buttonme" name="Insert_x" id="sabt" value="ثبت اطلاعات">	 
	  <!--<input type="hidden" name="Insert_x" >
	     <img border=0 src=images/taeed.png width=70 height=22 style="cursor:pointer" 
		  onclick="document.myform.Insert_x.value=1;myform.submit()" onmouseOver="this.src=\'images/taeed_hover.png\'"
          onmouseOut="this.src=\'images/taeed.png\'"/>-->
	 </td>	 
	 <!--<td align=right><input class=buttonme type="submit" name="Insert_x" value="ذخيره" /></td>-->
	 <!--<td width="20">&nbsp;</td><td width="70"><div onClick="window.location=\''.$prev_php.'?pageNo='.$pageMaster.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td>-->	 	 
	</tr>
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->
</table>
</div>
</form>
</body>
</html>';	
?>