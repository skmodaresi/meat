<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head> 
<style type="text/css">
body {
	font: 16px Arial,Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	 
	
}
#hcss{
       border-top-width: 1px;
       border-right-width: 1px;
       border-bottom-width: 1px;
       border-left-width: 1px;
       border-top-style: solid;
       border-right-style: solid;
       border-bottom-style: solid;
       border-bottom-width: 1px;
       border-left-style: solid;
       border-top-color: #000000;
       border-right-color: #000000;
       border-bottom-color: #000000;
       border-left-color: #000000;
       font-family: Verdana, Tahoma, Sans-Serif;
    font-size: 10pt;
    line-height: normal;
}
</style>
<?php
 header('Content-Type: text/html; charset=UTF-8');
include_once 'lib/php/jdf.php';
include_once 'lib/php/db_connect.php';
include_once 'lib/php/gen_def.php';

	$f_id = isset($_REQUEST['f_id']) ? $_REQUEST['f_id'] : '';
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
//	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
	$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
	$name_customer = isset($_REQUEST['name_customer']) ? $_REQUEST['name_customer'] : '';
	$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
	$year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
	
	//
	
	$queryf = "
			 	SELECT *  FROM dm_factor 
		 
				WHERE 
					f_id = '".$f_id."'
                AND
                   f_status_ebtal='". 0 ."'
					
					"; 
						  	
			$lnkf = mysql_query($queryf);
			$rowf= mysql_fetch_assoc($lnkf);
			
			$gdate=$rowf['f_reg_date'];	       
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $f_reg_date = $jyear."/".$jmonth."/".$jday;
	    $f_code1 =farsinum($rowf['f_code']);
	    $f_reg_date =farsinum($f_reg_date);
	//debuging
	
	$query = "
			 SELECT *  FROM dm_pish_havale_det 			 
				 WHERE 
						phd_p_price = 0 
				 AND 
					phd_id_province='".$province_id."'  ";					   								 	    					   
    			$lnk = mysql_query($query);
				if(mysql_num_rows($lnk)>0){
				
			while($row = mysql_fetch_assoc($lnk))
			{
				 $queryp="SELECT * FROM dm_product product
							left join dm_price price
						on product.p_id=price.price_p_id
						WHERE p_code=".$row['phd_pid']."
						 AND 
							    p_price_code=".$row['phd_price_code']."
						 AND
								  price_id_province=".$province_id ." ";
							
					$lnkp = mysql_query($queryp);
					$rowp = mysql_fetch_assoc($lnkp);
					$phd_price=$rowp['p_sellprice'] * $row['phd_amount'];
					$phd_priceh=$rowp['p_sellpriceh'] * $row['phd_amount'];
					$query = "
							UPDATE dm_pish_havale_det 
							SET 
								`phd_price` = '".$phd_price."',
								`phd_p_price` = '".$rowp['p_sellprice']."',
								`phd_p_priceh` = '".$rowp['p_sellpriceh']."' ,
								`phd_priceh` = '".$phd_priceh."' 			 
								
													 
							WHERE 
								phd_id_province = ".$province_id." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }

	
	$queryv = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id."' 
	";
		
	$lnkv = mysql_query($queryv);
	$rowv= mysql_fetch_assoc($lnkv);
//	print $queryv;
//	echo $province_name;
	$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_ph_code = '".$ph_code."' 
		AND
		 pf_id_province='".$province_id."'
		AND
		pf_type=". 0 ."	";
	//print $query;	
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$pf_code=$row['pf_code'];
$queryph = "
	 	SELECT *  FROM dm_pish_havale
 
		WHERE 
			ph_code = '".$ph_code."'
		 AND 
		   ph_id_province=".$province_id."
		   AND
				ph_id_year=".$year_id."";

	
		
	$lnkph = mysql_query($queryph);
	$rowph= mysql_fetch_assoc($lnkph);
//	print $queryph;
	$querypro = "SELECT * FROM  dm_province
							WHERE
								province_id=".$province_id."  ";	
											       						       
	$lnkpro = mysql_query($querypro);												
	$rowpro= mysql_fetch_assoc($lnkpro);
	$province_code = $rowpro['province_code'];
	$querycus = "
	 	SELECT *  FROM dm_customer
 
		WHERE 
			code_customer = '".$rowph['ph_customer_code']."'
		 AND 
		   customer_code_org=".$province_code."

	";
		
	$lnkcus = mysql_query($querycus);
	$rowcus= mysql_fetch_assoc($lnkcus);
	//echo  $row['pf_reg_date'];
	$gdate=$row['pf_reg_date'];
list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
$pf_date = $jyear."/".$jmonth."/".$jday;
$pf_date=farsinum($pf_date);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$queryph = "
				 	SELECT *  FROM dm_pish_havale ph
				 	  left join dm_operation_acc opr
				 	   on ph.ph_operation_id=opr.g_id
					WHERE 
						ph_code = '".$ph_code."' 
					AND
					   ph_id_province=".$province_id."
					 AND
					   ph_id_year=".$year_id."";
		
	$lnkph = mysql_query($queryph);
	$rowph= mysql_fetch_assoc($lnkph);
	$g_acc_name=$rowph['g_acc_name'];
	 
	     $gdate=$rowph['cm_req_date'];
	     
	     $querydoc = "
		 	SELECT *  FROM dm_pf_document 
	 
			WHERE 
				dpf_pf_code = ".$pf_code.""; 		
//	print $query;
	$lnkdoc = mysql_query($querydoc);
		
		if(mysql_error()) print mysql_error();
		if($doc=mysql_affected_rows()>0){
			$Status='پرداخت شده';
		}else{
			$Status='پرداخت نشده';
		}
			$queryprov = "SELECT *  FROM dm_province
			           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
			  $lnkprov = mysql_query($queryprov);
			  $rowprov= mysql_fetch_assoc($lnkprov);
			    $province_code=$rowprov['province_code'];
		if($rowph['ph_customer_type']=='n'){
		  $ph_customer_type='معمولي';
		 $queryco = "
				 	SELECT *  FROM dm_customer 
			 
					WHERE 
						code_customer = ".$rowph['ph_customer_code']." 
					AND
					    customer_code_org=".$rowv['province_code']."";
	    $lnkco = mysql_query($queryco);
	    $rowco= mysql_fetch_assoc($lnkco);
//	 print    $queryco;
		$name=$rowco['name_customer'];
		
		}else{
			$queryco = "
		 	SELECT *  FROM dm_customer 
	 
			WHERE 
				customer_code = ".$rowph['ph_customer_code']." 
		AND
			    customer_code_org=".$rowv['province_code']."
		";

	    $lnkco = mysql_query($queryco);
	    $rowco= mysql_fetch_assoc($lnkco);
	    print $queryco;
		$name=$rowco['customer_name'];
		  	$ph_customer_type='متفرقه';
		  }
		  
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $cm_req_date = $jyear."/".$jmonth."/".$jday;
		
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
    $day_number=farsinum($day_number);
    $month_number=farsinum($month_number);
    $year_number=farsinum($year_number);
    $cm_req_date=farsinum($cm_req_date);
    $ph_code1=farsinum($ph_code);
    $pf_code1=farsinum($pf_code);
    $cm_req_num=farsinum($rowph['cm_req_num']);
    $code_customer=farsinum($rowco['code_customer']);
    $ph_customer_code=farsinum($rowph['ph_customer_code']);
    $code_economic_customer=farsinum($rowco['code_economic_customer']);
	$ph_mojavez=farsinum($rowph['ph_mojavez']);
	
	$province_ecode=farsinum($rowv['province_ecode']);
	$province_ecode = explode('-', $province_ecode);
	 $province_ecode=$province_ecode[2].'-'.$province_ecode[1].'-'.$province_ecode[0] ;
	 $province_postal=farsinum($rowv['province_postal']);
	 
   
   	
    $outHtml='<table   align="center"  dir="rtl" id="hcss" width=90%>
                   <tr>
                      <td align="center" colspan="16"v style="text-shadow: -1px 0 black, 0 1px black
                                    ;"><img src="images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
                      
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $province_name .'</b> </td>
                   </tr>
                   <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> فاكتور اداره فروش</center></td>
                        
                    </tr>
                     <tr>
					 <td>&nbsp;&nbsp;</td>
					 <td>&nbsp;&nbsp;</td>
                    <td align="left" colspan="4">
                        <table  style="align:left;"  >
						
                                 <tr>
                                    <td ><font color="red"><b>'.$l.'</b></font></td>
                                    
                                </tr>
                                
                        </table>
                        </td>
                  </tr> 
                    <tr>
                          <td colspan="8" height=30%>&nbsp;</td>
                    </tr>
					<tr> 
					   <td  width="15%"><b>شماره فاكتور:</b></td>
				       <td  align="right" >'.$f_code1.'</td>
					    <td  align="center" width="15%"><b> تاریخ فاکتور</b></td>
				        <td >'.$f_reg_date.'</b></td>
						<td> &nbsp;</td>
						<td> &nbsp;</td>
					</tr>
					<tr>
					    <td>&nbsp;
						</td>
					</tr>
                    <tr>  
                       <td  width="20%"><b> شماره درخواست :</b></td><td width="10%"><b>'.$cm_req_num.'</b></td>
				       <td align="center" width="15%"><b>تاريخ درخواست  :</b></td><td width="15%"><b>'.$cm_req_date1.'</b></td>				      
				       <td align="center" width="15%"><b>شماره پيش حواله:</b></td>
				       <td  align="center" >'.$ph_code1.'</td> 
                    </tr>
                    
                    <tr>  
                       <td  width="15%"><b>نام مشتري  :</b></td><td width="10%"><b>'.$rowcus['name_customer'].'</b></td>
				       <td align="center" width="15%"><b>كد مشتري :</b></td><td width="15%"><b>'.$ph_customer_code.'</b></td>				      
				       <td align="center" width="15%"><b>نوع مشتری:</b></td>
				        <td  align="center" >معمولي</td>
                    </tr>
                    <tr>  
                       <td  width="15%"><b>کد اقتصادی خریدار :</b></td><td width="10%"><b>'.$rowcus['customer_gl_economic'].'</b></td>
                       <td  width="15%"  align="left"><b>آدرس: </b></td><td  width="25%"><b>'.$province_address.'</b></td>
                       <td  width="15%"><b>شماره مجوز :</b></td><td width="10%"><b>'.$ph_mojavez.'</b></td>				                         		       
                    </tr>
                    <tr> 
                     <td  width="15%"><b>كد پستی :</b></td><td width="10%"><b>'.$code_postal_costumer.'</b></td> 
                      
				       <td align="center" width="15%"><b>تلفن :</b></td><td width="15%"><b>'.$customer_tel.'</b></td>				      				    
				       <td align="left" width="15%">&nbsp;</td>
				       <td>&nbsp;</b></td>
                    </tr>
                    
                     
                    <tr>  
                       <td  width="20%"><b> شناسه ملی :</b></td><td width="10%"><b>'.$rowcus['customer_national_tax'].'</b></td>
				       <td align="center" width="15%"><b>کد/شماره ملی</b></td><td width="15%"><b>'.$rowcus['customer_gl_code'].'</b></td>				      
				       
                    </tr>
                     <tr>
                          <td colspan="8" height=30%>&nbsp;</td>
                    </tr>
                    <tr>  
				      <td align="right" width="15%" ><b> نشاني مشتري :</b></td>
				       <td colspan="2">'.$rowcus['customer_address_office'].'</b></td>  
                    </tr>
                    
                    </table>';
         $outHtml .='<table   align="center"  dir="rtl" id="hcss" width=90%>
         <tr>
         <td width="15%"><b>کد اقتصادی فروشنده :</b> &nbsp; '.$province_ecode.'</td>
         <td width="15%"><b>کد پستی فروشنده :</b> &nbsp; '.$province_postal.'</td>
				       </tr>
				       <tr>
         <td width="15%"><b>آدرس فروشنده</b> &nbsp; '.$rowpro['province_address'].'</td>
           <td width="15%"><b>کد شناسایی فروشنده :</b> &nbsp; 14002771736</td>
				       </tr>
				     
   </table>
				       ';
     
	$outHtml .= '<div dir="rtl">
                  <table   >
	         <table  align="center" class="nasi" Width="100%">
	        
	        <tr align="center" style="height=200px; vertical-align:top;" >
				<td>
				<br><br>
			<table  border="1" style=" align="center"  width="100%"  >
		  	
		';

    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND ph_id_province=".$province_id."

	";
//	print $query;	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
				
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		    AND
		        phd_id_province=".$province_id." 
		";
		$lnk = mysql_query($query);
//print	$query;	
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		         
					<td colspan="12" align=center >
					 
					   <b> ريز  فاكتور</b>
					</td>
				</tr>
						<tr>
							<td align="center" width="10%">رديف</td>
							<td align="center">نام کالا</td>
							<td align="center">كد كالا</td>										
							
							<td align="center">كد قيمت</td>
							<td align="center">مقدار خريد</td>
							<td align="center">كد محل</td>
							<td align="center">نام محل</td>
							<td align="center">تحويل گيرنده</td>
						    <td align="center">قيمت واحد </td>
						     <td align="center">هزينه هر واحد </td>
							<td align="center">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
				
				 select * from dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
		           WHERE p_code=".$row['phd_pid']." 
		        AND 
		        p_price_code=".$row['phd_price_code']."
		        AND
		         price_id_province=".$province_id."
				 	
					";
			
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$queryl = "
						select * from dm_location_goods
						  where   
				        
				         l_id_province=".$province_id."
				         AND
				         l_id=".$row['phd_l_id']."";
				//echo $queryl;
							$lnkl = mysql_query($queryl);
							$rowl= mysql_fetch_assoc($lnkl);
				$inx++;
				
							   $hazine=$row['phd_p_add'];
							   $hazine=farsinum($hazine);
				 $p_code=farsinum($row2['p_code']);
				 $phd_price_code=farsinum($row['phd_price_code']);
				 $phd_amount=farsinum($row['phd_amount']);
				  $phd_priceh=formatMoney($row['phd_priceh']);
				 $phd_priceh=farsinum($phd_priceh);
				 $phd_p_price=formatMoney($row['phd_p_price']);
				 $phd_p_price=farsinum($phd_p_price);
				 $p_unit=farsinum($row2['p_unit']);
				 $inxx=urlencode($inx);	
				 $inxx=farsinum($inxx);
				$phd_priceh=formatMoney($row['phd_priceh']);
				  $phd_priceh=farsinum($phd_priceh);
				$outHtml .= '
						<tr>
							<td align="center">'.$inxx.'</td>
							<td align="center">'.$row2['p_name'].'</td>
							<td align="center" >'.$p_code.'</td>
							<td align="center" >'.$phd_price_code.'</td>
							<td align="center" >'. $phd_amount.'</td>
							<td align="center" >'.$rowl['l_code'].'</td>
							<td align="center" >'.$rowl['l_name'].'</td>
							
							<td align="center" >'.$row['phd_deli_name'].'</td>
							';
										
							$outHtml .= '<td align="center" >'.$phd_p_price.'</td>
							             <td align="center" >'.$hazine.'</td>
										<td align="center" >'.$phd_priceh.'</td>
								         </tr>  
								          
					';
				$totalprice =$row['phd_priceh']+$totalprice;
				$totalprice1=formatMoney($totalprice);
				$totalprice1=farsinum($totalprice1);
				
			}
			
			$outHtml .= '
					
					<tr>
					  <td colspan="10">&nbsp;&nbsp;&nbsp;</td>
				     <td> جمع کل:'.$totalprice1.'ريال</td>
				  
					</tr>				
			</td>
	</tr>
	<tr>
	 <td colspan="15">
	     <table  border="1" style=" align="center"  width="100%" >
	         <tr>
	             <td colspan="15" align="center"> اطلاعات اسناد </td>
	         </tr>';
			
	$query = "
		 	SELECT *  FROM dm_pf_document 
	 
			WHERE 
				dpf_pf_code = ".$pf_code." 
			AND 
			   dpf_id_province=".$province_id."
			 AND 
			   dpf_id_year=".$year_id."
		";
