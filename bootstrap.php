<?php

use Util\ConstantesGenericasUtil;

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ERROR);

// define('HOST', 'itaquere.mysql.dbaas.com.br');
// define('BANCO', 'itaquere');

// define('USER', 'itaquere');
// define('SENHA', 'Itaquere2022');

define('HOST', 'localhost');
define('BANCO', 'itaquere');

define('USER', 'root');
define('SENHA', '');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO', 'restful');

define('DIR_IMG', DIR_APP . DS . 'img' . DS);
define('DIR_DOC', DIR_APP . DS . 'doc' . DS);

if(file_exists('autoload.php')){
    include('autoload.php');
} else {
    throw new Exception('Erro ao incluir boostrap', 404);
    exit;
}