<?php
echo'
<script type="text/javascript">
function OpenWindowDialog(url, w, h)
{
	 var features = "resizable:no;status:yes;dialogwidth:" + w + "px;dialogheight:" + h + "px;help:no";
     features = features + ";dialogtop:" + (window.screen.availHeight - w) /2;
	 features = features + ";dialogleft:" + (window.screen.availWidth - h) /2;	 
	 window.showModalDialog(url, this, features);	 
}
</script>
<img border="0" src="images/help.png" onClick="OpenWindowDialog(\'help_nerkh.php?code_kala_=\'+document.myform.code_kala.value+\'\',500,400)" title="جدول قیمت" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';
?>