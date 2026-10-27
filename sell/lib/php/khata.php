<?php 

 header('Content-Type: text/html; charset=UTF-8');

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 
<title>خطا در چاپ</title>
<script type="text/javascript" src="../../jquery-1.2.3.pack.js"></script>
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
  
    <strong><center> خطا در چاپ </center></strong>
  <p ><strong><center>در این روز فروشی ندارید و یا اینکه سند قبلا ساخته شده است</center> </strong> </p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="color:#0000FF "><strong></strong></div>
<a href="/../sell/home.php?pg=home&cmd=wellcome_home.php">بازگشت به صفحه اول</a>
  

</body>
</html>