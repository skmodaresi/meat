<?php
echo'
<html>
<head>
</head>
<body onload=document.myform.name.focus();>
<form name="myform">
<input type="text" name="name" id="name"/>
<input type="text" name="email" id="email"/>
<input type="text" name="message"/>
<input type="button" name="insert" value="insert" onclick="window.location ="test2.html?name=" +name + "&email=" + email + "&message=" + message;"/>
<input type="button" name="insert2" value="insert2" onclick="window.location.href = \'test2.php?name=\' + document.getElementById(\'name\').value+\'&email=\'+document.getElementById(\'email\').value;"/>
</form>
</body>
</html>';
echo<<<_END
<input type="button" name="insert3" value="insert3" onclick="window.location.href = 'test2.php?name=' + document.getElementById('name').value;"/>
<input type="button" name="insert3" value="insert5" onclick="window.location.href = 'test2.php?name=' + document.myform.name.value+&email="/>
<input type="button" name="insert4" value="insert4" onclick="window.location.href = 'test2.php?name&email=' + document.getElementById('name').value+document.getElementById('email').value;"/>
_END;
?>
