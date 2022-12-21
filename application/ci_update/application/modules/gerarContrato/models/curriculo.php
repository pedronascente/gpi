<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class curriculo extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getData($maximo, $inicio, $filtros) {
        $content = '';
        $palavrachave = (!empty($filtros['palavrachave'])) ? $filtros['palavrachave'] : null;
        unset($filtros['palavrachave']);
        if ($palavrachave) {
            $this->db->select('dataCadastro,rh_candidato.arquivar,rh_candidato.candidato_id, nome, rg, cpf,bairro, cargoPretendido, categoria, rh_endereco.cidade, (YEAR(CURDATE())-YEAR(dataNascimento))-(RIGHT(CURDATE(),5)<RIGHT(dataNascimento,5)) as idade')->from('rh_candidato')->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')->like('nome', $palavrachave)->or_like('cidade', $palavrachave)->or_like('bairro', $palavrachave)->or_like('cargoPretendido', $palavrachave)->or_like('sexo', $palavrachave)->where('arquivar', '0');
            $data = $this->db->order_by("rh_candidato.candidato_id", "desc")->limit($maximo, $inicio)->get()->result();
            $this->db->select('dataCadastro,rh_candidato.arquivar,rh_candidato.candidato_id, nome, rg, cpf,bairro, cargoPretendido, categoria, rh_endereco.cidade, (YEAR(CURDATE())-YEAR(dataNascimento))-(RIGHT(CURDATE(),5)<RIGHT(dataNascimento,5)) as idade')->from('rh_candidato')->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')->like('nome', $palavrachave)->or_like('cidade', $palavrachave)->or_like('bairro', $palavrachave)->or_like('cargoPretendido', $palavrachave)->or_like('sexo', $palavrachave)->where('arquivar', '0');
            $count = $this->db->order_by("rh_candidato.candidato_id", "desc")->get()->num_rows();
        } else {
            //RETORNA DADOS  DA TABELA :
            $this->db->select('dataCadastro,rh_candidato.arquivar,rh_candidato.candidato_id, nome, rg, cpf,bairro, cargoPretendido, categoria, rh_endereco.cidade, (YEAR(CURDATE())-YEAR(dataNascimento))-(RIGHT(CURDATE(),5)<RIGHT(dataNascimento,5)) as idade')->from('rh_candidato')->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')->where('arquivar', '0');
            $this->setFiltro($filtros);
            $data = $this->db->order_by("rh_candidato.candidato_id", "desc")->limit($maximo, $inicio)->get()->result();
            //RETORNA NUMERO DE DADOS DA TABELA :
            $this->db->select('dataCadastro,rh_candidato.arquivar,rh_candidato.candidato_id, nome, rg, cpf,bairro, cargoPretendido, categoria, rh_endereco.cidade, (YEAR(CURDATE())-YEAR(dataNascimento))-(RIGHT(CURDATE(),5)<RIGHT(dataNascimento,5)) as idade')->from('rh_candidato')->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')->where('arquivar', '0');
            $this->setFiltro($filtros);
            $count = $this->db->order_by("rh_candidato.candidato_id", "desc")->where('arquivar', '0')->get()->num_rows();
            $this->db->close();
            foreach ($data as $key => $value) {
                $categoria = $value->categoria == 'n' ? '' : $value->categoria;
                $content .= '<tr>';
                $content .= '<td>' . $value->nome . '</td>';
                $content .= '<td class="txt-center">' . $value->rg . '</td>';
                $content .= '<td class="txt-center">' . $value->cpf . '</td>';
                $content .= '<td>' . $value->cargoPretendido . '</td>';
                $content .= '<td class="txt-center">' . $value->cidade . '</td>';
                $content .= '<td class="txt-center">' . $categoria . '</td>';
                $content .= '<td class="txt-center">' . $value->idade . '</td>';
                $content .= '<td class="txt-center"><a target="_blank" href="' . $this->config->base_url('visualizar/' . $value->candidato_id) . '" class="btn btn-sm btn-success">ver</span></a></td>';
                $content .= '</tr>';
            }
        }
        return array('content' => $data, 'count' => $count);
    }

    private function setFiltro($filtros) {
        if (isset($filtros)) {
            foreach ($filtros as $key => $value) {
                switch ($key) {
                    case 'dateCadStart':
                        if (isset($filtros['dateCadEnd'])) {
                            $this->db->where('dataCadastro >=', date('Y-m-d', strtotime(str_replace('/', '-', $filtros['dateCadStart']))));
                            $this->db->where('dataCadastro <=', date('Y-m-d', strtotime(str_replace('/', '-', $filtros['dateCadEnd']))));
                        } else {
                            $this->db->where('dataCadastro >=', date('Y-m-d', strtotime(str_replace('/', '-', $filtros['dateCadStart']))));
                        }
                        break;
                    case 'dateCadEnd':
                        break;
                    case 'idadeStart':
                        date_default_timezone_set('America/Sao_Paulo');
                        if (isset($filtros['idadeEnd'])) {
                            $this->db->where('dataNascimento <=', date('Y-m-d H:i:s', strtotime('-' . $filtros['idadeStart'] . ' years', strtotime(date('Y-m-d H:i:s')))));
                            $this->db->where('dataNascimento >=', date('Y-m-d H:i:s', strtotime('-' . $filtros['idadeEnd'] . ' years', strtotime(date('Y-m-d H:i:s')))));
                        } else {
                            $this->db->where('dataNascimento >=', date('Y-m-d H:i:s', strtotime('-' . $filtros['idadeStart'] - 1 . ' years', strtotime(date('Y-m-d H:i:s')))));
                            $this->db->where('dataNascimento <=', date('Y-m-d H:i:s', strtotime('-' . $filtros['idadeStart'] . ' years', strtotime(date('Y-m-d H:i:s')))));
                        }
                        break;
                    case 'idadeEnd':
                        break;
                    default :
                        $this->db->like($key, $value);
                        break;
                }
            }
        }
    }

    public function getColaborador($id) {
        $dadosPessoais = $this->db->select('*,rh_candidato.candidato_id as id_candidato')
                        ->from('rh_candidato')
                        ->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')
                        ->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')
                        ->join('rh_contato', 'rh_contato.candidato_id = rh_candidato.candidato_id', 'left outer')
                        ->where('rh_candidato.candidato_id', $id, 'left outer')
                        ->get()->row();
        $formacao = $this->db->select('*')
                        ->from('rh_formacao')
                        ->where('candidato_id', $id)
                        ->get()->result();
        $experiencia = $this->db->select('*')
                        ->from('rh_experienciaproficional')
                        ->where('candidato_id', $id)
                        ->get()->result();

        $this->db->close();
        return array('dadosPessoais' => $dadosPessoais, 'formacao' => $formacao, 'experiencia' => $experiencia);
    }

    public function getTotalRegistro() {
        $query = $this->db->select('dataCadastro,rh_candidato.candidato_id, nome, rg, cpf, cargoPretendido, categoria, rh_endereco.cidade, (YEAR(CURDATE())-YEAR(dataNascimento))-(RIGHT(CURDATE(),5)<RIGHT(dataNascimento,5)) as idade')
                        ->from('rh_candidato')
                        ->join('rh_documentacao', 'rh_documentacao.candidato_id = rh_candidato.candidato_id', 'left outer')
                        ->join('rh_endereco', 'rh_endereco.candidato_id = rh_candidato.candidato_id', 'left outer')
                        ->get()->result();
        return $query;
    }

    public function salvarEdicao($data) {
        if (!empty($data)) {
            $id = array('candidato_id' => $data['DADOSPESSOAIS']['candidato_id']);
            $data['DADOSPESSOAIS']['dataNascimento'] = date('Y-m-d', strtotime($data['DADOSPESSOAIS']['dataNascimento']));
            $this->updateColaborador('rh_candidato', $data['DADOSPESSOAIS'], $id);
            $this->updateColaborador('rh_documentacao', $data['DOCUMENTACAO'], $id);
            $this->updateColaborador('rh_endereco', $data['ENDERECO'], $id);
            $this->updateColaborador('rh_contato', $data['CONTATO'], $id);
            $this->updateFormacao($data['FORMACAO'], $id);
            $this->updateExperiencia($data['EXPERIENCIAPROFISSIONAL'], $id);

            return array('boll' => true, 'id' => $data['DADOSPESSOAIS']['candidato_id']);
        } else {
            return array('boll' => false, 'id' => $data['DADOSPESSOAIS']['candidato_id']);
        }
    }

    public function excluir($id) {
        try {

            $tables = array('rh_candidato', 'rh_contato', 'rh_documentacao', 'rh_experienciaproficional', 'rh_formacao');
            $this->db->where('candidato_id', $id);
            $this->db->delete($tables);
            $this->db->close();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    private function updateColaborador($tabela, $dados, $id) {
        $this->db->where($id);
        $this->db->update($tabela, $dados);
    }

    private function updateFormacao(array $dadosForm, $where) {
        foreach ($dadosForm as $coluna => $valor) {
            foreach ($valor as $k => $v) {
                $arrayFormacao[$k]['candidato_id'] = $where['candidato_id'];
                $arrayFormacao[$k][$coluna] = $v;
            }
        }
        foreach ($arrayFormacao as $formacao) {
            $where['formacao_id'] = $formacao['formacao_id'];
            $this->updateColaborador('rh_formacao', $formacao, $where);
        }
    }

    private function updateExperiencia(array $dadosForm, $where) {
        $arrayExperiencia = null;
        foreach ($dadosForm as $coluna => $valor) {
            foreach ($valor as $k => $v) {
                $arrayExperiencia[$k]['candidato_id'] = $where['candidato_id'];
                $arrayExperiencia[$k][$coluna] = $v;
            }
        }
        foreach ($arrayExperiencia as $experiencia) {
            $experiencia['dataAdimissao'] = !empty($experiencia['dataAdimissao']) ? FormatadataSql($experiencia['dataAdimissao']) : NULL;
            $experiencia['dataDemissao'] = !empty($experiencia['dataDemissao']) ? FormatadataSql($experiencia['dataDemissao']) : NULL;
            $where['experienciaProficional_id'] = $experiencia['experienciaProficional_id'];
            $this->updateColaborador('rh_experienciaProficional', $experiencia, $where);
        }
    }

    public function setArquivar($tabela, $dados, $id) {
        $this->updateColaborador($tabela, $dados, "candidato_id={$id}");
    }

}
