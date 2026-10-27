
	<CENTER>
<FORM name="Keypad" action="">
<TABLE>

<TABLE border=0 width=50 height=60 cellspacing=5 style="border: 1px solid #CC3300">
<TR>
<TD colspan=3 align=middle>
<input name="ReadOut" type="Text" size=24 value="0" width=100%>
</TD>
<TD>
</TD>
<TD style="border: 1px solid #CCCCFF" align="center">
<input name="btnClear" type="button" value="  C  " onclick="Clear()" style="width: 40">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center">
<input name="btnClearEntry" type="button" value="  CE " onclick="ClearEntry()" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnSeven" type="Button" value="  7  " onclick="NumPressed(7)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnEight" type="Button" value="  8  " onclick="NumPressed(8)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnNine" type="Button" value="  9  " onclick="NumPressed(9)">
</TD>
<TD height="30">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center" height="30">
<input name="btnNeg" type="button" value=" +/- " onclick="Neg()" style="width: 40">
</TD>
<TD style="border: 1px solid #CCCCFF" align="center" height="30">
<input name="btnPercent" type="button" value="  % " onclick="Percent()" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnFour" type="Button" value="  4  " onclick="NumPressed(4)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnFive" type="Button" value="  5  " onclick="NumPressed(5)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnSix" type="Button" value="  6  " onclick="NumPressed(6)">
</TD>
<TD height="30">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnPlus" type="button" value="  +  " onclick="Operation('+')" style="width: 40">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnMinus" type="button" value="   -   " onclick="Operation('-')" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnOne" type="Button" value="  1  " onclick="NumPressed(1)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnTwo" type="Button" value="  2  " onclick="NumPressed(2)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnThree" type="Button" value="  3  " onclick="NumPressed(3)">
</TD>
<TD height="30">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnMultiply" type="button" value="  ×  " onclick="Operation('*')" style="width: 40">
</TD>
<TD align=middle style="border: 1px solid #CCCCFF" height="30">
<input name="btnDivide" type="button" value="   /   " onclick="Operation('/')" style="width: 40">
</TD>
</TR>
<TR>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnZero" type="Button" value="  0  " onclick="NumPressed(0)">
</TD>
<TD style="border: 1px solid #FFCC66" align="center" height="30">
<input name="btnDecimal" type="Button" value="   .  " onclick="Decimal()">
</TD>
<TD colspan=4 height="30">
<B>
<p align="right">
<input name="btnEquals" type="button" value="  =  " onclick="Operation('=')" style="width: 90">
</B>
</TD>
</TR>
</TABLE>
</TABLE>
</B>
</FORM>
</CENTER>
<font face="Verdana, Arial, Helvetica" size=2>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
var FKeyPad = document.Keypad;
var Accumulate = 0;
var FlagNewNum = false;
var PendingOp = "";
function NumPressed (Num) {
if (FlagNewNum) {
FKeyPad.ReadOut.value  = Num;
FlagNewNum = false;
   }
else {
if (FKeyPad.ReadOut.value == "0")
FKeyPad.ReadOut.value = Num;
else
FKeyPad.ReadOut.value += Num;
   }
}
function Operation (Op) {
var Readout = FKeyPad.ReadOut.value;
if (FlagNewNum && PendingOp != "=");
else
{
FlagNewNum = true;
if ( '+' == PendingOp )
Accumulate += parseFloat(Readout);
else if ( '-' == PendingOp )
Accumulate -= parseFloat(Readout);
else if ( '/' == PendingOp )
Accumulate /= parseFloat(Readout);
else if ( '*' == PendingOp )
Accumulate *= parseFloat(Readout);
else
Accumulate = parseFloat(Readout);
FKeyPad.ReadOut.value = Accumulate;
PendingOp = Op;
   }
}
function Decimal () {
var curReadOut = FKeyPad.ReadOut.value;
if (FlagNewNum) {
curReadOut = "0.";
FlagNewNum = false;
   }
else
{
if (curReadOut.indexOf(".") == -1)
curReadOut += ".";
   }
FKeyPad.ReadOut.value = curReadOut;
}
function ClearEntry () {
FKeyPad.ReadOut.value = "0";
FlagNewNum = true;
}
function Clear () {
Accumulate = 0;
PendingOp = "";
ClearEntry();
}
function Neg () {
FKeyPad.ReadOut.value = parseFloat(FKeyPad.ReadOut.value) * -1;
}
function Percent () {
FKeyPad.ReadOut.value = (parseFloat(FKeyPad.ReadOut.value) / 100) * parseFloat(Accumulate);
}
// End -->
</SCRIPT>

<!-- End Code  -->
	<?php 