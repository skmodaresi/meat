function iconfirm(params,mess__)
 { if (!mess__) mess__="";
   var yn = window.confirm(mess__+" مطمئن هستيد؟ ");
   if (yn)
    window.location=params;
   else
    return flase;
 }
 function isNumber(evt)
{  evt = (evt) ? evt : window.event;
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   // if ((charCode > 48 || charCode < 57) && (charCode>36 || charCode<41) ) {return true;}
   // return false;
    //if (charCode > 31 &&  charCode==8 && (charCode < 48 || charCode > 57)) {return false;}
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {return false;}
    return true; 
}
$( document ).ready(function() {	
    $("#datepickerfrom").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker({ 

		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
	  });
	  $(window).scroll(function(){
        if ($(this).scrollTop() < 100) {
			$(".elevator-button") .fadeOut(500);
        } else {
			$(".elevator-button") .fadeIn(500);
        }
       });
	   var elevator = new Elevator({
		     element: document.querySelector(".elevator-button"),
		     duration: 2000
	   });
}); 
// $("#username").keypress(function(e) {
	// var k = e.keyCode || e.charCode;
	// var c = e.charCode;
	// var isArrow = (c == 0 && k >= 37 && k <= 40);
	// var isSpecial = ((k == 8) || (k == 9) || (k == 127)) || isArrow;	// backspace, tab, delete
	// var isOK = (k >= 48 && k <= 57) || (k >= 65 && k <= 90) || (k >= 97 && k <= 122);  // letters and numbers
	// return isOK || isSpecial;
// });

function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}

function enter(){ 
  if(event.keyCode==13){
       event.keyCode=9;
       return event.keyCode;}
}
function enterIE(){ 
if(window.event.keyCode == 13 && window.event.srcElement.id !='Insert_x')
 {window.event.keyCode = 9;
 return event.keyCode;
}
}
function enter3(e)
{ 
  if(window.event) // IE
  {
  keynum = e.keyCode;
  	if (keynum==13){
  		window.event.keyCode = 9;
  	}
  }
  else if(e.which) // Netscape/Firefox/Opera
  {
  keynum = e.which;
  	if (keynum==13){
  		e.which.keyCode = 9;
  	}
  }
}
function enter2(evt)
{  evt = window.Event ? evt.which : evt.KeyCode;
   var charCode = (evt.which) ? evt.which : evt.KeyCode;
   if (charCode ==13) {charCode=9; return charCode;}
}
// function checkKey(e){
    // if(e.keyCode == 13 ){ // if enter key
        // var e = jQuery.Event('keydown'); // create a manual event
        // e.which = e.charCode = 0;
        // e.keyCode = 9; // set the new event to "tab"
        // $(this.target).trigger(e); // trigger the new event (on the document)
        // return false;  // cancels the original "enter" event from executing
    // }
// }

//باز شدن جدول کد کالا
 function F10desc(evt)
{ 
 evt = (evt) ? evt:window.event;
 var charCode = (evt.which) ? evt.which : evt.keyCode;
 if (charCode==121)
 {window.open("help_kala.php","_blank","width=400px,left=20px"); return true;}
  return false;
}
 // function F10desc(aaa)
// { var keycode;
  // if (window.event) keycode = window.event.keyCode;
  // if (keycode==121)
  // window.open("help_kala.php","_blank","width=400px"); 
  // return false;
// }

// function is_int(event)
// {
  // var Key = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
  // if(Key==13 || (Key >= 48 && Key <=57)) return true;
  // else return false;
// }
function NumKeyPress(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if (event.keyCode < 48 || event.keyCode > 57) 
			event.returnValue = false;
	}
	else{
		if(evn.which < 48 || evn.which > 57) 
			return false;
	}
	
	input.value=Comma(filterNum(input.value),0);
}
function NumKeyPress_noComma(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if (event.keyCode < 48 || event.keyCode > 57) 
			event.returnValue = false;
	}
	else{
		if(event.charCode< 48 || event.charCode > 57) 
			return false;
	}
     // var code = e.charCode || e.keyCode;	
	//input.value=Comma(filterNum(input.value),0);
}
function numonly(field,high_)
{var val;
 if (isNaN(high_)) high_=0;
 if ( event.keyCode>"57" || event.keyCode<"48" )  return false;
 val =field.value+(event.keyCode-48);
 val=val.replace("/,/gi","");
 if (isNaN(val))  val=0;
 if (high_>0) {if (val>high_) {field.focus();return false;}}
}
function numSonly(field)
{if( (event.keyCode>"57" || event.keyCode<"48") && (event.keyCode!="42") )
 return false;
}
// function numSonly(field)
// {if( (event.keyCode>"57" || event.keyCode<"48") && (event.keyCode!="42") && (event.keyCode < "96" || event.keyCode > "105") )
 // return false;
