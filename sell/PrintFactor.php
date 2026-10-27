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
	$h_code = isset($_REQUEST['h_code']) ? $_REQUEST['h_code'] : '';
	$f_code = isset($_REQUEST['f_code']) ? $_REQUEST['f_code'] : '';
	$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
	$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
    $name_customer = isset($_REQUEST['name_customer']) ? $_REQUEST['name_customer'] : '';
    $year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
	global  $totalprice;
	global $priced;
	$query = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id."'"; 
		
	$lnk = mysql_query($query);
	$rowpro= mysql_fetch_assoc($lnk);
//print $query;
		$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_ph_code = '".$ph_code."' 
		AND pf_id_province='".$province_id."'	
		AND
		pf_type=". 0 ."";	
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$pf_code=$row['pf_code'];
//	print $query;
	if(mysql_error()) print mysql_error();
		
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
	//print $querycus;
	     $gdate=$rowph['cm_req_date'];	       
	     list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
	     list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
	     $cm_req_date = $jyear."/".$jmonth."/".$jday;
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
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
	$cm_req_num=farsinum($rowph['cm_req_num']);
	$cm_req_date1=farsinum($cm_req_date);
	$ph_code1=farsinum($ph_code);
	$f_code1=farsinum($f_code);
	$ph_customer_code=farsinum($rowph['ph_customer_code']);
	$province_ecode=farsinum($rowpro['province_ecode']);
	$province_ecode = explode('-', $province_ecode);
	 $province_ecode=$province_ecode[2].'-'.$province_ecode[1].'-'.$province_ecode[0] ;
	$ph_mojavez=farsinum($rowph['ph_mojavez']);
	$code_economic_customer=farsinum($rowcus['code_economic_customer']);
	$customer_tel=farsinum($rowcus['customer_tel']);
	$code_postal_costumer=farsinum($rowcus['code_postal_costumer']);
	$province_address=farsinum($rowpro['province_address']);
	$f_reg_date=farsinum($f_reg_date);
	$province_postal=farsinum($rowpro['province_postal']);
	
