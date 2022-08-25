<?php

namespace Service;

use Util\ConstantesGenericasUtil;
use Repository\UsuarioRepository;

class UsuariosService
{

    public function get($codigo = null){
        return $codigo ? $this->getOneByKey($codigo) : $this->getAll();
    }

    public function post($dados){
        $retorno = [];
        $this->UsuarioRepository = new UsuarioRepository();
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->UsuarioRepository->insert($dados);
        return $retorno;
    }

    public function put($dados, $codigo){
        $retorno = [];
        $this->UsuarioRepository = new UsuarioRepository();
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->UsuarioRepository->update($dados, $codigo);
        return $retorno;
    }

    public function login($dados){
        $retorno = [];
        $this->UsuarioRepository = new UsuarioRepository();
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->UsuarioRepository->login($dados);
        return $retorno;
    }

    public function delete($codigo){
        $retorno = [];
        $this->UsuarioRepository = new UsuarioRepository();
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->UsuarioRepository->delete($codigo);
        return $retorno;
    }

    private function getAll(){
        $this->UsuarioRepository = new UsuarioRepository();
        $page = null;
        $countpage = null;
        $order = null;
        $filter = null;
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $page = $_GET['page'];
        }
        if(isset($_GET['countpage']) && !empty($_GET['countpage'])){
            $countpage = $_GET['countpage'];
        }
        if(isset($_GET['order']) && !empty($_GET['order'])){
            $order= $_GET['order'];
        }
        if(isset($_GET['filter']) && !empty($_GET['filter'])){
            $filter = $_GET['filter'];
        }
        $retorno[ConstantesGenericasUtil::DATA] = $this->UsuarioRepository->getFilter($page, $countpage, $order, $filter);
        $retorno[ConstantesGenericasUtil::COUNT] = $this->UsuarioRepository->count()[0]['qtde'];
        return $retorno;
    }

    private function getOneByKey($codigo){
        $this->UsuarioRepository = new UsuarioRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->UsuarioRepository->getOneByKey($codigo);
        return $retorno;
    }

}