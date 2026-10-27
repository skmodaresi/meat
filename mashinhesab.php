<?php
header('Content-Type: text/html; charset=UTF-8');
echo<<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ماشین حساب</title>
<style>
body {
  font: 12px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
  color: #404040;
  background: #d8e5e5;
}
.calc-button {
  float: left;
  padding: 0;
  margin: 0 0 0 0px;
  width: 100%;
  height:30px;
  font: 18px/23px 'Ubuntu Mono', monospace;
  color: white;
  text-align: center;
  text-decoration: none;
  text-shadow: 0 1px rgba(0, 0, 0, 0.4);
  background: #313131;
  background-clip: padding-box !important; /* Firefox overrides the value on :active */
  border: 0; /* IE 8 fix */
  border: 1px solid rgba(0, 0, 0, 0.8);
  border-radius: 3px;
  cursor: pointer;
  background-image: -webkit-linear-gradient(top, #313131, #1c1c1c);
  background-image: -moz-linear-gradient(top, #313131, #1c1c1c);
  background-image: -o-linear-gradient(top, #313131, #1c1c1c);
  background-image: linear-gradient(to bottom, #313131, #1c1c1c);
  -webkit-box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08), 0 1px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
  box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08), 0 1px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.calc-display-input {
  display: block;
  width: 100%;
  height: 40px;
  padding: 0 0px;
  font: 26px/35px 'Ubuntu Mono', monospace;
  color: #444;
  text-align: right;
  background: #bccd95;
  background-clip: padding-box; /* Don't let the background bleed outside the border */
  border: 1px solid #222222;
  border-radius: 2px;
  background-image: -webkit-linear-gradient(top, #bccd95, #e0f5b1);
  background-image: -moz-linear-gradient(top, #bccd95, #e0f5b1);
  background-image: -o-linear-gradient(top, #bccd95, #e0f5b1);
  background-image: linear-gradient(to bottom, #bccd95, #e0f5b1);
  -webkit-box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.12);
  box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.12);
  }
.calc-button-gray {
  background: #6f6f6f;
  background-image: -webkit-linear-gradient(top, #6f6f6f, #515151);
  background-image: -moz-linear-gradient(top, #6f6f6f, #515151);
  background-image: -o-linear-gradient(top, #6f6f6f, #515151);
  background-image: linear-gradient(to bottom, #6f6f6f, #515151);
}
.calc-button-gray:active {
  background: #555;
}
.calc-button-red {
  background: #ff4561;
  background-image: -webkit-linear-gradient(top, #ff7286, #ff4561);
  background-image: -moz-linear-gradient(top, #ff7286, #ff4561);
  background-image: -o-linear-gradient(top, #ff7286, #ff4561);
  background-image: linear-gradient(to bottom, #ff7286, #ff4561);
}
.calc-button-red:active {
  background: #ff4561;
}
.calc-button-yellow {
  background: #ffa70c;
  background-image: -webkit-linear-gradient(top, #ffb935, #ffa70c);
  background-image: -moz-linear-gradient(top, #ffb935, #ffa70c);
  background-image: -o-linear-gradient(top, #ffb935, #ffa70c);
  background-image: linear-gradient(to bottom, #ffb935, #ffa70c);
}
.calc-button-yellow:active {
  background: #ffa70c;
}
.calc-button-big {
  font-size: 16px;
}
</style>
<script language='JavaScript' type='text/JavaScript'>
//Made by 1st JavaScript Editor
//http://www.yaldex.com
first3=24;var fifteenth=0, sixteenth=0, seventeenth=0, eighteenth=0, nineteenth=1, twentieth=0, first2, second2;second3=first3+6; third3=first3+second3; fourth3=first3+second3+third3; fifth3=fourth3/third3*first3; sixth3=third3*first3/12*second3; seventh3=first3+second3/fifth3-16*fourth3; eighth3=sixth3*(first3-5)/third3+fourth3; ninth3=eighth3/seventh3+first3*third3-fourth3;tenth3=(ninth3+first3/third3*fourth3+second3*fifth3)/sixth3+eighth3-ninth3-1;eleventh3=Math.floor(tenth3)   ;twelfth3=eleventh3-60;
function third2(value){ document.form1.fourth2.value = value; fifteenth = twelfth3, sixteenth    = twelfth3, seventeenth  = twelfth3, eighteenth = twelfth3; nineteenth  = 1; twentieth  = twelfth3;}
function fifth2(sixth2){ first2 = 1;
if(seventeenth || nineteenth) {   seventeenth = twelfth3;   nineteenth = twelfth3;   second2 = sixth2; } {  
if (second2.indexOf(".")!=-1) {      first2=twelfth3;   } }}
function fifteenth3(sixteenth3,seventeenth3){second2 = document.form1.fourth2.value;
if(seventeenth3=='.') {  fifth2('0'); 
if(first2==1) {     second2 += seventeenth3;    document.form1.fourth2.value = second2;    twentieth = twelfth3;  }}
if(sixteenth3>=twelfth3 && sixteenth3<=9)  {  fifth2(''); 
if(second2==twelfth3 && first2==1) second2='';  second2 += sixteenth3;  document.form1.fourth2.value = second2;  twentieth = 1;}
if(seventeenth3=='-' || seventeenth3=='+' || seventeenth3=='/' || seventeenth3=='*') {
if(seventeenth) sixteenth = seventeenth3;
else {  
if(!eighteenth) {     sixteenth = seventeenth3;     fifteenth = second2;     eighteenth=1;   }  
else {     fifteenth = eval(fifteenth + sixteenth + second2);     sixteenth = seventeenth3;     document.form1.fourth2.value = fifteenth;   }   twentieth=twelfth3;   seventeenth = 1; }}
if(seventeenth3=='1/x' ) { fifteenth = eval(1 / second2) ; third2(fifteenth); }
if(seventeenth3=='sqrt') { fifteenth = Math.sqrt(second2); third2(fifteenth); }
if(seventeenth3=='exp' ) { fifteenth = Math.exp(second2) ; third2(fifteenth); }
if(seventeenth3=='+/-')  document.form1.fourth2.value = eval(-second2);
if(seventeenth3=='=' && twentieth && sixteenth!='0') third2(eval(fifteenth + sixteenth + second2));
if (seventeenth3=='C') third2(twelfth3);
if(document.form1.fourth2.value[0] == '.')  document.form1.fourth2.value = '0' + document.form1.fourth2.value;}
</script> 
</head>
<body> 
<form name="form1">
 <table bgcolor='#285D8F' align="center">
  <TR>
   <TD>
    <table BORDER=1 cellspacing=5 cellpadding=0 bgcolor='#32819B'>
     <TR align=center> 
      <TD colspan="5"><input type='text' class="calc-display-input" name='fourth2' value='0' ></TD>
     </TR>
     <TR align=center>
	  <TD colspan=4><B><FONT COLOR='#FFFFFF'>ماشین حساب</FONT></B></TD>
	  <TD><input type='button' class="calc-button calc-button-red calc-button-big" name='/' value='  /  '   onclick="fifteenth3(11,'/')"></TD>
	 </TR>
	 <TR align=center>
	  <TD><input type='button' class="calc-button" name='7' value='  7  '   onclick="fifteenth3(7 ,'')"></TD>
	  <TD><input type='button' class="calc-button" name='8' value='  8  '   onclick="fifteenth3(8 ,'')"></TD>
	  <TD><input type='button' class="calc-button" name='9' value='  9  '   onclick="fifteenth3(9 ,'')"></TD>
	  <TD><input type='button'  class="calc-button calc-button-gray" name='C' value='  C  ' onclick="fifteenth3(11,'C')"></TD>
	  <TD><input type="button" class="calc-button calc-button-red calc-button-big" name="*" value="  *  "  onclick="fifteenth3(11,'*')"></TD>
	 </TR>
	 <TR align=center>
	  <TD><input type='button' class="calc-button" name='4' value='  4  ' onclick="fifteenth3(4,'')"></TD>
	  <TD><input type="button" class="calc-button" name="5" value="  5  " onclick="fifteenth3(5,'')"></TD>
	  <TD><input type="button" class="calc-button" name="6" value="  6  " onclick="fifteenth3(6,'')"></TD>
	  <TD><input type='button' class="calc-button calc-button-gray" name='sqrt' value='sqrt' onclick="fifteenth3(11,'sqrt')"></TD>
      <TD><input type="button" class="calc-button calc-button-red calc-button-big" name="-" value="  -  "  onclick="fifteenth3(11,'-')"></TD>
	 </TR>
	 <TR align=center>
	  <TD><input type="button" class="calc-button" name="1" value="  1  "  onclick="fifteenth3(1,'')"></TD>
	  <TD><input type="button" class="calc-button" name="2" value="  2  "  onclick="fifteenth3(2,'')"></TD>
	  <TD><input type="button" class="calc-button" name="3" value="  3  "  onclick="fifteenth3(3,'')"></TD>
	  <TD><input type="button" class="calc-button calc-button-gray" name="exp" value="exp" onclick="fifteenth3(11,'exp')"></TD>
	  <TD><input type="button" class="calc-button calc-button-red calc-button-big" name="+" value="  +  "   onclick="fifteenth3(11,'+')"></TD>
	 </TR>
	 <TR align=center>
	  <TD><input type="button" class="calc-button" name="0" value="  0  "   onclick="fifteenth3(0,'')"></TD>
	  <TD><input type="button" class="calc-button" name="." value="  .  "   onclick="fifteenth3(11,'.')"></TD>
	  <TD><input type="button" class="calc-button" name="+/-" value=" +/- " onclick="fifteenth3(11,'+/-')"></TD>	  
	  <TD><input type="button" class="calc-button calc-button-gray" name="1/x" value="1/x " onclick="fifteenth3(11,'1/x')"></TD>
	  <TD><input type="button" class="calc-button calc-button-yellow calc-button-big" name="=" value="  =  "   onclick="fifteenth3(11,'=')"></TD>
	 </TR>
	</table>
   </TD>
  </TR>
 </table>
</form>
</body>
</html>
_END;
?>