// }

// function isNumberKey(evt)
// {
    // var charCode = (evt.which) ? evt.which : event.keyCode
    // if (charCode > 31 && (charCode < 48 || charCode > 57))
        // return false;
    // return true;
// }
function NumKeyUp(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if ((event.keyCode != 37) && (event.keyCode != 38) && (event.keyCode != 39) && (event.keyCode != 40))	
			input.value=Comma(filterNum(input.value),1);
	    else input.focus();
	}
	else{
		if((evn.which != 37) && (evn.which != 38) && (evn.which != 39) && (evn.which != 40)) 
			input.value=Comma(filterNum(input.value),1);
		else input.focus();
	}
}
function filterNum(str) {
	re = /,/g;
	// remove ","
	return str.replace(re, "");
}
function Comma(myVal,oneFlag) {
	var T='',S=String(myVal),L=S.length-oneFlag, j;
	for (var j=0; j<=L; j++) {
		T+=S.charAt(j);
		if ((j < L) && ((L-j)%3 == 0)) 
			T+=','; 
	}
	return T;
}

function longdateonly(field)
{ var month;
  var day;
  window.status=" ";
  if(event.keyCode<="57" && event.keyCode>="48" )
  {
   str=field.value.length;
   switch(str)
   {

     case 4 :
       field.value=field.value+"/";
       day=field.value.substr(0,4);
       break;
     case 6 :
       month =field.value.substr(5,1)+(event.keyCode-48);
       if ((month > "12") || (month <= "00"))
       { window.status=" عدد "+month+" براي ماه اشتباه است ";
         field.value=field.value.substr(0,6);
         field.focus();
         return false;
       }
       break;
     case 7 :
       field.value=field.value+"/";
       break;
     case 9 :
       month =field.value.substr(5,1)+(event.keyCode-48);
       day =field.value.substr(8,1)+(event.keyCode-48);
       if (month<="06" && day > "31")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,10);
         field.focus();
         return false;
       }
       if (month>="07" && day > "30")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,10);
         field.focus();
         return false;
       }
       break;
   }
   return true;
  }
  else
  {field.focus();
   window.status=" ";
   return false;
  }
}
function dateonly(field,lower_bond,upper_bond)
{  
 var month;
  var day;
  window.status=" ";
  if (!field) return true;
  if(event.keyCode<="57" && event.keyCode>="48" )
  {
   str=field.value.length;
   switch(str)
   {
     case 2 :
       field.value=field.value+"/";
       day=field.value.substr(0,2);
       break;
     case 4 :
       month =field.value.substr(3,1)+(event.keyCode-48);
       if ((month > "12") || (month < "00"))
       { window.status=" عدد "+month+" براي ماه اشتباه است ";
         field.value=field.value.substr(0,4);
         field.focus();
         return false;
       }
       break;
     case 5 :
       field.value=field.value+"/";
       break;
     case 7 :
       month =field.value.substr(3,2);
       day =field.value.substr(6,1)+(event.keyCode-48);
       if (month<="06" && day > "31")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,8);
         field.focus();
         return false;
       }
       if (month>="07" && day > "30")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,8);
         field.focus();
         return false;
       }
       //if (lower_bond)
       //{ var ss=field.value.replace(///g,' ');
       //  if (ss<upper_bond)
       //  {alert('تاريخ سند در محدده سال جاري نيست');
       //   field.value="";
       //   field.focus();
       //   return false;
       //  }
       //}
       //if (upper_bond)
       //{ var ss=field.value.replace(///g,' ');
       //  if (ss>upper_bond)
       //  {alert('تاريخ سند در محدده سال جاري نيست');
       //   field.value="";
       //   field.focus();
       //   return false;
       //  }
       //}
       break;
   }
   return true;
  }
  else
  {field.focus();
   window.status=" ";
   return false;
  }
}
function dateonlyme(field,lower_bond,upper_bond,evt)
{ 
 evt = (evt) ? evt : window.event;
 var charCode = (evt.which) ? evt.which : evt.keyCode; 
 var month;
  var day;
  window.status=" ";
  if (!field) return true;
  if(charCode<="57" && charCode>="48" )
  {
   str=field.value.length;
   switch(str)
   {
     case 2 :
       field.value=field.value+"/";
       day=field.value.substr(0,2);
       break;
     case 4 :
       month =field.value.substr(3,1)+(charCode-48);
       if ((month > "12") || (month < "00"))
       { window.status=" عدد "+month+" براي ماه اشتباه است ";
         field.value=field.value.substr(0,4);
         field.focus();
         return false;
       }
       break;
     case 5 :
       field.value=field.value+"/";
       break;
     case 7 :
       month =field.value.substr(3,2);
       day =field.value.substr(6,1)+(charCode-48);
       if (month<="06" && day > "31")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,8);
         field.focus();
         return false;
       }
       if (month>="07" && day > "30")
       { window.status=" عدد "+day+" براي روز اشتباه است ";
         field.value=field.value.substr(0,8);
         field.focus();
         return false;
       }
       //if (lower_bond)
       //{ var ss=field.value.replace(///g,' ');
       //  if (ss<upper_bond)
       //  {alert('تاريخ سند در محدده سال جاري نيست');
       //   field.value="";
       //   field.focus();
       //   return false;
       //  }
       //}
       //if (upper_bond)
       //{ var ss=field.value.replace(///g,' ');
       //  if (ss>upper_bond)
       //  {alert('تاريخ سند در محدده سال جاري نيست');
       //   field.value="";
       //   field.focus();
       //   return false;
       //  }
       //}
       break;
   }
   return true;
  }
  else
  {field.focus();
   window.status=" ";
   return false;
  }
}

