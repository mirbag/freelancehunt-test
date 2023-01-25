<?php 
function formatting_post($post_get)
{
	if (is_string($post_get))
	{
		$post_get= str_replace("'","`",$post_get);
		$post_get= str_replace('"','&#34;',$post_get);
		$post_get= str_replace(' UNION ',' UNIОN ',$post_get);
		$post_get= str_replace(' SELECT ',' SELЕCT ',$post_get);
		$post_get= str_replace(' DELETE ',' DELЕTE ',$post_get);
		$post_get= str_replace(' INSERT ',' INSЕRT ',$post_get);
		$post_get= str_replace(' UPDATE ',' UPDATЕ ',$post_get);
		$post_get= str_replace(' FILE ',' FILЕ ',$post_get);
		// Делаем проверки без учета регистра...
	}
	return $post_get;
}


function protect_post_get()
{
	foreach($_POST as $key => $val) // Проходимся по POST и защищаем от иньекций
	{
		$_POST[$key]=formatting_post($_POST[$key]);
	}
	foreach($_GET as $key => $val)// Проходимся по GET и защищаем от иньекций
	{
		$_GET[$key]=formatting_post($_GET[$key]);
	}
}
protect_post_get();

function sql_zapros1($prava,$sql,&$rows='',&$result='')
{
	include $prava.'.php';
	include "peremennie.php";
	//$part_query=strtoupper(substr($sql, 0, 6));	// Еще проверка sql на разрешенные запросы...
	$part_query=(substr($sql, 0, 6));	// Еще проверка sql на разрешенные запросы...
	$allowed=false;
	foreach($allowed_querys[$prava] as $key => $val) // Проход по разрешенным запросам
	{
		if ($val==$part_query)
			{
				$allowed=true;
				break; // Запрос разрешен, продолжаем
			}
	}
	
	if (!$allowed)
	{
		return false; // Не разрешен запрос. Выходим.
		exit();
	}
	
	
	$result = mysqli_query($lnk_db, $sql);
	if ($part_query=='SELECT')
	{
		if (!empty($result))
			{
				$rows= mysqli_fetch_array($result,MYSQLI_ASSOC);
				if (!empty($rows))
					return true;
				else
					return false;
				
			}
		else
			{
				return false;
			}
	}
	else
		return true;
	
	mysqli_close($lnk_db);
}



function get_lang()
{
	include "peremennie.php";
	if (!Empty($_GET["lang"]))
	{
		$lang=$_GET["lang"];
		if ($lang=='ua') $lang='uk';
		if (!in_array($lang, $langs))
			$lang=$def_lang;
		if (empty($_COOKIE['lang']))
			{
				setcookie('lang', $lang, time() + (3600 * 24 * 30 * 12 * 10), "/");
			}
		else
			if ($_COOKIE['lang']!=$lang)
				setcookie('lang', $lang, time() + (3600 * 24 * 30 * 12 * 10), "/");
	}
	else
	{
		if (!empty($_COOKIE['lang']))
			$lang=$_COOKIE['lang'];
		else
			$lang=$def_lang;
		
		if ($lang=='ua') $lang='uk';
	}
	if (!in_array($lang, $langs))
		{
			if ($lang!='uk')
				$lang=$def_lang;
			else
				$lang!='ua';
		}
	return $lang;
}



function header_page($lang)
{
	include "peremennie.php";
	$title='';
	$gv=''; // Гугл верификация
	$description='';
	$keywords='';
	$page=$_SERVER['SCRIPT_NAME'];
	$sql="SELECT id,title_".$lang.",gv,description_".$lang.",keywords_".$lang." from heads where page='".$page."'";
	if (sql_zapros1($def_read_access,$sql,$rows,$result))
	{
		if (!empty($rows['id']))
		{
			$title=$rows["title_".$lang];
			$gv=$rows['gv'];
			$description=$rows["description_".$lang];
			$keywords=$rows["keywords_".$lang];;
		}
	}
	
	
print 	"
	<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>".$title."</title>
	<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' data='favicon.ico'>
	<link href='css/style.css' rel='stylesheet' type='text/css' data='css/style.css'>
	<link href='css/style_tel.css' rel='stylesheet' type='text/css' data='css/style_tel.css'>
	<script src='js/main.js' type='text/javascript' data='js/main.js'></script>
	";


if ($description!='')
	print "<meta name='description' content='".$description."'>
";
if ($keywords!='')
	print "	<meta name='keywords' content='".$keywords."'>
";
if ($gv!='')
	print "<meta name='google-site-verification' content='".$gv."'>
";
}


