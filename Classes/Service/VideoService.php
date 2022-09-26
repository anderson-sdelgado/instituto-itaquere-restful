<?php

namespace Service;

use Exception;
use Util\ConstantesGenericasUtil;
use Repository\VideoNoticiaRepository;

class VideoService
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
        $this->VideoNoticiaRepository = new VideoNoticiaRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->VideoNoticiaRepository->getAll();
        return $retorno;
    }

    private function getPorCodNoticia($codigo){
        $retorno = [];
        $this->VideoNoticiaRepository = new VideoNoticiaRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->VideoNoticiaRepository->getPorCodNoticia($codigo);
        return $retorno;
    }

}