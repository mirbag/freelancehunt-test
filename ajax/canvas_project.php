<?php
include "../php_bibl/peremennie.php";
include "../php_bibl/bibl.php";
/*include "../php_bibl/db_connect_read.php";*/

$wh='';
$res="";

if (!empty($_POST['filtr']))
{
	/*$wh="where name_ru like '%".$_GET['val']."%'";*/
	$id_tags='0,0';
	$filtrs=$_POST['filtr'];
	$filtrs_arr = explode("|", $filtrs);
	foreach($filtrs_arr as $key => $filtr)
	if  ($filtr!='')
	{
		$sql="SELECT id from tags where name_ru='".$filtr."'";
		sql_zapros1('db_connect_read',$sql,$rows); // - Точное совпадение фильтра
		if (!empty($rows['id']))
			$id_tags.=",".$rows['id'];
		else
			{
				// Значит єто что-то свое пользователя
				$sql="SELECT id from tags where name_ru like '%".$filtr."%'";
				sql_zapros1('db_connect_read',$sql,$rows,$result); // - Точное совпадение фильтра
				if (!empty($rows['id']))
					do
					{
						$id_tags.=",".$rows['id'];
					}
				while ($rows= mysqli_fetch_array($result,MYSQLI_ASSOC));
			}
	}
	$wh=" where id in(SELECT id_project from projects_tags where id_tags in (".$id_tags."))";
}



$res1=form_all_projects($wh);

/*print_r($_SERVER); Сделать проверку на внешние ресурсы....HTTP_REFERER*/
print "1||---||".$res1[0]."||---||Всего найдено проектов: ".$res1[1]."||---||".$res1[2];
exit();




?>	