<link type="text/css" rel="stylesheet" href="/gpi/public/css/sesmt.css" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php include_once  'src/controllers/relatorio.php'; ?>

<div class="row">
	<div class="col-md-12">
		<div class="card  ">
			<div class="card-body">
				<blockquote class="blockquote mb-0">
					<h4 class="M7eMe "> <b><?= $total_respostas['total_respostas']; ?> respostas </b></h4>
				</blockquote>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<blockquote class="blockquote ">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#1 Quanto tempo por dia você fica sentado em um dia de semana ?</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script>
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Contry', 'Mhl'],
								<?php foreach ($array_pergunta1 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var chart = new google.visualization.PieChart(document.getElementById('pergunta1'));
							chart.draw(data);
						}
					</script>
					<div class="rPU8He" id="pergunta1" style="position: relative; width: 100%; max-width: 732px; height: 350px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<blockquote class="blockquote">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#2 Quanto tempo por dia você fica sentado no final de semana ?</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script>
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Contry', 'Mhl'],
								<?php foreach ($array_pergunta2 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var chart = new google.visualization.PieChart(document.getElementById('pergunta2'));
							chart.draw(data);
						}
					</script>
					<div class="rPU8He" id="pergunta2" style="position: relative; width: 100%; max-width: 732px; height: 350px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card  ">
			<div class="card-body">
				<blockquote class="blockquote mb-0">
					<h4 class="M7eMe ">
						<b>SINAIS E SINTOMAS</b>
					</h4>
				</blockquote>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<blockquote class="blockquote">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#3 Nos Últimos 12 meses, você teve problemas como dor , formigamento/dormência em:</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script type="text/javascript">
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['sintomas', 'Contagem'],
								<?php foreach ($array_pergunta3 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var options = {
								colors: ['green'],
								legend: {
									position: "none"
								},

							};
							var chart = new google.visualization.BarChart(document.getElementById('pergunta3'));
							chart.draw(data, options);
						}
					</script>
					<div class="rPU8He" id="pergunta3" style="position: relative; width: 100%; max-width: 732px; height: 400px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card  ">
			<div class="card-body">
				<blockquote class="blockquote ">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#4 Nos Últimos 12 meses, você foi impedido(a) de realizar atividades normais <br>
								(trabalho, atividades domesticas e de lazer) por causa desse problema em:</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script type="text/javascript">
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['sintomas', 'Contagem'],
								<?php foreach ($array_pergunta4 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var options = {
								colors: ['green'],
								legend: {
									position: "none"
								},

							};
							var chart = new google.visualization.BarChart(document.getElementById('pergunta4'));
							chart.draw(data, options);
						}
					</script>
					<div class="rPU8He" id="pergunta4" style="position: relative; width: 100%; max-width: 732px; height: 400px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<blockquote class="blockquote ">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#5 No último ano você foi ao médico por esta queixa:</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script type="text/javascript">
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['sintomas', 'Contagem'],
								<?php foreach ($array_pergunta5 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var options = {
								colors: ['green'],
								legend: {
									position: "none"
								},

							};
							var chart = new google.visualization.BarChart(document.getElementById('pergunta5'));
							chart.draw(data, options);
						}
					</script>
					<div class="rPU8He" id="pergunta5" style="position: relative; width: 100%; max-width: 732px; height: 400px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<blockquote class="blockquote ">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal">#6 No último ano você foi ao médico por esta queixa:</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script type="text/javascript">
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['sintomas', 'Contagem'],
								<?php foreach ($array_pergunta6 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var options = {
								colors: ['green'],
								legend: {
									position: "none"
								},

							};
							var chart = new google.visualization.BarChart(document.getElementById('pergunta6'));
							chart.draw(data, options);
						}
					</script>
					<div class="rPU8He" id="pergunta6" style="position: relative; width: 100%; max-width: 732px; height: 400px;"></div>
				</blockquote>
			</div>
		</div>

		<div class="card  ">
			<div class="card-body">
				<blockquote class="blockquote ">
					<div class="SLvR0" id="c477" role="heading"><span class="myXFAc RjsPE">
							<b style="font-style:normal;white-space:normal"> #7 No últimos 7 dias você teve problema em:</b>
						</span><span class="bXtdDb"><?= $total_respostas['total_respostas']; ?> respostas </b></span>
					</div>
					<script type="text/javascript">
						google.charts.load('current', {
							'packages': ['corechart']
						});
						google.charts.setOnLoadCallback(drawChart);

						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['sintomas', 'Contagem'],
								<?php foreach ($array_pergunta7 as $item) { ?>['<?= $item['resposta'] ?>', <?= $item['total'] ?>],
								<?php	} ?>
							]);
							var options = {
								colors: ['green'],
								legend: {
									position: "none"
								},

							};
							var chart = new google.visualization.BarChart(document.getElementById('pergunta7'));
							chart.draw(data, options);
						}
					</script>
					<div class="rPU8He" id="pergunta7" style="position: relative; width: 100%; max-width: 732px; height: 400px;"></div>
				</blockquote>
			</div>
		</div>
	</div>
</div>