//	print $query;
	$lnk = mysql_query($query);
		
		if(mysql_error()) print mysql_error();
		if($doc=mysql_affected_rows()>0){
			
			$outHtml .= ' <tr>
			                 <td style="width:10%;">رديف</td>
			                 <td style="width:10%;">كد سند</td>
			                 <td style="width:15%;">نام سند</td>
			                 <td style="width:10%;">نام بانك</td>
			                 <td style="width:10%;">تاریخ سررسيد</td>
			                 <td style="width:10%;">شماره فيش</td>
			                 <td style="width:10%;">مبلغ</td>
			             </tr>
			             ';
			$inx=0;
			while($doc= mysql_fetch_assoc($lnk)){
								
				$query1 = "
						 	SELECT *  FROM dm_document 
					 
							WHERE 
								d_id = ".$doc['dpf_d_id']." 
													
						";
				$lnk1 = mysql_query($query1);
			    $doc1 = mysql_fetch_assoc($lnk1);
  //          print $query1;
				$queryba = "
						 	SELECT *  FROM dm_doc_det_b 
					 
							WHERE 
								doc_b_id = ".$doc1['d_bank']." 
													
						";
				$lnkba = mysql_query($queryba);
			    $bank = mysql_fetch_assoc($lnkba);
			 //   print $queryba;
			    		$queryty = "
						 	SELECT *  FROM dm_doc_det_t 
					 
							WHERE 
								doc_t_id = ".$doc1['d_documenttype']." 
													
						";
				$lnkty = mysql_query($queryty);
			    $type = mysql_fetch_assoc($lnkty);
			    if($doc['dpf_type']==4){
			    $no='اضافه پرداختی مشتری';	
			    }else{
			    	$no=$type['doc_t_name'];
			    }
			if($doc['dpf_type']==4){
			    $bank='';	
			    }else{
			    	$bank=$bank['doc_b_name'];
			    }
    $d_code=farsinum($doc1['d_code']);
    $dpf_sarresid=farsinum($doc['dpf_sarresid']);
	 $dpf_price=formatMoney($doc['dpf_price']);
    $dpf_price=farsinum($dpf_price);
   
	
    $dpf_num=farsinum($doc['dpf_num']);
	
			$inx++;
			$inxx=urlencode($inx);	
				$inxx=farsinum($inxx);
				
			$outHtml .='<tr>
						  <td style="width:10%;">'.$inxx.'</td>
						  <td style="width:10%;" >'. $d_code.'</td>	  
						   <td  style="width:15%;" >'.$no.'</td>
						   <td style="width:10%;">'.$bank.'</td>
						  <td style="width:10%;" >'. $dpf_sarresid.'</td>
						  <td style="width:10%;" >'. $dpf_num.'</td>
						   <td style="width:10%;">'.$dpf_price.'ريال</td>
						</tr>
					';
									
		}		
		$outHtml .='
		
		
		</table>';	
		}
		else{
	   $outHtml .= '<table border="1" class="nasi" Width="100%" style="height:90px;"></td></tr>
	                <tr>
	                  <td align="center" width="5%;">كد سند</td>	
	                  <td align="center" width="15%;">نوع سند</td>                  	                 	                
	                  
	                  <td align="center" width="10%;">شماره فيش</td>	                 
	                  <td align="center" width="10%;">نام بانك</td>
	                  <td align="center" width="10%;">نام شعبه</td>                 
	                  <td align="center" width="7%;">شماره جاري مشتری </td>                  
	                  <td align="center" width="7%;">شماره جاري شركت</td>
	                  <td align="center" width="10%;">تاريخ سررسيد</td>
	                   <td width="11%" align="center">مبلغ </td>

	                </tr> 
	                <tr>
	                   <td>&nbsp;</td>	
	                   
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr>
	                <tr>
	                   <td>&nbsp;</td>	
	                   
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr>
	                <tr>
	                   <td>&nbsp;</td>	
	                    
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr>
	                <tr>
	                    <td>&nbsp;</td>	
	                    
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr> 
	                <tr>
	                   <td>&nbsp;</td>	
	                   
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr> 
	                <tr>
	                    <td>&nbsp;</td>	
	                    	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                    <td>&nbsp;</td>	
	                </tr>      	   
	   </table>';
	   
	   
	    
		
		}
	 
	 $outHtml .='</table>
	 </td>
	</tr>
	</table>
			</div>
				
			';
		}
			$querys = "
						SELECT *  FROM dm_signature_g 
						 
								WHERE 
									sig_status = ". 1 ." 
									AND
								   sig_id_province=".$province_id  ."
								
							";
							
						$lnks = mysql_query($querys);
						$rows= mysql_fetch_assoc($lnks);
		
		 $outHtml .= '<br><table   dir="rtl" align="center"   width=75%>
		           <tr>
		               <td><b>'.$rows['sig1_f'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sig2_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sig3_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		           </tr>
		           <tr>
		               <td><b>'.$rows['sigs1_f'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sigs2_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sigs3_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		           </tr>
		           <tr>
		              <td colspan="5" align="center">'.$rows['text_f'].'</td>
		           </tr>
		           </table>';

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</td>
	</tr>
	
			</table>
			';
	echo $outHtml;
	}else
	{
				?>
	<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>خطا در چاپ</title>
<script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
<script type="text/javascript">
<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{
	//first slide down and blink the alert box
    $("#object").animate({ 
        top: "100px"
      }, 2000 ).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
   
   //close the message box when the cross image is clicked 
   $("#close_message").click(function()
	{
	   $("#object").fadeOut("slow");
	});
});
</script>
<style type="text/css">
body {
	font: 12px Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	width: 300px;
	
}
.message{
    border:1px solid #CCCCCC;
    
	position:absolute;
	width:1000px;
	border:1px solid #c93;
	background:yellow;
	padding:5px;
	right:0px;
	top : -170px;
}


</style>
</head>
<body>

<div id="object" class="message"> 
  
    <strong>  خطا در چاپ </strong>
  <p >!!!!!!!! شما پيش فاكتور را ثبت نكرديد </p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="color:#0000FF "><strong></strong></div>
  

</body>
</html>
	<?php 	
		
	}
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
	?>