function PressfloatOnly(evt,thisobj)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var textboxValue = thisobj.value + ""; 
    if (charCode == 190 || charCode == 110) {
        var contains = textboxValue.indexOf(".") != -1;
        if (contains)
            return false;
    }
    var temp = parseFloat(textboxValue);
    temp = temp.toFixed(3);
    var noofdecimal = 3; // it decides how many number to be printed after decimal point.
    var temp1 = textboxValue.split('.');
    if (temp1.length == 2) {
        if (temp1[1].length >= noofdecimal)// it determines that after decimal user has entered values
            if ( charCode==37 || charCode==39 || charCode==46 || charCode == 35 || charCode == 36 || charCode == 8 || charCode == 9 )
                 return true;
           else 
            return false;
    }
    if (charCode == 37 || charCode == 39) return true;  // allow arrows
    if (charCode == 46) return true; //delete
    if (charCode == 190 || charCode == 110) return true; // period or dot
    if (charCode == 35 || charCode == 36) return true; // home, end
    if (charCode == 8 || charCode == 9) return true; // backspace , tab
    if (charCode > 47 && charCode < 58) return true; //0-9  // special character keys
    if (charCode > 95 && charCode < 106) return true; //0-9 // number keys
    return false;
}
function filterNum(str) {
	re = /,/g;
	// remove ","
	return str.replace(re, "");
}
function NumKeyPress(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if (event.keyCode < 48 || event.keyCode > 57) 
			event.returnValue = false;
	}
	else{
		if(evn.which < 48 || evn.which > 57) 
			returnfalse;
	}	
	input.value=Comma(filterNum(input.value),0);
}
function NumKeyUp(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if ((event.keyCode != 37) && (event.keyCode != 38) && (event.keyCode != 39) && (event.keyCode != 40))	
			input.value=Comma(filterNum(input.value),1);
	    else input.focus();
	}
	else{
		if((evn.which != 37) && (evn.which != 38) && (evn.which != 39) && (evn.which != 40)) 
			input.value=Comma(filterNum(input.value),1);
		else input.focus();
	}
}