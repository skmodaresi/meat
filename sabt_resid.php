               <?php
   
				   include ("config.php");
				   $q1="SELECT * From resid r";
	               $allResid = mysql_query($q1);
                   while($row1=mysql_fetch_assoc($allResid))
	               {
	                $detailcount=$db->get_from_where("count(*)","resid_detail","shomare_resid=".$row1['shomare_resid']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	                $detailkalacount=$db->get_from_where("count(*)","resid_kala_detail","shomare_resid=".$row1['shomare_resid']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	                if(($detailcount!=0)AND($detailkalacount!=0))
					  mysql_query("UPDATE resid set sabt_nahayi=1 where code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND shomare_resid=".$row1['shomare_resid']."");

                   }
                   echo "change sabt resid field!";
                ?>