<?php
		$dblocation = "localhost";
<<<<<<< HEAD
		$dbname = "sdfsdf";
		$dbuser = "dfgsdgsdfg";
		$dbpasswd = "sdfgsdfgsdfg";		
=======
		$dbname = "dfgdsgdfg";
		$dbuser = "sdfgsdfg";
		$dbpasswd = "sdfgsdfgsdg";		
>>>>>>> d5103bb744ed0c2b3d860292c2767250e3984a75
		
		$lnk_db = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
		if (!$lnk_db)
		{
			 /*
<<<<<<< HEAD
			 Для отладки или база легла...*/
			 return array(0, "Нет соединение с MySQL. errno: ".mysqli_connect_errno( ).". error: ".mysqli_connect_error( ));
=======
			 Äëÿ îòëàäêè èëè áàçà ëåãëà...*/
			 return array(0, "Íåò ñîåäèíåíèå ñ MySQL. errno: ".mysqli_connect_errno( ).". error: ".mysqli_connect_error( ));
>>>>>>> d5103bb744ed0c2b3d860292c2767250e3984a75
		}
		mysqli_query($lnk_db, 'SET NAMES utf8');
?>
