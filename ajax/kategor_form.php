<?php
include "../php_bibl/peremennie.php";
include "../php_bibl/bibl.php";
/*include "../php_bibl/db_connect_read.php";*/

$wh='';
if (!empty($_GET['val']))
{
	$wh="where name_ru like '%".$_GET['val']."%'";
}

$sql="SELECT id,name_ru from tags ".$wh;
//print $sql;
$res="";
sql_zapros1('db_connect_read',$sql,$rows,$result);
//print_r($rows);
if (!empty($rows['id']))
	do
	{
		$res.="<div class='name_cat' onclick=\"ge('find_cat').value='".$rows['name_ru']."';ge('podskazki').style.display='none'\">".$rows['name_ru']."</div>";
	}
while ($rows= mysqli_fetch_array($result,MYSQLI_ASSOC));


if ($res=='')
{
	$res="<h2>Нет результатов</h2>";
}

/*print_r($_SERVER); Сделать проверку на внешние формы...*/
print "1||---||".$res;
exit();

?>