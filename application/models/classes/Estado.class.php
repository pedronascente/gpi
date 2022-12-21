<?php

class Estado extends Crud {

    public function select() {
        $this->Read()->ExRead("estado", null, null);
        return $this->Read()->getResult();
    }

    public function selectDDDsEstado($idEstado) {
        $this->Read()->ExRead("regiao", "WHERE regiao_estado_id = :idEstado", "idEstado={$idEstado}");
        return $this->Read()->getResult();
    }

}
