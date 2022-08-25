<?php

include 'bootstrap.php';

use Util\RotasUtil;
use Validator\RequestValidator;
use Util\ConstantesGenericasUtil;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
http_response_code(200);

try{

    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->direcionarRequest();
    $retorno[ConstantesGenericasUtil::STATUS] = ConstantesGenericasUtil::TIPO_SUCESSO;
    echo json_encode($retorno);
    exit;
} catch(Exception $e){
    $retorno = [];
    $retorno[ConstantesGenericasUtil::STATUS] = ConstantesGenericasUtil::TIPO_ERRO;
    $retorno[ConstantesGenericasUtil::RESPONSE] = $e->getMessage();
    echo json_encode($retorno);
    exit;
}


