<?php
		$dblocation = "localhost";
		$dbname = "user221118_freelancers";
		$dbuser = "user221118_read";
		$dbpasswd = "55Oneone55";		
		
		$lnk_db = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
		if (!$lnk_db)
		{
			 /*
			 ��� ������� ��� ���� �����...*/
			 return array(0, "��� ���������� � MySQL. errno: ".mysqli_connect_errno( ).". error: ".mysqli_connect_error( ));
		}
		mysqli_query($lnk_db, 'SET NAMES utf8');
?>