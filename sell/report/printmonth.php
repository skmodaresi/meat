
 <html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  
</head> 	
<?php
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';
 
 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
 $month_num = !empty($_REQUEST['month_num']) ? $_REQUEST['month_num'] :'1' ;
 $dahe_num = !empty($_REQUEST['dahe_num']) ? $_REQUEST['dahe_num'] : '1';
 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '1';
 $u_id = !empty($_REQUEST['u_id']) ? $_REQUEST['u_id'] : '';
//year=1394;
//echo $month_num;
$f=1;

$queryy = "
	 	SELECT *  FROM dm_year 
 
		WHERE 
			year_id = '".$year_id ."'"; 
		 		
	$lnky = mysql_query($queryy);
	$rowy= mysql_fetch_assoc($lnky);

$year=$rowy['year_name'];


if($dahe_num==1)
{
	$dahe_num='01';
	
		
			 $roz1=''.$year.'/'.$month_num.'/01';	
			// echo  $roz1;
			 $jdate=$roz1;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz1 = $gyear."-".$gmonth."-".$gday;
	//2
	
	 $roz2=''.$year.'/'.$month_num.'/02';	
			 $jdate=$roz2;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz2 = $gyear."-".$gmonth."-".$gday;
	
	//3
	 $roz3=''.$year.'/'.$month_num.'/03';	
			 $jdate=$roz3;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz3 = $gyear."-".$gmonth."-".$gday;
	//4
	 $roz4=''.$year.'/'.$month_num.'/04';	
			 $jdate=$roz4;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz4 = $gyear."-".$gmonth."-".$gday;
	//5
	 $roz5=''.$year.'/'.$month_num.'/05';	
			 $jdate=$roz5;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz5 = $gyear."-".$gmonth."-".$gday;
	
	//6
	 $roz6=''.$year.'/'.$month_num.'/06';	
			 $jdate=$roz6;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz6= $gyear."-".$gmonth."-".$gday;
	
		//7
				 $roz7=''.$year.'/'.$month_num.'/07';	
			 $jdate=$roz7;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz7 = $gyear."-".$gmonth."-".$gday;
		//8
		 $roz8=''.$year.'/'.$month_num.'/08';	
			 $jdate=$roz8;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz8 = $gyear."-".$gmonth."-".$gday;
			//9
			 $roz9=''.$year.'/'.$month_num.'/09';	
			 $jdate=$roz9;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz9 = $gyear."-".$gmonth."-".$gday;
				
				
				
			
			 $roz10=''.$year.'/'.$month_num.'/10';	
		
			 $jdate=$roz10;
		     $jdate .= '/\/';
		     
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz10 = $gyear."-".$gmonth."-".$gday;	

						$outHtml1='';  
					  
					
						$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
					                   <tr>
					                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
					   
					                   </tr>
					                   <tr>
					                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b></td>
					                                               
					                    </tr>
					                    <tr> 
					                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
					                        
					                    </tr>
					             </table></div>';
					
						
						$outHtml1 .= '	
							<div align = "center">
							<div align = "center" style="direction:rtl;">
								<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
						
					        		<tr class="rw1">
					        			<td colspan="14" align="center" style="height: 50px;vertical-align:middle;"><center>گزارش فروش  </center> </td>
					        		</tr>
					        		<tr class="rw1">
					        			 
					        			 <td   colspan="14" style="height: 50px;vertical-align:middle;"> از تاریخ<font style="color:green;">'.$year.'/'.$month_num.'/01 </font> 
                                       تا تاریخ   <font style="color:green;">  '.$year.'/'.$month_num.'/10 </font>   
                                      &nbsp; &nbsp; &nbsp;  &nbsp;کد کالا:'.$p_code.'  
					        			 </td>
					        			
					        		</tr>
					      			
						
						  <tr bgcolor="#99FFFF"   style="font-weight:bold;" >
						                        <td width="100" colspan="2" align="center">نام استان</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/01</td>
											    <td width="100"  align="center">روز '.$year.'/'.$month_num.'/02</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/03</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/04</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/05</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/06</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/07</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/08</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/09</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/10</td>
											    <td width="100" align="center">جمع</td>
											   
											    
											  </tr>';
					
						
						$queryu="SELECT * FROM dm_user_profile WHERE u_id=".$u_id."";				 
	$lnku = mysql_query($queryu);
	$rowu = mysql_fetch_assoc($lnku);
	
	if($rowu['u_province_id']==100){

		$shart=' in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1)';
		
		
	}else{
		
		$shart='  in ('.$rowu['u_province_id'].')';
		
	}
	
						
						
						
						
						$query = " SELECT 
									            sum( case when h_reg_date='".$roz1."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh1'
									        ,   sum( case when h_reg_date='".$roz2."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh2'
									        ,   sum( case when h_reg_date='".$roz3."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh3'
									        ,   sum( case when h_reg_date='".$roz4."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh4'
									        ,   sum( case when h_reg_date='".$roz5."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh5'
									        ,   sum( case when h_reg_date='".$roz6."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh6'
									        ,   sum( case when h_reg_date='".$roz7."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh7'
									        ,   sum( case when h_reg_date='".$roz8."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh8'
									        ,   sum( case when h_reg_date='".$roz9."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh9'
									        ,   sum( case when h_reg_date='".$roz10."'  then  ifnull(h_amount,0) else 0 end ) as 'tarikh10'
									        ,   sum( case when h_reg_date  between '".$roz1."'  and  '".$roz10."' then  ifnull(h_amount,0) else 0 end ) as 'tarikh1ta10'
									     
									        ,h_id_province
									        ,  pp.province_code_alef
									        ,pp.province_name
									
									
									from (
									
									select province_code_alef ,type_prod_id,h_reg_date,h_amount,h_priceh,h_id_province,p_code,h_code,price_id_province 
									from dm_havale h left join dm_product prod on prod.p_code=h.h_p_code 
									left join dm_price price on prod.p_id=price.`price_p_id`  
									left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province ".$shart."
									left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type 
									left join dm_province  prov on  prov.province_id=h.h_id_province
									where h_id_province ".$shart." 
									and h.h_reg_time between  '".$roz1."'  AND  '".$roz10."'
									and
									h_p_code = $p_code
									 
									and 
									price_id_province   ".$shart."
									and 
									h.`h_id_province`=price.`price_id_province` 
									GROUP BY h_id_province,h_code
									
									
									)
									 as c  right join dm_province pp on c.h_id_province = pp.province_id
                                     group by province_id order by  pp.province_code_alef
						";
					// and  
							//		  h_price_code=$p_price_code
				//print $query;	
						$lnk = mysql_query($query);
						global $inx1;
						global $inx11;
						$inx1=1;
						$inx11=1;
					
									
						if(mysql_affected_rows()>0){
								$jroz1=0;
								$jroz2=0;
								$jroz3=0;
								$jroz4=0;
								$jroz5=0;
								$jroz6=0;
								$jroz7=0;
								$jroz8=0;
								$jroz9=0;
								$jroz10=0;
								$jroz1ta10=0;
								
						
							while($row = mysql_fetch_assoc($lnk)){
								
								$query1= " select * from dm_province 
								            where 
								              province_code=".$row['h_id_province']."	";
					
								$lnk1 = mysql_query($query1);
								$row1 = mysql_fetch_assoc($lnk1);
								
								$h_id_province=$row['h_id_province'];
							if( $code_customer != -2){
							$shart = "   h_customer_code= ". $code_customer ."";	
						}else{
					$shart = "  1 ";	
					}	
					
					$sezaf=0;	
					$sezafpre=0;	
					 	           
											
							if($inx11==2000){
									
									$inx11=1;
									
									$outHtml1 .= '<tr colspan="24" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
									       </tr>
									   <tr><td colspan="14">&nbsp;</td>
									       </tr>
									         <td colspan="14">
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
								
						 	//	<div align = "center">
							//<div align = "center" style="direction:rtl;">
								
														            
								}	
							
										if(($inx1)%2==1){
												$color='#C5DED0';
												
											
											}
												else{
													$color='#BBB';
												   
												}
							                    // if($row['shavale']> $row['sebtal']){
													//}else{
													 
														
												//	}				
												
						     $inx11 =urlencode($inx1);
						     $inx11=farsinum($inx11);
						  
								$outHtml1 .= '	
									     
											 <tr style="background-color:'.$color.';">
											   
											    <td width="100" colspan="2"><b>'.$row['province_name'].'</b></td>
											    <td width="100" align="center">'.$row['tarikh1'].'</td>
											    <td width="100" align="center">'.$row['tarikh2'].'</td>
											    <td width="100" align="center">'.$row['tarikh3'].'</td>
											    <td width="100" align="center">'.$row['tarikh4'].'</td>
											    <td width="100" align="center">'.$row['tarikh5'].'</td>
											    <td width="100" align="center">'.$row['tarikh6'].'</td>
											    <td width="100" align="center">'.$row['tarikh7'].'</td>
											    <td width="100" align="center">'.$row['tarikh8'].'</td>
											    <td width="100" align="center">'.$row['tarikh9'].'</td>
											    <td width="100" align="center">'.$row['tarikh10'].'</td>
											    <td width="100" align="center">'.$row['tarikh1ta10'].'</td>
											    
											  </tr>';			
								$inx1++;
								$inx11++;
								//$amount=$amount+$mande;
									$jroz1=$jroz1+$row['tarikh1'];
									$jroz2=$jroz2+$row['tarikh2'];
									$jroz3=$jroz3+$row['tarikh3'];
									$jroz4=$jroz4+$row['tarikh4'];
									$jroz5=$jroz5+$row['tarikh5'];
									$jroz6=$jroz6+$row['tarikh6'];
									$jroz7=$jroz7+$row['tarikh7'];
									$jroz8=$jroz8+$row['tarikh8'];
									$jroz9=$jroz9+$row['tarikh9'];
									$jroz10=$jroz10+$row['tarikh10'];
									$jroz1ta10=$jroz1ta10+$row['tarikh1ta10'];
									
							
							}
							$kol=($gosfandv+$gosfandda+$gosalev+$gosaled+$morghv+$morghd);
							$outHtml1 .= '	
									     
											 <tr style="background-color:red;">
											   
											    <td width="100" colspan="2"><b>جمع</b></td>
											    <td width="100" align="center">'.$jroz1.'</td>
											    <td width="100" align="center">'.$jroz2.'</td>
											    <td width="100" align="center">'.$jroz3.'</td>
											    <td width="100" align="center">'.$jroz4.'</td>
											    <td width="100" align="center">'.$jroz5.'</td>
											    <td width="100" align="center">'.$jroz6.'</td>
											    <td width="100" align="center">'.$jroz7.'</td>
											    <td width="100" align="center">'.$jroz8.'</td>
											    <td width="100" align="center">'.$jroz9.'</td>
											    <td width="100" align="center">'.$jroz10.'</td>
											    <td width="100" align="center">'.$jroz1ta10.'</td>
											   
											  </tr>';
						
							//$jam=urlencode($jam);
							
							
							//$outHtml1.= '</table><div>&nbsp;</div>
						          //      <span style="background-color:red" width="70%">جمع کل:'.$kol.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
						//	                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$ebtal1.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
							              //    <span style="background-color:red" width="70%">مقدار خالص دريافتی:'.$khales.'كيلوگرم </span>' ;						
					    }else{
					    	$outHtml1 .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
					    }
						
						
	
	
	
}

else if($dahe_num==2)
{
	
					//11
					 $roz11=''.$year.'/'.$month_num.'/11';	
					 $jdate=$roz11;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz11 = $gyear."-".$gmonth."-".$gday;
			//12
			
			 $roz12=''.$year.'/'.$month_num.'/12';	
					 $jdate=$roz12;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz12 = $gyear."-".$gmonth."-".$gday;
			
			//13
			 $roz13=''.$year.'/'.$month_num.'/13';	
					 $jdate=$roz13;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz13 = $gyear."-".$gmonth."-".$gday;
			//14
			 $roz14=''.$year.'/'.$month_num.'/14';	
					 $jdate=$roz14;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz14 = $gyear."-".$gmonth."-".$gday;
			//15
			 $roz15=''.$year.'/'.$month_num.'/15';	
					 $jdate=$roz15;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz15 = $gyear."-".$gmonth."-".$gday;
			
			//6
			 $roz16=''.$year.'/'.$month_num.'/16';	
					 $jdate=$roz16;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz16= $gyear."-".$gmonth."-".$gday;
			
				//7
						 $roz17=''.$year.'/'.$month_num.'/17';	
					 $jdate=$roz17;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz17 = $gyear."-".$gmonth."-".$gday;
				//18
				 $roz18=''.$year.'/'.$month_num.'/18';	
					 $jdate=$roz18;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz18 = $gyear."-".$gmonth."-".$gday;
					//19
					 $roz19=''.$year.'/'.$month_num.'/19';	
					 $jdate=$roz19;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz19 = $gyear."-".$gmonth."-".$gday;
					//20
					 $roz20=''.$year.'/'.$month_num.'/20';	
					 $jdate=$roz20;
				     $jdate .= '/\/';
				     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
				     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
					 if($gmonth<=9){
					       $gmonth='0'.$gmonth;  
					     }
					 if($gday<=9){
					       $gday='0'.$gday;  
					     }
						$roz20 = $gyear."-".$gmonth."-".$gday;	
			
			
	
	
	
	$outHtml1='';  
					  
					
						$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
					                   <tr>
					                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
					   
					                   </tr>
					                   <tr>
					                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b></td>
					                                               
					                    </tr>
					                    <tr> 
					                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
					                        
					                    </tr>
					             </table></div>';
					
						
						$outHtml1 .= '	
							<div align = "center">
							<div align = "center" style="direction:rtl;">
								<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
						
					        		<tr class="rw1">
					        			<td colspan="14" align="center" style="height: 50px;vertical-align:middle;"><center>گزارش فروش  </center> </td>
					        		</tr>
					        		<tr class="rw1">
					        			 
					        			 <td   colspan="14" style="height: 50px;vertical-align:middle;"> از تاریخ<font style="color:green;">'.$year.'/'.$month_num.'/11 </font> 
                                       تا تاریخ   <font style="color:green;">  '.$year.'/'.$month_num.'/20 </font>     
                                         &nbsp; &nbsp; &nbsp;  &nbsp;کد کالا:'.$p_code.'
                                       </td>
					        			 
					        			
					        		</tr>
					      			
						
						  <tr bgcolor="#99FFFF"   style="font-weight:bold;" >
						                        <td width="100" colspan="2" align="center">نام استان</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/11</td>
											    <td width="100"  align="center">روز '.$year.'/'.$month_num.'/12</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/13</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/14</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/15</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/16</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/17</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/18</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/19</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/20</td>
											      <td width="100" align="center"جمع</td>
											  </tr>';
					
						$query = " SELECT 
									            sum( case when h_reg_date='".$roz11."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh11'
									        ,   sum( case when h_reg_date='".$roz12."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh12'
									        ,   sum( case when h_reg_date='".$roz13."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh13'
									        ,   sum( case when h_reg_date='".$roz14."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh14'
									        ,   sum( case when h_reg_date='".$roz15."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh15'
									        ,   sum( case when h_reg_date='".$roz16."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh16'
									        ,   sum( case when h_reg_date='".$roz17."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh17'
									        ,   sum( case when h_reg_date='".$roz18."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh18'
									        ,   sum( case when h_reg_date='".$roz19."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh19'
									        ,   sum( case when h_reg_date='".$roz20."'  then  ifnull(h_amount,0) else 0 end ) as 'tarikh20'
									        ,   sum( case when h_reg_date  between '".$roz11."'  and  '".$roz20."' then  ifnull(h_amount,0) else 0 end ) as 'tarikh11ta20'
									     
									       ,h_id_province 
						, pp. province_code_alef 
						, pp. province_name 
									
									from (
									
									select province_code_alef ,type_prod_id,h_reg_date,h_amount,h_priceh,h_id_province,p_code,h_code,price_id_province 
									from dm_havale h left join dm_product prod on prod.p_code=h.h_p_code 
									left join dm_price price on prod.p_id=price.`price_p_id`  
									left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province in  (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type 
									left join dm_province  prov on  prov.province_id=h.h_id_province
									where h_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									and h.h_reg_time between  '".$roz11."'  AND  '".$roz20."'
									and
									h_p_code = $p_code
									 
									and 
									price_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									and 
									h.`h_id_province`=price.`price_id_province` 
									GROUP BY h_id_province,h_code
									
									
									)
									 as c right join dm_province pp on c.h_id_province = pp.province_id
                                     group by province_id order by  pp.province_code_alef
						";
	
						
					//print $query;	
						$lnk = mysql_query($query);
						global $inx1;
						global $inx11;
						$inx1=1;
						$inx11=1;
					
						if(mysql_affected_rows()>0){
								$jroz11=0;
								$jroz12=0;
								$jroz13=0;
								$jroz14=0;
								$jroz15=0;
								$jroz16=0;
								$jroz17=0;
								$jroz18=0;
								$jroz19=0;
								$jroz20=0;
								$jroz11ta20=0;
						
							while($row = mysql_fetch_assoc($lnk)){
								
								$query1= " select * from dm_province 
								            where 
								              province_code=".$row['h_id_province']."	";
					
								$lnk1 = mysql_query($query1);
								$row1 = mysql_fetch_assoc($lnk1);
								
								$h_id_province=$row['h_id_province'];
							if( $code_customer != -2){
							$shart = "   h_customer_code= ". $code_customer ."";	
						}else{
					$shart = "  1 ";	
					}	
					
					$sezaf=0;	
					$sezafpre=0;	
					 	           
											
							if($inx11==2000){
									
									$inx11=1;
									
									$outHtml1 .= '<tr colspan="24" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
									       </tr>
									   <tr><td colspan="14">&nbsp;</td>
									       </tr>
									         <td colspan="14">
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
								
						 	//	<div align = "center">
							//<div align = "center" style="direction:rtl;">
								
														            
								}	
							
										if(($inx1)%2==1){
												$color='#C5DED0';
												
											
											}
												else{
													$color='#BBB';
												   
												}
							                    // if($row['shavale']> $row['sebtal']){
													//}else{
													 
														
												//	}				
												
						     $inx11 =urlencode($inx1);
						     $inx11=farsinum($inx11);
						  
								$outHtml1 .= '	
									     
											 <tr style="background-color:'.$color.';">
											   
											    <td width="100" colspan="2"><b>'.$row['province_name'].'</b></td>
											    <td width="100" align="center">'.$row['tarikh11'].'</td>
											    <td width="100" align="center">'.$row['tarikh12'].'</td>
											    <td width="100" align="center">'.$row['tarikh13'].'</td>
											    <td width="100" align="center">'.$row['tarikh14'].'</td>
											    <td width="100" align="center">'.$row['tarikh15'].'</td>
											    <td width="100" align="center">'.$row['tarikh16'].'</td>
											    <td width="100" align="center">'.$row['tarikh17'].'</td>
											    <td width="100" align="center">'.$row['tarikh18'].'</td>
											    <td width="100" align="center">'.$row['tarikh19'].'</td>
											    <td width="100" align="center">'.$row['tarikh20'].'</td>
											     <td width="100" align="center">'.$row['tarikh11ta20'].'</td>
											    
											  </tr>';			
								$inx1++;
								$inx11++;
								//$amount=$amount+$mande;
									$jroz1=$jroz1+$row['tarikh11'];
									$jroz2=$jroz2+$row['tarikh12'];
									$jroz3=$jroz3+$row['tarikh13'];
									$jroz4=$jroz4+$row['tarikh14'];
									$jroz5=$jroz5+$row['tarikh15'];
									$jroz6=$jroz6+$row['tarikh16'];
									$jroz7=$jroz7+$row['tarikh17'];
									$jroz8=$jroz8+$row['tarikh18'];
									$jroz9=$jroz9+$row['tarikh19'];
									$jroz10=$jroz10+$row['tarikh20'];
									$jroz11ta20=$jroz1ta10+$row['tarikh11ta20'];
									
							
							}
						
							$outHtml1 .= '	
									     
											 <tr style="background-color:red;">
											 <tr style="background-color:red;">
											   
											    <td width="100" colspan="2"><b>جمع</b></td>
											    <td width="100" align="center">'.$jroz11.'</td>
											    <td width="100" align="center">'.$jroz12.'</td>
											    <td width="100" align="center">'.$jroz13.'</td>
											    <td width="100" align="center">'.$jroz14.'</td>
											    <td width="100" align="center">'.$jroz15.'</td>
											    <td width="100" align="center">'.$jroz16.'</td>
											    <td width="100" align="center">'.$jroz17.'</td>
											    <td width="100" align="center">'.$jroz18.'</td>
											    <td width="100" align="center">'.$jroz19.'</td>
											    <td width="100" align="center">'.$jroz20.'</td>
											    <td width="100" align="center">'.$jroz11ta20.'</td>
											   
											  </tr>';
						
							//$jam=urlencode($jam);
							
							
						//	$outHtml1.= '</table><div>&nbsp;</div>
						           //     <span style="background-color:red" width="70%">جمع کل:'.$kol.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
						//	                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$ebtal1.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
							              //    <span style="background-color:red" width="70%">مقدار خالص دريافتی:'.$khales.'كيلوگرم </span>' ;						
					    }else{
					    	$outHtml1 .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
					    }
	
	
}
else if($dahe_num==3)
{
	
		//21
			 $roz21=''.$year.'/'.$month_num.'/21';	
			 $jdate=$roz21;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz21 = $gyear."-".$gmonth."-".$gday;
	//22
	
	 $roz22=''.$year.'/'.$month_num.'/22';	
			 $jdate=$roz22;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz22 = $gyear."-".$gmonth."-".$gday;
	
	//23
	 $roz23=''.$year.'/'.$month_num.'/23';	
			 $jdate=$roz23;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz23 = $gyear."-".$gmonth."-".$gday;
	//24
	 $roz24=''.$year.'/'.$month_num.'/24';	
			 $jdate=$roz24;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz24 = $gyear."-".$gmonth."-".$gday;
	//25
	 $roz25=''.$year.'/'.$month_num.'/25';	
			 $jdate=$roz25;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz25 = $gyear."-".$gmonth."-".$gday;
	
	//26
	 $roz26=''.$year.'/'.$month_num.'/26';	
			 $jdate=$roz26;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz26= $gyear."-".$gmonth."-".$gday;
	
		//27
				 $roz27=''.$year.'/'.$month_num.'/27';	
			 $jdate=$roz27;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz27 = $gyear."-".$gmonth."-".$gday;
		//28
		 $roz28=''.$year.'/'.$month_num.'/28';	
			 $jdate=$roz28;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz28 = $gyear."-".$gmonth."-".$gday;
			//29
			 $roz29=''.$year.'/'.$month_num.'/29';	
			 $jdate=$roz29;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz29 = $gyear."-".$gmonth."-".$gday;
			//30
			 $roz30=''.$year.'/'.$month_num.'/30';	
			 $jdate=$roz30;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz30 = $gyear."-".$gmonth."-".$gday;	
				//31
			 $roz31=''.$year.'/'.$month_num.'/31';	
			 $jdate=$roz31;
		     $jdate .= '/\/';
		     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			 if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			 if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$roz31 = $gyear."-".$gmonth."-".$gday;	
	
	
	$outHtml1='';  
					  
					
						$outHtml1='<div><table     align="center"  dir="rtl"  width="90%">
					                   <tr>
					                      <td align="center" colspan="18" style="text-shadow: -1px 0 black, 0 1px black  ;"><img src="../images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
					   
					                   </tr>
					                   <tr>
					                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b></td>
					                                               
					                    </tr>
					                    <tr> 
					                         <td colspan="11" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
					                        
					                    </tr>
					             </table></div>';
					
						
						$outHtml1 .= '	
							<div align = "center">
							<div align = "center" style="direction:rtl;">
								<table  align="center" cellpadding="0"  width="90%" cellspacing="0"  border="1">
						
					        		<tr class="rw1">
					        			<td colspan="14" align="center" style="height: 50px;vertical-align:middle;"><center>گزارش فروش  </center> </td>
					        		</tr>
					        		<tr class="rw1">
					        			 
					        			 <td   colspan="14" style="height: 50px;vertical-align:middle;"> از تاریخ<font style="color:green;">'.$year.'/'.$month_num.'/21 </font> 
                                       تا تاریخ   <font style="color:green;">  '.$year.'/'.$month_num.'/31 </font>     
                                                     &nbsp; &nbsp; &nbsp;  &nbsp;کد کالا:'.$p_code.'
                                       </td> 
					        			
					        		</tr>
					      			
						
						              <tr bgcolor="#99FFFF" style="font-weight:bold;" >
						                         <td width="100" colspan="2" align="center">نام استان</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/21</td>
											    <td width="100"  align="center">روز '.$year.'/'.$month_num.'/22</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/23</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/24</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/25</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/26</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/27</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/28</td>
											    <td width="100" align="center">روزروز '.$year.'/'.$month_num.'/29</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/30</td>
											    <td width="100" align="center">روز '.$year.'/'.$month_num.'/31</td>
											    <td width="100" align="center">جمع</td>
											   
											    
										</tr>';
										$query = " SELECT 
									            sum( case when h_reg_date='".$roz21."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh21'
									        ,   sum( case when h_reg_date='".$roz22."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh22'
									        ,   sum( case when h_reg_date='".$roz23."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh23'
									        ,   sum( case when h_reg_date='".$roz24."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh24'
									        ,   sum( case when h_reg_date='".$roz25."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh25'
									        ,   sum( case when h_reg_date='".$roz26."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh26'
									        ,   sum( case when h_reg_date='".$roz27."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh27'
									        ,   sum( case when h_reg_date='".$roz28."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh28'
									        ,   sum( case when h_reg_date='".$roz29."'  then  ifnull(h_amount,0) else 0 end )  as 'tarikh29'
									        ,   sum( case when h_reg_date='".$roz30."'  then  ifnull(h_amount,0) else 0 end ) as 'tarikh30'
									        ,   sum( case when h_reg_date='".$roz31."'  then  ifnull(h_amount,0) else 0 end ) as 'tarikh31'
									        ,   sum( case when h_reg_date  between '".$roz21."'  and  '".$roz31."' then  ifnull(h_amount,0) else 0 end ) as 'tarikh21ta31'
									     
									        ,h_id_province
									        ,  pp.province_code_alef
									        ,pp.province_name
									
									
									from (
									
									select province_code_alef ,type_prod_id,h_reg_date,h_amount,h_priceh,h_id_province,p_code,h_code,price_id_province 
									from dm_havale h left join dm_product prod on prod.p_code=h.h_p_code 
									left join dm_price price on prod.p_id=price.`price_p_id`  
									left join dm_pish_factor pf on h.h_pf_code=pf.pf_code and pf_id_province in  (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									left join dm_prod_det_t prod_t on prod_t.type_prod_id=prod.p_type 
									left join dm_province  prov on  prov.province_id=h.h_id_province
									where h_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									and h.h_reg_time between  '".$roz21."'  AND  '".$roz31."'
									and
									h_p_code = $p_code
									 
									and 
									price_id_province in (3,4,5,6,7,8,9,10,13,14,18,22,17,19,20,21,15,23,24,26,25,27,28,29,30,33,34,36,16,2,37,1) 
									and 
									h.`h_id_province`=price.`price_id_province` 
									GROUP BY h_id_province,h_code
									
									
									)
									 as c  right join dm_province pp on c.h_id_province = pp.province_id
                                     group by province_id order by  pp.province_code_alef
						";
						
				//	print $query;
						$lnk = mysql_query($query);
						global $inx1;
						global $inx11;
						$inx1=1;
						$inx11=1;
						
						if(mysql_affected_rows()>0){
								$jroz21=0;
								$jroz22=0;
								$jroz23=0;
								$jroz24=0;
								$jroz25=0;
								$jroz26=0;
								$jroz27=0;
								$jroz28=0;
								$jroz29=0;
								$jroz30=0;
								$jroz21ta31=0;
						
							while($row = mysql_fetch_assoc($lnk)){
								
								$query1= " select * from dm_province 
								            where 
								              province_code=".$row['h_id_province']."	";
					
								$lnk1 = mysql_query($query1);
								$row1 = mysql_fetch_assoc($lnk1);
								
								$h_id_province=$row['h_id_province'];
							if( $code_customer != -2){
							$shart = "   h_customer_code= ". $code_customer ."";	
						}else{
					$shart = "  1 ";	
					}	
					
					$sezaf=0;	
					$sezafpre=0;	
					 	           
											
							if($inx11==2000){
									
									$inx11=1;
									
									$outHtml1 .= '<tr colspan="24" align="center" style="height: 50px;vertical-align:middle;"><td colspan="14">&nbsp;</td>
									       </tr>
									   <tr><td colspan="14">&nbsp;</td>
									       </tr>
									         <td colspan="14">
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
								
						 	//	<div align = "center">
							//<div align = "center" style="direction:rtl;">
								
														            
								}	
							
										if(($inx1)%2==1){
												$color='#C5DED0';
												
											
											}
												else{
													$color='#BBB';
												   
												}
							                    // if($row['shavale']> $row['sebtal']){
													//}else{
													 
														
												//	}				
												
						     $inx11 =urlencode($inx1);
						     $inx11=farsinum($inx11);
						  
								$outHtml1 .= '	
									     
											 <tr style="background-color:'.$color.';">
											   
											    <td width="100" colspan="2"><b>'.$row['province_name'].'</b></td>
											    <td width="100" align="center">'.$row['tarikh21'].'</td>
											    <td width="100" align="center">'.$row['tarikh22'].'</td>
											    <td width="100" align="center">'.$row['tarikh23'].'</td>
											    <td width="100" align="center">'.$row['tarikh24'].'</td>
											    <td width="100" align="center">'.$row['tarikh25'].'</td>
											    <td width="100" align="center">'.$row['tarikh26'].'</td>
											    <td width="100" align="center">'.$row['tarikh27'].'</td>
											    <td width="100" align="center">'.$row['tarikh28'].'</td>
											    <td width="100" align="center">'.$row['tarikh29'].'</td>
											    <td width="100" align="center">'.$row['tarikh30'].'</td>
											    <td width="100" align="center">'.$row['tarikh31'].'</td>
											    <td width="100" align="center">'.$row['tarikh21ta31'].'</td>
											    
											  </tr>';			
								$inx1++;
								$inx11++;
								//$amount=$amount+$mande;
									$jroz21=$jroz21+$row['tarikh21'];
									$jroz22=$jroz22+$row['tarikh22'];
									$jroz23=$jroz23+$row['tarikh23'];
									$jroz24=$jroz24+$row['tarikh24'];
									$jroz25=$jroz25+$row['tarikh25'];
									$jroz26=$jroz26+$row['tarikh26'];
									$jroz27=$jroz27+$row['tarikh27'];
									$jroz28=$jroz28+$row['tarikh28'];
									$jroz29=$jroz29+$row['tarikh29'];
									$jroz30=$jroz30+$row['tarikh30'];
									$jroz31=$jroz31+$row['tarikh31'];
									$jroz21ta31=$jroz21ta31+$row['tarikh21ta31'];
									
							
							}
						//	$kol=($gosfandv+$gosfandda+$gosalev+$gosaled+$morghv+$morghd);
							$outHtml1 .= '	
									     
											<tr style="background-color:red;">
											   
											    <td width="100" colspan="2"><b>جمع</b></td>
											    <td width="100" align="center">'.$jroz21.'</td>
											    <td width="100" align="center">'.$jroz22.'</td>
											    <td width="100" align="center">'.$jroz23.'</td>
											    <td width="100" align="center">'.$jroz24.'</td>
											    <td width="100" align="center">'.$jroz25.'</td>
											    <td width="100" align="center">'.$jroz26.'</td>
											    <td width="100" align="center">'.$jroz27.'</td>
											    <td width="100" align="center">'.$jroz28.'</td>
											    <td width="100" align="center">'.$jroz29.'</td>
											    <td width="100" align="center">'.$jroz30.'</td>
											    <td width="100" align="center">'.$jroz31.'</td>
											    <td width="100" align="center">'.$jroz21ta31.'</td>
											   
											  </tr>';
						
							//$jam=urlencode($jam);
							
							
							//$outHtml1.= '</table><div>&nbsp;</div>
						       //         <span style="background-color:red" width="70%">جمع کل:'.$kol.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
						//	                  <span style="background-color:red" width="70%">مقدار ابطالی:'.$ebtal1.'كيلوگرم </span>' ;		
						//	$outHtml1.= '</table><div>&nbsp;</div>
							              //    <span style="background-color:red" width="70%">مقدار خالص دريافتی:'.$khales.'كيلوگرم </span>' ;						
					    }else{
					    	$outHtml1 .= '<tr><td colspan="8">هيچ اطلاعاتي موجود نيست</td></tr></table>';
					    }	
	
}





    $queryu="SELECT * FROM dm_user_profile
			 
			     WHERE u_id=".$u_id."
			     ";
		   
		$lnku = mysql_query($queryu);
		$rowu = mysql_fetch_assoc($lnku);
  //  $outHtml1 .= '<div align="right"> '.$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'</div>';
     //   $outHtml1 .= '<div align="right">توسط کاربر: '.$rowu['u_family'].' </div>';
        
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
 