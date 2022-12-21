<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rh extends CI_Controller {
	
	public $UrlAatualizarDadosRh = "http://www.seguidor.com.br/api_restful_gpi/rh/arquivar";
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_CRUD');
		$this->load->model('rh/RHcandidato');
		$this->load->model('rh/RHcontato');
		$this->load->model('rh/RHdocumentacao');
		$this->load->model('rh/RHendereco');
		$this->load->model('rh/RHexperienciaproficional');
		$this->load->model('rh/RHformacao');		
	}

	public function index(){
            	$data = $this->save_rh();
		die(json_encode( array('data'=>$data)));
	}

	/*
	 * ....................................................................................................
	 * METODOS AUXILIARES DO METODO ::save_rh() :
	 * ....................................................................................................
	*/
	private function saveContato($ArrayListDependeteContato, $id_ultimoRegistro) {
        $ArrayListDependeteContato = $ArrayListDependeteContato['rh_contato'];
		if(!empty($ArrayListDependeteContato)){		
			foreach ($ArrayListDependeteContato as $v) {
			    $id = $v['contato_id'];
				unset( $v['candidato_id'],$v['contato_id'] );
				$v['candidato_id'] = $id_ultimoRegistro;
				$v['arquivar_seguidor'] = 's';
				$ultimo_id = $this->RHcontato->save($v);
				$this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_contato','id'=>$id ));//ARQUIVAR DADOS NA BASE SEGUIDOR.
			}
		}
    }
	
	private function saveDocumentacao($ArrayListDependeteDocumentacao, $id_ultimoRegistro) {
        $ArrayListDependeteDocumentacao = $ArrayListDependeteDocumentacao['rh_documentacao'];
        if(!empty($ArrayListDependeteDocumentacao)){	
			foreach ($ArrayListDependeteDocumentacao as $v) {
				$id = $v['doc_id'];
				unset( $v['candidato_id'],$v['doc_id']);
				$v['candidato_id'] = $id_ultimoRegistro;
				$v['arquivar_seguidor'] = 's';
				$this->RHdocumentacao->save($v);
				$this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_documentacao','id'=>$id));//ARQUIVAR DADOS NA BASE SEGUIDOR.
			}
		}
    }
	
	private function saveEnderecoRH($ArrayListDependeteEndereco, $id_ultimoRegistro) {
        $ArrayListDependeteEndereco = $ArrayListDependeteEndereco['rh_endereco'];
        if(!empty($ArrayListDependeteEndereco)){	
			foreach ($ArrayListDependeteEndereco as $v) {
				$id = $v['endereco_id'];
				unset( $v['candidato_id'],$v['endereco_id']);
				$v['candidato_id'] = $id_ultimoRegistro;
				$v['arquivar_seguidor'] = 's';
				$this->RHendereco->save($v);
				$this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_endereco','id'=>$id ));//ARQUIVAR DADOS NA BASE SEGUIDOR.
			}
		}
    }
	
	private function saveExperienciaProficional($ArrayListDependeteExperienciaProficional, $id_ultimoRegistro) {
        $ArrayListDependeteExperienciaProficional = $ArrayListDependeteExperienciaProficional['rh_experienciaproficional'];
        if(!empty($ArrayListDependeteExperienciaProficional)){
			foreach ($ArrayListDependeteExperienciaProficional as $v) {
				$id = $v['experienciaProficional_id'];
				unset( $v['candidato_id'],$v['experienciaProficional_id']);
				$v['candidato_id'] = $id_ultimoRegistro;
				$v['arquivar_seguidor'] = 's';
				$this->RHexperienciaproficional->save($v);
				$this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_experienciaproficional','id'=>$id ));//ARQUIVAR DADOS NA BASE SEGUIDOR .			
			}
		}
    }
	
	private function saveFormacao($ArrayListDependeteFormacao, $id_ultimoRegistro) {
        $ArrayListDependeteFormacao = $ArrayListDependeteFormacao['rh_formacao'];
        if(!empty($ArrayListDependeteFormacao)){
			foreach ($ArrayListDependeteFormacao as $v) {
				$id = $v['formacao_id'];
				unset( $v['candidato_id'],$v['formacao_id']);
				$v['candidato_id'] = $id_ultimoRegistro;
				$v['arquivar_seguidor'] = 's';
				$this->RHformacao->save($v);
				$this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_formacao','id'=>$id ));//ARQUIVAR DADOS NA BASE SEGUIDOR .				
			}
		}
    }
	/*
	 * ....................................................................................................
	 * RH :
	 * ....................................................................................................
	*/
	private function save_rh(){
	   $ArrayListCandidato = $this->buscarDadosviaWS(array("TABELA" => 'rh_candidato'));
	        if($ArrayListCandidato['rh_candidato']==false){
			return false;
			die();
		}
                # TOTAL DE REGISTROS.
		$number_of_candidato = count($ArrayListCandidato['rh_candidato']);
		 
                
                # SALVAR CANDIDATOS NA BASE INTERNA:
		for ($i = 0; $i < $number_of_candidato; $i++) {
                    $ID_AUX = $ArrayListCandidato['rh_candidato'][$i]['candidato_id'];
                    unset($ArrayListCandidato['rh_candidato'][$i]['candidato_id']);
                    $ArrayListCandidato['rh_candidato'][$i]['arquivar_seguidor'] = 's';
                    $duplicado = '';$this->RHcandidato->verificaDuplicata($ArrayListCandidato['rh_candidato'][$i]['nome']);
                    if(empty($duplicado)){
                            $id_ultimoRegistro = $this->RHcandidato->save($ArrayListCandidato['rh_candidato'][$i]);
                            //ATUALIZAR ARQUIVAR REGISTRO NO SEGUIDOR
                            if($id_ultimoRegistro){
                                    $this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_candidato',	'id'=>$ID_AUX ));
                            }	
                            //BUSCAR TABELA DEPENDENTES BASE SEGUIDOR :
                            $ArrayListRHcontato = $this->buscarDadosviaWS(array("TABELA" => 'rh_contato', "CAMPO" => 'candidato_id', "ID" => $ID_AUX));
                            $ArrayListRHdocumentacao = $this->buscarDadosviaWS(array("TABELA" => 'rh_documentacao', "CAMPO" => 'candidato_id', "ID" => $ID_AUX));
                            $ArrayListRHendereco = $this->buscarDadosviaWS(array("TABELA" => 'rh_endereco', "CAMPO" => 'candidato_id', "ID" => $ID_AUX));
                            $ArrayListRHexperienciaproficional = $this->buscarDadosviaWS(array("TABELA" => 'rh_experienciaproficional', "CAMPO" => 'candidato_id', "ID" => $ID_AUX));
                            $ArrayListRHformacao = $this->buscarDadosviaWS(array("TABELA" => 'rh_formacao', "CAMPO" => 'candidato_id', "ID" => $ID_AUX));			
                            //SALVAR TABELAS DEPENDENTES BASE INTERNA:
                            $this->saveContato($ArrayListRHcontato, $id_ultimoRegistro);
                            $this->saveDocumentacao($ArrayListRHdocumentacao, $id_ultimoRegistro);
                            $this->saveEnderecoRH($ArrayListRHendereco, $id_ultimoRegistro);
                            $this->saveExperienciaProficional($ArrayListRHexperienciaproficional, $id_ultimoRegistro);
                            $this->saveFormacao($ArrayListRHformacao, $id_ultimoRegistro);
                    }else{
                        $this->updateTabela($this->UrlAatualizarDadosRh, array('table'=>'rh_candidato',	'id'=>$ID_AUX ));
                    }
		}
	}
	/*
	 * ....................................................................................................
		WEB SERVICES :
	 * ....................................................................................................
	*/
    
    private function buscarDadosviaWS($arrayData) {
        $url = "http://www.seguidor.com.br/api_restful_gpi/rh/list/{$arrayData['TABELA']}";
        if (isset($arrayData['ID']) && $arrayData['ID'] > 0) {
            $url = "http://www.seguidor.com.br/api_restful_gpi/rh/list/{$arrayData['TABELA']}/{$arrayData['CAMPO']}/{$arrayData['ID']}";
        }
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

	private function updateTabela($url, $dataArray) {
	 	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataArray));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$response=json_decode($response_json, true);
    }
}
