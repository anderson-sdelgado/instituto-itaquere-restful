<?php

namespace Util;

class RotasUtil
{

    public static function getRotas()
    {
        $urls = self::getUrls();
        $request = [];
        $request['rota'] = ucfirst($urls[0]);
        $request['id'] = $urls[1] ?? null;
        $request['metodo'] = strtolower($_SERVER['REQUEST_METHOD']);
        $request['get'] = $_GET;
        return $request;
    }

    public static function getUrls()
    {
        $uri = str_replace('/' . DIR_PROJETO, '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }

    public static function getMetodo()
    {
        return strtolower($_REQUEST['method']);
    }

}