<div class="norm">
	
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Network', 'Active Connections'],
			
			<?php $i = 0;
			$providers = $um_social_login->networks;
			foreach( $providers as $provider => $array ) {
				$count = $um_social_login->count_users($provider);
				$i = $i + $count; ?>
			
			['<?php echo $array['name']; ?>', <?php echo $count; ?>],
			
			<?php } ?>
			
		]);

        var options = {
			chartArea:{left:20,top:20,width:'90%',height:'90%'},
			pieSliceText: 'label',
			pieHole: 0.4,
			legend: {position: 'right', textStyle: {color: '#666', fontSize: 12}},
			tooltip: {textStyle: {color: '#666'}, showColorCode: true},
			colors:[<?php foreach( $providers as $provider => $array ) { ?>'<?php echo $array['bg']; ?>',<?php } ?>]
        };

        var chart = new google.visualization.PieChart(document.getElementById('umsl_piechart_3d'));
        chart.draw(data, options);
	}
	</script>
	
	<?php if ( $i > 0 ) { ?> 

	<div style="min-height:300px;height:100%;width:100%;margin:auto;background:#fff;text-align:center">
		<div id="umsl_piechart_3d" style="min-height:300px;height:100%;width:100%;margin:auto;background:#fff;text-align:center"></div>
	</div>
	
	<?php } else { ?>
	
	<div style="height:200px;width:100%;margin:auto;background:#f9f9f9;text-align:center;display:table;">
		<div style="display:table-cell;vertical-align:middle;font-size:20px;color:#ccc;text-align:center;"><?php _e('Not enough data to show visual stats','um-social-login'); ?></div>
	</div>
	
	<?php } ?>

</div>