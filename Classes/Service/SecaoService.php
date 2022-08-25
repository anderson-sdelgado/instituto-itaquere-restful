<?php

namespace Service;

use Util\ConstantesGenericasUtil;
use Repository\SecaoRepository;

class SecaoService
{

    public function get($codigo = null){
        return $codigo ? $this->getOneByKey($codigo) : $this->getAll();
    }

    public function post($dados){
        $retorno = [];
        $this->SecaoRepository = new SecaoRepository();
        $codLast = $this->SecaoRepository->codLast();
        $codigo = $codLast[0]['codigo'];
        $dados['posicao'] = $codigo;
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->SecaoRepository->insert($dados);
        return $retorno;
    }

    public function put($dados, $codigo){
        $retorno = [];
        $this->SecaoRepository = new SecaoRepository();
        unset($dados['posicao']);
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->SecaoRepository->update($dados, $codigo);
        return $retorno;
    }

    public function down($dados, $codigo){
        $retorno = [];
        $this->SecaoRepository = new SecaoRepository();
        $secoes = $this->SecaoRepository->getCodParente($dados["codparente"], 'DESC');
        foreach ($secoes as $values) {
            if (intval($values['posicao']) < intval($dados['posicao'])){
                $d = array('posicao' => $values['posicao']);
                $this->SecaoRepository->update($d, $codigo);
                $d = array('posicao' => $dados['posicao']);
                $this->SecaoRepository->update($d, $values['codigo']);
                break;
            }
        }
        $retorno[ConstantesGenericasUtil::RESPONSE] = ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        return $retorno;
    }

    public function up($dados, $codigo){
        $retorno = [];
        $this->SecaoRepository = new SecaoRepository();
        $secoes = $this->SecaoRepository->getCodParente($dados["codparente"], 'ASC');
        foreach ($secoes as $values) {
            if (intval($values['posicao']) > intval($dados['posicao'])){
                $d = array('posicao' => $values['posicao']);
                $this->SecaoRepository->update($d, $codigo);
                $d = array('posicao' => $dados['posicao']);
                $this->SecaoRepository->update($d, $values['codigo']);
                break;
            }
        }
        $retorno[ConstantesGenericasUtil::RESPONSE] = ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        return $retorno;
    }

    public function delete($codigo){
        $retorno = [];
        $this->SecaoRepository = new SecaoRepository();
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->SecaoRepository->delete($codigo);
        return $retorno;
    }

    private function getAll(){
        $this->SecaoRepository = new SecaoRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->SecaoRepository->getAll();
        return $retorno;
    }

    private function getOneByKey($codigo){
        $this->SecaoRepository = new SecaoRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->SecaoRepository->getOneByKey($codigo);
        return $retorno;
    }

}