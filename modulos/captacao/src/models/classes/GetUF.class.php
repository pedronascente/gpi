<?php

//namespace C:\wamp\www\gpi\modulos\captacao\src\models\classes\GetUF.class.php
final class GetUF {

    public $_uf = false;
    public $array_lista_uf = [];

    public function _getUF($ddd) {
        $this->array_lista_uf = [
            ['AC' => [68]],
            ['AL' => [82]],
            ['AP' => [96]],
            ['AM' => [92, 97]],
            ['BA' => [71, 73, 74, 75, 77]],
            ['CE' => [88, 85]],
            ['ES' => [27, 28]],
            ['GO' => [61, 62, 64]],
            ['MA' => [98, 99]],
            ['MT' => [65, 66]],
            ['MS' => [67]],
            ['MG' => [31, 32, 33, 34, 38]],
            ['PA' => [91, 93, 94]],
            ['PB' => [83]],
            ['PR' => [41, 42, 43, 44, 45, 46]],
            ['PE' => [81, 87]],
            ['PI' => [86, 89]],
            ['RJ' => [21, 22, 24]],
            ['RN' => [84]],
            ['RS' => [51, 53, 54, 55]],
            ['RO' => [69]],
            ['RR' => [95]],
            ['SC' => [47, 48, 49]],
            ['SP' => [11, 12, 13, 14, 15, 16, 17, 18, 19]],
            ['SE' => [79]],
            ['TO' => [63]],
        ];

        foreach ($this->array_lista_uf as $key => $value) {
            foreach ($value as $keyx => $valuex) {
                if (in_array($ddd, $valuex)) {
                    $this->_uf = $keyx;
                    break;
                }
            }
        }
        return $this->_uf;
    }

}
