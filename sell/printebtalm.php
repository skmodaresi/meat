<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <script type="text/javascript" src="jquery-1.2.3.pack.js"></script> 
</head> 
  <body style="background-image: url(images/ebtal.PNG);background-position:center;background-attachment:fixed;background-repeat:no-repeat;"></body>

<?php
require_once __DIR__ . '/../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');

include_once 'lib/php/jdf.php';
include_once 'lib/php/db_connect.php';
//include_once 'index.php';
 $day_number = jdate('j');
 $month_number = jdate('n');
 $year_number = jdate('y');
 $day_name = jdate('l');
 $day_number=farsinum($day_number);
 $month_number=farsinum($month_number);
 $year_number=farsinum($year_number);
 
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
$pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';

$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_id = '".$pf_id."' 		
			   
		   ";
		    
	$lnk = mysql_query($query);
	$cm_req_date=farsinum($cm_req_date);
//	print $query;
$reqNo=farsinum($reqNo);
$ph_code1=farsinum($PhNo);
	if(mysql_num_rows($lnk)>0){
		$out='<table  style="border:2px;"   align="center"  dir="rtl" clas="sample" width=80%>
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
                         <td colspan="8" style="text-shadow: 0.1em 0.1em 0.05em #333;"><center> ابطال معرفي نامه</center></td>
                                     
                    </tr>
                    <tr> 
                         <td colspan="8" ><center>&nbsp;</center></td>
                        
                    </tr>
                    <tr >  
                     
                       <td  width="15%"><b>شماره درخواست :</b></td><td width="10%"><b>'.$reqNo.'</b></td>
				       <td align="center" width="15%"><b>تاريخ درخواست :</b></td><td width="15%"><b>'.$cm_req_date.'</b></td>				      
				       <td align="center" width="15%"><b>شماره پيش حواله:</b></td>
				     <td  align="center" >'.$ph_code1.'</td>
                    </tr>
                    <tr> 
                         <td colspan="8">&nbsp;&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                         <td  ><b> نام مشتري :</b></td>
					     <td align="right" width="25%"><b>'.$cus_name.'</b></td>
					     
					     <td align="center" style="width:10%" > <b>نوع مشتري :</b></td>
					     <td >'.$Type.'</td>					    
				         <td align="center" ><b>تاريخ پيش حواله:</b></td>
				         <td align="center">'.$year_number.'/'.$month_number .'/'.$day_number.'</td>
				        
                    </tr>
                    </table><br><br>';
		

	
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$PhNo." 
			AND
			    phd_id_province=".$province_id."
			     AND
	          phd_id_year=".$year_id.""; 
		
		$lnk = mysql_query($query);
		$row = mysql_fetch_assoc($lnk);
//		print $query;
		$queryg = "
		 	SELECT *  FROM dm_location_goods 
	 
			WHERE 
				l_code = ".$row['phd_l_id']." 
			AND
			    l_id_province=".$province_id."
		";
		$lnkg = mysql_query($queryg);
		$rowg = mysql_fetch_assoc($lnkg);
//	print $queryg;
		
		if(mysql_num_rows($lnk)>0){
			
			$outHtml = '<div dir="rtl"><table  border="1"  align="center"   width=80%>
						<tr><td colspan="10" align="center">ريز معرفي نامه</td></tr>
						<tr>
							<td align="center">رديف</td>
							<td align="center">كد كالا</td>
							<td align="center">نام کالا</td>
							<td align="center">كد قيمت</td>
							<td align="center">مقدار خريد</td>
							<td align="center">كد محل تحويل</td>
							<td align="center">نام محل تحويل</td>
							<td align="center">نام تحويل گيرنده</td>
							<td align="center">تحويل با</td>	
						</tr>	
			';
			
			$inx = 0;
			$query1 = "
				 	SELECT *  FROM dm_pish_havale_det 
			 
					WHERE 
						phd_ph_code = ".$PhNo." 
					AND
					    phd_id_province=".$province_id."
				    AND  
				      phd_id_year='".$year_id."'";
				$lnk1 = mysql_query($query);
				
			while( mysql_fetch_assoc($lnk1)>0){
				
				$query2 = "
							 	SELECT *  FROM dm_product product
									left join dm_price price
									on product.p_id=price.price_p_id 
						 
								WHERE 
									p_code = ".$row['phd_pid']." 
									
							";
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
//							print $query2;
				$inx++;
				 $p_code=farsinum($row2['p_code']);
				 $phd_price_code=farsinum($row['phd_price_code']);
				 $amount=farsinum($amount);
				 $amount=farsinum($rowg['l_code']);
				$amount=formatMoney($amount);
				$outHtml .= '
						<tr>
							<td align="center">'.$inx.'</td>
							<td align="center">'.$p_code.'</td>
							<td align="center">'.$row2['p_name'].'</td>
							<td align="center">'.$phd_price_code.'</td>
							<td align="center">'.$amount.'</td>
							<td align="center">'.$rowg['l_code'].'</td>
							<td align="center">'.$rowg['l_name'].'</td>
							<td align="center">'.$row['phd_deli_name'].'</td>
							<td align="center">معرفي نامه</td>			
						</tr>';
					
					$querys = "
							 	SELECT *  FROM dm_signature_g 
						 
								WHERE 
									sig_status = ". 1 ." 
								AND
									sig_id_province = ".$province_id ." 
							";
							$lnks = mysql_query($querys);
							$rows= mysql_fetch_assoc($lnks);
			}
		     $outHtml .= '</table><br><br>
		    
		     </div>';
		     $outHtml .= '<table   dir="rtl" align="center"   width=75%>
		           <tr>
		               <td><b>'.$rows['sig1_m'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sig2_m'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sig3_m'].'</b></td>
		           </tr>
		           <tr>
		               <td><b>'.$rows['sigs1_m'].'</b></td>
		               <td width=20%>&nbsp;</td>
		               <td><b>'.$rows['sigs2_m'].'</b></td>
		                <td width=20%>&nbsp;</td>
		                <td><b>'.$rows['sigs3_m'].'</b></td>
		           </tr>
		           <tr>
		               <td colspan="5" align="center">'.$rows['text_m'].'</td>
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
  <p >!!!!!!!شما معرفي نامه را ثبت نكرديد </p>
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