<?php

namespace Service;

use Util\ConstantesGenericasUtil;
use Repository\DocumentoRepository;
use Util\FileUtil;

class DocumentoService
{

    public function get($codigo = null){
        return $codigo ? $this->getOneByKey($codigo) : $this->getAll();
    }

    public function post($dados){
        $retorno = [];
        $this->DocumentoRepository = new DocumentoRepository();
        $codLast = $this->DocumentoRepository->codLast();
        $codigo = $codLast[0]['codigo'];
        $documento = FileUtil::updateDocument($codigo);
        $dados['posicao'] = $codigo;
        $dados['documento'] = $documento;
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->DocumentoRepository->insert($dados);
        return $retorno;
    }

    public function put($dados, $codigo){
        $retorno = [];
        $this->DocumentoRepository = new DocumentoRepository();
        $documento = $this->getOneByKey($codigo);
        if(FileUtil::hasDocument()){
            FileUtil::deleteFile($documento['documento']);
            $documento = FileUtil::updateDocument($codigo);
            $dados['documento'] = $documento;
        }
        else{
            unset($dados['documento']);
        }
        unset($dados['secao']);
        unset($dados['posicao']);
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->DocumentoRepository->update($dados, $codigo);
        return $retorno;
    }

    public function down($dados, $codigo){
        $retorno = [];
        $this->DocumentoRepository = new DocumentoRepository();
        $documentos =  $this->DocumentoRepository->getCodSecao($dados["secao"], 'DESC');
        foreach ($documentos as $value) {
            if (intval($value['posicao']) < intval($dados['posicao'])){
                $d = array('posicao' => $value['posicao']);
                $this->DocumentoRepository->update($d, $codigo);
                $d = array('posicao' => $dados['posicao']);
                $this->DocumentoRepository->update($d, $value['codigo']);
                break;
            }
        }
        $retorno[ConstantesGenericasUtil::RESPONSE] = ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        return $retorno;
    }

    public function up($dados, $codigo){
        $retorno = [];
        $this->DocumentoRepository = new DocumentoRepository();
        $documentos =  $this->DocumentoRepository->getCodSecao($dados["secao"], 'ASC');
        foreach ($documentos as $value) {
            if (intval($value['posicao']) > intval($dados['posicao'])){
                $d = array('posicao' => $value['posicao']);
                $this->DocumentoRepository->update($d, $codigo);
                $d = array('posicao' => $dados['posicao']);
                $this->DocumentoRepository->update($d, $value['codigo']);
                break;
            }
        }
        $retorno[ConstantesGenericasUtil::RESPONSE] = ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        return $retorno;
    }

    public function delete($codigo){
        $retorno = [];
        $this->DocumentoRepository = new DocumentoRepository();
        $documento = $this->getOneByKey($codigo);
        FileUtil::deleteFile($documento['documento']);
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->DocumentoRepository->delete($codigo);
        return $retorno;
    }

    private function getAll(){
        $this->DocumentoRepository = new DocumentoRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->DocumentoRepository->getAll();
        return $retorno;
    }

    private function getOneByKey($codigo){
        $this->DocumentoRepository = new DocumentoRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->DocumentoRepository->getOneByKey($codigo);
        return $retorno;
    }

}