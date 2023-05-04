<?php

class Help
{
  public function get_dia_semana($data)
  {
    switch ($data) {
      case 1:
        return 'Entre :  1 - 2  Horas';
        break;
      case 2:
        return 'Entre :  2 - 3 Horas';
        break;
      case 3:
        return 'Entre :  3 - 4 Horas';
        break;
      case 4:
        return 'Entre :  4 - 5 Horas';
        break;
      case 5:
        return 'Entre :  5 - ou mais';
        break;
    }
  }

  public function get_problema($data)
  {

    switch ($data) {
      case 1:
        return 'Pescoço';
        break;
      case 2:
        return 'Ombros';
        break;
      case 3:
        return 'Cotovelos';
        break;
      case 4:
        return 'Antebraços';
        break;
      case 5:
        return 'Punhos / Mãos / Dedos';
        break;
      case 6:
        return 'Parte Superior das costas';
        break;
      case 7:
        return 'Parte Inferior das costas';
        break;
      case 8:
        return 'Quadril / coxas';
        break;
      case 9:
        return 'Joelhos';
        break;
      case 10:
        return 'Tornozelos / Pés';
        break;
      case 11:
        return 'Cabeça';
        break;
    }
  }
}
