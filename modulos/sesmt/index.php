<link type="text/css" rel="stylesheet" href="/gpi/public/css/sesmt.css" />
<div class="panel panel-primary ">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="card  ">
					<div class="card-header text-center py-1 RVEQke">
					</div>
					<div class="card-body ">
						<blockquote class="blockquote">
							<h1 class="F9yp7e">
								<b>AVALIAÇÃO PERFIL LABORAL</b>
							</h1>
							<p class="c2gzEf">
								A Ginástica Laboral é a prática de atividades físicas
								leves no local de trabalho, com o objetivo de prevenir e aliviar dores e incômodos que
								ocorrem devido às atividades dos colaboradores.
							</p>
						</blockquote>
					</div>
				</div>
				<div class="card">
					<div class="card-body ">
						<blockquote class="blockquote">
							<p>
								Com o intuito de melhorar nossa ginástica laboral, gostaríamos que respondesse o questionário abaixo:
							</p>
						</blockquote>
					</div>
				</div>
				<form action="modulos/sesmt/src/controllers/salvar.php" method="POST">
					<div class="card ">
						<div class="card-body ">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<h4 class="M7eMe">
									<b>#1 Quanto tempo por dia você fica sentado em um dia de semana ? <span class="_color-red">*</span></b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta1.php";
								if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote 		<?php if (isset($_SESSION['pergunta2']) && $_SESSION['pergunta2'] == 'fail') {
																									echo '_error-alert';
																								} ?>">
								<h4 class="M7eMe">
									<b>#2 Quanto tempo por dia você fica sentado no final de semana ? <span class="_color-red">*</span></b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta2.php";
								if (isset($_SESSION['pergunta2']) && $_SESSION['pergunta2'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote ">
								<h4 class="M7eMe">
									<b>SINAIS E SINTOMAS</b>
								</h4>
								<p class="M7eMe c2gzEf">
									<b>Por favor, responda questões abaixo colocando um "X" para pergunta no quadrado apropriado.</b>
								</p>
								<p>Esta figura mostra como o corpo foi dividido, por si mesmo, qual parte está ou foi afetada, se houve alguma.</p>
							</blockquote>
						</div>
					</div>
					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote ">
								<img src="public/img/corpo-humano.jpg" class="img-fluid" />
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta3']) && $_SESSION['pergunta3'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<h4 class="M7eMe">
									<b>#3 Nos Últimos 12 meses, você teve problemas como dor , formigamento/dormência em: <span class="_color-red">*</span></b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta3.php";
								if (isset($_SESSION['pergunta3']) && $_SESSION['pergunta3'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta4']) && $_SESSION['pergunta4'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<h4 class="M7eMe">
									<b>#4 Nos Últimos 12 meses, você foi impedido(a) de realizar atividades normais (trabalho, atividades domesticas e de lazer)
										por causa desse problema em: <span class="_color-red">*</span>
									</b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta4.php";
								if (isset($_SESSION['pergunta4']) && $_SESSION['pergunta4'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta5']) && $_SESSION['pergunta5'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<b>#5 No último ano você foi ao médico por esta queixa: <span class="_color-red">*</span></b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta5.php";
								if (isset($_SESSION['pergunta5']) && $_SESSION['pergunta5'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta6']) && $_SESSION['pergunta6'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<h4 class="M7eMe"><b> #6 No último ano você foi ao médico por esta queixa: <span class="_color-red">*</span></b></h4>
								<?php
								include "src/views/formularios/frm_pergunta6.php";
								if (isset($_SESSION['pergunta6']) && $_SESSION['pergunta6'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>

					<div class="card ">
						<div class="card-body">
							<blockquote class="blockquote <?php if (isset($_SESSION['pergunta7']) && $_SESSION['pergunta7'] == 'fail') {
																							echo '_error-alert';
																						} ?>">
								<h4 class="M7eMe">
									<b>#7 No últimos 7 dias você teve problema em: <span class="_color-red">*</span></b>
								</h4>
								<?php
								include "src/views/formularios/frm_pergunta7.php";
								if (isset($_SESSION['pergunta7']) && $_SESSION['pergunta7'] == 'fail') {
									echo '<span class="error" role="alert">	<strong>Esta pergunta é obrigatória.</strong></span>';
								}
								?>
							</blockquote>
						</div>
					</div>
					<input type="submit" value="Enviar" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>
</div>