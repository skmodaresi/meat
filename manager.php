               <?php
require_once __DIR__ . '/mysql_compat.php';
				   include ("config.php");
				   $q1="SELECT * From mt_typesign";
	               $all = mysql_query($q1);
                   while($row1=mysql_fetch_assoc($all))
	               {
					$mg=$db->get_from_where("manager","mt_dpt","dpt_id=".$row1['dpt_id']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
					mysql_query("UPDATE mt_typesign set manager='$mg' where code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND sign_id=".$row1['sign_id']."");
                   }
                   echo "change manage!";
                
				?>