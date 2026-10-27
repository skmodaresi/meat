<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  
</head> 	
<?php
require_once __DIR__ . '/../../mysql_compat.php';

	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
  header('Content-Type: text/html; charset=UTF-8');

         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
		 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'2010-01-01' ;
		 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '2018-03-01';
		 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
		 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '2';		 
		 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
		 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
		 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '-2';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
		 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
		 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
		 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
		 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
		 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
		 $category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-2';				 
		 $ph_operation_id = !empty($_REQUEST['ph_operation_id']) ? $_REQUEST['ph_operation_id'] : '-2';
		 $ph_mojavez = !empty($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '-2';
		 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '-2';
		 $phd_deli_name = !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '-2';
		 
		 $jam=0;
        $jam1=0;
		if( $code_customer =='2-') {
			
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
	$outHtml1='';  
   $queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);

	$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
                   <tr>
                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
   
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
             </table></div>';
$lnkk = mysql_query("SELECT * FROM dm_operation_acc  where g_id=".$ph_operation_id." ");
	$rowk=mysql_fetch_assoc($lnkk);
	$firstDatef1= farsinum( $firstDatef );
	$EndDatef1= farsinum( $EndDatef );
	$province_ecode= farsinum( $rowp['province_ecode'] );
	 if($ph_operation_id !=-2){
	 	
	 	$outHtml1 .= '<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
	
        		<tr class="rw1">
        			<td colspan="15" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش تجمعی بر اساس مشتری </center> </td>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="9" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef1.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef1.'  </td>';
	$outHtml1 .= '<td   colspan="7" style="height: 50px;vertical-align:middle;">نوع عملیات:'.$rowk['g_acc_name'].' </td>';
        			
        	$outHtml1 .= '	</tr>';
	 	
	 	
	 }else{
	$outHtml1 .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
	
        		<tr class="rw1">
        			<td colspan="15" align="center" style="height: 50px;vertical-align:middle;"><center> گزارش تجمعی بر اساس مشتری </center> </td>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="15" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef1.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef1.'  </td>';
	
        			
        	$outHtml1 .= '	</tr>';
	
	 }
        	
        	$outHtml1 .= '	<tr class="rw1">
        			<td   colspan="6" style="height: 50px;vertical-align:middle;"> كد اقتصادي فروشنده  : '.$province_ecode.'  </td>
        			
        			<td   colspan="10" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   :
        			 '.$rowp['province_address'].'  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			        <td align="center">رديف </td>
					<td align="center">كد مشتری </td>
					<td align="center">نام مشتری </td>
					<td align="center">کد ملی/شناسه ملی </td>
					<td align="center">کد اقتصادی </td>
					<td align="center">کد پستی </td>
					<td align="center">آدرس </td>
			        <td align="center"> كد كالا</td>
			        <td align="center"> كد قيمت</td>
			        <td align="center"> نام كالا</td>
			        <td align="center">قيمت واحد</td>
			       
			        <td align="center"> دسته کالا</td>
			        <td align="center">مقدار صادره</td>
			        <td align="center">مقدار ابطال شده </td>
			        <td align="center">مبلغ قابل پرداخت </td>				      		        	        			      		      				    		        		        
				</tr>';
		
        	
        	
     
        	
      $query = "select p_name,h_customer_code,h_p_code,h_price_code,l_name,h_p_add,p_sellprice,p_sellpriceh, p_price_code,`cat_prod_name`

		 ,sum(case when havaleinBaze = 1  then shavale else 0 end) 
     		 
		 shavale ,
		
(

   select sum(h_pre_amount) from `dm_havale` hh 
    left join dm_customer cust on cust.code_customer=hh.h_customer_code 
    
    and cust.`customer_province_id` = ".$province_id."
    left join dm_customer_category cuscat on cust.customer_category=cuscat.category_id 
    
    
    
   left join dm_pish_factor pf on hh.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
   where ";
   if ($category_id != -2){
		 
		$query .= "    category_id= ". $category_id ." and ";
	}
   
  $query .= " hh.`h_reg_date`
      between '".$firstDate."'  AND  '".$EndDate."' 
      and  h_id_province=".$province_id." 
      and hh.h_p_code= p_code
      and hh.h_price_code = p_price_code 
      and hh.h_p_add = h_p_add2
      and hh.h_customer_code=h_customer_code2
      ";
      if ($l_id != -2){
		
		$query .= " AND  h_l_code= ".$l_id ." ";
	}
    if ($code_customer != -2 AND $city_id != -2){
		
		$query .= " And  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query .= " And  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query .= " And   customer_cusid_city= ". $city_id ." ";
	}
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
	if ($ph_operation_id != -2){
		 
		$query .= "  AND   ph_operation_id = '". $ph_operation_id ."' ";
	}
	if ($phd_deli_name != -2){
		 
		$query .= " AND   h_deli_name like '%".$phd_deli_name."%'  ";
	}
	
	//print $query;
$query .= ") as shavalepre
				  
		 ,sum(case when EbtalInBaze = 0 then sebtal else 0 end ) sebtalkharej 
		 ,sum(case when EbtalInBaze = 1 then sebtal else 0 end ) sebtalDakhel
		 ,sum(SUM_price)  sprice
         ,p_code
    

 from ( select h_code ,h_price_code,h_p_code,h_p_add, ph_code ,p_sellpriceh,IFNULL(ebt.`ebh_id`,ebt2.`ebh_id`) as ebh_id,h_reg_date , ph_mojavez , p_name , p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name
  , h_customer_code , case when h.`h_status` = 1 then 'ابطال کلي' else case when his.his_h_id is null
   then 'ابطال نشده' else 'ابطال جزئي' end end as STATUS_EBTAL ,

  case when ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'    or ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'   then case when h.`h_status` = 1
  then h.`h_amount` else case when his.his_h_id is null then 0 else his.`his_eb_amount` end end  else 0 end as sebtal ,    
  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then case when h.`h_status` = 1 then  0     else  h.`h_amount`  end  end  as shavale, 
   CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then   h.`h_pre_amount`  else  0  end  as shavalepr , 

         
    (case when (  ( (`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) and (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) then (case when (`h`.`h_status` = 1) then `h`.`h_amount` else (case when isnull(`his`.`his_h_id`) then 0 else `his`.`his_eb_amount` end) end) else 0 end) AS `sebtalBaze`,
    
     case when h.`h_status` = 1 
      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price ,
      
          (case when (((`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ))) then 1 else 0 end) AS `EbtalInBaze`,
    (case when (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."') then 1 else 0 end) AS `havaleInBaze`
      ,h.h_status
      
      ,count(ebt.ebh_h_id)+1   as ebtcnt  
      
      , h_p_add h_p_add2
      
      ,h_customer_code h_customer_code2
      
      from dm_havale h 
      left join dm_product p on h.h_p_code=p.p_code and h_id_province=".$province_id." 
      left join dm_price price on p.p_id=price.price_p_id and price.`p_price_code`=h.`h_price_code`
      left join dm_prod_det_t prod_t on prod_t.type_prod_id=p.p_type 
      left join dm_prod_det_p prod_p on prod_p.pack_prod_id=p.p_pakage_type 
      left join dm_prod_det_c prod_c on prod_c.cat_prod_id=p.p_category 
      left join dm_location_goods l on l.l_id=h.h_l_code 
      left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province=".$province_id."
      left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code and ph_id_province=".$province_id." 
      left join `dm_his_havale` his on his.`his_h_id` = h.`h_id` 
      left join dm_ebtal_h ebt on h.h_id=ebt.ebh_h_id and ebt.ebh_type=1 and ebt.ebh_id_province=".$province_id." and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."' ) 
      left join dm_ebtal_h ebt2 on his.his_id=ebt2.ebh_h_id and ebt2.ebh_type=0 and ebt2.ebh_id_province=".$province_id." and (ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
        where (( h_id_province=".$province_id." and (ebt.ebh_id_province=".$province_id." or ebt.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id."
  and ph_id_province=".$province_id." )and(  ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')
  
  or

   ( h_id_province=".$province_id." and ( ebt2.ebh_id_province=".$province_id." or ebt2.ebh_id_province is null)
  and price_id_province=".$province_id." and l_id_province=".$province_id." and pf_id_province=".$province_id." and
  ph_id_province=".$province_id." )
and (ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."' or h.h_reg_date between '".$firstDate."'  AND  '".$EndDate."')

  )";
					
if ($p_code != -2){
		
		$query .= "  AND h_p_code= ". $p_code ." ";
	}
if ($p_price_code != -2){
		
		$query .= " AND p_price_code= ". $p_price_code ." ";
	}
if ($p_type != -2){
		
		$query .= " AND p_type= ". $p_type ." ";
	}
if ( $p_category != -2){
		
		$query .= " AND  p_category= ".$p_category ." ";
	}
if ($l_id != -2){
		
		$query .= " AND  h_l_code= ".$l_id ." ";
		
	}
if ($phd_deli_name != -2){
		 
		$query .= " AND   h_deli_name like '%".$phd_deli_name."%'  ";
	}
//if ($p_pakage_type != -2){
//		
//		$query .= " AND   p_pakage_type= ".$p_pakage_type ." ";
//	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	if ($ph_mojavez != -2){
		 
		$query .= "  AND   ph_mojavez = '". $ph_mojavez ."' ";
	}
	if ($ph_operation_id != -2){
		 
		$query .= "  AND   ph_operation_id = '". $ph_operation_id ."' ";
	}
	$query .= "	group by `h_code`,ebt.`ebh_id`,ebt2.`ebh_id` )  ";
	$query .= " as c ";			
    $query .= " left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";


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
	
 //   $query .= " group by  h_customer_code,h_p_code,h_price_code,h_p_add
   //      ORDER BY  p_name, p_price_code asc";
	    	
    $query .= " group by  code_customer,p_code, p_price_code,h_p_add 
         ORDER BY  p_name, p_price_code asc";    	
               	
	
//	print $query;	
	$lnk = mysql_query($query);
	global $inx1;
	global $inx11;
	$inx1=1;
	$inx2=1;
	$inx11=1;
	if(mysql_affected_rows()>0){
		$amount=0;
	    $ebtal=0;
	    $sadere=0;
	
		
	
		while($row = mysql_fetch_assoc($lnk)){
						
//				$gdate=$row['h_reg_date'];
//			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
//			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
//			$jdate = $jyear."/".$jmonth."/".$jday;
						
		if($inx11==20){
				
				$inx11=1;
				
				$outHtml1 .= '<tr colspan="27" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
				       </tr>
				   <tr><td colspan="17">&nbsp;</td>
				       </tr>
				         <td colspan="17">
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				              </td>
                   
				
				</tr></table></div>';
			
	 
				$outHtml1 .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<td colspan="28" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center> گزارش تجمعی بر اساس مشتری  </center> </td>
        		</tr>
        		<tr class="rw1">
        			<td   colspan="16" style="height: 50px;vertical-align:middle;"> از تاريخ &nbsp; : '.$firstDatef.'  
        			&nbsp;&nbsp;&nbsp;
        			&nbsp;&nbsp;&nbsp;
        			  تا تاريخ    :
        			 '.$EndDatef.'  </td>
        			
        		</tr>
        		<tr class="rw1">
        			<td   colspan="6" style="height: 50px;vertical-align:middle;"> كد اقتصادي فروشنده  : '.$rowp['province_ecode'].'  </td>
        			
        			<td   colspan="11" style="height: 50px;vertical-align:middle;">  آدرس فروشنده   :
        			 '.$rowp['province_address'].'  </td>
        			
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			       <td align="center">رديف </td>
				   <td align="center">كد مشتری </td>
					<td align="center">نام مشتری </td>
					<td align="center">نام مشتری </td>
					<td align="center">کد ملی/شناسه ملی </td>
					<td align="center">کد اقتصادی </td>
					<td align="center">کد پستی </td>
					<td align="center">آدرس </td>
					
			        <td align="center"> كد كالا</td>
			        <td align="center"> كد قيمت</td>
			        <td align="center"> نام كالا</td>
			        
			        <td align="center"> قيمت واحد </td>
			     
			        <td align="center"> دسته کالا</td>
			        <td align="center">مقدار صادره</td>
	                <td align="center">مقدار ابطال شده </td>	          
			        <td align="center">مبلغ قابل پرداخت </td>				      		        	        
	    		        		        
				</tr>';
									            
			}	
			  //  <td align="center"> هزينه هر واحد</td>
			if($inx2==18){
		$outHtml1 .='</table><div class="page"></div>';
		
		$inx2=1;
				
				$outHtml1 .= '
								<table     align="center"  dir="rtl"  width="90%">
				                   <tr>
				                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
				   
				                   </tr>
				                   <tr>
				                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="18" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $rowp['province_name'] .'</b></td>
				                                               
				                    </tr>
				                    <tr> 
				                         <td colspan="12" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
				                        
				                    </tr>
				                    </table>
				             </table></div>';
			
	 	
				$outHtml1 .= '	
		<div align = "center">
		<div align = "center" style="direction:rtl;">
			<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
      			<tr class="rw1">
        			<th colspan="27" align="center" style="height: 50px;vertical-align:middle;background-color:#BBB;"><center>گزارش تجمعی بر اساس مشتری  </center> </th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;background-color:#BBF0F7;">
			       <td align="center">رديف </td>
				   <td align="center">كد مشتری </td>
					<td align="center">نام مشتری </td>
					<td align="center">کد ملی/شناسه ملی </td>
					<td align="center">کد اقتصادی </td>
					<td align="center">کد پستی </td>
					<td align="center">آدرس </td>
					
			        <td align="center"> كد كالا</td>
			        <td align="center"> كد قيمت</td>
			        <td align="center"> نام كالا</td>
			        
			        <td align="center"> قيمت واحد </td>
			        
			        <td align="center"> دسته کالا</td>
			        <td align="center">مقدار صادره</td>
	                <td align="center">مقدار ابطال شده </td>	          
			        <td align="center">مبلغ قابل پرداخت </td>';

		}
	// <td align="center"> هزينه هر واحد</td>
			$queryc="SELECT * FROM dm_customer 
									    WHERE
									      code_customer=".$row['h_customer_code']."
									    AND
									     customer_code_org=".$province_id."";	
//print 	$queryc;									 
								$lnkc = mysql_query($queryc);
								$rowc = mysql_fetch_assoc($lnkc);	
								$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$row['customer_cusid_city']."
									   ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);	
							$querypro="SELECT * FROM dm_province 
									    WHERE
									      province_id=".$province_id."
									    ";									     	     											
								$lnkpro = mysql_query($querypro);
								$rowpro = mysql_fetch_assoc($lnkpro);
					if(($inx1)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
		                    // if($row['shavale']> $row['sebtal']){
								//}else{
								 
									$sadere=$row['shavalepre']+$sadere;
							//	}				
							
	     $inx11 =urlencode($inx1);
	     $inx11=farsinum($inx11);
	     $p_code =urlencode($row['p_code']);
	     $p_code=farsinum($p_code);
	     $p_price_code =urlencode($row['p_price_code']);
	     $p_price_code=farsinum($p_price_code);
	     $shavalepre=formatMoney($row['shavalepre']);
	     $shavalepre=farsinum($shavalepre);
	      $p_sellprice=farsinum($row['p_sellprice']);
	     $shavale=formatMoney($shavale);
	     $shavale=farsinum( $shavale);
	     $shavale=farsinum($row['shavale']);
	     $shavale=formatMoney($shavale);
	     $shavale=farsinum( $shavale);			
		 $sebtal=formatMoney($row['sebtal']);	
		 $sebtal=farsinum($sebtal);
	     $mande1 =urlencode($mande);
		 $mande1=formatMoney($mande1);
	     $mande1=farsinum($mande1);
	     $jam = ($row['shavalepre']* $row['p_sellprice']);
	    $jam= urlencode($jam);
	     $sumprice = $row['shavalepre']* $row['p_sellprice'];
	     $sumprice=urlencode($sumprice);
	     $sumprice =urlencode($sumprice);
		 $sumprice=formatMoney($sumprice);
	     $sumprice =farsinum($sumprice);
	    
	   $sebtalDakhel= farsinum($row['sebtalDakhel']);
	    $code_customer= farsinum($rowc['code_customer']);
	    $hazineh=$row['h_p_add'];
        // $hazineh = urlencode($hazineh);
	   $hazineh1 =farsinum($hazineh);
	   
	   if($rowc['customer_national_tax'] ==''){
	   	
	   	$code_meli=$rowc['customer_gl_code'];
	   	
	   }else if($rowc['customer_national_tax'] ==0){
	   	
	   	$code_meli=$rowc['customer_gl_code'];
	   	
	   }else{
	   	
	   	$code_meli=$rowc['customer_national_tax'];
	   	
	   	
	   }
	
	
			$outHtml1 .= '
			
				<tr style="background-color:'.$color.';">
					<td align="center" style="vertical-align:middle;">'.$inx11.'</td>
					<td align="center" style="vertical-align:middle;">'.$code_customer.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['name_customer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$code_meli.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['customer_gl_economic'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['code_postal_costumer'].'</td>
					<td align="center" style="vertical-align:middle;">'.$rowc['customer_address_office'].'</td>
					<td align="center" style="vertical-align:middle;">'.$p_code.'</td>
					<td  align="center" style="vertical-align:middle;">'.$p_price_code.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['p_name'].'</td>	
					<td align="center" style="vertical-align:middle;">'.$p_sellprice.'</td>							
					<td align="center" style="vertical-align:middle;">'.$row['cat_prod_name'].'</td>	
						<td align="center" style="vertical-align:middle;">'.$shavalepre.'</td>
					
					<td align="center" style="vertical-align:middle;">'.$sebtalDakhel.'</td>				  
					<td align="center" style="vertical-align:middle;">'.$sumprice.'</td>
					<td align="center" style="vertical-align:middle;">'.$rowcity['city_name'].'</td>					
				
				</tr>';			
			$inx1++;
			$inx2++;
			$inx11++;
			   $jam1=($jam1+$jam);
			  $jam1= urlencode($jam1);
			$amount=$amount+$mande;
			$ebtal=$ebtal+$row['sebtalDakhel'];
			
			
			$amount1=formatMoney($amount);
			$ebtal1=formatMoney($ebtal);
		//	$jam1=formatMoney($jam1);
			
	
		}
		 //$jam1= farsinum($jam1);		
		$outHtml1.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدارصادره:'.$sadere.'كيلوگرم </span>' ;		
		$outHtml1.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$ebtal1.'كيلوگرم </span>' ;	
		$outHtml1.= '</table><div>&nbsp;</div>
		                  <span style="background-color:red" width="70%">مبلغ پرداختی:'.$jam1.'ریال </span>' ;							
    }else{
    	$outHtml1 .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
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
        function farsinum( $data )
{
$newstr = "";
$i = 0;
for ( ; $i <= strlen( $data ); ++$i )
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
 
  function farsichar( $data )
{
$newstr = "";
$i = 0;
for ( ; $i <= strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "ی" )
{
$nstr = str_replace( "ي", "ی", $str );
}
if ( $str == "۱" )
{
$nstr = str_replace( "ا", "۱", $str );
}
if ( $str == "ک" )
{
$nstr = str_replace( "ك", "ک", $str );
}

$newstr .= $nstr;
}
return $newstr;
}
function datesys(){
	
 return gmdate('Y-m-d');
//return	gmdate('Y-m-d H:i:s', strtotime('+6 days'));

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
    