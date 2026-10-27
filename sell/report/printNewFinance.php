<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  
</head> 	
<?php
require_once __DIR__ . '/../../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');
	include_once '../lib/php/jdf.php';
    include_once '../lib/php/db_connect.php';
    include_once '../lib/php/gen_def.php';

         $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
		 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
		 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'2010-01-01' ;
		 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '2018-03-01';
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

 global $outHtml;
 $queryp = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnkp = mysql_query($queryp);
	$rowp= mysql_fetch_assoc($lnkp);
	$province_ecode=farsinum($rowp['province_ecode']);
	$province_postal=farsinum($rowp['province_postal']);
	$province_tel=farsinum($rowp['province_tel']);
	$province_sabt=farsinum($rowp['province_sabt']);
	$queryy = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnky = mysql_query($queryy);
	//	print $query1;
		$rowy= mysql_fetch_assoc($lnky);
		$year_code=$rowy['year_code'];
		?>
		
<form action="../lib/php/exporttoexcel.php" method="post"    
   onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportT").eq(0).clone() ).html() )'>
   <?php 
		 $outHtml='<div  >
	 <table width="1003"  id="ReportT"  height="256" border="1" cellpadding="2" cellspacing="2">
  <caption>
 گزارش فروش <br />
 '.$year_code.'  سال  
  </caption>
  <tr>
    <th width="1500" height="112" scope="col" ><table width="994"  cellspacing="2" cellpadding="2">
      <tr>
        <th colspan="3" scope="col">&nbsp;</th>
        <th width="275" scope="col"><div align="right">
          <table width="153"  align="left" cellpadding="2" cellspacing="2" id="ReportTable">
            <tr >
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="7">&nbsp;</td>
              <td width="6">&nbsp;</td>
            </tr>
        </table>
        كد پستی 10 رقمی : <span>'.$province_postal.'  </div></th>
        <th width="249" scope="col"><div align="right">نشاني : <span>'.$rowp['province_address'].'</span></div></th>
        <th width="296" scope="col"><div align="right">     نام فروشنده :   <span>شركت پشتيباني استان '.$rowp['province_name'].'</span></div></th>
      </tr>
      <tr>
      <tr>
        <td width="75"><form id="form4" name="form4" method="post" action="">
          <input type="checkbox" name="checkbox4" value="checkbox" id="checkbox2" />
          <label for="checkbox2">زمستان</label>
        </form>        </td>
        <td width="73" height="31"><form id="form3" name="form3" method="post" action="">
            <label>
            <input type="checkbox" name="checkbox3" value="checkbox" />
            پائيز</label>
        </form></td>
        <td width="95"><form id="form2" name="form2" method="post" action="">
            <label>
            <input type="checkbox" name="checkbox2" value="checkbox" />
             تابستان</label>
        </form></td>
        <td width="75"><form id="form1" name="form1" method="post" action="">
            <label for="checkbox">
            <input type="checkbox" name="checkbox" value="checkbox" id="checkbox" />
            بهار</label>
        </form></td>
        <td width="223"><div align="left">:گزارش فصل</div></td>
        
        <td align="right">'. $province_ecode.' :شماره اقتصادی/ملی</td>
    
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td><div align="right">'. $province_tel.' :تلفن</div></td>
        <td><div align="right"> '. $province_sabt.':شماره ثبت </div></td>
      </tr>
    </table></th>
  </tr>
  <tr>
    <td><table width="994" border="1" cellspacing="2" cellpadding="2">
      <tr bgcolor="#FFFFCC">
        <td width="51"  align="center" rowspan="2">جمع كل </td>
        <td colspan="2">ماليات بر ارزش افزوده
          <div align="right"></div></td>
        <td><div align="right">مبلغ خريد به ريال </div></td>
        <td width="44" rowspan="2"><div align="right">كد برگشتي </div></td>       
        <td width="118"><div align="right">شرح نوع كالا/خدمات </div></td>
        <td width="99"><div align="center">شماره تلفن-كد شهر</div></td>
        <td colspan="2"><div align="center">نشانی</div></td>
        <td width="201"><div align="right">( نام و نام خانوادگي /نام شركت(خريدار </div></td>
        <td width="30" rowspan="2"><div align="right">رديف</div></td>
      </tr>
      <tr bgcolor="#FFFFCC">
     
        <td width="54">عوارض</td>
        <td width="44">ماليات</td>
        <td width="97">&nbsp;</td>
        
        <td><div align="right">(ايران كد(كدكالا </div></td>
        <td width="99"  align="center">كد پستي 10 رقمي  </td>
        <td width="80"><div align="right">&#1582;&#1610;&#1575;&#1576;&#1575;&#1606;</div></td>
        <td width="84"><div align="right">&#1588;&#1607;&#1585;</div></td>
        <td><div align="right">شماره اقتصادی/ملی  </div></td>
        </tr>';
    
		$query = "  select p_name,code_postal_costumer,h_p_price,personality_customer,p_sellprice,p_sellpriceh, p_price_code,`cat_prod_name`

		 ,sum(case when havaleinBaze = 1  then shavale else 0 end) 

		 
		 shavale
				  
		 ,sum(case when EbtalInBaze = 0 then sebtal else 0 end ) sebtalkharej 
		 ,sum(case when EbtalInBaze = 1 then sebtal else 0 end ) sebtalDakhel
		 ,sum(SUM_price)  sprice
         ,p_code
		 ,h_customer_code
		 ,h_p_add
		 , sum(shavalepr) shavalepre
		 ,h_p_add
		 ,h_p_code
		 ,h_price_code
		 ,customer_tel
		 ,customer_address_office
		 ,name_customer
		
		 ,customer_cusid_city
        ,customer_gl_code
        ,customer_gl_economic
        
 from ( select h_code ,h_p_code,h_p_price,h_price_code,p_sellpriceh, ph_code ,h_id_province, h_reg_date , ph_mojavez , p_name , p_code, p_sellprice , h_amount , l_name,p_price_code ,cat_prod_name
  , h_customer_code ,h_p_add, case when h.`h_status` = 1 then 'ابطال کلی' else case when his.his_h_id is null
   then 'ابطال نشده' else 'ابطال جزئی' end end as STATUS_EBTAL ,

  case when ebt2.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'    or ebt.ebh_reg_date between '".$firstDate."'  AND  '".$EndDate."'   then case when h.`h_status` = 1
  then h.`h_amount` else case when his.his_h_id is null then 0 else sum(his.`his_eb_amount`) end end  else 0 end as sebtal ,    
  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then case when h.`h_status` = 1 then  0     else  h.`h_amount`  end  end  as shavale, 
  CASE when h_reg_date between '".$firstDate."'  AND  '".$EndDate."'  then   h.`h_pre_amount`    end  as shavalepr, 
  
    (case when (  ( (`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) and (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."' )) then (case when (`h`.`h_status` = 1) then `h`.`h_amount` else (case when isnull(`his`.`his_h_id`) then 0 else `his`.`his_eb_amount` end) end) else 0 end) AS `sebtalBaze`,
    
     case when h.`h_status` = 1 
      then 0 else case when his.his_h_id is null then h.h_price else h.h_price end end as SUM_price ,
      
          (case when (((`ebt2`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ) or (`ebt`.`ebh_reg_date` between '".$firstDate."'  AND  '".$EndDate."'  ))) then 1 else 0 end) AS `EbtalInBaze`,
    (case when (`h`.`h_reg_date` between '".$firstDate."'  AND  '".$EndDate."') then 1 else 0 end) AS `havaleInBaze`
      ,h.h_status
      
      ,count(ebt.ebh_h_id) + count(ebt2.ebh_h_id) +1   as ebtcnt
      
      
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
//if ($l_id != -2){
//		
	//	$query .= " AND  h_l_code= ".$l_id ." ";
//	}

//if ($p_pakage_type != -2){
		
//		$query .= " AND   p_pakage_type= ".$p_pakage_type ." ";
//	}
if ($p_subsidies != -2){
		
		$query .= " AND   p_subsidies= ". $p_subsidies ." ";
	}	
	
	$query .= "	group by `h_code` )  ";
	$query .= " as c ";	
			
    $query .= " left join dm_customer cus2 on cus2.code_customer=c.h_customer_code and cus2.`customer_province_id` = ".$province_id."
          ";


   $query .= "left join dm_customer_category cuscat on cus2.customer_category=cuscat.category_id  ";
         
//	if ($category_id != -2){
//		 
//		$query .= "  AND   category_id= ". $category_id ." ";
//	}
	if ($code_customer != -2 AND $city_id != -2){
		
		$query .= " where  h_customer_code= ". $code_customer ."  AND   customer_cusid_city= ". $city_id ." ";
	}else if( $code_customer != -2){
		$query .= " where  h_customer_code= ". $code_customer ."";
		
	}else if ($city_id != -2){
		 
		$query .= " where   customer_cusid_city= ". $city_id ." ";
	}
	$query .= " group by  h_customer_code,h_id_province ,h_p_code,h_price_code,h_p_add
         ORDER BY  p_name, p_price_code asc";
//	print $query;	
	$lnk = mysql_query($query);
	global $inx;
	global $inx1;
	$inx=0;
	$inx1=0;
	if(mysql_affected_rows()>0){
		$amount=0;
	    $ebtal=0;
	    $sumprice=0;
		$jamkol=0;
		$jprice=0;
		while($row = mysql_fetch_assoc($lnk)){
		
		
	
	$sezafpre=0;
	
	//echo $sezafpre;
	//echo '/';
	
	
		if($row['customer_gl_code']=='' or $row['customer_gl_code']==0){
			$melishenase=$row['customer_gl_economic'];
			
			
		}else{
			
			$melishenase=$row['customer_gl_code'];
		}
	
	
								
								
		
				if(($inx1)%5==0){	
					
					
					
					$hh="page-break-before:always";
	$outHtml.='  <tr>
						    <td colspan="11" align="right">امضاء شخص حقيقی  

						    
						    
						    &nbsp;&nbsp;&nbsp;&nbsp;
						     &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
						    مهر و امضاء شخص حقوقی
						    
						    </td>

						  </tr>
						  <tr align="right">
						    <td colspan="11">
						      در صورت برگشت از فروش و تخفيفات فصول قبل سال جاري با قيد رقم ، ستون كد برگشتی با علامت 

						      
						      مشخص گردد
						      <br>
						      ضمنا رقم برگشتی در داخل پرانتز و در رديف مربوطه كلا با رنگ قرمز نوشته شود
						      <br>
						      مواردی كه كد كالا مشخص نمی‍باشد در ستون مربوطه شرح نوع كالا ذكر شود
				
	      </td>
	      
						  </tr>		
	<tr >
    	<td colspan="14">
	  <table width="1000" height="200" border="1" cellpadding="2" cellspacing="2">
	 
	  <tr>
	    <th width="1500" height="145" scope="col" ><table width="994"  cellspacing="2" cellpadding="2">
	   <tr>
	        <th colspan="3" scope="col">&nbsp;</th>
	        <th width="275" scope="col"><div align="right">
	          <table width="153"  align="left" cellpadding="2" cellspacing="2">
	   <tr >
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="7">&nbsp;</td>
	              <td width="6">&nbsp;</td>
	    </tr>
	        </table>
	        كد پستی 10 رقمی : <span>'.$province_postal.'  </div></th>
	        <th width="249" scope="col"><div align="right">نشاني : <span>'.$rowp['province_address'].'</span></div></th>
	        <th width="296" scope="col"><div align="right">     نام فروشنده :   <span>شركت پشتيباني استان '.$rowp['province_name'].'</span></div></th>
	     </tr>
	     <tr>
         <tr>
	        <td width="75"><form id="form4" name="form4" method="post" action="">
	          <input type="checkbox" name="checkbox4" value="checkbox" id="checkbox2" />
	          <label for="checkbox2">زمستان</label>
	        </form>        </td>
	        <td width="73" height="31"><form id="form3" name="form3" method="post" action="">
	            <label>
	            <input type="checkbox" name="checkbox3" value="checkbox" />
	            پائيز</label>
	        </form></td>
	        <td width="95"><form id="form2" name="form2" method="post" action="">
	            <label>
	            <input type="checkbox" name="checkbox2" value="checkbox" />
	             تابستان</label>
	        </form></td>
	        <td width="50"><form id="form1" name="form1" method="post" action="">
	            <label for="checkbox">
	            <input type="checkbox" name="checkbox" value="checkbox" id="checkbox" />
	            بهار</label>
	        </form></td>
	        <td width="223"><div align="left">:گزارش فصل</div></td>  
	       <td align="right">'. $province_ecode.' :شماره اقتصادی/ملی</td>    
	      </tr>
	      <tr>
	        <td colspan="4">&nbsp;</td>
	        <td><div align="right">'. $province_tel.' :تلفن</div></td>
	        <td><div align="right"> '. $province_sabt.':شماره ثبت </div></td>
	      </tr>
	    </table></th>
	  </tr>
	  <tr>
	    <td style="height: 0px;" width="10"><table width="994" border="1" cellspacing="2" cellpadding="2">
	      <tr bgcolor="#FFFFCC">
	        <td width="51"  align="center" rowspan="2">جمع كل </td>
	        <td colspan="2">ماليات بر ارزش افزوده
	          <div align="right"></div></td>
	        <td><div align="right">مبلغ خريد به ريال </div></td>
	        <td width="44" rowspan="2"><div align="right">كد برگشتي </div></td>       
	        <td width="118"><div align="right">شرح نوع كالا/خدمات </div></td>
	        <td width="99"><div align="center">شماره تلفن-كد شهر</div></td>
	        <td colspan="2"><div align="center">نشانی</div></td>
	        <td width="201"><div align="right">( نام و نام خانوادگي /نام شركت(خريدار </div></td>
	        <td width="30" rowspan="2"><div align="right">رديف</div></td>
	      </tr>
	      <tr bgcolor="#FFFFCC">
	     
	        <td width="54">عوارض</td>
	        <td width="44">ماليات</td>
	        <td width="97">&nbsp;</td>
	        
	        <td><div align="right">(ايران كد(كدكالا </div></td>
	        <td width="99"  align="center">كد پستي 10 رقمي  </td>
	        <td width="80"><div align="right">&#1582;&#1610;&#1575;&#1576;&#1575;&#1606;</div></td>
	        <td width="84"><div align="right">&#1588;&#1607;&#1585;</div></td>
	        <td><div align="right">شماره اقتصادی/ملی  </div></td>
	        </tr>
	        </table></td>
						  </tr>
						  
						</table>
			</td>
			</tr>';
						
						
					
				}else{
					$hh="";
				}		
	
		
							$querypro="SELECT * FROM dm_province 
									    WHERE
									      province_id=".$province_id."
									    ";									     	     											
								$lnkpro = mysql_query($querypro);
								$rowpro = mysql_fetch_assoc($lnkpro);
								
								
							$querycity="SELECT * FROM dm_city 
									    WHERE
									      city_id=".$row['customer_cusid_city']."
									    ";									     	     											
								$lnkcity = mysql_query($querycity);
								$rowcity = mysql_fetch_assoc($lnkcity);
					if(($inx)%2==1){
							$color='#C5DED0';
							
						
						}
							else{
								$color='#BBB';
							   
							}
			
							$mande=($row['shavalepre']-$row['sebtal'])- $sezafpre;
							
							
							$spriceh=$mande * $row['h_p_price'];
							
							
							$spriceh=formatMoney($spriceh);
							
							$shavale=formatMoney($row['shavale']);
							$mande1=formatMoney($mande1);
					$sprice1=farsinum($spriceh);
					$customer_tel=farsinum($row['customer_tel']);
					$code_postal_costumer=farsinum($row['code_postal_costumer']);
					$p_code=farsinum($row['p_code']);
						
				    $code_economic_customer=farsinum($row['code_economic_customer']);	
			                 
							
					if($row['shavalepre'] !=0  AND $row['sebtalDakhel']!=0 )
					  {         $inx++;	
								$inx1++;
							
						$inx=urlencode($inx);
					    $inx2=farsinum($inx);
						$mande=($row['shavalepre']-$row['sebtal'])- $sezafpre;
					     $spriceh=$row['shavalepre'] * $row['h_p_price'];
					     $jprice=$jprice+$spriceh;
					     $jamkol=$spriceh+$jamkol;
						 $spriceh=formatMoney($spriceh);
					     $spriceh1=farsinum($spriceh);
						
                         $outHtml .= '  <tr  style="background-color:'.$color.';">
								<td width="54" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="22" rowspan="2">...</td>
								<td width="23" rowspan="2">...</td>
								<td width="99" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="44" rowspan="2"><div align="right">... </div></td>
								<td width="111"><div align="right">'.$row['p_name'].' </div></td>
								<td width="108"><div align="center">'.$customer_tel.'</div></td>
								<td width="28" rowspan="2">'.$row['customer_address_office'].'</td>
								<td width="30" rowspan="2">'.$rowcity['city_name'].' </td>
								<td width="199"><div align="right">'.$row['name_customer'].' </div></td>
								<td width="31" rowspan="2"><div align="right">'.$inx2.'</div></td>
							   </tr>
							   <tr  style="background-color:'.$color.';">
								<td width="108"><div align="center">'.$p_code.' </div></td>
								<td><div align="right">'.$code_postal_costumer .' </div></td>
								<td><div align="right">'.$melishenase.'  </div></td>
								</tr>';
								$mande=$row['sebtalDakhel'];
					
								$spriceh=$mande * $row['h_p_price'];
								$spriceh=formatMoney($spriceh);
								$spriceh1=farsinum($spriceh);
								$inx++;	
								$inx1++;
							    $inx=urlencode($inx);
						        $inx2=farsinum($inx);
			                      $outHtml .= '  <tr  style="background-color:'.$color.';">
								<td width="54" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="22" rowspan="2">...</td>
								<td width="23" rowspan="2">...</td>
								<td width="99" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="44" rowspan="2"><div align="right">'.$row['ebh_code'].' </div></td>
								<td width="111"><div align="right">'.$row['p_name'].' </div></td>
								<td width="108"><div align="center">'.$customer_tel.'</div></td>
								<td width="28" rowspan="2">'.$row['customer_address_office'].'</td>
								<td width="30" rowspan="2">'.$row['city_name'].' </td>
								<td width="199"><div align="right">'.$row['name_customer'].' </div></td>
								<td width="31" rowspan="2"><div align="right">'.$inx2.'</div></td>
							   </tr>
							   <tr  style="background-color:'.$color.';">
								<td width="108"><div align="center">'.$p_code.' </div></td>
								<td><div align="right">'.$code_postal_costumer .' </div></td>
								<td><div align="right">'.$melishenase.' </div></td>
								</tr>';
			
					
					}else if($row['shavalepre'] !=0  )
					
                       {     $inx++;	
							 $inx1++;
						     $inx=urlencode($inx);
					         $inx2=farsinum($inx);
                       	   
							$mande=(($row['shavalepre']+$row['sebtalDakhel'])- $sezaf);
						
							$spriceh=$row['shavalepre'] * $row['h_p_price'];
							$jprice=$jprice+$spriceh;
							
							$jamkol=$spriceh+$jamkol;
						    $spriceh=formatMoney($spriceh);
						    $spriceh1=farsinum($spriceh);
						     
                             $outHtml .= '  <tr  style="background-color:'.$color.';">
								<td width="54" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="22" rowspan="2">...</td>
								<td width="23" rowspan="2">...</td>
								<td width="99" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
								<td width="44" rowspan="2"><div align="right">--- </div></td>
								<td width="111"><div align="right">'.$row['p_name'].' </div></td>
								<td width="108"><div align="center">'.$customer_tel.'</div></td>
								<td width="28" rowspan="2">'.$row['customer_address_office'].'</td>
								<td width="30" rowspan="2">'.$rowcity['city_name'].' </td>
								<td width="199"><div align="right">'.$row['name_customer'].' </div></td>
								<td width="31" rowspan="2"><div align="right">'.$inx2.'</div></td>
							   </tr>
							   <tr  style="background-color:'.$color.';">
								<td width="108"><div align="center">'.$p_code.' </div></td>
								<td><div align="right">'.$code_postal_costumer .' </div></td>
								<td><div align="right">'.$melishenase.'  </div></td>
								</tr>';
					    }else if( $row['sebtalDakhel']!=0 )
		                   {    $inx++;	
								$inx1++;
								$inx=urlencode($inx);
							    $inx2=farsinum($inx);
                                $mande=$row['sebtalDakhel'];
								$spriceh=$mande * $row['h_p_price'];
							
								$spriceh=formatMoney($spriceh);
								$spriceh1=farsinum($spriceh);
								$outHtml .= '  <tr  style="background-color:'.$color.';">
												<td width="54" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
												<td width="22" rowspan="2">...</td>
												<td width="23" rowspan="2">...</td>
												<td width="99" rowspan="2"><div align="center">'.$spriceh1.' </div></td>
												<td width="44" rowspan="2"><div align="right">'.$row['ebh_code'].' </div></td>
												<td width="111"><div align="right">'.$row['p_name'].' </div></td>
												<td width="108"><div align="center">'.$customer_tel.'</div></td>
												<td width="28" rowspan="2">'.$row['customer_address_office'].'</td>
												<td width="30" rowspan="2">'.$rowcity['city_name'].' </td>
												<td width="199"><div align="right">'.$row['name_customer'].' </div></td>
												<td width="31" rowspan="2"><div align="right">'.$inx2.'</div></td>
											   </tr>
												<tr  style="background-color:'.$color.';">
												<td width="108"><div align="center">'.$p_code.' </div></td>
												<td><div align="right">'.$code_postal_costumer .' </div></td>
												<td><div align="right">'.$melishenase.' </div></td>
												</tr>';
						}
									
					}
		
		
	 	  	$outHtml .= '<tr>
					    <td> جمع كل مبلغ: '.$jprice.'</td>
					  
						  </tr>
		</table></td>
		                    
						  </tr>
					 
						  
						  
						  <tr>
						    <td colspan="4" align="right">امضاء شخص حقيقی  

						    
						    
						    &nbsp;&nbsp;&nbsp;&nbsp;
						     &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
						    مهر و امضاء شخص حقوقی
						    
						    </td>

						  </tr>
						  <tr align="right">
						  
						    <td>
						      در صورت برگشت از فروش و تخفيفات فصول قبل سال جاري با قيد رقم ، ستون كد برگشتی با علامت 

						      
						      مشخص گردد
						      <br>
						      ضمنا رقم برگشتی در داخل پرانتز و در رديف مربوطه كلا با رنگ قرمز نوشته شود
						      <br>
						      مواردی كه كد كالا مشخص نمی‍باشد در ستون مربوطه شرح نوع كالا ذكر شود
				
	      </td>
	      
						  </tr>
						</table>';
	}
//	<td><input type="hidden" id="datatodisplay" name="datatodisplay"> </td> 
	//       <td> <input type="submit" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:100px;" value="خروجی در اکسل">  		    			      
		echo  $outHtml; 
		
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
?>