	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 header('Content-Type: text/html; charset=UTF-8');
    include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
  
    $day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	$day_number=farsinum($day_number);
    $month_number=farsinum($month_number);
	$year_number=farsinum( $year_number);
	
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
		 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'' ;
		 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '2';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $u_id = !empty($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez_hd']) ? $_REQUEST['ph_mojavez_hd'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '3';
		 
	
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml2='<div><table     align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="16"  style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';
	//echo $outHtml2;
	 $firstDatef1=farsinum($firstDatef);
	 $EndDatef1=farsinum($EndDatef);
	$outHtml = '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش پيش فاكتور ها </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="10" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>	
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>			      
			        <td align="center"> شماره پيش فاكتور</td>
			        <td align="center"> شماره پيش نويس</td>
			        <td align="center"> تاريخ پيش فاكتور</td>			     			      
			        <td align="center"> مبلغ پرداختی</td>			       
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			         <td align="center">نوع فروش</td>			      			       
			        <td align="center">وضعیت</td>			    		        		        
				</tr>';
		
	$query = " select * from dm_pish_havale ph
				left join dm_pish_factor pf 
				on ph.ph_code=pf.pf_ph_code AND
				 pf_id_province='".$province_id."'
				left join dm_pish_havale_det phd
				on phd.phd_ph_code=ph.ph_code
				 where
				 pf_reg_date between  '".$firstDate."' AND '".$EndDate."'
				 AND
				 pf_id_province='".$province_id."'
				 AND
				 ph_id_province='".$province_id."'
				 AND
				 phd_id_province='".$province_id."'
				 ";	
	if($code_customer != '-2')
	{
		
	$query .= " AND ph_customer_code=".$code_customer."";	
		
	}	
    $query .='  group by pf_code order by pf_code asc';
    
//print $query;
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	$amount=0;
	$price=0;
    $amountebtal=0;
	if(mysql_affected_rows()>0){
	
			
		while($row = mysql_fetch_assoc($lnk)){
							
				$gdate=$row['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
				$query1 = " select * from dm_havale
						    where
								   h_id_province='".$province_id."'
							AND					
								   h_pf_code=".$row['pf_code']."
								   
								   ";
				$lnk1 = mysql_query($query1);
				if(mysql_num_rows($lnk1)>0){
					$row1 = mysql_fetch_assoc($lnk1);
				$statuspf='حواله صادر شده';	
				$statuspf1=1;
				}else{
					$row1 = mysql_fetch_assoc($lnk1);
					$statuspf='حواله صادر نشده';
					$statuspf1=2;
				}				
		if($inx1==18){
				$outHtml .='</table><div class="page"></div>';
				$inx1=1;
				
				$outHtml .= '<tr colspan="29" align="center" style="height: 50px;vertical-align:middle;"><td colspan="16">&nbsp;</td>
				       </tr>
				   <tr><td colspan="19">&nbsp;</td>
				       </tr>
				         <td colspan="19">
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="20" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 
				$outHtml .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="25" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش پيش فاكتور </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>			      
			        <td align="center"> شماره پيش فاكتور</td>
			        <td align="center"> شماره پيش نويس</td>
			        <td align="center"> تاريخ پيش فاكتور</td>			     			      
			        <td align="center"> مبلغ پرداختی</td>			       
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>
			         <td align="center">نوع فروش</td>			      			       
			        <td align="center">وضعیت</td>			    		        		        
				</tr>';
									            
			}	
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['ph_customer_code']."
									    AND
									     customer_code_org=".$province_id."";									     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								
					if(($inx)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
		
		            $jdate=farsinum($jdate);	
					$inx1 =urlencode($inx);
                    $inx1=farsinum($inx1);	
                    $pf_code=farsinum($row['pf_code']);	
                    $pf_ph_code=farsinum($row['pf_ph_code']);
                    $pf_totalprice=farsinum($row['pf_totalprice']);
                    $ph_customer_code=farsinum($row['ph_customer_code']);	
                    
                    $queryt="SELECT * FROM dm_type_sell 
									    WHERE
									      dts_id=".$row['ph_types']."
									   ";									     	     											
								$lnkt = mysql_query($queryt);
								$rowt = mysql_fetch_assoc($lnkt);	
                    
         //enja
		 if($status==3)
         {
			$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['ph_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$pf_totalprice.'</td>	
				    <td align="center" style="vertical-align:middle;">'.$row['ph_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowt['dts_name'].'</td>
					
					<td align="center" style="vertical-align:middle;">'.$statuspf.'</td>
		
				</tr>';			
			$inx++;
			$inx1++;

         }else if(($status==1) AND ($statuspf1==1))
         {
         	
         	$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_ph_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['pf_totalprice'].'</td>	
				    <td align="center" style="vertical-align:middle;">'.$row['ph_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowt['dts_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$statuspf.'</td>
		
				</tr>';			
			$inx++;
			$inx1++;
         	
         	
         	
         }else if(($status==2) AND ($statuspf1==2))
         {
         	
         	$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx1.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['pf_ph_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['pf_totalprice'].'</td>	
				    <td align="center" style="vertical-align:middle;">'.$row['ph_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowt['dts_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$statuspf.'</td>
		
				</tr>';			
			$inx++;
			$inx1++;
         	
         	
         	
         }		
			
			
		}
	    
       	
    }else{
    	$outHtml .= '<tr><td colspan="19">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }

    
       $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        $outHtml .= '<div style="page-break-before:always";>&nbsp;</div>'; 
   //     echo $outHtml1;
     echo $outHtml; 
    function farsinum( $data )
{
$newstr = "";
$i = 0;
for ( ; $i < strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "0" )
{
$nstr = str_replace( "0", "۰", $str );
}
if ( $str == "1" )
{
$nstr = str_replace( "1", "۱", $str );
}
if ( $str == "2" )
{
$nstr = str_replace( "2", "۲", $str );
}
if ( $str == "3" )
{
$nstr = str_replace( "3", "۳", $str );
}
if ( $str == "4" )
{
$nstr = str_replace( "4", "۴", $str );
}
if ( $str == "5" )
{
$nstr = str_replace( "5", "۵", $str );
}
if ( $str == "6" )
{
$nstr = str_replace( "6", "۶", $str );
}
if ( $str == "7" )
{
$nstr = str_replace( "7", "۷", $str );
}
if ( $str == "8" )
{
$nstr = str_replace( "8", "۸", $str );
}
if ( $str == "9" )
{
$nstr = str_replace( "9", "۹", $str );
}
$newstr .= $nstr;
}
return $newstr;
}
 
 

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
     