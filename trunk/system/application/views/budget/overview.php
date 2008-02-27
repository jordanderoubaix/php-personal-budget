<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	
		<title>Budget Overview</title>
		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/reset-fonts-grids/reset-fonts-grids.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/assets/skins/sam/skin.css" />
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url')?>resources/css/main.css" />
		<script type="text/javascript" src="<?=yui_url()?>/build/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/json/json-min.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/element/element-beta-min.js"></script>		
		<script type="text/javascript" src="<?=yui_url()?>/build/datasource/datasource-beta-min.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/charts/charts-experimental-debug.js"></script>
		<script type="text/javascript" src="<?=base_url()?>resources/js/prototype.js"></script>
	</head>
	
	<body class="yui-skin-sam" style="text-align: left; margin-top: 10px;">
		<?php

			foreach($budget_data as $month_data) {
				$months[$month_data['month_pretty_name'] . ' ' . $month_data['year']] = 0;

				if (isset($month_data['categories'])) {
					foreach($month_data['categories'] as $category) {
						$months[$month_data['month_pretty_name'] . ' ' . $month_data['year']] += $category['total_spent'];
					}
				}
			}

		?>	
		<div id="doc3" class="yui-t2">
			<div id="hd"><a href="<?=base_url()?>" style='color: #fff; font-size: 160%'>PHP Personal Budget</a></div>
			<div id="bd">
				<div id="yui-main">
					<div class="yui-b">
						<div class="yui-g">
							<h6>Spending Trend</h6>
							<div id="chart_stuff" style="height: 300px">Could not load the graph</div>
						</div>
					</div>
				</div>
				<div class="yui-b">
					<?php $this->load->view('base/overview_menu.php'); ?>
				</div>
			</div>
			<div id="ft" style='border-top: 1px solid #999; color: #999; text-align: right;'>
				&copy; 2008, <a href="http://skaxo.com">Skaxo Interactive</a>
			</div>
		</div>
		<script type="text/javascript">
			YAHOO.widget.Chart.SWFURL = "<?=yui_url()?>/build/charts/assets/charts.swf";
			var chart_data = [
			<?php
			$data_string = "";
			foreach($months as $month_name => $month) {
				$data_string .= '{ month: "' . $month_name . '", spent: ' . $month . ' },';
			}
			$data_string = substr($data_string, 0, strlen($data_string) - 1);
			echo $data_string;
			?>
			];

			var myDataSource = new YAHOO.util.DataSource(chart_data);
			myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
			myDataSource.responseSchema = {
				fields: [ "month", "spent" ]
			};

			var currencyAxis = new YAHOO.widget.NumericAxis();
			//currencyAxis.minimum = 2000;
			currencyAxis.labelFunction = "formatCurrencyAxisLabel";

			var seriesDef = 
				[
					{
						displayName: "Amount Spent",
						yField: "spent",
						style: 
						{	color: 0x3366cc,
							size: 5,
							lineSize: 1
						}
					}
				];

			function getDataTipText(item, index, series) {
				//var toolTipText = series.displayName + " for " + item.month + ": " + formatCurrencyAxisLabel(item.spent);
				var toolTipText = formatCurrencyAxisLabel(item.spent);
				return toolTipText;
			}
			
			function formatCurrencyAxisLabel(value) {
				return YAHOO.util.Number.format( value,
				{	prefix: "$",
					thousandsSeparator: ",",
					decimalPlaces: 2
				});
			}

			var mychart = new YAHOO.widget.LineChart("chart_stuff", myDataSource, 
				{	xField: "month",
					series: seriesDef,
					yAxis: currencyAxis,
					style: 
					{
						font: { name: "Courier New", size: 12, color: 0x3366cc, bold: true },
						xAxis:
						{
							color: 0xa2bae7
						},
						yAxis: 
						{
							majorTicks: { color: 0xa2bae7 },
							minorTicks: { color: 0xa2bae7 },
							majorGridLines: { color: 0xa2bae7 },
							color: 0xa2bae7
						}
					},
					dataTipFunction: "getDataTipText"
				});

		</script>
	
	</body>
	
</html>
