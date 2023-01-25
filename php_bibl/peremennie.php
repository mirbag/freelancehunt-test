<?php
	if ($_SERVER['HTTP_HOST']=='localhost')
		{
			$dop_site='hitec.zone/freelancehunt-test';
			$full_site='http://localhost/hitec.zone/freelancehunt-test';
		}
	else
	{
		$dop_site='/freelancehunt-test';
		$full_site='http://hitec.zone/freelancehunt-test';
	}


$php_bibl=$_SERVER['SCRIPT_FILENAME'];
$php_bibl=strstr($php_bibl, $dop_site.'/', true).$dop_site.'/php_bibl/';
$def_lang='ru';

$lang_vis=array('ru' => "РУ", 'en' => 'EN');
$langs=array('ru','en');
$allowed_querys=array('db_connect_read' => array('SELECT'), 'db_connect_insert' => array('SELECT','INSERT','DELETE'));
$def_read_access='db_connect_read';
$token="875ce23f7a4360d8e74dc234d0c0c064cbb2f1a7";

$chart_val_ot=array(0,  500, 1000,5000);
$chart_val_do=array(500,1000,5000, 0);
$chart_labels=array("'До 500'","'От 500 до 1000'", "'от 1000 до 5000'", "'Более 5000'");



ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
?>