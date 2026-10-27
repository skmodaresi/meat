	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <style type="text/css" media="print">
      div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    </style>
<?php
require_once __DIR__ . '/../../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
    include_once '../lib/php/general.php';
  
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
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '-2';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $u_id = !empty($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';
		 $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		 $sort_id = !empty($_REQUEST['sort_id']) ? $_REQUEST['sort_id'] : '1';
		 
		 global $outHtml;
		// $ph_mojavez = urlencode($ph_mojavez);
		
		if( $code_customer =='-2') {
			
			$report=0;
		}else{
			
			$queryc="SELECT * FROM dm_customer 
					    WHERE
					      code_customer=".$code_customer."
					    AND
					     customer_code_org=".$province_id."";
			$lnkc  = mysql_query($queryc);
	       $rowc= mysql_fetch_assoc($lnkc);
			$name_customer= $rowc['name_customer'];
			$report=1;
		}
		
$queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1fghnf='<div><table    align="center"  dir="rtl"  width="90%">
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
	echo $outHtml1;
	if($report==1){
	$outHtml = '
		
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> صورت ریز فاکتورهای صادره طی سال </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="8" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			 <td colspan="7">
        			 نام مشتری :
        			 '.$name_customer.'
        			 </td>';
        			
        		;
	
	
				if($ph_mojavez!=-2){
					
					$outHtml .= '<td colspan="6">
        			 شماره مجوز :
        			 '.$ph_mojavez.'
        			 </td>';
					
				}
	
	$outHtml .=' </tr>';
	
	
	}else{
		
		
		$outHtml = '	
		<div><table    align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="16"  style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="23" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> صورت ریز حواله های صادره طی سال </center> </th>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="11" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		';
		if($ph_mojavez!=-2){
					
					$outHtml .= '<td colspan="10">
        			 شماره مجوز :
        			 '.$ph_mojavez.'
        			 </td>';
					
				}
	
	$outHtml .=' </tr>';
		
	}
      $outHtml .= '	<tr>
			      		<td width="63" rowspan="2"><div align="center">ردیف</div></td>
			      		<td width="122" rowspan="2"><div align="center">تاریخ</div></td>
			      	    <td width="99" rowspan="2"><div align="center">شماره حواله </div></td>
			      		<td width="113" rowspan="2"><div align="center">وضعیت</div></td>
       					<td width="157" rowspan="2"><div align="center">نام مشتری </div></td>
       					<td colspan="2"><div align="center">مقدار کالا </div></td>
				        <td width="130" rowspan="2"><div align="center">شرح کالا </div></td>
				        <td width="104" rowspan="2"><div align="center">مبلغ</div></td>
				    	<td width="94" rowspan="2"><div align="center">شماره حسابداری </div></td>
				        <td width="105" rowspan="2"><div align="center">گروه کالا </div></td>   
				  </tr>
				  <tr>
				    <td width="127"><div align="center">خالص</div></td>
				    <td width="130"><div align="center">ابطالی</div></td>
				  </tr>';
				
		
$query = " 
	select c.* ,cus2.* ,cuscat.category_name,h_pre_amount,g_acc_name
from (
select h_code ,h_deli_name,h_p_add,g_acc_name,cat_prod_name,h_pre_amount, ph_code ,ebt.ebh_reg_date as date1,ebt2.ebh_reg_date as date, h_reg_date , ph_mojavez , p_name , p_sellprice ,p_sellpriceh, h_amount ,
 l_name , h_customer_code 
 , case when h.`h_status` = 1
  then 'ابطال کلی' else case when his.his_h_id is null then 'ابطال نشده' else 'ابطالی' end end as
   STATUS_EBTAL , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then 
   0 else his.`his_eb_amount` end end as MEGHDAR_EBTAL
   
    , case when h.`h_status` = 1 then h.`h_amount` else case when his.his_h_id is null then h.`h_amount`
     else  his.`his_pre_amount`    end end as MEGHDAR_PRE 
     
     , case when h.`h_status` = 1 then 0 else case when his.his_h_id is null then h.h_priceh  else h.h_priceh end end as SUM_price 
     from dm_havale h left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id."
    
     left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
     left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code  and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code  and ph_id_province=".$province_id."
      left join dm_operation_acc acc on acc.g_id=ph.ph_operation_id AND g_acc_org=3
      left join dm_pish_havale_det phd  on ph.ph_code=phd.phd_ph_code  and phd_id_province=".$province_id."
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` AND his_id_province=".$province_id."
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1  and ebt.ebh_id_province=".$province_id." 
      and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' )
      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." AND his_id_province=".$province_id."
      and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')


  )  ";
       	
//	print $query;		
			
if ($p_code != -2){
		
		$query .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$query .= " AND p_price_code = ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$query .= " AND p_type = ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$query .= " AND  p_category = ".$p_category ." ";
	}
if ($l_id != -2){
		
		$query .= " AND  h_l_code = ".$l_id ." ";
		$l_status=1;
	}
	
	if ($phd_deli_name != -2){
	
 $phd_deli_name1=str_replace("ی","ي",$phd_deli_name);
 $phd_deli_name2=str_replace("‍‍ي","ی",$phd_deli_name);

 
	
		$query .= " AND ( ( h_deli_name like '%".$phd_deli_name."%') OR  (h_deli_name like '%".$phd_deli_name1."%')
		OR  (h_deli_name like '%".$phd_deli_name2."%')) ";
	}
	
//if ($phd_deli_name != -2){
		 
//	
	//	$query .= " AND   h_deli_name like '%".$phd_deli_name."%'  ";
//	}
if ($p_pakage_type != -2){
		
		$query .= " AND   p_pakage_type = ".$p_pakage_type ." ";
	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies = ". $p_subsidies ." ";
	}	
	
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
	if ($ph_operation_id != -2){
		 
		$query .= "  AND   ph_operation_id = '". $ph_operation_id ."' ";
	}
		
	$query .= " group by `h_code` ,ebt.ebh_h_id, ebt2.ebh_h_id
         ) as c 
          
          left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";
	
	if ($code_customer != -2){
		
		$query .= " AND  h_customer_code= ". $code_customer ." ";
	}
	 
	$query .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
	if ($category_id != -2){
		 
		$query .= "  where   category_id= ". $category_id ." ";
	}
	
	if ($code_customer != -2 AND $city_id != -2){
		
		$query .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query .= " where  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query .= " where   customer_cusid_city= ". $city_id ." ";
	}
	
	 if ($sort_id ==1){
	$query .=" ORDER BY h_code asc,MEGHDAR_PRE desc  ";
	 }else {
	 	
	 	$query .=" ORDER BY h_customer_code asc,MEGHDAR_PRE desc  ";
	 	
	 }
//print $query;	
	
	$lnk1 = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	$amount=0;
	$price=0;
    $amountebtal=0;
    $MEGHDAR1=0;
	$MEGHDARPRE1=0;
    
   $pre=0;
  // print ($firstDate .'ta'. $EndDate);
	if(mysql_num_rows($lnk1)>0){
			$last_hcode=0;
			$last_hamount=0;
			$last_h_regdate=0;
		while($row = mysql_fetch_assoc($lnk1)){
			
		
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
						
		if($inx1==18){
		$outHtml .='</table><div class="page"></div>';
				
				$inx1=1;
				
				$outHtml .= '
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="12" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				             </table></div>';
			
	 	//<div align = "center">
				$outHtml .= '	
	
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr>
			      		<td width="63" rowspan="2"><div align="center">ردیف</div></td>
			      		<td width="122" rowspan="2"><div align="center">تاریخ</div></td>
			      	    <td width="99" rowspan="2"><div align="center">شماره حواله </div></td>
			      		<td width="113" rowspan="2"><div align="center">وضعیت</div></td>
       					<td width="157" rowspan="2"><div align="center">نام مشتری </div></td>
       					<td colspan="2"><div align="center">مقدار کالا </div></td>
				        <td width="130" rowspan="2"><div align="center">شرح کالا </div></td>
				        <td width="104" rowspan="2"><div align="center">مبلغ</div></td>
				    	<td width="94" rowspan="2"><div align="center">شماره حسابداری </div></td>
				        <td width="105" rowspan="2"><div align="center">گروه کالا </div></td>   
				  </tr>
				  <tr>
				    <td width="127"><div align="center">خالص</div></td>
				    <td width="130"><div align="center">ابطالی</div></td>
				  </tr>';
									            
			}	
			
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$province_id."  ";	
				   								     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								//print $queryc;
								//echo '<br>';
								$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$rowc['customer_cusid_city']."
									   ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);	
							
							//	print $querycity;
							//	echo '<br>';
					if(($inx)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
							
							$MEGHDAR =($row['MEGHDAR_PRE'])-($row['MEGHDAR_EBTAL']);
							$MEGHDARk =($row['MEGHDAR_PRE'])-($row['MEGHDAR_EBTAL']);
						//	echo $row['MEGHDAR_PRE'];
					if($row['MEGHDAR_EBTAL']==0){
						
						$jdateebtal="-----";
					}else if ($row['date']==''){
						
						$gdate=$row['date1'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdateebtal = $jyear."/".$jmonth."/".$jday;
						
					}else if ($row['date1']==''){
						
						$gdate=$row['date'];
						list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
						list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
						$jdateebtal = $jyear."/".$jmonth."/".$jday;
						
					}			
					$inx11 =urlencode($inx);
	                $inx11=farsinum($inx11);
					$h_code =farsinum($row['h_code']);
					$jdate =farsinum($jdate);
					$ph_code =farsinum($row['ph_code']);
					$jdateebtal =farsinum($jdateebtal);
					$ph_mojavez1 =farsinum($row['ph_mojavez']);
					$MEGHDARf =urlencode($MEGHDAR);
					$MEGHDARf =farsinum($MEGHDARf);
					$p_sellprice =farsinum($row['p_sellprice']);
					$SUM_price =farsinum($row['SUM_price']);
					$h_customer_code =farsinum($row['h_customer_code']);
					$MEGHDAR_PRE =farsinum($row['MEGHDAR_PRE']);
					$MEGHDAR_EBTAL =farsinum($row['MEGHDAR_EBTAL']);
					$hazineh=$row['h_p_add'];
                    $hazineh = urlencode($hazineh);
					$hazineh1 =farsinum($hazineh);
			$outHtml .= '
			
				<tr style="background-color:'.$color.';">
					
				    <td><div align="center">'.$inx11.'</div></td>
				    <td><div align="center">'.$jdate.'</div></td>
				    <td><div align="center">'.$h_code.'</div></td>
				    <td><div align="center">'.$row['STATUS_EBTAL'].'</div></td>
				    <td><div align="center">'.$rowc['name_customer'].'</div></td>
				    <td><div align="center">'.$MEGHDARf.'</div></td>
				    <td><div align="center">'.$MEGHDAR_EBTAL.'</div></td>
				    <td><div align="center">'.$row['p_name'].'</div></td>
				    <td><div align="center">'.$SUM_price.'</div></td>
				    <td><div align="center"></div></td>
				    <td><div align="center">'.$row['cat_prod_name'].'</div></td>
		
				</tr>';		
				
						
		if( $row['h_reg_date'] >= $firstDate and  $row['h_reg_date']<= $EndDate){
		
			if($row['h_code']==$last_hcode){
					
				
				}
				if($row['h_code']!=$last_hcode){
					
					$MEGHDAR1=$MEGHDAR1+$MEGHDARk;
					
					$MEGHDARPRE1=$MEGHDARPRE1+$row['h_pre_amount'];
					
						}else{
				}
				$last_hcode=$row['h_code'];
				$last_hamount=$MEGHDAR;
				$last_hpre_amount=$row['h_pre_amount'];
				$last_h_regdate = $row['h_reg_date'];
			
		}else{
		}
			$inx++;
			$inx1++;
			
		   $MEGHDAR =($row['MEGHDAR_PRE'])-($row['MEGHDAR_EBTAL']);
           $amount=$amount+$MEGHDAR;
		  
           $price=($price)+($row['SUM_price']);
           //echo $row['date'];
       if( ($row['date'] >= $firstDate AND $row['date'] <= $EndDate) or  ($row['date1'] >= $firstDate  AND $row['date1']<= $EndDate)){  
          
           $amountebtal=($amountebtal)+($row['MEGHDAR_EBTAL']);
      			
       
       }
			  $pre=$row['MEGHDAR_PRE']+$pre;   
			
		}
		
if( $last_h_regdate >=$firstDate and  $row['h_reg_date']<=$EndDate){
		//echo $last_hamount;	
				
			//$MEGHDAR1=$MEGHDAR1+$last_hamount;
}
                 $MEGHDARjf =urlencode($MEGHDAR1);
				$MEGHDARjf =farsinum($MEGHDARjf);
				 $pre1 =urlencode($pre);
				$pre1 =farsinum($pre1);
				$amountebtal1 =urlencode($amountebtal);
				$amountebtal1 =farsinum($amountebtal1);
		$outHtml656= '
			
				<tr style="background-color:#99CC33;">
			    	<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td  align="center" style="vertical-align:middle;">&nbsp;</td>	
					<td  align="center" style="vertical-align:middle;">&nbsp;</td>						
					<td  align="center" style="vertical-align:middle;">&nbsp;</td>	
					<td align="center" style="vertical-align:middle;">'.$MEGHDARjf.'كيلوگرم</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
				    <td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">&nbsp;</td>
					<td align="center" style="vertical-align:middle;">'.$pre1.'كيلوگرم</td>
					<td align="center" style="vertical-align:middle;">'.$amountebtal1.'كيلوگرم</td>	
				</tr>';	
				 	$khales=$MEGHDARPRE1 - $amountebtal;
				 	$khales =urlencode($khales);
	                //	$outHtml.= '</table><div>&nbsp;</div>
		           //       <span style="background-color:red" width="90%">جمع صادره:'.$MEGHDAR1.'كيلوگرم </span>' ;
$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="90%">جمع صادره اوليه:'.$MEGHDARPRE1.'كيلوگرم </span>' ;							  
		$outHtmlsds= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="90%">مبلغي كه بايد پرداخت شود:'.$price.'ريال </span>' ;			
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="90%">مقدار ابطالی:'.$amountebtal1.'كيلوگرم </span>' ;
		$outHtml.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="90%">مقدار خالص صادره:'.$khales.'كيلوگرم </span>' ;				
    }else{
    	$outHtml .= '<tr><td colspan="17">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }

    

    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
    $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
        $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        $outHtml .= '<div style="page-break-before:always";>&nbsp;</div>'; 
        echo $outHtml;
     echo $outHtml1; 
    
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