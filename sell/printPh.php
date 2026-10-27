<html>

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  <style type="text/css">
body {
	font: 16px Arial,Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	 
	
}
.blind {

font-size:20px;


}


</style>
  
</head> 
<?php
 header('Content-Type: text/html; charset=UTF-8');

include_once 'lib/php/jdf.php';
include_once 'lib/php/db_connect.php';
//include_once 'index.php';
 $day_number = jdate('j');
 $month_number = jdate('n');
 $year_number = jdate('y');
 $day_name = jdate('l');
 
$PhNo = isset($_REQUEST['PhNo']) ? $_REQUEST['PhNo'] : '8';
$Type = isset($_REQUEST['cus_type']) ? $_REQUEST['cus_type'] : '';
$Type='معمولي';
$reqNo = isset($_REQUEST['reqNo']) ? $_REQUEST['reqNo'] : '';
$cus_name = isset($_REQUEST['cus_name']) ? $_REQUEST['cus_name'] : '';
$cus_economic = isset($_REQUEST['cus_economic']) ? $_REQUEST['cus_economic'] : '';
$cus_postal = isset($_REQUEST['cus_postal']) ? $_REQUEST['cus_postal'] : '';
$cus_address_office = isset($_REQUEST['cus_address_office']) ? $_REQUEST['cus_address_office'] : '';
$cus_tel = isset($_REQUEST['cus_tel']) ? $_REQUEST['cus_tel'] : '';
$cm_req_date = isset($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';
$cus_category = isset($_REQUEST['cus_category']) ? $_REQUEST['cus_category'] : '';
$province_name = isset($_REQUEST['province_name']) ? $_REQUEST['province_name'] : '';
$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
$year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '2';

$reqNo=farsinum($reqNo);

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
				    ph_code='".$PhNo."'
                      group by h_code					
					";					 	    					   
    			$lnkchek = mysql_query($querychek);
			if(mysql_num_rows($lnkchek)>0)
		{
			//print $querychek ;
				$s=	'';
				if(mysql_num_rows($lnkchek)==1)
                       {
					   $rowchek = mysql_fetch_assoc($lnkchek);
					   $h_code=farsinum($rowchek['h_code']);
                               $l='حواله شماره '.$h_code.' برای اين پيش نويس حواله صادر شده است';
                        }else{
									while($rowchek = mysql_fetch_assoc($lnkchek))
								{
								    $h_code=farsinum($rowchek['h_code']);
									$s .=$h_code.',';					   
								}
								$l='شماره حواله های '.$s.'برای اين پيش نويس حواله صادر شده است';
                            }
        }else{
		$l='براي اين پيش نويس حواله، حواله اي صادر نشده است.';
		
		}
//debuging
		$querychk = " SELECT *  FROM 
                          dm_pish_factor pf 
                        inner join  dm_pish_havale ph  on  ph.ph_code=pf.pf_ph_code
                     left join dm_pish_havale_det phd  on phd.phd_ph_code=ph.ph_code					 
				WHERE 
				 
					phd_id_province='".$province_id."'
                AND
				    pf_id_province='".$province_id."'
				AND
				    ph_id_province='".$province_id."'	
				 
				AND
				    ph_code='".$PhNo."'
                      group by pf_code					
					";					 	    					   
    			$lnkchk = mysql_query($querychk);
    			//print $querychk;
			if(mysql_num_rows($lnkchk)>0)
		{
			$rowchk = mysql_fetch_assoc($lnkchk);
			if($rowchk['pf_type']==1){
		$tahvil='معرفي نامه';	}else{
			
			$tahvil='حواله';
			
			
		}
			
		}else{
			
			$tahvil='نا مشخص';
			
		}

$query = "
			 SELECT *  FROM dm_pish_havale_det 			 
				 WHERE 
						phd_p_price = 0 
				 AND 
					phd_id_province='".$province_id."'  ";					   								 	    					   
    			$lnk = mysql_query($query);
    		
	if(mysql_num_rows($lnk)>0)
	{
				
			while($row = mysql_fetch_assoc($lnk))
			{
			
				 $queryp="SELECT * FROM dm_product product
							left join dm_price price
						on product.p_id=price.price_p_id
						left join dm_prod_det_u   det_u
						on   product.p_unit=det_u.unit_prod_id
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
								`phd_p_price` = ".$rowp['p_sellprice']." ,
                                `phd_priceh` = '".$phd_priceh."',
								`phd_p_priceh` = ".$rowp['p_sellpriceh']."  								
								
													 
							WHERE 
								phd_id_province = ".$province_id." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
								
	//print $query;
						$lnk = mysql_query($query);
					
								
				}
     }	
//
//age status=1 bashe yani tarikh bar aks omade enja
if($status==1 ){
	 $date = explode('/', $cm_req_date);
	 $cm_req_date=$date[2].'/'.$date[1].'/'.$date[0] ;
	 $cm_req_date=farsinum($cm_req_date);
}
else{
$gdate=$cm_req_date;
list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
$cm_req_date = $jyear."/".$jmonth."/".$jday;

$cm_req_date=farsinum($cm_req_date);
}

$cm_req_date=farsinum($cm_req_date);
$query = "
	 	SELECT *  FROM dm_province 
 
		WHERE 
			province_id = '".$province_id ."'"; 
		 		
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);
	$province_name=$row['province_name'];

