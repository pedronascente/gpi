<?php

class QuizModel extends Crud
{
  private $tabela = 'quiz_models';

  public function insert($array_inputs)
  {
    $this->Create()->ExCreate($this->tabela, $array_inputs);
    return $this->Create()->getResult();
  }

  public function total_respostas()
  {
    $sql = "SELECT COUNT('id') AS 'total_respostas' from  $this->tabela";
    $this->Read()->FullRead($sql);
    return $this->limparArray($this->Read()->getResult());
  }
}
