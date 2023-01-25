<?php
		$dblocation = "localhost";
		$dbname = "asdfsdf";
		$dbuser = "sdfsdf";
		$dbpasswd = "sdfsdf";		
		
		$lnk_db = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
		if (!$lnk_db)
		{
			 /*
			 Äëÿ îòëàäêè èëè áàçà ëåãëà...*/
			 return array(0, "Íåò ñîåäèíåíèå ñ MySQL. errno: ".mysqli_connect_errno( ).". error: ".mysqli_connect_error( ));
		}
		mysqli_query($lnk_db, 'SET NAMES utf8');
?>