$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$PhNo."' 
			
		AND
		  ph_id_province =".$province_id."
	   AND
		  ph_id_year =".$year_id."
		 
	   ";
//print $query;	
	$lnk = mysql_query($query);
	$rowph= mysql_fetch_assoc($lnk);
	
$queryco1 = "	SELECT *  FROM dm_customer
 
		WHERE 
			code_customer = '".$rowph['ph_customer_code']."' 
			
		AND
		  customer_code_org =".$province_id."
	   ";

	$lnkco1 = mysql_query($queryco1);
	$rowco1= mysql_fetch_assoc($lnkco1);
	$PhNo1=farsinum($PhNo);
	$ph_customer_code=farsinum($rowph['ph_customer_code']);
	$cm_req_date=farsinum($cm_req_date);
	$year_number=farsinum($year_number);
	$month_number=farsinum($month_number);
	$day_number=farsinum($day_number);
	$ph_mojavez=farsinum($rowph['ph_mojavez']);
	
	//echo $rowph['ph_reg_date'];
$gdate=$rowph['ph_reg_date'];
list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
$ph_reg_date = $jyear."/".$jmonth."/".$jday;
$ph_reg_date=farsinum($ph_reg_date);
$querychk = "
	 	SELECT *  FROM dm_pish_havale_det 
 
		WHERE 
			phd_ph_code = '".$PhNo."' 
			
		AND
		  phd_id_province =".$province_id."
	   AND
		  phd_id_year =".$year_id."
		 
	   ";

	$lnkchk = mysql_query($querychk);
	$rowchk= mysql_fetch_assoc($lnkchk);
	
