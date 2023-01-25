<?php ob_start("ob_gzhandler", 6);

include "../php_bibl/peremennie.php";
include $php_bibl."bibl.php";
$lang=get_lang();

$data='';

if (!empty($_GET['data']))
{
	$data=$_GET['data'];
}

?> 
<!DOCTYPE html>
	
<html>
  <head>
  </head>
  <body>
    <div id="app">
	  <div style='max-width:400px;width:100%;'>
	      <chartjs-pie :labels="labels" :data="dataset" :bind="true"></chartjs-pie>
	  </div>    
    </div>
    <script src='vue.min.js'></script>
	<script src='vue-chartjs.full.min.js'></script>
    <script src='vue-charts.min.js'></script>
    <script>

      Vue.use(VueCharts);
      var app = new Vue({
        el: '#app',
        data: function data() {
          return {
            dataentry: null,
            datalabel: null,
            labels: [<?php print implode(',',$chart_labels);?>],
            dataset: [<?php print $data;?>]
          };
        },

        methods: {
          addData: function addData() {
            this.dataset.push(this.dataentry);
            this.labels.push(this.datalabel);
            this.datalabel = '';
            this.dataentry = '';
          }
        }
      });
    </script>
  </body>
</html>