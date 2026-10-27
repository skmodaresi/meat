<?php
require_once __DIR__ . '/../../mysql_compat.php';
include_once 'includer.php';

$norozdate='2016-03-19';
$noroztime='2016-03-19 04:00:00';
	//az enja baraye ebtali
	
	$query = "select  *

					from `dm_havale` h
					left join dm_his_havale his
					on
					h.h_id=his.his_h_id
					where
					his_date='2018-03-20'
					AND
					his_reg_time='2016-03-19 04:00:00'
						 ";
	$lnk = mysql_query($query);	
	print $query;

	
		 while($row=mysql_fetch_assoc($lnk))
		 {
		 
		 	$h_amountnew=($row('h_amount') - $row('h_mande_havale'));
		 	
		 	$h_pricehnew=(($h_amountnew) * $row('h_p_priceh'));
		 	
		 	 $query7 = "
						UPDATE dm_havale 
						SET 
							`h_amount` = ". $h_amountnew .",
							`h_priceh` = ". $h_pricehnew .",
							`h_price` = ". $h_pricehnew ."
						
														 
						WHERE 
							h_id = ".$row['h_id']." 	";
					print $query7;		
//				    	$lnk7 = mysql_query($query7);
//						if(mysql_error()) print mysql_error();
							

				 $query8 = "
						UPDATE dm_his_havale
						SET 
							`his_eb_amount` = ". $row('h_mande_havale') ."
														 
						WHERE 
							his_id = ".$row['his_id']." 	";
					print $query8;		
//				    	$lnk8 = mysql_query($query8);
//						if(mysql_error()) print mysql_error();		
//						
						
		 	
		 }

 
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ايجاد سال جديد</title>
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
	font: 30px Verdana,Arial, Helvetica, sans-serif;
	margin: 10px auto;
	width: 300px;
	
	
}
.message{
    border:1px solid #CCCCCC;
    align:center;
	position:absolute;
	width:1000px;
	border:1px solid #c93;
	background:orange;
	padding:5px;
	right:0px;
	top : -170px;
}


</style>
</head>
<body>

<div id="object" class="message"> 
  
    <strong> <b> سال نو مبارك </b></strong>
  <p >!!!!!!!! سال جديد ايجاد شد </p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="color:#0000FF "><strong></strong></div>
  

</body>
</html>