//	print $querychk ;
	if(mysql_affected_rows()>0){
		$out='<table  style="border:2px;"   align="center"  dir="rtl"  width="80%" >
                   <tr>
                      <td align="center" colspan="16" style="text-shadow: -1px 0 black, 0 1px black
                                    ;"><img src="images/allah1.PNG"><b>وزارت جهاد کشاورزي</b></td>
                      
                   </tr>
                   <tr>
                       <td align="center" style="text-shadow: -1px 0 black   ;" colspan="16" ><b> شركت سهامي پشتيباني امور دام كشور</b><b> - </b><b> اداره كل استان '. $province_name .'</b> </td>
                                               
                    </tr>
                    <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> سيستم فروش</center></td>
                        
                    </tr>
					 <tr> 
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> (پيش نويس حواله)</center></td>
                        
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
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                    <tr >  
                     
                       <td  width="15%"><b>شماره درخواست :</b></td><td width="10%" class="blind" class="blind"><b>'.$reqNo.'</b></td>
				       <td align="center" width="15%"><b>تاريخ درخواست :</b></td><td width="15%" class="blind"><b>'.$cm_req_date.'</b></td>				      
				       <td align="center" width="15%"><b>شماره پيش حواله:</b></td>
				     <td  align="center" class="blind" >'.$PhNo1.'</td>
                    </tr>
                    <tr> 
                         <td colspan="8">&nbsp;&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                         <td  ><b> نام مشتري :</b></td>
					     <td align="right" width="25%"><b>'.$cus_name.'</b></td>
					     
					     <td align="center" style="width:10%" > <b> كد مشتری :</b></td>
					     <td class="blind">'.$ph_customer_code.'</td>					    
				         <td align="center" ><b>تاريخ پيش حواله:</b></td>
				         <td align="center" class="blind">'.$ph_reg_date.'</td>
				        
                    </tr>
                    <tr>
                         <td  ><b> شماره مجوز :</b></td>
					     <td align="right" width="25%" class="blind"><b>'.$ph_mojavez.'</b></td>
					     
					     
				        
                    </tr>
                      <tr>  
                       <td  width="20%"><b> شناسه ملی :</b></td><td width="10%"><b>'.$rowco1['customer_national_tax'].'</b></td>
				       <td align="center" width="15%"><b>کد/شماره ملی</b></td><td width="15%"><b>'.$rowco1['customer_gl_code'].'</b></td>				      
				       <td align="center" width="15%"><b>کد اقتصادی</b></td>
				       <td  align="center" >'.$rowco1['customer_gl_economic'].'</td> 
                    </tr>
                    </table><br><br>';
		
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$PhNo." 
			AND
			    phd_id_province=".$province_id."
		 AND
		  phd_id_year =".$year_id."";
		$lnk = mysql_query($query);
	//print $query;

		if(mysql_affected_rows()>0){
			
			$outHtml = '<div dir="rtl"><table  border="1"  align="center"   width=80%>
						<tr><td colspan="10" align="center">ريز پيش حواله</td></tr>
						<tr>
							<td align="center">رديف</td>
							<td align="center">كد كالا</td>
							<td align="center">نام کالا</td>
							<td align="center">كد قيمت</td>
							<td align="center">مقدار خريد</td>
							<td align="center">كد محل تحويل/تحوبل روباری</td>
							<td align="center">نام محل تحويل/تحویل روباری</td>
							<td align="center">نام تحويل گيرنده</td>
							<td align="center">تحويل با</td>	
						</tr>	
			';
			
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
				         select * from dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id
							left join dm_prod_det_u   det_u
									on   product.p_unit=det_u.unit_prod_id
					           WHERE p_code=".$row['phd_pid']." 
					        AND 
					        p_price_code=".$row['phd_price_code']."
					        AND
					         price_id_province=".$province_id."
				
								
							";
				//print $query2;
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$queryunit = "
						 	SELECT *  FROM  dm_prod_det_u 
					 
							WHERE 
								unit_prod_id = ".$row['phd_id_unit']." 
						";
						$lnkunit = mysql_query($queryunit);
						$rowunit= mysql_fetch_assoc($lnkunit);
                    // print $queryunit;
				$inx++;
				 $queryl = "
							 	SELECT *  FROM dm_location_goods 
						 
								WHERE 
									l_id = ".$row['phd_l_id']." 
								AND
		                         l_id_province =".$province_id."
		               					";
							$lnkl = mysql_query($queryl);
							$rowl= mysql_fetch_assoc($lnkl);
							
					$query3 = "
							 	SELECT *  FROM dm_location_goods 
						 
								WHERE 
									l_id = ".$row['phd_robari']." 
								AND
		                         l_id_province =".$province_id."
		               					";
							$lnk3 = mysql_query($query3);
							$row3= mysql_fetch_assoc($lnk3);		
							
							
							
							
				$amount=formatMoney($row['phd_amount']);
				$amount=farsinum($amount);
				$p_code=farsinum($row2['p_code']);
				$l_code=farsinum($rowl['l_code']);
				$l_code1=farsinum($row3['l_code']);
				$p_price_code=farsinum($row['phd_price_code']);
				$phd_deli_name=farsinum($row['phd_deli_name']);
				$inxx=urlencode($inx);	
				$inxx=farsinum($inxx);
			//	echo $row['unit_prod_name'];
				$outHtml .= '
						<tr>
							<td align="center">'.$inxx.'</td>
							<td align="center" class="blind">'.$p_code.'</td>
							<td align="center">'.$row2['p_name'].'</td>
							<td align="center" class="blind">'.$p_price_code.'</td>
							<td align="center" class="blind">'.$amount.'('.$rowunit['unit_prod_name'].')</td>
							<td align="center" class="blind">'.$l_code1.'/'.$l_code.'</td>
							<td align="center">'.$rowl['l_name'].'/'.$row3['l_name'].'</td>
							<td align="center">'.$phd_deli_name.'</td>
							<td align="center">'.$tahvil.'</td>			
						</tr>
					';
					$querys = "
							 	SELECT *  FROM dm_signature_g 
						 
								WHERE 
									sig_status = ". 1 ." 
								AND
								   sig_id_province=".$province_id  ."
								
							";
							$lnks = mysql_query($querys);
							$rows= mysql_fetch_assoc($lnks);
			}
		     $outHtml .= '</table><br><br>
		    
		     </div>';
		     $outHtml .= '<table   dir="rtl" align="center"   width=75%>
		           <tr>
		               <td><b>'.$rows['sig1_ph'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sig2_ph'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sig3_ph'].'</b></td>
		           </tr>
		           <tr>
		               <td><b>'.$rows['sigs1_ph'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sigs2_ph'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sigs3_ph'].'</b></td>
		           </tr>
		           <tr>
		              <td colspan="5" align="center">'.$rows['text_ph'].'</td>
		           </tr>
		           </table>';
	} 
	else{
		$outHtml='';
	
	}
echo $out;
	echo $outHtml;
	
		}
		else
		{
		?>
	
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
  <p >!!!!!!!! شما كالايي انتخاب نكرديد </p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="color:#0000FF "><strong></strong></div>
  

</body>
</html>
	<?php 	
		
		}
//echo $_REQUEST['phd_name'];

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