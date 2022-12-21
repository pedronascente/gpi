<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['relatoriocaptacao'] = 'RelatorioCaptacao/index';
$route['relatoriocaptacao/geral'] = 'RelatorioCaptacao/get_geral';
$route['relatoriocaptacao/(:any)/(:any)/(:any)/(:any)']['GET'] = "RelatorioCaptacao/get_filtros/$1/$2/$3/$4";
$route['relatoriocaptacao/filtros/(:any)/(:any)/(:any)/(:any)']['GET'] = "RelatorioCaptacao/get_filtros_dinamico/$1/$2/$3/$4";

$route['migrarcaptacao'] = "MigrarCaptacao/index";


$route['migrarcaptacaoselect'] = "MigrarCaptacao/migrarCaptacaoSelect";
$route['migrarcaptacaosave'] = "MigrarCaptacao/migrarCaptacaoSave";
$route['migrarcaptacaosucesso'] = "MigrarCaptacao/migrarCaptacaoSucesso";

$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'curriculosGerenciar/gerenciar';
$route['curriculosGerenciar/getData'] = 'curriculosGerenciar/getData';
$route['gerenciar'] = 'curriculosGerenciar/gerenciar';
$route['arquivados'] = 'curriculosGerenciar/arquivados';
$route['migrar'] = 'curriculosGerenciar/Rh/index';
$route['visualizar/(:num)'] = 'curriculosGerenciar/visualizar/$1';
$route['editar/(:num)'] = 'curriculosGerenciar/editar/$1';
$route['arquivar/(:num)'] = 'curriculosGerenciar/arquivar/$1';
$route['excluir/(:num)'] = 'curriculosGerenciar/excluir/$1';
$route['salvarEdicao'] = 'curriculosGerenciar/salvarEdicao';

//checkList #cartaotri
$route['baixar-ckecklist/(:num)'] = 'CheckList/baixar_checklist/$1';
