<?php 
namespace System\HtmlComponents\Charts;

class Doughnut
{
	public static function start($canvasId, Array $data, Array $labels, Array $colors = [])
	{
		echo '<script type="text/javascript">';
		echo 'var ctx = document.getElementById("'.$canvasId.'").getContext("2d");';
		echo 'var myChart = new Chart(ctx, {';
		    echo 'type: "doughnut",';
		        echo 'data: {';
		            echo 'labels: [';
		                if (count($labels) > 0) {
			                foreach ($labels as $label) {
			                	echo "'{$label}'".',';
			                }
			            } else {
			            	echo "'Nenhum dado'";
			            }
		            echo '],';
		            echo 'datasets: [{';
		              echo 'backgroundColor: [';
		                if (count($labels) > 0) {
			                foreach ($colors as $color) {
			                	echo "'{$color}'".',';
			                }
			            } else {
			            	echo "'#f4f3ef'";
			            }
		              echo '],';
		              echo 'data: [';
		                if (count($data) > 0) {
			                foreach ($data as $value) {
			                	echo "'{$value}'".',';
			                }
			            } else {
			            	echo '100';
			            }
		              echo ']';
		            echo '}]';
		        echo '}';
		    echo '});';
		echo '</script>';
	}
}