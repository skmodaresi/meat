	<?php
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'1' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '1000000000000000000000';
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
		 global $outHtml;
$query = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);

	$outHtml1='<div><table     align="center"  dir="rtl"  width="100%">
                   <tr>
                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $row['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';
	echo $outHtml1;
	
	$outHtml .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="21" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش حواله برای اداره کل بازرسی کشور </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف </td>
			        <td align="center"> شماره حواله</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> نام کالا</td>
			        <td align="center"> مقدار كالا</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام مشتري</td>			    		        		        
				</tr>';
		
	$query = "select *
			 From dm_havale h inner join dm_product p 
			on h.h_p_code=p.p_code left join dm_price price_p
			on p.p_id = price_p.price_p_id left join dm_prod_det_t  prod_t 
			on prod_t.type_prod_id=p.p_type left join dm_prod_det_p prod_p 
			on prod_p.pack_prod_id=p.p_pakage_type left join dm_prod_det_c prod_c 
			on prod_c.cat_prod_id=p.p_category left join dm_location_goods l 
			on l.l_id=h.h_l_code  
			WHERE  h_id_province=".$province_id."  

			AND h_id_year=".$year_id." and p_price_code=h_price_code ";
	if ($p_code != -2){
		
		$query .= "AND h_p_code=". $p_code ."";
	}
if ($p_price_code != -2){
		
		$query .= "AND p_price_code=". $p_price_code ."";
	}
if ($p_type != -2){
		
		$query .= "AND p_type=". $p_type ."";
	}
if ( $p_category != -2){
		
		$query .= "AND  p_category=".$p_category ."";
	}
if ($l_id != -2){
		
		$query .= "AND  h_l_code=".$l_id ."";
	}
if ($code_customer != -2){
		
		$query .= "AND  h_customer_code=".$code_customer ."";
	}
if ($p_pakage_type != -2){
		
		$query .= "AND   p_pakage_type=".$p_pakage_type ."";
	}
if ($p_subsidies != -2){
		
		$query .= "AND   p_subsidies=". $p_subsidies ."";
	}	
	$query .= "	AND
		     h_reg_date between   '".$firstDate."' AND  '".$EndDate."' ";
	
	print $query;		
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=1;
	$inx1=1;
	if(mysql_affected_rows()>0){
		$amount=0;
	
		while($row = mysql_fetch_assoc($lnk)){
						
				$gdate=$row['h_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
						
		if($inx1==20){
				
				$inx1=1;
				
				$outHtml .= '<tr><td colspan="10">&nbsp;</td>
				       </tr>
				         <td colspan="10">
								<table     align="center"  dir="rtl"  width="100%">
				                   <tr>
				                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $row['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 
				$outHtml .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="21" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش حواله برای اداره کل بازرسی کشور </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف </td>
			        <td align="center"> شماره حواله</td>
			        <td align="center"> تاريخ حواله</td>
			        <td align="center"> نام کالا</td>
			        <td align="center"> مقدار كالا</td>
			        <td align="center">محل انبار</td>
			        <td align="center">کد مشتري </td>
			        <td align="center">نام  مشتري</td>			    		        		        
				</tr>';
									            
			}	
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$province_id."";									     	     											
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
											
						
			$outHtml .= '
			
				<tr >
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$jdate.'</td>
					<td  align="center" style="vertical-align:middle;">'.$row['p_name'].'</div>					
					<td align="center" style="vertical-align:middle;">'.$row['h_amount'].'</td>
				    <td align="center" style="vertical-align:middle;">'.$row['l_name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['h_customer_code'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
				</tr>';			
			$inx++;
			$inx1++;
			           $amount=$row['h_amount']+$amount;
			
			
			
		}
				
		echo '<div>:مقداركل</div>' ;		
		echo '<div>'.$amount.'كيلوگرم</div>' ;
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr></table>';
    }
   header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=print.csv');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo $outHtml;
    