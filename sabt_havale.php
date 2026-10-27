               <?php
   
				   include ("config.php");
				   $q1="SELECT * From havale h";
	               $allHavale = mysql_query($q1);
                   while($row1=mysql_fetch_assoc($allHavale))
	               {
	                $detailcount=$db->get_from_where("count(*)","havale_detail","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	                if($detailcount!=0)
					  mysql_query("UPDATE havale set sabt_nahayi=1 where code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND shomare_havale_anbar=".$row1['shomare_havale_anbar']."");

                   }
                   echo "change sabt havale field!";
                ?>