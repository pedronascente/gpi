<?php

class Pergunta7Model extends Crud
{
  private $tabela = 'pergunta7_models';

  public function insert($array_inputs)
  {
    $this->Create()->ExCreate($this->tabela, $array_inputs);
    return $this->Create()->getResult();
  }

  public function get_relatorio()
  {
    $sql = "SELECT COUNT('id') AS 'total', resposta FROM  $this->tabela GROUP BY  resposta ORDER BY resposta ASC";
    $this->Read()->FullRead($sql);
    return $this->Read()->getResult();
  }
}
