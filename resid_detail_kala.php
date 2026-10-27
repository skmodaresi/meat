<?php
echo'
<table width="50%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <!--<td class="title">
   <div style="position:absolute;top:5px;left:40%;">  کالاهای موجود در این رسید</div>
  </td>-->	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="" align="center">
	 <td width="30%">تاریخ تولید</td>
	 <td width="25%">تعداد کارتن</td>
	 <td width="30%">وزن ناخالص</td>
	 <td width="15%">حذف</td>
	</tr>';
	$j=0;
    // $majmo_vazn_nakhales=0;	
    // $majmo_tedad_karton=0;	
    // $majmo_sum_karton_r_d_this=0;	
    // $majmo_vazn_khales_r_d=0;	
    //$q_d_kala="SELECT * From resid_kala_detail WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND shomare_resid='$shomare_resid' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear";	
    $q_d_kala="SELECT * From resid_kala_detail WHERE shomare_resid='$shomare_resid' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear";	
	$all_d_kala = $db->query($q_d_kala);
    while($row_d_kala=$db->fetch_assoc($all_d_kala))
	{
     //if($right_edt)
	 $edtClick='onClick="window.location=\''.$FileName.'?Mode=Editdetail&id_='.$row_d_kala['id'].'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';
	 if($j++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
     echo'
	  <td '.$edtClick.'>'.$row_d_kala['sal_tolid_shamsi'].' - '.$mahshamsiArr[$row_d_kala['mah_tolid_shamsi']].'</td>
	  <td '.$edtClick.'>'.$row_d_kala['tedad_karton_r_d_sub'].'</td>
	  <td '.$edtClick.'>'.$row_d_kala['vazn_nakhales_r_d_sub'].'</td>
	  <td>';	  
      // $q="SELECT * from mojody_kala where code_kala=".$row_d_kala['code_kala']." AND code_keshvar=".$row_d_kala['code_keshvar']." AND sal_tolid_shamsi=".$row_d_kala['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_d_kala['mah_tolid_shamsi']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$gl_code_sardkhane AND year=$mtActiveYear AND deleted=0";     
      // //echo $q;
	  // $res=$db->query($q);
      // $row=$db->fetch_assoc($res);
	  echo'<img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x_detail=1&id_='.$row_d_kala['id'].'&tedad_karton_r_d_='.$row_d_kala['tedad_karton_r_d'].'&vazn_nakhales_r_d_='.$row_d_kala['vazn_nakhales_r_d'].'&vazn_khales_r_d_='.$row_d_kala['vazn_khales_r_d'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف کالای  '.$row_d_kala['nameKala'].'\')" />';

	  	  // echo'<img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       // onmouseOver="this.src=\'images/trash_hover.png\'" 
		   // onmouseOut="this.src=\'images/trash.png\'" 
		   // onClick="iconfirm(\''.$FileName.'?Delete_x_detail=1&id_='.$row_d_kala['id'].'&tedad_karton_='.$row['tedad_karton'].'&tedad_karton_r_d_='.$row_d_kala['tedad_karton_r_d'].'&mojody_nakhales_='.$row['mojody_nakhales'].'&vazn_nakhales_r_d_='.$row_d_kala['vazn_nakhales_r_d'].'&mojody_khales_='.$row['mojody_khales'].'&vazn_khales_r_d_='.$row_d_kala['vazn_khales_r_d'].'&code_kala_='.$row['code_kala'].'&code_keshvar_='.$row['code_keshvar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف کالای  '.$row_d_kala['nameKala'].'\')" />';	  
	  echo'
	  </td>
	</tr>';
	// $majmo_vazn_nakhales+=$row_d_kala['vazn_nakhales_r_d'];
	// $majmo_tedad_karton+=$row_d_kala['tedad_karton_r_d'];
	// $majmo_sum_karton_r_d_this+=$row_d_kala['sum_karton_r_d_this'];
	// $majmo_vazn_khales_r_d+=$row_d_kala['vazn_khales_r_d'];
	}
	echo'
	    <!--<tr class=""> 
	     <td colspan="2">مجموع مقادیر</td>
	     <td>'.$majmo_vazn_nakhales.'</td>
	     <td>'.$majmo_tedad_karton.'</td>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>'.$majmo_sum_karton_r_d_this.'</td>
	     <td>'.$majmo_vazn_khales_r_d.'</td>
	     <td>&nbsp;</td>
	    </tr>-->
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->	
</table>';
?>	