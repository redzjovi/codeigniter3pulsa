<?php if ($this->session->flashdata('profile_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('profile_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
	<div class="panel-heading">
        <?php echo lang('menu_nav_dashboard') ?>
    </div>
	<div class="panel-body">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h4><b><?php echo lang('dashboard_label_paid').' ('.number_format($stats->count_paid).')' ?></b></h4>
						<p><?php echo number_format($stats->total_paid) ?></p>
					</div>
					<div class="icon">
						<i class=""></i>
					</div>
					<a href="#" class="small-box-footer">&nbsp;</a>
				</div>
            </div><!-- ./col -->
			
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h4><b><?php echo lang('dashboard_label_unpaid').' ('.number_format($stats->count_unpaid).')' ?></b></h4>
						<p><?php echo number_format($stats->total_unpaid) ?></p>
					</div>
					<div class="icon">
						<i class=""></i>
					</div>
					<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
				</div>
            </div><!-- ./col -->
			
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h4><b><?php echo lang('dashboard_label_total').' ('.number_format($stats->count_total).')' ?></b></h4>
						<p><?php echo number_format($stats->total) ?></p>
					</div>
					<div class="icon">
						<i class=""></i>
					</div>
					<a href="#" class="small-box-footer">&nbsp;</a>
				</div>
            </div><!-- ./col -->
			
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h4><b><?php echo lang('dashboard_label_profit').' ('.number_format($stats->count_profit).')' ?></b></h4>
						<p><?php echo number_format($stats->total_profit) ?></p>
					</div>
					<div class="icon">
						<i class=""></i>
					</div>
					<a href="#" class="small-box-footer">&nbsp;</a>
				</div>
            </div><!-- ./col -->
		</div><!-- /.row -->
		
		<div class="row">
			<div class="col-md-12">
				<p class="text-center">
					<strong><?php echo lang('dashboard_label_transaction_history') ?></strong>
				</p>
				<div class="chart">
					<!-- Sales Chart Canvas -->
					<div id="transaction_history_chart" style="width:100%; height:400px;"></div>
					<!-- <canvas id="transaction_history_chart" style="height: 180px;"></canvas> -->
				</div>
			</div>
		</div><!-- /.row -->
	</div>
</div>

<script>
	var chart;
    var graph;
			
	var chartData2 =
	[
		{
			"date": "04-05-2016",
			"value": 1
		},
		{
			"date": "05-05-2016",
			"value": 2
		},
		{
			"date": "06-05-2016",
			"value": 3
		},
		{
			"date": "07-05-2016",
			"value": 4
		},
		{
			"date": "08-05-2016",
			"value": 3
		}
    ];
	
	var chartData = <?php echo $transaction_history_chart ?>;
	console.log(chartData);
				
	AmCharts.ready(function () {
		// SERIAL CHART
		chart = new AmCharts.AmSerialChart();

		chart.dataProvider = chartData;
		chart.categoryField = "date";
		// chart.dataDateFormat = "DD MMM YYYY";

		// listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
		// chart.addListener("dataUpdated", zoomChart);

		// AXES
		// category
		var categoryAxis = chart.categoryAxis;
		categoryAxis.dashLength = 3;
		categoryAxis.minorGridAlpha = 0.1;
		categoryAxis.minorGridEnabled = true;
		// categoryAxis.minPeriod = "YYYY-MM-DD"; // our data is yearly, so we set minPeriod to YYYY
		// categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
		
		// value
		var valueAxis = new AmCharts.ValueAxis();
		valueAxis.axisAlpha = 0;
		valueAxis.dashLength = 3;
		valueAxis.inside = true;
		chart.addValueAxis(valueAxis);

		// GRAPH
		graph = new AmCharts.AmGraph();
		graph.fillAlphas = 0.5;
		graph.type = "smoothedLine"; // this line makes the graph smoothed line.
		graph.lineColor = "#d1655d";
		graph.negativeLineColor = "#637bb6"; // this line makes the graph to change color when it drops below 0
		graph.bullet = "round";
		graph.bulletSize = 8;
		graph.bulletBorderColor = "#FFFFFF";
		graph.bulletBorderAlpha = 1;
		graph.bulletBorderThickness = 2;
		graph.lineThickness = 2;
		graph.valueField = "value";
		graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[value]] ([[count_paid]])</span></b>";
		chart.addGraph(graph);

		// CURSOR
		var chartCursor = new AmCharts.ChartCursor();
		// chartCursor.categoryBalloonDateFormat = "DD-MM-YYYY";
		chartCursor.cursorAlpha = 0;
		chartCursor.cursorPosition = "mouse";
		chart.addChartCursor(chartCursor);

		// SCROLLBAR
		var chartScrollbar = new AmCharts.ChartScrollbar();
		chart.addChartScrollbar(chartScrollbar);

		// WRITE
		chart.write("transaction_history_chart");
	});

	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart() {
		// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
		chart.zoomToDates(new Date(1972, 0), new Date(1984, 0));
	}
</script>