function top_menu($lang)
{
	print "
<div id='popup1' class='overlay'>
	<div class='popup'>
		<a class='close' href='#'>&times;</a>
		<div class='content' id='filtr_form'>
			<input value='' id='find_cat' placeholder='Введите категорию' onkeyup='show_kategor_form();' onmouseup='show_kategor_form(true);'>
			<div class='button' onclick='add_filtr()'>Добавить</div>
				<div class='podskazki' id='podskazki' style='display:none'>
					<img src='img/loading.gif' class='loading'>
				</div>
			
			<div id='vibrani_kategor'>
				
			</div>
				
			<div id='kol_proj'>
				
			</div>
		</div>
	</div>
</div>
";
}


function vivod_tbl($filtr)
{
	$wh="";
	if ($filtr!='')
		{
			$wh="select `id`, `id_freelancehunt`, `name`, `src`, `budget`, `budget_currency`, `fio_creator`, `login_creator` from projects where";
		}
}

function form_all_projects($wh)
{
	include "peremennie.php";
	$res_chart1=array(0,0,0,0);
	$sm_kol=0;
	$sql="SELECT `id`, `id_freelancehunt`, `name`, `src`, `budget`, `budget_currency`, `fio_creator`, `login_creator` from projects ".$wh;
	sql_zapros1('db_connect_read',$sql,$rows,$result);
	if (!empty($rows['id']))
		{
			$res="
					<table>
					    <thead>
					    <tr style='background:#FFF;'>
					      <th style='width:40%'>Название проекта</th>
					      <th style='width:30%'>Имя/логин заказчика</th>
					      <th style='width:30%'>Бюджет</th>
					    </tr>
					    </thead>
					    <tbody>
			";
			do
			{
				$sm_kol++;
				$login='';
				$budget='';
				if ($rows['login_creator']!='')
					$login=" (".$rows['login_creator'].")";
				
				if ($rows['budget']!='')
					{
						$budget=$rows['budget']." ".$rows['budget_currency'];
					}
				
				$arrLength = count($chart_labels);
				
				for($i = 0; $i < $arrLength; $i++) 
				{
					if (($chart_val_ot[$i]!=0) && ($chart_val_do[$i]!=0))
						{
							if (($rows['budget']>$chart_val_ot[$i]) && ($rows['budget']<=$chart_val_do[$i]))
								$res_chart1[$i]++;
						}
					else
						{
							if (($chart_val_ot[$i]==0) && ($rows['budget']<=$chart_val_do[$i]))
							
								$res_chart1[$i]++;
							
							if (($chart_val_do[$i]==0) && ($rows['budget']>$chart_val_ot[$i]))
								$res_chart1[$i]++;
						}
				}
				$res.="<tr>
					      <td data-label='Название проекта'><a href='".$rows['src']."'  target='_blank'>".$rows['name']."</a></td>
					      <td data-label='Имя/логин заказчика'>".$rows['fio_creator'].$login."</td>
					      <td data-label='Бюджет'>".$budget."</td>
					    </tr>
				";
			}
			while ($rows= mysqli_fetch_array($result,MYSQLI_ASSOC));
			
			$chart='';
			$chart=implode(',',$res_chart1);
			//print_r($res_chart1);
			
			$res.="
					 </tbody>
				</table>";
		}
	if ($res=='')
	{
		$res="<h2>Нет результатов</h2>";
	}
		return(array(0 => $res, 1 => $sm_kol, 2  => $chart));
}

function main_tbl($lang,$find='',&$chart='')
{
	$all_data=form_all_projects('');
	$chart=$all_data[2];
	print "
		
		<div class='cont_tbl'>
			<div class='box'>
				<a href='#popup1'>Выбрать категорию</a>
			</div>
			
			<a href='#popup2' style='float:right;margin-top:-15px;'>Показать график</a>
		</div>
		
		<div class='cont_tbl' id='main_tbl'>
			".$all_data[0]."
			</div>";

}



?>