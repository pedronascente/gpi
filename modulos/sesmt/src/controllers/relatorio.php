<?php
include_once("Config.inc.php");

$quiz = new QuizModel();
$Pergunta1 = new Pergunta1Model();
$Pergunta2 = new Pergunta2Model();
$Pergunta3 = new Pergunta3Model();
$Pergunta4 = new Pergunta4Model();
$Pergunta5 = new Pergunta5Model();
$Pergunta6 = new Pergunta6Model();
$Pergunta7 = new Pergunta7Model();

$total_respostas = $quiz->total_respostas();
$array_pergunta1 = $Pergunta1->get_relatorio();
$array_pergunta2 = $Pergunta2->get_relatorio();
$array_pergunta3 = $Pergunta3->get_relatorio();
$array_pergunta4 = $Pergunta4->get_relatorio();
$array_pergunta5 = $Pergunta5->get_relatorio();
$array_pergunta6 = $Pergunta6->get_relatorio();
$array_pergunta7 = $Pergunta7->get_relatorio();
