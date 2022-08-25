<?php

namespace Service;

use Exception;
use Util\ConstantesGenericasUtil;
use Repository\GaleriaNoticiaRepository;

class GaleriaService
{

    public function get($id = null){
        $retorno = $id ? $this->getPorCodNoticia($id) : $this->getAll();
        if($retorno === null){
            throw new Exception(ConstantesGenericasUtil::MSG_ERRO_GENERICO, 404);
        }
        return $retorno;
    }

    private function getAll(){
        $retorno = [];
        $this->GaleriaNoticiaRepository = new GaleriaNoticiaRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->GaleriaNoticiaRepository->getAll();
        return $retorno;
    }

    private function getPorCodNoticia($codigo){
        $retorno = [];
        $this->GaleriaNoticiaRepository = new GaleriaNoticiaRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->GaleriaNoticiaRepository->getPorCodNoticia($codigo);
        return $retorno;
    }

}