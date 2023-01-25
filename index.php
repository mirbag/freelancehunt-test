<?php ob_start("ob_gzhandler", 6);
 
include "php_bibl/peremennie.php";
include $php_bibl."bibl.php";
$lang=get_lang();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head> 
	<?php
		header_page($lang);

	?>
    	<script src='//cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js'></script>
		<script src='//unpkg.com/vue-chartjs@2.6.0/dist/vue-chartjs.full.min.js'></script>
    	<script src='//unpkg.com/hchs-vue-charts@1.2.8'></script>	
</head>
	<body>
		
		
		
		
		<?php
			top_menu($lang);
			$chart='';
			main_tbl($lang,'',$chart);
		?>
	
	<div id="popup2" class="overlay">
	<div class="popup" style='display:flex;'>
		<a class="close" href="#">×</a>
		<iframe name="frame1" id="frame1" src="frame/chart.php?data=<?php print $chart?>" style="width:400px;border:0px;height:400px;margin:auto;position:relative;"></iframe>
	</div>
</div>
		
		
	</body>
</html>




<?php
	//mysqli_close($lnk_db);
?>