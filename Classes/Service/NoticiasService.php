<?php

namespace Service;

use Util\ConstantesGenericasUtil;
use Repository\NoticiasRepository;
use Repository\GaleriaNoticiaRepository;
use Util\FileUtil;
use Util\JsonUtil;

class NoticiasService
{

    public function get($codigo = null){
        return $codigo ? $this->getOneByKey($codigo) : $this->getAll();
    }

    public function post($dados){
        $retorno = [];
        $this->NoticiasRepository = new NoticiasRepository();
        $this->GaleriaNoticiaRepository = new GaleriaNoticiaRepository();
        $codLast = $this->NoticiasRepository->codLast();
        $codigo = $codLast[0]['codigo'];
        $capa = FileUtil::updateImage($codigo);
        $codLast = $this->GaleriaNoticiaRepository->codLast();
        $codGaleira = $codLast[0]['codigo'];
        $galeria = FileUtil::updateGallery($codigo, $codGaleira);
        foreach ($galeria as $values) {
            $this->GaleriaNoticiaRepository->insert($values);
        }
        $dados['capa'] = $capa;
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->NoticiasRepository->insert($dados);
        return $retorno;
    }

    public function put($dados, $codigo){
        $retorno = [];
        $this->NoticiasRepository = new NoticiasRepository();
        $this->GaleriaNoticiaRepository = new GaleriaNoticiaRepository();
        $noticia = $this->getOneByKey($codigo);
        if(FileUtil::hasImage()){
            FileUtil::deleteFile($noticia['capa']);
            $capa = FileUtil::updateImage($codigo);
            $dados['capa'] = $capa;
        }
        else{
            unset($dados['capa']);
        }
        $galeriaBD = $this->GaleriaNoticiaRepository->getPorCodNoticia($codigo);
        $galeriaRet = JsonUtil::tratarListImage();
        foreach ($galeriaBD as $imgBD) {
            $verif = true;
            foreach ($galeriaRet as $imgRet) {
                if($imgBD['codigo'] === $imgRet['codigo']){
                    $verif = false;
                }
            }
            if($verif){
                FileUtil::deleteFile($imgBD['image']);
                $this->GaleriaNoticiaRepository->delete($imgBD['codigo']);
            }
        }
        $codLast = $this->GaleriaNoticiaRepository->codLast();
        $codGaleira = $codLast[0]['codigo'];
        $galeria = FileUtil::updateGallery($codigo, $codGaleira);
        foreach ($galeria as $values) {
            $this->GaleriaNoticiaRepository->insert($values);
        }
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->NoticiasRepository->update($dados, $codigo);
        return $retorno;
    }

    public function status($dados, $codigo){
        $retorno = [];
        $this->NoticiasRepository = new NoticiasRepository();
        unset($dados['conteudo']);
        unset($dados['titulo']);
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->NoticiasRepository->update($dados, $codigo);
        return $retorno;
    }

    public function delete($codigo){
        $retorno = [];
        $this->NoticiasRepository = new NoticiasRepository();
        $this->GaleriaNoticiaRepository = new GaleriaNoticiaRepository();
        $galeria = $this->GaleriaNoticiaRepository->getPorCodNoticia($codigo);
        foreach ($galeria as $values) {
            FileUtil::deleteFile($values['image']);
            $this->GaleriaNoticiaRepository->delete($values['codigo']);
        }
        $noticia = $this->getOneByKey($codigo);
        FileUtil::deleteFile($noticia['capa']);
        $retorno[ConstantesGenericasUtil::RESPONSE] = $this->NoticiasRepository->delete($codigo);
        return $retorno;
    }

    private function getAll(){
        $this->NoticiasRepository = new NoticiasRepository();
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
        $retorno[ConstantesGenericasUtil::DATA] = $this->NoticiasRepository->getFilter($page, $countpage, $order, $filter);
        $retorno[ConstantesGenericasUtil::COUNT] = $this->NoticiasRepository->count()[0]['qtde'];
        return $retorno;
    }

    private function getOneByKey($codigo){
        $this->NoticiasRepository = new NoticiasRepository();
        $retorno[ConstantesGenericasUtil::DATA] = $this->NoticiasRepository->getOneByKey($codigo);
        return $retorno;
    }

}