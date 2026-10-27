<?php
//Define User Access rights
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="role_access.php";
$TableName="role_access";
$right_edt=0;
if (right(311)) $right_edt=1; 
$logtime=date('H:i:s');
 if(!isset($prev_php)) $prev_php="roles.php";
 if(!isset($sort)) $sort='d';
 if($update=='ثبت تغييرات')
 {if($new_role_id and $wrole_id!=$new_role_id) $zrole_id=$new_role_id; else $zrole_id=$wrole_id;
  //$logIns="";$logDel="";
  foreach($axarr as $key => $value )
  {$cnt=$db->get_from_where("count(*)","role_access","role_id='$zrole_id' and access_element='$key'");
   if($AccessRight[$key]=='on')
   { //We have checked this element
     if(!$cnt) {$db->query("insert into role_access (role_id,access_element) values ('$zrole_id','$key')");
	 //$logIns.="$key,";
	}
   }
   else
   { //We have not checked this element
     if($cnt) {$db->query("delete from role_access where role_id='$zrole_id' and access_element='$key'");
	 //$logDel.="$key,";
	 }
   }
  }
  //$log="role:$zrole_id ";if ($logIns) $log.="Added:$logIns "; if ($logDel) $log.="Removed:$logDel";
 // $db->query("insert into logtot (sys_id,org,year,method,des,user_id,user_date,ip) values 
  //('$wsys_id','$acc_org_id','$AccActiveYear','$FileName','$log','".$_SESSION['acc_user_id']."','".Date('Y-m-d H:i')."','".$_SERVER['REMOTE_ADDR']."')");
  echo "<script>alert('حدود دسترسي نقش ".$db->get_from_where("role_description","roles","role_id='$zrole_id'")." تغيير يافت');window.location='roles.php'</script>";
 }
 /*   End for update */ 
$titr='حدود دسترسی نقش ها';
require_once('head.html');
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="750px" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>';
  $role_desc=$db->get_from_where("role_description","roles","role_id='$wrole_id'");
  echo'
  <td class="title">جدول حدود اختيارات  <span style="color:yellow;">'.$role_desc.'</span></td>
 </tr>
 <tr>
 <td class="title"><input type=hidden name=wrole_id value='.$wrole_id.'>';
 if(($wrole_id==1)and(SuperUser())) echo'<input class="buttonme" type=submit id="sabt" name=update value="ثبت تغييرات">'; 
 else if(($right_edt)and($wrole_id!=1))echo'<input class="buttonme" type=submit id="sabt" name=update value="ثبت تغييرات">';    
 //if($right_edt) echo'<input class="buttonme" type=submit name=update value="ثبت تغييرات">';    
 echo'
    <input type="button" class="buttonme" value="بازگشت" onClick="window.location=\'roles.php?PageNo='.$PageNo.'\'"/>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="10%"><input type="checkbox" value="on" onClick=\'if(this.value=="on") this.value=doNow("on"); else this.value=doNow("off");\'></td>
	 <td width="20%">کد دسترسی</td>
	 <td width="70%">محل دسترسی</td>
	</tr>';
    for($i=1;$i<=count($axarr);$i++) $tm[$i]=$axarr[$i][1];
    // PHP 8 removed each(); this loop only walked the internal array pointer,\n    // which foreach() below does not depend on. end() puts the pointer at the\n    // last element, matching the old end state closely.\n    asort($tm); end($tm);
    $axarr_1=$axarr;
    if($sort=='code') $axarr_1=$tm;
    //$strategics=Array(38,53,54,55,56,57,58,59,63,85,86,87,88,89,90,94,108,143,144,145,167,168);
    foreach($axarr_1 as $del => $val)
    { if($sort=='code') $val_code=$val; else $val_code=$axarr[$del][1];
      $cnt1=$db->get_from_where("count(*)","role_access","role_id='$wrole_id'  and access_element='$del'");
      $checked='';
	  if($cnt1){$checked='checked';$colorme='style="background:#FFFEDB;color:#1E4263;font-size:14px;font-weight:bold;"';} 
	  else     {$checked='';$colorme='style="background:#DEF9FE;font-size:14px;"';}
      echo "
      <tr $colorme>";
      // if (in_array($del,$strategics)) echo 
      // <tr bgcolor=#BCCEE4 dir=rtl>";
       echo "
       <td align=center><input type=checkbox name=AccessRight[$del] $checked></td>
       <td align=right>$val_code</td>
       <td align=right>&nbsp&nbsp".$axarr[$del][0]."</td>
      </tr>";
    }//foreach
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr align="center">
	 <td><input type=hidden name=wrole_id value='.$wrole_id.'>';
	  if(($wrole_id==1)and(SuperUser())) echo'<input class="buttonme" type=submit id="sabt" name=update value="ثبت تغييرات">'; 
      else if(($right_edt)and($wrole_id!=1))echo'<input class="buttonme" type=submit id="sabt" name=update value="ثبت تغييرات">';
      //if ($right_edt) echo'<input class="buttonme" type=submit name=update value="ثبت تغييرات">';   
      echo'
      <input type="button" class="buttonme" value="بازگشت" onClick="window.location=\'roles.php?PageNo='.$PageNo.'\'"/>
	 </td> 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
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