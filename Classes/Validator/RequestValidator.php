<?php

namespace Validator;

use Util\JsonUtil;
use Util\RotasUtil;
use Util\ConstantesGenericasUtil;

class RequestValidator{

    private $request;
    private $dadosRequest;

    const GET = 'get';
    const DELETE = 'delete';
    const POST = 'post';

    public function __construct($request)
    {
       $this->request = $request;
    }

    public function direcionarRequest()
    {
        if (strpos($this->request['rota'], '?') !== false) {
            $this->request['rota'] = substr($this->request['rota'], 0, strpos($this->request['rota'], "?"));
        }
        $service = "Service\\". $this->request['rota'] ."Service";
        if ($this->request['metodo'] === self::GET || $this->request['metodo'] === self::DELETE) {
            return call_user_func_array(array(new $service, $this->request['metodo']), array($this->request['id']));
        } else {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
            $this->request['metodo'] = RotasUtil::getMetodo();
            return call_user_func_array(array(new $service, $this->request['metodo']), array($this->dadosRequest, $this->request['id']));
        }
    }

}