//baraye chap havale sadere	
	
	
	$querychek = " SELECT *  FROM dm_havale h
                     inner join dm_pish_factor pf on h.h_pf_code=pf.pf_code
                     inner join  dm_pish_havale ph  on  ph.ph_code=pf.pf_ph_code
                     left join dm_pish_havale_det phd  on phd.phd_ph_code=ph.ph_code					 
				WHERE 
				  phd_status= 1
				AND	
					phd_id_province='".$province_id."'
                AND
				    pf_id_province='".$province_id."'
				AND
				    ph_id_province='".$province_id."'	
				AND
				    h_id_province='".$province_id."' 
				AND
				    ph_code='".$ph_code."'
                      group by h_code					
					";					 	    					   
    			$lnkchek = mysql_query($querychek);
    			//print $querychek;
			if(mysql_num_rows($lnkchek)>0)
		{
			//print $querychek ;
				$s=	'';
				if(mysql_num_rows($lnkchek)==1)
                       {
					   $rowchek = mysql_fetch_assoc($lnkchek);
					   $h_code=farsinum($rowchek['h_code']);
                               $l='حواله شماره '.$h_code.' برای اين فاکتور  صادر شده است';
                        }else{
									while($rowchek = mysql_fetch_assoc($lnkchek))
								{
								    $h_code=farsinum($rowchek['h_code']);
									$s .=$h_code.',';					   
								}
								$l='شماره حواله های '.$s.'برای اين فاکتور صادر شده است';
                            }
        }else{
		$l='براي اين فاکتور، حواله اي صادر نشده است.';
		
		}
	
	
	
	
	
	
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
                  <table  >
	         <table  align="center" class="nasi" Width="75%">
	        
	        <tr align="center" style="height=200px; vertical-align:top;" >
				<td>
				<br><br>
			<table  border="1" style=" align="center"  width="100%"  >';
		  	
		

    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND ph_id_province=".$province_id."	";	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
				
		//retrieve detail of pishHavale
		$query = "
			 	SELECT *  FROM dm_factor_det 
		 
				WHERE 
					fd_f_id = '".$f_id."'
               AND
					fd_status=". 0 ."";						  	
			$lnk = mysql_query($query);
		//	print  $query;
		
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		         <tr>
					<td colspan="12" align=center >
					 
					   <b> ريز فاكتور</b>
					</td>
				</tr>
						<tr>
							<td align="center">رديف</td>
							<td align="center">نام کالا</td>
							<td align="center">كد كالا</td>
							<td align="center">كد قيمت</td>
							<td align="center">مقدار خريد</td>
					<!--	<td align="center">نام تحويل گيرنده</td> -->
						    <td align="center">قيمت واحد </td>
						      <td align="center">هزينه اضافی هر واحد </td>
							<td align="center">قيمت كالا </td>
							<td align="center">نام تحويل گيرنده </td>
						</tr>
		</div>
			';
			$inx = 0;
			
				while($row= mysql_fetch_assoc($lnk)){
				
		 
		    $inx++;		
			if(($inx)%2==1)
				$class="rw1";				
			else					
				$class="rw0";

		    $h_id=$row['fd_h_id'];		
			$queryha = "
				 	SELECT *  FROM dm_havale 
			 
					WHERE 
						h_id = '".$h_id."' "; 						  	
			$lnkha = mysql_query($queryha);
			$rowha= mysql_fetch_assoc($lnkha);
		//	print $queryha;
			if(mysql_error()) print mysql_error();
//product


                         $queryp = "
								 	SELECT *  FROM dm_product product
									left join dm_price price
									on product.p_id=price.price_p_id
							 			 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
									
									WHERE 
										p_code = '".$rowha['h_p_code']."'
                                    AND p_price_code='".$rowha['h_price_code']."'
                                    
                                    and
			                price_id_province=".$province_id.""; 
                                    
                                    	
							//	print 	$queryp;						  	
							$lnkp = mysql_query($queryp);
							$rowp= mysql_fetch_assoc($lnkp);
							
							
						$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$rowha['h_p_code']." 
							AND
								p_price_code=".$rowha['h_price_code']."
							AND
								price_id_province=".$province_id."
							AND
							   ch_id_province=".$province_id."";
						//print $querych;		
			$lnkch = mysql_query($querych);
			
	  	   $hazine=$rowha['h_p_add'];
	  	if (isset($_SESSION['dm_user_profile']['u_province_id'])){
							$queryprov = "SELECT *  FROM dm_province
								           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
								  $lnkprov = mysql_query($queryprov);
								  if (mysql_num_rows($lnkprov) > 0) {
								  $rowprov= mysql_fetch_assoc($lnkprov);
								  }
	  	
	  	}
								    $province_code=$rowprov['province_code'];
								    
							$query5 = "
								 	SELECT *  FROM dm_customer 
							 
									WHERE 
										code_customer = '".$rowha['h_customer_code']."'
                                  AND
			                            customer_code_org=".$province_code."";	
															  	
							$lnk5 = mysql_query($query5);
							if(mysql_num_rows($lnk5)>0){
							$row5= mysql_fetch_assoc($lnk5);
							}			
					$inxx=urlencode($inx);	
				   $inxx=farsinum($inxx);
				   $h_p_code=farsinum($rowha['h_p_code']);
				   $h_price_code=farsinum($rowha['h_price_code']);
				   $h_amount=formatMoney($rowha['h_amount']);
				   $h_amount=farsinum($h_amount);
				   $h_p_price=farsinum($rowha['h_p_price']);
				 //  $hazine=farsinum($hazine);
			       $outHtml.= '
						<tr class="'.$class.'">
							<td align="center">'.$inxx.'</td>
							<td align="center">'.$rowp['p_name'].'</td>
							<td align="center">'.$h_p_code.'</td>						
							<td align="center">'.$h_price_code.'</td>
							<td align="center">'.$h_amount.'</td>';

				$h_price=formatMoney($rowha['h_priceh']);
				$h_price=farsinum($h_price);
							
							$outHtml.= '<td align="center">'.$h_p_price.'</td>
							             <td align="center">'.$hazine.'</td>
											<td align="center">'.$h_price.'ريال</td>
											<td align="center">'.$rowha['h_deli_name'].'</td>
								        
								         </tr>';  
								         					
				$totalprice =$rowha['h_priceh']+$totalprice;											
				         	
		}	
			$totalprice=formatMoney($totalprice);
			$totalprice=farsinum($totalprice);
		
			$outHtml .= '
							<tr>
						       <td colspan="9"> قابل پرداخت : '.$totalprice.' ریا ل </td>
						        
							</tr>				
						</td>
				</tr>
				</table>';

	
	
			$outHtml .= ' </table><br>
			              <table  dir="rtl" align="center" width=85%>
			                      <tr>
			                          <td width=15%><b>مبلغ پرداخت شده :</td><td>'.$totalprice.' ریا ل</td>
			                          <td width=10%>&nbsp;</td>
			                         
								     
			                 </tr>
			                </table> ';
			             
			            
	
	 
	 $outHtml .='</table>
	 </td>
	</tr>
	</table>
			</div>
				
			';
		}
		$priced=formatMoney($priced);
		
		
		
		$querys = "
						SELECT *  FROM dm_signature_g 
						 
								WHERE 
									sig_status = ". 1 ." 
									AND
								   sig_id_province=".$province_id  ."";	
								
								
						$lnks = mysql_query($querys);
						$rows= mysql_fetch_assoc($lnks);
		
		 $outHtml .= '<br><table   dir="rtl" align="center"   width=75%>
		           <tr>
		               <td><b>'.$rows['sig1_f'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sig2_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sig3_f'].'</b></td>
		           </tr>
		           <tr>
		               <td><b>'.$rows['sigs1_f'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sigs2_f'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sigs3_f'].'</b></td>
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
	?>
	
	
</html>