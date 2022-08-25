<?php

namespace Util;

use Exception;

class JsonUtil
{


    public static function tratarCorpoRequisicaoJson()
    {

        try{
            $postJson = json_decode($_REQUEST['data'], true);
        } catch (Exception $exception){
            throw new Exception($exception->getMessage(), 404);
        }
        return $postJson;

    }

    public static function tratarListImage()
    {
        try{
            $postJson = json_decode($_REQUEST['galleryserver'], true);
        } catch (Exception $exception){
            throw new Exception($exception->getMessage(), 404);
        }
        return $postJson;
    }

}